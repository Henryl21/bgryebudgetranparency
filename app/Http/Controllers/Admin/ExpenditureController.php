<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Expenditure;
use Illuminate\Support\Facades\Cache;

class ExpenditureController extends Controller
{
    public function index()
    {
        $auth_user_barangay = auth()->user()->barangay_role;

        $expenditures = Expenditure::whereRaw('LOWER(barangay) = ?', [$auth_user_barangay])
            ->get();

        $totalSpent = $expenditures->sum('amount');

        return view('admin.expenditure.index', compact('expenditures', 'totalSpent'));
    }

    public function create()
    {
        return view('admin.expenditure.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0.01',
            'date'        => 'nullable|date',
            'category'    => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'receipt'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $data['type'] = 'expense';

        // Get current total budget and total spent
        $totalBudget = Budget::sum('amount'); // total budget
        $totalSpent = Expenditure::sum('amount');

        // Check if adding this expenditure exceeds budget
        if (($totalSpent + $data['amount']) > $totalBudget) {
            return redirect()->back()->with('error', 'Cannot add expenditure. Total budget is not enough.');
        }

        // Handle receipt file
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $data['receipt'] = base64_encode(file_get_contents($file->getRealPath()));
            $data['receipt_type'] = $file->getClientMimeType();
        }

        Expenditure::create($data);

        Cache::forget('dashboard_totals');
        Cache::forget('expenditure_totals');

        return redirect()->route('admin.expenditure.index')
                         ->with('success', 'Expenditure recorded successfully!');
    }

    public function edit($id)
    {
        $expenditure = Expenditure::findOrFail($id);
        return view('admin.expenditure.edit', compact('expenditure'));
    }

    public function update(Request $request, $id)
    {
        $expenditure = Expenditure::findOrFail($id);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0.01',
            'date'        => 'nullable|date',
            'category'    => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'receipt'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'remove_image'=> 'nullable|in:0,1'
        ]);

        // Calculate remaining budget if updating amount
        $totalBudget = Budget::sum('amount');
        $totalSpent = Expenditure::sum('amount') - $expenditure->amount; // subtract old amount

        if (($totalSpent + $data['amount']) > $totalBudget) {
            return redirect()->back()->with('error', 'Cannot update expenditure. Total budget is not enough.');
        }

        // Remove old base64 receipt
        if ($request->remove_image == '1') {
            $data['receipt'] = null;
            $data['receipt_type'] = null;
        }

        // Upload new receipt
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $data['receipt'] = base64_encode(file_get_contents($file->getRealPath()));
            $data['receipt_type'] = $file->getClientMimeType();
        }

        $expenditure->update($data);

        Cache::forget('dashboard_totals');
        Cache::forget('expenditure_totals');

        return redirect()->route('admin.expenditure.index')
                         ->with('success', 'Expenditure updated successfully!');
    }

    public function destroy($id)
    {
        $expenditure = Expenditure::findOrFail($id);

        $expenditure->delete();

        Cache::forget('dashboard_totals');
        Cache::forget('expenditure_totals');

        return redirect()->route('admin.expenditure.index')
                         ->with('success', 'Expenditure deleted successfully.');
    }
}
