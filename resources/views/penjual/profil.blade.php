@extends('layouts.penjual')

@section('title', 'Profil Penjual | GiftKita Seller')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-6">
    <h1 class="text-2xl font-bold mb-4 text-[#007daf]">Profil Penjual</h1>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Profil --}}
    <form action="{{ route('penjual.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Foto Profil --}}
        <div class="flex items-center gap-4 mb-4">
            @if($foto)
                <img src="{{ asset($foto->filepath) }}" class="w-24 h-24 rounded-full object-cover border" alt="Foto Profil">
            @else
                <div class="w-24 h-24 flex items-center justify-center bg-gray-100 text-gray-400 rounded-full">
                    <span>Tidak ada foto</span>
                </div>
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-700">Ganti Foto Profil</label>
                <input type="file" name="foto_profil" class="mt-1 block w-full text-sm border rounded p-2">
            </div>
        </div>

        {{-- Username --}}
        <div>
            <label class="block font-medium text-gray-700">Username</label>
            <input type="text" name="username" value="{{ old('username', $penjual->username) }}" 
                   class="w-full border rounded p-2" required>
        </div>

        {{-- Email --}}
        <div>
            <label class="block font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email', $penjual->email) }}" 
                   class="w-full border rounded p-2" required>
        </div>

        {{-- Nomor HP --}}
        <div>
            <label class="block font-medium text-gray-700">Nomor HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp', $penjual->no_hp) }}" 
                   class="w-full border rounded p-2" required>
        </div>

        {{-- Tombol Simpan --}}
        <button type="submit" class="bg-gradient-to-r from-[#007daf] to-[#ffb829] text-white px-6 py-2 rounded-lg shadow hover:scale-105 transition">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection
