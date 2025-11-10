<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Officer;
use App\Models\OfficerUser;
use App\Models\OfficerRequest;
use App\Models\Expenditure;
use Illuminate\Http\Request;

class OfficerApprovalController extends Controller
{
    /**
     * Display all pending officers for approval.
     */
    public function index()
    {
        $officers = Officer::latest()->get();

        // Get barangay name of logged-in admin
        $auth_barangay_user = strtolower(auth()->user()->barangay_role);

        // Get all officer users under the same barangay
        $officer_user_ids = OfficerUser::whereRaw('LOWER(barangay) = ?', [$auth_barangay_user])
            ->pluck('id');

        // Fetch all budget requests for the same barangay officers
        $budget_request = OfficerRequest::whereIn('officer_user_id', $officer_user_ids)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.officers.approval', compact('officers', 'budget_request'));
    }

    /**
     * Approve the officer request.
     * Also auto-inserts into the expenditures table.
     */
    public function approve($id)
    {
        $officer = Officer::findOrFail($id);

        // Update officer status
        $officer->status = 'approved';
        $officer->decline_reason = null;
        $officer->save();

        // Auto-insert into expenditures table
        Expenditure::create([
            'title'       => $officer->title ?? $officer->name,
            'category'    => $officer->category ?? 'Uncategorized',
            'amount'      => $officer->amount ?? 0,
            'date'        => now(),
            'description' => "Auto-generated from Officer Approval (ID: {$officer->id})",
            'receipt'     => $officer->receipt ?? null,
            'status'      => 'approved',
            'barangay'    => $officer->barangay ?? auth()->user()->barangay_role,
        ]);

        return back()->with('success', 'Officer approved and expenditure recorded successfully.');
    }

    /**
     * Approve a budget request and auto-insert to expenditures.
     */
    public function approveBudgetRequest(Request $request, $id)
    {
        $officer = OfficerRequest::findOrFail($id);

        // Update officer request status
        $officer->status = 'approved';
        $officer->decline_reason = null;
        $officer->save();

        // Auto-insert to expenditures table
        Expenditure::create([
            'title'       => $officer->title ?? $officer->name,
            'category'    => $officer->category ?? 'Other',
            'barangay'    => strtolower($officer->barangay ?? auth()->user()->barangay_role),
            'amount'      => $officer->amount ?? 0,
            'date'        => now(),
            'description' => $officer->description ?? 'Budget request approved.',
            'receipt'     => $officer->receipt ?? null,
            'status'      => 'approved',
        ]);

        return back()->with('success', 'Budget request approved and expenditure recorded successfully.');
    }

    /**
     * Decline the officer request with reason.
     */
    public function decline(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $officer = Officer::findOrFail($id);
        $officer->status = 'declined';
        $officer->decline_reason = $request->input('reason');
        $officer->save();

        return back()->with('error', 'Officer request declined with reason.');
    }

    /**
     * Decline a budget request with reason.
     */
    public function declineBudgetRequest(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $officer = OfficerRequest::findOrFail($id);
        $officer->status = 'declined';
        $officer->decline_reason = $request->input('reason');
        $officer->save();

        return back()->with('success', 'Budget request declined with reason.');
    }

    /**
     * Show details of a specific officer.
     */
    public function show($id)
    {
        $officer = Officer::findOrFail($id);
        return view('admin.officers.show', compact('officer'));
    }

    /**
     * Delete an officer record (if needed).
     */
    public function destroy($id)
    {
        $officer = Officer::findOrFail($id);
        $officer->delete();

        return back()->with('success', 'Officer record deleted successfully.');
    }
}
