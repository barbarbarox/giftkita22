<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil ID penjual yang sedang login
        $penjualId = Auth::guard('penjual')->id();

        // Ambil semua toko milik penjual ini
        $tokoIds = DB::table('tokos')
            ->where('penjual_id', $penjualId)
            ->pluck('id')
            ->toArray();

        // 1. Hitung Total Produk (dari semua toko milik penjual)
        $totalProduk = DB::table('produks')
            ->whereIn('toko_id', $tokoIds)
            ->count();

        // 2. Hitung Total Pesanan (melalui produk yang dimiliki)
        $totalPesanan = DB::table('pesanans')
            ->join('produks', 'pesanans.produk_id', '=', 'produks.id')
            ->whereIn('produks.toko_id', $tokoIds)
            ->count();

        // 3. Hitung Jumlah Toko
        $jumlahToko = count($tokoIds);

        // 4. Data Grafik Mingguan (7 hari terakhir)
        $weekLabels = [];
        $weekData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $weekLabels[] = $date->isoFormat('ddd'); // Sen, Sel, Rab, dst
            
            $count = DB::table('pesanans')
                ->join('produks', 'pesanans.produk_id', '=', 'produks.id')
                ->whereIn('produks.toko_id', $tokoIds)
                ->whereDate('pesanans.tanggal_pemesanan', $date->toDateString())
                ->count();
            
            $weekData[] = $count;
        }

        // 5. Data Grafik Bulanan (4 minggu terakhir)
        $monthLabels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
        $monthData = [];
        
        for ($i = 3; $i >= 0; $i--) {
            $startDate = Carbon::now()->subWeeks($i)->startOfWeek();
            $endDate = Carbon::now()->subWeeks($i)->endOfWeek();
            
            $count = DB::table('pesanans')
                ->join('produks', 'pesanans.produk_id', '=', 'produks.id')
                ->whereIn('produks.toko_id', $tokoIds)
                ->whereBetween('pesanans.tanggal_pemesanan', [$startDate, $endDate])
                ->count();
            
            $monthData[] = $count;
        }

        // 6. Data Grafik Tahunan (12 bulan terakhir)
        $yearLabels = [];
        $yearData = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $yearLabels[] = $date->isoFormat('MMM'); // Jan, Feb, Mar, dst
            
            $count = DB::table('pesanans')
                ->join('produks', 'pesanans.produk_id', '=', 'produks.id')
                ->whereIn('produks.toko_id', $tokoIds)
                ->whereYear('pesanans.tanggal_pemesanan', $date->year)
                ->whereMonth('pesanans.tanggal_pemesanan', $date->month)
                ->count();
            
            $yearData[] = $count;
        }

        return view('penjual.dashboard', compact(
            'totalProduk',
            'totalPesanan',
            'jumlahToko',
            'weekLabels',
            'weekData',
            'monthLabels',
            'monthData',
            'yearLabels',
            'yearData'
        ));
    }
}