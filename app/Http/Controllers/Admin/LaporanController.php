<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanPenjual;
use App\Models\Penjual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    /**
     * Display a listing of laporan
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        $kategori = $request->input('kategori');
        $search = $request->input('search');

        $laporan = LaporanPenjual::with(['penjual.toko'])
            ->when($status, function($q) use ($status) {
                $q->where('status', $status);
            })
            ->when($kategori, function($q) use ($kategori) {
                $q->where('kategori', $kategori);
            })
            ->when($search, function($q) use ($search) {
                $q->where(function($query) use ($search) {
                    $query->where('nama_pelapor', 'like', "%{$search}%")
                          ->orWhere('email_pelapor', 'like', "%{$search}%")
                          ->orWhere('deskripsi', 'like', "%{$search}%")
                          ->orWhereHas('penjual', function($q) use ($search) {
                              $q->where('username', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                          });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Statistik
        $stats = [
            'total' => LaporanPenjual::count(),
            'pending' => LaporanPenjual::where('status', 'pending')->count(),
            'ditinjau' => LaporanPenjual::where('status', 'ditinjau')->count(),
            'selesai' => LaporanPenjual::where('status', 'selesai')->count(),
            'ditolak' => LaporanPenjual::where('status', 'ditolak')->count(),
        ];

        return view('admin.laporan.index', compact('laporan', 'stats', 'status', 'kategori', 'search'));
    }

    /**
     * Display the specified laporan
     */
    public function show($id)
    {
        $laporan = LaporanPenjual::with(['penjual.toko', 'penjual.laporanPenjuals'])
            ->findOrFail($id);

        // Riwayat laporan penjual ini
        $riwayatLaporan = LaporanPenjual::where('penjual_id', $laporan->penjual_id)
            ->where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.laporan.show', compact('laporan', 'riwayatLaporan'));
    }

    /**
     * Update status laporan
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,ditinjau,selesai,ditolak',
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        $laporan = LaporanPenjual::findOrFail($id);
        
        $laporan->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
            'ditinjau_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui!');
    }

    /**
     * Bulk action untuk laporan
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'laporan_ids' => 'required|array',
            'laporan_ids.*' => 'exists:laporan_penjuals,id',
            'action' => 'required|in:ditinjau,selesai,ditolak,delete',
        ]);

        $laporanIds = $request->laporan_ids;
        $action = $request->action;

        if ($action === 'delete') {
            LaporanPenjual::whereIn('id', $laporanIds)->delete();
            $message = 'Laporan berhasil dihapus!';
        } else {
            LaporanPenjual::whereIn('id', $laporanIds)->update([
                'status' => $action,
                'ditinjau_at' => now(),
            ]);
            $message = "Status laporan berhasil diubah menjadi {$action}!";
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Delete laporan
     */
    public function destroy($id)
    {
        $laporan = LaporanPenjual::findOrFail($id);
        
        // Hapus file bukti jika ada
        if ($laporan->bukti_file && \Storage::disk('public')->exists($laporan->bukti_file)) {
            \Storage::disk('public')->delete($laporan->bukti_file);
        }
        
        $laporan->delete();

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil dihapus!');
    }

    /**
     * Statistik laporan per penjual
     */
    public function statistik()
    {
        // Penjual dengan laporan terbanyak
        $penjualBermasalah = Penjual::withCount([
                'laporanPenjuals',
                'laporanPenjuals as laporan_pending_count' => function($q) {
                    $q->where('status', 'pending');
                }
            ])
            ->having('laporan_penjuals_count', '>', 0)
            ->orderBy('laporan_penjuals_count', 'desc')
            ->limit(20)
            ->get();

        // Laporan per kategori
        $laporanPerKategori = LaporanPenjual::selectRaw('kategori, COUNT(*) as total')
            ->groupBy('kategori')
            ->get()
            ->mapWithKeys(function($item) {
                return [$item->kategori => $item->total];
            });

        // Laporan per status
        $laporanPerStatus = LaporanPenjual::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function($item) {
                return [$item->status => $item->total];
            });

        // Trend laporan (30 hari terakhir)
        $trendLaporan = LaporanPenjual::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('admin.laporan.statistik', compact(
            'penjualBermasalah',
            'laporanPerKategori',
            'laporanPerStatus',
            'trendLaporan'
        ));
    }
}