<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * Check if current user is admin.
     * Returns a response if not, otherwise null.
     */
    private function checkAdmin()
    {
        $user = Auth::guard('admin')->user();
        if (!$user || $user->role !== 'admin') {
            return response()->view('admin.announcements.access-denied'); // create this view for SweetAlert
        }
        return null;
    }

    /**
     * Display a listing of the announcements.
     */
    public function index()
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        // Only show announcements from the logged-in admin's barangay
        $announcements = Announcement::where('barangay_role', auth('admin')->user()->barangay_role)
                                     ->latest()
                                     ->get();

        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new announcement.
     */
    public function create()
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        return view('admin.announcements.create');
    }

    /**
     * Store a newly created announcement in storage.
     */
    public function store(Request $request)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Announcement::create([
            'title'         => $request->title,
            'content'       => $request->content,
            'barangay_role' => auth('admin')->user()->barangay_role,
            'published_at'  => now(),
        ]);

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement created successfully.');
    }

    /**
     * Show the form for editing the specified announcement.
     */
    public function edit($id)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $announcement = Announcement::findOrFail($id);

        if ($announcement->barangay_role !== auth('admin')->user()->barangay_role) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified announcement in storage.
     */
    public function update(Request $request, $id)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $announcement = Announcement::findOrFail($id);

        if ($announcement->barangay_role !== auth('admin')->user()->barangay_role) {
            abort(403, 'Unauthorized action.');
        }

        $announcement->update([
            'title'   => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement updated successfully.');
    }

    /**
     * Remove the specified announcement from storage.
     */
    public function destroy($id)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $announcement = Announcement::findOrFail($id);

        if ($announcement->barangay_role !== auth('admin')->user()->barangay_role) {
            abort(403, 'Unauthorized action.');
        }

        $announcement->delete();

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement deleted successfully.');
    }
}
