@extends('layouts.app')

@section('title', 'GiftKita — Hadiah Spesialmu, Dengan Sentuhan Istimewa')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white text-center py-24 px-4 relative overflow-hidden">
        <div class="max-w-4xl mx-auto">
            <h1 id="hero-title" class="text-3xl md:text-4xl font-bold mb-4 leading-snug">
                Buat Momenmu Lebih Spesial Bersama GiftKita
            </h1>

            {{-- Animasi teks ketikan --}}
            <p id="hero-dynamic-text" class="text-lg md:text-xl font-medium h-6 md:h-7"></p>
        </div>
    </section>

    <!-- Keunggulan Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto text-center px-4">
            <h2 class="text-3xl font-bold mb-10 text-[#007daf]">Kenapa Pilih GiftKita?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 border rounded-xl shadow-md hover:shadow-xl transition">
                    <h3 class="text-xl font-semibold mb-2 text-[#c771d4]">Custom Hampers</h3>
                    <p>Buat hadiah sesuai tema dan gaya yang kamu mau, dari klasik sampai modern.</p>
                </div>
                <div class="p-6 border rounded-xl shadow-md hover:shadow-xl transition">
                    <h3 class="text-xl font-semibold mb-2 text-[#007daf]">Ga pake ribet</h3>
                    <p>Pesan hampers mudah dan cepat, tanpa langkah yang bikin pusing.</p>
                </div>
                <div class="p-6 border rounded-xl shadow-md hover:shadow-xl transition">
                    <h3 class="text-xl font-semibold mb-2 text-[#ffb829]">Komunikasi oke</h3>
                    <p>Toko di sini siap merespons dengan cepat dan ramah di setiap pesanmu.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Produk Pilihan -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-10 text-[#007daf]">Produk Pilihan</h2>

            @if ($produks->isEmpty())
                <p class="text-gray-600">Belum ada produk yang tersedia.</p>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                    @foreach ($produks as $produk)
                        <a href="{{ route('produk.show', $produk->id) }}" 
                           class="group bg-white rounded-lg shadow-md hover:shadow-xl transition border border-gray-100 overflow-hidden block">
                            @php
                                $thumbnail = $produk->files->first();
                                $imagePath = $thumbnail ? asset('storage/' . $thumbnail->filepath) : asset('images/no-image.jpg');
                            @endphp

                            {{-- Gambar produk --}}
                            <img src="{{ $imagePath }}" 
                                 alt="{{ $produk->nama }}" 
                                 class="w-full h-36 object-cover group-hover:scale-105 transition-transform duration-300">

                            {{-- Info produk --}}
                            <div class="p-3 text-left">
                                <h3 class="text-sm font-semibold text-[#007daf] mb-1 truncate">{{ $produk->nama }}</h3>
                                <p class="text-xs text-gray-600 mb-1 line-clamp-2">
                                    {{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}
                                </p>
                                <p class="text-[#ffb829] font-bold text-sm">
                                    Rp{{ number_format($produk->harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Tombol Lihat Semua Produk --}}
                <div class="mt-10">
                    <a href="{{ route('katalog.index') }}" 
                       class="bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white px-8 py-3 rounded-full font-semibold hover:scale-105 transition">
                        Lihat Semua Produk
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-[#ffb829] via-[#c771d4] to-[#007daf] text-white text-center py-16 px-4">
        <h2 class="text-3xl font-bold mb-4">Ingin Jadi Bagian dari GiftKita?</h2>
        <p class="mb-6 text-lg">Daftar sebagai penjual dan tunjukkan kreativitasmu dalam membuat hadiah istimewa!</p>
        <a href="/register" class="bg-white text-[#c771d4] px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
            Daftar Sekarang
        </a>
    </section>

    {{-- Script Animasi Ketikan --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const element = document.getElementById("hero-dynamic-text");
            const texts = [
                "Temukan hampers, buket, dan hadiah terbaik yang bisa disesuaikan dengan keinginanmu.",
                "Setiap hadiah adalah cerita, biarkan GiftKita bantu kamu menulisnya.",
                "Rayakan momen bahagia dengan hadiah penuh makna dari GiftKita.",
                "Ciptakan kejutan tak terlupakan untuk orang tersayang 🎁"
            ];

            let index = 0;
            let charIndex = 0;
            let typing = true;

            function typeEffect() {
                if (typing) {
                    if (charIndex < texts[index].length) {
                        element.textContent += texts[index].charAt(charIndex);
                        charIndex++;
                        setTimeout(typeEffect, 50);
                    } else {
                        typing = false;
                        setTimeout(typeEffect, 2000); // tunggu 2 detik sebelum menghapus
                    }
                } else {
                    if (charIndex > 0) {
                        element.textContent = texts[index].substring(0, charIndex - 1);
                        charIndex--;
                        setTimeout(typeEffect, 25);
                    } else {
                        typing = true;
                        index = (index + 1) % texts.length;
                        setTimeout(typeEffect, 400);
                    }
                }
            }

            typeEffect();
        });
    </script>
@endsection
