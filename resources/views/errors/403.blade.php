<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-red-50 via-orange-50 to-yellow-50 min-h-screen flex items-center justify-center px-4">
    <div class="max-w-2xl w-full animate-fade-in">
        <!-- Icon & Status Code -->
        <div class="text-center mb-8">
            <div class="inline-block animate-float">
                <div class="bg-red-100 rounded-full p-6 mb-4">
                    <i class="fas fa-ban text-6xl text-red-500"></i>
                </div>
            </div>
            <h1 class="text-8xl font-bold text-red-600 mb-2">403</h1>
            <h2 class="text-3xl font-semibold text-gray-800 mb-4">Akses Ditolak</h2>
            <p class="text-gray-600 text-lg">
                @if(isset($exception) && $exception->getMessage())
                    {{ $exception->getMessage() }}
                @else
                    Anda tidak memiliki izin untuk mengakses halaman ini.
                @endif
            </p>
        </div>

        <!-- Info Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-6">
            <div class="space-y-4">
                <!-- Informasi Kontekstual -->
                @auth('admin')
                    <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-lg">
                        <i class="fas fa-info-circle text-blue-500 text-xl mt-1"></i>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Anda login sebagai Admin</h3>
                            <p class="text-sm text-gray-600">Halaman yang Anda coba akses mungkin khusus untuk penjual atau tidak tersedia.</p>
                        </div>
                    </div>
                @endauth

                @auth('penjual')
                    <div class="flex items-start gap-3 p-4 bg-green-50 rounded-lg">
                        <i class="fas fa-info-circle text-green-500 text-xl mt-1"></i>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Anda login sebagai Penjual</h3>
                            <p class="text-sm text-gray-600">Halaman yang Anda coba akses mungkin khusus untuk admin atau tidak tersedia.</p>
                        </div>
                    </div>
                @endauth

                @guest('admin')
                @guest('penjual')
                    <div class="flex items-start gap-3 p-4 bg-yellow-50 rounded-lg">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-xl mt-1"></i>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Anda belum login</h3>
                            <p class="text-sm text-gray-600">Halaman ini memerlukan autentikasi. Silakan login terlebih dahulu.</p>
                        </div>
                    </div>
                @endguest
                @endguest

                <!-- Kemungkinan Penyebab -->
                <div class="border-t pt-4">
                    <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-lightbulb text-yellow-500"></i>
                        Kemungkinan Penyebab:
                    </h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-circle text-xs text-red-400 mt-1.5"></i>
                            <span>Anda tidak memiliki hak akses ke halaman ini</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-circle text-xs text-red-400 mt-1.5"></i>
                            <span>Anda login dengan akun yang salah (admin/penjual)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-circle text-xs text-red-400 mt-1.5"></i>
                            <span>Sesi login Anda telah berakhir</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-circle text-xs text-red-400 mt-1.5"></i>
                            <span>Halaman yang Anda akses tidak tersedia</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <!-- Tombol Kembali -->
            <button onclick="window.history.back()" 
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </button>

            <!-- Tombol Beranda -->
            <a href="{{ route('home') }}" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-home"></i>
                Halaman Utama
            </a>

            <!-- Tombol Login (jika guest) -->
            @guest('admin')
            @guest('penjual')
                <a href="{{ route('penjual.login') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </a>
            @endguest
            @endguest

            <!-- Tombol Dashboard (jika authenticated) -->
            @auth('admin')
                <a href="{{ route('admin.dashboard') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard Admin
                </a>
            @endauth

            @auth('penjual')
                <a href="{{ route('penjual.dashboard') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard Penjual
                </a>
            @endauth
        </div>

        <!-- Footer Info -->
        <div class="text-center mt-8 text-sm text-gray-500">
            <p>Jika Anda yakin ini adalah kesalahan, silakan hubungi administrator.</p>
        </div>
    </div>

    <script>
        // Auto redirect jika ada parameter redirect
        const urlParams = new URLSearchParams(window.location.search);
        const redirectUrl = urlParams.get('redirect');
        
        if (redirectUrl) {
            setTimeout(() => {
                window.location.href = redirectUrl;
            }, 3000);
        }
    </script>
</body>
</html>