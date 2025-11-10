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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ✅ Correct place to cast datetime fields
    protected $casts = [
        'birthdate' => 'date',
        'password_changed_at' => 'datetime',
        'otp_expires_at' => 'datetime', // <-- fix
        'is_verified' => 'boolean',
    ];

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

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::needsRehash($value) ? bcrypt($value) : $value;
        }
    }

    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo && file_exists(storage_path('app/public/profile_photos/' . $this->profile_photo))) {
            return asset('storage/profile_photos/' . $this->profile_photo);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name);
    }
}
