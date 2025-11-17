<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    public function show()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile.show', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,

            // Normal image upload
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            // Base64 validation
            'profile_photo_base64' => [
                'nullable',
                'regex:/^data:image\/(jpg|jpeg|png);base64,/',
            ],
        ]);

        // Update basic fields
        $admin->name = $request->name;
        $admin->email = $request->email;

        // Delete old photo if exists
        if ($admin->profile_photo && Storage::disk('public')->exists($admin->profile_photo)) {
            Storage::disk('public')->delete($admin->profile_photo);
        }

        /*
        |--------------------------------------------------------------------------
        | HANDLE BASE64 IMAGE
        |--------------------------------------------------------------------------
        */
        if ($request->profile_photo_base64) {

            $base64 = $request->profile_photo_base64;

            // Extract file extension
            preg_match('/data:image\/(.*?);base64/', $base64, $match);
            $extension = $match[1];

            // Remove header (data:image/png;base64,)
            $imageData = base64_decode(
                preg_replace('/^data:image\/\w+;base64,/', '', $base64)
            );

            // Generate unique filename
            $filename = 'admin_photos/' . uniqid() . '.' . $extension;

            // Save decoded image
            Storage::disk('public')->put($filename, $imageData);

            // Save path to DB
            $admin->profile_photo = $filename;
        }

        /*
        |--------------------------------------------------------------------------
        | HANDLE NORMAL FILE UPLOAD
        |--------------------------------------------------------------------------
        */
        elseif ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('admin_photos', 'public');
            $admin->profile_photo = $path;
        }

        // Save model
        $admin->save();

        return redirect()
            ->route('admin.profile.show')
            ->with('success', 'Profile updated successfully.');
    }
}
