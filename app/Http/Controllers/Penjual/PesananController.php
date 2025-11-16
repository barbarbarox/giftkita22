<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    /**
     * Tampilkan daftar semua pesanan untuk penjual yang sedang login
     */
    public function index()
    {
        $penjualId = Auth::id();

        // Ambil semua pesanan milik toko dari penjual yang login
        $pesanans = Pesanan::with(['produk.toko'])
            ->whereHas('produk.toko', function ($query) use ($penjualId) {
                $query->where('penjual_id', $penjualId);
            })
            ->orderByDesc('tanggal_pemesanan')
            ->get();

        return view('penjual.pesanan.index', compact('pesanans'));
    }

    /**
     * Tampilkan detail pesanan
     */
    public function show($id)
    {
        $penjualId = Auth::id();

        $pesanan = Pesanan::with(['produk.toko', 'produk.kategori', 'produk.files'])
            ->find($id);

        // Validasi jika pesanan tidak ditemukan
        if (!$pesanan) {
            return redirect()->route('penjual.pesanan.index')
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        // Cegah akses dari penjual lain
        if ($pesanan->produk->toko->penjual_id !== $penjualId) {
            return redirect()->route('penjual.pesanan.index')
                ->with('error', 'Anda tidak berhak melihat pesanan ini.');
        }

        return view('penjual.pesanan.show', compact('pesanan'));
    }

    /**
     * Update status pesanan (AJAX)
     */
    public function updateStatus(Request $request, $id)
    {
        $penjualId = Auth::id();

        $pesanan = Pesanan::with('produk.toko')->find($id);

        // Validasi jika pesanan tidak ditemukan
        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.'
            ], 404);
        }

        // Cegah akses dari penjual lain
        if ($pesanan->produk->toko->penjual_id !== $penjualId) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berhak memperbarui pesanan ini.'
            ], 403);
        }

        $newStatus = $request->input('status');

        // ✅ Update dengan status yang lengkap
        $validStatuses = ['pending', 'dikonfirmasi', 'diproses', 'selesai', 'dibatalkan'];
        if (!in_array($newStatus, $validStatuses)) {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak valid.'
            ], 400);
        }

        $pesanan->status = $newStatus;
        $pesanan->save();

        return response()->json([
            'success' => true,
            'message' => 'Status pesanan berhasil diperbarui.',
            'new_status' => $newStatus
        ]);
    }
}