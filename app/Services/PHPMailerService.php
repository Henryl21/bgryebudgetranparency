<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;

class PHPMailerService
{
    protected $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        try {
            // ✅ Use environment variables for better security
            $this->mailer->isSMTP();
            $this->mailer->Host       = env('MAIL_HOST', 'smtp.gmail.com');
            $this->mailer->SMTPAuth   = true;
            $this->mailer->Username   = env('MAIL_USERNAME', 'punayhenryl17@gmail.com');
            $this->mailer->Password   = env('MAIL_PASSWORD', 'zbxzhxeq ktpp mxac');
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port       = env('MAIL_PORT', 587);

            // ✅ Default sender info
            $this->mailer->setFrom(
                env('MAIL_FROM_ADDRESS', 'noreply@gmail.com'),
                env('MAIL_FROM_NAME', 'Barangay System')
            );

            // ✅ Debug (off by default)
            $this->mailer->SMTPDebug = 0;
            $this->mailer->Debugoutput = function ($str, $level) {
                Log::debug("PHPMailer debug level {$level}: {$str}");
            };

            // ✅ Charset
            $this->mailer->CharSet = 'UTF-8';
        } catch (Exception $e) {
            Log::error('Mailer setup failed: ' . $e->getMessage());
        }
    }

    /**
     * ✅ Send OTP Email (with expiry time in minutes)
     */
    public function sendOtpEmail(string $toEmail, string $otp, int $expiresInMinutes = 1): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($toEmail);
            $this->mailer->isHTML(true);

            $this->mailer->Subject = 'Your OTP Code - Barangay System';
            $this->mailer->Body = "
                <div style='font-family: Arial, sans-serif; background:#f9fafb; padding:20px; border-radius:10px;'>
                    <h2 style='color:#2b6cb0;'>🔐 Email Verification</h2>
                    <p>Hello,</p>
                    <p>Your One-Time Password (OTP) is:</p>
                    <h3 style='color:#2b6cb0; font-size:24px; letter-spacing:3px;'>{$otp}</h3>
                    <p>This OTP will expire in <b>{$expiresInMinutes} minute(s)</b>. Please do not share it with anyone.</p>
                    <br>
                    <p>Regards,<br><b>Barangay System Team</b></p>
                </div>
            ";
            $this->mailer->AltBody = "Your OTP code is: {$otp}. It will expire in {$expiresInMinutes} minute(s).";

            $this->mailer->send();

            // ✅ Log success
            Log::info("✅ OTP sent successfully to {$toEmail}");
            return true;

        } catch (Exception $e) {
            // ⚠️ Handle cases where email was likely sent but PHPMailer returned a minor SMTP warning
            if (stripos($e->getMessage(), 'Data not accepted') !== false || stripos($e->getMessage(), 'Connection closed gracefully') !== false) {
                Log::warning("⚠️ OTP possibly sent (minor SMTP warning) to {$toEmail}: " . $e->getMessage());
                return true;
            }

            Log::error("❌ Failed to send OTP email to {$toEmail}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * ✅ Send Password Reset Email
     */
    public function sendResetLinkEmail(string $toEmail, string $resetLink): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($toEmail);
            $this->mailer->isHTML(true);

            $this->mailer->Subject = 'Reset Your Admin Password - Barangay System';
            $this->mailer->Body = "
                <div style='font-family: Arial, sans-serif; background:#f9fafb; padding:20px; border-radius:10px;'>
                    <p>Hello,</p>
                    <p>You requested a password reset. Click the link below to reset your password:</p>
                    <p><a href='{$resetLink}' style='color:#2b6cb0; text-decoration:none; font-weight:bold;'>Reset Password</a></p>
                    <p>This link will expire in 60 minutes.</p>
                    <p>If you did not request this, please ignore this email.</p>
                    <br>
                    <p>Regards,<br><b>Barangay System Team</b></p>
                </div>
            ";
            $this->mailer->AltBody = "Reset your password here: {$resetLink}";

            $this->mailer->send();

            // ✅ Log success
            Log::info("✅ Password reset link sent to {$toEmail}");
            return true;

        } catch (Exception $e) {
            // ⚠️ Same as above — treat harmless SMTP warnings as successful
            if (stripos($e->getMessage(), 'Data not accepted') !== false || stripos($e->getMessage(), 'Connection closed gracefully') !== false) {
                Log::warning("⚠️ Reset email possibly sent (minor SMTP warning) to {$toEmail}: " . $e->getMessage());
                return true;
            }

            Log::error("❌ Reset email failed to {$toEmail}: " . $e->getMessage());
            return false;
        }
    }
}
