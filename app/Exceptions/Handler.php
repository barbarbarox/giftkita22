<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Route;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * 🎨 Render custom error pages
     */
    public function render($request, Throwable $exception)
    {
        // 🔍 404 - Not Found
        if ($exception instanceof NotFoundHttpException || 
            $exception instanceof ModelNotFoundException) {
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resource not found',
                ], 404);
            }
            
            if (view()->exists('errors.404')) {
                return response()->view('errors.404', [], 404);
            }
        }

        // 🔐 401 - Unauthenticated (belum login)
        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        // 🚫 403 - Forbidden (tidak punya akses)
        if ($exception instanceof AuthorizationException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden - You do not have permission to access this resource',
                ], 403);
            }
            
            if (view()->exists('errors.403')) {
                return response()->view('errors.403', [
                    'message' => $exception->getMessage()
                ], 403);
            }
        }

        // 🔄 419 - CSRF Token Mismatch
        if ($exception instanceof TokenMismatchException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'CSRF token mismatch. Please refresh the page.',
                ], 419);
            }
            
            if (view()->exists('errors.419')) {
                return response()->view('errors.419', [], 419);
            }
            
            // Fallback: redirect back dengan error
            return redirect()->back()
                ->withInput($request->except($this->dontFlash))
                ->with('error', 'Sesi Anda telah kedaluwarsa. Silakan coba lagi.');
        }

        // ⚠️ 500 - Internal Server Error
        if ($exception instanceof HttpException && $exception->getStatusCode() == 500) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Internal server error',
                ], 500);
            }
            
            if (view()->exists('errors.500')) {
                return response()->view('errors.500', [], 500);
            }
        }

        // 💥 Generic HTTP Exceptions
        if ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $exception->getMessage() ?: 'HTTP Error',
                    'status_code' => $statusCode,
                ], $statusCode);
            }

            // Check if custom error view exists
            if (view()->exists("errors.{$statusCode}")) {
                return response()->view("errors.{$statusCode}", [
                    'message' => $exception->getMessage()
                ], $statusCode);
            }
        }

        // 🔥 Production: Catch all errors
        if (!config('app.debug')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong',
                ], 500);
            }
            
            if (view()->exists('errors.500')) {
                return response()->view('errors.500', [], 500);
            }
        }

        // Default Laravel error handling
        return parent::render($request, $exception);
    }

    /**
     * 🔐 Convert authentication exception into proper response
     * 
     * PENTING: Ini adalah kunci utama untuk mengatasi error "Route login not defined"
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // Jika request mengharapkan JSON (API)
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        // 🔍 Deteksi guard dari exception
        $guard = $exception->guards()[0] ?? null;
        
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
                // Cek apakah route ada
                if (Route::has('admin.login')) {
                    return redirect()->guest(route('admin.login'))
                        ->with('error', 'Silakan login sebagai admin terlebih dahulu.');
                }
                // Fallback: langsung ke URL
                return redirect('/admin/login')
                    ->with('error', 'Silakan login sebagai admin terlebih dahulu.');

            case 'penjual':
                // Cek apakah route ada
                if (Route::has('penjual.login')) {
                    return redirect()->guest(route('penjual.login'))
                        ->with('error', 'Silakan login sebagai penjual terlebih dahulu.');
                }
                // Fallback: langsung ke URL
                return redirect('/penjual/login')
                    ->with('error', 'Silakan login sebagai penjual terlebih dahulu.');

            default:
                // Jika tidak ada guard, tampilkan error 401
                if (view()->exists('errors.401')) {
                    return response()->view('errors.401', [
                        'message' => 'Anda harus login terlebih dahulu.'
                    ], 401);
                }
                
                // Final fallback
                return redirect('/')->with('error', 'Anda harus login terlebih dahulu.');
        }
    }
}