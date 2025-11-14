<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class OfficerUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'barangay',
        'otp',
        'otp_expires_at',
        'time_in',
        'time_out',
        'latitude',
        'longitude',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    protected $casts = [
        'otp_expires_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

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
     * 🔥 Officer has many login logs
     */
    public function loginLogs()
    {
        return $this->hasMany(LoginLog::class, 'officer_id');
    }

    /**
     * 🔥 Latest login log
     */
    public function latestLoginLog()
    {
        return $this->hasOne(LoginLog::class, 'officer_id')->latestOfMany();
    }

    /**
     * 🔥 Barangay list helper
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
}
