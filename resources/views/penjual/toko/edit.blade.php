@extends('layouts.penjual')

@section('title', 'Edit Profil Toko | GiftKita Seller')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-8 border border-gray-100">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        ✏️ Edit Profil Toko
    </h1>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Edit --}}
    <form action="{{ route('penjual.toko.update', $toko->uuid) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Nama Toko --}}
        <div>
            <label class="block font-medium mb-1">Nama Toko</label>
            <input type="text" name="nama_toko" value="{{ old('nama_toko', $toko->nama_toko) }}" 
                   class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-[#007daf]" required>
        </div>

        {{-- Alamat --}}
        <div>
            <label class="block font-medium mb-1">Alamat</label>
            <textarea name="alamat_toko" rows="2" 
                      class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-[#007daf]">{{ old('alamat_toko', $toko->alamat_toko) }}</textarea>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block font-medium mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="3" 
                      class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-[#007daf]">{{ old('deskripsi', $toko->deskripsi) }}</textarea>
        </div>

        {{-- Foto Profil --}}
        <div>
            <label class="block font-medium mb-1">Foto Profil Toko</label>
            @if($toko->foto_profil)
                <div class="mb-2">
                    <img src="{{ asset($toko->foto_profil) }}" alt="Foto Profil" class="w-32 h-32 object-cover rounded-lg shadow">
                </div>
            @endif
            <input type="file" name="foto_profil" accept="image/*"
                   class="w-full border rounded-lg p-2 cursor-pointer bg-gray-50 hover:bg-gray-100">
            <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG (max 2MB)</p>
        </div>

        {{-- Sosial Media --}}
        <div class="grid md:grid-cols-3 gap-4">
            <div>
                <label class="block font-medium mb-1 text-pink-500">Instagram (opsional)</label>
                <input type="url" name="instagram" value="{{ old('instagram', $toko->instagram) }}"
                       class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-pink-400" placeholder="https://instagram.com/namatoko">
            </div>

            <div>
                <label class="block font-medium mb-1 text-green-600">WhatsApp (wajib)</label>
                <input type="text" name="whatsapp" value="{{ old('whatsapp', $toko->whatsapp) }}"
                       class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-green-400" placeholder="08xxxx / +628xxxx" required>
            </div>

            <div>
                <label class="block font-medium mb-1 text-blue-600">Facebook (opsional)</label>
                <input type="url" name="facebook" value="{{ old('facebook', $toko->facebook) }}"
                       class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400" placeholder="https://facebook.com/namatoko">
            </div>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-between mt-6">
            <a href="{{ route('penjual.toko.index') }}" 
               class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700">⬅️ Kembali</a>

            <button type="submit" 
                    class="px-6 py-2 bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white font-semibold rounded-lg shadow hover:scale-105 transition">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
