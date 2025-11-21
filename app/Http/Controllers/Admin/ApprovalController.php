<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resolution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    /**
     * Check if current user is captain.
     */
    private function checkCaptain()
    {
        $user = Auth::guard('admin')->user();
        if (!$user || $user->role !== 'captain') {
            return response()->view('admin.officers.access-denied'); // create this view for SweetAlert
        }
        return null;
    }

    /**
     * Display all resolutions for approval.
     */
    public function index()
    {
        if ($response = $this->checkCaptain()) {
            return $response;
        }

        $approvals = Resolution::latest()->get();
        return view('admin.officers.approval', compact('approvals'));
    }

    /**
     * Update the status of a resolution.
     */
    public function updateStatus(Request $request, Resolution $resolution)
    {
        if ($response = $this->checkCaptain()) {
            return $response;
        }

        $request->validate([
            'status' => 'required|in:approved,declined'
        ]);

        $resolution->status = $request->status;
        $resolution->save();

        return response()->json([
            'message' => "Resolution status updated to {$request->status}."
        ]);
    }
}
