@extends('layouts.penjual')

@section('title', 'Dashboard Penjual | GiftKita Seller')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    {{-- Judul --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Penjual</h1>
        <p class="text-gray-500">Selamat datang kembali, {{ Auth::user()->nama ?? 'Penjual' }} 👋</p>
    </div>

    {{-- Statistik Utama --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        {{-- Jumlah Produk --}}
        <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-[#007daf]">
            <h2 class="text-gray-600 mb-3">Total Produk</h2>
            <p class="text-4xl font-bold text-gray-800">{{ $totalProduk ?? 0 }}</p>
            <a href="{{ route('penjual.produk.index') }}" 
               class="inline-block mt-4 text-[#007daf] hover:underline font-medium">
                Lihat Produk →
            </a>
        </div>

        {{-- Jumlah Pesanan --}}
        <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-[#c771d4]">
            <h2 class="text-gray-600 mb-3">Total Pesanan</h2>
            <p class="text-4xl font-bold text-gray-800">{{ $totalPesanan ?? 0 }}</p>
            <a href="{{ route('penjual.pesanan.index') }}" 
               class="inline-block mt-4 text-[#c771d4] hover:underline font-medium">
                Lihat Pesanan →
            </a>
        </div>

        {{-- Jumlah Toko --}}
        <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-[#ffb829]">
            <h2 class="text-gray-600 mb-3">Jumlah Toko</h2>
            <p class="text-4xl font-bold text-gray-800">{{ $jumlahToko ?? 0 }}</p>
            <a href="{{ route('penjual.toko.index') }}" 
               class="inline-block mt-4 text-[#ffb829] hover:underline font-medium">
                Kelola Toko →
            </a>
        </div>
    </div>

    {{-- Performa Penjualan --}}
    <div class="bg-white shadow-md rounded-xl p-6 mt-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Performa Penjualan</h2>
            
            {{-- Filter Periode --}}
            <div class="flex gap-2">
                <button onclick="updateChart('week')" 
                        class="px-4 py-2 rounded-lg text-sm font-medium transition periode-btn active"
                        data-period="week">
                    Minggu
                </button>
                <button onclick="updateChart('month')" 
                        class="px-4 py-2 rounded-lg text-sm font-medium transition periode-btn"
                        data-period="month">
                    Bulan
                </button>
                <button onclick="updateChart('year')" 
                        class="px-4 py-2 rounded-lg text-sm font-medium transition periode-btn"
                        data-period="year">
                    Tahun
                </button>
            </div>
        </div>

        {{-- Canvas untuk Chart.js --}}
        <div class="h-80">
            <canvas id="salesChart"></canvas>
        </div>
    </div>
</div>

{{-- Chart.js Script --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let salesChart;
    
    // Data penjualan (sesuaikan dengan data dari controller)
    const salesData = {
        week: {
            labels: {!! json_encode($weekLabels ?? ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']) !!},
            data: {!! json_encode($weekData ?? [0, 0, 0, 0, 0, 0, 0]) !!}
        },
        month: {
            labels: {!! json_encode($monthLabels ?? ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4']) !!},
            data: {!! json_encode($monthData ?? [0, 0, 0, 0]) !!}
        },
        year: {
            labels: {!! json_encode($yearLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']) !!},
            data: {!! json_encode($yearData ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]) !!}
        }
    };

    function createChart(period) {
        const ctx = document.getElementById('salesChart').getContext('2d');
        
        if (salesChart) {
            salesChart.destroy();
        }

        salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: salesData[period].labels,
                datasets: [{
                    label: 'Penjualan',
                    data: salesData[period].data,
                    borderColor: 'rgb(0, 125, 175)',
                    backgroundColor: 'rgba(0, 125, 175, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: 'rgb(0, 125, 175)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgb(0, 125, 175)',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    function updateChart(period) {
        // Update tombol aktif
        document.querySelectorAll('.periode-btn').forEach(btn => {
            btn.classList.remove('active');
            btn.style.backgroundColor = '';
            btn.style.color = '';
        });
        
        const activeBtn = document.querySelector(`[data-period="${period}"]`);
        activeBtn.classList.add('active');
        
        // Buat chart baru
        createChart(period);
    }

    // Style untuk tombol
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.periode-btn');
        buttons.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                if (!this.classList.contains('active')) {
                    this.style.backgroundColor = '#f3f4f6';
                }
            });
            btn.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.style.backgroundColor = '';
                }
            });
        });

        // Style tombol aktif
        const activeBtn = document.querySelector('.periode-btn.active');
        if (activeBtn) {
            activeBtn.style.backgroundColor = '#007daf';
            activeBtn.style.color = 'white';
        }

        // Inisialisasi chart pertama kali dengan periode minggu
        createChart('week');
    });

    // Update style ketika tombol diklik
    document.querySelectorAll('.periode-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.periode-btn').forEach(b => {
                b.style.backgroundColor = '';
                b.style.color = '';
            });
            this.style.backgroundColor = '#007daf';
            this.style.color = 'white';
        });
    });
</script>

<style>
    .periode-btn {
        background-color: #f9fafb;
        color: #6b7280;
    }
    .periode-btn.active {
        background-color: #007daf;
        color: white;
    }
</style>
@endsection