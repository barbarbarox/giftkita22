@extends('admin.layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section with Animation -->
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-8 rounded-2xl shadow-2xl mb-6 transform hover:scale-[1.01] transition-all duration-300">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-white">
                <h2 class="text-3xl font-bold mb-2 animate-fade-in">📚 Manajemen Kategori</h2>
                <p class="text-blue-100 animate-fade-in-delay">Kelola kategori dengan mudah</p>
            </div>
            <a href="{{ route('admin.kategori.create') }}" 
               class="bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-2xl hover:scale-105 transform transition-all duration-300 flex items-center gap-2 group">
                <span class="text-2xl group-hover:rotate-90 transition-transform duration-300">+</span>
                <span>Tambah Kategori</span>
            </a>
        </div>
    </div>

    <!-- Success Alert with Animation -->
    @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg mb-6 shadow-md animate-slide-down flex items-center gap-3">
            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Table Container -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Mobile Card View -->
        <div class="block md:hidden">
            @forelse ($kategoris as $index => $kategori)
                <div class="border-b border-gray-200 p-4 hover:bg-gray-50 transition-colors duration-200 animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="bg-blue-500 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold">{{ $index + 1 }}</span>
                                <h3 class="font-bold text-gray-800 text-lg">{{ $kategori->nama_kategori }}</h3>
                            </div>
                            <p class="text-gray-600 text-sm">{{ $kategori->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.kategori.edit', $kategori->id) }}" 
                           class="flex-1 bg-yellow-400 text-white px-4 py-2 rounded-lg hover:bg-yellow-500 transform hover:scale-105 transition-all duration-200 text-center font-medium shadow-md">
                            ✏️ Edit
                        </a>
                        <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="w-full bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transform hover:scale-105 transition-all duration-200 font-medium shadow-md">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <div class="text-6xl mb-4 animate-bounce">📭</div>
                    <p class="text-gray-500 text-lg">Belum ada kategori yang tersedia</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="py-4 px-6 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">No</th>
                        <th class="py-4 px-6 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Nama Kategori</th>
                        <th class="py-4 px-6 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Deskripsi</th>
                        <th class="py-4 px-6 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($kategoris as $index => $kategori)
                        <tr class="hover:bg-blue-50 transition-colors duration-200 animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 text-white font-bold shadow-md">
                                    {{ $index + 1 }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-800">{{ $kategori->nama_kategori }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-gray-600">{{ $kategori->deskripsi ?? '-' }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.kategori.edit', $kategori->id) }}" 
                                       class="bg-yellow-400 text-white px-4 py-2 rounded-lg hover:bg-yellow-500 transform hover:scale-110 transition-all duration-200 font-medium shadow-md hover:shadow-lg inline-flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transform hover:scale-110 transition-all duration-200 font-medium shadow-md hover:shadow-lg inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center">
                                <div class="text-6xl mb-4 animate-bounce">📭</div>
                                <p class="text-gray-500 text-lg">Belum ada kategori yang tersedia</p>
                                <a href="{{ route('admin.kategori.create') }}" class="inline-block mt-4 text-blue-500 hover:text-blue-700 font-semibold">
                                    Tambah kategori pertama →
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $kategoris->links() }}
    </div>
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

@keyframes fade-in-delay {
    from {
        opacity: 0;
        transform: translateY(10px);
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

.animate-fade-in {
    animation: fade-in 0.6s ease-out forwards;
    opacity: 0;
}

.animate-fade-in-delay {
    animation: fade-in-delay 0.8s ease-out 0.3s forwards;
    opacity: 0;
}

.animate-slide-down {
    animation: slide-down 0.5s ease-out;
}

@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.animate-bounce {
    animation: bounce 2s infinite;
}

/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}
</style>
@endsection