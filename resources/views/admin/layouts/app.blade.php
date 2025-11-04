<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen bg-gray-100">

    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-900 text-white p-5 flex flex-col">
        <h1 class="text-2xl font-bold mb-6">Admin Panel</h1>
        <a href="{{ route('admin.dashboard') }}" class="mb-3 hover:text-blue-400">🏠 Dashboard</a>
        <a href="{{ route('admin.penjual.index') }}" class="mb-3 hover:text-blue-400">👤 Penjual</a>
        <a href="{{ route('admin.kategori.index') }}" class="mb-3 hover:text-blue-400">📦 Kategori</a>
        <a href="{{ route('admin.faq.index') }}" class="mb-3 hover:text-blue-400">❓ FAQ</a>

        <form method="POST" action="{{ route('admin.logout') }}" class="mt-auto">
            @csrf
            <button class="w-full bg-red-500 py-2 rounded hover:bg-red-600">Logout</button>
        </form>
    </aside>

    {{-- Main content --}}
    <main class="flex-1 overflow-y-auto bg-white">
        @yield('content')
    </main>
</body>
</html>
