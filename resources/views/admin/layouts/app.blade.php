<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin | GiftKita')</title>
    @vite('resources/css/app.css')

    <style>
        /* Transisi sidebar */
        .sidebar {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            height: 100vh;
        }
        .sidebar-hidden {
            transform: translateX(-100%);
        }

        /* Sidebar fix di layar besar */
        @media (min-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                transform: translateX(0) !important;
                overflow-y: auto;
            }
            main {
                margin-left: 16rem;
            }
        }

        /* Animasi hover nav item */
        .nav-item {
            position: relative;
            transition: all 0.3s ease;
        }
        .nav-item::before {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            height: 2px;
            width: 0;
            background: white;
            transition: width 0.3s ease;
        }
        .nav-item:hover::before {
            width: 100%;
        }
    </style>
</head>
<body class="bg-gray-50 flex">

    {{-- SIDEBAR --}}
    <aside id="sidebar"
        class="sidebar fixed md:relative w-64 bg-gradient-to-b from-indigo-700 via-purple-600 to-pink-500 text-white flex flex-col z-50 sidebar-hidden md:sidebar-visible shadow-lg">

        <div class="p-6 font-bold text-2xl border-b border-white/20 flex justify-between items-center">
            <span>GiftKita Admin</span>
            <button id="closeSidebar" class="md:hidden text-white hover:text-gray-200 text-2xl">&times;</button>
        </div>

        {{-- Navigasi --}}
        <nav class="flex-1 p-4 space-y-3 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="nav-item block py-2.5 px-4 rounded hover:bg-white/20">Dashboard</a>
            <a href="{{ route('admin.penjual.index') }}" class="nav-item block py-2.5 px-4 rounded hover:bg-white/20">Penjual</a>
            <a href="{{ route('admin.kategori.index') }}" class="nav-item block py-2.5 px-4 rounded hover:bg-white/20">Kategori</a>
            <a href="{{ route('admin.faq.index') }}" class="nav-item block py-2.5 px-4 rounded hover:bg-white/20">FAQ</a>
        </nav>

        {{-- Tombol Logout --}}
        <div class="p-4 border-t border-white/20">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button
                    class="w-full py-2 rounded-lg bg-white text-indigo-700 font-semibold hover:bg-gray-100 shadow-lg transition duration-200">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-6 md:p-8 overflow-y-auto w-full transition-all duration-300">
        {{-- Tombol buka sidebar hanya muncul di HP --}}
        <button id="openSidebar"
            class="md:hidden mb-4 bg-indigo-700 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-800 transition">
            ☰ Menu
        </button>

        {{-- Konten halaman --}}
        @yield('content')
    </main>

    {{-- SCRIPT --}}
    <script>
        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');

        // Buka sidebar
        openBtn?.addEventListener('click', () => sidebar.classList.remove('sidebar-hidden'));
        // Tutup sidebar
        closeBtn?.addEventListener('click', () => sidebar.classList.add('sidebar-hidden'));

        // Klik luar area sidebar -> tutup (untuk mobile)
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 768 && !sidebar.contains(e.target) && !openBtn.contains(e.target)) {
                sidebar.classList.add('sidebar-hidden');
            }
        });

        // Responsif otomatis
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
