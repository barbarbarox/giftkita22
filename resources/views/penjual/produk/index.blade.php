@extends('layouts.penjual')

@section('title', 'Daftar Produk | GiftKita Seller')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Produk</h1>

        <a href="{{ route('penjual.produk.create') }}" 
           class="px-4 py-2 bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white rounded shadow hover:scale-105 transition">
            ➕ Tambah Produk
        </a>
    </div>

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Jika belum ada produk --}}
    @if($produks->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 p-5 rounded-lg text-yellow-800 text-center">
            Belum ada produk yang ditambahkan.
            <a href="{{ route('penjual.produk.create') }}" 
               class="text-[#007daf] font-semibold underline ml-1">
               Tambahkan sekarang
            </a>
        </div>
    @else
        {{-- Grid produk --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($produks as $produk)
                <div class="bg-white shadow-md rounded-xl p-5 border border-gray-100 hover:shadow-lg transition">

                    {{-- Gambar / Video utama --}}
                    @php
                        $thumbnail = $produk->files->first();
                    @endphp

                    <div class="relative mb-4">
                        @if($thumbnail)
                            @php
                                $path = 'storage/' . $thumbnail->filepath;
                                $ext = strtolower(pathinfo($thumbnail->filepath, PATHINFO_EXTENSION));
                            @endphp

                            @if(in_array($ext, ['mp4', 'mov', 'webm', 'avi']))
                                <video class="w-full h-40 object-cover rounded-lg border border-gray-200" controls muted>
                                    <source src="{{ asset($path) }}">
                                </video>
                            @else
                                <img src="{{ asset($path) }}" 
                                     alt="Foto Produk" 
                                     class="w-full h-40 object-cover rounded-lg border border-gray-200">
                            @endif
                        @else
                            <div class="w-full h-40 bg-gray-100 flex items-center justify-center text-gray-400 rounded-lg">
                                Tidak ada foto
                            </div>
                        @endif
                    </div>

                    {{-- Info produk --}}
                    <div>
                        <h2 class="text-lg font-bold text-[#007daf] mb-1">{{ $produk->nama }}</h2>
                        <p class="text-sm text-gray-600 mb-2 line-clamp-2">
                            {{ $produk->deskripsi ?? 'Belum ada deskripsi.' }}
                        </p>
                        <p class="text-sm text-gray-700 mb-1">💰 Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>

                        <p class="text-sm text-gray-500">🏷️ {{ $produk->kategori->nama_kategori ?? '-' }}</p>
                    </div>

                    {{-- Tombol aksi --}}
                    <div class="flex justify-between mt-4">
                        <a href="{{ route('penjual.produk.edit', $produk->id) }}" 
                           class="px-3 py-1.5 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-sm">
                            ✏️ Edit
                        </a>

                        <form action="{{ route('penjual.produk.destroy', $produk->id) }}" 
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus produk ini?')" 
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1.5 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
