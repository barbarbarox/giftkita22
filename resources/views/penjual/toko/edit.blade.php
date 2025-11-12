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
        {{-- 📍 LOKASI TOKO (BAGIAN PETA & INPUT) --}}
        {{-- ========================================================= --}}
        <div class="md:col-span-2 p-6 bg-gray-50 border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
            <h2 class="text-lg font-semibold text-[#007daf] mb-4 flex items-center gap-2">
                <i class='bx bx-map text-[#007daf] text-xl'></i> Lokasi Toko
            </h2>

            <div class="grid md:grid-cols-2 gap-6">
                {{-- PREVIEW PETA --}}
                <div>
                    <label class="block font-semibold mb-2">Preview Google Maps</label>
                    
                    {{-- Preview iframe (akan diupdate via JavaScript) --}}
                    <iframe id="mapPreviewFrame" 
                            src="{{ $toko->embed_url     ?? '' }}" 
                            width="100%" 
                            height="300" 
                            style="border:0;" 
                            class="rounded-lg shadow-sm border border-gray-300 {{ $toko->hasMapLocation() ? '' : 'hidden' }}" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    
                    {{-- Placeholder jika belum ada peta --}}
                    <div id="mapPlaceholder" 
                         class="w-full h-[300px] flex items-center justify-center bg-gray-100 border border-gray-300 rounded-lg {{ $toko->hasMapLocation() ? 'hidden' : '' }}">
                        <div class="text-center">
                            <i class='bx bx-map text-gray-400 text-5xl mb-2'></i>
                            <p class="text-gray-500 italic">Preview peta akan muncul di sini</p>
                            <p class="text-xs text-gray-400 mt-1">Paste link Google Maps atau gunakan lokasi Anda</p>
                        </div>
                    </div>

                    {{-- Info koordinat saat ini --}}
                    @if($toko->hasMapLocation())
                    <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-xs text-blue-800">
                            <i class='bx bx-current-location'></i> 
                            <strong>Koordinat saat ini:</strong><br>
                            Lat: {{ $toko->latitude ?? '-' }}, Lng: {{ $toko->longitude ?? '-' }}
                        </p>
                    </div>
                    @endif
                </div>

                {{-- FORM INPUT LOKASI --}}
                <div>
                    <label class="block font-semibold mb-2">Link Google Maps</label>
                    <input type="url" 
                           name="google_map_link" 
                           id="google_map_link"
                           value="{{ old('google_map_link', $toko->google_map_link) }}"
                           placeholder="https://maps.app.goo.gl/xxxxx atau https://goo.gl/maps/xxxxx"
                           class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#007daf] mb-2">
                    
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-3 mb-4">
                        <p class="text-xs text-blue-800">
                            <strong>💡 Cara mendapatkan link:</strong><br>
                            1. Buka Google Maps di HP/Komputer<br>
                            2. Cari lokasi toko Anda<br>
                            3. Klik tombol "Bagikan" atau "Share"<br>
                            4. Pilih "Salin link" atau "Copy link"<br>
                            5. Paste di kolom di atas
                        </p>
                    </div>

                    {{-- Hidden inputs untuk lat/lng (akan diisi otomatis oleh controller) --}}
                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $toko->latitude) }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $toko->longitude) }}">

                    {{-- Tombol gunakan lokasi saya --}}
                    <button type="button" 
                            id="getLocation"
                            class="w-full px-4 py-2 bg-[#007daf] text-white rounded-lg text-sm font-medium hover:bg-[#006b9c] transition flex items-center justify-center gap-2">
                        <i class='bx bx-current-location text-lg'></i>
                        Gunakan Lokasi Saya Sekarang
                    </button>
                    
                    <p class="text-xs text-gray-500 mt-2">
                        <i class='bx bx-info-circle'></i> 
                        Sistem akan otomatis mengambil koordinat dari link yang Anda masukkan
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
{{-- ⭐️ JAVASCRIPT untuk Preview Peta Real-time --}}
{{-- ========================================================= --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ambil elemen
    const linkInput = document.getElementById('google_map_link');
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const mapPreview = document.getElementById('mapPreviewFrame');
    const mapPlaceholder = document.getElementById('mapPlaceholder');
    const getLocationBtn = document.getElementById('getLocation');
    const loadingIndicator = document.getElementById('loadingIndicator');

    // ========================================
    // 1. AUTO-EXTRACT KOORDINAT dari Link (HANYA UNTUK PREVIEW)
    // ========================================
    linkInput.addEventListener('blur', function() {
        const url = this.value.trim();
        
        if (!url) {
            return;
        }

        // Tampilkan loading
        if (loadingIndicator) {
            loadingIndicator.classList.remove('hidden');
        }

        // Coba extract koordinat dari URL TANPA mengubah nilai input
        extractCoordinatesFromUrl(url);
    });

    // Fungsi extract koordinat dari berbagai format URL Google Maps
    // PENTING: Fungsi ini HANYA untuk preview, TIDAK mengubah input google_map_link
    function extractCoordinatesFromUrl(url) {
        // Pattern untuk menangkap koordinat dari URL
        const patterns = [
            /@(-?\d+\.\d+),(-?\d+\.\d+)/,  // Format: @lat,lng
            /q=(-?\d+\.\d+),(-?\d+\.\d+)/, // Format: q=lat,lng
            /place\/[^\/]+\/@(-?\d+\.\d+),(-?\d+\.\d+)/, // Format place/@lat,lng
            /ll=(-?\d+\.\d+),(-?\d+\.\d+)/, // Format: ll=lat,lng
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
            // Update input hidden (untuk preview saja, bukan untuk submit)
            latInput.value = coordinates.lat;
            lngInput.value = coordinates.lng;
            
            // Update preview peta
            updateMapPreview(coordinates.lat, coordinates.lng);
        } else {
            // Jika tidak bisa extract (link pendek/format lain)
            // Biarkan controller yang handle saat submit
            // Tetap tampilkan peta dari koordinat yang ada (jika ada)
            if (latInput.value && lngInput.value) {
                updateMapPreview(latInput.value, lngInput.value);
            }
            console.log('Link akan diproses oleh server');
        }

        // Sembunyikan loading
        if (loadingIndicator) {
            loadingIndicator.classList.add('hidden');
        }
    }

    // ========================================
    // 2. GUNAKAN LOKASI SAAT INI (Geolocation)
    // ========================================
    getLocationBtn.addEventListener('click', function() {
        if (!navigator.geolocation) {
            alert('❌ Browser Anda tidak mendukung fitur geolokasi');
            return;
        }

        // Tampilkan loading
        if (loadingIndicator) {
            loadingIndicator.classList.remove('hidden');
        }
        getLocationBtn.disabled = true;
        getLocationBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Mengambil lokasi...';

        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                // Update input hidden
                latInput.value = lat;
                lngInput.value = lng;

                // Update link Google Maps
                linkInput.value = `https://www.google.com/maps?q=${lat},${lng}`;

                // Update preview peta
                updateMapPreview(lat, lng);

                // Reset button
                getLocationBtn.disabled = false;
                getLocationBtn.innerHTML = '<i class="bx bx-current-location text-lg"></i> Gunakan Lokasi Saya Sekarang';
                
                // Sembunyikan loading
                if (loadingIndicator) {
                    loadingIndicator.classList.add('hidden');
                }

                // Notifikasi sukses
                showNotification('✅ Lokasi berhasil diambil!', 'success');
            },
            function(error) {
                let errorMsg = 'Gagal mengambil lokasi';
                
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMsg = 'Anda menolak izin akses lokasi. Mohon aktifkan di pengaturan browser.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMsg = 'Informasi lokasi tidak tersedia';
                        break;
                    case error.TIMEOUT:
                        errorMsg = 'Timeout saat mengambil lokasi';
                        break;
                }

                alert('❌ ' + errorMsg);
                
                // Reset button
                getLocationBtn.disabled = false;
                getLocationBtn.innerHTML = '<i class="bx bx-current-location text-lg"></i> Gunakan Lokasi Saya Sekarang';
                
                // Sembunyikan loading
                if (loadingIndicator) {
                    loadingIndicator.classList.add('hidden');
                }
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    });

    // ========================================
    // 3. UPDATE PREVIEW PETA
    // ========================================
    function updateMapPreview(lat, lng) {
        if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
            // Sembunyikan peta, tampilkan placeholder
            mapPreview.classList.add('hidden');
            mapPlaceholder.classList.remove('hidden');
            return;
        }

        // Update src iframe dengan koordinat
        const embedUrl = `https://www.google.com/maps?q=${lat},${lng}&hl=id&z=15&output=embed`;
        mapPreview.src = embedUrl;

        // Tampilkan peta, sembunyikan placeholder
        mapPreview.classList.remove('hidden');
        mapPlaceholder.classList.add('hidden');
    }

    // ========================================
    // 4. HELPER: Notifikasi
    // ========================================
    function showNotification(message, type = 'success') {
        const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
        
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in-down`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Load preview saat halaman dimuat
    const currentLat = latInput.value;
    const currentLng = lngInput.value;
    if (currentLat && currentLng) {
        updateMapPreview(currentLat, currentLng);
    }
});
</script>

<style>
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
@endsection