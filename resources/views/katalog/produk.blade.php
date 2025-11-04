@extends('layouts.app')

@section('title', $produk->nama . ' | GiftKita')

@section('content')
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-10 sm:py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

        {{-- GALERI FOTO PRODUK --}}
        <div class="relative">
            @if($produk->files->isNotEmpty())
                <div id="carousel" class="relative overflow-hidden rounded-xl shadow-lg">
                    @foreach($produk->files as $index => $file)
                        <img src="{{ asset('storage/' . $file->filepath) }}"
                             alt="{{ $produk->nama }}"
                             class="carousel-img w-full h-80 sm:h-96 object-cover transition-opacity duration-500 {{ $index === 0 ? 'opacity-100' : 'opacity-0 absolute inset-0' }}">
                    @endforeach

                    {{-- Tombol geser kiri/kanan --}}
                    <button id="prevBtn" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white rounded-full p-2">
                        ❮
                    </button>
                    <button id="nextBtn" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white rounded-full p-2">
                        ❯
                    </button>
                </div>

                {{-- Indikator posisi foto --}}
                <div class="flex justify-center mt-3 space-x-2">
                    @foreach($produk->files as $index => $file)
                        <div class="dot w-3 h-3 rounded-full bg-gray-300 cursor-pointer {{ $index === 0 ? 'bg-[#007daf]' : '' }}"></div>
                    @endforeach
                </div>
            @else
                <div class="w-full h-80 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                    Belum ada foto produk
                </div>
            @endif
        </div>

        {{-- DETAIL PRODUK --}}
        <div class="text-center md:text-left">
            <h1 class="text-2xl sm:text-3xl font-bold mb-3 bg-clip-text text-transparent bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829]">
                {{ $produk->nama }}
            </h1>
            <p class="text-gray-600 mb-6 leading-relaxed text-sm sm:text-base">{{ $produk->deskripsi }}</p>
            <p class="text-xl sm:text-2xl font-bold text-[#007daf] mb-8">
                Rp {{ number_format($produk->harga, 0, ',', '.') }}
            </p>

            <div class="flex flex-wrap justify-center md:justify-start gap-3">
                <button id="openPesanModal"
                        class="px-5 sm:px-8 py-2 sm:py-3 rounded-xl text-white font-semibold bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] hover:scale-105 transition">
                    Pesan Sekarang
                </button>

                @if($produk->toko)
                    <a href="{{ route('toko.show', $produk->toko->id) }}"
                       class="px-5 sm:px-8 py-2 sm:py-3 rounded-xl border border-[#007daf] text-[#007daf] font-semibold hover:bg-[#007daf] hover:text-white transition shadow-sm">
                        Lihat Toko
                    </a>
                @endif

                <a href="{{ route('katalog.index') }}" 
                   class="px-5 sm:px-8 py-2 sm:py-3 rounded-xl border border-gray-300 hover:bg-gray-100 transition">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</section>

{{-- MODAL PESANAN --}}
<div id="pesanModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-2xl relative transform scale-95 transition-transform">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4 text-center">🧾 Detail Pesanan</h2>

        <form id="pesanForm" method="POST" action="{{ route('pesanan.store', $produk->id) }}">
            @csrf
            <div class="space-y-3">
                <div>
                    <label class="block text-gray-600">Nama Lengkap</label>
                    <input type="text" name="nama_pembeli" class="w-full rounded-lg border-gray-300 focus:ring-[#007daf]" required>
                </div>
                <div>
                    <label class="block text-gray-600">Email (Opsional)</label>
                    <input type="email" name="email_pembeli" class="w-full rounded-lg border-gray-300 focus:ring-[#007daf]">
                </div>
                <div>
                    <label class="block text-gray-600">Nomor HP</label>
                    <input type="text" name="no_hp_pembeli" pattern="\d+" class="w-full rounded-lg border-gray-300 focus:ring-[#007daf]" required>
                </div>
                <div>
                    <label class="block text-gray-600">Alamat Lengkap</label>
                    <textarea name="alamat_pembeli" rows="2" class="w-full rounded-lg border-gray-300 focus:ring-[#007daf]"></textarea>
                </div>
                <div>
                    <label class="block text-gray-600">Jumlah</label>
                    <input type="number" name="jumlah" min="1" value="1" class="w-full rounded-lg border-gray-300 focus:ring-[#007daf]" required>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" id="batalPesan" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 rounded-lg text-white font-semibold bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] hover:scale-105 transition">
                    Kirim Pesanan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- POPUP SUKSES --}}
<div id="successPopup"
     class="hidden fixed inset-0 flex items-center justify-center z-50 bg-black/40 backdrop-blur-sm">
    <div class="bg-white p-6 rounded-xl shadow-2xl text-center animate-bounce-in">
        <div class="text-4xl mb-3">✅</div>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">Pesanan Berhasil Dikirim!</h3>
        <p class="text-gray-500 mb-4">Penjual akan segera menghubungi Anda.</p>
        <button id="okPopup"
                class="px-4 py-2 bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white rounded-lg shadow hover:scale-105 transition">
            Oke
        </button>
    </div>
</div>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const imgs = document.querySelectorAll('.carousel-img');
    if (imgs.length > 0) {
        const dots = document.querySelectorAll('.dot');
        let current = 0;

        const showSlide = (index) => {
            imgs.forEach((img, i) => {
                img.classList.toggle('opacity-100', i === index);
                img.classList.toggle('opacity-0', i !== index);
                if(dots[i]) {
                    dots[i].classList.toggle('bg-[#007daf]', i === index);
                    dots[i].classList.toggle('bg-gray-300', i !== index);
                }
            });
        };

        document.getElementById('nextBtn').addEventListener('click', () => {
            current = (current + 1) % imgs.length;
            showSlide(current);
        });
        document.getElementById('prevBtn').addEventListener('click', () => {
            current = (current - 1 + imgs.length) % imgs.length;
            showSlide(current);
        });
        dots.forEach((dot, i) => dot.addEventListener('click', () => {
            current = i;
            showSlide(i);
        }));
    }

    // Modal Pesanan
    const pesanModal = document.getElementById('pesanModal');
    const pesanBtn = document.getElementById('openPesanModal');
    const batalPesan = document.getElementById('batalPesan');
    const successPopup = document.getElementById('successPopup');
    const okPopup = document.getElementById('okPopup');
    const form = document.getElementById('pesanForm');

    pesanBtn.addEventListener('click', () => {
        pesanModal.classList.remove('hidden');
        pesanModal.classList.add('flex');
    });

    batalPesan.addEventListener('click', () => {
        pesanModal.classList.add('hidden');
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);

        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        });

        if (response.ok) {
            pesanModal.classList.add('hidden');
            successPopup.classList.remove('hidden');
        } else {
            alert('Terjadi kesalahan, coba lagi.');
        }
    });

    okPopup.addEventListener('click', () => {
        successPopup.classList.add('hidden');
        form.reset();
    });
});
</script>

<style>
@keyframes bounce-in {
  0% { transform: scale(0.8); opacity: 0; }
  60% { transform: scale(1.05); opacity: 1; }
  100% { transform: scale(1); }
}
.animate-bounce-in { animation: bounce-in 0.4s ease; }
</style>
@endsection
