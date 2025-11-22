<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CleanInvalidSession
{
    /**
     * Handle an incoming request.
     * 
     * Middleware ini membersihkan session "zombie" - session yang sudah invalid
     * tapi cookie-nya masih tersimpan di browser.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ⚠️ CRITICAL: Cek apakah session sudah di-start
        if (!$request->hasSession()) {
            // Session belum tersedia, skip middleware
            return $next($request);
        }

        // Khusus untuk route penjual
        if ($request->is('penjual/*')) {
            $this->cleanZombieSession($request, 'penjual');
        }
        
        // Khusus untuk route admin
        if ($request->is('admin/*')) {
            $this->cleanZombieSession($request, 'admin');
        }

        return $next($request);
    }

    /**
     * Bersihkan session zombie untuk guard tertentu
     */
    protected function cleanZombieSession(Request $request, string $guard)
    {
        // ⚠️ Double check: Pastikan session tersedia
        if (!$request->hasSession()) {
            return;
        }

        // Cek apakah ada session cookie tapi user tidak terautentikasi
        $sessionCookie = $request->cookie(session()->getName());
        $rememberCookie = $request->cookie("remember_{$guard}");
        
        // Jika ada cookie tapi user tidak login, berarti zombie session
        if (($sessionCookie || $rememberCookie) && !Auth::guard($guard)->check()) {
            
            \Log::info("Zombie session detected for guard: {$guard}", [
                'has_session_cookie' => !empty($sessionCookie),
                'has_remember_cookie' => !empty($rememberCookie),
                'path' => $request->path(),
                'ip' => $request->ip(),
            ]);
            
            // Force clear session (dengan try-catch untuk safety)
            try {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            } catch (\Exception $e) {
                \Log::error('Failed to invalidate session in CleanInvalidSession', [
                    'error' => $e->getMessage(),
                    'guard' => $guard,
                ]);
            }
            
            // Clear remember token dari database jika ada
            if ($rememberCookie) {
                $modelClass = $this->getModelClass($guard);
                if ($modelClass && class_exists($modelClass)) {
                    try {
                        $modelClass::where('remember_token', '!=', null)
                            ->update(['remember_token' => null]);
                    } catch (\Exception $e) {
                        \Log::error('Failed to clear remember token in CleanInvalidSession', [
                            'error' => $e->getMessage(),
                            'guard' => $guard,
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Get model class berdasarkan guard
     */
    protected function getModelClass(string $guard): ?string
    {
        $provider = config("auth.guards.{$guard}.provider");
        return config("auth.providers.{$provider}.model");
    }
}