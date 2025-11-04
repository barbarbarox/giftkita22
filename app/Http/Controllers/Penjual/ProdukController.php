<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Toko;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    /**
     * Tampilkan semua produk milik penjual yang login
     */
    public function index()
    {
        $penjual = Auth::user();

        // Ambil semua toko milik penjual
        $tokoIds = $penjual->tokos->pluck('id');

        // Ambil semua produk dari toko-toko tersebut
        $produks = Produk::whereIn('toko_id', $tokoIds)
            ->with(['kategori', 'toko', 'files'])
            ->latest()
            ->get();

        return view('penjual.produk.index', compact('produks'));
    }

    /**
     * Form tambah produk baru
     */
    public function create()
    {
        $penjual = Auth::user();
        $kategoris = Kategori::all();
        $tokos = $penjual->tokos; // Semua toko milik penjual

        return view('penjual.produk.create', compact('kategoris', 'tokos'));
    }

    /**
     * Simpan produk baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'toko_id' => 'required|exists:tokos,id',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,webm,avi|max:51200', // max 50MB
        ]);

        // Pastikan toko benar-benar milik penjual
        $penjual = Auth::user();
        if (!$penjual->tokos->pluck('id')->contains($validated['toko_id'])) {
            abort(403, 'Anda tidak berhak menambahkan produk ke toko ini.');
        }

        $produk = Produk::create([
            'toko_id' => $validated['toko_id'],
            'kategori_id' => $validated['kategori_id'],
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'stok' => $validated['stok'],
            'harga' => $validated['harga'],
        ]);

        // Simpan file ke storage dan tabel files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('produk', 'public');
                $produk->files()->create(['filepath' => $path]);
            }
        }

        return redirect()
            ->route('penjual.produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Form edit produk
     */
    public function edit(Produk $produk)
    {
        $penjual = Auth::user();

        // Cegah edit produk yang bukan milik toko penjual
        if (!$penjual->tokos->pluck('id')->contains($produk->toko_id)) {
            abort(403, 'Anda tidak berhak mengedit produk ini.');
        }

        $kategoris = Kategori::all();
        $tokos = $penjual->tokos;
        $produk->load('files');

        return view('penjual.produk.edit', compact('produk', 'kategoris', 'tokos'));
    }

    /**
     * Update data produk
     */
    public function update(Request $request, Produk $produk)
    {
        $penjual = Auth::user();

        // Cegah update produk milik toko lain
        if (!$penjual->tokos->pluck('id')->contains($produk->toko_id)) {
            abort(403, 'Anda tidak berhak mengubah produk ini.');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'toko_id' => 'required|exists:tokos,id',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,webm,avi|max:51200',
            'hapus_file.*' => 'nullable|uuid',
        ]);

        $produk->update([
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'kategori_id' => $validated['kategori_id'],
            'toko_id' => $validated['toko_id'],
        ]);

        // Hapus file lama
        if ($request->filled('hapus_file')) {
            foreach ($request->hapus_file as $fileId) {
                $file = $produk->files()->find($fileId);
                if ($file) {
                    Storage::disk('public')->delete($file->filepath);
                    $file->delete();
                }
            }
        }

        // Upload file baru
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('produk', 'public');
                $produk->files()->create(['filepath' => $path]);
            }
        }

        return redirect()
            ->route('penjual.produk.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Hapus produk beserta semua file-nya
     */
    public function destroy(Produk $produk)
    {
        $penjual = Auth::user();

        // Pastikan produk milik toko penjual
        if (!$penjual->tokos->pluck('id')->contains($produk->toko_id)) {
            abort(403, 'Anda tidak berhak menghapus produk ini.');
        }

        foreach ($produk->files as $file) {
            Storage::disk('public')->delete($file->filepath);
            $file->delete();
        }

        $produk->delete();

        return redirect()
            ->route('penjual.produk.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
