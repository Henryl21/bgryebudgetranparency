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
     * Show the user registration form.
     */
    public function showRegisterForm()
    {
        $barangays = User::getBarangays();
        return view('user.register', compact('barangays'));
    }

    /**
     * Handle user registration and send OTP.
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => ['required', 'string', 'max:100', 'regex:/^[A-Za-z\s\'\-]+$/'],
                'middle_initial' => ['nullable', 'string', 'max:2', 'regex:/^[A-Za-z\.]+$/'],
                'last_name' => ['required', 'string', 'max:100', 'regex:/^[A-Za-z\s\'\-]+$/'],
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
                    'regex:/[@$!%*?&]/',
                ],
                'barangay_role' => ['required', Rule::in(array_keys(User::getBarangays()))],
                'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png|max:2048'],
            ]);

            // Combine name parts
            $fullName = $validated['first_name'];
            if (!empty($validated['middle_initial'])) {
                $fullName .= ' ' . strtoupper($validated['middle_initial']) . '.';
            }
            $fullName .= ' ' . $validated['last_name'];
            if (!empty($validated['suffix'])) {
                $fullName .= ', ' . ucfirst($validated['suffix']);
            }

            // Handle profile photo upload
            $profilePhotoName = null;
            if ($request->hasFile('profile_photo')) {
                $profilePhotoName = time() . '_' . $request->file('profile_photo')->getClientOriginalName();
                $request->file('profile_photo')->storeAs('profile_photos', $profilePhotoName, 'public');
            }

            // Generate OTP
            $otp = rand(100000, 999999);

            // Create the user with temporary OTP
            $user = User::create([
                'full_name' => $fullName,
                'number' => $validated['number'],
                'age' => $validated['age'],
                'birthdate' => $validated['birthdate'],
                'gender' => $validated['gender'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'barangay_role' => $validated['barangay_role'],
                'profile_photo' => $profilePhotoName,
                'password_changed_at' => now(),
                'is_verified' => false,
                'otp' => $otp,
                'otp_expires_at' => now()->addSeconds(60), // OTP expires in 1 minute
            ]);

            // Send OTP via PHPMailer
            try {
                $this->mailerService->sendOtpEmail($user->email, $otp, 1);
            } catch (\Exception $e) {
                return back()->with('error', '❌ Failed to send OTP. Please check your email configuration.')->withInput();
            }

            // Redirect to OTP verification page
            return redirect()
                ->route('user.verify-otp.form', ['email' => $user->email])
                ->with('success', '✅ Registration successful! A 6-digit OTP was sent to your email. Please verify to activate your account.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', '⚠️ Registration failed. Please try again later.')->withInput();
        }
    }

    /**
     * Show the OTP verification form.
     */
    public function showVerifyOtpForm(Request $request)
    {
        $email = $request->query('email');
        $user = User::where('email', $email)->first();

        $remainingSeconds = 0;
        if ($user && $user->otp_expires_at) {
            $remainingSeconds = max(0, $user->otp_expires_at->diffInSeconds(now()));
        }

        return view('user.verify-otp', compact('email', 'remainingSeconds'));
    }

    /**
     * Verify OTP and activate user.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        if ($user->otp_expires_at < now()) {
            return back()->with('error', '⚠️ OTP expired. Please request a new one.');
        }

        if ($user->otp !== $request->otp) {
            return back()->with('error', '❌ Invalid OTP. Please try again.');
        }

        // Mark user as verified
        $user->update([
            'is_verified' => true,
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        return redirect()->route('user.login')->with('success', '🎉 Account verified successfully! You can now log in.');
    }

    /**
     * Resend OTP (5 minutes validity).
     */
    public function resendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        // Generate new OTP
        $otp = rand(100000, 999999);
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5), // 5-minute expiry
        ]);

        try {
            $this->mailerService->sendOtpEmail($user->email, $otp, 5);
        } catch (\Exception $e) {
            return back()->with('error', '❌ Failed to resend OTP. Please try again.')->withInput();
        }

        return back()->with('success', '✅ A new OTP has been sent to your email. It will expire in 5 minutes.');
    }
}
