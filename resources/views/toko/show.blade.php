@extends('layouts.app')

@section('title', $toko->nama_toko . ' | GiftKita')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-16">

    {{-- 🔹 Info Toko --}}
    <div class="flex flex-col md:flex-row items-start md:items-center gap-8 mb-12">
        @php
            // Pastikan path foto benar
            $fotoPath = $toko->foto_profil;
            if ($fotoPath && str_starts_with($fotoPath, 'storage/')) {
                $foto = asset($fotoPath);
            } elseif ($fotoPath) {
                $foto = asset('storage/' . $fotoPath);
            } else {
                $foto = asset('images/no-image.jpg');
            }

            $nomorWa = $toko->whatsapp ? preg_replace('/\D/', '', $toko->whatsapp) : null;
            $pesan = urlencode("Halo, saya tertarik dengan produk dari *{$toko->nama_toko}* di GiftKita!");
            $linkWA = $nomorWa ? "https://wa.me/{$nomorWa}?text={$pesan}" : null;
        @endphp

        {{-- Foto Toko --}}
        <img src="{{ $foto }}" alt="{{ $toko->nama_toko }}"
             class="w-48 h-48 object-cover rounded-2xl shadow-lg border-4 border-white/50 hover:scale-105 transition duration-300">

        {{-- Detail Toko --}}
        <div>
            <h1 class="text-3xl font-bold text-[#007daf] mb-3">{{ $toko->nama_toko }}</h1>
            <p class="text-gray-600 mb-4 max-w-xl leading-relaxed">{{ $toko->deskripsi ?? 'Tidak ada deskripsi untuk toko ini.' }}</p>

            @if ($toko->alamat_toko)
                <p class="text-sm text-gray-500 mb-2">
                    <span class="font-semibold text-gray-700">📍 Alamat:</span> {{ $toko->alamat_toko }}
                </p>
            @endif

            @if ($toko->penjual)
                <p class="text-sm text-gray-500 mb-6">
                    <span class="font-semibold text-gray-700">👤 Pemilik:</span> {{ $toko->penjual->nama ?? '-' }}
                </p>
            @endif

            {{-- Tombol WhatsApp --}}
            @if ($linkWA)
                <a href="{{ $linkWA }}" 
                   target="_blank" 
                   class="inline-block px-6 py-3 bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white font-semibold rounded-full hover:shadow-xl hover:scale-105 transition-all duration-300 mb-4">
                    Hubungi Toko via WhatsApp
                </a>
            @endif

            {{-- Media Sosial --}}
            <div class="flex items-center gap-5 mt-3 text-2xl">
                @if ($toko->instagram)
                    <a href="{{ $toko->instagram }}" target="_blank" class="text-pink-500 hover:text-pink-600 transition-transform hover:scale-125">
                        <i class="fab fa-instagram"></i>
                    </a>
                @endif

                @if ($toko->facebook)
                    <a href="{{ $toko->facebook }}" target="_blank" class="text-blue-600 hover:text-blue-700 transition-transform hover:scale-125">
                        <i class="fab fa-facebook"></i>
                    </a>
                @endif

                @if ($toko->whatsapp)
                    <a href="{{ $linkWA }}" target="_blank" class="text-green-500 hover:text-green-600 transition-transform hover:scale-125">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- 🔹 Daftar Produk Toko --}}
    <h2 class="text-2xl font-bold text-[#007daf] mb-6">Produk dari {{ $toko->nama_toko }}</h2>

    @if ($toko->produks->isEmpty())
        <p class="text-gray-600">Belum ada produk di toko ini.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @foreach ($toko->produks as $produk)
                @php
                    $thumbnail = $produk->files->first();
                    if ($thumbnail && str_starts_with($thumbnail->filepath, 'storage/')) {
                        $imagePath = asset($thumbnail->filepath);
                    } elseif ($thumbnail) {
                        $imagePath = asset('storage/' . $thumbnail->filepath);
                    } else {
                        $imagePath = asset('images/no-image.jpg');
                    }
                @endphp

                <a href="{{ route('produk.show', $produk->id) }}" 
                   class="bg-white rounded-xl border shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1 block overflow-hidden">
                    <img src="{{ $imagePath }}" alt="{{ $produk->nama }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold text-[#007daf] mb-1">{{ $produk->nama }}</h3>
                        <p class="text-sm text-gray-600 line-clamp-2 mb-2">{{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                        <p class="font-bold text-[#ffb829]">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</section>

{{-- Font Awesome untuk ikon sosial media --}}
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
