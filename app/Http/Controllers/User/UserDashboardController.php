<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Expenditure;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        // ✅ Get current user's barangay
        $currentUser = Auth::guard('user')->user();
        $barangayRole = $currentUser->barangay_role; // must exist in users table

        // 💰 Totals (filtered by barangay)
        $totalBudget = Budget::where('barangay_role', $barangayRole)
            ->where('type', 'income')
            ->sum('amount'); 

        $expenditures = Expenditure::whereRaw('LOWER(barangay) = ?', [$barangayRole])
            ->get();

        // Calculate total spent
        $totalSpent = $expenditures->sum('amount');

        $totalRemaining = $totalBudget - $totalSpent;

        // 📦 Budgets
        $budgets = Budget::where('barangay_role', $barangayRole)
            ->latest()
            ->get();

        // 💸 Expenditures
        $expenditures = Budget::where('barangay_role', $barangayRole)
            ->where('type', 'expense')
            ->get();

        // 📅 Years for filtering
        $budgetYears = Budget::where('barangay_role', $barangayRole)
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // 📊 Chart
        $budgetChart = [
            'labels' => [],
            'data' => [],
        ];

        if ($expenditures->isNotEmpty()) {
            $grouped = $expenditures->groupBy('category');
            $budgetChart['labels'] = $grouped->keys()->toArray();
            $budgetChart['data'] = $grouped->map(fn($item) => $item->sum('amount'))
                                          ->values()
                                          ->toArray();
        }

        // 📢 Announcements
        $announcements = Announcement::where('barangay_role', $barangayRole)
            ->latest()
            ->get();

        return view('user.dashboard', compact(
            'totalBudget',
            'totalSpent',
            'totalRemaining',
            'budgets',
            'budgetChart',
            'budgetYears',
            'expenditures',
            'announcements',
            'barangayRole'
        ));
    }

    /**
     * 🚪 Logout user and redirect to user login page
     */
    public function logout(Request $request)
    {
        Auth::guard('user')->logout(); // Logs out from 'user' guard

        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to user login route
        return redirect()->route('user.login')->with('success', 'You have been logged out successfully.');
    }
}
