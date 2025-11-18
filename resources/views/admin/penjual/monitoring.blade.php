@extends('admin.layouts.app')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.penjual.index') }}" 
               class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-800">Monitoring Penjual</h1>
                <p class="text-gray-600 mt-1">{{ $penjual->username }} ({{ $penjual->email }})</p>
            </div>
            
            {{-- Status Toggle Section --}}
            <div class="bg-white rounded-xl shadow-lg p-4 border-2 {{ $penjual->isActive() ? 'border-green-200' : 'border-red-200' }}">
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm text-gray-500 font-medium">Status Akun</p>
                        <p class="text-lg font-bold {{ $penjual->isActive() ? 'text-green-600' : 'text-red-600' }}">
                            {{ $penjual->isActive() ? 'Aktif' : 'Nonaktif' }}
                        </p>
                    </div>
                    
                    {{-- Toggle Switch --}}
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" 
                               class="sr-only peer" 
                               id="statusToggle"
                               {{ $penjual->isActive() ? 'checked' : '' }}
                               onchange="toggleStatus(this)">
                        <div class="w-14 h-8 bg-red-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-green-500"></div>
                    </label>
                </div>
                
                {{-- Info deaktivasi jika nonaktif --}}
                @if($penjual->isInactive() && $penjual->deactivated_at)
                <div class="mt-3 pt-3 border-t border-gray-200">
                    <p class="text-xs text-gray-500">
                        <strong>Dinonaktifkan:</strong> {{ $penjual->deactivated_at->format('d M Y H:i') }}
                    </p>
                    @if($penjual->deactivation_reason)
                    <p class="text-xs text-gray-600 mt-1">
                        <strong>Alasan:</strong> {{ $penjual->deactivation_reason }}
                    </p>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg flex items-center justify-between">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>
    </div>
    @endif

    @if(session('warning'))
    <div class="mb-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg flex items-center justify-between">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('warning') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-yellow-700 hover:text-yellow-900">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>
    </div>
    @endif

    {{-- Statistik Overview --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Toko</p>
                    <p class="text-4xl font-bold mt-2">{{ $totalToko }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Total Produk</p>
                    <p class="text-4xl font-bold mt-2">{{ $totalProduk }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Total Pesanan</p>
                    <p class="text-4xl font-bold mt-2">{{ $totalPesanan }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm">Total Pendapatan</p>
                    <p class="text-2xl font-bold mt-2">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <div class="bg-white rounded-xl shadow-lg mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" role="tablist">
                <button class="tab-btn active py-4 px-1 border-b-2 font-medium text-sm" data-tab="tokos">
                    🏪 Daftar Toko ({{ $totalToko }})
                </button>
                <button class="tab-btn py-4 px-1 border-b-2 font-medium text-sm" data-tab="produks">
                    📦 Daftar Produk ({{ $totalProduk }})
                </button>
                <button class="tab-btn py-4 px-1 border-b-2 font-medium text-sm" data-tab="grafik">
                    📈 Grafik Penjualan
                </button>
                <button class="tab-btn py-4 px-1 border-b-2 font-medium text-sm" data-tab="pesanan">
                    📋 Riwayat Pesanan
                </button>
            </nav>
        </div>
    </div>

    {{-- Tab Content: Daftar Toko --}}
    <div id="tokos" class="tab-content">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($tokos as $toko)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                <div class="h-32 bg-gradient-to-r from-blue-400 to-purple-500 relative">
                    @if($toko->foto_profil)
                    <img src="{{ asset('storage/' . $toko->foto_profil) }}" class="w-20 h-20 rounded-full border-4 border-white absolute bottom-0 left-6 transform translate-y-1/2" alt="{{ $toko->nama_toko }}">
                    @else
                    <div class="w-20 h-20 bg-gray-300 rounded-full border-4 border-white absolute bottom-0 left-6 transform translate-y-1/2 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    @endif
                </div>
                <div class="pt-12 p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $toko->nama_toko }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $toko->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-blue-600">{{ $toko->jumlah_produk }}</p>
                            <p class="text-xs text-gray-500">Produk</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-green-600">{{ $toko->total_pesanan }}</p>
                            <p class="text-xs text-gray-500">Pesanan</p>
                        </div>
                    </div>

                    @if($toko->alamat_toko)
                    <div class="flex items-start gap-2 text-sm text-gray-600 mb-3">
                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="line-clamp-2">{{ $toko->alamat_toko }}</span>
                    </div>
                    @endif

                    <div class="flex gap-2">
                        @if($toko->whatsapp)
                        <a href="https://wa.me/{{ $toko->whatsapp }}" target="_blank" class="flex-1 text-center py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-medium transition-colors">
                            WhatsApp
                        </a>
                        @endif
                        @if($toko->instagram)
                        <a href="{{ $toko->instagram }}" target="_blank" class="flex-1 text-center py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-lg text-sm font-medium transition-colors">
                            Instagram
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">Penjual ini belum memiliki toko</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Tab Content: Daftar Produk --}}
    <div id="produks" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Toko</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Stok</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($produks as $produk)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $produk->nama }}</div>
                                <div class="text-sm text-gray-500 line-clamp-1">{{ Str::limit($produk->deskripsi, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $produk->nama_toko }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                    {{ $produk->nama_kategori }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                                Rp{{ number_format($produk->harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $produk->stok > 10 ? 'bg-green-100 text-green-800' : ($produk->stok > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $produk->stok }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                Belum ada produk
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tab Content: Grafik Penjualan --}}
    <div id="grafik" class="tab-content hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Grafik Line --}}
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Trend Penjualan (12 Bulan)</h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            {{-- Produk Terlaris --}}
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Top 5 Produk Terlaris</h3>
                <div class="space-y-4">
                    @forelse($produkTerlaris as $index => $produk)
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">{{ $produk->nama }}</p>
                            <p class="text-sm text-gray-500">{{ $produk->total_terjual }} terjual • {{ $produk->jumlah_pesanan }} pesanan</p>
                        </div>
                        <div class="text-right">
                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($produk->total_terjual / $produkTerlaris->max('total_terjual')) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 text-center py-8">Belum ada data penjualan</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Tab Content: Riwayat Pesanan --}}
    <div id="pesanan" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Toko</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pembeli</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($pesananTerbaru as $pesanan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $pesanan->nama_produk }}</div>
                                <div class="text-sm text-gray-500">@ Rp{{ number_format($pesanan->harga, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $pesanan->nama_toko }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $pesanan->nama_pembeli }}</td>
                            <td class="px-6 py-4 text-center text-sm font-medium">{{ $pesanan->jumlah }}</td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-gray-900">
                                Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($pesanan->status == 'pending')
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @elseif($pesanan->status == 'diproses')
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                        Diproses
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                        Selesai
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                Belum ada pesanan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Deaktivasi --}}
<div id="deactivateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="bg-red-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Nonaktifkan Penjual</h3>
        </div>
        
        <form id="deactivateForm" method="POST" action="{{ route('admin.penjual.toggleStatus', $penjual->id) }}">
            @csrf
            <p class="text-gray-600 mb-4">
                Anda yakin ingin menonaktifkan akun <strong>{{ $penjual->username }}</strong>?
                Penjual tidak akan bisa login dan semua toko mereka akan dibekukan.
            </p>
            
            <div class="mb-4">
                <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                    Alasan Deaktivasi <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="reason" 
                    name="reason" 
                    rows="3" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                    placeholder="Masukkan alasan deaktivasi..."
                    required
                ></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="button" 
                        onclick="closeDeactivateModal()" 
                        class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                    Nonaktifkan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Konfirmasi Aktivasi --}}
<div id="activateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="bg-green-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Aktifkan Penjual</h3>
        </div>
        
        <form method="POST" action="{{ route('admin.penjual.toggleStatus', $penjual->id) }}">
            @csrf
            <p class="text-gray-600 mb-6">
                Anda yakin ingin mengaktifkan kembali akun <strong>{{ $penjual->username }}</strong>?
                Penjual akan bisa login dan mengelola toko mereka kembali.
            </p>
            
            <div class="flex gap-3">
                <button type="button" 
                        onclick="closeActivateModal()" 
                        class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                    Aktifkan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Tab Switching
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Remove active dari semua tab
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('active', 'border-blue-500', 'text-blue-600');
            b.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        });
        
        // Add active ke tab yang diklik
        this.classList.add('active', 'border-blue-500', 'text-blue-600');
        this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        
        // Hide semua content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Show content yang sesuai
        const tabId = this.getAttribute('data-tab');
        document.getElementById(tabId).classList.remove('hidden');
    });
});

// Style default untuk tab
document.querySelectorAll('.tab-btn').forEach(btn => {
    if (!btn.classList.contains('active')) {
        btn.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
    } else {
        btn.classList.add('border-blue-500', 'text-blue-600');
    }
});

// Toggle Status Function
function toggleStatus(checkbox) {
    const isActive = checkbox.checked;
    
    if (isActive) {
        // Tampilkan modal aktivasi
        document.getElementById('activateModal').classList.remove('hidden');
    } else {
        // Tampilkan modal deaktivasi
        document.getElementById('deactivateModal').classList.remove('hidden');
    }
    
    // Reset checkbox ke state sebelumnya (akan diubah setelah submit form)
    checkbox.checked = !checkbox.checked;
}

// Close Modal Functions
function closeDeactivateModal() {
    document.getElementById('deactivateModal').classList.add('hidden');
    document.getElementById('reason').value = '';
}

function closeActivateModal() {
    document.getElementById('activateModal').classList.add('hidden');
}

// Close modal ketika click di luar modal
document.getElementById('deactivateModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeactivateModal();
    }
});

document.getElementById('activateModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeActivateModal();
    }
});

// Chart
const ctx = document.getElementById('salesChart');
if (ctx) {
    const chartLabels = <?php echo json_encode($chartLabels); ?>;
    const chartData = <?php echo json_encode($chartData); ?>;
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Jumlah Pesanan',
                data: chartData,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: 'rgb(59, 130, 246)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 2,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}
</script>
@endsection