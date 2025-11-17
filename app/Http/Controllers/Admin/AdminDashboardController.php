<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Expenditure;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    // Dashboard
    public function index(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();
        $barangayRole = $currentAdmin->barangay_role;

        // Totals (income)
        $totalBudget = Budget::where('barangay_role', $barangayRole)
            ->where('type', 'income')
            ->sum('amount');

        // Expenditures
        $expenditures = Expenditure::whereRaw('LOWER(barangay) = ?', [$barangayRole])->get();
        $totalSpent = $expenditures->sum('amount');
        $totalRemaining = $totalBudget - $totalSpent;

        // Budgets
        $budgets = Budget::where('barangay_role', $barangayRole)->latest()->get();

        // Years
        $budgetYears = Budget::where('barangay_role', $barangayRole)
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Chart Data
        $budgetChart = ['labels' => [], 'data' => []];
        if ($expenditures->isNotEmpty()) {
            $grouped = $expenditures->groupBy('category');
            $budgetChart['labels'] = $grouped->keys()->toArray();
            $budgetChart['data'] = $grouped->map(fn($item) => $item->sum('amount'))->values()->toArray();
        }

        // Announcements
        $query = Announcement::where('barangay_role', $barangayRole);

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('content', 'LIKE', "%{$searchTerm}%");
            });
        }

        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $announcements = $query->orderBy('created_at', 'desc')->get();

        $barangayName = $currentAdmin->barangay_name ?? ucfirst($barangayRole);

        return view('admin.dashboard', compact(
            'totalBudget',
            'totalSpent',
            'totalRemaining',
            'budgets',
            'budgetChart',
            'budgetYears',
            'expenditures',
            'announcements',
            'barangayName',
            'barangayRole'
        ));
    }

    // AJAX announcement search
    public function searchAnnouncements(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();
        $barangayRole = $currentAdmin->barangay_role;
        $searchTerm = $request->get('search', '');

        $announcements = Announcement::where('barangay_role', $barangayRole)
            ->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('content', 'LIKE', "%{$searchTerm}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'announcements' => $announcements,
                'count' => $announcements->count()
            ]);
        }

        return redirect()->route('admin.dashboard', ['search' => $searchTerm]);
    }

    // SAFE Database Backup (NO exec(), works online)
    public function downloadDatabase()
    {
        $dbName = env('DB_DATABASE');

        // Fetch all tables
        $tables = DB::select("SHOW TABLES");

        $sqlDump = "-- Laravel MySQL Backup\n-- " . date('Y-m-d H:i:s') . "\n\n";

        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];

            // CREATE TABLE
            $create = DB::select("SHOW CREATE TABLE `$tableName`")[0]->{'Create Table'};
            $sqlDump .= "DROP TABLE IF EXISTS `$tableName`;\n";
            $sqlDump .= $create . ";\n\n";

            // INSERT DATA
            $rows = DB::table($tableName)->get();

            foreach ($rows as $row) {
                $values = array_map(function ($value) {
                    return $value === null ? "NULL" : "'" . addslashes($value) . "'";
                }, (array)$row);

                $sqlDump .= "INSERT INTO `$tableName` VALUES(" . implode(",", $values) . ");\n";
            }

            $sqlDump .= "\n";
        }

        // Filename
        $backupName = "backup_" . date('Y-m-d_H-i-s') . ".sql";

        return response($sqlDump)
            ->header("Content-Type", "application/sql")
            ->header("Content-Disposition", "attachment; filename=$backupName");
    }

    // Show DB Management Page
    public function showDatabasePage()
    {
        $currentAdmin = Auth::guard('admin')->user();
        $barangayName = $currentAdmin->barangay_name ?? ucfirst($currentAdmin->barangay_role);

        return view('admin.database', compact('barangayName'));
    }

    // Logout admin
    public function logout()
    {
        Auth::guard('admin')->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('welcome');
    }
}
