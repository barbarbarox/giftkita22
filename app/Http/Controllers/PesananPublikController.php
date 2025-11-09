<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PesananPublikController extends Controller
{
    /**
     * Simpan pesanan dari pembeli publik (tanpa login)
     */
    public function store(Request $request)
    {
        try {
            // ✅ 1. Validasi input dari form
            $validated = $request->validate([
                'produk_id' => 'required|exists:produks,id',
                'nama_pembeli' => 'required|string|max:255',
                'email_pembeli' => 'nullable|email|max:255',
                'no_hp_pembeli' => 'required|string|max:20',
                'alamat_pembeli' => 'required|string',
                'jumlah' => 'required|integer|min:1',
            ]);

            // ✅ 2. Simpan ke database
            Pesanan::create([
                'id' => (string) Str::uuid(), // gunakan UUID sebagai id
                'produk_id' => $validated['produk_id'],
                'nama_pembeli' => $validated['nama_pembeli'],
                'email_pembeli' => $validated['email_pembeli'] ?? null,
                'no_hp_pembeli' => $validated['no_hp_pembeli'],
                'alamat_pembeli' => $validated['alamat_pembeli'],
                'jumlah' => $validated['jumlah'],
                'tanggal_pemesanan' => Carbon::now(),
                'status' => 'pending',
            ]);

            // ✅ 3. Kembalikan respon sukses ke frontend
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dikirim!',
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // ⚠️ 4a. Error validasi
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            // ⚠️ 4b. Error umum (misal kolom tidak ada, DB gagal, dll)
            Log::error('Gagal menyimpan pesanan: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan pesanan.',
                'error_detail' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
