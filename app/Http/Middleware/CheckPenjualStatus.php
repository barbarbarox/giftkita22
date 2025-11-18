<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPenjualStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user login sebagai penjual
        if (Auth::guard('penjual')->check()) {
            $penjual = Auth::guard('penjual')->user();
            
            // Jika penjual tidak aktif, redirect ke halaman deaktivasi
            if ($penjual->status === 'inactive') {
                return redirect()->route('penjual.deactivated');
            }
        }
        
        return $next($request);
    }
}