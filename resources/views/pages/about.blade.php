@extends('layouts.app')

@section('title', 'Tentang Kami | GiftKita')

@section('content')
<div class="relative bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white py-16">
    <div class="absolute inset-0 bg-black opacity-30"></div>
    <div class="relative z-10 flex flex-col items-center justify-center">
        <h1 class="text-4xl font-bold mb-2">Tentang Kami</h1>
        <p class="text-lg opacity-90 text-center">Mengenal lebih dekat GiftKita: visi, misi, dan cerita kami untuk dunia promosi hampers buat hadiahmu lebih penuh makna cerita.</p>
        <div class="mt-4 text-sm opacity-80">
            <a href="/" class="hover:underline">Beranda</a> / <span>Tentang Kami</span>
        </div>
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
{{-- Kontak Kami --}}
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-8 bg-white">
    <h3 class="text-3xl font-bold text-center text-[#007daf] mb-6">Hubungi Kami</h3>
    <p class="text-gray-600 text-center mb-10">
        Punya pertanyaan atau ingin bergabung sebagai penjual? Jangan ragu untuk menghubungi kami!
    </p>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- Contact Cards (Kiri) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            {{-- Email --}}
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 text-center hover:shadow-lg transition group">
                <div class="w-16 h-16 bg-gradient-to-br from-[#007daf] to-[#0099cc] rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-800 mb-2">Email</h4>
                <a href="mailto:support@giftkita.id" class="text-[#007daf] hover:underline text-sm break-all">
                    support@giftkita.id
                </a>
            </div>

            {{-- WhatsApp --}}
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 text-center hover:shadow-lg transition group">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-800 mb-2">WhatsApp</h4>
                <a href="https://wa.me/6282249219360" target="_blank" class="text-green-600 hover:underline text-sm">
                    +62 822-4921-9360
                </a>
            </div>

            {{-- Instagram --}}
            <div class="bg-gradient-to-br from-pink-50 to-purple-100 rounded-xl p-6 text-center hover:shadow-lg transition group">
                <div class="w-16 h-16 bg-gradient-to-br from-[#c771d4] to-[#ff007f] rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-800 mb-2">Instagram</h4>
                <a href="https://instagram.com/giftkita.id" target="_blank" class="text-[#c771d4] hover:underline text-sm">
                    @giftkita.id
                </a>
            </div>

            {{-- Alamat --}}
            <div class="bg-gradient-to-br from-orange-50 to-yellow-100 rounded-xl p-6 text-center hover:shadow-lg transition group">
                <div class="w-16 h-16 bg-gradient-to-br from-[#ffb829] to-[#ff9500] rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-800 mb-2">Alamat</h4>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Politeknik Negeri Bengkalis<br>
                    Jl. Bathin Alam, Sungai Alam<br>
                    Bengkalis, Riau 28712
                </p>
            </div>

        </div>

        {{-- Google Maps (Kanan) --}}
<div class="rounded-xl overflow-hidden shadow-lg border-2 border-[#007daf] h-full min-h-[400px] relative">
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.663862863573!2d102.14805697496893!3d1.4590704986364907!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d1fbfd1f1f1f1f%3A0x123456789abcdef!2sPoliteknik%20Negeri%20Bengkalis!5e0!3m2!1sid!2sid!4v1699999999999!5m2!1sid!2sid"
        width="100%"
        height="100%"
        style="border:0; min-height: 400px;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        class="transition duration-500">
    </iframe>

    {{-- Badge "Lihat di Google Maps" --}}
    <div class="absolute bottom-4 left-4">
        <a href="https://maps.google.com/?q=Politeknik+Negeri+Bengkalis" target="_blank"
           class="flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-lg hover:shadow-xl transition group">
            <svg class="w-5 h-5 text-[#007daf] group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="text-sm font-semibold text-gray-700">Lihat di Google Maps</span>
        </a>
    </div>
</div>

    </div>

    {{-- CTA Button --}}
    <div class="text-center mt-10">
        <a href="https://wa.me/6282249219360" target="_blank"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-[#007daf] to-[#c771d4] text-white px-8 py-3 rounded-full font-semibold hover:shadow-lg transform hover:scale-105 transition">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
            </svg>
            Hubungi Kami via WhatsApp
        </a>
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
