@extends('layouts.penjual')
<!-- penjual/produk/index.blade.php -->
@section('title', 'Daftar Produk | GiftKita Seller')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Header Section --}}
    <div class="bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] rounded-2xl shadow-2xl p-6 sm:p-8 mb-8 animate-fade-in">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="text-white">
                <h1 class="text-3xl sm:text-4xl font-bold mb-2">🎁 Daftar Produk</h1>
                <p class="text-white/90">Kelola semua produk Anda dengan mudah</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 w-full sm:w-auto">
                {{-- Tombol Import --}}
                <a href="{{ route('penjual.produk.import.form') }}"
                    class="bg-green-500 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-2xl hover:scale-105 transform transition-all duration-300 flex items-center justify-center gap-2 group whitespace-nowrap">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <span>Import Excel</span>
                </a>

                {{-- Tombol Tambah --}}
                <a href="{{ route('penjual.produk.create') }}"
                    class="bg-white text-[#007daf] px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-2xl hover:scale-105 transform transition-all duration-300 flex items-center justify-center gap-2 group whitespace-nowrap">
                    <span class="text-2xl group-hover:rotate-90 transition-transform duration-300">+</span>
                    <span>Tambah Produk</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg mb-6 shadow-md animate-slide-down flex items-center gap-3">
        <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Empty State --}}
    @if($produks->isEmpty())
    <div class="bg-gradient-to-br from-yellow-50 to-orange-50 border-2 border-yellow-200 rounded-2xl p-12 text-center animate-fade-in">
        <div class="text-8xl mb-6 animate-bounce">📦</div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Produk</h3>
        <p class="text-gray-600 mb-6 max-w-md mx-auto">
            Mulai berjualan dengan menambahkan produk pertama Anda sekarang!
        </p>
        <a href="{{ route('penjual.produk.create') }}"
            class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white rounded-xl font-semibold shadow-lg hover:shadow-2xl hover:scale-105 transform transition-all duration-300">
            <span class="text-2xl">+</span>
            <span>Tambah Produk Pertama</span>
        </a>
    </div>
    @else
    {{-- View Toggle & Stats --}}
    <div class="bg-white rounded-xl shadow-md p-4 mb-6 animate-fade-in">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            {{-- Stats --}}
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-3xl">📊</span>
                    <div>
                        <p class="text-sm text-gray-500">Total Produk</p>
                        <p class="text-2xl font-bold text-[#007daf]">{{ $produks->count() }}</p>
                    </div>
                </div>
            </div>

            {{-- View Toggle --}}
            <div class="flex items-center gap-2 bg-gray-100 rounded-lg p-1">
                <button onclick="setView('grid')"
                    id="gridBtn"
                    class="view-btn px-4 py-2 rounded-md transition-all duration-300 flex items-center gap-2 active-view">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span class="hidden sm:inline">Grid</span>
                </button>
                <button onclick="setView('list')"
                    id="listBtn"
                    class="view-btn px-4 py-2 rounded-md transition-all duration-300 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <span class="hidden sm:inline">List</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Grid View --}}
    <div id="gridView" class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
        @foreach($produks as $index => $produk)
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden hover:shadow-2xl transform hover:scale-105 transition-all duration-300 border border-gray-100 animate-fade-in flex flex-col"
            style="animation-delay: {{ $index * 0.1 }}s">
            {{-- Image/Video Container --}}
            @php
            $thumbnail = $produk->files->first();
            @endphp

            <div class="relative overflow-hidden group h-40 sm:h-48 bg-gray-100">
                @if($thumbnail)
                @php
                $path = 'storage/' . $thumbnail->filepath;
                $ext = strtolower(pathinfo($thumbnail->filepath, PATHINFO_EXTENSION));
                @endphp

                @if(in_array($ext, ['mp4', 'mov', 'webm', 'avi']))
                <video class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500" muted loop onmouseover="this.play()" onmouseout="this.pause()">
                    <source src="{{ asset($path) }}">
                </video>
                <div class="absolute top-2 right-2 bg-black/60 text-white px-2 py-1 rounded text-xs flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"></path>
                    </svg>
                    <span class="hidden sm:inline">Video</span>
                </div>
                @else
                <img src="{{ asset($path) }}"
                    alt="Foto Produk"
                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                @endif
                @else
                <div class="w-full h-full flex items-center justify-center">
                    <div class="text-center">
                        <span class="text-4xl sm:text-6xl">📦</span>
                        <p class="text-gray-400 mt-2 text-xs sm:text-sm">Tidak ada foto</p>
                    </div>
                </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>

            {{-- Content --}}
            <div class="p-3 sm:p-4 flex-1 flex flex-col">
                <div class="flex-1">
                    <h2 class="text-sm sm:text-lg font-bold text-[#007daf] mb-1 sm:mb-2 hover:text-[#c771d4] transition-colors duration-300 line-clamp-2 min-h-[2.5rem] sm:min-h-[3.5rem]">
                        {{ $produk->nama }}
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-600 mb-2 sm:mb-3 line-clamp-2 min-h-[2rem] sm:min-h-[2.5rem]">
                        {{ $produk->deskripsi ?? 'Belum ada deskripsi.' }}
                    </p>

                    {{-- Price & Category --}}
                    <div class="space-y-1 mb-3 sm:mb-4">
                        <div class="flex items-center gap-1 sm:gap-2">
                            <span class="text-base sm:text-lg">💰</span>
                            <span class="text-sm sm:text-lg font-bold text-green-600">Rp{{ number_format($produk->harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center gap-1 sm:gap-2 text-xs sm:text-sm text-gray-600">
                            <span>🏷️</span>
                            <span class="line-clamp-1">{{ $produk->kategori->nama_kategori ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex gap-2 mt-auto">
                    <a href="{{ route('penjual.produk.edit', $produk->id) }}"
                        class="flex-1 px-2 sm:px-3 py-1.5 sm:py-2 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transform hover:scale-105 transition-all duration-200 text-center font-medium shadow-md hover:shadow-lg flex items-center justify-center gap-1 text-xs sm:text-sm">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span class="hidden sm:inline">Edit</span>
                    </a>

                    <form action="{{ route('penjual.produk.destroy', $produk->id) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                        class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full px-2 sm:px-3 py-1.5 sm:py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transform hover:scale-105 transition-all duration-200 font-medium shadow-md hover:shadow-lg flex items-center justify-center gap-1 text-xs sm:text-sm">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span class="hidden sm:inline">Hapus</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- List View --}}
    <div id="listView" class="space-y-4 hidden">
        @foreach($produks as $index => $produk)
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-100 animate-fade-in"
            style="animation-delay: {{ $index * 0.1 }}s">
            <div class="flex flex-col sm:flex-row">
                {{-- Image/Video --}}
                @php
                $thumbnail = $produk->files->first();
                @endphp

                <div class="sm:w-80 flex-shrink-0 relative overflow-hidden group">
                    @if($thumbnail)
                    @php
                    $path = 'storage/' . $thumbnail->filepath;
                    $ext = strtolower(pathinfo($thumbnail->filepath, PATHINFO_EXTENSION));
                    @endphp

                    @if(in_array($ext, ['mp4', 'mov', 'webm', 'avi']))
                    <video class="w-full h-64 sm:h-full object-cover transform group-hover:scale-110 transition-transform duration-500" muted loop onmouseover="this.play()" onmouseout="this.pause()">
                        <source src="{{ asset($path) }}">
                    </video>
                    <div class="absolute top-4 right-4 bg-black/60 text-white px-3 py-2 rounded-lg text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"></path>
                        </svg>
                        Video
                    </div>
                    @else
                    <img src="{{ asset($path) }}"
                        alt="Foto Produk"
                        class="w-full h-64 sm:h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    @endif
                    @else
                    <div class="w-full h-64 sm:h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <div class="text-center">
                            <span class="text-6xl">📦</span>
                            <p class="text-gray-400 mt-2">Tidak ada foto</p>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="flex-1 p-6">
                    <div class="flex flex-col sm:flex-row justify-between gap-4 h-full">
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-[#007daf] mb-3 hover:text-[#c771d4] transition-colors duration-300">
                                {{ $produk->nama }}
                            </h2>
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ $produk->deskripsi ?? 'Belum ada deskripsi.' }}
                            </p>

                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-2xl">💰</span>
                                    <span class="text-2xl font-bold text-green-600">Rp{{ number_format($produk->harga, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-700">
                                    <span class="text-xl">🏷️</span>
                                    <span>{{ $produk->kategori->nama_kategori ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex sm:flex-col gap-2 sm:w-32">
                            <a href="{{ route('penjual.produk.edit', $produk->id) }}"
                                class="flex-1 sm:flex-none px-4 py-2.5 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transform hover:scale-105 transition-all duration-200 text-center font-medium shadow-md hover:shadow-lg flex items-center justify-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span>Edit</span>
                            </a>

                            <form action="{{ route('penjual.produk.destroy', $produk->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                                class="flex-1 sm:flex-none">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full px-4 py-2.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transform hover:scale-105 transition-all duration-200 font-medium shadow-md hover:shadow-lg flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slide-down {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.6s ease-out forwards;
        opacity: 0;
    }

    .animate-slide-down {
        animation: slide-down 0.5s ease-out;
    }

    .animate-bounce {
        animation: bounce 2s infinite;
    }

    .view-btn {
        color: #6b7280;
        font-weight: 500;
    }

    .view-btn.active-view {
        background: white;
        color: #007daf;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }

    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    html {
        scroll-behavior: smooth;
    }
</style>

<script>
    function setView(viewType) {
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');
        const gridBtn = document.getElementById('gridBtn');
        const listBtn = document.getElementById('listBtn');

        if (viewType === 'grid') {
            gridView.classList.remove('hidden');
            listView.classList.add('hidden');
            gridBtn.classList.add('active-view');
            listBtn.classList.remove('active-view');
            localStorage.setItem('produkView', 'grid');
        } else {
            gridView.classList.add('hidden');
            listView.classList.remove('hidden');
            listBtn.classList.add('active-view');
            gridBtn.classList.remove('active-view');
            localStorage.setItem('produkView', 'list');
        }
    }

    // Load saved view preference
    document.addEventListener('DOMContentLoaded', function() {
        const savedView = localStorage.getItem('produkView') || 'grid';
        setView(savedView);
    });
</script>
@endsection