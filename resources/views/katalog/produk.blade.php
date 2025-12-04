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
            
            {{-- Left: Product Images/Videos Gallery --}}
            <div class="animate-fade-in space-y-6">
                {{-- Main Media Display --}}
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border-2 border-gray-100">
                    <div id="mainMediaContainer" class="relative h-[500px] bg-gradient-to-br from-gray-50 to-gray-100">
                        @php
                            $firstFile = $produk->files->first();
                        @endphp
                        
                        @if($firstFile)
                            @php
                                $extension = strtolower(pathinfo($firstFile->filepath, PATHINFO_EXTENSION));
                                $isVideo = in_array($extension, ['mp4', 'webm', 'ogg', 'mov', 'avi']);
                            @endphp
                            
                            @if($isVideo)
                                <video 
                                    id="mainMedia"
                                    src="{{ asset('storage/' . $firstFile->filepath) }}" 
                                    class="w-full h-full object-contain"
                                    controls
                                    controlsList="nodownload"
                                    preload="metadata"
                                >
                                    Browser Anda tidak mendukung video HTML5.
                                </video>
                            @else
                                <img 
                                    id="mainMedia"
                                    src="{{ asset('storage/' . $firstFile->filepath) }}" 
                                    alt="{{ $produk->nama }}"
                                    class="w-full h-full object-contain transition-all duration-500"
                                >
                            @endif
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class='bx bx-image text-gray-400 text-8xl'></i>
                            </div>
                        @endif

                        {{-- Navigation Arrows (if multiple files) --}}
                        @if($produk->files->count() > 1)
                            <button 
                                onclick="previousMedia()"
                                class="absolute left-4 top-1/2 -translate-y-1/2 bg-[#007daf] hover:bg-[#006b9c] text-white rounded-full p-3 transition-all duration-300 hover:scale-110 shadow-lg z-10"
                            >
                                <i class='bx bx-chevron-left text-2xl'></i>
                            </button>
                            <button 
                                onclick="nextMedia()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 bg-[#007daf] hover:bg-[#006b9c] text-white rounded-full p-3 transition-all duration-300 hover:scale-110 shadow-lg z-10"
                            >
                                <i class='bx bx-chevron-right text-2xl'></i>
                            </button>
                        @endif

                        {{-- Category Badge --}}
                        <div class="absolute top-4 left-4 z-10">
                            <span class="bg-gradient-to-r from-[#007daf] to-[#0096d9] text-white text-sm font-semibold px-4 py-2 rounded-full shadow-lg backdrop-blur-sm">
                                {{ $produk->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </div>
                    </div>

                    {{-- Thumbnail Gallery --}}
                    @if($produk->files->count() > 1)
                        <div class="p-4 bg-gray-50 flex gap-3 overflow-x-auto">
                            @foreach($produk->files as $index => $file)
                                @php
                                    $extension = strtolower(pathinfo($file->filepath, PATHINFO_EXTENSION));
                                    $isVideo = in_array($extension, ['mp4', 'webm', 'ogg', 'mov', 'avi']);
                                @endphp
                                
                                <button 
                                    onclick="changeMainMedia({{ $index }})"
                                    class="thumbnail relative flex-shrink-0 w-24 h-24 rounded-xl overflow-hidden border-2 {{ $index === 0 ? 'border-[#007daf]' : 'border-gray-200' }} hover:border-[#007daf] transition-all duration-300 hover:scale-110"
                                    data-index="{{ $index }}"
                                >
                                    @if($isVideo)
                                        <video 
                                            src="{{ asset('storage/' . $file->filepath) }}" 
                                            class="w-full h-full object-cover"
                                            preload="metadata"
                                        ></video>
                                        <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30">
                                            <i class='bx bx-play-circle text-white text-3xl'></i>
                                        </div>
                                    @else
                                        <img 
                                            src="{{ asset('storage/' . $file->filepath) }}" 
                                            alt="Thumbnail {{ $index + 1 }}"
                                            class="w-full h-full object-cover"
                                        >
                                    @endif
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
                        <span class="font-medium">Posted {{ $produk->created_at->diffForHumans() }}</span>
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

                    @if($produk->toko->uuid ?? $produk->toko->id)
                        <a 
                            href="{{ route('toko.show', $produk->toko->uuid ?? $produk->toko->id) }}"
                            class="w-full bg-gradient-to-r from-[#007daf] to-[#0096d9] text-white font-semibold py-4 rounded-xl transition-all duration-300 hover:shadow-xl hover:scale-105 flex items-center justify-center gap-2 group border-2 border-blue-200"
                        >
                            <i class='bx bx-store-alt group-hover:rotate-12 transition-transform'></i>
                            Kunjungi Toko
                        </a>
                    @else
                        <button 
                            disabled
                            class="w-full bg-gray-400 text-white font-semibold py-4 rounded-xl flex items-center justify-center gap-2 cursor-not-allowed opacity-60"
                        >
                            <i class='bx bx-store-alt'></i>
                            Toko Tidak Tersedia
                        </button>
                    @endif
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
// Media gallery data
const mediaFiles = [
    @foreach($produk->files as $file)
        @php
            $extension = strtolower(pathinfo($file->filepath, PATHINFO_EXTENSION));
            $isVideo = in_array($extension, ['mp4', 'webm', 'ogg', 'mov', 'avi']);
        @endphp
        {
            url: "{{ asset('storage/' . $file->filepath) }}",
            isVideo: {{ $isVideo ? 'true' : 'false' }}
        },
    @endforeach
];
let currentMediaIndex = 0;

function changeMainMedia(index) {
    const container = document.getElementById('mainMediaContainer');
    const currentMedia = document.getElementById('mainMedia');
    
    // Pause video if it's playing
    if (currentMedia && currentMedia.tagName === 'VIDEO') {
        currentMedia.pause();
    }
    
    // Fade out effect
    if (currentMedia) {
        currentMedia.style.opacity = '0';
    }
    
    setTimeout(() => {
        const mediaData = mediaFiles[index];
        let newMediaHTML;
        
        if (mediaData.isVideo) {
            newMediaHTML = `
                <video 
                    id="mainMedia"
                    src="${mediaData.url}" 
                    class="w-full h-full object-contain"
                    controls
                    controlsList="nodownload"
                    preload="metadata"
                    style="opacity: 0;"
                >
                    Browser Anda tidak mendukung video HTML5.
                </video>
            `;
        } else {
            newMediaHTML = `
                <img 
                    id="mainMedia"
                    src="${mediaData.url}" 
                    alt="Produk {{ $produk->nama }}"
                    class="w-full h-full object-contain transition-all duration-500"
                    style="opacity: 0;"
                >
            `;
        }
        
        // Find the media container content area
        const badges = container.querySelectorAll('.absolute');
        const buttons = container.querySelectorAll('button');
        
        // Clear container but keep badges and buttons
        Array.from(container.children).forEach(child => {
            if (!child.classList.contains('absolute') && child.tagName !== 'BUTTON') {
                child.remove();
            }
        });
        
        // Insert new media at the beginning
        container.insertAdjacentHTML('afterbegin', newMediaHTML);
        
        // Fade in effect
        const newMedia = document.getElementById('mainMedia');
        setTimeout(() => {
            newMedia.style.opacity = '1';
        }, 50);
        
        currentMediaIndex = index;
        updateThumbnailBorders();
    }, 200);
}

function nextMedia() {
    currentMediaIndex = (currentMediaIndex + 1) % mediaFiles.length;
    changeMainMedia(currentMediaIndex);
}

function previousMedia() {
    currentMediaIndex = (currentMediaIndex - 1 + mediaFiles.length) % mediaFiles.length;
    changeMainMedia(currentMediaIndex);
}

function updateThumbnailBorders() {
    document.querySelectorAll('.thumbnail').forEach((thumb, index) => {
        if (index === currentMediaIndex) {
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

// Keyboard navigation for media
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowRight') {
        nextMedia();
    } else if (e.key === 'ArrowLeft') {
        previousMedia();
    }
});

// Pause video when navigating away
document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        const currentMedia = document.getElementById('mainMedia');
        if (currentMedia && currentMedia.tagName === 'VIDEO') {
            currentMedia.pause();
        }
    }
});
</script>

<style>
#mainMedia {
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

/* Video player custom styling */
video::-webkit-media-controls-panel {
    background-image: linear-gradient(transparent, rgba(0, 125, 175, 0.3));
}

video::-webkit-media-controls-play-button {
    background-color: rgba(0, 125, 175, 0.8);
    border-radius: 50%;
}
</style>
@endsection