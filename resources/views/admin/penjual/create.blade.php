@extends('admin.layouts.app')

@section('content')
<div class="p-6 max-w-lg mx-auto">
    <h1 class="text-2xl font-semibold mb-4">Tambah Penjual Baru</h1>

    {{-- Pesan Error Validasi --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.penjual.store') }}" method="POST" class="bg-white shadow-md rounded px-6 py-4">
        @csrf

        {{-- Username --}}
        <div class="mb-4">
            <label class="block mb-2 text-gray-700 font-semibold">Username</label>
            <input type="text" name="username" value="{{ old('username') }}" 
                   class="w-full border rounded p-2 focus:ring focus:ring-blue-200" required>
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label class="block mb-2 text-gray-700 font-semibold">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" 
                   class="w-full border rounded p-2 focus:ring focus:ring-blue-200" required>
        </div>

        {{-- Nomor HP --}}
        <div class="mb-4">
            <label class="block mb-2 text-gray-700 font-semibold">No HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp') }}" 
                   class="w-full border rounded p-2 focus:ring focus:ring-blue-200">
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <label class="block mb-2 text-gray-700 font-semibold">Password</label>
            <input type="password" name="password" 
                   class="w-full border rounded p-2 focus:ring focus:ring-blue-200" required>
        </div>

        {{-- Konfirmasi Password --}}
        <div class="mb-6">
            <label class="block mb-2 text-gray-700 font-semibold">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" 
                   class="w-full border rounded p-2 focus:ring focus:ring-blue-200" required>
        </div>

        {{-- Tombol Submit --}}
        <div class="flex justify-end">
            <button type="submit" 
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
