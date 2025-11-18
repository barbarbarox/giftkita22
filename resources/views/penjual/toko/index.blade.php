@extends('layouts.penjual')

@section('title', 'Daftar Toko | GiftKita Seller')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Header Section --}}
    <div class="bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] rounded-2xl shadow-2xl p-6 sm:p-8 mb-8 animate-fade-in">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="text-white">
                <h1 class="text-3xl sm:text-4xl font-bold mb-2">🏪 Daftar Toko Anda</h1>
                <p class="text-white/90">Kelola semua toko Anda dengan mudah</p>
            </div>
            <a href="{{ route('penjual.toko.create') }}" 
               class="bg-white text-[#007daf] px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-2xl hover:scale-105 transform transition-all duration-300 flex items-center gap-2 group whitespace-nowrap">
                <span class="text-2xl group-hover:rotate-90 transition-transform duration-300">+</span>
                <span>Tambah Toko</span>
            </a>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg mb-6 shadow-md animate-slide-down flex items-center gap-3">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Empty State --}}
    @if($tokos->isEmpty())
        <div class="bg-gradient-to-br from-yellow-50 to-orange-50 border-2 border-yellow-200 rounded-2xl p-12 text-center animate-fade-in">
            <div class="text-8xl mb-6 animate-bounce">🏪</div>
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Toko</h3>
            <p class="text-gray-600 mb-6 max-w-md mx-auto">
                Mulai perjalanan bisnis Anda dengan membuat toko pertama Anda sekarang!
            </p>
            <a href="{{ route('penjual.toko.create') }}" 
               class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white rounded-xl font-semibold shadow-lg hover:shadow-2xl hover:scale-105 transform transition-all duration-300">
                <span class="text-2xl">+</span>
                <span>Buat Toko Pertama</span>
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
                            <p class="text-sm text-gray-500">Total Toko</p>
                            <p class="text-2xl font-bold text-[#007daf]">{{ $tokos->count() }}</p>
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
        <div id="gridView" class="grid grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach($tokos as $index => $toko)
                <div class="bg-white shadow-lg rounded-2xl overflow-hidden hover:shadow-2xl transform hover:scale-105 transition-all duration-300 border border-gray-100 animate-fade-in" 
                     style="animation-delay: {{ $index * 0.1 }}s">
                    {{-- Image Container --}}
                    <div class="relative overflow-hidden group aspect-square sm:aspect-auto sm:h-48">
                        @if($toko->foto_profil)
                            <img src="{{ asset($toko->foto_profil) }}" 
                                 alt="Foto Toko" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                <div class="text-center">
                                    <span class="text-4xl sm:text-6xl">🏪</span>
                                    <p class="text-gray-400 mt-2 text-xs sm:text-sm">Tidak ada foto</p>
                                </div>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>

                    {{-- Content --}}
                    <div class="p-3 sm:p-5">
                        <h2 class="text-base sm:text-xl font-bold text-[#007daf] mb-2 hover:text-[#c771d4] transition-colors duration-300">
                            {{ $toko->nama_toko }}
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4 line-clamp-2 min-h-[32px] sm:min-h-[40px]">
                            {{ $toko->deskripsi ?? 'Belum ada deskripsi.' }}
                        </p>

                        {{-- Info --}}
                        <div class="space-y-1 sm:space-y-2 mb-3 sm:mb-4">
                            <div class="flex items-start gap-1 sm:gap-2 text-xs sm:text-sm text-gray-700">
                                <span class="text-base sm:text-lg flex-shrink-0">📍</span>
                                <span class="line-clamp-1">{{ $toko->alamat_toko ?? 'Alamat belum diisi' }}</span>
                            </div>
                            <div class="flex items-center gap-1 sm:gap-2 text-xs sm:text-sm text-gray-700">
                                <span class="text-base sm:text-lg">📞</span>
                                <span class="truncate">{{ $toko->whatsapp ?? '-' }}</span>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex gap-2">
                            <a href="{{ route('penjual.toko.edit', $toko->uuid) }}" 
                               class="flex-1 px-2 sm:px-4 py-1.5 sm:py-2.5 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transform hover:scale-105 transition-all duration-200 text-center font-medium shadow-md hover:shadow-lg flex items-center justify-center gap-1 text-xs sm:text-sm">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span class="hidden sm:inline">Edit</span>
                            </a>

                            <form action="{{ route('penjual.toko.destroy', $toko->uuid) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus toko ini?')" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full px-2 sm:px-4 py-1.5 sm:py-2.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transform hover:scale-105 transition-all duration-200 font-medium shadow-md hover:shadow-lg flex items-center justify-center gap-1 text-xs sm:text-sm">
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
            @foreach($tokos as $index => $toko)
                <div class="bg-white shadow-lg rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-100 animate-fade-in" 
                     style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="flex flex-col sm:flex-row">
                        {{-- Image --}}
                        <div class="sm:w-64 flex-shrink-0 relative overflow-hidden group">
                            @if($toko->foto_profil)
                                <img src="{{ asset($toko->foto_profil) }}" 
                                     alt="Foto Toko" 
                                     class="w-full h-48 sm:h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-48 sm:h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <div class="text-center">
                                        <span class="text-6xl">🏪</span>
                                        <p class="text-gray-400 mt-2 text-sm">Tidak ada foto</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 p-6">
                            <div class="flex flex-col sm:flex-row justify-between gap-4">
                                <div class="flex-1">
                                    <h2 class="text-2xl font-bold text-[#007daf] mb-3 hover:text-[#c771d4] transition-colors duration-300">
                                        {{ $toko->nama_toko }}
                                    </h2>
                                    <p class="text-gray-600 mb-4 line-clamp-3">
                                        {{ $toko->deskripsi ?? 'Belum ada deskripsi.' }}
                                    </p>

                                    <div class="space-y-2">
                                        <div class="flex items-start gap-2 text-gray-700">
                                            <span class="text-xl flex-shrink-0">📍</span>
                                            <span>{{ $toko->alamat_toko ?? 'Alamat belum diisi' }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-gray-700">
                                            <span class="text-xl">📞</span>
                                            <span>{{ $toko->whatsapp ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="flex sm:flex-col gap-2 sm:w-32">
                                    <a href="{{ route('penjual.toko.edit', $toko->uuid) }}" 
                                       class="flex-1 sm:flex-none px-4 py-2.5 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transform hover:scale-105 transition-all duration-200 text-center font-medium shadow-md hover:shadow-lg flex items-center justify-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        <span>Edit</span>
                                    </a>

                                    <form action="{{ route('penjual.toko.destroy', $toko->uuid) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus toko ini?')" class="flex-1 sm:flex-none">
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
    0%, 100% {
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
        localStorage.setItem('tokoView', 'grid');
    } else {
        gridView.classList.add('hidden');
        listView.classList.remove('hidden');
        listBtn.classList.add('active-view');
        gridBtn.classList.remove('active-view');
        localStorage.setItem('tokoView', 'list');
    }
}

// Load saved view preference
document.addEventListener('DOMContentLoaded', function() {
    const savedView = localStorage.getItem('tokoView') || 'grid';
    setView(savedView);
});
</script>
@endsection