@extends('layouts.penjual')

@section('title', 'Tambah Toko Baru | GiftKita Seller')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-lg rounded-2xl p-8 mt-6 border border-gray-100">
    <h1 class="text-2xl font-bold text-[#007daf] mb-6">🛍️ Tambah Toko Baru</h1>

    {{-- ALERT ERROR --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penjual.toko.store') }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="grid md:grid-cols-2 gap-8">
        @csrf
        <input type="hidden" name="penjual_id" value="{{ Auth::guard('penjual')->user()->id }}">

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
                    <input type="text" name="nama_toko" value="{{ old('nama_toko') }}" 
                           class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#007daf]" required>
                </div>

                {{-- Alamat --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Kabupaten/Kota</label>
                    <textarea name="alamat_toko" rows="2"
                              class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#007daf]">{{ old('alamat_toko') }}</textarea>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block font-semibold mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="4"
                              class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#007daf]">{{ old('deskripsi') }}</textarea>
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- 🖼️ KOLOM KANAN: FOTO PROFIL + SOSIAL MEDIA + LOKASI --}}
        {{-- ========================================================= --}}
        <div class="space-y-6">
            {{-- Foto Profil --}}
            <div class="p-6 bg-gray-50 border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
                <h2 class="text-lg font-semibold text-[#007daf] mb-3 flex items-center gap-2">
                    <i class='bx bx-image text-[#007daf] text-xl'></i> Foto Profil
                </h2>
                <input type="file" name="foto_profil" 
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
                        <input type="url" name="instagram" value="{{ old('instagram') }}" 
                               placeholder="https://instagram.com/nama_toko"
                               class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-pink-400">
                    </div>

                    {{-- Facebook --}}
                    <div>
                        <label class="block font-semibold mb-1 flex items-center gap-2">
                            <i class='bx bxl-facebook text-blue-600 text-lg'></i> Facebook
                        </label>
                        <input type="url" name="facebook" value="{{ old('facebook') }}" 
                               placeholder="https://facebook.com/nama_toko"
                               class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-600">
                    </div>

                    {{-- WhatsApp --}}
                    <div>
                        <label class="block font-semibold mb-1 flex items-center gap-2">
                            <i class='bx bxl-whatsapp text-green-500 text-lg'></i> WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" 
                               placeholder="Contoh: 6281234567890"
                               class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500" required>
                    </div>
                </div>
            </div>

            {{-- Lokasi Toko --}}
            <div class="p-6 bg-gray-50 border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
                <h2 class="text-lg font-semibold text-[#007daf] mb-4 flex items-center gap-2">
                    <i class='bx bx-map text-[#007daf] text-xl'></i> Lokasi Toko
                </h2>

                {{-- Link Google Maps --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Link Google Maps (opsional)</label>
                    <input type="url" name="google_map_link" value="{{ old('google_map_link') }}"
                           placeholder="https://www.google.com/maps/place/..."
                           class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#007daf]">
                    <p class="text-xs text-gray-500 mt-1">
                        Gunakan link dari <b>Bagikan → Sematkan peta → Salin URL</b>.
                    </p>
                </div>

                {{-- Latitude & Longitude --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1">Latitude</label>
                        <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}"
                               class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#007daf]">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Longitude</label>
                        <input type="text" name="longitude" id="longitude" value="{{ old('longitude') }}"
                               class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#007daf]">
                    </div>
                </div>

                {{-- Tombol Ambil Lokasi --}}
                <button type="button" id="getLocation"
                        class="mt-3 px-4 py-2 bg-[#007daf] text-white rounded-lg text-sm font-medium hover:bg-[#006b9c] transition">
                    📍 Gunakan Lokasi Saya
                </button>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- 🧩 FOOTER: TOMBOL SIMPAN --}}
        {{-- ========================================================= --}}
        <div class="md:col-span-2 text-right pt-8 border-t">
            <button type="submit" 
                    class="px-6 py-2 bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white font-semibold rounded-lg shadow hover:scale-105 transition">
                💾 Simpan Toko
            </button>
        </div>
    </form>
</div>

{{-- SCRIPT: Ambil Lokasi Otomatis --}}
<script>
document.getElementById("getLocation").addEventListener("click", () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((pos) => {
            document.getElementById("latitude").value = pos.coords.latitude;
            document.getElementById("longitude").value = pos.coords.longitude;
        }, (err) => {
            alert("Gagal mendapatkan lokasi: " + err.message);
        });
    } else {
        alert("Browser kamu tidak mendukung geolokasi.");
    }
});
</script>
@endsection