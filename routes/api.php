<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Penjual\TokoController;
use App\Http\Controllers\Penjual\ProdukController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\Penjual\PesananController;

/*
|--------------------------------------------------------------------------
| API Routes - GiftKita.id
|--------------------------------------------------------------------------
|
| Semua endpoint API backend, otomatis menggunakan prefix "/api"
| Contoh: http://127.0.0.1:8000/api/toko
|
*/

// Tes API aktif
Route::get('/ping', fn() => response()->json(['message' => 'GiftKita API aktif 🚀']));

// ==========================
// 🧑‍💼 ADMIN
// ==========================
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminAuthController::class, 'index']);
    Route::post('/', [AdminAuthController::class, 'store']);
    Route::put('/{uuid}', [AdminAuthController::class, 'update']);
    Route::delete('/{uuid}', [AdminAuthController::class, 'destroy']);

    // CRUD kategori
    Route::apiResource('kategori', KategoriController::class);

    // CRUD FAQ
    Route::apiResource('faq', FAQController::class);
});

// ==========================
// 🏪 TOKO
// ==========================
Route::prefix('toko')->group(function () {
    Route::get('/', [TokoController::class, 'index']);
    Route::get('/{uuid}', [TokoController::class, 'show']);
    Route::post('/', [TokoController::class, 'store']);
    Route::put('/{uuid}', [TokoController::class, 'update']);
    Route::delete('/{uuid}', [TokoController::class, 'destroy']);
});

// ==========================
// 🛍️ PRODUK
// ==========================
Route::prefix('produk')->group(function () {
    Route::get('/', [ProdukController::class, 'index']);
    Route::get('/{uuid}', [ProdukController::class, 'show']);
    Route::post('/', [ProdukController::class, 'store']);
    Route::put('/{uuid}', [ProdukController::class, 'update']);
    Route::delete('/{uuid}', [ProdukController::class, 'destroy']);
});

// ==========================
// 📦 PESANAN
// ==========================
Route::prefix('pesanan')->group(function () {
    Route::get('/', [PesananController::class, 'index']);
    Route::post('/', [PesananController::class, 'store']);
    Route::get('/{uuid}', [PesananController::class, 'show']);
});
