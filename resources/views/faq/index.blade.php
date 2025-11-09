@php
    // Deteksi apakah pengguna saat ini login sebagai penjual
    $isPenjual = Auth::guard('penjual')->check();
@endphp

@extends('layouts.app')

@section('title', 'FAQ | GiftKita')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#007daf] via-[#c771d4] to-[#ffb829] py-12 px-4">
    <div class="max-w-5xl mx-auto">
        {{-- Header --}}
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-white drop-shadow-md animate-fade-down">
                Pertanyaan yang Sering Diajukan (FAQ)
            </h1>
            <p class="text-white/90 mt-3 text-lg animate-fade-up">
                Temukan jawaban atas pertanyaan umum seputar GiftKita
            </p>
        </div>

        {{-- Form Pencarian --}}
        <form method="GET" action="{{ route('faq.index') }}" class="flex flex-col md:flex-row gap-3 justify-center mb-8">
            <input
                type="text"
                name="q"
                value="{{ $search }}"
                placeholder="Cari pertanyaan..."
                class="w-full md:w-2/3 px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#007daf] focus:outline-none shadow-sm"
            >
            <select
                name="role"
                onchange="this.form.submit()"
                class="px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#c771d4] focus:outline-none shadow-sm"
            >
                <option value="">Semua Kategori</option>
                <option value="pembeli" {{ $role === 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                <option value="penjual" {{ $role === 'penjual' ? 'selected' : '' }}>Penjual</option>
            </select>
        </form>

        {{-- Daftar FAQ --}}
        <div class="space-y-4">
            @forelse ($faqs as $faq)
                <div x-data="{ open: false }"
                     class="bg-white/90 backdrop-blur-md rounded-2xl shadow-lg transition hover:shadow-2xl animate-fade-in">
                    <button @click="open = !open"
                            class="w-full flex justify-between items-center px-6 py-4 text-left font-semibold text-gray-800">
                        <span>{{ $faq->pertanyaan }}</span>
                        <i :class="open ? 'bx bx-chevron-up' : 'bx bx-chevron-down'"
                           class="text-2xl text-[#007daf] transition-all duration-300"></i>
                    </button>
                    <div x-show="open"
                         x-transition.duration.300ms
                         class="px-6 pb-5 text-gray-600 border-t border-gray-200">
                        {!! nl2br(e($faq->jawaban)) !!}
                        @if($faq->role !== 'semua')
                            <div class="mt-3 text-sm text-gray-400 italic">
                                <i class='bx bx-user'></i> FAQ untuk: {{ ucfirst($faq->role) }}
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-center text-white/90 text-lg">Belum ada FAQ yang tersedia.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Script AlpineJS --}}
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

{{-- Animasi --}}
<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fade-in 0.5s ease-out; }

    @keyframes fade-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up { animation: fade-up 0.7s ease-out; }

    @keyframes fade-down {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-down { animation: fade-down 0.7s ease-out; }
</style>
@endsection
