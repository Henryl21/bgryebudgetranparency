<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Expenditure;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

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

        // Budgets for this barangay
        $budgets = Budget::where('barangay_role', $barangayRole)->latest()->get();

        // Unique years
        $budgetYears = Budget::where('barangay_role', $barangayRole)
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Chart data
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

    // Search announcements
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

    // Download Database
    public function downloadDatabase()
    {
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbName = env('DB_DATABASE', 'barangar');
        $dbUser = env('DB_USERNAME', 'root');
        $dbPass = env('DB_PASSWORD', '');

        $backupPath = storage_path('app/backups/');
        if (!file_exists($backupPath)) mkdir($backupPath, 0755, true);

        $fileName = 'database_backup_' . date('Y_m_d_His') . '.sql';
        $filePath = $backupPath . $fileName;

        $mysqldumpPath = "D:\\xampp\\mysql\\bin\\mysqldump.exe";
        $command = "\"{$mysqldumpPath}\" --user=\"{$dbUser}\" --password=\"{$dbPass}\" --host=\"{$dbHost}\" {$dbName} > \"{$filePath}\"";

        \exec($command, $output, $returnVar);

        if ($returnVar !== 0 || !file_exists($filePath)) {
            return back()->with('error', 'mysqldump command failed. Please check the path and credentials.');
        }

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    // Show Database Page
    public function showDatabasePage()
    {
        $currentAdmin = Auth::guard('admin')->user();
        $barangayName = $currentAdmin->barangay_name ?? ucfirst($currentAdmin->barangay_role);

        return view('admin.database', compact('barangayName'));
    }

    // Logout admin and redirect to welcome
    public function logout()
    {
        Auth::guard('admin')->logout();       // Logout admin
        session()->invalidate();               // Clear session
        session()->regenerateToken();          // Regenerate CSRF token
        return redirect()->route('welcome');  // Redirect to welcome.blade.php
    }
}
