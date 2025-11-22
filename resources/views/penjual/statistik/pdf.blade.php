<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Statistik Penjualan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0 0 8px 0;
            color: #1e40af;
            font-size: 20px;
        }
        .header p {
            margin: 3px 0;
            color: #6b7280;
            font-size: 10px;
        }
        .info-section {
            background: #f3f4f6;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            border-left: 4px solid #3b82f6;
        }
        .info-section h3 {
            font-size: 12px;
            color: #1e40af;
            margin-bottom: 8px;
        }
        .stats-grid {
            width: 100%;
            margin-bottom: 20px;
        }
        .stats-grid table {
            width: 100%;
            border-collapse: collapse;
        }
        .stats-grid td {
            padding: 8px;
            border: 1px solid #e5e7eb;
        }
        .stats-grid .label {
            font-weight: bold;
            width: 50%;
            background: #f9fafb;
        }
        .stats-grid .value {
            text-align: right;
            color: #1e40af;
            font-weight: bold;
        }
        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #1e40af;
            margin: 20px 0 10px 0;
            padding-bottom: 6px;
            border-bottom: 2px solid #3b82f6;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        table.data-table thead {
            background: #3b82f6;
            color: white;
        }
        table.data-table th {
            padding: 8px 6px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
        }
        table.data-table td {
            padding: 7px 6px;
            border: 1px solid #e5e7eb;
            font-size: 10px;
        }
        table.data-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-success {
            background: #dcfce7;
            color: #166534;
        }
        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }
        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }
        .highlight {
            color: #10b981;
            font-weight: bold;
        }
        .rank-badge {
            display: inline-block;
            width: 24px;
            height: 24px;
            line-height: 24px;
            text-align: center;
            border-radius: 50%;
            font-weight: bold;
            font-size: 10px;
        }
        .rank-1 {
            background: #fef3c7;
            color: #92400e;
        }
        .rank-2 {
            background: #e5e7eb;
            color: #374151;
        }
        .rank-3 {
            background: #fed7aa;
            color: #9a3412;
        }
        .rank-other {
            background: #dbeafe;
            color: #1e40af;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN STATISTIK PENJUALAN</h1>
        <p><strong>{{ $penjual->nama }}</strong></p>
        <p>Periode: {{ $startDate->format('d F Y') }} - {{ $endDate->format('d F Y') }}</p>
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }} WIB</p>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <h3>Informasi Laporan</h3>
        <p>Laporan ini berisi ringkasan statistik penjualan untuk periode yang dipilih, termasuk data pendapatan, pesanan, produk terlaris, dan performa per toko.</p>
    </div>

    <!-- Statistik Umum -->
    <div class="section-title">Ringkasan Statistik</div>
    <div class="stats-grid">
        <table>
            <tr>
                <td class="label">Total Pendapatan</td>
                <td class="value highlight">Rp {{ number_format($stats['total_pendapatan'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Total Pesanan</td>
                <td class="value">{{ number_format($stats['total_pesanan']) }}</td>
            </tr>
            <tr>
                <td class="label">Pesanan Selesai</td>
                <td class="value" style="color: #10b981;">{{ number_format($stats['pesanan_selesai']) }}</td>
            </tr>
            <tr>
                <td class="label">Pesanan Pending</td>
                <td class="value" style="color: #f59e0b;">{{ number_format($stats['pesanan_pending']) }}</td>
            </tr>
            <tr>
                <td class="label">Rata-rata Nilai Pesanan</td>
                <td class="value">Rp {{ number_format($stats['rata_rata_pesanan'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Total Produk</td>
                <td class="value">{{ number_format($stats['total_produk']) }}</td>
            </tr>
        </table>
    </div>

    <!-- Produk Terlaris -->
    <div class="section-title">Top 10 Produk Terlaris</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 8%;" class="text-center">Rank</th>
                <th style="width: 35%;">Nama Produk</th>
                <th style="width: 22%;">Toko</th>
                <th style="width: 15%;" class="text-center">Terjual</th>
                <th style="width: 20%;" class="text-right">Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produkTerlaris as $index => $produk)
            <tr>
                <td class="text-center">
                    <span class="rank-badge {{ $index == 0 ? 'rank-1' : ($index == 1 ? 'rank-2' : ($index == 2 ? 'rank-3' : 'rank-other')) }}">
                        {{ $index + 1 }}
                    </span>
                </td>
                <td><strong>{{ $produk->nama }}</strong></td>
                <td>{{ $produk->toko->nama_toko }}</td>
                <td class="text-center">
                    <span class="badge badge-info">{{ number_format($produk->total_terjual) }} pcs</span>
                </td>
                <td class="text-right highlight">
                    Rp {{ number_format($produk->total_pendapatan, 0, ',', '.') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 20px; color: #6b7280;">
                    Tidak ada data produk terlaris
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Statistik Per Toko -->
    <div class="section-title">Performa Per Toko</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 35%;">Nama Toko</th>
                <th style="width: 20%;" class="text-center">Jumlah Produk</th>
                <th style="width: 20%;" class="text-center">Total Pesanan</th>
                <th style="width: 25%;" class="text-right">Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($statistikPerToko as $toko)
            <tr>
                <td><strong>{{ $toko->nama_toko }}</strong></td>
                <td class="text-center">
                    <span class="badge badge-info">{{ number_format($toko->produks_count) }}</span>
                </td>
                <td class="text-center">{{ number_format($toko->pesanans_count) }}</td>
                <td class="text-right highlight">
                    Rp {{ number_format($toko->total_pendapatan, 0, ',', '.') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center" style="padding: 20px; color: #6b7280;">
                    Tidak ada data toko
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Summary Footer -->
    <div class="info-section" style="margin-top: 30px;">
        <h3>Catatan</h3>
        <ul style="margin-left: 20px; margin-top: 8px;">
            <li>Semua data dalam laporan ini diambil dari periode {{ $startDate->format('d F Y') }} hingga {{ $endDate->format('d F Y') }}</li>
            <li>Pendapatan yang tercatat hanya dari pesanan dengan status "Selesai"</li>
            <li>Produk terlaris diurutkan berdasarkan jumlah unit terjual</li>
        </ul>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Laporan ini digenerate secara otomatis oleh sistem</strong></p>
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
    </div>
</body>
</html>