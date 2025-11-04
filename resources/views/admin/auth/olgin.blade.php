<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Secure Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white shadow-lg rounded-xl p-8 w-96">
        <h1 class="text-2xl font-bold text-center mb-6">Login Admin</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="text-sm">
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <label class="block mb-2 text-gray-700">Email</label>
            <input type="email" name="email" class="w-full border rounded-lg p-2 mb-4" required>

            <label class="block mb-2 text-gray-700">Password</label>
            <input type="password" name="password" class="w-full border rounded-lg p-2 mb-4" required>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">
                Masuk
            </button>
        </form>
    </div>
</body>
</html>
