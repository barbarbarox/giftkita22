<!DOCTYPE html>
<!-- resources/views/admin/auth/login.blade.php -->
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin | GiftKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('images/GiftKita.png') }}">
    
    <!-- Google reCAPTCHA v2 -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="min-h-screen relative overflow-hidden">
    <!-- Animated Background -->
    <div class="fixed inset-0 -z-10">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600"></div>
        <div class="absolute inset-0 opacity-30">
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-4xl">
            <!-- Back Button -->
            <a href="/" class="inline-flex items-center gap-2 text-white mb-6 hover:gap-3 transition-all duration-300 group">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="font-medium">Kembali ke Beranda</span>
            </a>

            <!-- Card Container -->
            <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden">
                <div class="grid md:grid-cols-2 gap-0">
                    <!-- Left Side - Illustration -->
                    <div class="hidden md:flex bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 p-12 items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 opacity-10">
                            <div class="floating-shape"></div>
                            <div class="floating-shape"></div>
                            <div class="floating-shape"></div>
                        </div>
                        <div class="relative z-10 text-white text-center">
                            <div class="w-32 h-32 mx-auto mb-6 relative">
                                <div class="absolute inset-0 bg-white/20 rounded-full animate-ping"></div>
                                <div class="relative bg-white/30 backdrop-blur-md rounded-full w-full h-full flex items-center justify-center">
                                    <i class="fas fa-shield-halved text-6xl"></i>
                                </div>
                            </div>
                            <h2 class="text-3xl font-bold mb-4">Admin Panel</h2>
                            <p class="text-white/90 leading-relaxed mb-6">
                                Kelola platform GiftKita dengan dashboard admin yang powerful dan mudah digunakan
                            </p>
                            <div class="mt-8 space-y-3">
                                <div class="flex items-center gap-3 text-sm">
                                    <i class="fas fa-lock text-green-300"></i>
                                    <span>Akses aman & terenkripsi</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm">
                                    <i class="fas fa-chart-pie text-green-300"></i>
                                    <span>Dashboard analytics lengkap</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm">
                                    <i class="fas fa-cog text-green-300"></i>
                                    <span>Kontrol penuh sistem</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Form -->
                    <div class="p-8 md:p-12 flex flex-col justify-center">
                        <!-- Header -->
                        <div class="text-center mb-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full mb-4">
                                <i class="fas fa-user-shield text-2xl text-white"></i>
                            </div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-2">
                                Admin Login
                            </h1>
                            <p class="text-gray-600">Masuk ke GiftKita Admin Panel</p>
                        </div>

                        <!-- Success Alert -->
                        @if(session('success'))
                        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg animate-fade-in">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-check-circle mt-0.5"></i>
                                <div class="flex-1">
                                    <p class="font-semibold text-sm">Berhasil!</p>
                                    <p class="text-xs mt-1">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Status Alert -->
                        @if(session('status'))
                        <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded-lg animate-fade-in">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-info-circle mt-0.5"></i>
                                <div class="flex-1">
                                    <p class="text-sm">{{ session('status') }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Error Alert -->
                        @if($errors->any())
                        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg animate-fade-in">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-exclamation-circle mt-0.5"></i>
                                <div class="flex-1">
                                    <p class="font-semibold text-sm">Login Gagal</p>
                                    @foreach($errors->all() as $error)
                                        <p class="text-xs mt-1">{{ $error }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Form -->
                        <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
                            @csrf
                            
                            <!-- Email -->
                            <div class="form-group">
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-envelope text-indigo-500 mr-2"></i>
                                    Email Admin
                                </label>
                                <input type="email" name="email" required value="{{ old('email') }}"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 outline-none @error('email') border-red-500 @enderror"
                                    placeholder="admin@giftkita.com">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password with Eye Animation -->
                            <div class="form-group">
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-lock text-purple-500 mr-2"></i>
                                    Password
                                </label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" required
                                        class="w-full px-4 py-3 pr-12 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-300 outline-none @error('password') border-red-500 @enderror"
                                        placeholder="••••••••">
                                    <button type="button" id="togglePassword" class="absolute right-3 top-1/2 -translate-y-1/2 p-2 hover:bg-gray-100 rounded-lg transition-all duration-300">
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
                            <div class="flex items-center justify-between text-sm">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 focus:ring-2 cursor-pointer">
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
                            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white font-bold py-4 rounded-xl hover:shadow-2xl hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 mt-6">
                                <span class="flex items-center justify-center gap-2">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Masuk ke Admin Panel
                                </span>
                            </button>
                        </form>

                        <!-- Security Notice -->
                        <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-info-circle text-amber-600 mt-0.5"></i>
                                <div class="flex-1">
                                    <p class="text-xs text-amber-800">
                                        <strong>Keamanan:</strong> Halaman ini khusus untuk administrator. Jangan bagikan kredensial login Anda kepada siapapun.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <p class="text-center text-gray-400 text-xs mt-8">
                            © 2024 GiftKita — Admin Panel v1.0
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
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
        
        .bubble:nth-child(1) {
            left: 10%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
        }
        
        .bubble:nth-child(2) {
            left: 30%;
            width: 60px;
            height: 60px;
            animation-delay: 2s;
        }
        
        .bubble:nth-child(3) {
            left: 50%;
            width: 100px;
            height: 100px;
            animation-delay: 4s;
        }
        
        .bubble:nth-child(4) {
            left: 70%;
            width: 70px;
            height: 70px;
            animation-delay: 6s;
        }
        
        .bubble:nth-child(5) {
            left: 90%;
            width: 90px;
            height: 90px;
            animation-delay: 8s;
        }
        
        @keyframes rise {
            0% {
                bottom: -100px;
                transform: translateX(0);
            }
            50% {
                transform: translateX(100px);
            }
            100% {
                bottom: 1080px;
                transform: translateX(-100px);
            }
        }

        /* Floating Shapes */
        .floating-shape {
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 15s infinite ease-in-out;
        }
        
        .floating-shape:nth-child(1) {
            top: 10%;
            left: 20%;
            animation-delay: 0s;
        }
        
        .floating-shape:nth-child(2) {
            top: 60%;
            right: 20%;
            animation-delay: 5s;
        }
        
        .floating-shape:nth-child(3) {
            bottom: 20%;
            left: 60%;
            animation-delay: 10s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            25% {
                transform: translate(20px, -20px) rotate(90deg);
            }
            50% {
                transform: translate(0, -40px) rotate(180deg);
            }
            75% {
                transform: translate(-20px, -20px) rotate(270deg);
            }
        }

        /* Fade In Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        /* Eye Animation Styles */
        .eye-container {
            width: 24px;
            height: 24px;
            position: relative;
        }

        .eye {
            width: 100%;
            height: 100%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .eyeball {
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            border: 2px solid #374151;
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pupil {
            width: 8px;
            height: 8px;
            background: #1f2937;
            border-radius: 50%;
            transition: transform 0.3s ease;
        }

        .eyelid {
            position: absolute;
            width: 24px;
            background: #374151;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 50%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 2;
        }

        .eyelid-top {
            height: 12px;
            top: 0;
            transform: translateX(-50%) translateY(-100%);
        }

        .eyelid-bottom {
            height: 12px;
            bottom: 0;
            transform: translateX(-50%) translateY(100%);
        }

        /* Eye Closed State */
        .eye.closed .eyelid-top {
            transform: translateX(-50%) translateY(6px);
        }

        .eye.closed .eyelid-bottom {
            transform: translateX(-50%) translateY(-6px);
        }

        /* Form Input Focus Effects */
        .form-group input:focus {
            transform: scale(1.01);
        }

        /* Smooth Transitions */
        * {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>

    <script>
        // Toggle Password Visibility with Eye Animation
        const input = document.getElementById('password');
        const toggle = document.getElementById('togglePassword');
        const eye = toggle.querySelector('.eye');

        toggle.addEventListener('click', () => {
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            
            if (isPassword) {
                // Open eye
                eye.classList.add('closed');
            } else {
                // Close eye
                eye.classList.remove('closed');
            }
        });

        // Mouse Follow Effect on Pupil
        const container = document.querySelector('.eye-container');
        const pupil = container.querySelector('.pupil');
        
        container.addEventListener('mousemove', (e) => {
            if (eye.classList.contains('closed')) return;
            
            const rect = container.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            
            const angle = Math.atan2(y, x);
            const distance = Math.min(Math.sqrt(x * x + y * y), 4);
            
            const pupilX = Math.cos(angle) * distance;
            const pupilY = Math.sin(angle) * distance;
            
            pupil.style.transform = `translate(${pupilX}px, ${pupilY}px)`;
        });
        
        container.addEventListener('mouseleave', () => {
            pupil.style.transform = 'translate(0, 0)';
        });

        // Input Animation on Focus
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.01)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>