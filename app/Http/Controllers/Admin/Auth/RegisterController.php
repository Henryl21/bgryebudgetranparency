<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        $barangays = Admin::getBarangays();
        return view('admin.auth.register', compact('barangays'));
    }

    public function register(Request $request)
    {
        $barangayKeys = array_keys(Admin::getBarangays());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
            ],
            'barangay_role' => ['required', Rule::in($barangayKeys)],
            'role' => ['required', Rule::in(['admin', 'treasurer', 'captain'])],
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'profile_photo_base64' => [
                'nullable',
                'regex:/^data:image\/(jpg|jpeg|png|gif);base64,/',
            ],
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one symbol (@$!%*?&).',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'barangay_role.required' => 'Please select a barangay role.',
            'barangay_role.in' => 'Please select a valid barangay from the list.',
        ]);

        // Ensure this barangay doesn't already have the same role
        $existingAdmin = Admin::where('barangay_role', $request->barangay_role)
                              ->where('role', $request->role)
                              ->first();
        if ($existingAdmin) {
            return back()->withErrors([
                'barangay_role' => 'This barangay already has an assigned ' . $request->role . '. Please choose a different role or barangay.'
            ])->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | HANDLE PHOTO (FILE OR BASE64)
        |--------------------------------------------------------------------------
        */
        $profilePhotoPath = null;

        // Handle Base64 upload
        if ($request->profile_photo_base64) {
            $base64 = $request->profile_photo_base64;

            // Extract extension
            preg_match('/data:image\/(.*?);base64/', $base64, $match);
            $extension = $match[1];

            // Strip the header
            $imageData = base64_decode(
                preg_replace('/^data:image\/\w+;base64,/', '', $base64)
            );

            // Create unique file
            $filename = 'admin_profiles/' . uniqid() . '.' . $extension;

            // Store in storage/app/public/admin_profiles
            Storage::disk('public')->put($filename, $imageData);

            $profilePhotoPath = $filename;
        }
        // Handle normal file upload
        elseif ($request->hasFile('profile_photo')) {
            $profilePhotoPath = 
                $request->file('profile_photo')->store('admin_profiles', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE NEW ADMIN
        |--------------------------------------------------------------------------
        */
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'barangay_role' => $request->barangay_role,
            'role' => $request->role,
            'profile_photo' => $profilePhotoPath,
        ]);

        // Auto login new admin
        Auth::guard('admin')->login($admin);

        return redirect()->route('admin.dashboard')->with('success',
            'Registration successful! Welcome, ' . $admin->name .
            '. You are now the ' . $admin->role . ' for ' . $admin->barangay_name . ' Barangay.'
        );
    }
}
