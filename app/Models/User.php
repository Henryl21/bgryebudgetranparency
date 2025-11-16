<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

  protected $fillable = [
    'full_name',
    'number',
    'age',
    'birthdate',
    'gender',
    'email',
    'password',
    'profile_photo',
    'barangay_role',
    'password_changed_at',
    'is_verified',
    'otp',
    'otp_expires_at',
    'time_in',
    'time_out',
    'latitude',      // add this
    'longitude',     // add this
];


    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'password_changed_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    /**
     * 🔥 Barangay list
     */
    public static function getBarangays(): array
    {
        return [
            'bunakan' => 'Bunakan',
            'kangwayan' => 'Kangwayan',
            'kaongkod' => 'Kaongkod',
            'kodia' => 'Kodia',
            'maalat' => 'Maalat',
            'malbago' => 'Malbago',
            'mancilang' => 'Mancilang',
            'tarong' => 'Tarong',
            'pili' => 'Pili',
            'poblacion' => 'Poblacion',
            'san-agustin' => 'San-agustin',
            'tabagak' => 'Tabagak',
            'talangnan' => 'Talangnan',
            'tugas' => 'Tugas',
        ];
    }

    /**
     * 🔥 Automatically hash password
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] =
                Hash::needsRehash($value) ? bcrypt($value) : $value;
        }
    }

    /**
     * 🔥 Profile photo URL
     */
   public function getProfilePhotoUrlAttribute(): string
    {
        // Check if image exists in storage
        if ($this->profile_photo && Storage::disk('public')->exists($this->profile_photo)) {
            return asset('storage/' . $this->profile_photo);
        }

        // Default photo (UI Avatar API)
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name);
    }

    /**
     * 🔥 User has many login logs
     */
    public function loginLogs()
    {
        return $this->hasMany(LoginLog::class, 'user_id');
    }

    /**
     * 🔥 Latest login log
     */
    public function latestLoginLog()
    {
        return $this->hasOne(LoginLog::class, 'user_id')->latestOfMany();
    }
}
