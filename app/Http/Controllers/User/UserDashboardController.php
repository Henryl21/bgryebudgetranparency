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
        // ✅ Get current logged-in user
        $user = Auth::guard('user')->user();
        $barangayRole = $user->barangay_role;

        // 💰 Total income for the user's barangay
        $totalBudget = Budget::where('barangay_role', $barangayRole)
            ->where('type', 'income')
            ->sum('amount');

        // 💸 Expenditures
        $expenditures = Expenditure::whereRaw('LOWER(barangay) = ?', [strtolower($barangayRole)])->get();

        // 🧮 Compute totals
        $totalSpent = $expenditures->sum('amount');
        $totalRemaining = $totalBudget - $totalSpent;

        // 📅 All budgets
        $budgets = Budget::where('barangay_role', $barangayRole)->latest()->get();

        // 📊 Expenditure category chart
        $budgetChart = [
            'labels' => [],
            'data' => [],
        ];

        if ($expenditures->isNotEmpty()) {
            $grouped = $expenditures->groupBy('category');
            $budgetChart['labels'] = $grouped->keys()->toArray();
            $budgetChart['data'] = $grouped->map(fn($item) => $item->sum('amount'))->values()->toArray();
        }

        // 📅 Budget years
        $budgetYears = Budget::where('barangay_role', $barangayRole)
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // 📢 Announcements
        $announcements = Announcement::where('barangay_role', $barangayRole)->latest()->get();

        // ✅ Pass $user to the view to fix the undefined variable
        return view('user.dashboard', compact(
            'user',
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
     * 🚪 Logout user and redirect to login
     */
    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'You have been logged out successfully.');
    }
}
