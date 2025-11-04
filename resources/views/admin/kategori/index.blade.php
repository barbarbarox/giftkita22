@extends('admin.layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-700">Daftar Kategori</h2>
        <a href="{{ route('admin.kategori.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">+ Tambah</a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="min-w-full border border-gray-300">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="py-2 px-4 border">No</th>
                <th class="py-2 px-4 border">Nama Kategori</th>
                <th class="py-2 px-4 border">Deskripsi</th>
                <th class="py-2 px-4 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kategoris as $index => $kategori)
                <tr class="text-center">
                    <td class="py-2 px-4 border">{{ $index + 1 }}</td>
                    <td class="py-2 px-4 border">{{ $kategori->nama_kategori }}</td>
                    <td class="py-2 px-4 border">{{ $kategori->deskripsi ?? '-' }}</td>
                    <td class="py-2 px-4 border">
                        <a href="{{ route('admin.kategori.edit', $kategori->id) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Edit</a>
                        <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="py-4 text-gray-500">Belum ada kategori.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">{{ $kategoris->links() }}</div>
</div>
@endsection
