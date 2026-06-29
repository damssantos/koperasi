<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SDY YPIK PAM JAYA</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#0C121F] flex items-center justify-center min-h-screen text-white font-sans py-10">

    <div class="bg-[#111827] p-8 rounded-2xl shadow-xl w-full max-w-md border border-gray-800">
        <div class="flex flex-col items-center mb-6">
            <div class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center text-xs mb-2 font-bold text-gray-200">LOGO</div>
            <h2 class="text-sm font-semibold tracking-wider">SDY YPIK PAM JAYA</h2>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-xs text-gray-400 mb-1">Nama Lengkap*</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="w-full bg-[#0C121F] border @error('nama_lengkap') border-red-500 @else border-gray-700 @enderror rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="Silakan tulis nama lengkap Anda">
                @error('nama_lengkap') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs text-gray-400 mb-1">NIK*</label>
                <input type="text" name="nik" value="{{ old('nik') }}" class="w-full bg-[#0C121F] border @error('nik') border-red-500 @else border-gray-700 @enderror rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="Silakan tulis 16 digit NIK Anda">
                @error('nik') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs text-gray-400 mb-1">Alamat*</label>
                <input type="text" name="alamat" value="{{ old('alamat') }}" class="w-full bg-[#0C121F] border @error('alamat') border-red-500 @else border-gray-700 @enderror rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="Silakan tulis alamat rumah Anda">
                @error('alamat') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs text-gray-400 mb-1">Nomor Handphone*</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full bg-[#0C121F] border @error('no_hp') border-red-500 @else border-gray-700 @enderror rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="Contoh: 081234567890">
                @error('no_hp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs text-gray-400 mb-1">Email*</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-[#0C121F] border @error('email') border-red-500 @else border-gray-700 @enderror rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-blue-500 text-white transition-all duration-500 ease-in-out autofill:shadow-[inset_0_0_0_1000px_#0C121F] [-webkit-text-fill-color:white]" placeholder="Silakan tulis email aktif Anda">
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs text-gray-400 mb-1">Kata Sandi*</label>
                <input type="password" name="password" class="w-full bg-[#0C121F] border @error('password') border-red-500 @else border-gray-700 @enderror rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-blue-500 text-white transition-all duration-500 ease-in-out autofill:shadow-[inset_0_0_0_1000px_#0C121F] [-webkit-text-fill-color:white]" placeholder="Minimal 6 karakter">
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full bg-[#060E20] hover:bg-[#0c1933] border border-gray-800 text-white font-medium py-2.5 rounded-lg text-sm transition mt-4 cursor-pointer">
                Daftar
            </button>
        </form>

        <p class="text-center text-xs text-gray-400 mt-6">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-400 hover:underline">Login Akun</a>
        </p>
    </div>

</body>
</html>