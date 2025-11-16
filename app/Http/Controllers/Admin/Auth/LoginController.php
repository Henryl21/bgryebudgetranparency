<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\Services\PHPMailerService;
use Carbon\Carbon;

class LoginController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        $barangays = Admin::getBarangays();

        $requireCaptcha = false;
        if (request()->has('email') && $this->hasTooManyLoginAttempts(request())) {
            $requireCaptcha = true;
        }

        return view('admin.auth.login', compact('barangays', 'requireCaptcha'));
    }

    /**
     * Handle admin login request with OTP generation
     */
    public function login(Request $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $barangayKeys = array_keys(Admin::getBarangays());

        $rules = [
            'email' => 'required|email',
            'password' => ['required', 'string', 'min:8'],
            'barangay_role' => ['required', Rule::in($barangayKeys)],
        ];

        if ($this->hasTooManyLoginAttempts($request)) {
            $rules['captcha'] = 'required|captcha';
        }

        $request->validate($rules, [
            'barangay_role.required' => 'Please select your barangay.',
            'barangay_role.in' => 'Please select a valid barangay from the list.',
            'captcha.required' => 'Please complete the CAPTCHA verification.',
            'captcha.captcha' => 'CAPTCHA verification failed. Please try again.',
        ]);

        $admin = Admin::where('email', $request->email)
            ->whereRaw('LOWER(barangay_role) = ?', [strtolower($request->barangay_role)])
            ->first();

        if (!$admin) {
            $this->incrementLoginAttempts($request);
            return back()->withErrors(['email' => 'No admin found with these details.'])
                         ->withInput($request->only('email', 'barangay_role'));
        }

        if (!Hash::check($request->password, $admin->password)) {
            $this->incrementLoginAttempts($request);
            $attemptsLeft = $this->retriesLeft($request);
            $errorMessage = 'Incorrect password.';
            if ($attemptsLeft > 0) {
                $errorMessage .= " You have {$attemptsLeft} attempt(s) remaining.";
            }
            return back()->withErrors(['password' => $errorMessage])
                         ->withInput($request->only('email', 'barangay_role'));
        }

        if (Hash::needsRehash($admin->password)) {
            $admin->password = Hash::make($request->password);
            $admin->save();
        }

        $this->clearLoginAttempts($request);

        // =================== GENERATE OTP =======================
        $otp = rand(100000, 999999);
        $admin->otp = $otp;
        $admin->otp_expires_at = now()->addMinutes(5);
        $admin->save();

        // Send OTP email
        $mailer = new PHPMailerService();
        $mailer->sendOtpEmail($admin->email, $otp, 5);

        // Store email + admin id in session
        session([
            'otp_admin_id' => $admin->id,
            'otp_email' => $admin->email,
            'otp_last_sent' => now(),
        ]);

        return redirect()->route('admin.otp.form')->with('success', 'OTP sent to your email.');
    }

    /**
     * Show OTP verification page
     */
    public function showOtpForm()
    {
        if (!session()->has('otp_admin_id')) {
            return redirect()->route('admin.login')->with('error', 'Session expired.');
        }

        return view('admin.auth.verify-otp', [
            'email' => session('otp_email')
        ]);
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);
        $admin = Admin::find(session('otp_admin_id'));

        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Session expired.');
        }

        if ($admin->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        if (now()->greaterThan($admin->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Your OTP has expired.']);
        }

        // Clear OTP
        $admin->otp = null;
        $admin->otp_expires_at = null;
        $admin->save();

        // Clear OTP session data
        session()->forget('otp_admin_id');
        session()->forget('otp_email');
        session()->forget('otp_last_sent');

        Auth::guard('admin')->login($admin);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard')->with('success', 'OTP Verified — Welcome back, ' . $admin->name . '!');
    }

    /**
     * Resend OTP
     */
   public function resendOtp(Request $request)
{
    if (!session()->has('otp_admin_id')) {
        return redirect()->route('admin.login')->with('error', 'Session expired. Please login again.');
    }

    $admin = Admin::find(session('otp_admin_id'));

    if (!$admin) {
        session()->forget('otp_admin_id');
        session()->forget('otp_email');
        session()->forget('otp_last_sent');
        return redirect()->route('admin.login')->with('error', 'Admin not found. Please login again.');
    }

    // Generate new OTP instantly (no cooldown)
    $otp = rand(100000, 999999);
    $admin->otp = $otp;
    $admin->otp_expires_at = now()->addMinutes(5);
    $admin->save();

    // Send OTP email
    $mailer = new PHPMailerService();
    $mailer->sendOtpEmail($admin->email, $otp, 5);

    // Update last sent time (optional, for info only)
    session(['otp_last_sent' => now()]);

    return back()->with('success', 'A new OTP has been sent to your email.');
}

    /**
     * Logout the admin
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'You have been successfully logged out.');
    }

    // ================= RATE LIMIT HELPERS =================
    protected function throttleKey(Request $request): string
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }

    protected function hasTooManyLoginAttempts(Request $request): bool
    {
        return RateLimiter::tooManyAttempts($this->throttleKey($request), 3);
    }

    protected function incrementLoginAttempts(Request $request): void
    {
        RateLimiter::hit($this->throttleKey($request), 60);
    }

    protected function clearLoginAttempts(Request $request): void
    {
        RateLimiter::clear($this->throttleKey($request));
    }

    protected function retriesLeft(Request $request): int
    {
        return RateLimiter::retriesLeft($this->throttleKey($request), 3);
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = RateLimiter::availableIn($this->throttleKey($request));
        if ($seconds <= 0 || $seconds > 60) $seconds = 60;

        throw ValidationException::withMessages([
            'email' => ["Too many login attempts. Please try again in {$seconds} second(s)."],
        ])->status(429);
    }
}
