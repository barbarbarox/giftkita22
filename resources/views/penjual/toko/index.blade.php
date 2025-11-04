@extends('layouts.penjual')

@section('title', 'Daftar Toko | GiftKita Seller')

@section('content')
<div class="max-w-6xl mx-auto">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Toko Anda</h1>

        <a href="{{ route('penjual.toko.create') }}" 
           class="px-4 py-2 bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white rounded shadow hover:scale-105 transition">
            ➕ Tambah Toko
        </a>
    </div>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- Jika belum ada toko --}}
    @if($tokos->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 p-5 rounded-lg text-yellow-800 text-center">
            Anda belum memiliki toko.
            <a href="{{ route('penjual.toko.create') }}" 
               class="text-[#007daf] font-semibold underline ml-1">
               Buat toko sekarang
            </a>
        </div>
    @else
        {{-- Daftar toko --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tokos as $toko)
                <div class="bg-white shadow-md rounded-xl p-5 border border-gray-100 hover:shadow-lg transition">
                    {{-- Foto toko --}}
                    <div class="relative">
                        @if($toko->foto_profil)
                            <img src="{{ asset($toko->foto_profil) }}" 
                                 alt="Foto Toko" 
                                 class="w-full h-40 object-cover rounded-lg border border-gray-200">
                        @else
                            <div class="w-full h-40 bg-gray-100 flex items-center justify-center text-gray-400 rounded-lg">
                                Tidak ada foto
                            </div>
                        @endif
                    </div>

                    {{-- Info toko --}}
                    <div class="mt-4">
                        <h2 class="text-lg font-bold text-[#007daf]">{{ $toko->nama_toko }}</h2>
                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                            {{ $toko->deskripsi ?? 'Belum ada deskripsi.' }}
                        </p>
                        <p class="mt-2 text-sm text-gray-700">
                            📍 {{ $toko->alamat_toko ?? 'Alamat belum diisi' }}
                        </p>
                        <p class="text-sm text-gray-700">
                            📞 {{ $toko->whatsapp ?? '-' }}
                        </p>
                    </div>

                    {{-- Tombol aksi --}}
                    <div class="flex justify-between mt-4">
                        <a href="{{ route('penjual.toko.edit', $toko->uuid) }}" 
                           class="px-3 py-1.5 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-sm">
                            ✏️ Edit
                        </a>

                        <form action="{{ route('penjual.toko.destroy', $toko->uuid) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus toko ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1.5 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
