<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Officer;
use App\Models\OfficerUser;
use App\Models\OfficerRequest;
use App\Models\Expenditure;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfficerApprovalController extends Controller
{
    /**
     * Check if current user is captain.
     * Returns a response if not, otherwise null.
     */
    private function checkCaptain()
    {
        $user = Auth::guard('admin')->user();
        if (!$user || $user->role !== 'captain') {
            return response()->view('admin.officers.access-denied'); // create this view for access denied
        }
        return null;
    }

    /**
     * Display all pending officers for approval.
     */
    public function index()
    {
        if ($response = $this->checkCaptain()) {
            return $response;
        }

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
     * Approve the officer request and auto-insert into expenditures.
     */
    public function approve($id)
    {
        if ($response = $this->checkCaptain()) {
            return $response;
        }

        $officer = Officer::findOrFail($id);

        // Check if total budget is enough
        $totalBudget = Budget::sum('amount');
        $totalSpent = Expenditure::sum('amount');

        if (($totalSpent + ($officer->amount ?? 0)) > $totalBudget) {
            return back()->with('error', 'Cannot approve officer. Total budget is not enough.');
        }

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
        if ($response = $this->checkCaptain()) {
            return $response;
        }

        $officerRequest = OfficerRequest::findOrFail($id);

        // Check if total budget is enough
        $totalBudget = Budget::sum('amount');
        $totalSpent = Expenditure::sum('amount');

        if (($totalSpent + ($officerRequest->amount ?? 0)) > $totalBudget) {
            return back()->with('error', 'Cannot approve budget request. Total budget is not enough.');
        }

        $officerRequest->status = 'approved';
        $officerRequest->decline_reason = null;
        $officerRequest->save();

        Expenditure::create([
            'title'       => $officerRequest->title ?? $officerRequest->name,
            'category'    => $officerRequest->category ?? 'Other',
            'barangay'    => strtolower($officerRequest->barangay ?? auth()->user()->barangay_role),
            'amount'      => $officerRequest->amount ?? 0,
            'date'        => now(),
            'description' => $officerRequest->description ?? 'Budget request approved.',
            'receipt'     => $officerRequest->receipt ?? null,
            'status'      => 'approved',
        ]);

        return back()->with('success', 'Budget request approved and expenditure recorded successfully.');
    }

    /**
     * Decline the officer request with reason.
     */
    public function decline(Request $request, $id)
    {
        if ($response = $this->checkCaptain()) {
            return $response;
        }

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
        if ($response = $this->checkCaptain()) {
            return $response;
        }

        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $officerRequest = OfficerRequest::findOrFail($id);
        $officerRequest->status = 'declined';
        $officerRequest->decline_reason = $request->input('reason');
        $officerRequest->save();

        return back()->with('success', 'Budget request declined with reason.');
    }

    /**
     * Show details of a specific officer.
     */
    public function show($id)
    {
        if ($response = $this->checkCaptain()) {
            return $response;
        }

        $officer = Officer::findOrFail($id);
        return view('admin.officers.show', compact('officer'));
    }

    /**
     * Delete an officer record (if needed).
     */
    public function destroy($id)
    {
        if ($response = $this->checkCaptain()) {
            return $response;
        }

        $officer = Officer::findOrFail($id);
        $officer->delete();

        return back()->with('success', 'Officer record deleted successfully.');
    }
}
