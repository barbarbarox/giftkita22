<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin | GiftKita')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Sidebar Transitions */
        .sidebar {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 50;
        }
        
        .sidebar-hidden {
            transform: translateX(-100%);
        }

        /* Desktop Sidebar */
        @media (min-width: 768px) {
            .sidebar {
                transform: translateX(0) !important;
            }
            main {
                margin-left: 18rem;
            }
        }

        /* Nav Item Animations */
        .nav-item {
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .nav-item::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 70%;
            width: 4px;
            background: white;
            border-radius: 0 4px 4px 0;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(4px);
        }

        .nav-item.active {
            background: rgba(255, 255, 255, 0.2);
            font-weight: 700;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .nav-item.active::before {
            opacity: 1;
        }

        /* Badge Animations */
        .badge {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .7;
            }
        }

        /* Ripple Effect */
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple-animation 0.6s ease-out;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Click Spark Canvas */
        #sparkCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            z-index: 9999;
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 40;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Smooth Scrollbar */
        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Loading Animation */
        .skeleton {
            animation: skeleton-loading 1s linear infinite alternate;
        }

        @keyframes skeleton-loading {
            0% {
                background-color: hsl(200, 20%, 80%);
            }
            100% {
                background-color: hsl(200, 20%, 95%);
            }
        }

        /* Header Animation */
        .header-slide {
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Alert Animation */
        .animate-slide-down {
            animation: alertSlide 0.5s ease-out;
        }

        @keyframes alertSlide {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body class="bg-gray-50 flex overflow-hidden">

    {{-- Click Spark Canvas --}}
    <canvas id="sparkCanvas"></canvas>

    {{-- Sidebar Overlay (Mobile) --}}
    <div id="sidebarOverlay" class="sidebar-overlay md:hidden"></div>

    {{-- SIDEBAR --}}
    <aside id="sidebar"
        class="sidebar w-72 bg-gradient-to-b from-indigo-600 via-purple-600 to-pink-600 text-white flex flex-col shadow-2xl sidebar-hidden md:sidebar-visible">

        {{-- Logo & Close Button --}}
        <div class="p-6 border-b border-white/20 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-gift text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="font-bold text-xl">GiftKita</h1>
                    <p class="text-xs opacity-75">Admin Panel</p>
                </div>
            </div>
            <button id="closeSidebar" class="md:hidden text-white hover:text-gray-200 text-2xl transition-transform hover:rotate-90">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Admin Info --}}
        <div class="p-6 bg-white/10 backdrop-blur-sm">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center font-bold text-lg shadow-lg">
                    {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1">
                    <p class="font-semibold">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</p>
                    <p class="text-xs opacity-75">{{ Auth::guard('admin')->user()->email ?? 'admin@giftkita.com' }}</p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" 
            class="nav-item flex items-center gap-3 py-3 px-4 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home w-5 text-center"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.penjual.index') }}" 
            class="nav-item flex items-center gap-3 py-3 px-4 rounded-xl {{ request()->routeIs('admin.penjual.*') ? 'active' : '' }}">
                <i class="fas fa-users w-5 text-center"></i>
                <span>Kelola Penjual</span>
                @php
                    $totalPenjual = \App\Models\Penjual::count();
                    $inactivePenjual = \App\Models\Penjual::where('status', 'inactive')->count();
                @endphp
                <div class="ml-auto flex items-center gap-1">
                    @if($totalPenjual > 0)
                    <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full font-bold">{{ $totalPenjual }}</span>
                    @endif
                    @if($inactivePenjual > 0)
                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold animate-pulse">{{ $inactivePenjual }}</span>
                    @endif
                </div>
            </a>

            {{-- MENU LAPORAN PENJUAL - BARU --}}
            <a href="{{ route('admin.laporan.index') }}" 
            class="nav-item flex items-center gap-3 py-3 px-4 rounded-xl {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                <i class="fas fa-flag w-5 text-center"></i>
                <span>Laporan</span>
                @php
                    $totalLaporan = \App\Models\LaporanPenjual::count();
                    $laporanPending = \App\Models\LaporanPenjual::where('status', 'pending')->count();
                @endphp
                <div class="ml-auto flex items-center gap-1">
                    @if($totalLaporan > 0)
                    <span class="bg-gray-500 text-white text-xs px-2 py-1 rounded-full font-bold">{{ $totalLaporan }}</span>
                    @endif
                    @if($laporanPending > 0)
                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold animate-pulse">{{ $laporanPending }}</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('admin.kategori.index') }}" 
            class="nav-item flex items-center gap-3 py-3 px-4 rounded-xl {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                <i class="fas fa-tags w-5 text-center"></i>
                <span>Kategori</span>
            </a>

            <a href="{{ route('admin.faq.index') }}" 
            class="nav-item flex items-center gap-3 py-3 px-4 rounded-xl {{ request()->routeIs('admin.faq.*') ? 'active' : '' }}">
                <i class="fas fa-question-circle w-5 text-center"></i>
                <span>FAQ</span>
            </a>
        </nav>

        {{-- Logout Button --}}
        <div class="p-4 border-t border-white/20">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                    class="w-full py-3 px-4 rounded-xl bg-white/20 hover:bg-white/30 backdrop-blur-sm font-semibold transition-all duration-300 flex items-center justify-center gap-2 hover:scale-105 hover:shadow-lg">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 overflow-y-auto h-screen">
        {{-- Header --}}
        <header class="header-slide bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
            <div class="px-4 md:px-8 py-4 flex items-center justify-between">
                {{-- Menu Button (Mobile) --}}
                <button id="openSidebar"
                    class="md:hidden bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-bars"></i>
                    <span>Menu</span>
                </button>

                {{-- Page Title --}}
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 hidden md:block">
                    @yield('page-title', 'Dashboard')
                </h2>

                {{-- Right Actions --}}
                <div class="flex items-center gap-3">
                    {{-- Notifications --}}
                    <button class="relative p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fas fa-bell text-gray-600 text-xl"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>

                    {{-- Quick Actions --}}
                    <button class="hidden md:flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg font-semibold hover:shadow-lg transition-all duration-300 hover:scale-105">
                        <i class="fas fa-plus"></i>
                        <span>Aksi Cepat</span>
                    </button>
                </div>
            </div>
        </header>

        {{-- Content Area --}}
        <div class="p-4 md:p-8">
            {{-- Success Alert --}}
            @if(session('success'))
            <div class="alert mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-md animate-slide-down">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-green-800">Berhasil!</p>
                        <p class="text-green-700 text-sm">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-green-500 hover:text-green-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            @endif

            {{-- Warning Alert --}}
            @if(session('warning'))
            <div class="alert mb-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg shadow-md animate-slide-down">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-yellow-800">Peringatan!</p>
                        <p class="text-yellow-700 text-sm">{{ session('warning') }}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-yellow-500 hover:text-yellow-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            @endif

            {{-- Error Alert --}}
            @if(session('error'))
            <div class="alert mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-md animate-slide-down">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-times-circle text-red-500 text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-red-800">Error!</p>
                        <p class="text-red-700 text-sm">{{ session('error') }}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            @endif

            {{-- Info Alert --}}
            @if(session('info'))
            <div class="alert mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg shadow-md animate-slide-down">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500 text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-blue-800">Informasi</p>
                        <p class="text-blue-700 text-sm">{{ session('info') }}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            @endif

            {{-- Validation Errors --}}
            @if($errors->any())
            <div class="alert mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-md animate-slide-down">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-red-800 mb-2">Terdapat kesalahan:</p>
                        <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- SCRIPTS --}}
    <script>
        // ========================================
        // Sidebar Toggle
        // ========================================
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');

        function openSidebar() {
            sidebar.classList.remove('sidebar-hidden');
            overlay.classList.add('active');
        }

        function closeSidebar() {
            sidebar.classList.add('sidebar-hidden');
            overlay.classList.remove('active');
        }

        openBtn?.addEventListener('click', openSidebar);
        closeBtn?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);

        // Auto close on resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('sidebar-hidden');
                overlay.classList.remove('active');
            } else {
                sidebar.classList.add('sidebar-hidden');
                overlay.classList.remove('active');
            }
        });

        // ========================================
        // Ripple Effect on Nav Items
        // ========================================
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                
                this.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            });
        });

        // ========================================
        // Click Spark Animation
        // ========================================
        const canvas = document.getElementById('sparkCanvas');
        const ctx = canvas.getContext('2d');
        
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });

        const sparks = [];
        const sparkConfig = {
            color: '#ffffff',
            size: 10,
            radius: 20,
            count: 8,
            duration: 500
        };

        class Spark {
            constructor(x, y, angle) {
                this.x = x;
                this.y = y;
                this.angle = angle;
                this.startTime = Date.now();
            }

            update() {
                const elapsed = Date.now() - this.startTime;
                if (elapsed >= sparkConfig.duration) return false;

                const progress = elapsed / sparkConfig.duration;
                const eased = this.easeOut(progress);
                
                this.distance = eased * sparkConfig.radius;
                this.lineLength = sparkConfig.size * (1 - eased);
                this.opacity = 1 - progress;

                return true;
            }

            draw() {
                const x1 = this.x + this.distance * Math.cos(this.angle);
                const y1 = this.y + this.distance * Math.sin(this.angle);
                const x2 = this.x + (this.distance + this.lineLength) * Math.cos(this.angle);
                const y2 = this.y + (this.distance + this.lineLength) * Math.sin(this.angle);

                ctx.strokeStyle = sparkConfig.color;
                ctx.globalAlpha = this.opacity;
                ctx.lineWidth = 2;
                ctx.beginPath();
                ctx.moveTo(x1, y1);
                ctx.lineTo(x2, y2);
                ctx.stroke();
            }

            easeOut(t) {
                return t * (2 - t);
            }
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            for (let i = sparks.length - 1; i >= 0; i--) {
                if (!sparks[i].update()) {
                    sparks.splice(i, 1);
                } else {
                    sparks[i].draw();
                }
            }
            
            requestAnimationFrame(animate);
        }

        animate();

        // Create sparks on click
        document.addEventListener('click', (e) => {
            // Only create sparks on clickable elements
            const target = e.target.closest('.nav-item, button, a');
            if (!target) return;

            const x = e.clientX;
            const y = e.clientY;

            // Determine spark color based on element
            if (target.closest('.sidebar')) {
                sparkConfig.color = '#ffffff';
            } else {
                sparkConfig.color = '#8b5cf6'; // Purple
            }

            for (let i = 0; i < sparkConfig.count; i++) {
                const angle = (2 * Math.PI * i) / sparkConfig.count;
                sparks.push(new Spark(x, y, angle));
            }
        });

        // ========================================
        // Smooth Scroll
        // ========================================
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // ========================================
        // Auto-hide notifications
        // ========================================
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>

</body>
</html>