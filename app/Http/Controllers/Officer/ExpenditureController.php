<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expenditure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExpenditureController extends Controller
{
    /**
     * Display officer’s expenditures
     */
    public function index()
    {
        $officerId = Auth::guard('officer')->id();
        $expenditures = Expenditure::where('officer_id', $officerId)->latest()->get();

        return view('officer.expenditures.index', compact('expenditures'));
    }

    /**
     * Store a new expenditure request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|in:Infrastructure,Education,Healthcare,Public Safety,Utilities,Other',
            'amount' => 'required|numeric|min:0',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'resolution' => 'nullable|file|mimes:pdf,doc,docx|max:4096',
        ]);

        $receiptPath = $request->hasFile('receipt')
            ? $request->file('receipt')->store('receipts', 'public')
            : null;

        $resolutionPath = $request->hasFile('resolution')
            ? $request->file('resolution')->store('resolutions', 'public')
            : null;

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

        return redirect()->back()->with('success', 'Expenditure request submitted successfully!');
    }

    /**
     * Edit an expenditure
     */
    public function edit($id)
    {
        $officerId = Auth::guard('officer')->id();
        $expenditure = Expenditure::where('officer_id', $officerId)->findOrFail($id);

        return view('officer.expenditures.edit', compact('expenditure'));
    }

    /**
     * Update expenditure
     */
    public function update(Request $request, $id)
    {
        $officerId = Auth::guard('officer')->id();
        $expenditure = Expenditure::where('officer_id', $officerId)->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|in:Infrastructure,Education,Healthcare,Public Safety,Utilities,Other',
            'amount' => 'required|numeric|min:0',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'resolution' => 'nullable|file|mimes:pdf,doc,docx|max:4096',
        ]);

        if ($request->hasFile('receipt')) {
            if ($expenditure->receipt) {
                Storage::disk('public')->delete($expenditure->receipt);
            }
            $expenditure->receipt = $request->file('receipt')->store('receipts', 'public');
        }

        if ($request->hasFile('resolution')) {
            if ($expenditure->resolution) {
                Storage::disk('public')->delete($expenditure->resolution);
            }
            $expenditure->resolution = $request->file('resolution')->store('resolutions', 'public');
        }

        $expenditure->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'category' => $validated['category'],
            'amount' => $validated['amount'],
        ]);

        return redirect()->route('officer.expenditures.index')->with('success', 'Expenditure updated successfully!');
    }

    /**
     * Delete expenditure
     */
    public function destroy($id)
    {
        $officerId = Auth::guard('officer')->id();
        $expenditure = Expenditure::where('officer_id', $officerId)->findOrFail($id);

        if ($expenditure->receipt) {
            Storage::disk('public')->delete($expenditure->receipt);
        }
        if ($expenditure->resolution) {
            Storage::disk('public')->delete($expenditure->resolution);
        }

        $expenditure->delete();

        return redirect()->back()->with('success', 'Expenditure deleted successfully!');
    }
}
