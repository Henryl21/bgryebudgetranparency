<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        // ✅ Handle profile photo upload (directly in /public/profile_photos)
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('profile_photos');

            // Create folder if not exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Delete old photo if exists
            if ($user->profile_photo && file_exists($destinationPath . '/' . $user->profile_photo)) {
                unlink($destinationPath . '/' . $user->profile_photo);
            }

            // Move new file
            $file->move($destinationPath, $filename);

            // Save filename in DB
            $user->profile_photo = $filename;
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
        $photoPath = public_path('profile_photos/' . $user->profile_photo);

        // ✅ Delete profile photo if exists
        if ($user->profile_photo && file_exists($photoPath)) {
            unlink($photoPath);
        }

        Auth::guard('user')->logout();
        $user->delete();

        return redirect()->route('user.login')
                         ->with('success', '🗑️ Your account has been deleted successfully.');
    }
}
