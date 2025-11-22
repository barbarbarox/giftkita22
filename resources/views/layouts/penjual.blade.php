<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Penjual | GiftKita')</title>
    @vite('resources/css/app.css')
    <link rel="icon" type="image/png" href="{{ asset('images/GiftKita.png') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        /* ===== LOADING ANIMATION ===== */
        #loadingScreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #007daf 0%, #c771d4 50%, #ffb829 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        #loadingScreen.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .logo-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin-bottom: 30px;
        }

        .logo-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            animation: logoFloat 2s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .loading-text {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            animation: textPulse 1.5s ease-in-out infinite;
        }

        @keyframes textPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.05); }
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-top: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ===== CLICK SPARK EFFECT ===== */
        .spark {
            position: fixed;
            pointer-events: none;
            z-index: 9998;
        }

        .spark::before {
            content: '✨';
            position: absolute;
            font-size: 20px;
            animation: sparkFloat 0.8s ease-out forwards;
        }

        @keyframes sparkFloat {
            0% {
                transform: translate(0, 0) scale(0);
                opacity: 1;
            }
            100% {
                transform: translate(var(--x), var(--y)) scale(1);
                opacity: 0;
            }
        }

        /* ===== SIDEBAR STYLES ===== */
        .sidebar {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100vh;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-hidden {
            transform: translateX(-100%);
        }

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

        /* ===== SCROLLBAR CUSTOM ===== */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* ===== MENU ITEM STYLES ===== */
        .menu-item {
            position: relative;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .menu-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: white;
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .menu-item:hover::before {
            transform: scaleY(1);
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(8px);
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.25);
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .menu-item.active::before {
            transform: scaleY(1);
        }

        /* ===== LOGO HEADER ANIMATION ===== */
        .logo-header {
            position: relative;
            overflow: hidden;
        }

        .logo-header::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent,
                rgba(255, 255, 255, 0.1),
                transparent
            );
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        /* ===== BUTTON STYLES ===== */
        .btn-menu {
            position: relative;
            overflow: hidden;
        }

        .btn-menu::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-menu:hover::before {
            width: 300px;
            height: 300px;
        }

        /* ===== LOGOUT BUTTON ===== */
        .logout-btn {
            position: relative;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .logout-btn:active {
            transform: translateY(0);
        }

        /* ===== MOBILE MENU BUTTON ===== */
        .mobile-menu-btn {
            transition: all 0.3s ease;
        }

        .mobile-menu-btn:hover {
            transform: scale(1.05);
        }

        .mobile-menu-btn:active {
            transform: scale(0.95);
        }

        /* ===== BACKDROP OVERLAY ===== */
        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            z-index: 40;
        }

        .sidebar-backdrop.active {
            opacity: 1;
            visibility: visible;
        }

        /* ===== NOTIFICATION BADGE ===== */
        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #ff4444;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: bold;
            animation: badgePulse 2s ease-in-out infinite;
        }

        @keyframes badgePulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* ===== SMOOTH SCROLL ===== */
        html {
            scroll-behavior: smooth;
        }

        /* ===== FADE IN CONTENT ===== */
        main {
            animation: fadeInUp 0.6s ease-out;
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
    </style>
</head>
<body class="bg-gray-50 flex overflow-x-hidden">

    {{-- LOADING SCREEN --}}
    <div id="loadingScreen">
        <div class="logo-container">
            <img src="{{ asset('images/GiftKita.png') }}" alt="GiftKita Logo">
        </div>
        <div class="loading-text">GiftKita Seller</div>
        <div class="loading-spinner"></div>
    </div>

    {{-- BACKDROP OVERLAY FOR MOBILE --}}
    <div id="sidebarBackdrop" class="sidebar-backdrop md:hidden"></div>

    {{-- SIDEBAR --}}
    <aside id="sidebar"
        class="sidebar fixed md:relative w-64 bg-gradient-to-b from-[#007daf] via-[#c771d4] to-[#ffb829] text-white flex flex-col z-50 sidebar-hidden md:sidebar-visible">

        {{-- LOGO HEADER --}}
        <div class="logo-header p-6 font-bold text-2xl border-b border-white/20 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/GiftKita.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                <span>GiftKita Seller</span>
            </div>
            <button id="closeSidebar" class="md:hidden text-white hover:text-gray-200 text-3xl transition-transform hover:rotate-90">
                <i class='bx bx-x'></i>
            </button>
        </div>

        {{-- NAVIGATION MENU --}}
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <a href="{{ route('penjual.dashboard') }}" 
               class="menu-item flex items-center gap-3 py-3 px-4 rounded-lg {{ request()->routeIs('penjual.dashboard') ? 'active' : '' }}">
                <i class='bx bxs-dashboard text-xl'></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('penjual.profil') }}" 
               class="menu-item flex items-center gap-3 py-3 px-4 rounded-lg {{ request()->routeIs('penjual.profil') ? 'active' : '' }}">
                <i class='bx bxs-user-circle text-xl'></i>
                <span>Profil</span>
            </a>

            <a href="{{ route('penjual.toko.index') }}" 
               class="menu-item flex items-center gap-3 py-3 px-4 rounded-lg {{ request()->routeIs('penjual.toko.*') ? 'active' : '' }}">
                <i class='bx bxs-store text-xl'></i>
                <span>Toko Saya</span>
            </a>

            <a href="{{ route('penjual.produk.index') }}" 
               class="menu-item flex items-center gap-3 py-3 px-4 rounded-lg {{ request()->routeIs('penjual.produk.*') ? 'active' : '' }}">
                <i class='bx bxs-box text-xl'></i>
                <span>Produk</span>
            </a>

            <a href="{{ route('penjual.pesanan.index') }}" 
               class="menu-item relative flex items-center gap-3 py-3 px-4 rounded-lg {{ request()->routeIs('penjual.pesanan.*') ? 'active' : '' }}">
                <i class='bx bxs-shopping-bag text-xl'></i>
                <span>Pesanan</span>
                {{-- Optional: Notification Badge --}}
                {{-- <span class="notification-badge">5</span> --}}
            </a>

            <a href="{{ route('penjual.bantuan') }}" 
               class="menu-item flex items-center gap-3 py-3 px-4 rounded-lg {{ request()->routeIs('penjual.bantuan') ? 'active' : '' }}">
                <i class='bx bxs-help-circle text-xl'></i>
                <span>Bantuan & FAQ</span>
            </a>

            <a href="{{ route('penjual.statistik.index') }}" 
               class="menu-item flex items-center gap-3 py-3 px-4 rounded-lg {{ request()->routeIs('penjual.statistik') ? 'active' : '' }}">
                <i class='bx bxs-bar-chart-alt-2 text-xl'></i>
                <span>Statistik</span>
            </a>
        </nav>

        {{-- LOGOUT BUTTON --}}
        <div class="p-4 border-t border-white/20">
            <form action="{{ route('penjual.logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="logout-btn w-full flex items-center justify-center gap-2 py-3 rounded-lg bg-white text-[#007daf] font-semibold hover:bg-[#f8fafc] shadow-lg transition duration-200">
                    <i class='bx bx-log-out text-xl'></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-6 md:p-8 overflow-y-auto w-full min-h-screen">
        {{-- MOBILE MENU BUTTON --}}
        <button id="openSidebar"
            class="mobile-menu-btn md:hidden mb-6 bg-gradient-to-r from-[#007daf] to-[#c771d4] text-white px-5 py-3 rounded-xl shadow-lg hover:shadow-xl transition flex items-center gap-2 font-semibold">
            <i class='bx bx-menu text-2xl'></i>
            <span>Menu</span>
        </button>

        @yield('content')
    </main>

    {{-- SCRIPTS --}}
    <script>
        // ===== LOADING SCREEN =====
        window.addEventListener('load', function() {
            setTimeout(() => {
                document.getElementById('loadingScreen').classList.add('hidden');
            }, 1500); // 1.5 detik
        });

        // ===== CLICK SPARK EFFECT =====
        document.addEventListener('click', function(e) {
            createSpark(e.clientX, e.clientY);
        });

        function createSpark(x, y) {
            const sparkCount = 6;
            
            for (let i = 0; i < sparkCount; i++) {
                const spark = document.createElement('div');
                spark.className = 'spark';
                
                const angle = (Math.PI * 2 * i) / sparkCount;
                const velocity = 30 + Math.random() * 30;
                const tx = Math.cos(angle) * velocity;
                const ty = Math.sin(angle) * velocity;
                
                spark.style.left = x + 'px';
                spark.style.top = y + 'px';
                spark.style.setProperty('--x', tx + 'px');
                spark.style.setProperty('--y', ty + 'px');
                
                document.body.appendChild(spark);
                
                setTimeout(() => spark.remove(), 800);
            }
        }

        // ===== SIDEBAR TOGGLE =====
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');

        function openSidebar() {
            sidebar.classList.remove('sidebar-hidden');
            backdrop.classList.add('active');
        }

        function closeSidebar() {
            sidebar.classList.add('sidebar-hidden');
            backdrop.classList.remove('active');
        }

        openBtn?.addEventListener('click', openSidebar);
        closeBtn?.addEventListener('click', closeSidebar);
        backdrop?.addEventListener('click', closeSidebar);

        // Auto-close sidebar on mobile when clicking outside
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 768 && 
                !sidebar.contains(e.target) && 
                !openBtn.contains(e.target) &&
                !backdrop.contains(e.target)) {
                closeSidebar();
            }
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('sidebar-hidden');
                backdrop.classList.remove('active');
            } else {
                sidebar.classList.add('sidebar-hidden');
                backdrop.classList.remove('active');
            }
        });

        // ===== SMOOTH SCROLL TO TOP =====
        window.addEventListener('scroll', function() {
            const scrollBtn = document.getElementById('scrollToTop');
            if (scrollBtn) {
                if (window.pageYOffset > 300) {
                    scrollBtn.style.display = 'block';
                } else {
                    scrollBtn.style.display = 'none';
                }
            }
        });

        // ===== PREVENT LOADING SCREEN ON BACK BUTTON =====
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                document.getElementById('loadingScreen').classList.add('hidden');
            }
        });

        // ===== KEYBOARD SHORTCUTS =====
        document.addEventListener('keydown', function(e) {
            // ESC to close sidebar on mobile
            if (e.key === 'Escape' && window.innerWidth < 768) {
                closeSidebar();
            }
        });

        // ===== ADD RIPPLE EFFECT TO MENU ITEMS =====
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(255, 255, 255, 0.5);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple 0.6s ease-out;
                    pointer-events: none;
                `;
                
                this.appendChild(ripple);
                setTimeout(() => ripple.remove(), 600);
            });
        });

        // CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>

</body>
</html>