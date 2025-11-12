<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\TokoPublikController;
use App\Http\Controllers\PesananPublikController;
use App\Http\Controllers\FaqController;

// Controllers Penjual
use App\Http\Controllers\Penjual\DashboardController;
use App\Http\Controllers\Penjual\ProfilController;
use App\Http\Controllers\Penjual\TokoController;
use App\Http\Controllers\Penjual\ProdukController;
use App\Http\Controllers\Penjual\PesananController;
use App\Http\Controllers\Auth\PenjualAuthController;
use App\Http\Controllers\Penjual\BantuanController;
use App\Http\Controllers\Auth\GooglePenjualController;

// Controllers Admin
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPenjualController;
use App\Http\Controllers\Admin\AdminKategoriController;
use App\Http\Controllers\Admin\AdminFaqController;

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // 🔐 Login & Logout admin (tanpa middleware auth)
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::post('/faq/upload-image', [AdminFaqController::class, 'uploadImage'])->name('admin.faq.uploadImage');


    // 🔒 Hanya untuk admin yang sudah login
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // 👤 CRUD Penjual
        Route::resource('/penjual', AdminPenjualController::class)->except(['show'])->names('penjual');

        // 🏷️ CRUD Kategori
        Route::resource('/kategori', AdminKategoriController::class)->except(['show'])->names('kategori');

        // 📚 CRUD FAQ (gunakan UUID)
        Route::resource('/faq', AdminFaqController::class)
            ->except(['show'])
            ->names('faq')
            ->whereUuid('faq'); // ✅ penting agar route binding UUID berfungsi
    });
});
Route::post('/admin/faq/upload-image', [AdminFaqController::class, 'uploadImage'])
    ->name('admin.faq.uploadImage');

/*
|--------------------------------------------------------------------------
| ROUTE UMUM (PEMBELI DAN PENJUAL)
|--------------------------------------------------------------------------
*/

// 🏠 Landing Page
Route::get('/', [LandingController::class, 'index'])->name('home');

// 🛍️ Katalog & Produk
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{id}', [KatalogController::class, 'show'])->name('katalog.show');
Route::get('/produk/{produk}', [KatalogController::class, 'show'])->name('produk.show');

// 📦 Pesanan Publik
Route::post('/pesanan', [PesananPublikController::class, 'store'])->name('pesanan.store');

// 🏪 Toko Publik
Route::get('/toko', [TokoPublikController::class, 'index'])->name('toko.index');
Route::get('/toko/{uuid}', [TokoPublikController::class, 'show'])->name('toko.show');

// 🔐 Login Penjual
Route::get('/penjual/login', [PenjualAuthController::class, 'showLoginForm'])->name('penjual.login');
Route::post('/penjual/login', [PenjualAuthController::class, 'login'])->name('penjual.login.post');
Route::post('/penjual/logout', [PenjualAuthController::class, 'logout'])->name('penjual.logout');

// ❓ FAQ
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

// Login Google untuk Penjual
Route::get('/auth/google/redirect', [PenjualAuthController::class, 'redirectToGoogle'])->name('penjual.google.redirect');
Route::get('/auth/google/callback', [PenjualAuthController::class, 'handleGoogleCallback'])->name('penjual.google.callback');

Route::get('/auth/google/redirect', [PenjualAuthController::class, 'redirectToGoogle'])->name('penjual.google.redirect');
Route::get('/auth/google/callback', [PenjualAuthController::class, 'handleGoogleCallback'])->name('penjual.google.callback');

// 🔐 Registrasi Penjual
Route::get('/penjual/register', [PenjualAuthController::class, 'showRegisterForm'])->name('penjual.register');
Route::post('/penjual/register', [PenjualAuthController::class, 'register'])->name('penjual.register.post');
Route::get('/auth/google', [PenjualAuthController::class, 'redirectToGoogle'])->name('penjual.google.redirect');
Route::get('/auth/google/callback', [PenjualAuthController::class, 'handleGoogleCallback'])->name('penjual.google.callback');
// 🚪 Logout Umum
Route::get('/logout', fn() => redirect('/')->with('status', 'Anda telah logout.'))->name('logout');
Route::view('/kebijakan-privasi', 'pages.kebijakan-privasi')->name('kebijakan-privasi');
Route::view('/kebijakan-layanan', 'pages.kebijakan-layanan')->name('kebijakan-layanan');
Route::view('/about', 'pages.about')->name('tentang-kami');
/*
|--------------------------------------------------------------------------
| ROUTE PENJUAL (Hanya bisa diakses oleh penjual login)
|--------------------------------------------------------------------------
*/
Route::prefix('penjual')->name('penjual.')->middleware('auth:penjual')->group(function () {

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
    Route::put('/pesanan/{id}/status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');

    // 🆘 Bantuan
    Route::get('/bantuan', [BantuanController::class, 'index'])->name('bantuan');
});

/*
|--------------------------------------------------------------------------
| ROUTE HALAMAN INFORMASI
|--------------------------------------------------------------------------
*/

// 📄 Halaman Informasi
Route::view('/kebijakan-privasi', 'pages.kebijakan-privasi')->name('kebijakan-privasi');
Route::view('/kebijakan-layanan', 'pages.kebijakan-layanan')->name('kebijakan-layanan');
Route::view('/about', 'pages.about')->name('tentang-kami');

