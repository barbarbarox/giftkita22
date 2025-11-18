<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Dinonaktifkan | GiftKita</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen flex items-center justify-center p-4">
    
    <div class="max-w-2xl w-full">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            
            <!-- Header with Icon -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 p-8 text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-white/20 rounded-full mb-4 animate-pulse">
                    <i class="fas fa-ban text-white text-5xl"></i>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                    Akun Dinonaktifkan
                </h1>
                <p class="text-red-100 text-lg">
                    Akses Anda ke GiftKita Seller telah dibatasi
                </p>
            </div>

            <!-- Content -->
            <div class="p-8 md:p-12">
                @php
                    $penjual = Auth::guard('penjual')->user();
                @endphp

                <!-- User Info -->
                <div class="bg-gray-50 rounded-xl p-6 mb-6 border-2 border-gray-200">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                            {{ strtoupper(substr($penjual->username, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">{{ $penjual->username }}</h2>
                            <p class="text-gray-600">{{ $penjual->email }}</p>
                        </div>
                    </div>

                    <!-- Deactivation Info -->
                    @if($penjual->deactivated_at)
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="fas fa-calendar-times w-5"></i>
                            <span>Dinonaktifkan pada:</span>
                            <span class="font-semibold">{{ $penjual->deactivated_at->format('d M Y, H:i') }} WIB</span>
                        </div>
                        
                        @if($penjual->deactivation_reason)
                        <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                            <p class="text-sm font-semibold text-red-800 mb-1">
                                <i class="fas fa-info-circle mr-2"></i>Alasan:
                            </p>
                            <p class="text-red-700">{{ $penjual->deactivation_reason }}</p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Message -->
                <div class="space-y-4 mb-8">
                    <div class="flex items-start gap-3 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mt-1"></i>
                        <div>
                            <h3 class="font-bold text-gray-800 mb-1">Akun Anda Tidak Aktif</h3>
                            <p class="text-gray-700 text-sm leading-relaxed">
                                Akun penjual Anda telah dinonaktifkan oleh administrator. 
                                Anda tidak dapat mengakses fitur-fitur penjual seperti dashboard, 
                                mengelola toko, produk, atau melihat pesanan.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-4 bg-blue-50 border-l-4 border-blue-400 rounded-lg">
                        <i class="fas fa-lightbulb text-blue-600 text-xl mt-1"></i>
                        <div>
                            <h3 class="font-bold text-gray-800 mb-1">Apa yang Bisa Dilakukan?</h3>
                            <ul class="text-gray-700 text-sm space-y-1 list-disc list-inside">
                                <li>Hubungi administrator untuk informasi lebih lanjut</li>
                                <li>Tanyakan alasan deaktivasi dan cara mengaktifkan kembali</li>
                                <li>Pastikan Anda memahami dan mematuhi kebijakan platform</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Contact Admin -->
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 mb-6">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-headset text-purple-600"></i>
                        Hubungi Administrator
                    </h3>
                    <div class="space-y-3">
                        <a href="mailto:admin@giftkita.com" 
                           class="flex items-center gap-3 p-3 bg-white rounded-lg hover:shadow-md transition-all">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-envelope text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Email</p>
                                <p class="font-semibold text-gray-800">admin@giftkita.com</p>
                            </div>
                        </a>
                        
                        <a href="https://wa.me/6281234567890" 
                           target="_blank"
                           class="flex items-center gap-3 p-3 bg-white rounded-lg hover:shadow-md transition-all">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fab fa-whatsapp text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">WhatsApp</p>
                                <p class="font-semibold text-gray-800">+62 812-3456-7890</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="/" 
                       class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-xl font-bold text-center hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-home"></i>
                        <span>Ke Beranda</span>
                    </a>
                    
                    <form method="POST" action="{{ route('penjual.logout') }}" class="flex-1">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-bold hover:bg-gray-300 transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="text-center mt-6 text-gray-600 text-sm">
            <p>© {{ date('Y') }} GiftKita. Semua hak dilindungi.</p>
        </div>
    </div>

    <style>
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .5;
            }
        }
        
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>

</body>
</html>