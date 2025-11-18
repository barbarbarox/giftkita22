@php
// Deteksi apakah pengguna saat ini login sebagai penjual
$isPenjual = Auth::guard('penjual')->check();
@endphp

@extends('layouts.app')

@section('title', 'FAQ | GiftKita')

@section('content')
<!-- Hero Section dengan Gradient Subtle -->
<div class="relative bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 overflow-hidden">
    <!-- Animated Background Shapes -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-200/30 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-purple-200/30 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-1/2 w-72 h-72 bg-pink-200/30 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        <!-- Header dengan Icon -->
        <div class="text-center mb-12 animate-fade-in-down">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl shadow-xl mb-6 transform hover:rotate-12 transition-all duration-300">
                <i class='bx bx-help-circle text-white text-4xl'>?</i>
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-4 tracking-tight">
                Pusat <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">Bantuan</span>
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Temukan jawaban untuk pertanyaan yang sering diajukan seputar GiftKita 🎁
            </p>
        </div>

        <!-- Search & Filter Box -->
        <div class="max-w-4xl mx-auto animate-fade-in-up">
            <form method="GET" action="{{ route('faq.index') }}" class="bg-white rounded-2xl shadow-2xl p-6 sm:p-8 border border-gray-100">
                <div class="flex flex-col lg:flex-row gap-4">
                    <!-- Search Input -->
                    <div class="flex-1 relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class='bx bx-search text-gray-400 text-xl group-focus-within:text-blue-500 transition-colors'></i>
                        </div>
                        <input
                            type="text"
                            name="q"
                            value="{{ $search ?? '' }}"
                            placeholder="Cari pertanyaan..."
                            class="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 outline-none text-gray-700 placeholder-gray-400">
                    </div>

                    <!-- Category Filter -->
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class='bx bx-filter text-gray-400 text-xl group-focus-within:text-purple-500 transition-colors'></i>
                        </div>
                        <select
                            name="role"
                            onchange="this.form.submit()"
                            class="w-full lg:w-56 pl-12 pr-10 py-4 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-300 outline-none text-gray-700 appearance-none cursor-pointer bg-white hover:bg-gray-50">
                            <option value="">Semua Kategori</option>
                            <option value="pembeli" {{ ($role ?? '') === 'pembeli' ? 'selected' : '' }}>👤 Pembeli</option>
                            <option value="penjual" {{ ($role ?? '') === 'penjual' ? 'selected' : '' }}>🏪 Penjual</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <i class='bx bx-chevron-down text-gray-400 text-xl'></i>
                        </div>
                    </div>

                    <!-- Search Button -->
                    <button
                        type="submit"
                        class="px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 active:scale-95 transition-all duration-300 flex items-center justify-center gap-2 group">
                        <i class='bx bx-search text-xl group-hover:rotate-90 transition-transform duration-300'></i>
                        <span class="hidden sm:inline">Cari</span>
                    </button>
                </div>

                <!-- Active Filters -->
                @if($search || $role)
                <div class="mt-4 flex flex-wrap gap-2 items-center">
                    <span class="text-sm text-gray-500">Filter aktif:</span>
                    @if($search)
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                        <i class='bx bx-search-alt text-xs'></i>
                        "{{ $search }}"
                        <a href="{{ route('faq.index', ['role' => $role]) }}" class="ml-1 hover:text-blue-900">
                            <i class='bx bx-x text-base'></i>
                        </a>
                    </span>
                    @endif
                    @if($role)
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm">
                        <i class='bx bx-category text-xs'></i>
                        {{ ucfirst($role) }}
                        <a href="{{ route('faq.index', ['q' => $search]) }}" class="ml-1 hover:text-purple-900">
                            <i class='bx bx-x text-base'></i>
                        </a>
                    </span>
                    @endif
                    <a href="{{ route('faq.index') }}" class="text-sm text-gray-500 hover:text-gray-700 underline ml-2">
                        Hapus semua
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>

<!-- FAQ Content Section -->
<div class="bg-white py-16 sm:py-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Results Info -->
        @if($faqs->count() > 0)
        <div class="mb-8 text-center animate-fade-in">
            <p class="text-gray-600">
                Menampilkan <span class="font-bold text-gray-900">{{ $faqs->count() }}</span> pertanyaan
                @if($search || $role)
                dari pencarian Anda
                @endif
            </p>
        </div>
        @endif

        <!-- FAQ Accordion -->
        <div class="space-y-4">
            @forelse ($faqs as $index => $faq)
            <div
                x-data="{ open: false }"
                class="group bg-white rounded-2xl shadow-md hover:shadow-2xl border-2 border-gray-100 hover:border-blue-200 transition-all duration-500 overflow-hidden animate-fade-in-up"
                style="animation-delay: {{ $index * 100 }}ms">
                <!-- Question Header -->
                <button
                    @click="open = !open"
                    class="w-full flex justify-between items-start gap-4 px-6 sm:px-8 py-6 text-left focus:outline-none">
                    <!-- Number Badge -->
                    <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </div>

                    <!-- Question Text -->
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300 leading-tight">
                            {{ $faq->pertanyaan }}
                        </h3>
                        @if($faq->role !== 'semua')
                        <div class="mt-2 inline-flex items-center gap-1.5 px-3 py-1 bg-gradient-to-r from-blue-50 to-purple-50 rounded-full text-xs font-medium text-gray-600">
                            <i class='bx {{ $faq->role === "pembeli" ? "bx-user" : "bx-store" }} text-sm'></i>
                            {{ ucfirst($faq->role) }}
                        </div>
                        @endif
                    </div>

                    <!-- Toggle Icon -->
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-xl bg-gray-100 group-hover:bg-blue-100 flex items-center justify-center transition-all duration-300">
                            <i
                                :class="open ? 'bx-chevron-up' : 'bx-chevron-down'"
                                class="bx text-2xl text-gray-600 group-hover:text-blue-600 transition-all duration-300"
                                :style="open ? 'transform: rotate(180deg)' : ''"></i>
                        </div>
                    </div>
                </button>

                <!-- Answer Content -->
                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 max-h-0"
                    x-transition:enter-end="opacity-100 max-h-screen"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 max-h-screen"
                    x-transition:leave-end="opacity-0 max-h-0"
                    class="overflow-hidden">
                    <div class="px-6 sm:px-8 pb-6 sm:pb-8 pt-2">
                        <!-- Divider -->
                        <div class="w-full h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent mb-6"></div>

                        <!-- Answer with Icon -->
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class='bx bx-check text-green-600 text-xl'></i>
                            </div>
                            <div class="flex-1 faq-content">
                                {!! $faq->jawaban !!}
                            </div>
                        </div>

                        <!-- Helpful Section -->
                        <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-sm text-gray-500">Apakah jawaban ini membantu?</span>
                            <div class="flex gap-2">
                                <button class="px-4 py-2 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg text-sm font-medium transition-all duration-300 flex items-center gap-1 group">
                                    <i class='bx bx-like group-hover:scale-125 transition-transform'></i>
                                    Ya
                                </button>
                                <button class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-sm font-medium transition-all duration-300 flex items-center gap-1 group">
                                    <i class='bx bx-dislike group-hover:scale-125 transition-transform'></i>
                                    Tidak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="text-center py-16 animate-fade-in">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full mb-6">
                    <i class='bx bx-search-alt text-gray-400 text-5xl animate-pulse'></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Tidak Ada Hasil</h3>
                <p class="text-gray-600 mb-6 max-w-md mx-auto">
                    @if($search || $role)
                    Maaf, tidak ada FAQ yang cocok dengan pencarian Anda. Coba kata kunci lain atau hubungi kami.
                    @else
                    Belum ada FAQ yang tersedia saat ini.
                    @endif
                </p>
                @if($search || $role)
                <a href="{{ route('faq.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                    <i class='bx bx-refresh'></i>
                    Lihat Semua FAQ
                </a>
                @endif
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(method_exists($faqs, 'links') && $faqs->hasPages())
        <div class="mt-12 animate-fade-in">
            <div class="flex justify-center">
                {{ $faqs->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
<div class="mt-6 text-center">
    <a href="{{ route('laporan.create') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transform hover:scale-105 hover:-translate-y-1 transition-all duration-300 group">
        <i class='bx bx-error-circle text-2xl group-hover:rotate-12 transition-transform'></i>
        <span>Laporkan Penjual Bermasalah</span>
        <i class='bx bx-right-arrow-alt text-xl group-hover:translate-x-1 transition-transform'></i>
    </a>
    <p class="mt-3 text-sm text-gray-500">
        Alami masalah dengan penjual? Laporkan kepada kami untuk ditindaklanjuti.
    </p>
</div>

<!-- Contact Support Banner -->
<div class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 py-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="animate-fade-in-up">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                Masih Butuh Bantuan?
            </h2>
            <p class="text-white/90 text-lg mb-8 max-w-2xl mx-auto">
                Tim support kami siap membantu Anda 24/7. Jangan ragu untuk menghubungi kami!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="mailto:support@giftkita.com" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 font-bold rounded-xl shadow-xl hover:shadow-2xl transform hover:scale-105 hover:-translate-y-1 transition-all duration-300 group">
                    <i class='bx bx-envelope text-2xl group-hover:rotate-12 transition-transform'></i>
                    <span>Email Support</span>
                </a>
                <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-2 px-8 py-4 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transform hover:scale-105 hover:-translate-y-1 transition-all duration-300 group">
                    <i class='bx bxl-whatsapp text-2xl group-hover:rotate-12 transition-transform'></i>
                    <span>WhatsApp</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- AlpineJS -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<style>
    /* ===================================
   CUSTOM ANIMATIONS
   =================================== */

    @keyframes fade-in-down {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fade-in {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes blob {

        0%,
        100% {
            transform: translate(0, 0) scale(1);
        }

        33% {
            transform: translate(30px, -50px) scale(1.1);
        }

        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }
    }

    .animate-fade-in-down {
        animation: fade-in-down 0.8s ease-out;
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out;
        animation-fill-mode: both;
    }

    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }

    .animate-blob {
        animation: blob 7s infinite;
    }

    .animation-delay-2000 {
        animation-delay: 2s;
    }

    .animation-delay-4000 {
        animation-delay: 4s;
    }

    /* ===================================
   FAQ CONTENT STYLING
   =================================== */

    .faq-content {
        font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
        line-height: 1.8;
        color: #374151;
    }

    .faq-content p {
        margin-bottom: 1rem;
        line-height: 1.75;
    }

    .faq-content p:last-child {
        margin-bottom: 0;
    }

    .faq-content h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    .faq-content h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #374151;
        margin-top: 1.25rem;
        margin-bottom: 0.75rem;
    }

    .faq-content ul {
        list-style-type: disc;
        margin-left: 1.5rem;
        margin-bottom: 1rem;
    }

    .faq-content ol {
        list-style-type: decimal;
        margin-left: 1.5rem;
        margin-bottom: 1rem;
    }

    .faq-content li {
        margin-bottom: 0.5rem;
        line-height: 1.75;
    }

    .faq-content li::marker {
        color: #3b82f6;
        font-weight: 600;
    }

    .faq-content a {
        color: #3b82f6;
        text-decoration: underline;
        font-weight: 500;
        transition: color 0.2s;
    }

    .faq-content a:hover {
        color: #9333ea;
    }

    .faq-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.75rem;
        margin: 1.5rem auto;
        display: block;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .faq-content strong {
        font-weight: 700;
        color: #1f2937;
    }

    .faq-content code {
        background-color: #f3f4f6;
        color: #e11d48;
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
        font-size: 0.875em;
        font-family: 'Courier New', monospace;
    }

    .faq-content blockquote {
        border-left: 4px solid #3b82f6;
        padding-left: 1rem;
        margin: 1.5rem 0;
        font-style: italic;
        color: #6b7280;
        background-color: #f9fafb;
        padding: 1rem;
        border-radius: 0.5rem;
    }

    /* ===================================
   RESPONSIVE ADJUSTMENTS
   =================================== */

    @media (max-width: 640px) {
        .faq-content {
            font-size: 0.9rem;
        }

        .faq-content h2 {
            font-size: 1.25rem;
        }

        .faq-content h3 {
            font-size: 1.125rem;
        }
    }

    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Selection color */
    ::selection {
        background-color: #3b82f6;
        color: white;
    }
</style>
@endsection