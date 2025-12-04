<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class StatistikExport implements WithMultipleSheets
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

    public function sheets(): array
    {
        return [
            new RingkasanSheet($this->stats, $this->startDate, $this->endDate),
            new ProdukTerlarisSheet($this->produkTerlaris),
            new StatistikTokoSheet($this->statistikPerToko),
            new GrafikHarianSheet($this->grafikHarian),
            new GrafikBulananSheet($this->grafikBulanan),
        ];
    }
}

// ============================================
// SHEET 1: RINGKASAN STATISTIK
// ============================================
class RingkasanSheet implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    protected $stats;
    protected $startDate;
    protected $endDate;

    public function __construct($stats, $startDate, $endDate)
    {
        $this->stats = $stats;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return collect([
            [
                'Periode',
                Carbon::parse($this->startDate)->format('d M Y') . ' - ' . Carbon::parse($this->endDate)->format('d M Y')
            ],
            ['', ''],
            ['Metrik', 'Nilai'],
            ['Total Pendapatan', 'Rp ' . number_format($this->stats['total_pendapatan'], 0, ',', '.')],
            ['Total Pesanan', number_format($this->stats['total_pesanan'])],
            ['Pesanan Pending', number_format($this->stats['pesanan_pending'])],
            ['Pesanan Selesai', number_format($this->stats['pesanan_selesai'])],
            ['Total Produk', number_format($this->stats['total_produk'])],
            ['Produk Stok Habis', number_format($this->stats['produk_stok_habis'])],
            ['Rata-rata Nilai Pesanan', 'Rp ' . number_format($this->stats['rata_rata_pesanan'], 0, ',', '.')],
        ]);
    }

    public function headings(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        // Header periode
        $sheet->mergeCells('A1:B1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF4472C4');
        $sheet->getStyle('A1')->getFont()->getColor()->setARGB('FFFFFFFF');

        // Nilai periode
        $sheet->mergeCells('A2:B2');
        $sheet->getStyle('A2')->getFont()->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFD9E2F3');

        // Header tabel
        $sheet->getStyle('A4:B4')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A4:B4')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF6C757D');
        $sheet->getStyle('A4:B4')->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A4:B4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Data rows
        $sheet->getStyle('A5:B11')->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Alignment
        $sheet->getStyle('B5:B11')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        return [];
    }

    public function title(): string
    {
        return 'Ringkasan Statistik';
    }
}

// ============================================
// SHEET 2: PRODUK TERLARIS
// ============================================
class ProdukTerlarisSheet implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    protected $produkTerlaris;

    public function __construct($produkTerlaris)
    {
        $this->produkTerlaris = $produkTerlaris;
    }

    public function collection()
    {
        return $this->produkTerlaris->map(function ($produk, $index) {
            return [
                'rank' => $index + 1,
                'nama_produk' => $produk->nama,
                'nama_toko' => $produk->toko->nama_toko ?? '-',
                'kategori' => $produk->kategori->nama_kategori ?? '-',
                'total_terjual' => $produk->total_terjual,
                'total_pendapatan' => 'Rp ' . number_format($produk->total_pendapatan, 0, ',', '.'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Rank',
            'Nama Produk',
            'Nama Toko',
            'Kategori',
            'Total Terjual',
            'Total Pendapatan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header
        $sheet->getStyle('A1:F1')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A1:F1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFC000');
        $sheet->getStyle('A1:F1')->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // All data with borders
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:F' . $lastRow)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Alignment
        $sheet->getStyle('A2:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E2:F' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Top 3 highlighting
        if ($lastRow >= 2) {
            $sheet->getStyle('A2:F2')->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFD966'); // Gold
        }
        if ($lastRow >= 3) {
            $sheet->getStyle('A3:F3')->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFC0C0C0'); // Silver
        }
        if ($lastRow >= 4) {
            $sheet->getStyle('A4:F4')->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFCD7F32'); // Bronze
        }

        return [];
    }

    public function title(): string
    {
        return 'Produk Terlaris';
    }
}

// ============================================
// SHEET 3: STATISTIK PER TOKO
// ============================================
class StatistikTokoSheet implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    protected $statistikPerToko;

    public function __construct($statistikPerToko)
    {
        $this->statistikPerToko = $statistikPerToko;
    }

    public function collection()
    {
        return $this->statistikPerToko->map(function ($toko) {
            return [
                'nama_toko' => $toko->nama_toko,
                'total_produk' => $toko->produks_count,
                'total_pesanan' => $toko->pesanans_count,
                'total_pendapatan' => 'Rp ' . number_format($toko->total_pendapatan, 0, ',', '.'),
                'rata_rata_per_pesanan' => $toko->pesanans_count > 0 
                    ? 'Rp ' . number_format($toko->total_pendapatan / $toko->pesanans_count, 0, ',', '.') 
                    : 'Rp 0'
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Toko',
            'Total Produk',
            'Total Pesanan',
            'Total Pendapatan',
            'Rata-rata per Pesanan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header
        $sheet->getStyle('A1:E1')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A1:E1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF5B9BD5');
        $sheet->getStyle('A1:E1')->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // All data with borders
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:E' . $lastRow)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Alignment
        $sheet->getStyle('B2:E' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        return [];
    }

    public function title(): string
    {
        return 'Statistik Per Toko';
    }
}

// ============================================
// SHEET 4: GRAFIK PENJUALAN HARIAN
// ============================================
class GrafikHarianSheet implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    protected $grafikHarian;

    public function __construct($grafikHarian)
    {
        $this->grafikHarian = $grafikHarian;
    }

    public function collection()
    {
        return collect($this->grafikHarian)->map(function ($data) {
            return [
                'tanggal' => $data['tanggal'],
                'total_pesanan' => $data['total_pesanan'],
                'total_pendapatan' => 'Rp ' . number_format($data['total_pendapatan'], 0, ',', '.')
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Total Pesanan',
            'Total Pendapatan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header
        $sheet->getStyle('A1:C1')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A1:C1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF70AD47');
        $sheet->getStyle('A1:C1')->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A1:C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // All data with borders
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:C' . $lastRow)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Alignment
        $sheet->getStyle('B2:C' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        return [];
    }

    public function title(): string
    {
        return 'Penjualan Harian';
    }
}

// ============================================
// SHEET 5: GRAFIK PENJUALAN BULANAN
// ============================================
class GrafikBulananSheet implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    protected $grafikBulanan;

    public function __construct($grafikBulanan)
    {
        $this->grafikBulanan = $grafikBulanan;
    }

    public function collection()
    {
        return collect($this->grafikBulanan)->map(function ($data) {
            return [
                'bulan' => $data['bulan'],
                'total_pesanan' => $data['total_pesanan'],
                'total_pendapatan' => 'Rp ' . number_format($data['total_pendapatan'], 0, ',', '.')
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Bulan',
            'Total Pesanan',
            'Total Pendapatan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header
        $sheet->getStyle('A1:C1')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A1:C1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF9966FF');
        $sheet->getStyle('A1:C1')->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A1:C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // All data with borders
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:C' . $lastRow)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Alignment
        $sheet->getStyle('B2:C' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        return [];
    }

    public function title(): string
    {
        return 'Penjualan Bulanan';
    }
}