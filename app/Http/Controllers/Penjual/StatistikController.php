<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Toko;
use App\Models\Produk;
use App\Models\Pesanan;
use Carbon\Carbon;
use App\Exports\StatistikExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class StatistikController extends Controller
{
    /**
     * 📊 Tampilkan halaman statistik
     */
    public function index(Request $request)
    {
        $penjual = Auth::guard('penjual')->user();

        // Filter toko (default: semua toko)
        $tokoId = $request->input('toko_id');

        // Filter periode
        $periode = $request->input('periode', 'bulan_ini');
        [$startDate, $endDate] = $this->getPeriodeRange($periode, $request);

        // Data untuk filter dropdown
        $tokos = $penjual->tokos()->get();

        // Statistik Umum
        $stats = $this->getStatistikUmum($penjual->id, $tokoId, $startDate, $endDate);

        // Grafik Penjualan Harian (7 hari terakhir)
        $grafikHarian = $this->getGrafikHarian($penjual->id, $tokoId);

        // Grafik Penjualan Bulanan (12 bulan terakhir)
        $grafikBulanan = $this->getGrafikBulanan($penjual->id, $tokoId);

        // Produk Terlaris
        $produkTerlaris = $this->getProdukTerlaris($penjual->id, $tokoId, $startDate, $endDate);

        // Statistik Per Toko
        $statistikPerToko = $this->getStatistikPerToko($penjual->id, $startDate, $endDate);

        // Perbandingan Periode
        $perbandingan = $this->getPerbandinganPeriode($penjual->id, $tokoId, $startDate, $endDate);

        return view('penjual.statistik.index', compact(
            'stats',
            'grafikHarian',
            'grafikBulanan',
            'produkTerlaris',
            'statistikPerToko',
            'perbandingan',
            'tokos',
            'tokoId',
            'periode'
        ));
    }

    /**
     * 📈 Get periode range berdasarkan filter
     */
    private function getPeriodeRange($periode, $request)
    {
        switch ($periode) {
            case 'hari_ini':
                return [now()->startOfDay(), now()->endOfDay()];

            case 'minggu_ini':
                return [now()->startOfWeek(), now()->endOfWeek()];

            case 'bulan_ini':
                return [now()->startOfMonth(), now()->endOfMonth()];

            case 'tahun_ini':
                return [now()->startOfYear(), now()->endOfYear()];

            case 'custom':
                return [
                    Carbon::parse($request->input('start_date', now()->subMonth())),
                    Carbon::parse($request->input('end_date', now()))
                ];

            default:
                return [now()->startOfMonth(), now()->endOfMonth()];
        }
    }

    /**
     * 📊 Statistik Umum
     */
    private function getStatistikUmum($penjualId, $tokoId, $startDate, $endDate)
    {
        $query = Pesanan::query()
            ->whereHas('toko', function ($q) use ($penjualId) {
                $q->where('penjual_id', $penjualId);
            })
            ->whereBetween('tanggal_pemesanan', [$startDate, $endDate]);

        if ($tokoId) {
            $query->where('toko_id', $tokoId);
        }

        // Total Pendapatan
        $totalPendapatan = (clone $query)->where('status', 'selesai')->sum('total_harga');

        // Total Pesanan
        $totalPesanan = (clone $query)->count();

        // Pesanan Pending
        $pesananPending = (clone $query)->where('status', 'pending')->count();

        // Pesanan Selesai
        $pesananSelesai = (clone $query)->where('status', 'selesai')->count();

        // Total Produk
        $totalProduk = Produk::whereHas('toko', function ($q) use ($penjualId) {
            $q->where('penjual_id', $penjualId);
        })->when($tokoId, function ($q) use ($tokoId) {
            $q->where('toko_id', $tokoId);
        })->count();

        // Produk Stok Habis
        $produkStokHabis = Produk::whereHas('toko', function ($q) use ($penjualId) {
            $q->where('penjual_id', $penjualId);
        })->when($tokoId, function ($q) use ($tokoId) {
            $q->where('toko_id', $tokoId);
        })->where('stok', 0)->count();

        // Rata-rata Nilai Pesanan
        $rataRataPesanan = $totalPesanan > 0 ? $totalPendapatan / $totalPesanan : 0;

        return [
            'total_pendapatan' => $totalPendapatan,
            'total_pesanan' => $totalPesanan,
            'pesanan_pending' => $pesananPending,
            'pesanan_selesai' => $pesananSelesai,
            'total_produk' => $totalProduk,
            'produk_stok_habis' => $produkStokHabis,
            'rata_rata_pesanan' => $rataRataPesanan,
        ];
    }

    /**
     * 📈 Grafik Penjualan Harian (7 hari terakhir)
     */
    private function getGrafikHarian($penjualId, $tokoId)
    {
        $data = Pesanan::selectRaw('DATE(tanggal_pemesanan) as tanggal, COUNT(*) as total_pesanan, SUM(total_harga) as total_pendapatan')
            ->whereHas('toko', function ($q) use ($penjualId) {
                $q->where('penjual_id', $penjualId);
            })
            ->when($tokoId, function ($q) use ($tokoId) {
                $q->where('toko_id', $tokoId);
            })
            ->where('tanggal_pemesanan', '>=', now()->subDays(7))
            ->where('status', 'selesai')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Isi hari yang kosong dengan 0
        $result = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $item = $data->firstWhere('tanggal', $date);

            $result[] = [
                'tanggal' => Carbon::parse($date)->format('d M'),
                'total_pesanan' => $item ? $item->total_pesanan : 0,
                'total_pendapatan' => $item ? $item->total_pendapatan : 0,
            ];
        }

        return $result;
    }

    /**
     * 📊 Grafik Penjualan Bulanan (12 bulan terakhir)
     */
    private function getGrafikBulanan($penjualId, $tokoId)
    {
        $data = Pesanan::selectRaw('YEAR(tanggal_pemesanan) as tahun, MONTH(tanggal_pemesanan) as bulan, COUNT(*) as total_pesanan, SUM(total_harga) as total_pendapatan')
            ->whereHas('toko', function ($q) use ($penjualId) {
                $q->where('penjual_id', $penjualId);
            })
            ->when($tokoId, function ($q) use ($tokoId) {
                $q->where('toko_id', $tokoId);
            })
            ->where('tanggal_pemesanan', '>=', now()->subMonths(12))
            ->where('status', 'selesai')
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        // Isi bulan yang kosong dengan 0
        $result = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $tahun = $date->year;
            $bulan = $date->month;

            $item = $data->firstWhere(function ($d) use ($tahun, $bulan) {
                return $d->tahun == $tahun && $d->bulan == $bulan;
            });

            $result[] = [
                'bulan' => $date->format('M Y'),
                'total_pesanan' => $item ? $item->total_pesanan : 0,
                'total_pendapatan' => $item ? $item->total_pendapatan : 0,
            ];
        }

        return $result;
    }

    /**
     * 🏆 Produk Terlaris
     */
    private function getProdukTerlaris($penjualId, $tokoId, $startDate, $endDate, $limit = 10)
    {
        return Produk::select(
            'produks.id',
            'produks.toko_id',
            'produks.kategori_id',
            'produks.nama',
            'produks.deskripsi',
            'produks.stok',
            'produks.harga',
            'produks.created_at',
            'produks.updated_at',
            DB::raw('SUM(pesanans.jumlah) as total_terjual'),
            DB::raw('SUM(pesanans.total_harga) as total_pendapatan')
        )
            ->join('pesanans', 'produks.id', '=', 'pesanans.produk_id')
            ->whereHas('toko', function ($q) use ($penjualId) {
                $q->where('penjual_id', $penjualId);
            })
            ->when($tokoId, function ($q) use ($tokoId) {
                $q->where('produks.toko_id', $tokoId);
            })
            ->whereBetween('pesanans.tanggal_pemesanan', [$startDate, $endDate])
            ->where('pesanans.status', 'selesai')
            ->with(['toko', 'kategori'])
            ->groupBy(
                'produks.id',
                'produks.toko_id',
                'produks.kategori_id',
                'produks.nama',
                'produks.deskripsi',
                'produks.stok',
                'produks.harga',
                'produks.created_at',
                'produks.updated_at'
            )
            ->orderBy('total_terjual', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * 🏪 Statistik Per Toko
     */
    private function getStatistikPerToko($penjualId, $startDate, $endDate)
    {
        return Toko::where('penjual_id', $penjualId)
            ->withCount([
                'produks',
                'pesanans' => function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('tanggal_pemesanan', [$startDate, $endDate]);
                }
            ])
            ->withSum([
                'pesanans as total_pendapatan' => function ($q) use ($startDate, $endDate) {
                    $q->where('status', 'selesai')
                        ->whereBetween('tanggal_pemesanan', [$startDate, $endDate]);
                }
            ], 'total_harga')
            ->get()
            ->map(function ($toko) {
                $toko->total_pendapatan = $toko->total_pendapatan ?? 0;
                return $toko;
            });
    }

    /**
     * 📊 Perbandingan dengan Periode Sebelumnya
     */
    private function getPerbandinganPeriode($penjualId, $tokoId, $startDate, $endDate)
    {
        $duration = $startDate->diffInDays($endDate);
        $prevStart = $startDate->copy()->subDays($duration);
        $prevEnd = $endDate->copy()->subDays($duration);

        // Periode Sekarang
        $current = Pesanan::whereHas('toko', function ($q) use ($penjualId) {
            $q->where('penjual_id', $penjualId);
        })
            ->when($tokoId, function ($q) use ($tokoId) {
                $q->where('toko_id', $tokoId);
            })
            ->whereBetween('tanggal_pemesanan', [$startDate, $endDate])
            ->where('status', 'selesai');

        // Periode Sebelumnya
        $previous = Pesanan::whereHas('toko', function ($q) use ($penjualId) {
            $q->where('penjual_id', $penjualId);
        })
            ->when($tokoId, function ($q) use ($tokoId) {
                $q->where('toko_id', $tokoId);
            })
            ->whereBetween('tanggal_pemesanan', [$prevStart, $prevEnd])
            ->where('status', 'selesai');

        $currentPendapatan = (clone $current)->sum('total_harga');
        $previousPendapatan = (clone $previous)->sum('total_harga');

        $currentPesanan = (clone $current)->count();
        $previousPesanan = (clone $previous)->count();

        return [
            'pendapatan' => [
                'current' => $currentPendapatan,
                'previous' => $previousPendapatan,
                'percentage' => $this->calculatePercentageChange($currentPendapatan, $previousPendapatan),
            ],
            'pesanan' => [
                'current' => $currentPesanan,
                'previous' => $previousPesanan,
                'percentage' => $this->calculatePercentageChange($currentPesanan, $previousPesanan),
            ],
        ];
    }

    /**
     * 📊 Hitung persentase perubahan
     */
    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return (($current - $previous) / $previous) * 100;
    }

    /**
     * 📥 Export data statistik ke PDF
     */
    public function exportPDF(Request $request)
    {
        try {
            $penjual = Auth::guard('penjual')->user();

            // Get filter parameters
            $tokoId = $request->input('toko_id');
            $periode = $request->input('periode', 'bulan_ini');
            [$startDate, $endDate] = $this->getPeriodeRange($periode, $request);

            // Get statistics data
            $stats = $this->getStatistikUmum($penjual->id, $tokoId, $startDate, $endDate);
            $produkTerlaris = $this->getProdukTerlaris($penjual->id, $tokoId, $startDate, $endDate);
            $statistikPerToko = $this->getStatistikPerToko($penjual->id, $startDate, $endDate);

            // Generate PDF
            $pdf = Pdf::loadView('penjual.statistik.pdf', compact(
                'stats',
                'produkTerlaris',
                'statistikPerToko',
                'startDate',
                'endDate',
                'penjual'
            ));

            // Set paper size dan orientation
            $pdf->setPaper('a4', 'portrait');

            $filename = 'Statistik_Penjualan_' . date('Y-m-d_His') . '.pdf';
            return $pdf->download($filename);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal export PDF: ' . $e->getMessage());
        }
    }

    /**
     * 📥 Export data statistik ke Excel
     */
    public function exportExcel(Request $request)
    {
        try {
            $penjual = Auth::guard('penjual')->user();

            // Get filter parameters
            $tokoId = $request->input('toko_id');
            $periode = $request->input('periode', 'bulan_ini');
            [$startDate, $endDate] = $this->getPeriodeRange($periode, $request);

            // Get statistics data
            $stats = $this->getStatistikUmum($penjual->id, $tokoId, $startDate, $endDate);
            $produkTerlaris = $this->getProdukTerlaris($penjual->id, $tokoId, $startDate, $endDate);
            $statistikPerToko = $this->getStatistikPerToko($penjual->id, $startDate, $endDate);
            $grafikHarian = $this->getGrafikHarian($penjual->id, $tokoId);
            $grafikBulanan = $this->getGrafikBulanan($penjual->id, $tokoId);

            $filename = 'Statistik_Penjualan_' . date('Y-m-d_His') . '.xlsx';

            return Excel::download(
                new StatistikExport($stats, $produkTerlaris, $statistikPerToko, $grafikHarian, $grafikBulanan, $startDate, $endDate),
                $filename
            );
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal export Excel: ' . $e->getMessage());
        }
    }

    /**
     * 📥 Export data statistik sebagai gambar (HTML to Image)
     */
    public function exportImage(Request $request)
    {
        // Return view yang akan di-capture sebagai image via JavaScript
        return response()->json([
            'success' => true,
            'message' => 'Silakan gunakan browser untuk capture sebagai image (Print to PDF lalu convert)'
        ]);
    }
}