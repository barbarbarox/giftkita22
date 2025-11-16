@extends('layouts.app')

@section('title', 'Tentang Kami | GiftKita')

@section('content')
<div class="relative bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white py-16">
    <div class="absolute inset-0 bg-black opacity-30"></div>
    <div class="relative z-10 flex flex-col items-center justify-center">
        <h1 class="text-4xl font-bold mb-2">Tentang Kami</h1>
        <p class="text-lg opacity-90 text-center">Mengenal lebih dekat GiftKita: visi, misi, dan cerita kami untuk dunia promosi hampers buat hadiahmu lebih penuh makna cerita.</p>
    </div>
</div>


{{-- About Section --}}
<div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-12 py-12 px-4 sm:px-8 bg-white">
    <div class="md:w-2/5 flex items-center justify-center mb-8 md:mb-0">
    <img src="{{ asset('images/GiftKita.png') }}"
         alt="GiftKita Side Logo"
         class="w-64 h-64 rounded-3xl shadow-xl border p-4 transition-transform duration-300 ease-in-out hover:scale-110 active:scale-95">
</div>
    <div class="md:w-3/5 flex flex-col justify-center space-y-6">
        <h2 class="text-2xl font-bold text-[#007daf]">GiftKita</h2>
        <p class="text-gray-700">
            GiftKita hadir sebagai wadah promosi digital dan menghubungkan produk Anda dengan dunia digital secara mudah dan terpercaya. Kami menyediakan platform yang memfasilitasi penjual untuk mempromosikan produk mereka secara efektif, terintegrasi dengan media sosial penjual, sehingga jangkauan promosi lebih luas tanpa perlu repot mengelola transaksi.
        </p>
        <p class="text-gray-700">
            Dengan semangat menghadirkan kemudahan dan kepercayaan, GiftKita siap menjadi mitra dalam mengembangkan visibilitas produk Anda, memperkuat brand, dan mendukung pertumbuhan bisnis secara digital. Kami selalu terbuka untuk kolaborasi dan inovasi demi pengalaman promosi yang lebih baik bagi semua pengguna.
        </p>
    </div>
</div>

{{-- Visi & Misi Section --}}
<div class="bg-gradient-to-r from-[#007daf]/5 via-[#c771d4]/5 to-[#ffb829]/5 py-10">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 px-4 sm:px-8">

        {{-- Visi --}}
        <div>
            <h3 class="text-2xl font-bold text-[#ffb829] mb-2">Visi</h3>
            <p class="text-gray-800 text-lg">
                Menjadi platform promosi digital terpercaya yang membantu penjual dan bisnis untuk terhubung dengan pelanggan secara efektif dan aman.
            </p>
        </div>

        {{-- Misi dengan Icon Kado --}}
        <div>
            <h3 class="text-2xl font-bold text-[#c771d4] mb-2">Misi</h3>
            <ul class="list-none space-y-2 text-gray-800 text-lg">
                <li class="flex items-start gap-3">
                    <span class="text-2xl">🎁</span>
                    <span>Memfasilitasi promosi produk secara mudah melalui integrasi media sosial penjual.</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-2xl">🎁</span>
                    <span>Memberikan pengalaman promosi digital yang aman, transparan, dan terpercaya.</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-2xl">🎁</span>
                    <span>Mendukung pertumbuhan bisnis digital dengan inovasi dan kemudahan teknologi.</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-2xl">🎁</span>
                    <span>Menjadi mitra jangka panjang bagi penjual dalam memperluas pasar.</span>
                </li>
            </ul>
        </div>
    </div>
</div>


{{-- Tim Kami dengan Instagram Link --}}
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-8">
    <h3 class="text-3xl font-bold text-center text-[#007daf] mb-10">Tim Kami</h3>
    <p class="text-gray-600 text-center mb-8">
        Orang-orang hebat di balik GiftKita yang berdedikasi menghadirkan solusi promosi digital yang efisien, aman, dan bermanfaat bagi semua pengguna.
    </p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- Akbar Maulana --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition group">
            <div class="bg-gradient-to-br from-[#007daf] to-[#c771d4] p-8 flex justify-center relative">
                <div class="w-40 h-40 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border-4 border-white shadow-lg text-white text-5xl font-bold">
                    A
                </div>
                {{-- Instagram Overlay Akbar --}}
                <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <a href="https://www.instagram.com/abar_._" target="_blank" class="text-white hover:scale-110 transition-transform">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="bg-white p-6 text-center">
                <h4 class="font-bold text-lg text-gray-800 mb-1">Akbar Maulana</h4>
                <span class="text-gray-600 text-sm">Web Programming</span>
            </div>
        </div>

        {{-- Annisa Nur Rohmadhani --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition group">
            <div class="bg-gradient-to-br from-[#c771d4] to-[#ffb829] p-8 flex justify-center relative">
                <div class="w-70 h-70 rounded-full overflow-hidden border-4 border-white shadow-lg">
                    <img src="{{ asset('images/nisya.jpg') }}" alt="Annisa Nur Rohmadhani" class="w-full h-full object-cover">
                </div>
                {{-- Instagram Overlay Annisa --}}
                <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <a href="https://www.instagram.com/_nisyanr" target="_blank" class="text-white hover:scale-110 transition-transform">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="bg-white p-6 text-center">
                <h4 class="font-bold text-lg text-gray-800 mb-1">Annisa Nur Rohmadhani</h4>
                <span class="text-gray-600 text-sm">System Analyst</span>
            </div>
        </div>

        {{-- Syrli Rahayu --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition group">
            <div class="bg-gradient-to-br from-[#ffb829] to-[#007daf] p-8 flex justify-center relative">
                <div class="w-40 h-40 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border-4 border-white shadow-lg text-white text-5xl font-bold">
                    S
                </div>
                {{-- Instagram Overlay Syrli --}}
                <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <a href="https://www.instagram.com/syrli_sy5" target="_blank" class="text-white hover:scale-110 transition-transform">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="bg-white p-6 text-center">
                <h4 class="font-bold text-lg text-gray-800 mb-1">Syrli Rahayu</h4>
                <span class="text-gray-600 text-sm">UI/UX Designer</span>
            </div>
        </div>
    </div>
</div>


{{-- Jargon / Quote --}}
<div class="bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] py-12">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <h4 class="text-2xl font-bold text-white mb-4"></h4>
        <p class="text-white text-xl italic">
            "Menyinari Promosi Digital dan Menghubungkan Produk Anda dengan Dunia Digital Secara Mudah dan Terpercaya Bersama GiftKita."
        </p>
    </div>
</div>
@endsection