@extends('layouts.app')

@section('title', 'Kebijakan Layanan | GiftKita')

@section('content')

{{-- Hero Section with Gradient Background --}}
<div class="bg-gradient-to-r from-[#007daf] via-purple-500 to-[#c771d4] text-white py-16 mb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            Kebijakan Layanan GiftKita.id
        </h1>
        <p class="text-lg opacity-90">
            Mengenal lebih dekat tentang syarat dan ketentuan penggunaan platform kami
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
                <a href="#definisi" class="block py-1 hover:text-[#c771d4] transition">
                    1. Definisi
                </a>
            </li>
            <li>
                <a href="#ruang-lingkup" class="block py-1 hover:text-[#c771d4] transition">
                    2. Ruang Lingkup Layanan
                </a>
            </li>
            <li>
                <a href="#hak-pembeli" class="block py-1 hover:text-[#c771d4] transition">
                    3. Hak dan Kewajiban Pembeli
                </a>
            </li>
            <li>
                <a href="#hak-penjual" class="block py-1 hover:text-[#c771d4] transition">
                    4. Hak dan Kewajiban Penjual
                </a>
            </li>
            <li>
                <a href="#hak-admin" class="block py-1 hover:text-[#c771d4] transition">
                    5. Hak dan Kewajiban Admin
                </a>
            </li>
            <li>
                <a href="#batasan-penggunaan" class="block py-1 hover:text-[#c771d4] transition">
                    6. Batasan Penggunaan
                </a>
            </li>
            <li>
                <a href="#perlindungan-data" class="block py-1 hover:text-[#c771d4] transition">
                    7. Perlindungan Data dan Privasi
                </a>
            </li>
            <li>
                <a href="#pembatasan-tanggung-jawab" class="block py-1 hover:text-[#c771d4] transition">
                    8. Pembatasan Tanggung Jawab
                </a>
            </li>
            <li>
                <a href="#perubahan-layanan" class="block py-1 hover:text-[#c771d4] transition">
                    9. Perubahan Layanan
                </a>
            </li>
            <li>
                <a href="#penyelesaian-sengketa" class="block py-1 hover:text-[#c771d4] transition">
                    10. Penyelesaian Sengketa
                </a>
            </li>
            <li>
                <a href="#kontak" class="block py-1 hover:text-[#c771d4] transition">
                    11. Kontak Kami
                </a>
            </li>
            <li>
                <a href="#hukum-berlaku" class="block py-1 hover:text-[#c771d4] transition">
                    12. Hukum yang Berlaku
                </a>
            </li>
        </ul>
    </aside>

    {{-- Konten Utama --}}
    <section class="md:w-3/4 space-y-8 leading-relaxed">

        {{-- Intro (tanpa background) --}}
        <div id="intro" class="scroll-mt-32 border-l-4 border-[#007daf] pl-6">
            <p class="text-gray-700 text-lg leading-relaxed">
                Selamat datang di GiftKita.id. Dengan mengakses dan menggunakan platform kami,
                Anda dianggap telah membaca, memahami, dan menyetujui seluruh syarat dan ketentuan
                yang tercantum dalam Kebijakan Layanan ini. Jika Anda tidak menyetujui salah satu
                atau seluruh ketentuan ini, mohon untuk tidak menggunakan layanan GiftKita.id.
            </p>
        </div>

        {{-- 1. Definisi --}}
        <div id="definisi" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">1. Definisi</h2>
            <ul class="space-y-2 text-gray-700">
                <li class="pl-4 border-l-2 border-gray-200">
                    <strong>GiftKita.id</strong> atau <strong>"Kami"</strong> adalah platform berbasis web
                    yang dikembangkan oleh Kelompok 1 Mahasiswa Program Studi Keamanan Sistem Informasi,
                    Politeknik Negeri Bengkalis, yang berfungsi sebagai media yang mempertemukan penjual
                    hampers dengan pembeli.
                </li>
                <li class="pl-4 border-l-2 border-gray-200">
                    <strong>Pengguna</strong> adalah setiap orang atau pihak yang mengakses dan menggunakan
                    layanan GiftKita.id, termasuk Pembeli, Penjual, dan Admin.
                </li>
                <li class="pl-4 border-l-2 border-gray-200">
                    <strong>Pembeli</strong> adalah pengguna umum yang dapat mengakses katalog, melakukan
                    pemesanan, dan berkomunikasi dengan penjual melalui media sosial.
                </li>
                <li class="pl-4 border-l-2 border-gray-200">
                    <strong>Penjual</strong> adalah pengguna yang memiliki akun login dan berhak mengelola
                    toko, produk, serta menerima pesanan melalui sistem.
                </li>
                <li class="pl-4 border-l-2 border-gray-200">
                    <strong>Admin</strong> adalah pengelola sistem yang bertanggung jawab membuat akun login
                    untuk penjual dan mengelola operasional sistem secara keseluruhan.
                </li>
                <li class="pl-4 border-l-2 border-gray-200">
                    <strong>Produk</strong> adalah barang berupa hampers, kado, atau buket yang ditampilkan
                    dalam katalog GiftKita.id oleh penjual.
                </li>
            </ul>
        </div>

        {{-- 2. Ruang Lingkup Layanan --}}
        <div id="ruang-lingkup" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">2. Ruang Lingkup Layanan</h2>
            <p class="mb-3">
                GiftKita.id adalah platform <strong>intermediary (perantara)</strong> yang memfasilitasi
                interaksi antara penjual dan pembeli hampers. Kami <strong>tidak bertanggung jawab</strong> atas:
            </p>
            <ul class="list-disc pl-6 space-y-1 mb-4">
                <li>Proses transaksi pembayaran antara pembeli dan penjual.</li>
                <li>Kualitas, ketersediaan, dan pengiriman produk.</li>
                <li>Perselisihan yang terjadi antara pembeli dan penjual di luar sistem.</li>
            </ul>
            <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded">
                <p class="text-sm text-gray-700">
                    ⚠️ <strong>Penting:</strong> Transaksi, komunikasi, konsultasi, dan pembayaran dilakukan
                    <strong>di luar platform GiftKita.id</strong>, melalui media sosial atau kontak yang telah
                    disediakan oleh penjual.
                </p>
            </div>
        </div>

        {{-- 3. Hak dan Kewajiban Pembeli --}}
        <div id="hak-pembeli" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">3. Hak dan Kewajiban Pembeli</h2>

            <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <span class="text-green-600">✅</span> Hak Pembeli:
            </h3>
            <ul class="list-disc pl-6 space-y-1 mb-4">
                <li>Mengakses katalog produk tanpa perlu melakukan login.</li>
                <li>Melihat informasi detail produk (nama, harga, deskripsi, foto, stok).</li>
                <li>Melakukan pemesanan dengan mengisi formulir pesanan.</li>
                <li>Mendapatkan informasi kontak penjual setelah melakukan pemesanan.</li>
                <li>Mengakses fitur FAQ untuk mendapatkan bantuan terkait penggunaan sistem.</li>
                <li>Memberikan dukungan sukarela kepada pengembang melalui fitur <strong>Traktir Pembuat Sistem</strong>.</li>
            </ul>

            <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <span class="text-blue-600">📋</span> Kewajiban Pembeli:
            </h3>
            <ul class="list-disc pl-6 space-y-1">
                <li>Memberikan informasi yang benar, lengkap, dan akurat saat melakukan pemesanan.</li>
                <li>Tidak menyalahgunakan sistem untuk tujuan yang melanggar hukum atau merugikan pihak lain.</li>
                <li>Menghormati hak kekayaan intelektual penjual dan tidak menyalin, mendistribusikan, atau menggunakan konten tanpa izin.</li>
                <li>Melanjutkan proses transaksi dan komunikasi dengan penjual melalui kontak yang telah disediakan.</li>
            </ul>
        </div>

        {{-- 4. Hak dan Kewajiban Penjual --}}
        <div id="hak-penjual" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">4. Hak dan Kewajiban Penjual</h2>

            <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <span class="text-green-600">✅</span> Hak Penjual:
            </h3>
            <ul class="list-disc pl-6 space-y-1 mb-4">
                <li>Mendapatkan akun login dari admin untuk mengelola toko.</li>
                <li>Menambahkan, memperbarui, dan menghapus data produk sesuai kebutuhan.</li>
                <li>Mengelola informasi toko (nama toko, alamat, deskripsi, akun media sosial).</li>
                <li>Menerima rangkuman pesanan dari pembeli melalui media sosial yang telah didaftarkan.</li>
                <li>Mengakses fitur FAQ untuk mendapatkan panduan penggunaan sistem.</li>
            </ul>

            <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <span class="text-blue-600">📋</span> Kewajiban Penjual:
            </h3>
            <ul class="list-disc pl-6 space-y-1">
                <li>Menyediakan informasi produk yang benar, jelas, dan tidak menyesatkan.</li>
                <li>Bertanggung jawab penuh atas ketersediaan stok, kualitas produk, pengiriman, dan layanan purna jual.</li>
                <li>Merespons pesanan pembeli dengan cepat melalui media sosial yang telah didaftarkan.</li>
                <li>Tidak mengunggah konten yang melanggar hukum, mengandung unsur SARA, pornografi, kekerasan, atau hak kekayaan intelektual pihak lain.</li>
                <li>Mematuhi seluruh ketentuan dan peraturan perundang-undangan yang berlaku di Indonesia.</li>
            </ul>
        </div>

        {{-- 5. Hak dan Kewajiban Admin --}}
        <div id="hak-admin" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">5. Hak dan Kewajiban Admin</h2>

            <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <span class="text-green-600">✅</span> Hak Admin:
            </h3>
            <ul class="list-disc pl-6 space-y-1 mb-4">
                <li>Membuat, mengelola, dan menonaktifkan akun login penjual.</li>
                <li>Menghapus konten atau akun yang melanggar ketentuan layanan.</li>
                <li>Melakukan pemeliharaan, pembaruan, atau perubahan pada sistem tanpa pemberitahuan sebelumnya.</li>
            </ul>

            <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <span class="text-blue-600">📋</span> Kewajiban Admin:
            </h3>
            <ul class="list-disc pl-6 space-y-1">
                <li>Menjaga keamanan dan kerahasiaan data pengguna sesuai dengan kebijakan privasi.</li>
                <li>Memastikan sistem berjalan dengan baik dan dapat diakses 24/7 (kecuali dalam kondisi pemeliharaan atau gangguan teknis).</li>
            </ul>
        </div>

        {{-- 6. Batasan Penggunaan --}}
        <div id="batasan-penggunaan" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">6. Batasan Penggunaan</h2>
            <p class="mb-3">Pengguna <strong>DILARANG</strong> melakukan hal-hal berikut:</p>
            <ul class="space-y-2 text-gray-700">
                <li class="flex items-start gap-2">
                    <span class="text-red-500 font-bold">❌</span>
                    <span>Menggunakan sistem untuk tujuan ilegal, penipuan, atau merugikan pihak lain.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-red-500 font-bold">❌</span>
                    <span>Menyalin, memodifikasi, atau mendistribusikan konten dari GiftKita.id tanpa izin tertulis.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-red-500 font-bold">❌</span>
                    <span>Melakukan tindakan yang dapat merusak, mengganggu, atau membebani server dan infrastruktur sistem.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-red-500 font-bold">❌</span>
                    <span>Menggunakan bot, scraper, atau alat otomatis lainnya untuk mengakses atau mengumpulkan data dari sistem.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-red-500 font-bold">❌</span>
                    <span>Mengirimkan spam, virus, malware, atau kode berbahaya lainnya melalui sistem.</span>
                </li>
            </ul>
        </div>

        {{-- 7. Perlindungan Data dan Privasi --}}
        <div id="perlindungan-data" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">7. Perlindungan Data dan Privasi</h2>
            <p class="mb-3">
                Kami berkomitmen untuk melindungi data pribadi pengguna sesuai dengan peraturan
                perundang-undangan yang berlaku di Indonesia. Data yang dikumpulkan meliputi:
            </p>
            <ul class="list-disc pl-6 space-y-1 mb-4">
                <li>Nama, alamat, nomor telepon, dan informasi kontak lainnya yang diberikan saat pemesanan.</li>
                <li>Informasi toko dan produk yang diunggah oleh penjual.</li>
            </ul>
            <p class="mb-3">
                Data tersebut hanya akan digunakan untuk keperluan operasional sistem dan tidak akan
                dibagikan kepada pihak ketiga tanpa persetujuan pengguna, kecuali diwajibkan oleh hukum.
            </p>
            <p>
                Untuk informasi lebih lanjut, silakan baca
                <a href="{{ route('kebijakan-privasi') }}" class="text-[#c771d4] font-medium hover:underline">
                    Kebijakan Privasi
                </a> kami.
            </p>
        </div>

        {{-- 8. Pembatasan Tanggung Jawab --}}
        <div id="pembatasan-tanggung-jawab" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">8. Pembatasan Tanggung Jawab</h2>
            <p class="mb-3">GiftKita.id <strong>TIDAK BERTANGGUNG JAWAB</strong> atas:</p>
            <ul class="list-disc pl-6 space-y-1 mb-4">
                <li>Kerugian yang timbul akibat transaksi antara pembeli dan penjual di luar platform.</li>
                <li>Kualitas, ketersediaan, keterlambatan, atau kerusakan produk yang dipesan.</li>
                <li>Kehilangan data akibat kesalahan pengguna, gangguan teknis, atau serangan siber.</li>
                <li>Kerugian yang timbul akibat penggunaan layanan pihak ketiga (media sosial, platform pembayaran, dll).</li>
            </ul>
            <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded">
                <p class="text-sm text-gray-700">
                    ⚠️ Semua layanan disediakan <strong>"sebagaimana adanya"</strong> (as is) tanpa
                    jaminan apapun, baik tersurat maupun tersirat.
                </p>
            </div>
        </div>

        {{-- 9. Perubahan Layanan dan Ketentuan --}}
        <div id="perubahan-layanan" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">9. Perubahan Layanan dan Ketentuan</h2>
            <p class="mb-2">Kami berhak untuk:</p>
            <ul class="list-disc pl-6 space-y-1 mb-3">
                <li>Mengubah, membatasi, atau menghentikan layanan kapan saja tanpa pemberitahuan sebelumnya.</li>
                <li>Memperbarui Kebijakan Layanan ini sewaktu-waktu. Perubahan akan berlaku segera setelah dipublikasikan di situs.</li>
            </ul>
            <p>
                Pengguna disarankan untuk membaca Kebijakan Layanan secara berkala agar tetap mengetahui
                perubahan yang ada.
            </p>
        </div>

        {{-- 10. Penyelesaian Sengketa --}}
        <div id="penyelesaian-sengketa" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">10. Penyelesaian Sengketa</h2>
            <p>
                Jika terjadi perselisihan antara pengguna dan GiftKita.id, kami menganjurkan penyelesaian
                secara musyawarah. Apabila kesepakatan tidak tercapai, maka sengketa akan diselesaikan
                melalui jalur hukum yang berlaku di Indonesia dan tunduk pada yurisdiksi
                <strong>Pengadilan Negeri Bengkalis, Provinsi Riau</strong>.
            </p>
        </div>

        {{-- 11. Kontak Kami --}}
        <div id="kontak" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">11. Kontak Kami</h2>
            <p class="mb-4">
                Jika Anda memiliki pertanyaan, keluhan, atau saran terkait Kebijakan Layanan ini,
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

        {{-- 12. Hukum yang Berlaku --}}
        <div id="hukum-berlaku" class="scroll-mt-32">
            <h2 class="text-2xl font-bold text-[#007daf] mb-3">12. Hukum yang Berlaku</h2>
            <p class="mb-3">
                Kebijakan Layanan ini tunduk pada dan ditafsirkan sesuai dengan hukum Negara Republik Indonesia,
                termasuk namun tidak terbatas pada:
            </p>
            <ul class="list-disc pl-6 space-y-1">
                <li><strong>UU No. 11 Tahun 2008</strong> tentang Informasi dan Transaksi Elektronik (ITE).</li>
                <li><strong>UU No. 8 Tahun 1999</strong> tentang Perlindungan Konsumen.</li>
                <li><strong>PP No. 80 Tahun 2019</strong> tentang Perdagangan Melalui Sistem Elektronik (PMSE).</li>
            </ul>
        </div>

        {{-- Footer --}}
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 border-l-4 border-[#007daf] p-6 rounded-lg text-center">
            <p class="font-semibold text-gray-800 text-lg">
                Dengan menggunakan layanan GiftKita.id, Anda menyatakan telah membaca, memahami,
                dan menyetujui seluruh isi Kebijakan Layanan ini.
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
