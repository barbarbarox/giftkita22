@extends('layouts.app')

@section('title', 'Daftar Toko | GiftKita')

@section('content')
<section class="bg-gradient-to-b from-purple-50 to-white min-h-screen py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4">
        
        {{-- Header Section --}}
        <div class="text-center mb-8 md:mb-12" data-aos="fade-down">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold mb-3 md:mb-4 
                       bg-gradient-to-r from-purple-600 via-pink-600 to-orange-600 
                       bg-clip-text text-transparent">
                🏪 Toko Pilihan GiftKita
            </h1>
            <p class="text-gray-600 text-sm md:text-base lg:text-lg max-w-2xl mx-auto px-4">
                Temukan toko terpercaya dengan produk berkualitas di dekat Anda
            </p>
        </div>

        {{-- Search & Filter Section --}}
        <div class="bg-white rounded-xl md:rounded-2xl shadow-lg md:shadow-xl p-4 md:p-6 mb-6 md:mb-8" data-aos="fade-up">
            <div class="space-y-3 md:space-y-4">
                
                {{-- Search Bar --}}
                <div class="relative">
                    <input type="text" 
                           id="searchInput"
                           placeholder="Cari nama toko atau lokasi..." 
                           class="w-full px-5 md:px-6 py-3 md:py-4 pl-12 md:pl-14 border-2 border-gray-200 rounded-lg md:rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-300 text-sm md:text-base lg:text-lg">
                    <div class="absolute left-4 md:left-5 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search text-lg md:text-xl"></i>
                    </div>
                    <button id="clearSearch" class="hidden absolute right-4 md:right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 transition">
                        <i class="fas fa-times-circle text-lg md:text-xl"></i>
                    </button>
                </div>

                {{-- Location & Sort Filters --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
                    {{-- Get Location Button --}}
                    <button id="getLocationBtn" 
                            class="w-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-6 py-3 rounded-lg md:rounded-xl font-bold text-sm md:text-base hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center justify-center gap-3">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Cari Toko Terdekat</span>
                    </button>

                    {{-- Sort Options --}}
                    <select id="sortSelect" 
                            class="w-full px-4 py-3 pl-12 border-2 border-gray-200 rounded-lg md:rounded-xl focus:border-pink-500 focus:ring-4 focus:ring-pink-100 transition-all duration-300 appearance-none cursor-pointer bg-white text-sm md:text-base">
                        <option value="terbaru">🆕 Terbaru</option>
                        <option value="nama">📝 Nama A-Z</option>
                        <option value="produk_terbanyak">📦 Produk Terbanyak</option>
                        <option value="terdekat" disabled>📍 Terdekat (Aktifkan Lokasi)</option>
                    </select>
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" style="margin-top: -1px;">
                        <i class="fas fa-sort text-sm md:text-base"></i>
                    </div>
                </div>

                {{-- Location Status --}}
                <div id="locationStatus" class="hidden p-3 md:p-4 rounded-lg border-2">
                    <!-- Will be filled by JavaScript -->
                </div>
            </div>
        </div>

        {{-- Results Info --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 md:mb-6 gap-3" data-aos="fade-up">
            <div class="text-gray-700 text-sm md:text-base">
                <span id="tokoCount" class="font-bold text-xl md:text-2xl text-purple-600">{{ $tokos->count() }}</span>
                <span class="text-base md:text-lg">toko tersedia</span>
            </div>
            
            {{-- View Toggle --}}
            <div class="flex gap-2">
                <button id="gridView" class="px-3 md:px-4 py-2 rounded-lg bg-purple-500 text-white font-semibold transition-all duration-300 hover:shadow-lg text-sm md:text-base flex items-center gap-2">
                    <i class="fas fa-th"></i>
                    <span class="hidden sm:inline">Grid</span>
                </button>
                <button id="listView" class="px-3 md:px-4 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold transition-all duration-300 hover:shadow-lg text-sm md:text-base flex items-center gap-2">
                    <i class="fas fa-list"></i>
                    <span class="hidden sm:inline">List</span>
                </button>
            </div>
        </div>

        {{-- Toko Container --}}
        @if ($tokos->isEmpty())
            <div class="text-center py-12 md:py-20" data-aos="fade-up">
                <div class="mb-4 md:mb-6">
                    <i class="fas fa-store-slash text-6xl md:text-8xl text-gray-300"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-700 mb-2">Belum Ada Toko</h3>
                <p class="text-sm md:text-base text-gray-500 mb-4 md:mb-6">Toko akan segera hadir di platform kami</p>
            </div>
        @else
            <div id="tokosContainer" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4 lg:gap-6">
                @foreach ($tokos as $toko)
                    @php
                        $fotoPath = $toko->foto_profil;
                        if ($fotoPath && str_starts_with($fotoPath, 'storage/')) {
                            $foto = asset($fotoPath);
                        } elseif ($fotoPath) {
                            $foto = asset('storage/' . $fotoPath);
                        } else {
                            $foto = asset('images/no-image.jpg');
                        }
                    @endphp
                    
                    <a href="{{ route('toko.show', $toko->id) }}"
                       class="toko-card group bg-white rounded-xl md:rounded-2xl shadow-md hover:shadow-xl md:hover:shadow-2xl border border-gray-100 overflow-hidden transform transition-all duration-500 hover:scale-105"
                       data-aos="zoom-in"
                       data-aos-delay="{{ $loop->index * 50 }}"
                       data-toko-name="{{ strtolower($toko->nama_toko) }}"
                       data-toko-location="{{ strtolower($toko->alamat_toko ?? '') }}"
                       data-toko-lat="{{ $toko->latitude }}"
                       data-toko-lng="{{ $toko->longitude }}"
                       data-toko-produk="{{ $toko->produks_count ?? 0 }}">
                        
                        {{-- Store Image --}}
                        <div class="relative overflow-hidden toko-image">
                            <img src="{{ $foto }}" 
                                 alt="{{ $toko->nama_toko }}"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                 loading="lazy">
                            
                            {{-- Distance Badge (Hidden by default) --}}
                            <div class="distance-badge hidden absolute top-2 right-2 bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                <span class="distance-text">0 km</span>
                            </div>
                            
                            {{-- Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="absolute bottom-0 left-0 right-0 p-3 text-white">
                                    <p class="text-xs md:text-sm font-semibold flex items-center gap-2">
                                        <i class="fas fa-eye"></i>
                                        <span>Lihat Toko</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Store Info --}}
                        <div class="toko-info p-3 md:p-4 space-y-1.5 md:space-y-2">
                            {{-- Store Name --}}
                            <h3 class="toko-name font-bold text-gray-800 text-sm md:text-base lg:text-lg line-clamp-1 group-hover:text-purple-600 transition-colors">
                                {{ $toko->nama_toko }}
                            </h3>
                            
                            {{-- Description --}}
                            <p class="toko-desc text-xs md:text-sm text-gray-500 line-clamp-2 min-h-[2.5rem]">
                                {{ $toko->deskripsi ?? 'Toko berkualitas dengan berbagai pilihan produk menarik' }}
                            </p>
                            
                            {{-- Location (if available) --}}
                            @if($toko->alamat_toko)
                            <div class="toko-location flex items-start gap-2 text-xs text-gray-500">
                                <i class="fas fa-map-marker-alt mt-0.5 flex-shrink-0"></i>
                                <span class="line-clamp-1">{{ $toko->alamat_toko }}</span>
                            </div>
                            @endif
                            
                            {{-- Stats --}}
                            <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                                <div class="flex items-center gap-1.5">
                                    <i class="fas fa-box text-purple-500 text-sm"></i>
                                    <span class="text-xs md:text-sm font-semibold text-gray-700">{{ $toko->produks_count ?? 0 }} Produk</span>
                                </div>
                                
                                <div class="toko-distance-info hidden items-center gap-1.5">
                                    <i class="fas fa-location-arrow text-blue-500 text-sm"></i>
                                    <span class="distance-text-bottom text-xs font-semibold text-blue-600">0 km</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Empty Search Result --}}
            <div id="emptyResult" class="hidden text-center py-12 md:py-20">
                <div class="mb-4 md:mb-6">
                    <i class="fas fa-search text-6xl md:text-8xl text-gray-300"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-700 mb-2">Toko Tidak Ditemukan</h3>
                <p class="text-sm md:text-base text-gray-500 mb-4 md:mb-6">Coba kata kunci lain atau ubah filter pencarian</p>
            </div>
        @endif
    </div>
</section>

{{-- Styles --}}
<style>
/* Default Grid View */
.toko-image {
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

/* List View */
.list-view #tokosContainer {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.list-view .toko-card {
    display: flex;
    flex-direction: row;
    max-width: 100%;
    height: auto;
}

.list-view .toko-image {
    width: 150px;
    min-width: 150px;
    height: 150px;
    flex-shrink: 0;
}

.list-view .toko-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.list-view .toko-name {
    font-size: 1.125rem;
}

.list-view .toko-desc {
    display: block !important;
}

@media (min-width: 640px) {
    .list-view .toko-image {
        width: 200px;
        min-width: 200px;
        height: 200px;
    }
}

@media (min-width: 768px) {
    .list-view .toko-image {
        width: 250px;
        min-width: 250px;
        height: 250px;
    }
    
    .list-view .toko-name {
        font-size: 1.25rem;
    }
}

@media (max-width: 640px) {
    .list-view .toko-card {
        flex-direction: column;
    }
    
    .list-view .toko-image {
        width: 100%;
        min-width: 100%;
        height: 200px;
    }
}
</style>

{{-- Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    let userLat = null;
    let userLng = null;
    
    // Elements
    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    const sortSelect = document.getElementById('sortSelect');
    const getLocationBtn = document.getElementById('getLocationBtn');
    const locationStatus = document.getElementById('locationStatus');
    const tokosContainer = document.getElementById('tokosContainer');
    const emptyResult = document.getElementById('emptyResult');
    const tokoCount = document.getElementById('tokoCount');
    const tokoCards = document.querySelectorAll('.toko-card');
    
    // View Toggle
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const body = document.body;

    // Check saved view preference
    const savedView = localStorage.getItem('tokoView') || 'grid';
    if (savedView === 'list') {
        switchToList();
    }

    gridView.addEventListener('click', () => {
        switchToGrid();
        localStorage.setItem('tokoView', 'grid');
    });

    listView.addEventListener('click', () => {
        switchToList();
        localStorage.setItem('tokoView', 'list');
    });

    function switchToGrid() {
        body.classList.remove('list-view');
        gridView.classList.remove('bg-gray-200', 'text-gray-700');
        gridView.classList.add('bg-purple-500', 'text-white');
        listView.classList.remove('bg-purple-500', 'text-white');
        listView.classList.add('bg-gray-200', 'text-gray-700');
        tokosContainer.className = 'grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4 lg:gap-6';
    }

    function switchToList() {
        body.classList.add('list-view');
        listView.classList.remove('bg-gray-200', 'text-gray-700');
        listView.classList.add('bg-purple-500', 'text-white');
        gridView.classList.remove('bg-purple-500', 'text-white');
        gridView.classList.add('bg-gray-200', 'text-gray-700');
        tokosContainer.className = 'list-view';
    }

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

    // Search Functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        
        if (searchTerm) {
            clearSearch.classList.remove('hidden');
        } else {
            clearSearch.classList.add('hidden');
        }
        
        filterAndSort();
    });

    clearSearch.addEventListener('click', () => {
        searchInput.value = '';
        clearSearch.classList.add('hidden');
        filterAndSort();
    });

    // Sort Functionality
    sortSelect.addEventListener('change', filterAndSort);

    // Get User Location
    getLocationBtn.addEventListener('click', () => {
        if (!navigator.geolocation) {
            showLocationStatus('error', 'Browser Anda tidak mendukung Geolocation');
            return;
        }

        getLocationBtn.disabled = true;
        getLocationBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mencari Lokasi...';

        navigator.geolocation.getCurrentPosition(
            (position) => {
                userLat = position.coords.latitude;
                userLng = position.coords.longitude;
                
                showLocationStatus('success', `Lokasi ditemukan! Lat: ${userLat.toFixed(4)}, Lng: ${userLng.toFixed(4)}`);
                
                // Enable "Terdekat" option
                const terdekatOption = sortSelect.querySelector('option[value="terdekat"]');
                terdekatOption.disabled = false;
                sortSelect.value = 'terdekat';
                
                // Calculate and show distances
                calculateDistances();
                filterAndSort();
                
                getLocationBtn.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Lokasi Aktif';
                getLocationBtn.classList.remove('from-blue-500', 'to-cyan-500');
                getLocationBtn.classList.add('from-green-500', 'to-emerald-500');
            },
            (error) => {
                let errorMsg = 'Tidak dapat mengakses lokasi';
                if (error.code === error.PERMISSION_DENIED) {
                    errorMsg = 'Izin lokasi ditolak. Aktifkan izin lokasi di browser Anda.';
                }
                showLocationStatus('error', errorMsg);
                getLocationBtn.disabled = false;
                getLocationBtn.innerHTML = '<i class="fas fa-map-marker-alt mr-2"></i>Cari Toko Terdekat';
            }
        );
    });

    function showLocationStatus(type, message) {
        locationStatus.classList.remove('hidden', 'bg-green-50', 'border-green-500', 'text-green-700', 'bg-red-50', 'border-red-500', 'text-red-700');
        
        if (type === 'success') {
            locationStatus.classList.add('bg-green-50', 'border-green-500', 'text-green-700');
            locationStatus.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${message}`;
        } else {
            locationStatus.classList.add('bg-red-50', 'border-red-500', 'text-red-700');
            locationStatus.innerHTML = `<i class="fas fa-exclamation-circle mr-2"></i>${message}`;
        }
    }

    function calculateDistances() {
        tokoCards.forEach(card => {
            const lat = parseFloat(card.dataset.tokoLat);
            const lng = parseFloat(card.dataset.tokoLng);
            
            if (lat && lng && userLat && userLng) {
                const distance = calculateDistance(userLat, userLng, lat, lng);
                card.dataset.distance = distance.toFixed(2);
                
                // Show distance badges
                const distanceBadge = card.querySelector('.distance-badge');
                const distanceTextTop = card.querySelector('.distance-badge .distance-text');
                const distanceInfo = card.querySelector('.toko-distance-info');
                const distanceTextBottom = card.querySelector('.distance-text-bottom');
                
                if (distanceBadge && distanceTextTop) {
                    distanceBadge.classList.remove('hidden');
                    distanceTextTop.textContent = `${distance.toFixed(1)} km`;
                }
                
                if (distanceInfo && distanceTextBottom) {
                    distanceInfo.classList.remove('hidden');
                    distanceInfo.classList.add('flex');
                    distanceTextBottom.textContent = `${distance.toFixed(1)} km`;
                }
            }
        });
    }

    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius bumi dalam km
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    function filterAndSort() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const sortValue = sortSelect.value;
        let visibleCount = 0;
        
        // Convert NodeList to Array for sorting
        const cardsArray = Array.from(tokoCards);
        
        // Sort
        cardsArray.sort((a, b) => {
            switch(sortValue) {
                case 'nama':
                    return a.dataset.tokoName.localeCompare(b.dataset.tokoName);
                case 'produk_terbanyak':
                    return parseInt(b.dataset.tokoProduk) - parseInt(a.dataset.tokoProduk);
                case 'terdekat':
                    if (userLat && userLng) {
                        return parseFloat(a.dataset.distance || 999999) - parseFloat(b.dataset.distance || 999999);
                    }
                    return 0;
                case 'terbaru':
                default:
                    return 0;
            }
        });
        
        // Re-append in sorted order
        cardsArray.forEach(card => {
            tokosContainer.appendChild(card);
        });
        
        // Filter and show/hide
        tokoCards.forEach(card => {
            const name = card.dataset.tokoName;
            const location = card.dataset.tokoLocation;
            
            const matchSearch = !searchTerm || 
                               name.includes(searchTerm) || 
                               location.includes(searchTerm);
            
            if (matchSearch) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });
        
        // Update count
        tokoCount.textContent = visibleCount;
        
        // Show/hide empty state
        if (visibleCount === 0) {
            tokosContainer.classList.add('hidden');
            emptyResult.classList.remove('hidden');
        } else {
            tokosContainer.classList.remove('hidden');
            emptyResult.classList.add('hidden');
        }
    }
});
</script>
@endsection