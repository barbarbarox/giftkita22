@extends('layouts.penjual')

@section('title', 'Bantuan & FAQ Penjual | GiftKita')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#007daf] via-[#c771d4] to-[#ffb829] py-12 px-4">
    <div class="max-w-5xl mx-auto">
        {{-- Header --}}
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-white drop-shadow-md animate-fade-down">
                🆘 Bantuan & FAQ Penjual
            </h1>
            <p class="text-white/90 mt-3 text-lg animate-fade-up">
                Temukan panduan dan jawaban atas pertanyaan umum untuk penjual di GiftKita
            </p>
        </div>

        {{-- Form Pencarian --}}
        <form method="GET" action="{{ route('penjual.bantuan') }}" class="flex flex-col md:flex-row gap-3 justify-center mb-10">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari pertanyaan atau panduan..."
                class="w-full md:w-2/3 px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#007daf] focus:outline-none shadow-sm transition-all duration-300 hover:shadow-md"
            >
            <button
                type="submit"
                class="bg-white text-[#007daf] font-semibold px-6 py-3 rounded-xl shadow hover:shadow-lg hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2"
            >
                <i class='bx bx-search'></i> Cari
            </button>
        </form>

        {{-- Daftar FAQ --}}
        <div class="space-y-4">
            @forelse ($faqs as $faq)
                <div x-data="{ open: false }"
                     class="bg-white/90 backdrop-blur-md rounded-2xl shadow-lg border border-gray-100 transition-all duration-300 hover:shadow-2xl hover:scale-[1.02] hover:border-[#007daf]/30 animate-fade-in group">
                    {{-- Pertanyaan --}}
                    <button @click="open = !open"
                            class="w-full flex justify-between items-center px-6 py-5 text-left font-semibold text-gray-800 focus:outline-none group-hover:text-[#007daf] transition-colors duration-300">
                        <span class="text-base md:text-lg flex items-center gap-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#007daf] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                            {{ $faq->pertanyaan }}
                        </span>
                        <i :class="open ? 'bx bx-chevron-up' : 'bx bx-chevron-down'"
                           class="text-2xl text-[#007daf] transition-all duration-300 group-hover:scale-125"></i>
                    </button>
                    
                    {{-- Jawaban dengan styling dari CKEditor --}}
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                         class="px-6 pb-6 text-gray-700 border-t border-gray-200">
                        <div class="faq-content prose prose-sm max-w-none mt-4">
                            {!! $faq->jawaban !!}
                        </div>
                        
                        @if($faq->role !== 'semua')
                            <div class="mt-4 pt-3 border-t border-gray-100 text-sm text-gray-500 italic flex items-center gap-1 animate-fade-in">
                                <i class='bx bx-user-circle text-base'></i>
                                <span>FAQ khusus untuk: {{ ucfirst($faq->role) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center bg-white/20 backdrop-blur-md rounded-2xl p-8 animate-fade-up hover:bg-white/25 transition-all duration-300">
                    <i class='bx bx-info-circle text-white text-6xl mb-4 animate-bounce-slow'></i>
                    <p class="text-white text-lg font-medium">Belum ada panduan atau FAQ yang tersedia untuk penjual.</p>
                    <p class="text-white/80 text-sm mt-2">Silakan hubungi admin untuk informasi lebih lanjut.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination jika ada --}}
        @if(method_exists($faqs, 'links'))
            <div class="mt-8">
                {{ $faqs->links() }}
            </div>
        @endif

        {{-- Contact Admin Section --}}
        <div class="mt-12 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 text-center transition-all duration-300 hover:bg-white/15 hover:border-white/30 hover:shadow-2xl">
            <h3 class="text-xl font-bold text-white mb-2">Masih butuh bantuan?</h3>
            <p class="text-white/80 mb-4">Tim support kami siap membantu Anda</p>
            <div class="flex flex-col md:flex-row gap-3 justify-center">
                <a href="https://wa.me/6281234567890" target="_blank"
                   class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2 group">
                    <i class='bx bxl-whatsapp text-xl group-hover:rotate-12 transition-transform duration-300'></i>
                    Hubungi via WhatsApp
                </a>
                <a href="mailto:support@giftkita.com"
                   class="bg-white hover:bg-gray-100 text-[#007daf] font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2 group">
                    <i class='bx bx-envelope text-xl group-hover:rotate-12 transition-transform duration-300'></i>
                    Email Support
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Script AlpineJS --}}
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

{{-- Styling untuk konten FAQ dari CKEditor --}}
<style>
/* ===================================
   FAQ CONTENT STYLING (Same as public FAQ)
   =================================== */

.faq-content {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.8;
    color: #374151;
}

/* Paragraphs */
.faq-content p {
    margin-bottom: 1rem;
    line-height: 1.75;
}

.faq-content p:last-child {
    margin-bottom: 0;
}

/* Headings */
.faq-content h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #007daf;
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e5e7eb;
}

.faq-content h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #007daf;
    margin-top: 1.25rem;
    margin-bottom: 0.75rem;
}

.faq-content h4 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin-top: 1rem;
    margin-bottom: 0.5rem;
}

/* Lists */
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
    color: #007daf;
    font-weight: 600;
}

/* Links */
.faq-content a {
    color: #007daf;
    text-decoration: underline;
    font-weight: 500;
    transition: color 0.2s;
}

.faq-content a:hover {
    color: #c771d4;
}

/* Images */
.faq-content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.75rem;
    margin: 1.5rem auto;
    display: block;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.faq-content figure {
    margin: 1.5rem 0;
}

.faq-content figcaption {
    text-align: center;
    font-size: 0.875rem;
    color: #6b7280;
    font-style: italic;
    margin-top: 0.5rem;
}

/* Tables */
.faq-content table {
    border-collapse: collapse;
    width: 100%;
    margin: 1.5rem 0;
    font-size: 0.875rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    border-radius: 0.5rem;
    overflow: hidden;
}

.faq-content th,
.faq-content td {
    border: 1px solid #e5e7eb;
    padding: 0.75rem 1rem;
    text-align: left;
}

.faq-content th {
    background: linear-gradient(135deg, #007daf 0%, #0096d9 100%);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.05em;
}

.faq-content td {
    background-color: white;
}

.faq-content tr:nth-child(even) td {
    background-color: #f9fafb;
}

.faq-content tr:hover td {
    background-color: #f3f4f6;
}

/* Blockquotes */
.faq-content blockquote {
    border-left: 4px solid #007daf;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #6b7280;
    background-color: #f9fafb;
    padding: 1rem;
    border-radius: 0.5rem;
}

.faq-content blockquote p {
    margin-bottom: 0;
}

/* Code blocks */
.faq-content code {
    background-color: #f3f4f6;
    color: #e11d48;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-size: 0.875em;
    font-family: 'Courier New', Courier, monospace;
}

.faq-content pre {
    background-color: #1f2937;
    color: #f9fafb;
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 1rem 0;
}

.faq-content pre code {
    background-color: transparent;
    color: inherit;
    padding: 0;
}

/* Strong & Emphasis */
.faq-content strong {
    font-weight: 700;
    color: #1f2937;
}

.faq-content em {
    font-style: italic;
}

.faq-content u {
    text-decoration: underline;
}

.faq-content s {
    text-decoration: line-through;
}

/* Horizontal Rule */
.faq-content hr {
    border: none;
    border-top: 2px solid #e5e7eb;
    margin: 2rem 0;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .faq-content {
        font-size: 0.9rem;
    }
    
    .faq-content h2 {
        font-size: 1.25rem;
    }
    
    .faq-content h3 {
        font-size: 1.125rem;
    }
    
    .faq-content table {
        font-size: 0.75rem;
    }
    
    .faq-content th,
    .faq-content td {
        padding: 0.5rem;
    }
}

/* ===================================
   PAGE ANIMATIONS
   =================================== */

@keyframes fade-in {
    from { 
        opacity: 0; 
        transform: translateY(10px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

.animate-fade-in { 
    animation: fade-in 0.5s ease-out; 
}

@keyframes fade-up {
    from { 
        opacity: 0; 
        transform: translateY(20px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

.animate-fade-up { 
    animation: fade-up 0.7s ease-out; 
}

@keyframes fade-down {
    from { 
        opacity: 0; 
        transform: translateY(-20px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

.animate-fade-down { 
    animation: fade-down 0.7s ease-out; 
}

/* ===================================
   ADDITIONAL HOVER ANIMATIONS
   =================================== */

/* Slow bounce for icons */
@keyframes bounce-slow {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.animate-bounce-slow {
    animation: bounce-slow 2s ease-in-out infinite;
}

/* Shimmer effect for hover */
@keyframes shimmer {
    0% {
        background-position: -200% center;
    }
    100% {
        background-position: 200% center;
    }
}

.group:hover .shimmer-effect {
    background: linear-gradient(
        90deg,
        transparent 0%,
        rgba(255, 255, 255, 0.3) 50%,
        transparent 100%
    );
    background-size: 200% 100%;
    animation: shimmer 1.5s ease-in-out;
}

/* Pulse animation for important elements */
@keyframes pulse-glow {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(0, 125, 175, 0.4);
    }
    50% {
        box-shadow: 0 0 20px 10px rgba(0, 125, 175, 0);
    }
}

.hover-pulse:hover {
    animation: pulse-glow 1.5s ease-in-out infinite;
}

/* Smooth scale and rotate for icons */
.icon-hover {
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.group:hover .icon-hover {
    transform: scale(1.2) rotate(5deg);
}

/* Gradient text animation */
@keyframes gradient-shift {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

.gradient-text {
    background: linear-gradient(
        90deg,
        #007daf,
        #c771d4,
        #ffb829,
        #007daf
    );
    background-size: 300% 100%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.gradient-text:hover {
    animation: gradient-shift 3s ease infinite;
}

/* Lift effect */
.lift-effect {
    transition: all 0.3s ease;
}

.lift-effect:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}
</style>
@endsection