@extends('layouts.app')

@section('title', 'Katalog Produk | GiftKita')

@section('content')
<section class="bg-gradient-to-b from-blue-50 to-white min-h-screen py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4">
        
        {{-- Header Section --}}
        <div class="text-center mb-8 md:mb-12" data-aos="fade-down">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold mb-3 md:mb-4 
                       bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 
                       bg-clip-text text-transparent flex items-center justify-center gap-3">
                <i class="fas fa-gift text-blue-600"></i>
                Katalog Produk GiftKita
            </h1>
            <p class="text-gray-600 text-sm md:text-base lg:text-lg max-w-2xl mx-auto px-4">
                Temukan hadiah sempurna untuk orang tersayang dengan koleksi produk pilihan kami
            </p>
        </div>

        {{-- Search & Filter Section --}}
        <div class="bg-white rounded-xl md:rounded-2xl shadow-lg md:shadow-xl p-4 md:p-6 mb-6 md:mb-8" data-aos="fade-up">
            <form method="GET" action="{{ route('katalog.index') }}" class="space-y-3 md:space-y-4">
                
                {{-- Search Bar --}}
                <div class="relative">
                    <input type="text" 
                           name="q" 
                           value="{{ request('q') }}"
                           placeholder="Cari produk, toko, atau deskripsi..." 
                           class="w-full px-5 md:px-6 py-3 md:py-4 pl-12 md:pl-14 border-2 border-gray-200 rounded-lg md:rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 text-sm md:text-base lg:text-lg">
                    <div class="absolute left-4 md:left-5 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search text-lg md:text-xl"></i>
                    </div>
                    @if(request('q'))
                    <a href="{{ route('katalog.index') }}" class="absolute right-4 md:right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 transition">
                        <i class="fas fa-times-circle text-lg md:text-xl"></i>
                    </a>
                    @endif
                </div>

                {{-- Filters Row --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4">
                    {{-- Category Filter --}}
                    <div class="relative">
                        <select name="kategori" 
                                class="w-full px-4 py-2.5 md:py-3 pl-10 md:pl-12 border-2 border-gray-200 rounded-lg md:rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-300 appearance-none cursor-pointer bg-white text-sm md:text-base">
                            <option value="">
                                <i class="fas fa-layer-group"></i> Semua Kategori
                            </option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute left-3 md:left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fas fa-layer-group text-sm md:text-base"></i>
                        </div>
                        <div class="absolute right-3 md:right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fas fa-chevron-down text-sm"></i>
                        </div>
                    </div>

                    {{-- Sort Filter --}}
                    <div class="relative">
                        <select name="sort" 
                                class="w-full px-4 py-2.5 md:py-3 pl-10 md:pl-12 border-2 border-gray-200 rounded-lg md:rounded-xl focus:border-pink-500 focus:ring-4 focus:ring-pink-100 transition-all duration-300 appearance-none cursor-pointer bg-white text-sm md:text-base">
                            <option value="">Urutkan</option>
                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga Termurah</option>
                            <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga Termahal</option>
                            <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama A-Z</option>
                        </select>
                        <div class="absolute left-3 md:left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fas fa-sort-amount-down text-sm md:text-base"></i>
                        </div>
                        <div class="absolute right-3 md:right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fas fa-chevron-down text-sm"></i>
                        </div>
                    </div>

                    {{-- Search Button --}}
                    <button type="submit" 
                            class="bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 text-white px-6 md:px-8 py-2.5 md:py-3 rounded-lg md:rounded-xl font-bold text-sm md:text-base lg:text-lg hover:shadow-xl md:hover:shadow-2xl hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2 md:gap-3">
                        <i class="fas fa-search"></i>
                        <span>Cari Produk</span>
                    </button>
                </div>

                {{-- Active Filters Display --}}
                @if(request()->hasAny(['q', 'kategori', 'sort']))
                <div class="flex flex-wrap items-center gap-2 md:gap-3 pt-3 md:pt-4 border-t border-gray-200">
                    <span class="text-xs md:text-sm text-gray-600 font-semibold flex items-center gap-2">
                        <i class="fas fa-filter"></i>
                        Filter Aktif:
                    </span>
                    
                    @if(request('q'))
                    <span class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-3 py-1.5 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold">
                        <i class="fas fa-search"></i>
                        <span class="max-w-[100px] md:max-w-none truncate">"{{ request('q') }}"</span>
                        <a href="{{ route('katalog.index', array_filter(request()->except('q'))) }}" class="hover:text-blue-900">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    @endif
                    
                    @if(request('kategori'))
                    <span class="inline-flex items-center gap-2 bg-purple-100 text-purple-700 px-3 py-1.5 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold">
                        <i class="fas fa-tag"></i>
                        {{ $kategoris->find(request('kategori'))->nama_kategori ?? 'Kategori' }}
                        <a href="{{ route('katalog.index', array_filter(request()->except('kategori'))) }}" class="hover:text-purple-900">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    @endif
                    
                    @if(request('sort'))
                    <span class="inline-flex items-center gap-2 bg-pink-100 text-pink-700 px-3 py-1.5 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold">
                        <i class="fas fa-sort"></i>
                        {{ ucfirst(request('sort')) }}
                        <a href="{{ route('katalog.index', array_filter(request()->except('sort'))) }}" class="hover:text-pink-900">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    @endif
                    
                    <a href="{{ route('katalog.index') }}" class="text-xs md:text-sm text-red-600 hover:text-red-700 font-semibold ml-auto flex items-center gap-1">
                        <i class="fas fa-redo"></i>
                        Reset Semua
                    </a>
                </div>
                @endif
            </form>
        </div>

        {{-- Results Info & View Toggle --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 md:mb-6 gap-3 md:gap-4" data-aos="fade-up">
            <div class="text-gray-700 text-sm md:text-base flex items-center gap-2">
                <i class="fas fa-box-open text-blue-600 text-lg md:text-xl"></i>
                <span class="font-bold text-xl md:text-2xl text-blue-600">{{ $produks->count() }}</span>
                <span class="text-base md:text-lg">produk ditemukan</span>
            </div>
            
            {{-- View Toggle --}}
            <div class="flex gap-2">
                <button id="gridView" class="px-3 md:px-4 py-2 rounded-lg bg-blue-500 text-white font-semibold transition-all duration-300 hover:shadow-lg text-sm md:text-base flex items-center gap-2">
                    <i class="fas fa-th"></i>
                    <span class="hidden sm:inline">Grid</span>
                </button>
                <button id="listView" class="px-3 md:px-4 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold transition-all duration-300 hover:shadow-lg text-sm md:text-base flex items-center gap-2">
                    <i class="fas fa-list"></i>
                    <span class="hidden sm:inline">List</span>
                </button>
            </div>
        </div>

        {{-- Products Container --}}
        @if ($produks->isEmpty())
            <div class="text-center py-12 md:py-20" data-aos="fade-up">
                <div class="mb-4 md:mb-6">
                    <i class="fas fa-box-open text-6xl md:text-8xl text-gray-300"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-700 mb-2">Produk Tidak Ditemukan</h3>
                <p class="text-sm md:text-base text-gray-500 mb-4 md:mb-6">Coba ubah kata kunci atau filter pencarian Anda</p>
                <a href="{{ route('katalog.index') }}" class="inline-flex items-center gap-2 bg-blue-500 text-white px-5 md:px-6 py-2.5 md:py-3 rounded-lg md:rounded-xl font-semibold hover:bg-blue-600 transition-all text-sm md:text-base">
                    <i class="fas fa-redo"></i>
                    <span>Reset Pencarian</span>
                </a>
            </div>
        @else
            <div id="productsContainer" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4 lg:gap-6">
                @foreach ($produks as $produk)
                    @php
                        $thumbnail = $produk->files->first();
                        $imagePath = $thumbnail ? asset('storage/'.$thumbnail->filepath) : asset('images/no-image.jpg');
                    @endphp
                    
                    <a href="{{ route('katalog.show', $produk->id) }}"
                       class="product-card group bg-white rounded-xl md:rounded-2xl shadow-md hover:shadow-xl md:hover:shadow-2xl border border-gray-100 overflow-hidden transform transition-all duration-500 hover:scale-105"
                       data-aos="zoom-in"
                       data-aos-delay="{{ $loop->index * 50 }}">
                        
                        {{-- Product Image --}}
                        <div class="relative overflow-hidden product-image">
                            <img src="{{ $imagePath }}" 
                                 alt="{{ $produk->nama }}"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                 loading="lazy">
                            
                            {{-- Category Badge --}}
                            @if($produk->kategori)
                            <div class="absolute top-2 left-2 bg-white/90 backdrop-blur-sm px-2 py-1 md:px-3 md:py-1 rounded-full text-xs font-semibold text-purple-600 flex items-center gap-1">
                                <i class="fas fa-tag text-xs"></i>
                                {{ $produk->kategori->nama_kategori }}
                            </div>
                            @endif
                            
                            {{-- Quick View Icon --}}
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <span class="bg-white text-gray-800 px-3 py-1.5 md:px-4 md:py-2 rounded-full font-semibold text-xs md:text-sm">
                                    <i class="fas fa-eye mr-1 md:mr-2"></i>Lihat Detail
                                </span>
                            </div>
                        </div>
                        
                        {{-- Product Info --}}
                        <div class="product-info p-3 md:p-4 space-y-1.5 md:space-y-2">
                            {{-- Product Name --}}
                            <h3 class="product-name font-bold text-gray-800 text-sm md:text-base line-clamp-2 group-hover:text-blue-600 transition-colors">
                                {{ $produk->nama }}
                            </h3>
                            
                            {{-- Description (Hidden on mobile grid) --}}
                            <p class="product-desc hidden md:block text-xs md:text-sm text-gray-500 line-clamp-2">
                                {{ $produk->deskripsi ?? 'Deskripsi tidak tersedia' }}
                            </p>
                            
                            {{-- Price --}}
                            <div class="pt-1 md:pt-2">
                                <p class="product-price text-lg md:text-xl lg:text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent flex items-center gap-1">
                                    <i class="fas fa-tag text-sm md:text-base text-blue-600"></i>
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </p>
                            </div>
                            
                            {{-- Store Info --}}
                            <div class="product-store flex items-center gap-1.5 md:gap-2 pt-1.5 md:pt-2 border-t border-gray-100">
                                <i class="fas fa-store text-gray-400 text-xs md:text-sm"></i>
                                <span class="text-xs md:text-sm text-gray-600 truncate">{{ $produk->toko->nama_toko ?? 'Toko' }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- Styles --}}
<style>
/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}

/* Default Grid View - Square Images */
.product-image {
    aspect-ratio: 1 / 1;
    width: 100%;
}

/* AOS Animation */
[data-aos] {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}

[data-aos].aos-animate {
    opacity: 1;
    transform: translateY(0);
}

/* List View Styles */
.list-view #productsContainer {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.list-view .product-card {
    display: flex;
    flex-direction: row;
    max-width: 100%;
    height: auto;
}

.list-view .product-image {
    width: 150px;
    min-width: 150px;
    height: 150px;
    flex-shrink: 0;
    aspect-ratio: 1 / 1;
}

.list-view .product-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.list-view .product-name {
    font-size: 1.125rem;
    line-height: 1.5rem;
    -webkit-line-clamp: 2;
}

.list-view .product-desc {
    display: block !important;
    -webkit-line-clamp: 2;
}

.list-view .product-price {
    font-size: 1.5rem;
}

.list-view .product-store {
    margin-top: auto;
}

/* Responsive List View */
@media (min-width: 640px) {
    .list-view .product-image {
        width: 200px;
        min-width: 200px;
        height: 200px;
    }
}

@media (min-width: 768px) {
    .list-view .product-image {
        width: 250px;
        min-width: 250px;
        height: 250px;
    }
    
    .list-view .product-name {
        font-size: 1.25rem;
        line-height: 1.75rem;
    }
    
    .list-view .product-desc {
        -webkit-line-clamp: 3;
    }
}

/* Mobile Specific */
@media (max-width: 640px) {
    .list-view .product-card {
        flex-direction: column;
    }
    
    .list-view .product-image {
        width: 100%;
        min-width: 100%;
        height: 200px;
    }
    
    .list-view .product-desc {
        display: block !important;
    }
}

/* Touch device optimization */
@media (hover: none) {
    .product-card:active {
        transform: scale(0.98);
    }
}

/* Loading Animation */
@keyframes shimmer {
    0% { background-position: -1000px 0; }
    100% { background-position: 1000px 0; }
}

.skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 1000px 100%;
    animation: shimmer 2s infinite;
}
</style>

{{-- Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    // AOS Animation
    const elements = document.querySelectorAll('[data-aos]');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('aos-animate');
            }
        });
    }, { threshold: 0.1 });
    
    elements.forEach(el => {
        const delay = el.getAttribute('data-aos-delay');
        if (delay) {
            setTimeout(() => observer.observe(el), parseInt(delay));
        } else {
            observer.observe(el);
        }
    });

    // View Toggle
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const container = document.getElementById('productsContainer');
    const body = document.body;

    // Check saved preference
    const savedView = localStorage.getItem('catalogView') || 'grid';
    if (savedView === 'list') {
        switchToList();
    }

    gridView.addEventListener('click', () => {
        switchToGrid();
        localStorage.setItem('catalogView', 'grid');
    });

    listView.addEventListener('click', () => {
        switchToList();
        localStorage.setItem('catalogView', 'list');
    });

    function switchToGrid() {
        body.classList.remove('list-view');
        gridView.classList.remove('bg-gray-200', 'text-gray-700');
        gridView.classList.add('bg-blue-500', 'text-white');
        listView.classList.remove('bg-blue-500', 'text-white');
        listView.classList.add('bg-gray-200', 'text-gray-700');
        
        container.className = 'grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4 lg:gap-6';
    }

    function switchToList() {
        body.classList.add('list-view');
        listView.classList.remove('bg-gray-200', 'text-gray-700');
        listView.classList.add('bg-blue-500', 'text-white');
        gridView.classList.remove('bg-blue-500', 'text-white');
        gridView.classList.add('bg-gray-200', 'text-gray-700');
        
        container.className = 'list-view';
    }

    // Auto-submit on select change (Desktop only)
    if (window.innerWidth >= 768) {
        document.querySelectorAll('select[name="kategori"], select[name="sort"]').forEach(select => {
            select.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
    }

    // Lazy Loading Images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src || img.src;
                    img.classList.remove('skeleton');
                    observer.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[loading="lazy"]').forEach(img => {
            imageObserver.observe(img);
        });
    }
});
</script>
@endsection