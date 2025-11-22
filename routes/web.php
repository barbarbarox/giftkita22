<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ═══════════════════════════════════════════════════════════════
// 🌐 CONTROLLERS IMPORT
// ═══════════════════════════════════════════════════════════════

// Controllers Publik
use App\Http\Controllers\LandingController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\TokoPublikController;
use App\Http\Controllers\PesananPublikController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\LaporanPenjualController;

// Controllers Penjual
use App\Http\Controllers\Penjual\DashboardController;
use App\Http\Controllers\Penjual\ProfilController;
use App\Http\Controllers\Penjual\TokoController;
use App\Http\Controllers\Penjual\ProdukController;
use App\Http\Controllers\Penjual\PesananController;
use App\Http\Controllers\Penjual\BantuanController;
use App\Http\Controllers\Penjual\StatistikController;
use App\Http\Controllers\Auth\PenjualAuthController;

// Controllers Admin
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPenjualController;
use App\Http\Controllers\Admin\AdminKategoriController;
use App\Http\Controllers\Admin\AdminFaqController;
use App\Http\Controllers\Admin\LaporanController;

/*
|--------------------------------------------------------------------------
| 🌍 PUBLIC ROUTES (PEMBELI & PENGUNJUNG)
|--------------------------------------------------------------------------
| Routes yang dapat diakses oleh semua pengunjung tanpa autentikasi
*/

// 🏠 Landing Page
Route::get('/', [LandingController::class, 'index'])->name('home');

// 🛍️ Katalog & Produk
Route::prefix('katalog')->name('katalog.')->group(function () {
    Route::get('/', [KatalogController::class, 'index'])->name('index');
    Route::get('/{id}', [KatalogController::class, 'show'])->name('show');
});
Route::get('/produk/{produk}', [KatalogController::class, 'show'])->name('produk.show');

// 📦 Pesanan Publik (tanpa login)
Route::post('/pesanan', [PesananPublikController::class, 'store'])->name('pesanan.store');

// 🏪 Toko Publik
Route::prefix('toko')->name('toko.')->group(function () {
    Route::get('/', [TokoPublikController::class, 'index'])->name('index');
    Route::get('/{uuid}', [TokoPublikController::class, 'show'])->name('show');
});

// ❓ FAQ
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

// 📢 Laporan Penjual (tanpa login)
Route::prefix('lapor-penjual')->name('laporan.')->group(function () {
    Route::get('/', [LaporanPenjualController::class, 'create'])->name('create');
    Route::post('/', [LaporanPenjualController::class, 'store'])->name('store');
    Route::get('/get-penjual', [LaporanPenjualController::class, 'getPenjual'])->name('getPenjual');
});

// 📄 Halaman Informasi
Route::view('/kebijakan-privasi', 'pages.kebijakan-privasi')->name('kebijakan-privasi');
Route::view('/kebijakan-layanan', 'pages.kebijakan-layanan')->name('kebijakan-layanan');
Route::view('/about', 'pages.about')->name('tentang-kami');

/*
|--------------------------------------------------------------------------
| 🚨 EMERGENCY ROUTES - Force Clear Session
|--------------------------------------------------------------------------
| Route untuk membersihkan semua session zombie (debugging purpose)
*/

Route::get('/clear-session', function () {
    // Backup user info untuk logging
    $penjualId = Auth::guard('penjual')->id();
    $adminId = Auth::guard('admin')->id();
    
    // Logout semua guard
    Auth::guard('penjual')->logout();
    Auth::guard('admin')->logout();
    Auth::guard('web')->logout();
    
    // Invalidate session
    session()->flush();
    session()->invalidate();
    session()->regenerateToken();
    
    // Clear remember token di database
    if (class_exists(\App\Models\Penjual::class)) {
        \App\Models\Penjual::query()->update(['remember_token' => null]);
    }
    if (class_exists(\App\Models\Admin::class)) {
        \App\Models\Admin::query()->update(['remember_token' => null]);
    }
    
    // Log aktivitas
    \Log::info('Emergency session clear executed', [
        'penjual_id' => $penjualId,
        'admin_id' => $adminId,
        'ip' => request()->ip(),
    ]);
    
    // Buat response dengan cookie clearing
    $response = redirect('/')->with('success', 'Semua session berhasil dibersihkan. Silakan login kembali.');
    
    // Clear semua authentication cookies
    $cookies = [
        'laravel_session',
        'remember_penjual',
        'remember_admin',
        'remember_web',
        'XSRF-TOKEN',
        session()->getName(),
    ];
    
    foreach ($cookies as $cookie) {
        $response->withCookie(cookie()->forget($cookie));
    }
    
    return $response;
})->name('clear.session');

/*
|--------------------------------------------------------------------------
| 🔐 ADMIN ROUTES
|--------------------------------------------------------------------------
| Routes khusus untuk admin panel dengan autentikasi guard 'admin'
*/

Route::prefix('admin')->name('admin.')->group(function () {
    
    // ─────────────────────────────────────────────────────────────
    // 🔓 Guest Routes (Belum Login)
    // ─────────────────────────────────────────────────────────────
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    });
    
    // ─────────────────────────────────────────────────────────────
    // 🔒 Authenticated Routes (Sudah Login)
    // ─────────────────────────────────────────────────────────────
    Route::middleware('auth:admin')->group(function () {
        
        // Logout
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        
        // 📊 Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // 📋 Laporan Management
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [LaporanController::class, 'index'])->name('index');
            Route::get('/statistik', [LaporanController::class, 'statistik'])->name('statistik');
            Route::get('/{id}', [LaporanController::class, 'show'])->name('show');
            Route::post('/{id}/update-status', [LaporanController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/bulk-action', [LaporanController::class, 'bulkAction'])->name('bulkAction');
            Route::delete('/{id}', [LaporanController::class, 'destroy'])->name('destroy');
        });
        
        // 👤 Penjual Management
        Route::prefix('penjual')->name('penjual.')->group(function () {
            // Custom actions (sebelum resource)
            Route::get('/{id}/monitoring', [AdminPenjualController::class, 'monitoring'])->name('monitoring');
            Route::post('/{id}/toggle-status', [AdminPenjualController::class, 'toggleStatus'])->name('toggleStatus');
            Route::get('/{id}/deactivate-form', [AdminPenjualController::class, 'showDeactivateForm'])->name('deactivateForm');
            Route::post('/{id}/deactivate', [AdminPenjualController::class, 'deactivate'])->name('deactivate');
            Route::post('/{id}/activate', [AdminPenjualController::class, 'activate'])->name('activate');
        });
        
        // Resource route (setelah custom actions)
        Route::resource('penjual', AdminPenjualController::class)
            ->except(['show'])
            ->names('penjual');
        
        // 🏷️ Kategori Management
        Route::resource('kategori', AdminKategoriController::class)
            ->except(['show'])
            ->names('kategori');
        
        // 📚 FAQ Management
        Route::post('/faq/upload-image', [AdminFaqController::class, 'uploadImage'])->name('faq.uploadImage');
        Route::resource('faq', AdminFaqController::class)
            ->except(['show'])
            ->names('faq');
    });
});

/*
|--------------------------------------------------------------------------
| 🛍️ PENJUAL ROUTES
|--------------------------------------------------------------------------
| Routes khusus untuk dashboard penjual dengan autentikasi guard 'penjual'
*/

Route::prefix('penjual')->name('penjual.')->group(function () {
    
    // ─────────────────────────────────────────────────────────────
    // 🔓 Guest Routes (Belum Login)
    // ─────────────────────────────────────────────────────────────
    Route::middleware('guest:penjual')->group(function () {
        
        // Manual Login & Register
        Route::get('/login', [PenjualAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [PenjualAuthController::class, 'login'])->name('login.post');
        Route::get('/register', [PenjualAuthController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [PenjualAuthController::class, 'register'])->name('register.post');
        
        // Google OAuth
        Route::get('/google/redirect', [PenjualAuthController::class, 'redirectToGoogle'])->name('google.redirect');
        Route::get('/google/callback', [PenjualAuthController::class, 'handleGoogleCallback'])->name('google.callback');
    });
    
    // ─────────────────────────────────────────────────────────────
    // 🔍 Public Routes (Tidak Perlu Auth)
    // ─────────────────────────────────────────────────────────────
    
    // AJAX Check Ban Status (untuk rate limiting di login form)
    Route::post('/check-ban-status', [PenjualAuthController::class, 'checkBanStatus'])->name('check.ban');
    
    // Deactivated Page (akun yang dinonaktifkan)
    Route::get('/deactivated', function () {
        $penjual = auth('penjual')->user();
        
        // Jika tidak login atau akun aktif, redirect
        if (!$penjual) {
            return redirect()->route('penjual.login')
                ->with('info', 'Silakan login terlebih dahulu.');
        }
        
        if ($penjual->status === 'active') {
            return redirect()->route('penjual.dashboard');
        }
        
        return view('penjual.deactivated', compact('penjual'));
    })->name('deactivated');
    
    // ─────────────────────────────────────────────────────────────
    // 🔒 Authenticated Routes (Sudah Login + Status Active)
    // ─────────────────────────────────────────────────────────────
    Route::middleware(['auth:penjual', 'check.penjual.status'])->group(function () {
        
        // Logout (POST method - recommended)
        Route::post('/logout', [PenjualAuthController::class, 'logout'])->name('logout');
        
        // Logout (GET method - untuk compatibility, tapi kurang aman)
        // ⚠️ WARNING: GET method untuk logout tidak recommended untuk production
        // Karena bisa di-trigger oleh browser prefetch atau link crawler
        Route::get('/logout', function () {
            \Log::warning('Logout via GET method', [
                'user_id' => auth('penjual')->id(),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
            
            // Redirect ke POST logout
            return view('penjual.logout-confirmation');
        })->name('logout.get');
        
        // 📊 Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // 👤 Profil
        Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
        Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
        
        // 🏪 Toko Management
        Route::resource('toko', TokoController::class)
            ->except(['show'])
            ->names('toko');
        
        // 🎁 Produk Management
        Route::delete('/produk/foto/{id}', [ProdukController::class, 'hapusFoto'])->name('produk.foto.destroy');
        Route::resource('produk', ProdukController::class)
            ->except(['show'])
            ->names('produk');
        
        // 📦 Pesanan Management
        Route::prefix('pesanan')->name('pesanan.')->group(function () {
            Route::get('/', [PesananController::class, 'index'])->name('index');
            Route::get('/{id}', [PesananController::class, 'show'])->name('show');
            Route::put('/{id}/status', [PesananController::class, 'updateStatus'])->name('updateStatus');
        });
        
        // 📈 Statistik & Export
        Route::prefix('statistik')->name('statistik.')->group(function () {
            Route::get('/', [StatistikController::class, 'index'])->name('index');
            Route::get('/export-pdf', [StatistikController::class, 'exportPDF'])->name('export.pdf');
            Route::get('/export-excel', [StatistikController::class, 'exportExcel'])->name('export.excel');
            Route::get('/export-image', [StatistikController::class, 'exportImage'])->name('export.image');
        });
        
        // 🆘 Bantuan & FAQ
        Route::get('/bantuan', [BantuanController::class, 'index'])->name('bantuan');
    });
});

/*
|--------------------------------------------------------------------------
| 🚧 Fallback Route (404)
|--------------------------------------------------------------------------
| Route untuk handle halaman tidak ditemukan
*/

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});