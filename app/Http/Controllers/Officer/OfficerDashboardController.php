<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\OfficerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OfficerDashboardController extends Controller
{
    public function index()
    {
        $expenditures = OfficerRequest::where('officer_user_id', Auth::guard('officer')->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('officer.dashboard', compact('expenditures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category'    => 'nullable|string',
            'amount'      => 'required|numeric|min:0',
            'receipt'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'resolution'  => 'nullable|file|mimes:doc,docx,pdf|max:5120',
        ]);

        $receiptPath = $request->file('receipt')?->store('receipts', 'public');
        $resolutionPath = $request->file('resolution')?->store('resolutions', 'public');

        OfficerRequest::create([
            'officer_user_id' => Auth::guard('officer')->id(),
            'title'           => $request->title,
            'description'     => $request->description,
            'category'        => $request->category,
            'amount'          => $request->amount,
            'receipt'         => $receiptPath,
            'resolution'      => $resolutionPath,
            'status'          => 'pending',
        ]);

        return redirect()->route('officer.dashboard')
            ->with('success', 'Expenditure request submitted successfully!');
    }

    // ✅ EDIT — show edit form
    public function edit($id)
    {
        $expenditure = OfficerRequest::where('officer_user_id', Auth::guard('officer')->id())
            ->findOrFail($id);

        return view('officer.expenditures.edit', compact('expenditure'));
    }

    // ✅ UPDATE — save changes
    public function update(Request $request, $id)
    {
        $expenditure = OfficerRequest::where('officer_user_id', Auth::guard('officer')->id())
            ->findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category'    => 'nullable|string',
            'amount'      => 'required|numeric|min:0',
            'receipt'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'resolution'  => 'nullable|file|mimes:doc,docx,pdf|max:5120',
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
            'title'       => $request->title,
            'description' => $request->description,
            'category'    => $request->category,
            'amount'      => $request->amount,
        ]);

        return redirect()->route('officer.dashboard')
            ->with('success', 'Expenditure request updated successfully!');
    }

    // ✅ DELETE — remove an expenditure
    public function destroy($id)
    {
        $expenditure = OfficerRequest::where('officer_user_id', Auth::guard('officer')->id())
            ->findOrFail($id);

        if ($expenditure->receipt) {
            Storage::disk('public')->delete($expenditure->receipt);
        }
        if ($expenditure->resolution) {
            Storage::disk('public')->delete($expenditure->resolution);
        }

        $expenditure->delete();

        return redirect()->route('officer.dashboard')
            ->with('success', 'Expenditure request deleted successfully!');
    }
}
