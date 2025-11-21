<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;

class OfficerRequestController extends Controller
{
    public function index()
    {
        $expenditures = Budget::where('officer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('officer.dashboard', compact('expenditures'));
    }

    /**
     * Store Officer Expenditure Request (with PUBLIC receipt upload)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:1',
            'category'    => 'required|string|max:255',
            'description' => 'nullable|string',
            'date'        => 'required|date',
            'receipt'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->only([
            'title', 'amount', 'category', 'description', 'date'
        ]);

        // Add officer ID and default status
        $data['officer_id'] = Auth::id();
        $data['status'] = 'pending';

        // ========= PUBLIC RECEIPT UPLOAD =========
        if ($request->hasFile('receipt')) {
            $filename = time() . '_' . $request->file('receipt')->getClientOriginalName();
            $request->file('receipt')->move(public_path('receipts'), $filename);

            // Save path relative to /public
            $data['receipt_path'] = 'receipts/' . $filename;
        }

        Budget::create($data);

        return redirect()->route('officer.dashboard')
            ->with('success', 'Expenditure request submitted successfully!');
    }

    /**
     * Public receipt viewer: /receipt/{id}
     */
    public function publicReceipt($id)
    {
        $budget = Budget::findOrFail($id);

        if (!$budget->receipt_path) {
            abort(404, 'No receipt uploaded.');
        }

        $file = public_path($budget->receipt_path);

        if (!file_exists($file)) {
            abort(404, 'Receipt file not found.');
        }

        return response()->file($file);
    }
}
