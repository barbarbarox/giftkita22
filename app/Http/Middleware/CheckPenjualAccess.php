<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CheckPenjualAccess
{
    /**
     * Handle an incoming request.
     *
     * Middleware ini memastikan hanya penjual yang bisa akses route penjual.
     * Jika user login sebagai admin, akan di-block dengan 403.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ WHITELIST: Route public yang BOLEH diakses tanpa autentikasi
        $publicRoutes = [
            'penjual/login',
            'penjual/register',
            'penjual/google/redirect',
            'penjual/google/callback',
            'penjual/check-ban-status',
            'penjual/deactivated',
        ];
        
        $path = $request->path();
        
        // Skip check untuk route public
        foreach ($publicRoutes as $publicRoute) {
            if (str_starts_with($path, $publicRoute)) {
                return $next($request); // ← Izinkan akses tanpa autentikasi
            }
        }
        
        // Jika belum login sama sekali, redirect ke login penjual
        if (!Auth::guard('penjual')->check()) {
            // Cek apakah user login sebagai admin
            if (Auth::guard('admin')->check()) {
                // User login sebagai admin tapi coba akses penjual area
                throw new AccessDeniedHttpException('Anda tidak memiliki akses ke halaman penjual. Silakan login sebagai penjual.');
            }
            
            // Belum login sama sekali, redirect ke login penjual
            return redirect()->route('penjual.login')
                ->with('warning', 'Silakan login sebagai penjual untuk mengakses halaman ini.');
        }
        
        return $next($request);
    }
}