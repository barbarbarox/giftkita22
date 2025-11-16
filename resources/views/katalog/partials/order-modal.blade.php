{{-- Modal Pesanan --}}
<div id="orderModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-fade-in">
    <div class="bg-white rounded-3xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto animate-scale-in">
        {{-- Modal Header --}}
        <div class="sticky top-0 bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white px-8 py-6 rounded-t-3xl z-10">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold">📝 Bagaimana Cara Kami Hubungi Anda?</h2>
                    <p class="text-white/90 text-sm mt-1">Isi data Anda untuk melanjutkan pesanan</p>
                </div>
                <button 
                    onclick="closeOrderModal()"
                    class="bg-white/20 hover:bg-white/30 rounded-full p-2 transition-all duration-300 hover:rotate-90"
                >
                    <i class='bx bx-x text-3xl'>X</i>
                </button>
            </div>
        </div>

        {{-- Modal Body --}}
        <form id="orderForm" class="p-8 space-y-6">
            @csrf
            <input type="hidden" id="produk_id" name="produk_id">

            {{-- Data Diri Section --}}
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border-2 border-blue-200">
                <h3 class="text-lg font-bold text-[#007daf] mb-4 flex items-center gap-2">
                    <i class='bx bx-user-circle text-2xl'></i>
                    Data Diri
                </h3>

                <div class="grid md:grid-cols-2 gap-4">
                    {{-- Nama --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="nama_pembeli" 
                            required
                            placeholder="Masukkan nama lengkap"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-[#007daf] focus:ring-2 focus:ring-[#007daf]/20 transition-all duration-300"
                        >
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Email <span class="text-gray-400">(opsional)</span>
                        </label>
                        <input 
                            type="email" 
                            name="email_pembeli"
                            placeholder="contoh:email@example.com"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-[#007daf] focus:ring-2 focus:ring-[#007daf]/20 transition-all duration-300"
                        >
                    </div>

                    {{-- No HP --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="tel" 
                            name="no_hp_pembeli" 
                            required
                            placeholder="Contoh: 081234567890"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-[#007daf] focus:ring-2 focus:ring-[#007daf]/20 transition-all duration-300"
                        >
                        <p class="text-xs text-gray-500 mt-1">Format: 08xxxxxxxxxx atau 628xxxxxxxxxx</p>
                    </div>
                </div>
            </div>

            {{-- Alamat Section --}}
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 border-2 border-purple-200">
                <h3 class="text-lg font-bold text-[#c771d4] mb-4 flex items-center gap-2">
                    <i class='bx bx-map-pin text-2xl'></i>
                    Alamat Pengiriman
                </h3>

                {{-- Alamat Lengkap --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="alamat_pembeli" 
                        required
                        rows="3"
                        placeholder="Masukkan alamat lengkap (Jalan, RT/RW, Kelurahan, Kecamatan, Kota)"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-[#c771d4] focus:ring-2 focus:ring-[#c771d4]/20 transition-all duration-300"
                    ></textarea>
                </div>

                {{-- Info Section --}}
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4 rounded-r-xl">
                    <p class="text-sm text-blue-800">
                        <strong>💡 Tips:</strong> Untuk memudahkan pengiriman, Anda dapat memilih salah satu cara berikut untuk menunjukkan lokasi:
                    </p>
                </div>

                {{-- Location Options --}}
                <div class="space-y-3 mb-4">
                    <label class="flex items-center gap-3 p-4 bg-white rounded-xl cursor-pointer hover:bg-gray-50 transition-all duration-300 border-2 border-gray-200 hover:border-[#007daf]">
                        <input type="radio" name="location_method" value="link" class="w-5 h-5 text-[#007daf]">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">🔗 Link Google Maps</p>
                            <p class="text-xs text-gray-500">Paste link lokasi dari Google Maps</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-4 bg-white rounded-xl cursor-pointer hover:bg-gray-50 transition-all duration-300 border-2 border-gray-200 hover:border-[#007daf]">
                        <input type="radio" name="location_method" value="picker" class="w-5 h-5 text-[#007daf]">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">🗺️ Pilih di Peta</p>
                            <p class="text-xs text-gray-500">Klik lokasi langsung di peta interaktif</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-4 bg-white rounded-xl cursor-pointer hover:bg-gray-50 transition-all duration-300 border-2 border-gray-200 hover:border-[#007daf]">
                        <input type="radio" name="location_method" value="gps" class="w-5 h-5 text-[#007daf]">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">📍 Lokasi Saya Saat Ini</p>
                            <p class="text-xs text-gray-500">Gunakan GPS untuk ambil lokasi otomatis</p>
                        </div>
                    </label>
                </div>

                {{-- Google Maps Link Input --}}
                <div id="linkInput" class="hidden mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Link Google Maps
                    </label>
                    <input 
                        type="url" 
                        name="google_map_link" 
                        id="google_map_link"
                        placeholder="https://maps.app.goo.gl/xxxxx"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-[#c771d4] focus:ring-2 focus:ring-[#c771d4]/20 transition-all duration-300"
                    >
                </div>

                {{-- Map Picker --}}
                <div id="mapPicker" class="hidden mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Pilih Lokasi di Peta
                    </label>
                    <div id="map" class="w-full h-[300px] rounded-xl border-2 border-gray-200 overflow-hidden"></div>
                    <p class="text-xs text-gray-500 mt-2">Klik di peta untuk memilih lokasi pengiriman</p>
                </div>

                {{-- Hidden Coordinates --}}
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                {{-- Coordinate Info --}}
                <div id="coordinateInfo" class="hidden mt-3 p-3 bg-green-50 border border-green-200 rounded-xl">
                    <p class="text-sm text-green-800">
                        <i class='bx bx-check-circle'></i> 
                        <strong>Lokasi dipilih:</strong>
                        <span id="displayCoordinates"></span>
                    </p>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="flex gap-4">
                <button 
                    type="button"
                    onclick="closeOrderModal()"
                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-4 rounded-xl transition-all duration-300"
                >
                    Batal
                </button>
                <button 
                    type="submit"
                    class="flex-1 bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white font-bold py-4 rounded-xl transition-all duration-300 hover:shadow-xl hover:scale-105 flex items-center justify-center gap-2"
                >
                    <i class='bx bxl-whatsapp text-2xl'></i>
                    Lanjut ke WhatsApp
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Leaflet CSS for Map --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
@keyframes scale-in {
    from {
        transform: scale(0.9);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.animate-scale-in {
    animation: scale-in 0.3s ease-out;
}

#orderModal {
    animation: fade-in 0.3s ease-out;
}
</style>

<script>
let map = null;
let marker = null;
let isMapInitialized = false;

// Open Modal
function openOrderModal(produkId) {
    document.getElementById('orderModal').classList.remove('hidden');
    document.getElementById('produk_id').value = produkId;
    document.body.style.overflow = 'hidden';
}

// Close Modal
function closeOrderModal() {
    document.getElementById('orderModal').classList.add('hidden');
    document.getElementById('orderForm').reset();
    document.body.style.overflow = 'auto';
    
    // Hide all location inputs
    document.getElementById('linkInput').classList.add('hidden');
    document.getElementById('mapPicker').classList.add('hidden');
    document.getElementById('coordinateInfo').classList.add('hidden');
}

// Location Method Change
document.querySelectorAll('input[name="location_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // Hide all
        document.getElementById('linkInput').classList.add('hidden');
        document.getElementById('mapPicker').classList.add('hidden');
        
        if (this.value === 'link') {
            document.getElementById('linkInput').classList.remove('hidden');
        } else if (this.value === 'picker') {
            document.getElementById('mapPicker').classList.remove('hidden');
            initializeMap();
        } else if (this.value === 'gps') {
            getUserLocation();
        }
    });
});

// Initialize Map
function initializeMap() {
    if (isMapInitialized) return;
    
    const mapContainer = document.getElementById('map');
    map = L.map('map').setView([-2.5489, 118.0149], 5); // Indonesia center
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);
    
    map.on('click', function(e) {
        placeMarker(e.latlng.lat, e.latlng.lng);
    });
    
    isMapInitialized = true;
}

// Place Marker
function placeMarker(lat, lng) {
    if (marker) {
        map.removeLayer(marker);
    }
    
    marker = L.marker([lat, lng]).addTo(map);
    map.setView([lat, lng], 15);
    
    document.getElementById('latitude').value = lat.toFixed(7);
    document.getElementById('longitude').value = lng.toFixed(7);
    
    showCoordinateInfo(lat, lng);
}

// Get User Location (GPS)
function getUserLocation() {
    if (!navigator.geolocation) {
        alert('Browser Anda tidak mendukung geolocation');
        return;
    }
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            
            document.getElementById('latitude').value = lat.toFixed(7);
            document.getElementById('longitude').value = lng.toFixed(7);
            
            showCoordinateInfo(lat, lng);
            alert('✅ Lokasi berhasil diambil!');
        },
        function(error) {
            alert('❌ Gagal mengambil lokasi: ' + error.message);
        }
    );
}

// Show Coordinate Info
function showCoordinateInfo(lat, lng) {
    const info = document.getElementById('coordinateInfo');
    const display = document.getElementById('displayCoordinates');
    
    display.textContent = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
    info.classList.remove('hidden');
}

// Google Maps Link Input - Auto Extract Coordinates
document.getElementById('google_map_link')?.addEventListener('blur', function() {
    const url = this.value.trim();
    if (!url) return;
    
    const patterns = [
        /@(-?\d+\.\d+),(-?\d+\.\d+)/,
        /q=(-?\d+\.\d+),(-?\d+\.\d+)/,
    ];
    
    for (const pattern of patterns) {
        const match = url.match(pattern);
        if (match) {
            document.getElementById('latitude').value = match[1];
            document.getElementById('longitude').value = match[2];
            showCoordinateInfo(match[1], match[2]);
            break;
        }
    }
});

// Form Submit
document.getElementById('orderForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin text-2xl"></i> Memproses...';
    
    fetch('{{ route("pesanan.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect to WhatsApp
            window.location.href = data.whatsapp_url;
        } else {
            alert('❌ ' + data.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bx bxl-whatsapp text-2xl"></i> Lanjut ke WhatsApp';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Terjadi kesalahan. Silakan coba lagi.');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bx bxl-whatsapp text-2xl"></i> Lanjut ke WhatsApp';
    });
});

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeOrderModal();
    }
});
</script>