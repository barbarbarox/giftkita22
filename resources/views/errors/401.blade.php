<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>401 - Tidak Terautentikasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .animate-fade-in { animation: fadeIn 0.6s ease-in; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen flex items-center justify-center px-4">
    <div class="max-w-xl w-full animate-fade-in text-center">
        <!-- Icon -->
        <div class="mb-8">
            <div class="inline-block bg-blue-100 rounded-full p-6 mb-4">
                <i class="fas fa-lock text-6xl text-blue-500"></i>
            </div>
            <h1 class="text-7xl font-bold text-blue-600 mb-2">401</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tidak Terautentikasi</h2>
            <p class="text-gray-600">Anda harus login untuk mengakses halaman ini.</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center gap-3 p-4 bg-yellow-50 rounded-lg">
                <i class="fas fa-exclamation-circle text-yellow-500 text-2xl"></i>
                <p class="text-sm text-gray-700 text-left">
                    Halaman yang Anda coba akses memerlukan autentikasi. Silakan login terlebih dahulu.
                </p>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('penjual.login') }}" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg transition shadow-lg hover:shadow-xl">
                <i class="fas fa-sign-in-alt"></i>
                Login Penjual
            </a>
            
            <a href="{{ route('admin.login') }}" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold rounded-lg transition shadow-lg hover:shadow-xl">
                <i class="fas fa-user-shield"></i>
                Login Admin
            </a>
        </div>

        <p class="mt-6 text-sm text-gray-500">
            Belum punya akun? <a href="{{ route('penjual.register') }}" class="text-blue-600 hover:underline">Daftar sekarang</a>
        </p>
    </div>
</body>
</html>