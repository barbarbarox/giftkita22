<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ═══════════════════════════════════════════════════════════════
        // 🌐 Register Web Middleware Group
        // ═══════════════════════════════════════════════════════════════
        $middleware->web(append: [
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \App\Http\Middleware\CleanInvalidSession::class, // ← PINDAH KE SINI (setelah StartSession)
        ]);
        
        // ═══════════════════════════════════════════════════════════════
        // 🏷️ Register Middleware Aliases
        // ═══════════════════════════════════════════════════════════════
        $middleware->alias([
            'check.penjual.status' => \App\Http\Middleware\CheckPenjualStatus::class,
            'check.admin.access' => \App\Http\Middleware\CheckAdminAccess::class,
            'check.penjual.access' => \App\Http\Middleware\CheckPenjualAccess::class,
            'clean.session' => \App\Http\Middleware\CleanInvalidSession::class,
        ]);

        // ═══════════════════════════════════════════════════════════════
        // 🚪 Redirect Unauthenticated Users (Guest Redirect)
        // ═══════════════════════════════════════════════════════════════
        $middleware->redirectGuestsTo(function (Request $request) {
            $path = $request->path();
            
            // ✅ WHITELIST: Route yang BOLEH diakses tanpa login
            $publicRoutes = [
                'admin/login',
                'penjual/login',
                'penjual/register',
                'penjual/google/redirect',
                'penjual/google/callback',
                'penjual/check-ban-status',
                'clear-session', // ← Emergency clear session route
            ];
            
            // Jika request ke public routes, izinkan akses (return null)
            foreach ($publicRoutes as $publicRoute) {
                if (str_starts_with($path, $publicRoute)) {
                    return null; // ← Tidak redirect, izinkan akses
                }
            }
            
            // Admin routes (yang membutuhkan autentikasi)
            if (str_starts_with($path, 'admin')) {
                return route('admin.login');
            }
            
            // Penjual routes (yang membutuhkan autentikasi)
            if (str_starts_with($path, 'penjual')) {
                return route('penjual.login');
            }
            
            // Default: return null (tidak redirect untuk route publik)
            return null;
        });

        // ═══════════════════════════════════════════════════════════════
        // 🔄 Redirect Authenticated Users (Sudah Login)
        // ═══════════════════════════════════════════════════════════════
        $middleware->redirectUsersTo(function (Request $request) {
            // Cek guard mana yang authenticated
            if (auth('admin')->check()) {
                return route('admin.dashboard');
            }
            
            if (auth('penjual')->check()) {
                $penjual = auth('penjual')->user();
                
                // Cek status penjual
                if ($penjual && $penjual->status === 'inactive') {
                    return route('penjual.deactivated');
                }
                
                return route('penjual.dashboard');
            }
            
            // Default: redirect ke home
            return '/';
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
        // ═══════════════════════════════════════════════════════════════
        // 🔍 404 - NOT FOUND
        // ═══════════════════════════════════════════════════════════════
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resource not found'
                ], 404);
            }
            
            if (view()->exists('errors.404')) {
                return response()->view('errors.404', [], 404);
            }
            
            return response()->view('errors.minimal', [
                'code' => 404,
                'message' => 'Halaman tidak ditemukan'
            ], 404);
        });
        
        // ═══════════════════════════════════════════════════════════════
        // 🔐 401 - UNAUTHENTICATED (Belum Login)
        // ═══════════════════════════════════════════════════════════════
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated'
                ], 401);
            }
            
            // 🔍 Deteksi guard dari exception
            $guard = $e->guards()[0] ?? null;
            
            // 🔍 Deteksi dari URL jika guard tidak ada
            if (!$guard) {
                $path = $request->path();
                
                if (str_starts_with($path, 'admin')) {
                    $guard = 'admin';
                } elseif (str_starts_with($path, 'penjual')) {
                    $guard = 'penjual';
                }
            }
            
            // 🚪 Redirect berdasarkan guard
            switch ($guard) {
                case 'admin':
                    return redirect()->route('admin.login')
                        ->with('error', 'Silakan login sebagai admin terlebih dahulu.');
                    
                case 'penjual':
                    return redirect()->route('penjual.login')
                        ->with('error', 'Silakan login sebagai penjual terlebih dahulu.');
                    
                default:
                    // Tampilkan error 401 page
                    if (view()->exists('errors.401')) {
                        return response()->view('errors.401', [
                            'message' => 'Anda harus login terlebih dahulu.'
                        ], 401);
                    }
                    
                    return redirect('/')->with('error', 'Anda harus login terlebih dahulu.');
            }
        });
        
        // ═══════════════════════════════════════════════════════════════
        // 🚫 403 - FORBIDDEN (Tidak Punya Akses)
        // ═══════════════════════════════════════════════════════════════
        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden',
                    'error' => $e->getMessage()
                ], 403);
            }
            
            if (view()->exists('errors.403')) {
                return response()->view('errors.403', [
                    'exception' => $e,
                    'message' => $e->getMessage()
                ], 403);
            }
            
            return response()->view('errors.minimal', [
                'code' => 403,
                'message' => 'Akses ditolak'
            ], 403);
        });
        
        $exceptions->render(function (AuthorizationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden',
                    'error' => $e->getMessage()
                ], 403);
            }
            
            if (view()->exists('errors.403')) {
                return response()->view('errors.403', [
                    'exception' => $e,
                    'message' => $e->getMessage()
                ], 403);
            }
            
            return response()->view('errors.minimal', [
                'code' => 403,
                'message' => 'Anda tidak memiliki izin untuk mengakses halaman ini'
            ], 403);
        });
        
        // ═══════════════════════════════════════════════════════════════
        // 🔄 419 - CSRF TOKEN MISMATCH
        // ═══════════════════════════════════════════════════════════════
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'CSRF token mismatch. Please refresh the page.'
                ], 419);
            }
            
            if (view()->exists('errors.419')) {
                return response()->view('errors.419', [], 419);
            }
            
            // Fallback: Redirect dengan pesan error
            if ($request->is('admin/*')) {
                return redirect()->route('admin.login')
                    ->withErrors(['error' => 'Sesi Anda telah berakhir. Silakan login kembali.']);
            }
            
            if ($request->is('penjual/*')) {
                return redirect()->route('penjual.login')
                    ->withErrors(['error' => 'Sesi Anda telah berakhir. Silakan login kembali.']);
            }
            
            return redirect('/')
                ->withErrors(['error' => 'Sesi Anda telah berakhir. Silakan refresh halaman.']);
        });
        
        // ═══════════════════════════════════════════════════════════════
        // ⚠️ 500 - INTERNAL SERVER ERROR
        // ═══════════════════════════════════════════════════════════════
        $exceptions->render(function (\Throwable $e, Request $request) {
            // Skip jika dalam mode debug
            if (config('app.debug')) {
                return null;
            }
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Internal server error'
                ], 500);
            }
            
            if (view()->exists('errors.500')) {
                return response()->view('errors.500', [], 500);
            }
            
            return response()->view('errors.minimal', [
                'code' => 500,
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        });
        
    })->create();