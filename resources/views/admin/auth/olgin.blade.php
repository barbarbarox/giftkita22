<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin | GiftKita</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-[#007daf] via-[#c771d4] to-[#ffb829] min-h-screen flex justify-center items-center">

    <div class="bg-white/95 backdrop-blur-md shadow-2xl rounded-2xl p-8 w-[90%] max-w-md transition-all duration-300 hover:scale-[1.02]">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829]">
                Admin GiftKita
            </h1>
            <p class="text-gray-500 text-sm mt-2">Silakan login untuk melanjutkan</p>
        </div>

        {{-- ALERT ERROR --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-3 mb-4 animate-fade-in">
                <ul class="text-sm list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM LOGIN --}}
        <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
            @csrf
            {{-- EMAIL --}}
            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" id="email" name="email"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#007daf] focus:outline-none"
                       placeholder="contoh@email.com" required>
            </div>

            {{-- PASSWORD --}}
            <div class="relative">
                <label for="password" class="block text-gray-700 font-semibold mb-1">Password</label>
                <input type="password" id="password" name="password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 focus:ring-2 focus:ring-[#c771d4] focus:outline-none"
                       placeholder="••••••••" required>
                <i id="togglePassword" class='bx bx-show absolute right-3 top-9 text-gray-500 text-xl cursor-pointer transition hover:text-[#c771d4]'></i>
            </div>

            {{-- TOMBOL LOGIN --}}
            <button type="submit"
                    class="w-full bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white py-2.5 rounded-lg font-semibold shadow-lg hover:shadow-xl hover:scale-[1.03] transition duration-200">
                Masuk
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            © {{ date('Y') }} GiftKita — Panel Admin
        </p>
    </div>

    {{-- SCRIPT TOGGLE PASSWORD --}}
    <script>
        const passwordInput = document.getElementById("password");
        const toggleIcon = document.getElementById("togglePassword");

        toggleIcon.addEventListener("click", () => {
            const isHidden = passwordInput.getAttribute("type") === "password";
            passwordInput.setAttribute("type", isHidden ? "text" : "password");
            toggleIcon.classList.toggle("bx-show");
            toggleIcon.classList.toggle("bx-hide");

            // Tambahkan animasi kecil saat diklik
            toggleIcon.classList.add("scale-125");
            setTimeout(() => toggleIcon.classList.remove("scale-125"), 150);
        });
    </script>

    {{-- ANIMASI CSS --}}
    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fade-in 0.4s ease-in-out; }
    </style>

</body>
</html>
