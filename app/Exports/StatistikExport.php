<?php

namespace App\Exports;

use Carbon\Carbon;

class StatistikExport
{
    protected $stats;
    protected $produkTerlaris;
    protected $statistikPerToko;
    protected $grafikHarian;
    protected $grafikBulanan;
    protected $startDate;
    protected $endDate;

    public function __construct($stats, $produkTerlaris, $statistikPerToko, $grafikHarian, $grafikBulanan, $startDate, $endDate)
    {
        $this->stats = $stats;
        $this->produkTerlaris = $produkTerlaris;
        $this->statistikPerToko = $statistikPerToko;
        $this->grafikHarian = $grafikHarian;
        $this->grafikBulanan = $grafikBulanan;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Generate data untuk export
     */
    public function generateData()
    {
        $data = [];

        // ========================================
        // SHEET 1: RINGKASAN STATISTIK
        // ========================================
        $data[] = [
            'Sheet' => 'Ringkasan',
            'Data' => $this->getRingkasanData()
        ];

        // ========================================
        // SHEET 2: PRODUK TERLARIS
        // ========================================
        $data[] = [
            'Sheet' => 'Produk Terlaris',
            'Data' => $this->getProdukTerlarisData()
        ];

        // ========================================
        // SHEET 3: STATISTIK PER TOKO
        // ========================================
        $data[] = [
            'Sheet' => 'Per Toko',
            'Data' => $this->getStatistikPerTokoData()
        ];

        // ========================================
        // SHEET 4: GRAFIK HARIAN
        // ========================================
        $data[] = [
            'Sheet' => 'Penjualan Harian',
            'Data' => $this->getGrafikHarianData()
        ];

        // ========================================
        // SHEET 5: GRAFIK BULANAN
        // ========================================
        $data[] = [
            'Sheet' => 'Penjualan Bulanan',
            'Data' => $this->getGrafikBulananData()
        ];

        return $data;
    }

    /**
     * Sheet 1: Ringkasan Statistik
     */
    private function getRingkasanData()
    {
        return [
            // Header Info
            ['LAPORAN STATISTIK PENJUALAN'],
            ['Periode', Carbon::parse($this->startDate)->format('d M Y') . ' - ' . Carbon::parse($this->endDate)->format('d M Y')],
            ['Tanggal Export', now()->format('d M Y H:i')],
            [''], // Baris kosong

            // Ringkasan Pendapatan
            ['RINGKASAN PENDAPATAN'],
            ['Metrik', 'Nilai'],
            ['Total Pendapatan', 'Rp ' . number_format($this->stats['total_pendapatan'], 0, ',', '.')],
            ['Total Pesanan', number_format($this->stats['total_pesanan'])],
            ['Rata-rata Nilai Pesanan', 'Rp ' . number_format($this->stats['rata_rata_pesanan'], 0, ',', '.')],
            [''], // Baris kosong

            // Status Pesanan
            ['STATUS PESANAN'],
            ['Status', 'Jumlah'],
            ['Pending', number_format($this->stats['pesanan_pending'])],
            ['Selesai', number_format($this->stats['pesanan_selesai'])],
            [''], // Baris kosong

            // Informasi Produk
            ['INFORMASI PRODUK'],
            ['Metrik', 'Nilai'],
            ['Total Produk Aktif', number_format($this->stats['total_produk'])],
            ['Produk Stok Habis', number_format($this->stats['produk_stok_habis'])],
        ];
    }

    /**
     * Sheet 2: Produk Terlaris
     */
    private function getProdukTerlarisData()
    {
        $data = [
            ['TOP 10 PRODUK TERLARIS'],
            ['Periode', Carbon::parse($this->startDate)->format('d M Y') . ' - ' . Carbon::parse($this->endDate)->format('d M Y')],
            [''], // Baris kosong
            ['Rank', 'Nama Produk', 'Toko', 'Kategori', 'Harga', 'Total Terjual', 'Total Pendapatan']
        ];

        foreach ($this->produkTerlaris as $index => $produk) {
            $data[] = [
                $index + 1,
                $produk->nama,
                $produk->toko->nama_toko ?? '-',
                $produk->kategori->nama_kategori ?? '-',
                'Rp ' . number_format($produk->harga, 0, ',', '.'),
                number_format($produk->total_terjual) . ' pcs',
                'Rp ' . number_format($produk->total_pendapatan, 0, ',', '.')
            ];
        }

        // Tambahkan total
        $totalTerjual = $this->produkTerlaris->sum('total_terjual');
        $totalPendapatan = $this->produkTerlaris->sum('total_pendapatan');
        
        $data[] = ['', '', '', '', 'TOTAL', number_format($totalTerjual) . ' pcs', 'Rp ' . number_format($totalPendapatan, 0, ',', '.')];

        return $data;
    }

    /**
     * Sheet 3: Statistik Per Toko
     */
    private function getStatistikPerTokoData()
    {
        $data = [
            ['STATISTIK PER TOKO'],
            ['Periode', Carbon::parse($this->startDate)->format('d M Y') . ' - ' . Carbon::parse($this->endDate)->format('d M Y')],
            [''], // Baris kosong
            ['Nama Toko', 'Total Produk', 'Total Pesanan', 'Total Pendapatan', 'Rata-rata per Pesanan']
        ];

        foreach ($this->statistikPerToko as $toko) {
            $rataRata = $toko->pesanans_count > 0 ? $toko->total_pendapatan / $toko->pesanans_count : 0;
            
            $data[] = [
                $toko->nama_toko,
                number_format($toko->produks_count),
                number_format($toko->pesanans_count),
                'Rp ' . number_format($toko->total_pendapatan, 0, ',', '.'),
                'Rp ' . number_format($rataRata, 0, ',', '.')
            ];
        }

        // Tambahkan total
        $totalProduk = $this->statistikPerToko->sum('produks_count');
        $totalPesanan = $this->statistikPerToko->sum('pesanans_count');
        $totalPendapatan = $this->statistikPerToko->sum('total_pendapatan');
        
        $data[] = ['TOTAL', number_format($totalProduk), number_format($totalPesanan), 'Rp ' . number_format($totalPendapatan, 0, ',', '.'), ''];

        return $data;
    }

    /**
     * Sheet 4: Grafik Penjualan Harian
     */
    private function getGrafikHarianData()
    {
        $data = [
            ['PENJUALAN HARIAN (7 HARI TERAKHIR)'],
            [''], // Baris kosong
            ['Tanggal', 'Total Pesanan', 'Total Pendapatan']
        ];

        foreach ($this->grafikHarian as $item) {
            $data[] = [
                $item['tanggal'],
                number_format($item['total_pesanan']),
                'Rp ' . number_format($item['total_pendapatan'], 0, ',', '.')
            ];
        }

        // Tambahkan total
        $totalPesanan = array_sum(array_column($this->grafikHarian, 'total_pesanan'));
        $totalPendapatan = array_sum(array_column($this->grafikHarian, 'total_pendapatan'));
        
        $data[] = ['TOTAL', number_format($totalPesanan), 'Rp ' . number_format($totalPendapatan, 0, ',', '.')];

        return $data;
    }

    /**
     * Sheet 5: Grafik Penjualan Bulanan
     */
    private function getGrafikBulananData()
    {
        $data = [
            ['PENJUALAN BULANAN (12 BULAN TERAKHIR)'],
            [''], // Baris kosong
            ['Bulan', 'Total Pesanan', 'Total Pendapatan']
        ];

        foreach ($this->grafikBulanan as $item) {
            $data[] = [
                $item['bulan'],
                number_format($item['total_pesanan']),
                'Rp ' . number_format($item['total_pendapatan'], 0, ',', '.')
            ];
        }

        // Tambahkan total
        $totalPesanan = array_sum(array_column($this->grafikBulanan, 'total_pesanan'));
        $totalPendapatan = array_sum(array_column($this->grafikBulanan, 'total_pendapatan'));
        
        $data[] = ['TOTAL', number_format($totalPesanan), 'Rp ' . number_format($totalPendapatan, 0, ',', '.')];

        return $data;
    }
}