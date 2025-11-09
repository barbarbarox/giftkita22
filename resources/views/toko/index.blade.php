@extends('layouts.app')

@section('title', 'Daftar Toko | GiftKita')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-16">
    <h1 class="text-3xl font-bold mb-10 text-center text-[#007daf]">Toko yang Ada di GiftKita</h1>

    @if ($tokos->isEmpty())
        <p class="text-gray-600 text-center">Belum ada toko yang terdaftar.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($tokos as $toko)
                <div class="bg-white border rounded-xl shadow-md hover:shadow-xl transition overflow-hidden">
                    @php
                        // Cek apakah path sudah termasuk 'storage/'
                        $fotoPath = $toko->foto_profil;

                        if ($fotoPath && str_starts_with($fotoPath, 'storage/')) {
                            $foto = asset($fotoPath);
                        } elseif ($fotoPath) {
                            $foto = asset('storage/' . $fotoPath);
                        } else {
                            $foto = asset('images/no-image.jpg');
                        }
                    @endphp

                    <a href="{{ route('toko.show', $toko->id) }}">
                        <img src="{{ $foto }}" alt="{{ $toko->nama_toko }}" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-[#007daf] mb-1">{{ $toko->nama_toko }}</h3>
                            <p class="text-sm text-gray-600 line-clamp-2">{{ $toko->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                            <p class="mt-2 text-xs text-gray-500">🛍️ {{ $toko->produks_count ?? 0 }} Produk</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endsection
