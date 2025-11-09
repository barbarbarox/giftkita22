<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Default guard & password broker. Untuk aplikasi multi-role, biarkan
    | tetap 'web' agar route publik tidak error saat guard belum terdeteksi.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Tiap guard mewakili sesi login terpisah (admin, penjual, user/pembeli).
    | Gunakan "session" untuk aplikasi berbasis web (bukan API token).
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'penjual' => [
            'driver' => 'session',
            'provider' => 'penjuals',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Provider menentukan model yang digunakan oleh masing-masing guard.
    | Pastikan model dan tabel sudah sesuai dengan struktur database kamu.
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'penjuals' => [
            'driver' => 'eloquent',
            'model' => App\Models\Penjual::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Kamu bisa buat mekanisme lupa password terpisah untuk tiap guard
    | jika suatu saat sistemnya diperluas.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60, // menit
            'throttle' => 60, // detik antar request reset
        ],

        'penjuals' => [
            'provider' => 'penjuals',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 30, // Admin → lebih ketat
            'throttle' => 120,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Waktu sesi untuk halaman sensitif (misal ubah password) sebelum
    | pengguna diminta login ulang.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];
