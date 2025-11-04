<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with(['toko', 'files', 'kategori']);

        // Pencarian berdasarkan nama/deskripsi
        if ($request->filled('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->q . '%');
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $produks = $query->latest()->get();
        $kategoris = Kategori::all();

        return view('katalog.index', compact('produks', 'kategoris'));
    }

    public function show($id)
    {
        $produk = Produk::with(['toko', 'files', 'kategori'])->findOrFail($id);

        return view('katalog.produk', compact('produk'));
    }
}
