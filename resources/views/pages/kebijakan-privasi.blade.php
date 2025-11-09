@extends('layouts.app')

@section('title', 'Kebijakan Privasi | GiftKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-8 py-8 flex flex-col md:flex-row gap-8">

    {{-- Sidebar Daftar Isi --}}
    <aside class="md:w-1/4 bg-white border rounded-xl shadow-md p-6 h-max md:sticky md:top-32">
        <h2 class="font-bold text-lg mb-4 text-[#007daf]">Daftar Isi</h2>
        <ul class="space-y-2 text-gray-700 text-sm">
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
        </ul>
    </aside>

    {{-- Konten Utama --}}
    <section class="md:w-3/4 space-y-8 leading-relaxed">

        {{-- Header --}}
        <div class="border-b pb-4">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                Pedoman Perlindungan Data Pribadi GiftKita.id
            </h1>
            <p class="text-sm text-gray-500">Terakhir Diperbarui: 3 November 2025</p>
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

            <h3 class="font-semibold text-gray-800 mb-2">Dari penjual:</h3>
            <p class="mb-4">
                Data yang disediakan untuk promosi, misalnya: profil sosial media, foto produk,
                nama, dan kontak yang relevan.
            </p>

            <h3 class="font-semibold text-gray-800 mb-2">Dari pengunjung:</h3>
            <p>
                Interaksi dengan website secara anonim, misalnya kunjungan ke halaman promosi.
            </p>
        </div>

        {{-- 3. Penggunaan Data --}}
        <div id="penggunaan-data" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">3. Penggunaan Data</h2>
            <p class="mb-2">Data digunakan untuk:</p>
            <ul class="list-disc pl-6 space-y-1">
                <li>Menampilkan promosi dan informasi produk dari penjual.</li>
                <li>Meningkatkan pengalaman dan kinerja website.</li>
                <li>Memberikan dukungan terkait promosi penjual.</li>
                <li>Memenuhi kewajiban hukum dan keamanan platform.</li>
            </ul>
        </div>

        {{-- 4. Hak Penjual --}}
        <div id="hak-penjual" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">4. Hak Penjual</h2>
            <p class="mb-2">Penjual dapat:</p>
            <p>
                Meminta akses, pembaruan, atau penghapusan data mereka dengan menghubungi
                <a href="mailto:support@giftkita.id" class="text-[#c771d4] font-medium hover:underline">
                    support@giftkita.id
                </a>.
                Permintaan akan diproses dalam waktu 30 hari kerja.
            </p>
        </div>

        {{-- 5. Keamanan Data --}}
        <div id="keamanan-data" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">5. Keamanan Data</h2>
            <p>
                GiftKita.id menjaga data penjual dan informasi pengunjung anonim agar tetap aman.
                Namun, GiftKita.id tidak bertanggung jawab atas penggunaan data di luar kendali platform.
            </p>
        </div>

        {{-- 6. Perubahan Pedoman --}}
        <div id="perubahan-pedoman" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">6. Perubahan Pedoman</h2>
            <p>
                GiftKita.id dapat memperbarui pedoman ini sewaktu-waktu. Disarankan pengunjung dan
                penjual mengecek website secara berkala untuk versi terbaru.
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
</script>
@endsection
