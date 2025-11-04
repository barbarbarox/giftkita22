<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return response()->json(Kategori::with('produk')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|unique:kategoris',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori = Kategori::create($validated);
        return response()->json($kategori, 201);
    }

    public function show($id)
    {
        return response()->json(Kategori::with('produk')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->only(['nama_kategori', 'deskripsi']));
        return response()->json($kategori);
    }

    public function destroy($id)
    {
        Kategori::destroy($id);
        return response()->json(['message' => 'Kategori deleted successfully']);
    }
}
