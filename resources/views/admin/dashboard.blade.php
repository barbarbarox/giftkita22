@extends('admin.layouts.app')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="mb-8 animate-fadeIn">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Admin</h1>
        <p class="text-gray-600">Selamat datang kembali, {{ Auth::guard('admin')->user()->name ?? 'Admin' }} 👋</p>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        
        {{-- Total Penjual --}}
        <div class="card-hover bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-blue-100 text-sm font-medium">Total Penjual</p>
                    <p class="text-4xl font-bold mt-1 animate-count">{{ $totalPenjual ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('admin.penjual.index') }}" 
               class="flex items-center justify-between bg-white/20 hover:bg-white/30 backdrop-blur-sm px-4 py-3 rounded-lg transition-all duration-200 group">
                <span class="font-semibold">Kelola Penjual</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>

        {{-- Total Kategori --}}
        <div class="card-hover bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-green-100 text-sm font-medium">Total Kategori</p>
                    <p class="text-4xl font-bold mt-1 animate-count">{{ $totalKategori ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('admin.kategori.index') }}" 
               class="flex items-center justify-between bg-white/20 hover:bg-white/30 backdrop-blur-sm px-4 py-3 rounded-lg transition-all duration-200 group">
                <span class="font-semibold">Kelola Kategori</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>

        {{-- Total FAQ --}}
        <div class="card-hover bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-purple-100 text-sm font-medium">Total FAQ</p>
                    <p class="text-4xl font-bold mt-1 animate-count">{{ $totalFaq ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('admin.faq.index') }}" 
               class="flex items-center justify-between bg-white/20 hover:bg-white/30 backdrop-blur-sm px-4 py-3 rounded-lg transition-all duration-200 group">
                <span class="font-semibold">Kelola FAQ</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 animate-slideUp">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Aksi Cepat
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.penjual.create') }}" 
               class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-all duration-200 group border-2 border-transparent hover:border-blue-500">
                <div class="bg-blue-500 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 group-hover:text-blue-600">Tambah Penjual</p>
                    <p class="text-sm text-gray-500">Daftarkan penjual baru</p>
                </div>
            </a>

            <a href="{{ route('admin.kategori.create') }}" 
               class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-all duration-200 group border-2 border-transparent hover:border-green-500">
                <div class="bg-green-500 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 group-hover:text-green-600">Tambah Kategori</p>
                    <p class="text-sm text-gray-500">Buat kategori produk</p>
                </div>
            </a>

            <a href="{{ route('admin.faq.create') }}" 
               class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-all duration-200 group border-2 border-transparent hover:border-purple-500">
                <div class="bg-purple-500 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 group-hover:text-purple-600">Tambah FAQ</p>
                    <p class="text-sm text-gray-500">Buat pertanyaan baru</p>
                </div>
            </a>

            <a href="{{ route('admin.penjual.index') }}" 
               class="flex items-center p-4 bg-orange-50 hover:bg-orange-100 rounded-lg transition-all duration-200 group border-2 border-transparent hover:border-orange-500">
                <div class="bg-orange-500 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 group-hover:text-orange-600">Monitoring Penjual</p>
                    <p class="text-sm text-gray-500">Pantau Aktivitas Penjual</p>
                </div>
            </a>
        </div>
    </div>

    {{-- Info Cards --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Activity --}}
        <div class="bg-white rounded-xl shadow-lg p-6 animate-slideUp" style="animation-delay: 0.1s">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Aktivitas Terbaru
            </h2>
            <div class="space-y-3">
                <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                    <p class="text-gray-600 text-sm">Sistem berjalan normal</p>
                </div>
                <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                    <p class="text-gray-600 text-sm">Database terkoneksi</p>
                </div>
                <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                    <p class="text-gray-600 text-sm">Semua layanan aktif</p>
                </div>
            </div>
        </div>

        {{-- System Info --}}
        <div class="bg-white rounded-xl shadow-lg p-6 animate-slideUp" style="animation-delay: 0.2s">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Informasi Sistem
            </h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-600 text-sm">Versi Laravel</span>
                    <span class="font-semibold text-gray-800">{{ app()->version() }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-600 text-sm">Versi PHP</span>
                    <span class="font-semibold text-gray-800">{{ PHP_VERSION }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-600 text-sm">Tanggal Hari Ini</span>
                    <span class="font-semibold text-gray-800">{{ now()->isoFormat('DD MMMM YYYY') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes count {
    from {
        opacity: 0;
        transform: scale(0.5);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.5s ease-out;
}

.animate-slideUp {
    animation: slideUp 0.6s ease-out;
    animation-fill-mode: both;
}

.animate-count {
    animation: count 0.5s ease-out;
}

.card-hover {
    position: relative;
    overflow: hidden;
}

.card-hover::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.card-hover:hover::before {
    left: 100%;
}
</style>
@endsection