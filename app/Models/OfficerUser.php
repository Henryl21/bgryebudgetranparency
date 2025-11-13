<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class OfficerUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'officer_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',       // Role-based login
        'barangay',   // Officer's barangay
        'otp',        // OTP for login/registration
        'otp_expires_at', // Expiry time for OTP
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime', // important for comparison
    ];

    /**
     * Optional: relationship to officer profile
     */
    public function officerProfile()
    {
        return $this->hasOne(Officer::class, 'email', 'email');
    }

    /**
     * Helper method: check role
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Password reset table for this guard
     */
    public function getPasswordResetTable()
    {
        return 'officer_password_resets';
    }
}
