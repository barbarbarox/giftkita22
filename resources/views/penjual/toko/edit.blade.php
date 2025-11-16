@extends('layouts.penjual')

@section('title', 'Edit Profil Toko | GiftKita Seller')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-lg rounded-2xl p-8 border border-gray-100">

    <h1 class="text-2xl font-bold text-[#007daf] mb-6 flex items-center gap-2">
        ✏️ Edit Profil Toko
    </h1>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan error validasi --}}
    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-800 p-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Edit --}}
    <form action="{{ route('penjual.toko.update', $toko->uuid) }}" 
          method="POST" enctype="multipart/form-data" 
          class="grid md:grid-cols-2 gap-8">
        @csrf
        @method('PUT')

        {{-- ========================================================= --}}
        {{-- 🧾 KOLOM KIRI: IDENTITAS TOKO --}}
        {{-- ========================================================= --}}
        <div class="space-y-6">
            <div class="p-6 bg-gray-50 border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
                <h2 class="text-lg font-semibold text-[#007daf] mb-4 flex items-center gap-2">
                    <i class='bx bx-store text-[#007daf] text-xl'></i> Identitas Toko
                </h2>

                {{-- Nama Toko --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Nama Toko <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_toko" value="{{ old('nama_toko', $toko->nama_toko) }}" 
                           class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#007daf]" required>
                </div>

                {{-- Alamat --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Alamat</label>
                    <textarea name="alamat_toko" rows="2" 
                              class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#007daf]">{{ old('alamat_toko', $toko->alamat_toko) }}</textarea>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block font-semibold mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" 
                              class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#007daf]">{{ old('deskripsi', $toko->deskripsi) }}</textarea>
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{--  KOLOM KANAN: FOTO PROFIL + SOSIAL MEDIA --}}
        {{-- ========================================================= --}}
        <div class="space-y-6">
            {{-- Foto Profil --}}
            <div class="p-6 bg-gray-50 border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
                <h2 class="text-lg font-semibold text-[#007daf] mb-3 flex items-center gap-2">
                    <i class='bx bx-image text-[#007daf] text-xl'></i> Foto Profil
                </h2>
                @if($toko->foto_profil)
                    <div class="mb-3">
                        <img src="{{ asset($toko->foto_profil) }}" alt="Foto Profil" 
                             class="w-32 h-32 object-cover rounded-lg shadow">
                    </div>
                @endif
                <input type="file" name="foto_profil" accept="image/*"
                       class="w-full border border-gray-300 rounded-lg p-2 cursor-pointer bg-white">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (maks. 2MB)</p>
            </div>

            {{-- Sosial Media --}}
            <div class="p-6 bg-gray-50 border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
                <h2 class="text-lg font-semibold text-[#007daf] mb-4 flex items-center gap-2">
                    <i class='bx bx-share-alt text-[#007daf] text-xl'></i> Sosial Media
                </h2>

                <div class="space-y-4">
                    {{-- Instagram --}}
                    <div>
                        <label class="block font-semibold mb-1 flex items-center gap-2">
                            <i class='bx bxl-instagram text-pink-500 text-lg'></i> Instagram
                        </label>
                        <input type="url" name="instagram" 
                               value="{{ old('instagram', $toko->instagram) }}"
                               placeholder="https://instagram.com/nama_toko"
                               class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-pink-400">
                    </div>

                    {{-- Facebook --}}
                    <div>
                        <label class="block font-semibold mb-1 flex items-center gap-2">
                            <i class='bx bxl-facebook text-blue-600 text-lg'></i> Facebook
                        </label>
                        <input type="url" name="facebook" 
                               value="{{ old('facebook', $toko->facebook) }}"
                               placeholder="https://facebook.com/nama_toko"
                               class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-600">
                    </div>

                    {{-- WhatsApp --}}
                    <div>
                        <label class="block font-semibold mb-1 flex items-center gap-2">
                            <i class='bx bxl-whatsapp text-green-500 text-lg'></i> WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="whatsapp" 
                               value="{{ old('whatsapp', $toko->whatsapp) }}"
                               placeholder="6281234567890"
                               class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500" required>
                        <p class="text-xs text-gray-500 mt-1">Format: 628xxxxxxxxxx (tanpa +, spasi, atau tanda hubung)</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- 📍 LOKASI TOKO (FULL WIDTH) --}}
        {{-- ========================================================= --}}
        <div class="md:col-span-2 p-6 bg-gray-50 border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
            <h2 class="text-lg font-semibold text-[#007daf] mb-4 flex items-center gap-2">
                <i class='bx bx-map text-[#007daf] text-xl'></i> Lokasi Toko
            </h2>

            <div class="grid md:grid-cols-2 gap-6">
                {{-- PREVIEW PETA INTERAKTIF --}}
                <div>
                    <label class="block font-semibold mb-2">Preview Lokasi</label>
                    
                    {{-- Map Container --}}
                    <div id="mapContainer" class="w-full h-[350px] bg-gray-100 border border-gray-300 rounded-lg overflow-hidden relative">
                        {{-- Map akan dimuat di sini --}}
                        <div id="map" class="w-full h-full {{ $toko->hasMapLocation() ? '' : 'hidden' }}"></div>
                        
                        {{-- Placeholder jika belum ada peta --}}
                        <div id="mapPlaceholder" class="w-full h-full flex items-center justify-center {{ $toko->hasMapLocation() ? 'hidden' : '' }}">
                            <div class="text-center">
                                <i class='bx bx-map text-gray-400 text-5xl mb-2'></i>
                                <p class="text-gray-500 italic">Pilih lokasi di peta atau gunakan lokasi Anda</p>
                            </div>
                        </div>
                    </div>

                    {{-- Info koordinat --}}
                    <div id="coordinateInfo" class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg {{ $toko->hasMapLocation() ? '' : 'hidden' }}">
                        <p class="text-xs text-blue-800">
                            <i class='bx bx-current-location'></i> 
                            <strong>Koordinat terpilih:</strong><br>
                            <span id="displayCoordinates">
                                @if($toko->hasMapLocation())
                                    Lat: {{ $toko->latitude }}, Lng: {{ $toko->longitude }}
                                @else
                                    -
                                @endif
                            </span>
                        </p>
                    </div>
                </div>

                {{-- FORM INPUT LOKASI --}}
                <div>
                    <label class="block font-semibold mb-2">Link Google Maps</label>
                    <input type="url" 
                           name="google_map_link" 
                           id="google_map_link"
                           value="{{ old('google_map_link', $toko->google_map_link) }}"
                           placeholder="https://maps.app.goo.gl/xxxxx atau paste link Google Maps"
                           class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#007daf] mb-2">
                    
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-3 mb-4">
                        <p class="text-xs text-blue-800">
                            <strong>💡 3 Cara mendapatkan lokasi:</strong><br>
                            1. <strong>Paste link</strong> dari Google Maps<br>
                            2. <strong>Pilih di peta</strong> dengan tombol di bawah<br>
                            3. <strong>Gunakan GPS</strong> lokasi Anda saat ini
                        </p>
                    </div>

                    {{-- Hidden inputs untuk koordinat --}}
                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $toko->latitude) }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $toko->longitude) }}">

                    {{-- Tombol Aksi --}}
                    <div class="space-y-2">
                        <button type="button" 
                                id="pickLocation"
                                class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition flex items-center justify-center gap-2">
                            <i class='bx bx-map-pin text-lg'></i>
                            Pilih Lokasi di Peta
                        </button>

                        <button type="button" 
                                id="getLocation"
                                class="w-full px-4 py-2 bg-[#007daf] text-white rounded-lg text-sm font-medium hover:bg-[#006b9c] transition flex items-center justify-center gap-2">
                            <i class='bx bx-current-location text-lg'></i>
                            Gunakan Lokasi Saya Sekarang
                        </button>
                    </div>
                    
                    <p class="text-xs text-gray-500 mt-2">
                        <i class='bx bx-info-circle'></i> 
                        Koordinat akan otomatis terisi saat Anda memilih lokasi
                    </p>

                    {{-- Loading indicator --}}
                    <div id="loadingIndicator" class="hidden mt-3 text-center">
                        <div class="inline-flex items-center gap-2 text-sm text-gray-600">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memproses lokasi...
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- FOOTER --}}
        {{-- ========================================================= --}}
        <div class="md:col-span-2 text-right pt-8 border-t">
            <a href="{{ route('penjual.toko.index') }}" 
               class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 mr-3">
                ⬅️ Kembali
            </a>

            <button type="submit" 
                    class="px-6 py-2 bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white font-semibold rounded-lg shadow hover:scale-105 transition">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>

{{-- ========================================================= --}}
{{-- 🗺️ LEAFLET.JS (Interactive Map) --}}
{{-- ========================================================= --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
#map {
    z-index: 1;
}

.leaflet-popup-content-wrapper {
    border-radius: 8px;
}

@keyframes fade-in-down {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-down {
    animation: fade-in-down 0.3s ease-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========================================
    // INISIALISASI VARIABEL
    // ========================================
    const linkInput = document.getElementById('google_map_link');
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const mapContainer = document.getElementById('map');
    const mapPlaceholder = document.getElementById('mapPlaceholder');
    const coordinateInfo = document.getElementById('coordinateInfo');
    const displayCoordinates = document.getElementById('displayCoordinates');
    const pickLocationBtn = document.getElementById('pickLocation');
    const getLocationBtn = document.getElementById('getLocation');
    const loadingIndicator = document.getElementById('loadingIndicator');

    let map = null;
    let marker = null;
    let isMapInitialized = false;

    // Default center (ambil dari data toko atau Indonesia)
    const currentLat = parseFloat(latInput.value) || -2.5489;
    const currentLng = parseFloat(lngInput.value) || 118.0149;
    const hasExistingLocation = latInput.value && lngInput.value;

    // ========================================
    // 1. INISIALISASI PETA
    // ========================================
    function initializeMap(center = [currentLat, currentLng], zoom = hasExistingLocation ? 15 : 5) {
        if (isMapInitialized) {
            return;
        }

        // Show map, hide placeholder
        mapContainer.classList.remove('hidden');
        mapPlaceholder.classList.add('hidden');

        // Initialize Leaflet map
        map = L.map('map').setView(center, zoom);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Add click event to map
        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            
            placeMarker(lat, lng);
            updateInputs(lat, lng);
        });

        // Jika ada lokasi existing, tampilkan marker
        if (hasExistingLocation) {
            placeMarker(currentLat, currentLng);
        }

        isMapInitialized = true;
    }

    // ========================================
    // 2. PLACE/UPDATE MARKER
    // ========================================
    function placeMarker(lat, lng) {
        // Remove existing marker
        if (marker) {
            map.removeLayer(marker);
        }

        // Add new marker
        marker = L.marker([lat, lng], {
            draggable: true
        }).addTo(map);

        // Add popup
        marker.bindPopup(`
            <div class="text-center">
                <strong>📍 Lokasi Toko</strong><br>
                <small>${lat.toFixed(6)}, ${lng.toFixed(6)}</small>
            </div>
        `).openPopup();

        // Update when marker is dragged
        marker.on('dragend', function(e) {
            const position = e.target.getLatLng();
            updateInputs(position.lat, position.lng);
        });

        // Center map to marker
        map.setView([lat, lng], 15);
    }

    // ========================================
    // 3. UPDATE INPUT FIELDS
    // ========================================
    function updateInputs(lat, lng) {
        // Update hidden inputs
        latInput.value = lat.toFixed(7);
        lngInput.value = lng.toFixed(7);

        // Update Google Maps link
        linkInput.value = `https://www.google.com/maps?q=${lat},${lng}`;

        // Show coordinate info
        coordinateInfo.classList.remove('hidden');
        displayCoordinates.textContent = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;

        // Show success notification
        showNotification('✅ Lokasi berhasil dipilih!', 'success');
    }

    // ========================================
    // 4. TOMBOL "PILIH LOKASI DI PETA"
    // ========================================
    pickLocationBtn.addEventListener('click', function() {
        if (!isMapInitialized) {
            // Initialize map 
            if (hasExistingLocation) {
                // Jika sudah ada lokasi, tampilkan itu
                initializeMap([currentLat, currentLng], 15);
            } else if (navigator.geolocation) {
                // Jika belum ada, coba pakai GPS
                loadingIndicator.classList.remove('hidden');
                
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        initializeMap([lat, lng], 13);
                        placeMarker(lat, lng);
                        updateInputs(lat, lng);
                        
                        loadingIndicator.classList.add('hidden');
                        showNotification('🗺️ Klik pada peta untuk memilih lokasi toko', 'info');
                    },
                    function(error) {
                        // Fallback to default center
                        initializeMap();
                        loadingIndicator.classList.add('hidden');
                        showNotification('🗺️ Klik pada peta untuk memilih lokasi toko', 'info');
                    }
                );
            } else {
                initializeMap();
                showNotification('🗺️ Klik pada peta untuk memilih lokasi toko', 'info');
            }
        } else {
            showNotification('🗺️ Klik pada peta untuk memilih lokasi toko', 'info');
        }
    });

    // ========================================
    // 5. TOMBOL "GUNAKAN LOKASI SAYA"
    // ========================================
    getLocationBtn.addEventListener('click', function() {
        if (!navigator.geolocation) {
            showNotification('❌ Browser tidak mendukung geolokasi', 'error');
            return;
        }

        loadingIndicator.classList.remove('hidden');
        getLocationBtn.disabled = true;
        getLocationBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Mengambil lokasi...';

        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                // Initialize map if not yet
                if (!isMapInitialized) {
                    initializeMap([lat, lng], 15);
                }

                // Place marker
                placeMarker(lat, lng);
                updateInputs(lat, lng);

                // Reset button
                getLocationBtn.disabled = false;
                getLocationBtn.innerHTML = '<i class="bx bx-current-location text-lg"></i> Gunakan Lokasi Saya Sekarang';
                loadingIndicator.classList.add('hidden');

                showNotification('✅ Lokasi berhasil diambil!', 'success');
            },
            function(error) {
                let errorMsg = 'Gagal mengambil lokasi';
                
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMsg = 'Akses lokasi ditolak. Mohon aktifkan di pengaturan browser.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMsg = 'Informasi lokasi tidak tersedia';
                        break;
                    case error.TIMEOUT:
                        errorMsg = 'Timeout saat mengambil lokasi';
                        break;
                }

                showNotification('❌ ' + errorMsg, 'error');
                
                getLocationBtn.disabled = false;
                getLocationBtn.innerHTML = '<i class="bx bx-current-location text-lg"></i> Gunakan Lokasi Saya Sekarang';
                loadingIndicator.classList.add('hidden');
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    });

    // ========================================
    // 6. PASTE LINK GOOGLE MAPS
    // ========================================
    linkInput.addEventListener('blur', function() {
        const url = this.value.trim();
        
        if (!url) return;

        loadingIndicator.classList.remove('hidden');

        // Extract coordinates from URL
        const patterns = [
            /@(-?\d+\.\d+),(-?\d+\.\d+)/,
            /q=(-?\d+\.\d+),(-?\d+\.\d+)/,
            /place\/[^\/]+\/@(-?\d+\.\d+),(-?\d+\.\d+)/,
            /ll=(-?\d+\.\d+),(-?\d+\.\d+)/,
        ];

        let coordinates = null;

        for (const pattern of patterns) {
            const match = url.match(pattern);
            if (match && match[1] && match[2]) {
                coordinates = {
                    lat: parseFloat(match[1]),
                    lng: parseFloat(match[2])
                };
                break;
            }
        }

        if (coordinates) {
            // Initialize map if not yet
            if (!isMapInitialized) {
                initializeMap([coordinates.lat, coordinates.lng], 15);
            }

            // Place marker
            placeMarker(coordinates.lat, coordinates.lng);
            updateInputs(coordinates.lat, coordinates.lng);

            showNotification('✅ Koordinat berhasil diambil dari link!', 'success');
        } else {
            // Jika tidak bisa extract, tetap update input
            latInput.value = latInput.value || '';
            lngInput.value = lngInput.value || '';
        }

        loadingIndicator.classList.add('hidden');
    });

    // ========================================
    // 7. AUTO-LOAD MAP jika sudah ada lokasi
    // ========================================
    if (hasExistingLocation) {
        // Auto-initialize map dengan lokasi existing
        setTimeout(() => {
            initializeMap([currentLat, currentLng], 15);
        }, 500);
    }

    // ========================================
    // 8. HELPER: NOTIFICATION
    // ========================================
    function showNotification(message, type = 'success') {
        const bgColor = type === 'success' ? 'bg-green-500' : 
                        type === 'error' ? 'bg-red-500' : 
                        'bg-blue-500';
        
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in-down`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
});
</script>
@endsection