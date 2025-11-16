@extends('layouts.app')

@section('title', $produk->nama . ' | GiftKita')

@section('content')
<div class="min-h-screen bg-white py-12 px-4">
    <div class="max-w-7xl mx-auto">
        
        {{-- Back Button --}}
        <div class="mb-6 animate-fade-down">
            <a href="{{ route('katalog.index') }}" class="inline-flex items-center gap-2 bg-[#007daf] hover:bg-[#006b9c] text-white px-6 py-3 rounded-xl hover:shadow-lg transition-all duration-300">
                <i class='bx bx-arrow-back text-xl'></i>
                Kembali ke Katalog
            </a>
        </div>

        {{-- Main Content --}}
        <div class="grid md:grid-cols-2 gap-8">
            
            {{-- Left: Product Images Gallery --}}
            <div class="animate-fade-in space-y-6">
                {{-- Main Image Display --}}
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-200">
                    <div id="mainImageContainer" class="relative h-[500px] bg-gray-50">
                        @php
                            $firstImage = $produk->files->first();
                        @endphp
                        
                        @if($firstImage)
                            <img 
                                id="mainImage"
                                src="{{ asset('storage/' . $firstImage->filepath) }}" 
                                alt="{{ $produk->nama }}"
                                class="w-full h-full object-contain transition-all duration-500"
                            >
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class='bx bx-image text-gray-300 text-8xl'></i>
                            </div>
                        @endif

                        {{-- Navigation Arrows (if multiple images) --}}
                        @if($produk->files->count() > 1)
                            <button 
                                onclick="previousImage()"
                                class="absolute left-4 top-1/2 -translate-y-1/2 bg-[#007daf] hover:bg-[#006b9c] text-white rounded-full p-3 transition-all duration-300 hover:scale-110 shadow-lg"
                            >
                                <i class='bx bx-chevron-left text-2xl'></i>
                            </button>
                            <button 
                                onclick="nextImage()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 bg-[#007daf] hover:bg-[#006b9c] text-white rounded-full p-3 transition-all duration-300 hover:scale-110 shadow-lg"
                            >
                                <i class='bx bx-chevron-right text-2xl'></i>
                            </button>
                        @endif

                        {{-- Category Badge --}}
                        <div class="absolute top-4 left-4">
                            <span class="bg-[#007daf] text-white text-sm font-semibold px-4 py-2 rounded-full shadow-lg">
                                {{ $produk->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </div>
                    </div>

                    {{-- Thumbnail Gallery --}}
                    @if($produk->files->count() > 1)
                        <div class="p-4 bg-white flex gap-3 overflow-x-auto border-t border-gray-200">
                            @foreach($produk->files as $index => $file)
                                <button 
                                    onclick="changeMainImage('{{ asset('storage/' . $file->filepath) }}', {{ $index }})"
                                    class="thumbnail flex-shrink-0 w-24 h-24 rounded-xl overflow-hidden border-2 {{ $index === 0 ? 'border-[#007daf]' : 'border-gray-300' }} hover:border-[#007daf] transition-all duration-300 hover:scale-110"
                                    data-index="{{ $index }}"
                                >
                                    <img 
                                        src="{{ asset('storage/' . $file->filepath) }}" 
                                        alt="Thumbnail {{ $index + 1 }}"
                                        class="w-full h-full object-cover"
                                    >
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right: Product Information --}}
            <div class="space-y-6 animate-fade-in" style="animation-delay: 0.2s;">
                
                {{-- Product Name & Price Card --}}
                <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 border border-gray-200">
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-4 leading-tight">
                        {{ $produk->nama }}
                    </h1>

                    <div class="flex items-baseline gap-3 mb-6">
                        <span class="text-5xl font-bold text-[#c771d4]">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Posted Date --}}
                    <div class="flex items-center gap-2 text-sm text-gray-600 mb-6 bg-gray-50 px-4 py-3 rounded-xl w-fit border border-gray-200">
                        <i class='bx bx-time-five text-[#007daf] text-lg'></i>
                        <span class="font-medium">Diposting {{ $produk->created_at->diffForHumans() }}</span>
                    </div>

                    {{-- Order Button --}}
                    <button 
                        onclick="openOrderModal()"
                        class="w-full bg-[#c771d4] hover:bg-[#b560c3] text-white font-bold py-5 rounded-2xl transition-all duration-300 hover:shadow-2xl hover:scale-105 flex items-center justify-center gap-3 group"
                    >
                        <i class='bx bx-cart text-3xl group-hover:animate-bounce'></i>
                        <span class="text-xl">Pesan Sekarang</span>
                    </button>
                </div>

                {{-- Description Section --}}
                @if($produk->deskripsi)
                    <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 border border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2 pb-4 border-b border-gray-200">
                            <div class="w-10 h-10 rounded-full bg-[#ffb829] flex items-center justify-center">
                                <i class='bx bx-detail text-white text-xl'></i>
                            </div>
                            Deskripsi Produk
                        </h2>
                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($produk->deskripsi)) !!}
                        </div>
                    </div>
                @endif

                {{-- Share Product Section --}}
                <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 border border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class='bx bx-share-alt text-[#007daf] text-2xl'></i>
                        Bagikan Produk
                    </h2>

                    <div class="flex flex-wrap gap-3">
                        {{-- WhatsApp --}}
                        <button 
                            onclick="shareToWhatsApp()"
                            class="flex items-center gap-2 bg-[#25D366] hover:bg-[#20ba5a] text-white px-5 py-3 rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg group"
                        >
                            <img src="{{ asset('icons/whatsapp.png') }}" alt="WhatsApp" class="w-6 h-6 group-hover:rotate-12 transition-transform">
                            <span class="font-semibold">WhatsApp</span>
                        </button>

                        {{-- Telegram --}}
                        <button 
                            onclick="shareToTelegram()"
                            class="flex items-center gap-2 bg-[#0088cc] hover:bg-[#0077b5] text-white px-5 py-3 rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg group"
                        >
                            <img src="{{ asset('icons/telegram.png') }}" alt="Telegram" class="w-6 h-6 group-hover:rotate-12 transition-transform">
                            <span class="font-semibold">Telegram</span>
                        </button>

                        {{-- X (Twitter) --}}
                        <button 
                            onclick="shareToX()"
                            class="flex items-center gap-2 bg-[#f5f5f5] hover:bg-gray-800 text-black px-5 py-3 rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg group"
                        >
                            <img src="{{ asset('icons/x.png') }}" alt="X" class="w-6 h-6 group-hover:rotate-12 transition-transform">
                            <span class="font-semibold">X(Twitter)</span>
                        </button>

                        {{-- Instagram (Note: Instagram doesn't support direct sharing via URL) --}}
                        <button 
                            onclick="showInstagramMessage()"
                            class="flex items-center gap-2 bg-gradient-to-br from-[#833AB4] via-[#FD1D1D] to-[#F77737] hover:from-[#7232a8] hover:via-[#e91b1b] hover:to-[#e06b2f] text-white px-5 py-3 rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg group"
                        >
                            <img src="{{ asset('icons/instagram.png') }}" alt="Instagram" class="w-6 h-6 group-hover:rotate-12 transition-transform">
                            <span class="font-semibold">Instagram</span>
                        </button>

                        {{-- Copy Link --}}
                        <button 
                            onclick="copyProductLink()"
                            id="copyLinkBtn"
                            class="flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-5 py-3 rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg group"
                        >
                            <img src="{{ asset('icons/link.png') }}" alt="Copy Link" id="linkIcon" class="w-6 h-6 group-hover:rotate-12 transition-transform">
                            <span class="font-semibold">Salin Link</span>
                        </button>
                    </div>

                    {{-- Success Message for Copy Link --}}
                    <div id="copySuccessMessage" class="hidden mt-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2">
                        <i class='bx bx-check-circle text-xl'></i>
                        <span class="font-medium">Link berhasil disalin!</span>
                    </div>
                </div>

                {{-- Toko Info Card --}}
                <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 border border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class='bx bx-store text-[#007daf] text-2xl'></i>
                        Informasi Toko
                    </h2>

                    <div class="flex items-center gap-4 mb-6 p-4 bg-gray-50 rounded-2xl border border-gray-200">
                        @if($produk->toko->foto_profil)
                            <img 
                                src="{{ asset($produk->toko->foto_profil) }}" 
                                alt="{{ $produk->toko->nama_toko }}"
                                class="w-16 h-16 rounded-full object-cover border-4 border-[#007daf] shadow-lg"
                            >
                        @else
                            <div class="w-16 h-16 rounded-full bg-[#007daf] flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                                {{ substr($produk->toko->nama_toko, 0, 1) }}
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900">{{ $produk->toko->nama_toko }}</h3>
                            @if($produk->toko->alamat_toko)
                                <p class="text-sm text-gray-600 flex items-center gap-1 mt-1">
                                    <i class='bx bx-map text-[#007daf]'></i>
                                    {{ $produk->toko->alamat_toko }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <a 
                        href="{{ route('toko.show', $produk->toko->id) }}"
                        class="w-full bg-[#007daf] hover:bg-[#006b9c] text-white font-semibold py-4 rounded-xl transition-all duration-300 hover:shadow-xl hover:scale-105 flex items-center justify-center gap-2 group"
                    >
                        <i class='bx bx-store-alt group-hover:rotate-12 transition-transform'></i>
                        Kunjungi Toko
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Include Modal Pesanan --}}
@include('katalog.partials.order-modal')

{{-- Hidden data untuk JavaScript --}}
<script>
// Image gallery data
const images = [
    @foreach($produk->files as $file)
        "{{ asset('storage/' . $file->filepath) }}",
    @endforeach
];
let currentImageIndex = 0;

function changeMainImage(imageUrl, index) {
    const mainImage = document.getElementById('mainImage');
    if (mainImage) {
        mainImage.style.opacity = '0';
        setTimeout(() => {
            mainImage.src = imageUrl;
            mainImage.style.opacity = '1';
            currentImageIndex = index;
            updateThumbnailBorders();
        }, 200);
    }
}

function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % images.length;
    changeMainImage(images[currentImageIndex], currentImageIndex);
}

function previousImage() {
    currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
    changeMainImage(images[currentImageIndex], currentImageIndex);
}

function updateThumbnailBorders() {
    document.querySelectorAll('.thumbnail').forEach((thumb, index) => {
        if (index === currentImageIndex) {
            thumb.classList.remove('border-gray-300');
            thumb.classList.add('border-[#007daf]');
        } else {
            thumb.classList.remove('border-[#007daf]');
            thumb.classList.add('border-gray-300');
        }
    });
}

// Set produk ID untuk modal
function openOrderModal() {
    const modal = document.getElementById('orderModal');
    if (modal) {
        modal.classList.remove('hidden');
        document.getElementById('produk_id').value = '{{ $produk->id }}';
        document.body.style.overflow = 'hidden';
    }
}

// Keyboard navigation for images
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowRight') {
        nextImage();
    } else if (e.key === 'ArrowLeft') {
        previousImage();
    }
});

// Social Media Share Functions
const productUrl = "{{ url()->current() }}";
const productTitle = "{{ $produk->nama }}";
const productPrice = "Rp {{ number_format($produk->harga, 0, ',', '.') }}";
const shareText = `Lihat produk menarik ini: ${productTitle} - ${productPrice}`;

function shareToWhatsApp() {
    const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(shareText + ' ' + productUrl)}`;
    window.open(whatsappUrl, '_blank');
}

function shareToTelegram() {
    const telegramUrl = `https://t.me/share/url?url=${encodeURIComponent(productUrl)}&text=${encodeURIComponent(shareText)}`;
    window.open(telegramUrl, '_blank');
}

function shareToX() {
    const xUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(shareText)}&url=${encodeURIComponent(productUrl)}`;
    window.open(xUrl, '_blank');
}

function showInstagramMessage() {
    alert('Untuk membagikan ke Instagram:\n\n1. Salin link produk menggunakan tombol "Salin Link"\n2. Buka aplikasi Instagram\n3. Buat Story atau Post baru\n4. Tempelkan link di bio atau caption Anda');
}

function copyProductLink() {
    navigator.clipboard.writeText(productUrl).then(function() {
        // Show success message
        const successMsg = document.getElementById('copySuccessMessage');
        const copyBtn = document.getElementById('copyLinkBtn');
        const linkIcon = document.getElementById('linkIcon');
        
        successMsg.classList.remove('hidden');
        linkIcon.src = "{{ asset('icons/check.png') }}";
        copyBtn.querySelector('span').textContent = 'Tersalin!';
        copyBtn.classList.remove('bg-gray-600', 'hover:bg-gray-700');
        copyBtn.classList.add('bg-green-600', 'hover:bg-green-700');
        
        // Reset after 3 seconds
        setTimeout(() => {
            successMsg.classList.add('hidden');
            linkIcon.src = "{{ asset('icons/link.png') }}";
            copyBtn.querySelector('span').textContent = 'Salin Link';
            copyBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
            copyBtn.classList.add('bg-gray-600', 'hover:bg-gray-700');
        }, 3000);
    }).catch(function(err) {
        alert('Gagal menyalin link. Silakan coba lagi.');
    });
}
</script>

<style>
#mainImage {
    transition: opacity 0.3s ease-in-out;
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out forwards;
}

@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-up {
    animation: fade-up 0.8s ease-out;
}

@keyframes fade-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-down {
    animation: fade-down 0.6s ease-out;
}

@keyframes fade-down {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.prose {
    font-size: 1rem;
    line-height: 1.75;
}

/* Custom scrollbar for thumbnail gallery */
.overflow-x-auto::-webkit-scrollbar {
    height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f9fafb;
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #007daf;
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #006b9c;
}
</style>
@endsection