<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\OfficerUser;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OfficerAuthController extends Controller
{
    /**
     * Show the login page
     */
    public function showLogin()
    {
        $barangays = Admin::getBarangays();
        return view('officer.auth.login', compact('barangays'));
    }

    /**
     * Show the register page
     */
    public function showRegister()
    {
        $barangays = Admin::getBarangays();
        return view('officer.auth.register', compact('barangays'));
    }

    /**
     * Send OTP to officer's email
     */
    protected function sendOtp(OfficerUser $officer)
    {
        $otp = rand(100000, 999999); // 6-digit OTP
        $officer->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        Mail::raw("Your OTP is: {$otp}. It expires in 5 minutes.", function ($message) use ($officer) {
            $message->to($officer->email)
                    ->subject('Officer OTP Verification');
        });
    }

    /**
     * Handle officer registration with OTP
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
        'regex:/[A-Z]/',
        'regex:/[a-z]/',
        'regex:/[0-9]/',
        'regex:/[@$!%*?&]/',
        'confirmed',
    ],
    'role'     => 'required|string|max:255',
    'barangay' => 'required|string|max:255',
], [
    'password.min' => 'Password must be at least 8 characters long.',
    'password.regex' => 'Password must include uppercase, lowercase, number, and special character.',
]);

// Check if the role already exists in the selected barangay
$exists = OfficerUser::where('role', $request->role)
    ->where('barangay', $request->barangay)
    ->exists();

if ($exists) {
    return back()->withInput()->with('error', "The role '{$request->role}' is already assigned in this barangay.");
}


        // Create officer
        $officer = OfficerUser::create([
            'name'     => $request->name,
            'email'    => strtolower($request->email),
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'barangay' => $request->barangay,
        ]);

        // Send OTP
        $this->sendOtp($officer);

        // Store officer ID in session
        session(['officer_id' => $officer->id]);

        return redirect()->route('officer.register.otp')
            ->with('info', 'Registration successful! An OTP has been sent to your email.');
    }

    /**
     * Show OTP page after registration
     */
    public function showRegisterOtp()
    {
        if (!session('officer_id')) {
            return redirect()->route('officer.register')->with('error', 'Please register first.');
        }
        return view('officer.auth.register-otp');
    }

    /**
     * Verify OTP after registration
     */
    public function verifyRegisterOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $officer = OfficerUser::find(session('officer_id'));

        if (!$officer) {
            return redirect()->route('officer.register')->with('error', 'Session expired. Please register again.');
        }

        if ($request->otp == $officer->otp && now()->lessThan($officer->otp_expires_at)) {
            $officer->update([
                'otp' => null,
                'otp_expires_at' => null,
            ]);

            Auth::guard('officer')->login($officer);
            session()->forget('officer_id');

            return redirect()->route('officer.login')
                ->with('success', 'Your account is verified! Welcome, ' . $officer->name);
        }

        return back()->with('error', 'Invalid or expired OTP.');
    }

    /**
     * Officer login, OTP sent after password verification
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

    if (RateLimiter::tooManyAttempts($key, 3)) {
        $seconds = RateLimiter::availableIn($key);
        return back()->with('error', "Too many failed attempts. Try again in {$seconds} seconds.");
    }

    $officer = OfficerUser::where('email', $email)->first();

    if (!$officer) {
        RateLimiter::hit($key, 60);
        return back()->with('error', 'Email is not registered. Please register first.');
    }

    if (!Hash::check($request->password, $officer->password)) {
        RateLimiter::hit($key, 60);
        return back()->with('error', 'Incorrect password.');
    }

    if ($officer->role !== $request->role || $officer->barangay !== $request->barangay) {
        RateLimiter::hit($key, 60);
        return back()->with('error', 'Role or barangay does not match.');
    }

    // Send OTP
    $this->sendOtp($officer);
    session(['officer_id' => $officer->id]);

    return redirect()->route('officer.otp')
        ->with('info', 'OTP sent to your email. Enter it to complete login.');
}


    /**
     * Show login OTP page
     */
    public function showOtp()
    {
        if (!session('officer_id')) {
            return redirect()->route('officer.login')->with('error', 'Please login first.');
        }

        return view('officer.auth.otp');
    }

    /**
     * Verify login OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $officer = OfficerUser::find(session('officer_id'));

        if (!$officer) {
            return redirect()->route('officer.login')->with('error', 'Session expired. Please login again.');
        }

        if ($request->otp == $officer->otp && now()->lessThan($officer->otp_expires_at)) {
            Auth::guard('officer')->login($officer);
            session()->forget('officer_id');

            $officer->update([
                'last_login_at' => now(),
                'otp' => null,
                'otp_expires_at' => null,
            ]);

            return redirect()->route('officer.dashboard')
                ->with('success', 'Welcome back, ' . $officer->name . '!');
        }

        return back()->with('error', 'Invalid or expired OTP.');
    }

    /**
     * Officer logout
     */
    public function logout(Request $request)
    {
        Auth::guard('officer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('officer.login')->with('info', 'You have been logged out securely.');
    }
}
