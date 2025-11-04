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

        $validStatuses = ['pending', 'diproses', 'selesai'];
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
