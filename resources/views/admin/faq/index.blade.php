@extends('admin.layouts.app')

@section('title', 'Daftar FAQ')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar FAQ</h1>

    <a href="{{ route('admin.faq.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Tambah FAQ</a>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mt-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full mt-4 bg-white border">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="py-2 px-4 border">Pertanyaan</th>
                <th class="py-2 px-4 border">Jawaban</th>
                <th class="py-2 px-4 border w-40">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faqs as $faq)
            <tr>
                <td class="py-2 px-4 border">{{ $faq->pertanyaan }}</td>
                <td class="py-2 px-4 border">{{ Str::limit($faq->jawaban, 100) }}</td>
                <td class="py-2 px-4 border">
                    <a href="{{ route('admin.faq.edit', $faq->id) }}" class="px-3 py-1 bg-yellow-400 text-white rounded">Edit</a>
                    <form action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus FAQ ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
