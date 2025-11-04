<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\TokoPublikController;
use App\Http\Controllers\PesananPublikController;

// Controllers Penjual
use App\Http\Controllers\Penjual\DashboardController;
use App\Http\Controllers\Penjual\ProfilController;
use App\Http\Controllers\Penjual\TokoController;
use App\Http\Controllers\Penjual\ProdukController;
use App\Http\Controllers\Penjual\PesananController;
use App\Http\Controllers\Auth\PenjualAuthController;

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
Route::prefix('admin')->group(function () {

    // 🔐 Login Admin (disamarkan)
    Route::get('/olgin', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/olgin', [AdminAuthController::class, 'login'])->name('admin.login.post');

    // 🔒 Hanya untuk admin yang login
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

        // 👤 CRUD Penjual
        Route::resource('/penjual', AdminPenjualController::class)->except(['show'])->names([
            'index' => 'admin.penjual.index',
            'create' => 'admin.penjual.create',
            'store' => 'admin.penjual.store',
            'edit' => 'admin.penjual.edit',
            'update' => 'admin.penjual.update',
            'destroy' => 'admin.penjual.destroy',
        ]);

        // 🏷️ CRUD Kategori
        Route::resource('/kategori', AdminKategoriController::class)->except(['show'])->names([
            'index' => 'admin.kategori.index',
            'create' => 'admin.kategori.create',
            'store' => 'admin.kategori.store',
            'edit' => 'admin.kategori.edit',
            'update' => 'admin.kategori.update',
            'destroy' => 'admin.kategori.destroy',
        ]);

        // 📚 CRUD FAQ
        Route::resource('/faq', AdminFaqController::class)->except(['show'])->names([
            'index' => 'admin.faq.index',
            'create' => 'admin.faq.create',
            'store' => 'admin.faq.store',
            'edit' => 'admin.faq.edit',
            'update' => 'admin.faq.update',
            'destroy' => 'admin.faq.destroy',
        ]);
    });
});

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
// 📦 Pesanan Publik (pembeli)
Route::post('/pesanan', [PesananPublikController::class, 'store'])->name('pesanan.store');

// 🏪 Toko Publik
Route::get('/toko', [TokoPublikController::class, 'index'])->name('toko.index');
Route::get('/toko/{uuid}', [TokoPublikController::class, 'show'])->name('toko.show');

// 🔐 Login Penjual
Route::get('/penjual/login', [PenjualAuthController::class, 'showLoginForm'])->name('penjual.login');
Route::post('/penjual/login', [PenjualAuthController::class, 'login'])->name('penjual.login.post');
Route::post('/penjual/logout', [PenjualAuthController::class, 'logout'])->name('penjual.logout');

// 🚪 Logout Umum
Route::get('/logout', fn() => redirect('/')->with('status', 'Anda telah logout.'))->name('logout');

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
    Route::get('/toko', [TokoController::class, 'index'])->name('toko.index');
    Route::get('/toko/create', [TokoController::class, 'create'])->name('toko.create');
    Route::post('/toko', [TokoController::class, 'store'])->name('toko.store');
    Route::get('/toko/{uuid}/edit', [TokoController::class, 'edit'])->name('toko.edit');
    Route::put('/toko/{uuid}', [TokoController::class, 'update'])->name('toko.update');
    Route::delete('/toko/{uuid}', [TokoController::class, 'destroy'])->name('toko.destroy');

    // 🧺 CRUD Produk
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    Route::delete('/produk/foto/{id}', [ProdukController::class, 'hapusFoto'])->name('produk.foto.destroy');

    // 📦 Pesanan (FIXED)
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::put('/pesanan/{id}/status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');

    // 🆘 Bantuan
    Route::view('/bantuan', 'penjual.bantuan')->name('bantuan');
});
