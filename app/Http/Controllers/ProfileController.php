<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show user profile.
     */
    public function show()
    {
        $user = Auth::guard('user')->user();
        return view('user.profile.show', compact('user'));
    }

    /**
     * Show edit form.
     */
    public function edit()
    {
        $user = Auth::guard('user')->user();
        return view('user.profile.edit', compact('user'));
    }

    /**
     * Update user profile.
     */
    public function update(Request $request)
    {
        $user = Auth::guard('user')->user();

        // ✅ Validate inputs
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'number' => 'nullable|string|max:20',
            'barangay_role' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // ✅ Update basic info
        $user->full_name = $validated['full_name'];
        $user->email = $validated['email'];
        $user->number = $validated['number'] ?? $user->number;
        $user->barangay_role = $validated['barangay_role'] ?? $user->barangay_role;

        // ✅ Handle profile photo upload
        if ($request->hasFile('profile_photo')) {

            // Delete old photo if exists
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Save new uploaded image correctly
            $path = $request->file('profile_photo')->store('profile_photos', 'public');

            // Store path like: profile_photos/xxxx.jpg
            $user->profile_photo = $path;
        }


        // ✅ Handle password update
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('user.profile.show')
            ->with('success', '✅ Profile updated successfully!');
    }

    /**
     * Delete account.
     */
    public function destroy()
    {
        $user = Auth::guard('user')->user();

        // ✅ Delete profile photo if exists
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        Auth::guard('user')->logout();
        $user->delete();

        return redirect()->route('user.login')
            ->with('success', '🗑️ Your account has been deleted successfully.');
    }
}
