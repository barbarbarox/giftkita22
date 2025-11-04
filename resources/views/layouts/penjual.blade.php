<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Penjual | GiftKita')</title>
    @vite('resources/css/app.css')

    <style>
        /* Sidebar penuh dan fixed di layar besar */
        .sidebar {
            transition: transform 0.3s ease-in-out;
            height: 100vh;
        }
        .sidebar-hidden {
            transform: translateX(-100%);
        }
        /* Agar sidebar tidak ikut scroll */
        @media (min-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                transform: translateX(0) !important;
                overflow-y: auto;
            }
            main {
                margin-left: 16rem; /* lebar sidebar 64 */
            }
        }
    </style>
</head>
<body class="bg-gray-50 flex">

    {{-- SIDEBAR --}}
    <aside id="sidebar"
        class="sidebar fixed md:relative w-64 bg-gradient-to-b from-[#007daf] via-[#c771d4] to-[#ffb829] text-white flex flex-col z-50 sidebar-hidden md:sidebar-visible">

        <div class="p-6 font-bold text-2xl border-b border-white/20 flex justify-between items-center">
            <span>GiftKita Seller</span>
            <button id="closeSidebar" class="md:hidden text-white hover:text-gray-200 text-2xl">&times;</button>
        </div>

        <nav class="flex-1 p-4 space-y-3 overflow-y-auto">
            <a href="{{ route('penjual.dashboard') }}" class="block py-2.5 px-4 rounded hover:bg-white/20">Dashboard</a>
            <a href="{{ route('penjual.profil') }}" class="block py-2.5 px-4 rounded hover:bg-white/20">Profil Penjual</a>
            <a href="{{ route('penjual.toko.index') }}" class="block py-2.5 px-4 rounded hover:bg-white/20">Profil Toko</a>
            <a href="{{ route('penjual.produk.index') }}" class="block py-2.5 px-4 rounded hover:bg-white/20">Produk</a>
            <a href="{{ route('penjual.pesanan.index') }}" class="block py-2.5 px-4 rounded hover:bg-white/20">Pesanan</a>
            <a href="{{ route('penjual.bantuan') }}" class="block py-2.5 px-4 rounded hover:bg-white/20">Bantuan</a>
        </nav>

        {{-- Tombol Logout lebih menonjol --}}
        <div class="p-4 border-t border-white/20">
            <a href="/logout"
               class="block text-center py-2 rounded-lg bg-white text-[#007daf] font-semibold hover:bg-[#f8fafc] shadow-lg transition duration-200">
                Logout
            </a>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-6 md:p-8 overflow-y-auto w-full">
        {{-- Tombol buka sidebar hanya untuk HP --}}
        <button id="openSidebar"
            class="md:hidden mb-4 bg-[#007daf] text-white px-4 py-2 rounded-lg shadow hover:bg-[#006b9a] transition">
            ☰ Menu
        </button>

        @yield('content')
    </main>

    {{-- SCRIPT --}}
    <script>
        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');

        openBtn?.addEventListener('click', () => sidebar.classList.remove('sidebar-hidden'));
        closeBtn?.addEventListener('click', () => sidebar.classList.add('sidebar-hidden'));

        document.addEventListener('click', (e) => {
            if (window.innerWidth < 768 && !sidebar.contains(e.target) && !openBtn.contains(e.target)) {
                sidebar.classList.add('sidebar-hidden');
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('sidebar-hidden');
            } else {
                sidebar.classList.add('sidebar-hidden');
            }
        });
    </script>

</body>
</html>
