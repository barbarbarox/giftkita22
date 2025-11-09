@extends('admin.layouts.app')

@section('title', 'Tambah FAQ')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">📝 Tambah FAQ Baru</h1>

    {{-- ✅ Notifikasi error validasi --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-5">
            <ul class="list-disc pl-6 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.faq.store') }}" method="POST" class="space-y-5 bg-white p-6 rounded-lg shadow-md border">
        @csrf

        {{-- Pertanyaan --}}
        <div>
            <label for="pertanyaan" class="block text-gray-700 font-semibold mb-2">Pertanyaan</label>
            <input type="text" id="pertanyaan" name="pertanyaan" value="{{ old('pertanyaan') }}"
                   class="w-full border-gray-300 rounded-lg focus:ring-[#007daf] focus:border-[#007daf]" required>
        </div>

        {{-- Jawaban --}}
        <div>
            <label for="jawaban" class="block text-gray-700 font-semibold mb-2">Jawaban</label>
            <textarea id="jawaban" name="jawaban" rows="4"
                      class="w-full border-gray-300 rounded-lg focus:ring-[#007daf] focus:border-[#007daf]"
                      required>{{ old('jawaban') }}</textarea>
        </div>

        {{-- Role (Kategori FAQ) --}}
        <div>
            <label for="role" class="block text-gray-700 font-semibold mb-2">Untuk Pengguna</label>
            <select id="role" name="role" class="w-full border-gray-300 rounded-lg focus:ring-[#007daf] focus:border-[#007daf]" required>
                <option value="" disabled selected>Pilih kategori pengguna...</option>
                <option value="pembeli" {{ old('role') == 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                <option value="penjual" {{ old('role') == 'penjual' ? 'selected' : '' }}>Penjual</option>
                <option value="umum" {{ old('role') == 'umum' ? 'selected' : '' }}>Umum</option>
            </select>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('admin.faq.index') }}"
               class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition">
                Batal
            </a>
            <button type="submit"
                    class="px-5 py-2 rounded-lg bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white font-semibold hover:scale-105 transition">
                Simpan FAQ
            </button>
        </div>
    </form>
</div>
@endsection
