@extends('layouts.app')

@section('title', 'Register Penjual | GiftKita')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-animated-gradient py-12 px-4">
    <div class="bg-white/95 backdrop-blur-md p-8 rounded-2xl shadow-2xl w-full max-w-3xl transition-all duration-300 hover:scale-[1.01]">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Daftar Sebagai Penjual</h2>

        {{-- Notifikasi --}}
        @if(session('status'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded-lg mb-4 animate-fade-in">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded-lg mb-4 animate-fade-in">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Form Register --}}
        <form action="{{ route('penjual.register.post') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Kolom Kanan --}}
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Nama Pengguna</label>
                        <input type="text" name="username" value="{{ old('username') }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#007daf] focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#007daf] focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">No. HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#007daf] focus:outline-none">
                    </div>
                </div>

                {{-- Kolom Kiri --}}
                <div class="space-y-4">
                    <div class="relative">
                        <label class="block text-gray-700 font-semibold mb-1">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 focus:ring-2 focus:ring-[#7f5fcf] focus:outline-none">
                        <i id="togglePassword" class='bx bx-show absolute right-3 top-9 text-gray-500 text-xl cursor-pointer transition hover:text-[#7f5fcf]'></i>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#7f5fcf] focus:outline-none">
                    </div>
                </div>
            </div>

            {{-- Tombol Register --}}
            <div class="mt-8">
                <button type="submit"
                    class="w-full bg-gradient-to-r from-[#007daf] to-[#7f5fcf] text-white font-semibold py-2.5 rounded-lg shadow-lg hover:shadow-xl hover:scale-[1.02] transition duration-200">
                    Daftar Sekarang
                </button>

                {{-- Divider --}}
                <div class="flex items-center my-5">
                    <div class="flex-grow h-px bg-gray-200"></div>
                    <span class="px-3 text-gray-400 text-sm">atau</span>
                    <div class="flex-grow h-px bg-gray-200"></div>
                </div>

                {{-- Tombol Login Google --}}
                <a href="{{ route('penjual.google.redirect') }}"
                   class="w-full flex items-center justify-center gap-2 bg-white border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg hover:bg-gray-50 shadow transition duration-200">
                    <i class='bx bxl-google text-red-500 text-xl'></i> Lanjutkan dengan Google
                </a>
            </div>

            <p class="text-center text-sm text-gray-600 mt-6">
                Sudah punya akun?
                <a href="{{ route('penjual.login') }}" class="text-[#007daf] font-semibold hover:underline hover:text-[#7f5fcf] transition">Login di sini</a>
            </p>
        </form>
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
