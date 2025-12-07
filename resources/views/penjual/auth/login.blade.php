<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Penjual | GiftKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('images/GiftKita.png') }}">
    
    <!-- Google reCAPTCHA v2 -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="min-h-screen relative overflow-x-hidden">
    <!-- Animated Background -->
    <div class="fixed inset-0 -z-10">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-purple-600 to-pink-500"></div>
        <div class="absolute inset-0 opacity-30">
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
        </div>
    </div>

    <!-- Main Container - Scrollable -->
    <div class="min-h-screen flex items-center justify-center p-4 py-8 md:py-12">
        <div class="w-full max-w-5xl">
            <!-- Back Button -->
            <a href="/" class="inline-flex items-center gap-2 text-white mb-4 md:mb-6 hover:gap-3 transition-all duration-300 group">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="font-medium">Kembali ke Beranda</span>
            </a>

            <!-- Card Container -->
            <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden">
                <div class="grid md:grid-cols-2 gap-0">
                    <!-- Left Side - Illustration (Hidden on Mobile) -->
                    <div class="hidden md:flex bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 p-8 lg:p-12 items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 opacity-10">
                            <div class="floating-shape"></div>
                            <div class="floating-shape"></div>
                            <div class="floating-shape"></div>
                        </div>
                        <div class="relative z-10 text-white text-center">
                            <div class="w-24 h-24 lg:w-32 lg:h-32 mx-auto mb-6 relative">
                                <div class="absolute inset-0 bg-white/20 rounded-full animate-ping"></div>
                                <div class="relative bg-white/30 backdrop-blur-md rounded-full w-full h-full flex items-center justify-center">
                                    <i class="fas fa-gift text-4xl lg:text-6xl"></i>
                                </div>
                            </div>
                            <h2 class="text-2xl lg:text-3xl font-bold mb-4">Selamat Datang Kembali!</h2>
                            <p class="text-white/90 leading-relaxed mb-6 text-sm lg:text-base">
                                Masuk ke dashboard penjual untuk mengelola toko dan produk Anda
                            </p>
                            <div class="mt-8 space-y-3">
                                <div class="flex items-center gap-3 text-sm">
                                    <i class="fas fa-chart-line text-green-300"></i>
                                    <span>Pantau penjualan real-time</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm">
                                    <i class="fas fa-box text-green-300"></i>
                                    <span>Kelola produk dengan mudah</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm">
                                    <i class="fas fa-headset text-green-300"></i>
                                    <span>Dukungan pelanggan 24/7</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Form (Scrollable) -->
                    <div class="p-6 md:p-8 lg:p-12 flex flex-col justify-start max-h-[85vh] md:max-h-[90vh] overflow-y-auto custom-scrollbar">
                        <!-- Header -->
                        <div class="text-center mb-6 md:mb-8">
                            <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">
                                Login Penjual
                            </h1>
                            <p class="text-gray-600 text-sm md:text-base">Masuk ke GiftKita Seller</p>
                        </div>

                        {{-- ═══════════════════════════════════════════════════════════ --}}
                        {{-- 🚨 ALERT BAN - Popup Modal --}}
                        {{-- ═══════════════════════════════════════════════════════════ --}}
                        @if(session('ban_info') && session('ban_info')['banned'])
                            <div id="banModal" class="modal-overlay" style="display: flex;">
                                <div class="modal-content ban-modal">
                                    <div class="ban-icon">🚫</div>
                                    <h2>Akun Dinonaktifkan</h2>
                                    <div class="ban-message">
                                        <p><strong>Alasan:</strong></p>
                                        <p class="reason-text">{{ session('ban_info')['reason'] }}</p>
                                        
                                        @if(session('ban_info')['date'])
                                            <p class="ban-date">
                                                <small>Dinonaktifkan pada: {{ session('ban_info')['date'] }}</small>
                                            </p>
                                        @endif
                                    </div>
                                    
                                    <div class="ban-actions">
                                        <a href="https://wa.me/6289636926578?text=Halo%20admin%2C%20akun%20saya%20telah%20dinonaktifkan.%20Mohon%20bantuan." 
                                           class="btn btn-whatsapp" 
                                           target="_blank">
                                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                                            </svg>
                                            Hubungi Admin
                                        </a>
                                        <button onclick="closeBanModal()" class="btn btn-secondary">
                                            Kembali ke Beranda
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- ═══════════════════════════════════════════════════════════ --}}
                        {{-- ⚠️ ERROR MESSAGES - Static Alert --}}
                        {{-- ═══════════════════════════════════════════════════════════ --}}
                        @if($errors->has('account_banned'))
                            <div class="mb-4 p-3 md:p-4 bg-red-50 border-l-4 border-red-500 rounded-lg animate-fade-in">
                                <div class="flex items-start gap-2 md:gap-3">
                                    <i class="fas fa-ban text-red-600 text-lg md:text-xl mt-0.5"></i>
                                    <div class="flex-1 min-w-0">
                                        <strong class="text-red-800 text-sm md:text-base">{{ $errors->first('account_banned') }}</strong>
                                        <p class="text-red-700 text-xs md:text-sm mt-1">Jika Anda merasa ini adalah kesalahan, silakan hubungi admin.</p>
                                        <a href="https://wa.me/6289636926578?text=Halo%20admin%2C%20akun%20saya%20telah%20dinonaktifkan.%20Mohon%20bantuan." 
                                           class="text-red-600 hover:text-red-800 underline text-xs md:text-sm mt-2 inline-block" 
                                           target="_blank">
                                            📞 Hubungi Admin via WhatsApp
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($errors->has('status'))
                            <div class="mb-4 p-3 md:p-4 bg-red-50 border-l-4 border-red-500 rounded-lg animate-fade-in">
                                <div class="flex items-start gap-2 md:gap-3">
                                    <i class="fas fa-ban text-red-600 text-lg md:text-xl mt-0.5"></i>
                                    <div class="flex-1 min-w-0">
                                        <strong class="text-red-800 text-sm md:text-base">{{ $errors->first('status') }}</strong>
                                        @if($errors->has('reason'))
                                            <p class="text-red-700 text-xs md:text-sm mt-1"><strong>Alasan:</strong> {{ $errors->first('reason') }}</p>
                                        @endif
                                        @if($errors->has('date'))
                                            <p class="text-red-600 text-xs mt-1">Dinonaktifkan pada: {{ $errors->first('date') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Success Notification -->
                        @if(session('success'))
                        <div class="mb-4 p-3 md:p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg animate-fade-in">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-check-circle mt-0.5"></i>
                                <span class="text-sm md:text-base">{{ session('success') }}</span>
                            </div>
                        </div>
                        @endif

                        <!-- Status Notification -->
                        @if(session('status') && !session('ban_info'))
                        <div class="mb-4 p-3 md:p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded-lg animate-fade-in">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-info-circle mt-0.5"></i>
                                <span class="text-sm md:text-base">{{ session('status') }}</span>
                            </div>
                        </div>
                        @endif

                        <!-- Error Notification -->
                        @if(session('error'))
                        <div class="mb-4 p-3 md:p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg animate-fade-in">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-exclamation-circle mt-0.5"></i>
                                <span class="text-sm md:text-base">{{ session('error') }}</span>
                            </div>
                        </div>
                        @endif

                        <!-- Ban Timer Warning -->
                        <div id="banWarning" class="mb-4 p-3 md:p-4 bg-red-50 border-l-4 border-red-500 rounded-lg hidden animate-fade-in">
                            <div class="flex items-start gap-2 md:gap-3">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-red-600 text-lg md:text-xl mt-0.5"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-red-800 mb-1 text-sm md:text-base">Akun Diblokir Sementara</h3>
                                    <p class="text-red-700 text-xs md:text-sm mb-3">
                                        Terlalu banyak percobaan login gagal. Form akan aktif kembali dalam:
                                    </p>
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3">
                                        <div class="bg-red-600 text-white px-3 md:px-4 py-2 rounded-lg font-mono text-base md:text-lg font-bold" id="countdownTimer">
                                            --:--
                                        </div>
                                        <div class="text-xs text-red-600">
                                            Percobaan: <span id="attemptCount" class="font-bold">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Login Failed Errors -->
                        @if($errors->any() && !$errors->has('account_banned') && !$errors->has('status'))
                        <div class="mb-4 p-3 md:p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg animate-fade-in">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-exclamation-circle text-lg md:text-xl mt-0.5"></i>
                                <div class="flex-1 min-w-0">
                                    @foreach($errors->all() as $error)
                                    <div class="mb-1 text-xs md:text-sm break-words">{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Form -->
                        <form action="{{ route('penjual.login.post') }}" method="POST" id="loginForm" class="space-y-4 md:space-y-5">
                            @csrf

                            <!-- Email -->
                            <div class="form-group">
                                <label class="block text-gray-700 font-semibold mb-2 text-sm md:text-base">
                                    <i class="fas fa-envelope text-blue-500 mr-2"></i>
                                    Email
                                </label>
                                <input type="email" name="email" id="emailInput" required value="{{ old('email') }}"
                                    class="w-full px-3 md:px-4 py-2.5 md:py-3 text-sm md:text-base border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-300 outline-none @error('email') border-red-500 @enderror"
                                    placeholder="email@example.com">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label class="block text-gray-700 font-semibold mb-2 text-sm md:text-base">
                                    <i class="fas fa-lock text-purple-500 mr-2"></i>
                                    Password
                                </label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" required
                                        class="w-full px-3 md:px-4 py-2.5 md:py-3 pr-12 text-sm md:text-base border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-300 outline-none @error('password') border-red-500 @enderror"
                                        placeholder="••••••••">
                                    <button type="button" id="togglePassword" class="absolute right-2 md:right-3 top-1/2 -translate-y-1/2 p-2 hover:bg-gray-100 rounded-lg transition-all duration-300">
                                        <div class="eye-container">
                                            <div class="eye">
                                                <div class="eyelid eyelid-top"></div>
                                                <div class="eyeball">
                                                    <div class="pupil"></div>
                                                </div>
                                                <div class="eyelid eyelid-bottom"></div>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="flex items-center justify-between text-xs md:text-sm">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" name="remember" id="rememberCheckbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                    <span class="text-gray-600 group-hover:text-gray-800 transition">Ingat Saya</span>
                                </label>
                            </div>

                            <!-- reCAPTCHA -->
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                                @error('g-recaptcha-response')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" id="submitBtn" class="w-full bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 text-white font-bold py-3 md:py-4 text-sm md:text-base rounded-xl hover:shadow-2xl hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 mt-4 md:mt-6">
                                <span class="flex items-center justify-center gap-2">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Masuk
                                </span>
                            </button>

                            <!-- Divider -->
                            <div class="flex items-center gap-4 my-4 md:my-6">
                                <div class="flex-1 h-px bg-gray-200"></div>
                                <span class="text-gray-400 text-xs md:text-sm">atau</span>
                                <div class="flex-1 h-px bg-gray-200"></div>
                            </div>

                            <!-- Google Login -->
                            <a href="{{ route('penjual.google.redirect') }}" id="googleBtn" class="w-full flex items-center justify-center gap-2 md:gap-3 bg-white border-2 border-gray-200 hover:border-gray-300 text-gray-700 font-semibold py-2.5 md:py-3 text-sm md:text-base rounded-xl hover:shadow-lg transition-all duration-300">
                                <svg class="w-5 h-5 md:w-6 md:h-6 flex-shrink-0" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                </svg>
                                <span class="truncate">Masuk dengan Google</span>
                            </a>

                            <!-- Register Link -->
                            <p class="text-center text-gray-600 text-xs md:text-sm mt-4 md:mt-6">
                                Belum punya akun?
                                <a href="{{ route('penjual.register') }}" class="text-purple-600 font-semibold hover:text-purple-700 hover:underline transition">
                                    Daftar sekarang
                                </a>
                            </p>
                        </form>

                        <!-- Footer -->
                        <p class="text-center text-gray-400 text-xs mt-6 md:mt-8">
                            © 2024 GiftKita — Seller Portal
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            padding: 1rem;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background: white;
            border-radius: 1.5rem;
            padding: 2rem;
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .ban-modal h2 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 1rem;
            text-align: center;
        }

        .ban-icon {
            font-size: 4rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        .ban-message {
            background: #fef2f2;
            padding: 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #dc2626;
        }

        .ban-message p {
            margin-bottom: 0.5rem;
            color: #991b1b;
        }

        .reason-text {
            font-size: 1.125rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .ban-date {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 1rem;
        }

        .ban-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            text-align: center;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-whatsapp {
            background: #25d366;
            color: white;
        }

        .btn-whatsapp:hover {
            background: #1fb757;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 211, 102, 0.3);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            border: none;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
            transform: translateY(-2px);
        }

        /* Animated Background Bubbles */
        .bubble {
            position: absolute;
            bottom: -100px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: rise 10s infinite ease-in;
        }

        .bubble:nth-child(1) { left: 10%; width: 80px; height: 80px; animation-delay: 0s; }
        .bubble:nth-child(2) { left: 30%; width: 60px; height: 60px; animation-delay: 2s; }
        .bubble:nth-child(3) { left: 50%; width: 100px; height: 100px; animation-delay: 4s; }
        .bubble:nth-child(4) { left: 70%; width: 70px; height: 70px; animation-delay: 6s; }
        .bubble:nth-child(5) { left: 90%; width: 90px; height: 90px; animation-delay: 8s; }

        @keyframes rise {
            0% { bottom: -100px; transform: translateX(0); }
            50% { transform: translateX(100px); }
            100% { bottom: 1080px; transform: translateX(-100px); }
        }

        /* Floating Shapes */
        .floating
        -shape {
position: absolute;
width: 100px;
height: 100px;
border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
background: rgba(255, 255, 255, 0.1);
animation: float 15s infinite ease-in-out;
}
    .floating-shape:nth-child(1) { top: 10%; left: 20%; animation-delay: 0s; }
    .floating-shape:nth-child(2) { top: 60%; right: 20%; animation-delay: 5s; }
    .floating-shape:nth-child(3) { bottom: 20%; left: 60%; animation-delay: 10s; }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        25% { transform: translate(20px, -20px) rotate(90deg); }
        50% { transform: translate(0, -40px) rotate(180deg); }
        75% { transform: translate(-20px, -20px) rotate(270deg); }
    }

    /* Fade In Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }

    /* Eye Animation */
    .eye-container { width: 20px; height: 20px; position: relative; }
    .eye { width: 100%; height: 100%; position: relative; display: flex; align-items: center; justify-content: center; }
    .eyeball { width: 18px; height: 18px; background: white; border-radius: 50%; border: 2px solid #374151; position: relative; z-index: 1; display: flex; align-items: center; justify-content: center; }
    .pupil { width: 7px; height: 7px; background: #1f2937; border-radius: 50%; transition: transform 0.3s ease; }
    .eyelid { position: absolute; width: 22px; background: #374151; left: 50%; transform: translateX(-50%); border-radius: 50%; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); z-index: 2; }
    .eyelid-top { height: 11px; top: 0; transform: translateX(-50%) translateY(-100%); }
    .eyelid-bottom { height: 11px; bottom: 0; transform: translateX(-50%) translateY(100%); }
    .eye.closed .eyelid-top { transform: translateX(-50%) translateY(5px); }
    .eye.closed .eyelid-bottom { transform: translateX(-50%) translateY(-5px); }

    /* Disabled Form */
    .form-disabled {
        opacity: 0.5;
        pointer-events: none;
        filter: grayscale(50%);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .eyeball { width: 16px; height: 16px; }
        .pupil { width: 6px; height: 6px; }
        .eyelid { width: 20px; }
        
        .modal-content {
            padding: 1.5rem;
            margin: 1rem;
        }
        
        .ban-icon {
            font-size: 3rem;
        }
        
        .ban-modal h2 {
            font-size: 1.25rem;
        }
    }

    @media (max-width: 640px) {
        .ban-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
    }
</style>

<script>
    console.log('🔍 Login Page Loaded');

    let countdownInterval, isBanned = false;
    const form = document.getElementById('loginForm');
    const banWarning = document.getElementById('banWarning');
    const countdownTimer = document.getElementById('countdownTimer');
    const attemptCount = document.getElementById('attemptCount');
    const emailInput = document.getElementById('emailInput');
    const passwordInput = document.getElementById('password');
    const submitBtn = document.getElementById('submitBtn');
    const googleBtn = document.getElementById('googleBtn');
    const rememberCheckbox = document.getElementById('rememberCheckbox');
    const togglePassword = document.getElementById('togglePassword');

    // Ban Modal Close Function
    window.closeBanModal = function() {
        const modal = document.getElementById('banModal');
        if (modal) {
            modal.style.display = 'none';
            window.location.href = '/';
        }
    }

    // Check ban from Laravel error
    @if($errors->has('email') && str_contains($errors->first('email'), 'Terlalu banyak'))
        const errorMsg = @json($errors->first('email'));
        const minutesMatch = errorMsg.match(/dalam (\d+) menit/);
        if (minutesMatch) {
            startBanCountdown(parseInt(minutesMatch[1]) * 60, 5);
        }
    @endif

    setTimeout(checkBanStatus, 500);
    setInterval(() => { if (!isBanned) checkBanStatus(); }, 5000);
    emailInput.addEventListener('input', () => {
        if (!isBanned && emailInput.value.includes('@')) checkBanStatus();
    });

    function checkBanStatus() {
        const email = emailInput.value;
        if (!email || !email.includes('@')) return;

        fetch('{{ route("penjual.check.ban") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ email })
        })
        .then(res => res.json())
        .then(data => {
            if (data.banned) {
                startBanCountdown(data.seconds, data.attempts);
            } else {
                clearBanCountdown();
                if (data.attempts > 0) attemptCount.textContent = data.attempts;
            }
        })
        .catch(err => console.error('❌ Error:', err));
    }

    function startBanCountdown(seconds, attempts) {
        if (isBanned) return;
        isBanned = true;
        banWarning.classList.remove('hidden');
        attemptCount.textContent = attempts || 0;
        disableForm();
        if (countdownInterval) clearInterval(countdownInterval);

        let remaining = seconds;
        updateTimerDisplay(remaining);
        countdownInterval = setInterval(() => {
            remaining--;
            if (remaining <= 0) {
                clearBanCountdown();
                setTimeout(checkBanStatus, 500);
            } else {
                updateTimerDisplay(remaining);
            }
        }, 1000);
    }

    function clearBanCountdown() {
        if (!isBanned) return;
        isBanned = false;
        banWarning.classList.add('hidden');
        if (countdownInterval) {
            clearInterval(countdownInterval);
            countdownInterval = null;
        }
        enableForm();
    }

    function updateTimerDisplay(seconds) {
        const m = Math.floor(seconds / 60);
        const s = seconds % 60;
        countdownTimer.textContent = `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
    }

    function disableForm() {
        form.classList.add('form-disabled');
        [emailInput, passwordInput, submitBtn, rememberCheckbox, togglePassword].forEach(el => el.disabled = true);
        googleBtn.style.pointerEvents = 'none';
        googleBtn.style.opacity = '0.5';
    }

    function enableForm() {
        form.classList.remove('form-disabled');
        [emailInput, passwordInput, submitBtn, rememberCheckbox, togglePassword].forEach(el => el.disabled = false);
        googleBtn.style.pointerEvents = '';
        googleBtn.style.opacity = '';
    }

    // Password visibility toggle
    const eye = togglePassword.querySelector('.eye');
    const pupil = togglePassword.querySelector('.pupil');
    
    togglePassword.addEventListener('click', () => {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        eye.classList.toggle('closed', !isPassword);
    });

    togglePassword.addEventListener('mousemove', (e) => {
        if (eye.classList.contains('closed')) return;
        const rect = togglePassword.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;
        const angle = Math.atan2(y, x);
        const distance = Math.min(Math.sqrt(x * x + y * y), 3);
        pupil.style.transform = `translate(${Math.cos(angle) * distance}px, ${Math.sin(angle) * distance}px)`;
    });

    togglePassword.addEventListener('mouseleave', () => {
        pupil.style.transform = 'translate(0, 0)';
    });

    // Close modal when clicking outside
    window.addEventListener('click', (e) => {
        const modal = document.getElementById('banModal');
        if (modal && e.target === modal) {
            closeBanModal();
        }
    });

    console.log('✅ Initialized');
</script>
</body>
</html>