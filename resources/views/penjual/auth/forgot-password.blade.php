@extends('layouts.app')

@section('title', 'Lupa Password | GiftKita')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-50 to-blue-50 px-4">
    <div class="max-w-md w-full">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('images/GiftKita.png') }}" alt="GiftKita" class="h-16 mx-auto mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Lupa Password?</h2>
                <p class="text-gray-600 mt-2">Masukkan email Anda untuk menerima link reset password</p>
            </div>

            <!-- Status Message -->
            @if (session('status'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-green-800 text-sm">{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('penjual.password.email') }}">
                @csrf

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                        placeholder="email@example.com"
                        required
                        autofocus
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold py-3 rounded-lg hover:from-purple-700 hover:to-blue-700 transition duration-300 shadow-lg hover:shadow-xl"
                >
                    Kirim Link Reset Password
                </button>

                <!-- Back to Login -->
                <div class="mt-6 text-center">
                    <a href="{{ route('penjual.login') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                        ← Kembali ke Login
                    </a>
                </div>
            </form>
        </div>

        <!-- Help Text -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('penjual.register') }}" class="text-purple-600 hover:text-purple-700 font-medium">
                    Daftar sekarang
                </a>
            </p>
        </div>
    </div>
</div>
@endsection