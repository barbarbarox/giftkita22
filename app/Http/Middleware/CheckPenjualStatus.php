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
     * Middleware ini mengecek status penjual saat mengakses halaman.
     * Jika status = 'inactive', paksa logout dan redirect ke login dengan pesan ban.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user login sebagai penjual
        if (Auth::guard('penjual')->check()) {
            $penjual = Auth::guard('penjual')->user();
            
            // Jika penjual tidak aktif (di-ban)
            if ($penjual && $penjual->status === 'inactive') {
                
                // Log aktivitas ban detection
                \Log::warning('Inactive penjual detected - Force logout', [
                    'penjual_id' => $penjual->id,
                    'email' => $penjual->email,
                    'deactivated_at' => $penjual->deactivated_at,
                    'ip' => $request->ip(),
                    'path' => $request->path(),
                ]);
                
                // Simpan informasi ban untuk ditampilkan di login page
                $banInfo = [
                    'banned' => true,
                    'reason' => $penjual->deactivation_reason ?? 'Akun Anda telah dinonaktifkan oleh admin.',
                    'date' => $penjual->deactivated_at ? $penjual->deactivated_at->format('d M Y H:i') : null,
                    'username' => $penjual->username,
                    'email' => $penjual->email,
                ];
                
                // Hapus remember token dari database
                $penjual->setRememberToken(null);
                $penjual->save();
                
                // Force logout
                Auth::guard('penjual')->logout();
                
                // Invalidate session
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                // Redirect ke login dengan pesan ban
                return redirect()->route('penjual.login')
                    ->withErrors([
                        'account_banned' => 'Akun Anda telah dinonaktifkan oleh admin.',
                    ])
                    ->with('ban_info', $banInfo);
            }
        }
        
        return $next($request);
    }
}