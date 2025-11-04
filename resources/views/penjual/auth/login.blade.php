@extends('layouts.app')

@section('title', 'Login Penjual | GiftKita')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#007daf] via-[#c771d4] to-[#ffb829] py-12 px-4">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login Penjual</h2>

        @if(session('status'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('penjual.login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 font-semibold">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-[#007daf] focus:border-[#007daf]">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Password</label>
                <input type="password" name="password" required
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-[#007daf] focus:border-[#007daf]">
            </div>

            <button type="submit" 
                    class="w-full bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white font-semibold py-2 rounded-lg hover:scale-105 transition">
                Login
            </button>
        </form>
    </div>
</div>
@endsection
