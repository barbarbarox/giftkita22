@extends('layouts.app')

@section('title', 'Kebijakan Privasi | GiftKita')

@section('content')

{{-- Hero Section with Gradient Background --}}
<div class="bg-gradient-to-r from-[#007daf] via-purple-500 to-[#c771d4] text-white py-16 mb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            Pedoman Perlindungan Data Pribadi GiftKita.id
        </h1>
        <p class="text-lg opacity-90">
            Komitmen kami dalam melindungi data pribadi penjual dan pengunjung website
        </p>
        <p class="text-sm mt-2 opacity-75">Terakhir Diperbarui: 10 November 2025</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-8 py-8 flex flex-col md:flex-row gap-8">

    {{-- Sidebar Daftar Isi --}}
    <aside class="md:w-1/4 bg-white border rounded-xl shadow-md p-6 h-max md:sticky md:top-32">
        <h2 class="font-bold text-lg mb-4 text-[#007daf]">Daftar Isi</h2>
        <ul class="space-y-2 text-gray-700 text-sm">
            <li>
                <a href="#intro" class="block py-1 hover:text-[#c771d4] transition">
                    Pendahuluan
                </a>
            </li>
            <li>
                <a href="#pendahuluan" class="block py-1 hover:text-[#c771d4] transition">
                    1. Pendahuluan
                </a>
            </li>
            <li>
                <a href="#data-dikumpulkan" class="block py-1 hover:text-[#c771d4] transition">
                    2. Data yang Dikumpulkan
                </a>
            </li>
            <li>
                <a href="#penggunaan-data" class="block py-1 hover:text-[#c771d4] transition">
                    3. Penggunaan Data
                </a>
            </li>
            <li>
                <a href="#hak-penjual" class="block py-1 hover:text-[#c771d4] transition">
                    4. Hak Penjual
                </a>
            </li>
            <li>
                <a href="#keamanan-data" class="block py-1 hover:text-[#c771d4] transition">
                    5. Keamanan Data
                </a>
            </li>
            <li>
                <a href="#perubahan-pedoman" class="block py-1 hover:text-[#c771d4] transition">
                    6. Perubahan Pedoman
                </a>
            </li>
            <li>
                <a href="#kontak" class="block py-1 hover:text-[#c771d4] transition">
                    7. Kontak Kami
                </a>
            </li>
        </ul>
    </aside>

    {{-- Konten Utama --}}
    <section class="md:w-3/4 space-y-8 leading-relaxed">

        {{-- Intro (tanpa background) --}}
        <div id="intro" class="scroll-mt-32 border-l-4 border-[#007daf] pl-6">
            <p class="text-gray-700 text-lg leading-relaxed">
                GiftKita.id berkomitmen melindungi data pribadi penjual dan pengunjung website.
                Pedoman ini menjelaskan bagaimana data dikumpulkan, digunakan, dan dilindungi
                sesuai dengan peraturan perundang-undangan yang berlaku di Indonesia.
            </p>
        </div>

        {{-- 1. Pendahuluan --}}
        <div id="pendahuluan" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">1. Pendahuluan</h2>
            <p class="mb-3">
                GiftKita.id berkomitmen melindungi data pribadi penjual dan pengunjung website.
                Pedoman ini menjelaskan bagaimana data dikumpulkan, digunakan, dan dilindungi.
            </p>
            <p class="mb-3">
                GiftKita.id menyediakan platform promosi online untuk penjual, tanpa memfasilitasi
                transaksi pembelian. Semua transaksi terjadi langsung antara penjual dan pembeli,
                sehingga GiftKita.id tidak menyimpan data pribadi pembeli dan tidak menyediakan
                login untuk pembeli.
            </p>
            <p>
                Pedoman ini juga menjelaskan hak penjual terkait data mereka, termasuk akses,
                pembaruan, dan penghapusan data, serta bagaimana GiftKita.id menjaga keamanan data.
                Tujuan utama pedoman ini adalah memastikan transparansi, perlindungan data, dan
                pengalaman yang aman bagi semua pengguna platform.
            </p>
        </div>

        {{-- 2. Data yang Dikumpulkan --}}
        <div id="data-dikumpulkan" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">2. Data yang Dikumpulkan</h2>

            <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <span class="text-purple-600">👤</span> Dari Penjual:
            </h3>
            <p class="mb-4 pl-4 border-l-2 border-gray-200">
                Data yang disediakan untuk promosi, misalnya: profil sosial media, foto produk,
                nama, dan kontak yang relevan.
            </p>

            <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <span class="text-blue-600">🌐</span> Dari Pengunjung:
            </h3>
            <p class="pl-4 border-l-2 border-gray-200">
                Interaksi dengan website secara anonim, misalnya kunjungan ke halaman promosi.
            </p>
        </div>

        {{-- 3. Penggunaan Data --}}
        <div id="penggunaan-data" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">3. Penggunaan Data</h2>
            <p class="mb-3">Data digunakan untuk:</p>
            <ul class="space-y-2 text-gray-700">
                <li class="flex items-start gap-2">
                    <span class="text-green-600 font-bold">✓</span>
                    <span>Menampilkan promosi dan informasi produk dari penjual.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-green-600 font-bold">✓</span>
                    <span>Meningkatkan pengalaman dan kinerja website.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-green-600 font-bold">✓</span>
                    <span>Memberikan dukungan terkait promosi penjual.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-green-600 font-bold">✓</span>
                    <span>Memenuhi kewajiban hukum dan keamanan platform.</span>
                </li>
            </ul>
        </div>

        {{-- 4. Hak Penjual --}}
        <div id="hak-penjual" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">4. Hak Penjual</h2>
            <p class="mb-3">Penjual memiliki hak untuk:</p>
            <ul class="space-y-2 text-gray-700 mb-4">
                <li class="flex items-start gap-2">
                    <span class="text-blue-600 font-bold">•</span>
                    <span><strong>Mengakses</strong> data pribadi mereka yang tersimpan di sistem.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-600 font-bold">•</span>
                    <span><strong>Memperbarui</strong> data pribadi yang tidak akurat atau usang.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-600 font-bold">•</span>
                    <span><strong>Menghapus</strong> data pribadi mereka dari sistem (sesuai kebijakan retensi data).</span>
                </li>
            </ul>
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                <p class="text-gray-700">
                    Untuk mengajukan permintaan terkait data pribadi, penjual dapat menghubungi kami melalui
                    <a href="mailto:support@giftkita.id" class="text-[#c771d4] font-medium hover:underline">
                        support@giftkita.id
                    </a>.
                    Permintaan akan diproses dalam waktu <strong>30 hari kerja</strong>.
                </p>
            </div>
        </div>

        {{-- 5. Keamanan Data --}}
        <div id="keamanan-data" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">5. Keamanan Data</h2>
            <p class="mb-3">
                GiftKita.id menjaga data penjual dan informasi pengunjung anonim agar tetap aman
                dengan menerapkan langkah-langkah keamanan berikut:
            </p>
            <ul class="space-y-2 text-gray-700 mb-4">
                <li class="flex items-start gap-2">
                    <span class="text-green-600 font-bold">🔒</span>
                    <span><strong>Enkripsi Data:</strong> Menggunakan protokol SSL/TLS untuk melindungi data saat transmisi.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-green-600 font-bold">🔐</span>
                    <span><strong>Password Hashing:</strong> Password penjual di-hash menggunakan algoritma bcrypt sebelum disimpan.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-green-600 font-bold">🛡️</span>
                    <span><strong>Akses Terbatas:</strong> Hanya admin dan penjual yang bersangkutan yang dapat mengakses data tertentu.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-green-600 font-bold">📊</span>
                    <span><strong>Monitoring:</strong> Aktivitas sistem dipantau untuk mendeteksi akses tidak sah.</span>
                </li>
            </ul>
            <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded">
                <p class="text-sm text-gray-700">
                    ⚠️ <strong>Catatan:</strong> Meskipun kami telah menerapkan langkah-langkah keamanan yang wajar,
                    GiftKita.id tidak bertanggung jawab atas penggunaan data di luar kendali platform atau akibat
                    kelalaian pengguna dalam menjaga kerahasiaan akun mereka.
                </p>
            </div>
        </div>

        {{-- 6. Perubahan Pedoman --}}
        <div id="perubahan-pedoman" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">6. Perubahan Pedoman</h2>
            <p class="mb-3">
                GiftKita.id dapat memperbarui pedoman ini sewaktu-waktu untuk mencerminkan perubahan
                dalam praktik privasi kami atau peraturan perundang-undangan yang berlaku.
            </p>
            <p class="mb-3">
                Perubahan akan berlaku segera setelah dipublikasikan di website. Kami akan mengupdate
                tanggal "Terakhir Diperbarui" di bagian atas halaman ini.
            </p>
            <p>
                Disarankan pengunjung dan penjual mengecek halaman ini secara berkala untuk mengetahui
                versi terbaru dari Pedoman Perlindungan Data Pribadi.
            </p>
        </div>

        {{-- 7. Kontak Kami --}}
        <div id="kontak" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">7. Kontak Kami</h2>
            <p class="mb-4">
                Jika Anda memiliki pertanyaan, permintaan, atau keluhan terkait Pedoman Perlindungan Data Pribadi ini,
                silakan hubungi kami melalui:
            </p>
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 border border-gray-200 rounded-lg p-6 space-y-3">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">📧</span>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <a href="mailto:support@giftkita.id" class="text-[#007daf] font-medium hover:underline">
                            support@giftkita.id
                        </a>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-2xl">📱</span>
                    <div>
                        <p class="text-sm text-gray-500">WhatsApp</p>
                        <a href="https://wa.me/6282249219360" class="text-[#007daf] font-medium hover:underline">
                            +62 822-4921-9360
                        </a>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🌐</span>
                    <div>
                        <p class="text-sm text-gray-500">Instagram</p>
                        <a href="https://instagram.com/giftkita.id" target="_blank" class="text-[#007daf] font-medium hover:underline">
                            @giftkita.id
                        </a>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-2xl">📍</span>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Alamat</p>
                        <p class="text-gray-700 leading-relaxed">
                            Program Studi Keamanan Sistem Informasi<br>
                            Jurusan Teknik Informatika<br>
                            Politeknik Negeri Bengkalis<br>
                            Jl. Bathin Alam, Desa Sungai Alam<br>
                            Kecamatan Bengkalis, Kabupaten Bengkalis<br>
                            Provinsi Riau - Indonesia<br>
                            Kode Pos: 28712
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 border-l-4 border-[#007daf] p-6 rounded-lg text-center">
            <p class="font-semibold text-gray-800 text-lg">
                Dengan menggunakan layanan GiftKita.id, Anda menyatakan telah membaca dan memahami
                Pedoman Perlindungan Data Pribadi ini.
            </p>
        </div>

    </section>
</div>

{{-- Smooth Scroll Script --}}
<script>
    document.querySelectorAll('aside a[href^="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Highlight active section in sidebar
    const sections = document.querySelectorAll('section > div[id]');
    const navLinks = document.querySelectorAll('aside a');

    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            if (pageYOffset >= sectionTop - 150) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('text-[#c771d4]', 'font-semibold');
            if (link.getAttribute('href').substring(1) === current) {
                link.classList.add('text-[#c771d4]', 'font-semibold');
            }
        });
    });
</script>
@endsection
