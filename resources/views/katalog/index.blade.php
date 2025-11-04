@extends('layouts.app')

@section('title', 'Katalog Produk | GiftKita')

@section('content')
<section class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-center mb-8 text-[#007daf]">Katalog Produk</h1>

    {{-- Form pencarian dan filter --}}
    <form method="GET" action="{{ route('katalog.index') }}" class="flex flex-col md:flex-row gap-4 justify-center mb-10">
        <input type="text" name="q" placeholder="Cari produk..."
               value="{{ request('q') }}"
               class="border rounded-lg px-4 py-2 w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-[#007daf]">

        <select name="kategori" class="border rounded-lg px-4 py-2 w-full md:w-1/4 focus:outline-none focus:ring-2 focus:ring-[#c771d4]">
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                    {{ $kategori->nama_kategori }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white px-6 py-2 rounded-lg hover:scale-105 transition">
            🔍 Cari
        </button>
    </form>

    {{-- Grid Produk --}}
    @if ($produks->isEmpty())
        <p class="text-center text-gray-600">Tidak ada produk ditemukan.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($produks as $produk)
                @php
                    $thumbnail = $produk->files->first();
                    $imagePath = $thumbnail ? asset('storage/'.$thumbnail->filepath) : asset('images/no-image.jpg');
                @endphp
                <a href="{{ route('katalog.show', $produk->id) }}"
                   class="block bg-white shadow-md border border-gray-100 rounded-xl overflow-hidden hover:shadow-lg transition transform hover:scale-[1.02]">
                    <img src="{{ $imagePath }}" alt="{{ $produk->nama }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold text-[#007daf] mb-1">{{ $produk->nama }}</h3>
                        <p class="text-sm text-gray-600 line-clamp-2 mb-2">{{ $produk->deskripsi ?? '-' }}</p>
                        <p class="text-[#ffb829] font-bold mb-1">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500">Toko: {{ $produk->toko->nama_toko ?? '-' }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</section>
@endsection
