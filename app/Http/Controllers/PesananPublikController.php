<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PesananPublikController extends Controller
{
    public function store(Request $request)
    {
        try {
            // ✅ Validasi input
            $validated = $request->validate([
                'produk_id' => 'required|exists:produks,id',
                'nama_pembeli' => 'required|string|max:255',
                'email_pembeli' => 'nullable|email|max:255',
                'no_hp_pembeli' => 'required|string|max:20',
                'alamat_pembeli' => 'required|string',
                'jumlah' => 'required|integer|min:1',
            ]);

            // ✅ Simpan pesanan ke database dengan UUID
            Pesanan::create([
                'id' => (string) Str::uuid(),
                'produk_id' => $validated['produk_id'],
                'nama_pembeli' => $validated['nama_pembeli'],
                'email_pembeli' => $validated['email_pembeli'] ?? null,
                'no_hp_pembeli' => $validated['no_hp_pembeli'],
                'alamat_pembeli' => $validated['alamat_pembeli'],
                'jumlah' => $validated['jumlah'],
                'tanggal_pemesanan' => Carbon::now(),
                'status' => 'pending',
            ]);

            // ✅ Response sukses ke frontend
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dikirim!',
            ], 200);

        } catch (\Exception $e) {
            // ❌ Tangani error
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan pesanan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
