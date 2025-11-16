<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\OfficerUser;
use App\Models\Admin;
use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Services\PHPMailerService;

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
     * Send OTP using PHPMailerService (same HTML design as Admin/User)
     */
    protected function sendOtp(OfficerUser $officer)
    {
        $otp = rand(100000, 999999);

        $officer->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        // Use PHPMailerService to send styled HTML OTP email
        $mailer = new PHPMailerService();
        $mailer->sendOtpEmail($officer->email, $otp, 5);
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
                'required','string','min:8',
                'regex:/[A-Z]/','regex:/[a-z]/',
                'regex:/[0-9]/','regex:/[@$!%*?&]/',
                'confirmed',
            ],
            'role'     => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
        ]);

        $exists = OfficerUser::where('role', $request->role)
            ->where('barangay', $request->barangay)
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', "The role '{$request->role}' is already assigned in this barangay.");
        }

        $officer = OfficerUser::create([
            'name'     => $request->name,
            'email'    => strtolower($request->email),
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'barangay' => $request->barangay,
        ]);

        $this->sendOtp($officer);
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
        $request->validate(['otp' => 'required|digits:6']);

        $officer = OfficerUser::find(session('officer_id'));

        if (!$officer) {
            return redirect()->route('officer.register')->with('error', 'Session expired. Please register again.');
        }

        if ($request->otp == $officer->otp && now()->lessThan($officer->otp_expires_at)) {

            // Save latitude & longitude (if provided) and clear OTP
            $officer->update([
                'otp' => null,
                'otp_expires_at' => null,
                'latitude' => $request->latitude ?? $officer->latitude,
                'longitude' => $request->longitude ?? $officer->longitude,
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
            return back()->with('error', 'Email is not registered.');
        }

        if (!Hash::check($request->password, $officer->password)) {
            RateLimiter::hit($key, 60);
            return back()->with('error', 'Incorrect password.');
        }

        if ($officer->role !== $request->role || $officer->barangay !== $request->barangay) {
            RateLimiter::hit($key, 60);
            return back()->with('error', 'Role or barangay does not match.');
        }

        $this->sendOtp($officer);
        session(['officer_id' => $officer->id]);

        return redirect()->route('officer.otp')
            ->with('info', 'OTP sent to your email.');
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
     * Verify login OTP and log time_in
     */
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $officer = OfficerUser::find(session('officer_id'));

        if (!$officer) {
            return redirect()->route('officer.login')->with('error', 'Session expired. Please login again.');
        }

        if ($request->otp == $officer->otp && now()->lessThan($officer->otp_expires_at)) {

            Auth::guard('officer')->login($officer);
            session()->forget('officer_id');

            // Save new latitude & longitude if provided
            if ($request->filled('latitude') && $request->filled('longitude')) {
                $officer->latitude = $request->latitude;
                $officer->longitude = $request->longitude;
                $officer->save();
            }

            // Log login time
            LoginLog::create([
                'officer_id' => $officer->id,
                'time_in' => now(),
                'latitude' => $request->latitude ?? $officer->latitude,
                'longitude' => $request->longitude ?? $officer->longitude,
            ]);

            // Update officer account login timestamps and clear OTP
            $officer->update([
                'time_in' => now(),
                'last_login_at' => now(),
                'otp' => null,
                'otp_expires_at' => null,
            ]);

            return redirect()->route('officer.dashboard')
                ->with('success', 'Welcome back, ' . $officer->name . '! Location saved.');
        }

        return back()->with('error', 'Invalid or expired OTP.');
    }

    /**
     * Officer logout and log time_out
     */
    public function logout(Request $request)
    {
        $officer = Auth::guard('officer')->user();

        if ($officer) {
            $latestLog = $officer->latestLoginLog()->first();

            if ($latestLog && !$latestLog->time_out) {
                $latestLog->update(['time_out' => now()]);
            }

            $officer->update([
                'time_out' => now(),
            ]);
        }

        Auth::guard('officer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('officer.login')->with('info', 'You have been logged out securely.');
    }
}
