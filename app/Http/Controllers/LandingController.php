<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil 6 produk terbaru dengan gambar
        $produks = Produk::with(['files' => function ($q) {
            $q->limit(1);
        }, 'kategori', 'toko'])
        ->latest()
        ->take(4)
        ->get();

        return view('welcome', compact('produks'));
    }
}
