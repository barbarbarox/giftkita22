@extends('admin.layouts.app')

@section('title', 'Tambah FAQ')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Tambah FAQ</h1>

    <form action="{{ route('admin.faq.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="pertanyaan" class="block font-semibold">Pertanyaan</label>
            <input type="text" name="pertanyaan" id="pertanyaan" value="{{ old('pertanyaan') }}" class="w-full border rounded p-2">
            @error('pertanyaan')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="jawaban" class="block font-semibold">Jawaban</label>
            <textarea name="jawaban" id="jawaban" rows="5" class="w-full border rounded p-2">{{ old('jawaban') }}</textarea>
            @error('jawaban')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Simpan</button>
    </form>
</div>
@endsection
