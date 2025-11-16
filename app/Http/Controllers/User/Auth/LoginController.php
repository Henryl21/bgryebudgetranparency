<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LoginLog;
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
     * Show user login form
     */
    public function showLoginForm()
    {
        $barangays = User::getBarangays();
        return view('user.login', compact('barangays'));
    }

    /**
     * Handle login request and send OTP
     */
    public function login(Request $request)
    {
        if ($this->isLockedOut($request)) {
            return $this->sendLockoutResponse($request);
        }

        $barangayKeys = array_keys(User::getBarangays());

        $request->validate([
            'email' => 'required|email',
            'password' => ['required','string','min:8'],
            'barangay_role' => ['required', Rule::in($barangayKeys)],
        ]);

        $user = User::where('email', $request->email)
            ->whereRaw('LOWER(barangay_role) = ?', [strtolower($request->barangay_role)])
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            $this->incrementLoginAttempts($request);
            $error = !$user ? 'No account found.' : 'Incorrect password.';
            return back()->withErrors(['email' => $error])
                         ->withInput($request->only('email','barangay_role'));
        }

        $this->clearLoginAttempts($request);

        // Generate OTP
        $otp = rand(100000,999999);
        session([
            'login_user_id' => $user->id,
            'login_email' => $user->email,
            'login_otp' => $otp,
            'login_otp_expires' => now()->addMinutes(5)
        ]);

        try {
            $this->mailerService->sendOtpEmail($user->email, $otp, 5);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send OTP.'])->withInput();
        }

        return redirect()->route('user.login.verify-otp.form')
            ->with('success', 'OTP sent! Check your email.');
    }

    /**
     * Show OTP verification form
     */
    public function showLoginOtpForm()
    {
        $email = session('login_email'); // So UI can show "OTP sent to your email"
        return view('user.login-verify-otp', compact('email'));
    }

    /**
     * Verify OTP and login
     */
    public function verifyLoginOtp(Request $request)
    {
        $request->validate(['otp'=>'required|digits:6']);

        $otp = session('login_otp');
        $otpExpires = session('login_otp_expires');
        $userId = session('login_user_id');

        if (!$otp || !$userId) {
            return redirect()->route('user.login')->withErrors(['email'=>'Login session expired.']);
        }

        if ($otpExpires < now()) {
            session()->forget(['login_user_id','login_otp','login_otp_expires']);
            return redirect()->route('user.login')->withErrors(['email'=>'OTP expired.']);
        }

        if ($request->otp != $otp) {
            return back()->withErrors(['otp'=>'Invalid OTP.']);
        }

        // OTP correct → log in
        $user = User::find($userId);
        $remember = session('login_remember', false);
        Auth::guard('user')->login($user, $remember);
        $request->session()->regenerate();

        // ================= LOGIN LOG =================
        LoginLog::create([
            'user_id' => $user->id,
            'time_in' => now(),
        ]);

        $user->time_in = now();
        $user->time_out = null;

        // ====== SAVE LATITUDE & LONGITUDE ======
        $user->latitude = $request->latitude ?? $user->latitude;
        $user->longitude = $request->longitude ?? $user->longitude;
        // =======================================

        $user->save();

        session()->forget(['login_user_id','login_otp','login_otp_expires','login_remember']);

        return redirect()->route('user.dashboard')->with(
            'success',
            'Welcome back, ' . $user->full_name . '!'
        );
    }

    /**
     * RESEND OTP
     */
    public function resendLoginOtp()
    {
        $userId = session('login_user_id');
        $email  = session('login_email');

        if (!$userId || !$email) {
            return redirect()->route('user.login')
                ->withErrors(['email' => 'Session expired. Please login again.']);
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('user.login')
                ->withErrors(['email' => 'User not found.']);
        }

        // Generate new OTP
        $otp = rand(100000, 999999);

        session([
            'login_otp' => $otp,
            'login_otp_expires' => now()->addMinutes(5),
        ]);

        try {
            $this->mailerService->sendOtpEmail($email, $otp, 5);
        } catch (\Exception $e) {
            return back()->withErrors(['otp' => 'Failed to resend OTP. Try again later.']);
        }

        return back()->with('success', 'A new OTP has been sent to your email.');
    }

    /**
     * Logout user and update time_out
     */
    public function logout(Request $request)
    {
        $user = Auth::guard('user')->user();

        if ($user) {
            $latestLog = $user->latestLoginLog;
            if ($latestLog && !$latestLog->time_out) {
                $latestLog->time_out = now();
                $latestLog->save();
            }

            $user->time_out = now();
            $user->save();
        }

        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login')
            ->with('status', 'You have been successfully logged out.');
    }

    // ====================== LOCKOUT FUNCTIONS ======================
    protected function lockoutKey(Request $request): string
    {
        return 'login_lockout_'.sha1($request->ip().'|'.strtolower($request->input('email')));
    }

    protected function attemptKey(Request $request): string
    {
        return 'login_attempts_'.sha1($request->ip().'|'.strtolower($request->input('email')));
    }

    protected function incrementLoginAttempts(Request $request): void
    {
        $attemptKey = $this->attemptKey($request);
        $lockoutKey = $this->lockoutKey($request);

        $attempts = Cache::get($attemptKey,0) + 1;
        Cache::put($attemptKey,$attempts,60);

        if ($attempts >= 3) {
            $lockoutEndsAt = now()->addSeconds(60)->timestamp;
            Cache::put($lockoutKey,$lockoutEndsAt,60);
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

    protected function sendLockoutResponse(Request $request)
    {
        $lockoutTimestamp = Cache::get($this->lockoutKey($request));
        $seconds = $lockoutTimestamp ? $lockoutTimestamp - time() : 60;
        if ($seconds <= 0 || $seconds > 60) $seconds = 60;

        throw ValidationException::withMessages([
            'email'=>["Too many login attempts. Please try again in {$seconds} second(s)."],
        ])->status(429);
    }
}
