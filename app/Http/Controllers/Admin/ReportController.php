<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\Expenditure;
use App\Models\BarangaySetting;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Show expenditures report (printable view).
     */
    public function printExpenditures()
    {
        // Get only expenditures (type = expense), ordered by latest date
        // $expenditures = Budget::where('type', 'expense')
        //     ->orderBy('date', 'desc')
        //     ->get();
        $auth_user_barangay = auth()->user()->barangay_role;

        $expenditures = Expenditure::whereRaw('LOWER(barangay) = ?', [$auth_user_barangay])
            ->get();

        // Calculate total spent
        $totalSpent = $expenditures->sum('amount');

        // Get barangay info/settings (logo, address, etc.)
        $settings = BarangaySetting::where('barangay_role', auth()->user()->barangay_role)->first();

        // Pass everything to the view
        return view('admin.reports.print', compact('expenditures', 'settings', 'totalSpent'));
    }
}
