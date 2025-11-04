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

    {{-- Navbar --}}
    <nav class="bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white shadow-lg fixed w-full top-0 left-0 z-40">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-4 sm:px-8 py-3">
            {{-- Logo --}}
            <div id="navbar-logo" class="flex items-center gap-2 transition-all duration-700 ease-in-out">
                <img src="{{ asset('images/GiftKita.png') }}" alt="GiftKita Logo" class="h-10 w-auto">
                <h1 class="font-bold text-xl tracking-wide">GiftKita</h1>
            </div>

            {{-- Tombol Sidebar --}}
            <button id="sidebar-toggle" class="focus:outline-none text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        {{-- Menu utama (selalu tampil bahkan di mobile) --}}
        <div class="flex justify-center bg-[#ffffff1a] backdrop-blur-sm border-t border-white/20 text-sm sm:text-base font-medium">
            <a href="/" class="py-3 px-4 hover:bg-white/20 transition">Beranda</a>
            <a href="/katalog" class="py-3 px-4 hover:bg-white/20 transition">Katalog</a>
            <a href="/toko" class="py-3 px-4 hover:bg-white/20 transition">Lihat Toko</a>
        </div>
    </nav>

    {{-- Sidebar --}}
    <aside id="sidebar" class="fixed top-0 right-0 w-64 h-full bg-white shadow-lg z-50 transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="flex justify-between items-center p-4 border-b">
            <h2 class="text-lg font-bold text-[#007daf]">Menu</h2>
            <button id="sidebar-close" class="text-gray-600 hover:text-[#007daf]">
                ✕
            </button>
        </div>

        <div class="p-4 space-y-3">
            <a href="/faq" class="block py-2 px-2 rounded hover:bg-gray-100">FAQ & Bantuan</a>
            <a href="/about" class="block py-2 px-2 rounded hover:bg-gray-100">Tentang Kami</a>
            <a href="/kebijakan-layanan" class="block py-2 px-2 rounded hover:bg-gray-100">Kebijakan Layanan</a>
            <a href="/kebijakan-privasi" class="block py-2 px-2 rounded hover:bg-gray-100">Kebijakan Privasi</a>
            <a href="/penjual/login" class="block py-2 px-2 rounded hover:bg-gray-100">Masuk sebagai Penjual</a>
        </div>
    </aside>

    {{-- Overlay sidebar --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 hidden z-40"></div>

    {{-- Splash Screen --}}
    <div id="splash-screen" class="fixed inset-0 flex flex-col items-center justify-center bg-white z-50">
        <img id="splash-logo" src="{{ asset('images/GiftKita.png') }}" alt="GiftKita Logo"
             class="w-32 h-32 opacity-0 animate-fade-in-up">
        <h1 id="splash-text" class="mt-4 text-3xl font-bold text-pink-600 opacity-0 animate-fade-in-up [animation-delay:0.3s]">
            GiftKita
        </h1>
    </div>

    {{-- Konten Dinamis --}}
    <main class="flex-1 pt-32 sm:pt-28">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gradient-to-r from-[#ffb829] via-[#c771d4] to-[#007daf] text-white text-center p-4 mt-12">
        <p class="text-sm">&copy; {{ date('Y') }} GiftKita — Semua hak cipta dilindungi.</p>
    </footer>

    {{-- Script Navbar, Sidebar & Splash --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const body = document.getElementById('body');
            const splash = document.getElementById('splash-screen');
            const splashLogo = document.getElementById('splash-logo');
            const splashText = document.getElementById('splash-text');
            const navbarLogo = document.getElementById('navbar-logo');

            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarClose = document.getElementById('sidebar-close');
            const overlay = document.getElementById('sidebar-overlay');

            // Sidebar toggle
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.remove('translate-x-full');
                overlay.classList.remove('hidden');
            });
            sidebarClose.addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);

            function closeSidebar() {
                sidebar.classList.add('translate-x-full');
                overlay.classList.add('hidden');
            }

            // Splash animation
            body.style.overflow = 'hidden';
            setTimeout(() => {
                const targetRect = navbarLogo.getBoundingClientRect();
                const rect = splashLogo.getBoundingClientRect();
                const dx = targetRect.left + targetRect.width / 2 - (rect.left + rect.width / 2);
                const dy = targetRect.top + targetRect.height / 2 - (rect.top + rect.height / 2);

                splashLogo.style.transition = 'transform 1s ease-in-out';
                splashText.style.transition = 'transform 1s ease-in-out, opacity 0.8s ease';
                splashLogo.style.transform = `translate(${dx}px, ${dy}px) scale(0.35)`;
                splashText.style.transform = `translate(${dx}px, ${dy - 10}px) scale(0.35)`;
                splashText.style.opacity = '0';

                setTimeout(() => {
                    splash.classList.add('opacity-0', 'transition-opacity', 'duration-700');
                    setTimeout(() => {
                        splash.remove();
                        body.style.overflow = 'auto';
                    }, 700);
                }, 1000);
            }, 2200);
        });
    </script>
</body>
</html>
