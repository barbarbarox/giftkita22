<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GiftKita')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('images/GiftKita.png') }}" type="image/png">
</head>

<body id="body" class="bg-white text-gray-800 flex flex-col min-h-screen overflow-x-hidden relative">
    {{-- Canvas untuk Click Spark Effect --}}
    <canvas id="sparkCanvas" class="fixed top-0 left-0 w-full h-full pointer-events-none z-[9999]"></canvas>

    {{-- Navbar --}}
    <nav class="bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white shadow-xl fixed w-full top-0 left-0 z-40 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto">
            {{-- Top Bar --}}
            <div class="flex justify-between items-center px-4 sm:px-8 py-3">
                {{-- Logo --}}
                <div id="navbar-logo" class="flex items-center gap-2 transition-all duration-700 ease-in-out">
                    <img src="{{ asset('images/GiftKita.png') }}" alt="GiftKita Logo" class="h-10 w-auto drop-shadow-lg">
                    <h1 class="font-bold text-xl tracking-wide drop-shadow-md">GiftKita</h1>
                </div>

                {{-- Tombol Menu Sidebar (Card Nav) --}}
                <button id="sidebar-toggle" class="focus:outline-none text-white hover:scale-110 transition-transform duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            {{-- Menu Utama --}}
            <div class="flex justify-center bg-white/10 backdrop-blur-md border-t border-white/20">
                <a href="/" class="nav-link py-3 px-6 text-sm sm:text-base font-medium hover:bg-white/20 transition-all duration-200 relative group">
                    <span class="relative z-10">Beranda</span>
                    <span class="nav-indicator"></span>
                </a>
                <a href="/katalog" class="nav-link py-3 px-6 text-sm sm:text-base font-medium hover:bg-white/20 transition-all duration-200 relative group">
                    <span class="relative z-10">Katalog</span>
                    <span class="nav-indicator"></span>
                </a>
                <a href="/toko" class="nav-link py-3 px-6 text-sm sm:text-base font-medium hover:bg-white/20 transition-all duration-200 relative group">
                    <span class="relative z-10">Lihat Toko</span>
                    <span class="nav-indicator"></span>
                </a>
            </div>
        </div>
    </nav>

    {{-- Card Navigation Sidebar --}}
    <div id="card-nav-sidebar" class="card-nav-sidebar">
        <div class="card-nav-wrapper">
            {{-- Close Button --}}
            <button id="sidebar-close" class="close-btn">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Header --}}
            <div class="sidebar-header">
                <img src="{{ asset('images/GiftKita.png') }}" alt="GiftKita" class="h-12 w-auto">
                <h2 class="text-2xl font-bold bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] bg-clip-text text-transparent">
                    Menu
                </h2>
            </div>

            {{-- Cards Grid --}}
            <div class="cards-grid">
                {{-- Card 1: Bantuan --}}
                <div class="nav-card bg-gradient-to-br from-blue-50 to-blue-100 hover:shadow-xl transition-all duration-300">
                    <div class="nav-card-icon bg-blue-500">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="nav-card-title text-blue-900">FAQ & Bantuan</h3>
                    <p class="nav-card-desc text-blue-700">Temukan jawaban dari pertanyaan umum</p>
                    <a href="/faq" class="nav-card-button bg-blue-500 hover:bg-blue-600">
                        Lihat FAQ
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                {{-- Card 2: Tentang Kami --}}
                <div class="nav-card bg-gradient-to-br from-purple-50 to-purple-100 hover:shadow-xl transition-all duration-300">
                    <div class="nav-card-icon bg-purple-500">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="nav-card-title text-purple-900">Tentang Kami</h3>
                    <p class="nav-card-desc text-purple-700">Kenali lebih jauh tentang GiftKita</p>
                    <a href="/about" class="nav-card-button bg-purple-500 hover:bg-purple-600">
                        Pelajari Lebih
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                {{-- Card 3: Kebijakan --}}
                <div class="nav-card bg-gradient-to-br from-orange-50 to-orange-100 hover:shadow-xl transition-all duration-300">
                    <div class="nav-card-icon bg-orange-500">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="nav-card-title text-orange-900">Kebijakan Layanan</h3>
                    <p class="nav-card-desc text-orange-700">Baca syarat dan ketentuan layanan</p>
                    <a href="/kebijakan-layanan" class="nav-card-button bg-orange-500 hover:bg-orange-600">
                        Baca Kebijakan
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                {{-- Card 4: Login Penjual --}}
                <div class="nav-card bg-gradient-to-br from-pink-50 to-pink-100 hover:shadow-xl transition-all duration-300">
                    <div class="nav-card-icon bg-pink-500">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                    </div>
                    <h3 class="nav-card-title text-pink-900">Portal Penjual</h3>
                    <p class="nav-card-desc text-pink-700">Masuk sebagai penjual untuk mengelola toko</p>
                    <a href="/penjual/login" class="nav-card-button bg-pink-500 hover:bg-pink-600">
                        Masuk Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Overlay Sidebar --}}
    <div id="sidebar-overlay" class="sidebar-overlay"></div>

    {{-- Enhanced Splash Screen --}}
    <div id="splash-screen" class="splash-screen">
        <div class="splash-content">
            <div class="splash-logo-wrapper">
                <img id="splash-logo" src="{{ asset('images/GiftKita.png') }}" alt="GiftKita Logo" class="splash-logo">
                <div class="splash-glow"></div>
                <div class="splash-ring"></div>
                <div class="splash-ring-2"></div>
            </div>
            <h1 id="splash-text" class="splash-text">
                <span class="letter" style="--i:0">G</span>
                <span class="letter" style="--i:1">i</span>
                <span class="letter" style="--i:2">f</span>
                <span class="letter" style="--i:3">t</span>
                <span class="letter" style="--i:4">K</span>
                <span class="letter" style="--i:5">i</span>
                <span class="letter" style="--i:6">t</span>
                <span class="letter" style="--i:7">a</span>
            </h1>
            <div class="splash-tagline">Platform Hadiah Terpercaya</div>
            <div class="splash-particles">
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
            </div>
        </div>
    </div>

    {{-- Konten Dinamis --}}
    <main class="flex-1 pt-32 sm:pt-28">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white mt-12">
        <div class="max-w-7xl mx-auto px-6 py-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- Column 1: About --}}
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/GiftKita.png') }}" alt="GiftKita" class="h-12 w-auto drop-shadow-lg">
                        <h3 class="font-bold text-2xl drop-shadow-md">GiftKita</h3>
                    </div>
                    <p class="text-sm text-white/90 leading-relaxed">
                        Platform jual beli hadiah terlengkap dan terpercaya di Indonesia. Temukan hadiah sempurna untuk orang tersayang.
                    </p>
                </div>

                {{-- Column 2: Quick Links --}}
                <div>
                    <h4 class="font-semibold text-lg mb-4 border-b border-white/20 pb-2">Menu</h4>
                    <ul class="space-y-2 text-sm">
                        <li>
                            <a href="/" class="hover:text-white/80 transition-colors inline-flex items-center gap-2 group">
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                Beranda
                            </a>
                        </li>
                        <li>
                            <a href="/katalog" class="hover:text-white/80 transition-colors inline-flex items-center gap-2 group">
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                Katalog
                            </a>
                        </li>
                        <li>
                            <a href="/toko" class="hover:text-white/80 transition-colors inline-flex items-center gap-2 group">
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                Toko
                            </a>
                        </li>
                        <li>
                            <a href="/about" class="hover:text-white/80 transition-colors inline-flex items-center gap-2 group">
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                Tentang Kami
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Column 3: Support --}}
                <div>
                    <h4 class="font-semibold text-lg mb-4 border-b border-white/20 pb-2">Bantuan</h4>
                    <ul class="space-y-2 text-sm">
                        <li>
                            <a href="/faq" class="hover:text-white/80 transition-colors inline-flex items-center gap-2 group">
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                FAQ
                            </a>
                        </li>
                        <li>
                            <a href="/kebijakan-layanan" class="hover:text-white/80 transition-colors inline-flex items-center gap-2 group">
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                Kebijakan Layanan
                            </a>
                        </li>
                        <li>
                            <a href="/penjual/login" class="hover:text-white/80 transition-colors inline-flex items-center gap-2 group">
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                Portal Penjual
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Column 4: Contact --}}
                <div>
                    <h4 class="font-semibold text-lg mb-4 border-b border-white/20 pb-2">Kontak</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>giftkita@gmail.com</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>082249219360</span>
                        </li>
                    </ul>
                    
                    {{-- Social Media --}}
                    <div class="flex gap-3 mt-4">
                        <a href="#" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-all hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-all hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-all hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Copyright --}}
            <div class="border-t border-white/20 mt-8 pt-6 text-center">
                <p class="text-sm">&copy; {{ date('Y') }} GiftKita. Semua hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    <style>
        /* Nav Link Active Indicator */
        .nav-indicator {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 80%;
            height: 3px;
            background: white;
            border-radius: 2px 2px 0 0;
            transition: transform 0.3s ease;
        }

        .nav-link:hover .nav-indicator {
            transform: translateX(-50%) scaleX(1);
        }

        /* Card Navigation Sidebar Styles */
        .card-nav-sidebar {
            position: fixed;
            top: 0;
            right: -100%;
            width: 100%;
            max-width: 500px;
            height: 100vh;
            background: white;
            box-shadow: -5px 0 30px rgba(0, 0, 0, 0.2);
            z-index: 999;
            transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
        }

        .card-nav-sidebar.active {
            right: 0;
        }

        .card-nav-wrapper {
            padding: 2rem;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        .close-btn:hover {
            background: #e5e7eb;
            transform: rotate(90deg);
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .nav-card {
            padding: 1.5rem;
            border-radius: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .nav-card:hover {
            transform: translateY(-4px);
        }

        .nav-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .nav-card-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
        }

        .nav-card-desc {
            font-size: 0.875rem;
            line-height: 1.5;
            margin: 0;
        }

        .nav-card-button {
            margin-top: auto;
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.2s;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .nav-card-button:hover {
            transform: translateX(4px);
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 998;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Enhanced Splash Screen Styles */
        .splash-screen {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            z-index: 10000;
            transition: opacity 0.8s ease, visibility 0.8s ease;
        }

        .splash-screen.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .splash-content {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .splash-logo-wrapper {
            position: relative;
            width: 160px;
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .splash-logo {
            width: 140px;
            height: 140px;
            position: relative;
            z-index: 3;
            animation: logoFloat 3s ease-in-out infinite, logoRotate 4s ease-in-out infinite;
            filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.3));
        }

        .splash-glow {
            position: absolute;
            inset: -20px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.8) 0%, transparent 70%);
            animation: glowPulse 2s ease-in-out infinite;
            z-index: 1;
        }

        .splash-ring {
            position: absolute;
            inset: -10px;
            border: 3px solid rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: ringExpand 2s ease-out infinite;
            z-index: 2;
        }

        .splash-ring-2 {
            position: absolute;
            inset: -10px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: ringExpand 2s ease-out 0.5s infinite;
            z-index: 2;
        }

        .splash-text {
            font-size: 3.5rem;
            font-weight: 800;
            color: white;
            text-align: center;
            margin: 0;
            letter-spacing: 0.1em;
            display: flex;
            gap: 0.1em;
            filter: drop-shadow(0 4px 20px rgba(0, 0, 0, 0.3));
        }

        .splash-text .letter {
            display: inline-block;
            animation: letterBounce 0.6s ease-out forwards;
            animation-delay: calc(var(--i) * 0.1s);
            opacity: 0;
            transform: translateY(50px) rotate(-10deg);
        }

        .splash-tagline {
            margin-top: 1rem;
            font-size: 1.125rem;
            color: rgba(255, 255, 255, 0.9);
            text-align: center;
            animation: fadeInUp 1s ease-out 1s forwards;
            opacity: 0;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            font-weight: 300;
        }

        .splash-particles {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            opacity: 0;
            animation: particleFloat 3s ease-in-out infinite;
        }

        .particle:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .particle:nth-child(2) {
            top: 40%;
            left: 20%;
            animation-delay: 0.5s;
        }

        .particle:nth-child(3) {
            top: 60%;
            left: 80%;
            animation-delay: 1s;
        }

        .particle:nth-child(4) {
            top: 80%;
            left: 70%;
            animation-delay: 1.5s;
        }

        .particle:nth-child(5) {
            top: 30%;
            right: 15%;
            animation-delay: 0.3s;
        }

        .particle:nth-child(6) {
            top: 70%;
            right: 25%;
            animation-delay: 0.8s;
        }

        .particle:nth-child(7) {
            top: 50%;
            left: 5%;
            animation-delay: 1.2s;
        }

        .particle:nth-child(8) {
            top: 15%;
            right: 10%;
            animation-delay: 1.7s;
        }

        /* Animations */
        @keyframes logoFloat {
            0%, 100% {
                transform: translateY(0px) scale(1);
            }
            50% {
                transform: translateY(-15px) scale(1.05);
            }
        }

        @keyframes logoRotate {
            0%, 100% {
                transform: rotate(0deg);
            }
            25% {
                transform: rotate(-5deg);
            }
            75% {
                transform: rotate(5deg);
            }
        }

        @keyframes glowPulse {
            0%, 100% {
                opacity: 0.5;
                transform: scale(1);
            }
            50% {
                opacity: 1;
                transform: scale(1.1);
            }
        }

        @keyframes ringExpand {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }
            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        @keyframes letterBounce {
            0% {
                opacity: 0;
                transform: translateY(50px) rotate(-10deg);
            }
            60% {
                opacity: 1;
                transform: translateY(-10px) rotate(5deg);
            }
            80% {
                transform: translateY(5px) rotate(-2deg);
            }
            100% {
                opacity: 1;
                transform: translateY(0) rotate(0deg);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes particleFloat {
            0%, 100% {
                opacity: 0;
                transform: translateY(0) scale(0);
            }
            50% {
                opacity: 1;
                transform: translateY(-100px) scale(1);
            }
        }

        /* Responsive */
        @media (max-width: 640px) {
            .card-nav-sidebar {
                max-width: 100%;
            }

            .card-nav-wrapper {
                padding: 1.5rem;
            }

            .sidebar-header {
                margin-bottom: 1.5rem;
            }

            .nav-card {
                padding: 1.25rem;
            }

            .splash-logo {
                width: 100px;
                height: 100px;
            }

            .splash-logo-wrapper {
                width: 120px;
                height: 120px;
            }

            .splash-text {
                font-size: 2.5rem;
            }

            .splash-tagline {
                font-size: 0.875rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // ============ ENHANCED SPLASH SCREEN (Only on homepage first visit) ============
            const body = document.getElementById('body');
            const splash = document.getElementById('splash-screen');
            const splashLogo = document.getElementById('splash-logo');
            const navbarLogo = document.getElementById('navbar-logo');

            // Check if this is homepage (you can adjust the condition based on your routing)
            const isHomepage = window.location.pathname === '/' || window.location.pathname === '/';
            
            // Check if this is first visit to homepage
            const hasVisitedHomepage = sessionStorage.getItem('hasVisitedHomepage');

            if (isHomepage && !hasVisitedHomepage) {
                // First visit to homepage - show enhanced splash
                body.style.overflow = 'hidden';
                // Hide splash after animations complete
                setTimeout(() => {
                    // Fly logo to navbar
                    const targetRect = navbarLogo.getBoundingClientRect();
                    const rect = splashLogo.getBoundingClientRect();
                    const dx = targetRect.left + targetRect.width / 2 - (rect.left + rect.width / 2);
                    const dy = targetRect.top + targetRect.height / 2 - (rect.top + rect.height / 2);

                    splashLogo.style.transition = 'transform 1.2s cubic-bezier(0.68, -0.55, 0.265, 1.55), opacity 0.8s ease';
                    splashLogo.style.transform = `translate(${dx}px, ${dy}px) scale(0.25)`;
                    
                    // Fade out splash screen
                    setTimeout(() => {
                        splash.classList.add('hidden');
                        setTimeout(() => {
                            splash.remove();
                            body.style.overflow = 'auto';
                            sessionStorage.setItem('hasVisitedHomepage', 'true');
                        }, 800);
                    }, 1000);
                }, 3000); // Wait for all animations to play
            } else {
                // Not homepage or already visited - remove splash immediately
                splash.remove();
                body.style.overflow = 'auto';
            }

            // ============ CLICK SPARK EFFECT ============
            const canvas = document.getElementById('sparkCanvas');
            const ctx = canvas.getContext('2d');
            let sparks = [];

            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            const sparkConfig = {
                color: '#ff6b9d',
                size: 10,
                radius: 15,
                count: 8,
                duration: 400
            };

            document.addEventListener('click', (e) => {
                const now = performance.now();
                for (let i = 0; i < sparkConfig.count; i++) {
                    sparks.push({
                        x: e.clientX,
                        y: e.clientY,
                        angle: (2 * Math.PI * i) / sparkConfig.count,
                        startTime: now
                    });
                }
            });

            function animateSparks(timestamp) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                
                sparks = sparks.filter(spark => {
                    const elapsed = timestamp - spark.startTime;
                    if (elapsed >= sparkConfig.duration) return false;

                    const progress = elapsed / sparkConfig.duration;
                    const eased = progress * (2 - progress);
                    const distance = eased * sparkConfig.radius;
                    const lineLength = sparkConfig.size * (1 - eased);

                    const x1 = spark.x + distance * Math.cos(spark.angle);
                    const y1 = spark.y + distance * Math.sin(spark.angle);
                    const x2 = spark.x + (distance + lineLength) * Math.cos(spark.angle);
                    const y2 = spark.y + (distance + lineLength) * Math.sin(spark.angle);

                    ctx.strokeStyle = sparkConfig.color;
                    ctx.lineWidth = 2;
                    ctx.beginPath();
                    ctx.moveTo(x1, y1);
                    ctx.lineTo(x2, y2);
                    ctx.stroke();

                    return true;
                });

                requestAnimationFrame(animateSparks);
            }
            requestAnimationFrame(animateSparks);

            // ============ CARD NAVIGATION SIDEBAR ============
            const sidebar = document.getElementById('card-nav-sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarClose = document.getElementById('sidebar-close');
            const overlay = document.getElementById('sidebar-overlay');

            function openSidebar() {
                sidebar.classList.add('active');
                overlay.classList.add('active');
                body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                body.style.overflow = 'auto';
            }

            sidebarToggle.addEventListener('click', openSidebar);
            sidebarClose.addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);

            // Close on ESC key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && sidebar.classList.contains('active')) {
                    closeSidebar();
                }
            });

            // Prevent card clicks from closing sidebar
            sidebar.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        });
    </script>
</body>
</html>