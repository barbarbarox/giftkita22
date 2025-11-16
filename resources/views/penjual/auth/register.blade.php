<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penjual | GiftKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen relative overflow-hidden">
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

    <!-- Main Container -->
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-5xl">
            <!-- Back Button -->
            <a href="/penjual/login" class="inline-flex items-center gap-2 text-white mb-6 hover:gap-3 transition-all duration-300 group">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="font-medium">Kembali ke Login</span>
            </a>

            <!-- Card Container -->
            <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden">
                <div class="grid md:grid-cols-2 gap-0">
                    <!-- Left Side - Illustration -->
                    <div class="hidden md:flex bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 p-12 items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 opacity-10">
                            <div class="floating-shape"></div>
                            <div class="floating-shape"></div>
                            <div class="floating-shape"></div>
                        </div>
                        <div class="relative z-10 text-white text-center">
                            <div class="w-32 h-32 mx-auto mb-6 relative">
                                <div class="absolute inset-0 bg-white/20 rounded-full animate-ping"></div>
                                <div class="relative bg-white/30 backdrop-blur-md rounded-full w-full h-full flex items-center justify-center">
                                    <i class="fas fa-store text-6xl"></i>
                                </div>
                            </div>
                            <h2 class="text-3xl font-bold mb-4">Bergabung dengan GiftKita</h2>
                            <p class="text-white/90 leading-relaxed">
                                Mulai berjualan dan raih kesuksesan bersama ribuan penjual lainnya di platform terpercaya
                            </p>
                            <div class="mt-8 space-y-3">
                                <div class="flex items-center gap-3 text-sm">
                                    <i class="fas fa-check-circle text-green-300"></i>
                                    <span>Gratis biaya pendaftaran</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm">
                                    <i class="fas fa-check-circle text-green-300"></i>
                                    <span>Dashboard lengkap & mudah digunakan</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm">
                                    <i class="fas fa-check-circle text-green-300"></i>
                                    <span>Support 24/7</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Form -->
                    <div class="p-6 md:p-8 max-h-screen overflow-y-auto">
                        <!-- Header -->
                        <div class="text-center mb-6">
                            <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">
                                Buat Akun Penjual
                            </h1>
                            <p class="text-sm text-gray-600">Isi data di bawah untuk mendaftar</p>
                        </div>

                        <!-- Form -->
                        <form action="/penjual/register" method="POST" class="space-y-4">
                            <!-- Grid 2 Kolom -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Username -->
                                <div class="form-group">
                                    <label class="block text-gray-700 font-semibold mb-1.5 text-sm">
                                        <i class="fas fa-user text-blue-500 mr-1.5"></i>
                                        Nama Pengguna
                                    </label>
                                    <input type="text" name="username" required
                                        class="w-full px-3 py-2.5 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 outline-none text-sm"
                                        placeholder="Username">
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label class="block text-gray-700 font-semibold mb-1.5 text-sm">
                                        <i class="fas fa-envelope text-purple-500 mr-1.5"></i>
                                        Email
                                    </label>
                                    <input type="email" name="email" required
                                        class="w-full px-3 py-2.5 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all duration-300 outline-none text-sm"
                                        placeholder="email@example.com">
                                </div>

                                <!-- Phone -->
                                <div class="form-group">
                                    <label class="block text-gray-700 font-semibold mb-1.5 text-sm">
                                        <i class="fas fa-phone text-green-500 mr-1.5"></i>
                                        No. HP
                                    </label>
                                    <input type="tel" name="no_hp" required
                                        class="w-full px-3 py-2.5 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-300 outline-none text-sm"
                                        placeholder="08xxxxxxxxxx">
                                </div>

                                <!-- Password with Eye Animation -->
                                <div class="form-group">
                                    <label class="block text-gray-700 font-semibold mb-1.5 text-sm">
                                        <i class="fas fa-lock text-pink-500 mr-1.5"></i>
                                        Password
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="password" name="password" required
                                            class="w-full px-3 py-2.5 pr-10 border-2 border-gray-200 rounded-lg focus:border-pink-500 focus:ring-2 focus:ring-pink-500/20 transition-all duration-300 outline-none text-sm"
                                            placeholder="Min. 6 karakter">
                                        <button type="button" id="togglePassword" class="absolute right-2 top-1/2 -translate-y-1/2 p-1.5 hover:bg-gray-100 rounded-lg transition-all duration-300">
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
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group md:col-span-2">
                                    <label class="block text-gray-700 font-semibold mb-1.5 text-sm">
                                        <i class="fas fa-lock-open text-orange-500 mr-1.5"></i>
                                        Konfirmasi Password
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="password_confirmation" name="password_confirmation" required
                                            class="w-full px-3 py-2.5 pr-10 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-300 outline-none text-sm"
                                            placeholder="Ketik ulang password">
                                        <button type="button" id="togglePasswordConfirm" class="absolute right-2 top-1/2 -translate-y-1/2 p-1.5 hover:bg-gray-100 rounded-lg transition-all duration-300">
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
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 text-white font-bold py-3 rounded-lg hover:shadow-2xl hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 mt-4 text-sm">
                                <span class="flex items-center justify-center gap-2">
                                    <i class="fas fa-rocket"></i>
                                    Daftar Sekarang
                                </span>
                            </button>

                            <!-- Divider -->
                            <div class="flex items-center gap-4 my-4">
                                <div class="flex-1 h-px bg-gray-200"></div>
                                <span class="text-gray-400 text-xs">atau</span>
                                <div class="flex-1 h-px bg-gray-200"></div>
                            </div>

                            <!-- Google Login -->
                            <a href="/penjual/google/redirect" class="w-full flex items-center justify-center gap-3 bg-white border-2 border-gray-200 hover:border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg hover:shadow-lg transition-all duration-300 text-sm">
                                <svg class="w-5 h-5" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                                Lanjutkan dengan Google
                            </a>

                            <!-- Login Link -->
                            <p class="text-center text-gray-600 text-xs mt-4">
                                Sudah punya akun?
                                <a href="/penjual/login" class="text-purple-600 font-semibold hover:text-purple-700 hover:underline transition">
                                    Login di sini
                                </a>
                            </p>
                        </form>
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
        function setupPasswordToggle(inputId, toggleId) {
            const input = document.getElementById(inputId);
            const toggle = document.getElementById(toggleId);
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
        }

        // Initialize both password toggles
        setupPasswordToggle('password', 'togglePassword');
        setupPasswordToggle('password_confirmation', 'togglePasswordConfirm');

        // Mouse Follow Effect on Pupil
        document.querySelectorAll('.eye-container').forEach(container => {
            const pupil = container.querySelector('.pupil');
            
            container.addEventListener('mousemove', (e) => {
                const eye = container.querySelector('.eye');
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