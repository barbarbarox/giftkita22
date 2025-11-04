@extends('admin.layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-lg font-semibold mb-4">Edit Kategori</h2>

    <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="block font-medium">Nama Kategori</label>
            <input type="text" name="nama_kategori" class="border rounded w-full p-2" value="{{ old('nama_kategori', $kategori->nama_kategori) }}">
            @error('nama_kategori') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label class="block font-medium">Deskripsi</label>
            <textarea name="deskripsi" class="border rounded w-full p-2" rows="4">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
        </div>

        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Update</button>
        <a href="{{ route('admin.kategori.index') }}" class="ml-2 text-gray-600">Kembali</a>
    </form>
</div>
@endsection
