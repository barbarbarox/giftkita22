@extends('admin.layouts.app')

@section('title', 'Daftar FAQ')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📚 Daftar FAQ</h1>
        <a href="{{ route('admin.faq.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            + Tambah FAQ
        </a>
    </div>

    {{-- ✅ Notifikasi sukses --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-5">
            {{ session('success') }}
        </div>
    @endif

    @if($faqs->isEmpty())
        <p class="text-gray-500 text-center py-10">Belum ada data FAQ.</p>
    @else
        <div class="overflow-x-auto bg-white border rounded-lg shadow">
            <table class="min-w-full border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="py-3 px-4 border text-left">Pertanyaan</th>
                        <th class="py-3 px-4 border text-left">Jawaban</th>
                        <th class="py-3 px-4 border text-center">Untuk</th>
                        <th class="py-3 px-4 border text-center w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faqs as $faq)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 border align-top">{{ $faq->pertanyaan }}</td>
                            <td class="py-3 px-4 border text-gray-600 align-top">{{ Str::limit($faq->jawaban, 100) }}</td>
                            <td class="py-3 px-4 border text-center">
                                @if($faq->role === 'pembeli')
                                    <span class="px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">Pembeli</span>
                                @elseif($faq->role === 'penjual')
                                    <span class="px-3 py-1 text-xs font-semibold text-purple-700 bg-purple-100 rounded-full">Penjual</span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">Semua</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 border text-center">
                                <a href="{{ route('admin.faq.edit', $faq->id) }}"
                                   class="inline-block px-3 py-1 text-sm bg-yellow-400 text-white rounded hover:bg-yellow-500 transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.faq.destroy', $faq->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus FAQ ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
