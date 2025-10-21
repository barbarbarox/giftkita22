<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GiftKita')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800 flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center p-4">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo.jpg') }}" alt="GiftKita Logo" class="h-10">
                <h1 class="font-bold text-xl">GiftKita</h1>
            </div>
            <ul class="flex gap-6 font-medium">
                <li><a href="/" class="hover:underline">Beranda</a></li>
                <li><a href="/katalog" class="hover:underline">Katalog</a></li>
                <li><a href="/faq" class="hover:underline">FAQ</a></li>
                <li><a href="/login" class="hover:underline">Masuk</a></li>
            </ul>
        </div>
    </nav>

    <!-- Konten dinamis -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-[#ffb829] via-[#c771d4] to-[#007daf] text-white text-center p-4">
        <p class="text-sm">&copy; {{ date('Y') }} GiftKita — Semua hak cipta dilindungi.</p>
    </footer>

</body>
</html>
