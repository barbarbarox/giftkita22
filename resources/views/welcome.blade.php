@extends('layouts.app')

@section('title', 'GiftKita — Hadiah Spesialmu, Dengan Sentuhan Istimewa')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white text-center py-20">
        <h1 class="text-4xl font-bold mb-4">Buat Momenmu Lebih Spesial Bersama GiftKita</h1>
        <p class="text-lg mb-6">Temukan hampers, buket, dan hadiah terbaik yang bisa disesuaikan dengan keinginanmu.</p>
        <a href="/katalog" class="bg-white text-[#007daf] font-semibold px-6 py-3 rounded-full hover:bg-gray-100 transition">
            Lihat Katalog
        </a>
    </section>

    <!-- Keunggulan Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto text-center">
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

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-[#ffb829] via-[#c771d4] to-[#007daf] text-white text-center py-16">
        <h2 class="text-3xl font-bold mb-4">Ingin Jadi Bagian dari GiftKita?</h2>
        <p class="mb-6">Daftar sebagai penjual dan tunjukkan kreativitasmu dalam membuat hadiah istimewa!</p>
        <a href="/register" class="bg-white text-[#c771d4] px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
            Daftar Sekarang
        </a>
    </section>
@endsection
