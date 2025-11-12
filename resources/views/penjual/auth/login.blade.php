@extends('layouts.app')

@section('title', 'Login Penjual | GiftKita')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-animated-gradient py-12 px-4">
    <div class="bg-white/95 backdrop-blur-md p-8 rounded-2xl shadow-2xl w-full max-w-md transition-all duration-300 hover:scale-[1.01]">
        {{-- Header --}}
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Login Penjual</h2>
            <p class="text-gray-500 text-sm mt-1">Masuk ke akun GiftKita Seller Anda</p>
        </div>

        {{-- Notifikasi --}}
        @if(session('status'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg p-3 mb-4 animate-fade-in">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-3 mb-4 animate-fade-in">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Form Login --}}
        <form action="{{ route('penjual.login.post') }}" method="POST" class="space-y-5">
            @csrf
            {{-- Email --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#007daf] focus:outline-none">
            </div>

            {{-- Password --}}
            <div class="relative">
                <label class="block text-gray-700 font-semibold mb-1">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 focus:ring-2 focus:ring-[#7f5fcf] focus:outline-none">
                <i id="togglePassword" class='bx bx-show absolute right-3 top-9 text-gray-500 text-xl cursor-pointer transition hover:text-[#7f5fcf]'></i>
            </div>

            {{-- Tombol Login --}}
            <button type="submit"
                    class="w-full bg-gradient-to-r from-[#007daf] to-[#7f5fcf] text-white py-2.5 rounded-lg font-semibold shadow-lg hover:shadow-xl hover:scale-[1.02] transition duration-200">
                Masuk
            </button>
        </form>

        {{-- Divider --}}
        <div class="flex items-center my-5">
            <div class="flex-grow h-px bg-gray-200"></div>
            <span class="px-3 text-gray-400 text-sm">atau</span>
            <div class="flex-grow h-px bg-gray-200"></div>
        </div>

        {{-- Tombol Login dengan Google --}}
        <a href="{{ route('penjual.google.redirect') }}"
           class="w-full flex items-center justify-center gap-2 bg-white border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg hover:bg-gray-50 shadow transition duration-200">
            <i class='bx bxl-google text-red-500 text-xl'></i> Masuk dengan Google
        </a>

        {{-- Tombol ke halaman register --}}
        <p class="text-center text-sm text-gray-600 mt-6">
            Belum punya akun?
            <a href="{{ route('penjual.register') }}"
               class="text-[#007daf] font-semibold hover:underline hover:text-[#7f5fcf] transition">Daftar sekarang</a>
        </p>

        <p class="text-center text-sm text-gray-500 mt-4">
            © {{ date('Y') }} GiftKita — Seller Portal
        </p>
    </div>
</div>

{{-- Script Toggle Password --}}
<script>
    const passwordInput = document.getElementById("password");
    const toggleIcon = document.getElementById("togglePassword");

    toggleIcon.addEventListener("click", () => {
        const isHidden = passwordInput.getAttribute("type") === "password";
        passwordInput.setAttribute("type", isHidden ? "text" : "password");
        toggleIcon.classList.toggle("bx-show");
        toggleIcon.classList.toggle("bx-hide");

        // Animasi kecil pada ikon
        toggleIcon.classList.add("scale-125");
        setTimeout(() => toggleIcon.classList.remove("scale-125"), 150);
    });
</script>

{{-- Animasi Background & Fade --}}
<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.4s ease-in-out;
    }

    /* 🌈 Animasi background lembut bergerak */
    @keyframes gradient-shift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .bg-animated-gradient {
        background: linear-gradient(-45deg, #007daf, #3498db, #7f5fcf, #ffb829);
        background-size: 300% 300%;
        animation: gradient-shift 8s ease infinite;
    }
</style>
@endsection
