@extends('layouts.penjual')

@section('title', 'Statistik Penjualan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">📊 Statistik Penjualan</h1>
        <p class="text-gray-600">Pantau performa toko dan produk Anda secara real-time</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <form method="GET" action="{{ route('penjual.statistik') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Filter Toko -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-store text-blue-500 mr-2"></i>Filter Toko
                </label>
                <select name="toko_id" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                    <option value="">Semua Toko</option>
                    @foreach($tokos as $toko)
                        <option value="{{ $toko->id }}" {{ request('toko_id') == $toko->id ? 'selected' : '' }}>
                            {{ $toko->nama_toko }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Periode -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-calendar text-purple-500 mr-2"></i>Periode
                </label>
                <select name="periode" id="periode" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all">
                    <option value="hari_ini" {{ $periode == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="minggu_ini" {{ $periode == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="bulan_ini" {{ $periode == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="tahun_ini" {{ $periode == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                    <option value="custom" {{ $periode == 'custom' ? 'selected' : '' }}>Custom</option>
                </select>
            </div>

            <!-- Button Filter -->
            <div class="flex items-end">
                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white font-bold py-3 px-6 rounded-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                    <i class="fas fa-filter mr-2"></i>Terapkan Filter
                </button>
            </div>
        </form>

        <!-- Custom Date Range (Hidden by default) -->
        <div id="customDateRange" class="mt-4 hidden grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Pendapatan -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white/20 p-3 rounded-lg">
                    <i class="fas fa-money-bill-wave text-2xl"></i>
                </div>
                @if($perbandingan['pendapatan']['percentage'] > 0)
                    <span class="bg-white/30 px-3 py-1 rounded-full text-sm font-semibold">
                        <i class="fas fa-arrow-up"></i> {{ number_format($perbandingan['pendapatan']['percentage'], 1) }}%
                    </span>
                @elseif($perbandingan['pendapatan']['percentage'] < 0)
                    <span class="bg-white/30 px-3 py-1 rounded-full text-sm font-semibold">
                        <i class="fas fa-arrow-down"></i> {{ number_format(abs($perbandingan['pendapatan']['percentage']), 1) }}%
                    </span>
                @endif
            </div>
            <h3 class="text-white/80 text-sm font-medium mb-1">Total Pendapatan</h3>
            <p class="text-3xl font-bold">Rp {{ number_format($stats['total_pendapatan'], 0, ',', '.') }}</p>
            <p class="text-white/70 text-xs mt-2">Dari pesanan selesai</p>
        </div>

        <!-- Total Pesanan -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white/20 p-3 rounded-lg">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
                @if($perbandingan['pesanan']['percentage'] > 0)
                    <span class="bg-white/30 px-3 py-1 rounded-full text-sm font-semibold">
                        <i class="fas fa-arrow-up"></i> {{ number_format($perbandingan['pesanan']['percentage'], 1) }}%
                    </span>
                @elseif($perbandingan['pesanan']['percentage'] < 0)
                    <span class="bg-white/30 px-3 py-1 rounded-full text-sm font-semibold">
                        <i class="fas fa-arrow-down"></i> {{ number_format(abs($perbandingan['pesanan']['percentage']), 1) }}%
                    </span>
                @endif
            </div>
            <h3 class="text-white/80 text-sm font-medium mb-1">Total Pesanan</h3>
            <p class="text-3xl font-bold">{{ number_format($stats['total_pesanan']) }}</p>
            <p class="text-white/70 text-xs mt-2">Semua status</p>
        </div>

        <!-- Pesanan Pending -->
        <div class="bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white/20 p-3 rounded-lg">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
            </div>
            <h3 class="text-white/80 text-sm font-medium mb-1">Pesanan Pending</h3>
            <p class="text-3xl font-bold">{{ number_format($stats['pesanan_pending']) }}</p>
            <p class="text-white/70 text-xs mt-2">Perlu diproses</p>
        </div>

        <!-- Rata-rata Pesanan -->
        <div class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white/20 p-3 rounded-lg">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
            </div>
            <h3 class="text-white/80 text-sm font-medium mb-1">Rata-rata Nilai Pesanan</h3>
            <p class="text-3xl font-bold">Rp {{ number_format($stats['rata_rata_pesanan'], 0, ',', '.') }}</p>
            <p class="text-white/70 text-xs mt-2">Per transaksi</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Grafik Penjualan Harian -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-chart-line text-blue-500 mr-2"></i>Penjualan 7 Hari Terakhir
            </h3>
            <canvas id="grafikHarian"></canvas>
        </div>

        <!-- Grafik Penjualan Bulanan -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-chart-bar text-purple-500 mr-2"></i>Penjualan 12 Bulan Terakhir
            </h3>
            <canvas id="grafikBulanan"></canvas>
        </div>
    </div>

    <!-- Produk Terlaris & Statistik Per Toko -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Produk Terlaris -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-trophy text-yellow-500 mr-2"></i>Top 10 Produk Terlaris
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Rank</th>
                            <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Produk</th>
                            <th class="text-right py-3 px-2 text-sm font-semibold text-gray-600">Terjual</th>
                            <th class="text-right py-3 px-2 text-sm font-semibold text-gray-600">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produkTerlaris as $index => $produk)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="py-3 px-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full 
                                    {{ $index == 0 ? 'bg-yellow-100 text-yellow-600' : ($index == 1 ? 'bg-gray-100 text-gray-600' : ($index == 2 ? 'bg-orange-100 text-orange-600' : 'bg-blue-50 text-blue-600')) }} 
                                    font-bold text-sm">
                                    {{ $index + 1 }}
                                </span>
                            </td>
                            <td class="py-3 px-2">
                                <p class="font-semibold text-gray-800 text-sm">{{ $produk->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $produk->toko->nama_toko }}</p>
                            </td>
                            <td class="py-3 px-2 text-right">
                                <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ number_format($produk->total_terjual) }} pcs
                                </span>
                            </td>
                            <td class="py-3 px-2 text-right">
                                <span class="text-green-600 font-bold text-sm">
                                    Rp {{ number_format($produk->total_pendapatan, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2"></i>
                                <p>Belum ada data penjualan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Statistik Per Toko -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-store text-indigo-500 mr-2"></i>Performa Per Toko
            </h3>
            <div class="space-y-4">
                @forelse($statistikPerToko as $toko)
                <div class="border-2 border-gray-100 rounded-lg p-4 hover:border-blue-300 transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="font-bold text-gray-800">{{ $toko->nama_toko }}</h4>
                        <span class="bg-gradient-to-r from-blue-500 to-purple-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $toko->produks_count }} Produk
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Total Pesanan</p>
                            <p class="text-lg font-bold text-blue-600">{{ number_format($toko->pesanans_count) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Total Pendapatan</p>
                            <p class="text-lg font-bold text-green-600">Rp {{ number_format($toko->total_pendapatan, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-store-slash text-4xl mb-2"></i>
                    <p>Belum ada toko</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Additional Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Total Produk -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-blue-100 p-3 rounded-lg">
                    <i class="fas fa-box text-blue-600 text-2xl"></i>
                </div>
                <span class="text-3xl font-bold text-gray-800">{{ number_format($stats['total_produk']) }}</span>
            </div>
            <h3 class="text-gray-600 font-semibold">Total Produk</h3>
            <p class="text-sm text-gray-500 mt-1">Produk aktif di semua toko</p>
        </div>

        <!-- Pesanan Selesai -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-green-100 p-3 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
                <span class="text-3xl font-bold text-green-600">{{ number_format($stats['pesanan_selesai']) }}</span>
            </div>
            <h3 class="text-gray-600 font-semibold">Pesanan Selesai</h3>
            <p class="text-sm text-gray-500 mt-1">Transaksi berhasil</p>
        </div>
    </div>

    <!-- Export Buttons -->
    <div class="mt-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg p-6">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-white">
                <h3 class="text-xl font-bold mb-1">
                    <i class="fas fa-download mr-2"></i>Export Laporan Statistik
                </h3>
                <p class="text-blue-100 text-sm">Unduh laporan mu tinggal sat set</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <button onclick="exportPDF()" class="bg-white text-red-600 px-6 py-3 rounded-lg font-semibold hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                    <i class="fas fa-file-pdf mr-2"></i>Cetak laporan
                </button>
                <button onclick="exportImage()" class="bg-white text-purple-600 px-6 py-3 rounded-lg font-semibold hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                    <i class="fas fa-file-image mr-2"></i>Cetak PDF
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Toggle Custom Date Range
    document.getElementById('periode').addEventListener('change', function() {
        const customRange = document.getElementById('customDateRange');
        if (this.value === 'custom') {
            customRange.classList.remove('hidden');
        } else {
            customRange.classList.add('hidden');
        }
    });

    // Grafik Penjualan Harian
    const grafikHarianCtx = document.getElementById('grafikHarian').getContext('2d');
    new Chart(grafikHarianCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($grafikHarian, 'tanggal')) !!},
            datasets: [{
                label: 'Total Pesanan',
                data: {!! json_encode(array_column($grafikHarian, 'total_pesanan')) !!},
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Grafik Penjualan Bulanan
    const grafikBulananCtx = document.getElementById('grafikBulanan').getContext('2d');
    new Chart(grafikBulananCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($grafikBulanan, 'bulan')) !!},
            datasets: [{
                label: 'Total Pendapatan',
                data: {!! json_encode(array_column($grafikBulanan, 'total_pendapatan')) !!},
                backgroundColor: 'rgba(147, 51, 234, 0.8)',
                borderColor: 'rgb(147, 51, 234)',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
<script>
    // Fungsi untuk mendapatkan parameter filter saat ini
    function getCurrentFilters() {
        const urlParams = new URLSearchParams(window.location.search);
        return {
            toko_id: urlParams.get('toko_id') || '',
            periode: urlParams.get('periode') || 'bulan_ini',
            start_date: urlParams.get('start_date') || '',
            end_date: urlParams.get('end_date') || ''
        };
    }

    // Export ke PDF
    function exportPDF() {
        const filters = getCurrentFilters();
        const params = new URLSearchParams();
        
        if (filters.toko_id) params.append('toko_id', filters.toko_id);
        params.append('periode', filters.periode);
        if (filters.start_date) params.append('start_date', filters.start_date);
        if (filters.end_date) params.append('end_date', filters.end_date);
        
        const url = `{{ route('penjual.statistik.export.pdf') }}?${params.toString()}`;
        window.location.href = url;
    }

    // Export ke Excel
    function exportExcel() {
        const filters = getCurrentFilters();
        const params = new URLSearchParams();
        
        if (filters.toko_id) params.append('toko_id', filters.toko_id);
        params.append('periode', filters.periode);
        if (filters.start_date) params.append('start_date', filters.start_date);
        if (filters.end_date) params.append('end_date', filters.end_date);
        
        const url = `{{ route('penjual.statistik.export.excel') }}?${params.toString()}`;
        window.location.href = url;
    }

    // Export ke Word (alternatif via PDF)
    function exportWord() {
        if (confirm('💡 Tips: Export ke PDF terlebih dahulu, lalu buka file PDF tersebut di Microsoft Word untuk mengedit lebih lanjut.\n\nLanjutkan export PDF?')) {
            exportPDF();
        }
    }

    // Export sebagai Image (menggunakan Print)
    function exportImage() {
        if (confirm('📸 Gunakan fungsi Print pada browser (Ctrl+P / Cmd+P) dan pilih:\n\n✅ "Save as PDF" untuk hasil terbaik\n✅ "Microsoft Print to PDF"\n✅ Atau screenshot manual\n\nLanjutkan ke halaman print?')) {
            window.print();
        }
    }

    // Optional: Tambahkan loading indicator saat export
    function showLoadingExport(message = 'Sedang memproses export...') {
        // Bisa ditambahkan loading overlay jika diinginkan
        console.log(message);
    }
</script>
@endsection