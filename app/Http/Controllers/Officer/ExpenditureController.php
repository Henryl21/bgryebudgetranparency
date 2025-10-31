<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenditureController extends Controller
{
    public function store(Request $request)
    {
         // ✅ Validate input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|in:Infrastructure,Education,Healthcare,Public Safety,Utilities,Other',
            'amount' => 'required|numeric|min:0',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'resolution' => 'nullable|file|mimes:pdf,doc,docx|max:4096',
        ]);

        // ✅ Handle file uploads
        $receiptPath = null;
        $resolutionPath = null;

        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('receipts', 'public');
        }

        if ($request->hasFile('resolution')) {
            $resolutionPath = $request->file('resolution')->store('resolutions', 'public');
        }

        // ✅ Create the expenditure record
        Expenditure::create([
            'officer_id' => Auth::guard('officer')->id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'category' => $validated['category'],
            'amount' => $validated['amount'],
            'receipt' => $receiptPath,
            'resolution' => $resolutionPath,
            'status' => 'pending',
        ]);

        // ✅ Redirect back with success message
        return redirect()->back()->with('success', 'Expenditure request submitted successfully!');

    }
}
