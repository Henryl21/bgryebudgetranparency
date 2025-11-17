<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Validate fields
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'profile_photo_base64' => [
                'nullable',
                'regex:/^data:image\/(jpg|jpeg|png);base64,/',
            ],
        ]);

        // Update basic info
        $admin->name = $request->name;
        $admin->email = $request->email;

        // Folder inside public/
        $folder = public_path('admin_profiles');

        // Create folder if it does not exist
        if (!file_exists($folder)) {
            mkdir($folder, 0775, true);
        }

        // Handle Base64 Upload
        if ($request->profile_photo_base64) {

            // Remove old photo
            if ($admin->profile_photo && file_exists(public_path($admin->profile_photo))) {
                unlink(public_path($admin->profile_photo));
            }

            $base64 = $request->profile_photo_base64;

            preg_match('/data:image\/(.*?);base64/', $base64, $match);
            $ext = $match[1];

            $image = base64_decode(
                preg_replace('/^data:image\/\w+;base64,/', '', $base64)
            );

            $filename = uniqid() . '.' . $ext;

            file_put_contents($folder . '/' . $filename, $image);

            $admin->profile_photo = 'admin_profiles/' . $filename;
        }

        // Handle Normal File Upload
        elseif ($request->hasFile('profile_photo')) {

            // Remove old photo
            if ($admin->profile_photo && file_exists(public_path($admin->profile_photo))) {
                unlink(public_path($admin->profile_photo));
            }

            $file = $request->file('profile_photo');
            $filename = uniqid() . '.' . $file->extension();
            $file->move($folder, $filename);

            $admin->profile_photo = 'admin_profiles/' . $filename;
        }

        // Save admin data
        $admin->save();

        return redirect()
            ->route('admin.profile.show')
            ->with('success', 'Profile updated successfully.');
    }
}
