@extends('layouts.app')

@section('title', $produk->nama . ' | GiftKita')

@section('content')
<div class="min-h-screen bg-white py-12 px-4">
    <div class="max-w-7xl mx-auto">
        
        {{-- Back Button --}}
        <div class="mb-6 animate-fade-down">
            <a href="{{ route('katalog.index') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-[#007daf] to-[#0096d9] text-white px-6 py-3 rounded-xl hover:shadow-lg transition-all duration-300">
                <i class='bx bx-arrow-back text-xl'></i>
                Kembali ke Katalog
            </a>
        </div>

        {{-- Main Content --}}
        <div class="grid md:grid-cols-2 gap-8">
            
            {{-- Left: Product Images Gallery --}}
            <div class="animate-fade-in space-y-6">
                {{-- Main Image Display --}}
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border-2 border-gray-100">
                    <div id="mainImageContainer" class="relative h-[500px] bg-gradient-to-br from-gray-50 to-gray-100">
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
                                <i class='bx bx-image text-gray-400 text-8xl'></i>
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
                            <span class="bg-gradient-to-r from-[#007daf] to-[#0096d9] text-white text-sm font-semibold px-4 py-2 rounded-full shadow-lg backdrop-blur-sm">
                                {{ $produk->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </div>

                        {{-- Stock Badge --}}
                        @if($produk->stok <= 5)
                            <div class="absolute top-4 right-4">
                                <span class="bg-red-500 text-white text-sm font-semibold px-4 py-2 rounded-full shadow-lg backdrop-blur-sm animate-pulse">
                                    Stok: {{ $produk->stok }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Thumbnail Gallery --}}
                    @if($produk->files->count() > 1)
                        <div class="p-4 bg-gray-50 flex gap-3 overflow-x-auto">
                            @foreach($produk->files as $index => $file)
                                <button 
                                    onclick="changeMainImage('{{ asset('storage/' . $file->filepath) }}', {{ $index }})"
                                    class="thumbnail flex-shrink-0 w-24 h-24 rounded-xl overflow-hidden border-2 {{ $index === 0 ? 'border-[#007daf]' : 'border-gray-200' }} hover:border-[#007daf] transition-all duration-300 hover:scale-110"
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
                <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 border-2 border-gray-100">
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-4 leading-tight">
                        {{ $produk->nama }}
                    </h1>

                    <div class="flex items-baseline gap-3 mb-6">
                        <span class="text-5xl font-bold bg-gradient-to-r from-[#c771d4] to-[#d98fd4] bg-clip-text text-transparent">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Posted Date --}}
                    <div class="flex items-center gap-2 text-sm text-gray-600 mb-6 bg-gradient-to-r from-blue-50 to-purple-50 px-4 py-3 rounded-xl w-fit border border-blue-100">
                        <i class='bx bx-time-five text-[#007daf] text-lg'></i>
                        <span class="font-medium">Diposting {{ $produk->created_at->diffForHumans() }}</span>
                    </div>

                    {{-- Order Button --}}
                    <button 
                        onclick="openOrderModal()"
                        class="w-full bg-gradient-to-r from-[#c771d4] via-[#c771d4] to-[#d98fd4] text-white font-bold py-5 rounded-2xl transition-all duration-300 hover:shadow-2xl hover:scale-105 flex items-center justify-center gap-3 group border-2 border-purple-200"
                    >
                        <i class='bx bx-cart text-3xl group-hover:animate-bounce'></i>
                        <span class="text-xl">Pesan Sekarang</span>
                    </button>
                </div>

                {{-- Toko Info Card --}}
                <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 border-2 border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class='bx bx-store text-[#007daf] text-2xl'></i>
                        Informasi Toko
                    </h2>

                    <div class="flex items-center gap-4 mb-6 p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl border border-blue-200">
                        @if($produk->toko->foto_profil)
                            <img 
                                src="{{ asset($produk->toko->foto_profil) }}" 
                                alt="{{ $produk->toko->nama_toko }}"
                                class="w-16 h-16 rounded-full object-cover border-4 border-[#007daf] shadow-lg"
                            >
                        @else
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#007daf] to-[#0096d9] flex items-center justify-center text-white text-2xl font-bold shadow-lg">
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
                        href="{{ route('toko.show', $produk->toko->uuid) }}"
                        class="w-full bg-gradient-to-r from-[#007daf] to-[#0096d9] text-white font-semibold py-4 rounded-xl transition-all duration-300 hover:shadow-xl hover:scale-105 flex items-center justify-center gap-2 group border-2 border-blue-200"
                    >
                        <i class='bx bx-store-alt group-hover:rotate-12 transition-transform'></i>
                        Kunjungi Toko
                    </a>
                </div>

                {{-- Location Card --}}
                @if($produk->toko->hasMapLocation())
                    <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 border-2 border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class='bx bx-map-pin text-[#c771d4] text-2xl'></i>
                            Lokasi Toko
                        </h2>

                        <div class="rounded-2xl overflow-hidden border-4 border-gray-100 mb-4 shadow-lg">
                            <iframe 
                                src="{{ $produk->toko->embed_url }}" 
                                width="100%" 
                                height="250" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>

                        <a 
                            href="{{ $produk->toko->map_link }}" 
                            target="_blank"
                            class="w-full bg-gradient-to-r from-[#ffb829] to-[#ffc850] text-white font-semibold py-4 rounded-xl transition-all duration-300 hover:shadow-xl hover:scale-105 flex items-center justify-center gap-2 group border-2 border-yellow-200"
                        >
                            <i class='bx bx-map group-hover:rotate-12 transition-transform'></i>
                            Buka di Google Maps
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Description Section --}}
        @if($produk->deskripsi)
            <div class="mt-8 bg-white rounded-3xl shadow-xl p-8 animate-fade-up hover:shadow-2xl transition-all duration-300 border-2 border-gray-100">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2 pb-4 border-b-2 border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#ffb829] to-[#ffc850] flex items-center justify-center">
                        <i class='bx bx-detail text-white text-2xl'></i>
                    </div>
                    Deskripsi Produk
                </h2>
                <div class="prose max-w-none text-gray-700 leading-relaxed text-lg">
                    {!! nl2br(e($produk->deskripsi)) !!}
                </div>
            </div>
        @endif
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
            thumb.classList.remove('border-gray-200');
            thumb.classList.add('border-[#007daf]');
        } else {
            thumb.classList.remove('border-[#007daf]');
            thumb.classList.add('border-gray-200');
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
    font-size: 1.125rem;
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
    background: linear-gradient(90deg, #007daf, #c771d4);
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(90deg, #006b9c, #b560c3);
}
</style>
@endsectionvalue = '{{ $produk->id }}';
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
    font-size: 1.125rem;
    line-height: 1.75;
}

/* Custom scrollbar for thumbnail gallery */
.overflow-x-auto::-webkit-scrollbar {
    height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: linear-gradient(90deg, #007daf, #c771d4);
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(90deg, #006b9c, #b560c3);
}
</style>
@endsection