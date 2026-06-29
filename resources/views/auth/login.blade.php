<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SDY YPIK PAM JAYA</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#0C121F] flex items-center justify-center min-h-screen text-white font-sans">

    <div class="bg-[#111827] p-8 rounded-2xl shadow-xl w-full max-w-md border border-gray-800">
        <div class="flex flex-col items-center mb-6">
            <div class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center text-xs mb-2 font-bold text-gray-200">LOGO</div>
            <h2 class="text-sm font-semibold tracking-wider">SDY YPIK PAM JAYA</h2>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500 text-green-300 text-xs p-3 rounded-lg mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-xs text-gray-400 mb-1">Email</label>
                <input type="email" name="akun" value="{{ old('akun') }}" class="w-full bg-[#0C121F] border @error('akun') border-red-500 @else border-gray-700 @enderror rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500" placeholder="Masukkan alamat email Anda" required>
                @error('akun') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs text-gray-400 mb-1">Sandi</label>
                <input type="password" name="password" class="w-full bg-[#0C121F] border border-gray-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500" placeholder="Masukkan kata sandi" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg text-sm transition mt-2 cursor-pointer">
                Masuk
            </button>
        </form>

        <p class="text-center text-xs text-gray-400 mt-6">
            Tidak punya akun? <a href="{{ route('register') }}" class="text-blue-400 hover:underline">Daftar Akun</a>
        </p>
    </div>

</body>
</html>