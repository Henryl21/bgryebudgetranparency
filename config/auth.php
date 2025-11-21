<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */
    'guards' => [

        // Default guard
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Resident / Frontend user
        'user' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Admin guard
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        // Officer guard
        'officer' => [
            'driver' => 'session',
            'provider' => 'officers',
        ],

        // ⭐ NEW — Treasurer Guard
        'treasurer' => [
            'driver' => 'session',
            'provider' => 'treasurers',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */
    'providers' => [

        // Residents / App Users
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // Admins
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        // Officers
        'officers' => [
            'driver' => 'eloquent',
            'model' => App\Models\OfficerUser::class,
        ],

        // ⭐ NEW — Treasurers
        'treasurers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Treasurer::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    */
    'passwords' => [

        // Users
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        // Admins
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        // Officers
        'officers' => [
            'provider' => 'officers',
            'table' => 'officer_password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        // ⭐ NEW — Treasurer Password Reset
        'treasurers' => [
            'provider' => 'treasurers',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */
    'password_timeout' => 10800,

];
