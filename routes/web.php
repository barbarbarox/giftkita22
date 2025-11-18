<?php

use Illuminate\Support\Facades\Route;
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
use App\Http\Controllers\Auth\PenjualAuthController;
use App\Http\Controllers\Penjual\BantuanController;

// Controllers Admin
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPenjualController;
use App\Http\Controllers\Admin\AdminKategoriController;
use App\Http\Controllers\Admin\AdminFaqController;

/*
|--------------------------------------------------------------------------
| 🔐 ROUTE ADMIN
|--------------------------------------------------------------------------
| Pastikan route admin menggunakan middleware 'web' agar CSRF dan session aktif.
| Tanpa ini, error 419 (Page Expired) bisa muncul saat login/logout.
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware('web')
    ->group(function () {

        // 🔓 Login & Logout (tanpa middleware auth)
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // 🔒 Admin area (wajib login)
        Route::middleware('auth:admin')->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            // 👤 CRUD Penjual
            // ⚠️ PENTING: Route spesifik HARUS di atas route resource!
                Route::prefix('laporan')->name('laporan.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('index');
                    Route::get('/statistik', [App\Http\Controllers\Admin\LaporanController::class, 'statistik'])->name('statistik');
                    Route::get('/{id}', [App\Http\Controllers\Admin\LaporanController::class, 'show'])->name('show');
                    Route::post('/{id}/update-status', [App\Http\Controllers\Admin\LaporanController::class, 'updateStatus'])->name('updateStatus');
                    Route::post('/bulk-action', [App\Http\Controllers\Admin\LaporanController::class, 'bulkAction'])->name('bulkAction');
                    Route::delete('/{id}', [App\Http\Controllers\Admin\LaporanController::class, 'destroy'])->name('destroy');
                });
            
            // Monitoring Penjual
            Route::get('/penjual/{id}/monitoring', [AdminPenjualController::class, 'monitoring'])
                ->name('penjual.monitoring');
            
            // ✅ ROUTES BARU: Toggle Status Penjual
            Route::post('/penjual/{id}/toggle-status', [AdminPenjualController::class, 'toggleStatus'])
                ->name('penjual.toggleStatus');
            
            Route::get('/penjual/{id}/deactivate-form', [AdminPenjualController::class, 'showDeactivateForm'])
                ->name('penjual.deactivateForm');
            
            Route::post('/penjual/{id}/deactivate', [AdminPenjualController::class, 'deactivate'])
                ->name('penjual.deactivate');
            
            Route::post('/penjual/{id}/activate', [AdminPenjualController::class, 'activate'])
                ->name('penjual.activate');
            
            // Route resource di bawah
            Route::resource('/penjual', AdminPenjualController::class)
                ->except(['show'])
                ->names('penjual');

            // 🏷️ CRUD Kategori
            Route::resource('/kategori', AdminKategoriController::class)
                ->except(['show'])
                ->names('kategori');

            // 📚 CRUD FAQ
            Route::resource('/faq', AdminFaqController::class)
                ->except(['show'])
                ->names('faq');
            
            // 📸 Upload gambar FAQ (CKEditor)
            Route::post('/faq/upload-image', [AdminFaqController::class, 'uploadImage'])
                ->name('faq.uploadImage');
        });
    });

/*
|--------------------------------------------------------------------------
| 🌍 ROUTE UMUM (PEMBELI & PENGUNJUNG)
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('home');

// 🛍️ Katalog & Produk
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{id}', [KatalogController::class, 'show'])->name('katalog.show');
Route::get('/produk/{produk}', [KatalogController::class, 'show'])->name('produk.show');
Route::get('/katalog/{id}', [KatalogController::class, 'show'])->name('katalog.show');

// 📦 Pesanan Publik
Route::post('/pesanan', [PesananPublikController::class, 'store'])->name('pesanan.store');

// 🏪 Toko Publik
Route::get('/toko', [TokoPublikController::class, 'index'])->name('toko.index');
Route::get('/toko/{uuid}', [TokoPublikController::class, 'show'])->name('toko.show');

// ❓ FAQ
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
// Laporan Penjual (tanpa login)
Route::get('/lapor-penjual', [LaporanPenjualController::class, 'create'])->name('laporan.create');
Route::post('/lapor-penjual', [LaporanPenjualController::class, 'store'])->name('laporan.store');
Route::get('/lapor-penjual/get-penjual', [LaporanPenjualController::class, 'getPenjual'])->name('laporan.getPenjual');

// 📄 Halaman Informasi
Route::view('/kebijakan-privasi', 'pages.kebijakan-privasi')->name('kebijakan-privasi');
Route::view('/kebijakan-layanan', 'pages.kebijakan-layanan')->name('kebijakan-layanan');
Route::view('/about', 'pages.about')->name('tentang-kami');

/*
|--------------------------------------------------------------------------
| 🛍️ ROUTE PENJUAL (AUTH PENJUAL)
|--------------------------------------------------------------------------
*/

// 🔐 Autentikasi Penjual
Route::get('/penjual/login', [PenjualAuthController::class, 'showLoginForm'])->name('penjual.login');
Route::post('/penjual/login', [PenjualAuthController::class, 'login'])->name('penjual.login.post');
Route::post('/penjual/logout', [PenjualAuthController::class, 'logout'])->name('penjual.logout');

Route::get('/penjual/register', [PenjualAuthController::class, 'showRegisterForm'])->name('penjual.register');
Route::post('/penjual/register', [PenjualAuthController::class, 'register'])->name('penjual.register.post');

// 🪪 Login Google untuk Penjual
Route::get('/auth/google/redirect', [PenjualAuthController::class, 'redirectToGoogle'])->name('penjual.google.redirect');
Route::get('/auth/google/callback', [PenjualAuthController::class, 'handleGoogleCallback'])->name('penjual.google.callback');

// 🚪 Logout umum
Route::get('/logout', fn() => redirect('/')->with('status', 'Anda telah logout.'))->name('logout');
/*
|--------------------------------------------------------------------------
| 🧑‍💼 ROUTE PENJUAL (Hanya bisa diakses oleh penjual login)
|--------------------------------------------------------------------------
*/
Route::prefix('penjual')
    ->name('penjual.')
    ->middleware('auth:penjual')
    ->group(function () {

        // 📊 Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // 👤 Profil Penjual
        Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
        Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');

        // 🏪 CRUD Toko
        Route::resource('/toko', TokoController::class)->except(['show'])->names('toko');

        // 🧺 CRUD Produk
        Route::resource('/produk', ProdukController::class)->except(['show'])->names('produk');
        Route::delete('/produk/foto/{id}', [ProdukController::class, 'hapusFoto'])->name('produk.foto.destroy');

        // 📦 Pesanan
        Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
        Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
        Route::put('/pesanan/{id}/status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');

        // 🆘 Bantuan
        Route::get('/bantuan', [BantuanController::class, 'index'])->name('bantuan');
        
        // 📈 Statistik
        Route::get('/statistik', [\App\Http\Controllers\Penjual\StatistikController::class, 'index'])->name('statistik');
        
        // 📥 Export Statistik
        Route::get('/statistik/export-pdf', [\App\Http\Controllers\Penjual\StatistikController::class, 'exportPDF'])->name('statistik.export.pdf');
        Route::get('/statistik/export-excel', [\App\Http\Controllers\Penjual\StatistikController::class, 'exportExcel'])->name('statistik.export.excel');
        Route::get('/statistik/export-image', [\App\Http\Controllers\Penjual\StatistikController::class, 'exportImage'])->name('statistik.export.image');
    });