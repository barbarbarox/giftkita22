@extends('layouts.penjual')

@section('title', 'Tambah Toko Baru | GiftKita Seller')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl p-8 mt-6 border border-gray-100">
    <h1 class="text-2xl font-bold text-[#007daf] mb-6">🛍️ Tambah Toko Baru</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
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
          class="space-y-6">
        @csrf
        <input type="hidden" name="penjual_id" value="{{ Auth::guard('penjual')->user()->id }}">

        {{-- Nama Toko --}}
        <div>
            <label class="block font-semibold mb-1">Nama Toko <span class="text-red-500">*</span></label>
            <input type="text" name="nama_toko" value="{{ old('nama_toko') }}" 
                   class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#007daf]" required>
        </div>

        {{-- Alamat --}}
        <div>
            <label class="block font-semibold mb-1">Alamat</label>
            <textarea name="alamat_toko" rows="2"
                      class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#007daf]">{{ old('alamat_toko') }}</textarea>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block font-semibold mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="3"
                      class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#007daf]">{{ old('deskripsi') }}</textarea>
        </div>

        {{-- Foto Profil --}}
        <div>
            <label class="block font-semibold mb-1">Foto Profil Toko</label>
            <input type="file" name="foto_profil" 
                   class="w-full border border-gray-300 rounded-lg p-2 cursor-pointer bg-gray-50">
            <p class="text-xs text-gray-500 mt-1">Format yang diperbolehkan: JPG, PNG (maks. 2MB)</p>
        </div>

        {{-- Sosial Media --}}
        <div class="border-t pt-4">
            <h2 class="text-lg font-semibold text-[#007daf] mb-3">📱 Sosial Media</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Instagram (opsional)</label>
                    <input type="url" name="instagram" value="{{ old('instagram') }}" 
                           placeholder="https://instagram.com/nama_toko"
                           class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#c771d4]">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Facebook (opsional)</label>
                    <input type="url" name="facebook" value="{{ old('facebook') }}" 
                           placeholder="https://facebook.com/nama_toko"
                           class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#3b5998]">
                </div>
                <div class="md:col-span-2">
                    <label class="block font-semibold mb-1">WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" 
                           placeholder="Contoh: 6281234567890"
                           class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500" required>
                </div>
            </div>
        </div>

        {{-- Tombol Simpan --}}
        <div class="pt-4 text-right">
            <button type="submit" 
                    class="px-6 py-2 bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white font-semibold rounded-lg shadow hover:scale-105 transition">
                💾 Simpan Toko
            </button>
        </div>
    </form>
</div>
@endsection
