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
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama', 'like', '%' . $searchTerm . '%')
                  ->orWhere('deskripsi', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('toko', function($tq) use ($searchTerm) {
                      $tq->where('nama_toko', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Sorting
        switch ($request->input('sort')) {
            case 'termurah':
                $query->orderBy('harga', 'asc');
                break;
            case 'termahal':
                $query->orderBy('harga', 'desc');
                break;
            case 'nama':
                $query->orderBy('nama', 'asc');
                break;
            case 'terbaru':
            default:
                $query->latest();
                break;
        }

        $produks = $query->get();
        $kategoris = Kategori::all();

        return view('katalog.index', compact('produks', 'kategoris'));
    }

    public function show($id)
    {
        $produk = Produk::with(['toko', 'files', 'kategori'])->findOrFail($id);

        return view('katalog.produk', compact('produk'));
    }
}