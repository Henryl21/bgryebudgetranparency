<?php
namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PHPMailerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    protected $mailerService;

    public function __construct(PHPMailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }

    /**
     * Show the user login form.
     */
    public function showLoginForm()
    {
        $barangays = User::getBarangays();
        return view('user.login', compact('barangays'));
    }

    /**
     * Handle user login request.
     * Sends OTP if credentials are correct.
     */
    public function login(Request $request)
    {
        // Check lockout
        if ($this->isLockedOut($request)) {
            return $this->sendLockoutResponse($request);
        }

        $barangayKeys = array_keys(User::getBarangays());

        $request->validate([
            'email' => 'required|email',
            'password' => ['required', 'string', 'min:8'],
            'barangay_role' => ['required', Rule::in($barangayKeys)],
        ], [
            'barangay_role.required' => 'Please select your barangay.',
            'barangay_role.in' => 'Please select a valid barangay.',
        ]);

        $user = User::where('email', $request->email)
            ->whereRaw('LOWER(barangay_role) = ?', [strtolower($request->barangay_role)])
            ->first();

        if (!$user) {
            $this->incrementLoginAttempts($request);
            return back()->withErrors([
                'email' => 'No account found with these details. Please check your email and barangay.',
            ])->withInput($request->only('email', 'barangay_role'));
        }

        if (!Hash::check($request->password, $user->password)) {
            $this->incrementLoginAttempts($request);
            $attemptsLeft = $this->retriesLeft($request);
            $errorMessage = 'Incorrect password.';
            if ($attemptsLeft > 0) $errorMessage .= " You have {$attemptsLeft} attempt(s) remaining.";
            return back()->withErrors(['password' => $errorMessage])
                         ->withInput($request->only('email', 'barangay_role'));
        }

        // Reset attempts
        $this->clearLoginAttempts($request);

        // Check if OTP login is required
        $otp = rand(100000, 999999);
        session([
            'login_user_id' => $user->id,
            'login_otp' => $otp,
            'login_otp_expires' => now()->addMinutes(5)
        ]);

        try {
            $this->mailerService->sendOtpEmail($user->email, $otp, 5);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => '❌ Failed to send OTP. Please try again.'])->withInput();
        }

        return redirect()->route('user.login.verify-otp.form')->with('success', '✅ OTP sent! Check your email to complete login.');
    }

    /**
     * Show OTP verification form for login.
     */
    public function showLoginOtpForm()
    {
        return view('user.login-verify-otp');
    }

    /**
     * Verify OTP for login.
     */
    public function verifyLoginOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $otp = session('login_otp');
        $otpExpires = session('login_otp_expires');
        $userId = session('login_user_id');

        if (!$otp || !$userId) {
            return redirect()->route('user.login')->withErrors(['email' => '⚠️ Login session expired. Please try again.']);
        }

        if ($otpExpires < now()) {
            session()->forget(['login_user_id','login_otp','login_otp_expires']);
            return redirect()->route('user.login')->withErrors(['email' => '⚠️ OTP expired. Please login again.']);
        }

        if ($request->otp != $otp) {
            return back()->withErrors(['otp' => '❌ Invalid OTP. Please try again.']);
        }

        // OTP correct → log in
        $user = User::find($userId);
$remember = session('login_remember', false); // default false
Auth::guard('user')->login($user, $remember); // <-- use remember token
$request->session()->regenerate();

// Clear OTP & remember sessions
session()->forget(['login_user_id','login_otp','login_otp_expires','login_remember']);

        return redirect()->route('user.dashboard')->with(
            'success',
            'Welcome back, ' . $user->full_name . '! You are logged in as a resident of ' . ucfirst($user->barangay_role) . '.'
        );
    }

    // ====================== Existing lockout functions ======================

    protected function lockoutKey(Request $request): string
    {
        return 'login_lockout_' . sha1($request->ip() . '|' . strtolower($request->input('email')));
    }

    protected function attemptKey(Request $request): string
    {
        return 'login_attempts_' . sha1($request->ip() . '|' . strtolower($request->input('email')));
    }

    protected function incrementLoginAttempts(Request $request): void
    {
        $attemptKey = $this->attemptKey($request);
        $lockoutKey = $this->lockoutKey($request);

        $attempts = Cache::get($attemptKey, 0) + 1;
        Cache::put($attemptKey, $attempts, 60);

        if ($attempts >= 3) {
            $lockoutEndsAt = now()->addSeconds(60)->timestamp;
            Cache::put($lockoutKey, $lockoutEndsAt, 60);
            Cache::forget($attemptKey);
        }
    }

    protected function isLockedOut(Request $request): bool
    {
        $lockoutTimestamp = Cache::get($this->lockoutKey($request));
        return $lockoutTimestamp && time() < $lockoutTimestamp;
    }

    protected function clearLoginAttempts(Request $request): void
    {
        Cache::forget($this->attemptKey($request));
        Cache::forget($this->lockoutKey($request));
    }

    protected function retriesLeft(Request $request): int
    {
        $attempts = Cache::get($this->attemptKey($request), 0);
        return max(0, 3 - $attempts);
    }

    protected function sendLockoutResponse(Request $request)
    {
        $lockoutTimestamp = Cache::get($this->lockoutKey($request));
        $seconds = $lockoutTimestamp ? $lockoutTimestamp - time() : 60;
        if ($seconds <= 0 || $seconds > 60) $seconds = 60;

        throw ValidationException::withMessages([
            'email' => ["Too many login attempts. Please try again in {$seconds} second(s)."],
        ])->status(429);
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user.login')->with('status', 'You have been successfully logged out.');
    }
}
