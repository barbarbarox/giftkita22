<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * Middleware ini menentukan kemana user akan di-redirect jika belum login.
     */
    protected function redirectTo(Request $request): ?string
    {
        // PENTING: Return null untuk API requests (akan return 401 JSON)
        if ($request->expectsJson()) {
            return null;
        }

        // 🔍 Deteksi dari URL path
        $path = $request->path();
        
        // 🔐 Admin Routes - Cek apakah URL dimulai dengan 'admin'
        if (str_starts_with($path, 'admin')) {
            // Pastikan route admin.login ada
            if (\Illuminate\Support\Facades\Route::has('admin.login')) {
                return route('admin.login');
            }
            // Fallback jika route tidak ada
            return '/admin/login';
        }

        // 🛍️ Penjual Routes - Cek apakah URL dimulai dengan 'penjual'
        if (str_starts_with($path, 'penjual')) {
            // Pastikan route penjual.login ada
            if (\Illuminate\Support\Facades\Route::has('penjual.login')) {
                return route('penjual.login');
            }
            // Fallback jika route tidak ada
            return '/penjual/login';
        }

        // ❌ Default: Return null (akan trigger error 401)
        // Jangan redirect ke route 'login' yang tidak ada
        return null;
    }
}