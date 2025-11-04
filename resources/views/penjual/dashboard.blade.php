@extends('layouts.penjual')

@section('title', 'Dashboard Penjual | GiftKita Seller')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    {{-- Judul --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dashboard Penjual</h1>
            <p class="text-gray-500">Selamat datang kembali, {{ Auth::user()->nama ?? 'Penjual' }} 👋</p>
        </div>
        <a href="{{ route('penjual.produk.index') }}" 
           class="px-4 py-2 rounded-lg text-white font-semibold bg-gradient-to-r from-[#007daf] to-[#c771d4] hover:scale-105 transition">
            + Tambah Produk
        </a>
    </div>

    {{-- Statistik Utama --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
        {{-- Jumlah Produk --}}
        <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-[#007daf]">
            <h2 class="text-gray-600">Total Produk</h2>
            <p class="text-3xl font-bold mt-2">{{ $totalProduk ?? 0 }}</p>
        </div>

        {{-- Jumlah Pesanan --}}
        <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-[#c771d4]">
            <h2 class="text-gray-600">Total Pesanan</h2>
            <p class="text-3xl font-bold mt-2">{{ $totalPesanan ?? 0 }}</p>
        </div>

        {{-- Total Pendapatan --}}
        <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-[#ffb829]">
            <h2 class="text-gray-600">Total Pendapatan</h2>
            <p class="text-3xl font-bold mt-2">Rp{{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
        </div>

        {{-- Persentase Penjualan --}}
        <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-green-500">
            <h2 class="text-gray-600">Performa Penjualan</h2>
            @if(isset($persentasePenjualan))
                <p class="text-3xl font-bold mt-2 text-green-600">{{ $persentasePenjualan }}%</p>
                <p class="text-sm text-gray-500 mt-1">dibanding bulan lalu</p>
            @else
                <p class="text-sm text-gray-500 mt-3 italic">Belum ada data penjualan</p>
            @endif
        </div>
    </div>


    {{-- Pintasan Cepat --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-10">
        <a href="{{ route('penjual.toko.index') }}" class="p-6 bg-white shadow-md rounded-xl hover:bg-[#007daf]/10 transition">
            <h3 class="font-semibold text-[#007daf]">Profil Toko</h3>
            <p class="text-gray-500 text-sm mt-2">Lihat dan ubah profil tokomu.</p>
        </a>
        <a href="{{ route('penjual.produk.index') }}" class="p-6 bg-white shadow-md rounded-xl hover:bg-[#c771d4]/10 transition">
            <h3 class="font-semibold text-[#c771d4]">Kelola Produk</h3>
            <p class="text-gray-500 text-sm mt-2">Tambah, ubah, dan hapus produk.</p>
        </a>
        <a href="{{ route('penjual.pesanan.index') }}" class="p-6 bg-white shadow-md rounded-xl hover:bg-[#ffb829]/10 transition">
            <h3 class="font-semibold text-[#ffb829]">Lihat Pesanan</h3>
            <p class="text-gray-500 text-sm mt-2">Pantau status dan detail pesanan.</p>
        </a>
        <a href="{{ route('penjual.bantuan') }}" class="p-6 bg-white shadow-md rounded-xl hover:bg-blue-100 transition">
            <h3 class="font-semibold text-blue-500">Bantuan</h3>
            <p class="text-gray-500 text-sm mt-2">Panduan dan kontak admin.</p>
        </a>
    </div>
</div>
@endsection
