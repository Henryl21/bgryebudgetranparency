<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\OfficerUser;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class OfficerAuthController extends Controller
{
    /**
     * Show the login page.
     */
    public function showLogin()
    {
        // ✅ Fetch all barangays (for login form dropdown)
        $barangays = Admin::getBarangays();

        return view('officer.auth.login', compact('barangays'));
    }

    /**
     * Show the register page.
     */
    public function showRegister()
    {
        // ✅ Fetch all barangays (for registration form)
        $barangays = Admin::getBarangays();

        return view('officer.auth.register', compact('barangays'));
    }

    /**
     * Handle officer login (3-attempt limit + countdown + secure sessions)
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
            'role'     => 'required|string',
            'barangay' => 'required|string',
        ]);

        $email = strtolower($request->email);
        $ip = $request->ip();
        $key = Str::lower("officer-login:{$email}|{$ip}");

        // ✅ Check if user is locked out
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Too many failed attempts. Please try again in {$seconds} seconds.");
        }

        // ✅ Find officer by email, role, and barangay
        $officer = OfficerUser::where('email', $email)
            ->where('role', $request->role)
            ->where('barangay', $request->barangay)
            ->first();

        // ✅ Validate password
        if ($officer && Hash::check($request->password, $officer->password)) {
            // Clear login attempts
            RateLimiter::clear($key);

            // Login securely
            Auth::guard('officer')->login($officer, $request->boolean('remember'));
            $request->session()->regenerate();

            // Update last login timestamp
            $officer->update(['last_login_at' => now()]);

            return redirect()->intended(route('officer.dashboard'))
                ->with('success', 'Welcome back, ' . $officer->name . '!');
        }

        // ❌ Failed login — increment attempts
        RateLimiter::hit($key, 60);

        return back()->with('error', 'Invalid email, password, role, or barangay. Please try again.');
    }

    /**
     * Handle officer logout with full session termination
     */
    public function logout(Request $request)
    {
        Auth::guard('officer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('officer.login')
            ->with('info', 'You have been logged out securely.');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:officer_users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',      // at least one uppercase
                'regex:/[a-z]/',      // at least one lowercase
                'regex:/[0-9]/',      // at least one number
                'regex:/[@$!%*?&]/',  // at least one special character
                'confirmed',          // must match password_confirmation
            ],
            'role'     => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
        ], [
            'password.min' => 'Password must be at least 8 characters long.',
            'password.regex' => 'Password must include uppercase, lowercase, number, and special character.',
        ]);

        // ✅ Create new officer account
        OfficerUser::create([
            'name'     => $request->name,
            'email'    => strtolower($request->email),
            'password' => Hash::make($request->password), // 🔒 bcrypt
            'role'     => $request->role,
            'barangay' => $request->barangay,
        ]);

        // ✅ Redirect to login with success alert
        return redirect()->route('officer.login')
            ->with('success', 'Registration successful! Please log in with your new account.');
    }
}
