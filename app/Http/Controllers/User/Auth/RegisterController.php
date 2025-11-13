<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PHPMailerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    protected $mailerService;

    public function __construct(PHPMailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }

    /**
     * Show user registration form
     */
    public function showRegisterForm()
    {
        $barangays = User::getBarangays();
        return view('user.register', compact('barangays'));
    }

    /**
     * Handle registration and send OTP
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => ['required', 'string', 'max:100', 'regex:/^[A-Za-zÑñ\s\'\-]+$/'],
                'middle_name' => ['nullable', 'string', 'max:100', 'regex:/^[A-Za-zÑñ\s]+$/'],
                'last_name' => ['required', 'string', 'max:100', 'regex:/^[A-Za-zÑñ\s\'\-]+$/'],
                'suffix' => ['nullable', 'string', 'max:10', 'regex:/^[A-Za-z.]+$/'],
                'number' => ['required', 'regex:/^[0-9]{11}$/'],
                'birthdate' => ['required', 'date'],
                'age' => ['required', 'integer', 'min:1'],
                'gender' => ['required', Rule::in(['male', 'female', 'rather_not_say'])],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*?&\-_]/',
                ],
                'barangay_role' => ['required', Rule::in(array_keys(User::getBarangays()))],
                'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png|max:2048'],
            ]);

      if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $validated['profile_photo'] = $path;
        } else {
            $validated['profile_photo'] = null;
        }

            // Generate OTP
            $otp = rand(100000, 999999);

            // Store registration data in session
            session([
                'registration_data' => $validated,
                'registration_otp' => $otp,
                'registration_otp_expires' => now()->addMinutes(5),
            ]);

            // Send OTP via PHPMailer
            try {
                $this->mailerService->sendOtpEmail($validated['email'], $otp, 5);
            } catch (\Exception $e) {
                return back()
                    ->with('error', '❌ Failed to send OTP. Please check your email configuration.')
                    ->withInput();
            }

            return redirect()
                ->route('user.verify-otp.form', ['email' => $validated['email']])
                ->with('success', '✅ OTP sent! Please verify to complete your registration.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', '⚠️ Registration failed. Please try again later.')->withInput();
        }
    }

    /**
     * Show OTP verification form
     */
    public function showVerifyOtpForm(Request $request)
    {
        $email = $request->query('email');
        $remainingSeconds = 0;

        $data = session('registration_data');
        if ($data && $data['email'] === $email && session('registration_otp_expires')) {
            $remainingSeconds = max(0, session('registration_otp_expires')->diffInSeconds(now()));
        }

        return view('user.verify-otp', compact('email', 'remainingSeconds'));
    }

    /**
     * Verify OTP and create user
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $otp = session('registration_otp');
        $otpExpires = session('registration_otp_expires');
        $data = session('registration_data');

        if (!$otp || !$data || $data['email'] !== $request->email) {
            return back()->with('error', '⚠️ No registration data found. Please register again.');
        }

        if ($otpExpires < now()) {
            return back()->with('error', '⚠️ OTP expired. Please register again.');
        }

        if ($otp != $request->otp) {
            return back()->with('error', '❌ Invalid OTP. Please try again.');
        }

        // Combine full name
        $fullName = $data['first_name'];
        if (!empty($data['middle_name'])) $fullName .= ' ' . $data['middle_name'];
        $fullName .= ' ' . $data['last_name'];
        if (!empty($data['suffix'])) $fullName .= ', ' . ucfirst($data['suffix']);

        // Create user
        User::create([
            'full_name' => $fullName,
            'number' => $data['number'],
            'age' => $data['age'],
            'birthdate' => $data['birthdate'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'barangay_role' => $data['barangay_role'],
            'profile_photo' => $data['profile_photo'] ?? null,
            'is_verified' => true,
            'password_changed_at' => now(),
        ]);

        // Clear session
        session()->forget(['registration_data', 'registration_otp', 'registration_otp_expires']);

        return redirect()->route('user.login')->with('success', '🎉 Account verified successfully! You can now log in.');
    }

    /**
     * Resend OTP
     */
    public function resendOTP(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $data = session('registration_data');

        if (!$data || $data['email'] !== $request->email) {
            return back()->with('error', '⚠️ No registration data found. Please register again.');
        }

        // Generate new OTP
        $otp = rand(100000, 999999);
        session([
            'registration_otp' => $otp,
            'registration_otp_expires' => now()->addMinutes(5)
        ]);

        try {
            $this->mailerService->sendOtpEmail($request->email, $otp, 5);
        } catch (\Exception $e) {
            return back()->with('error', '❌ Failed to resend OTP. Please try again.');
        }

        return back()->with('success', '✅ A new OTP has been sent to your email. It will expire in 5 minutes.');
    }
}
