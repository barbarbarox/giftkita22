<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CheckAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * Middleware ini memastikan hanya admin yang bisa akses route admin.
     * Jika user login sebagai penjual, akan di-block dengan 403.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika belum login sama sekali, redirect ke login admin
        if (!Auth::guard('admin')->check()) {
            // Cek apakah user login sebagai penjual
            if (Auth::guard('penjual')->check()) {
                // User login sebagai penjual tapi coba akses admin area
                throw new AccessDeniedHttpException('Anda tidak memiliki akses ke halaman admin. Silakan login sebagai admin.');
            }
            
            // Belum login sama sekali, redirect ke login admin
            return redirect()->route('admin.login')
                ->with('warning', 'Silakan login sebagai admin untuk mengakses halaman ini.');
        }
        
        return $next($request);
    }
}