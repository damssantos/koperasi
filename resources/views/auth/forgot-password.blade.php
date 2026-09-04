<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lupa Kata Sandi - SOY YPIK PAM JAYA</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
        }

        .auth-muted {
            color: #64748b;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950 flex items-center justify-center p-6">

    <div class="w-full max-w-md">

        <!-- Card -->
        <div class="glass rounded-3xl p-8">

            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img
                    src="{{ asset('images/logo-ypik.png') }}"
                    alt="SOY YPIK PAM JAYA"
                    class="h-20 object-contain"
                >
            </div>

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-extrabold text-slate-900">
                    Lupa Kata Sandi?
                </h1>

                <p class="text-sm auth-muted mt-2 leading-relaxed">
                    Masukkan alamat email yang terdaftar.
                    Kami akan mengirimkan kode OTP untuk
                    mengatur ulang kata sandi Anda.
                </p>
            </div>

            <!-- Success -->
            @if(session('success'))
                <div class="mb-5 rounded-xl bg-green-50 border border-green-200 px-4 py-3">
                    <div class="flex items-start gap-3">
                        <i data-lucide="check-circle"
                           class="w-5 h-5 text-green-600 mt-0.5"></i>

                        <p class="text-sm text-green-700">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Error -->
            @if(session('error'))
                <div class="mb-5 rounded-xl bg-red-50 border border-red-200 px-4 py-3">
                    <div class="flex items-start gap-3">
                        <i data-lucide="alert-circle"
                           class="w-5 h-5 text-red-600 mt-0.5"></i>

                        <p class="text-sm text-red-700">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form
                action="{{ route('password.email') }}"
                method="POST"
                class="space-y-5"
            >

                @csrf

                <!-- Email -->
                <div>
                    <label
                        for="email"
                        class="block text-xs font-bold text-slate-700 mb-2"
                    >
                        Alamat Email
                    </label>

                    <div class="relative">
                        <i data-lucide="mail"
                           class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email Anda"
                            required
                            autofocus
                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                        >
                    </div>

                    @error('email')
                        <p class="text-xs text-red-600 mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Button -->
                <button
                    type="submit"
                    class="w-full py-3.5 rounded-xl bg-[#2f54eb] hover:bg-[#1d39c4] text-white font-bold text-sm transition-all duration-200 shadow-lg shadow-blue-500/20"
                >
                    Kirim Kode OTP
                </button>

            </form>

            <!-- Back Login -->
            <div class="text-center mt-6">

                <a
                    href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-[#2f54eb] hover:text-[#1d39c4] transition"
                >
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>

                    Kembali ke Login
                </a>

            </div>

        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-slate-400 mt-6">
            © {{ date('Y') }} SOY YPIK PAM JAYA
        </p>

    </div>

    <script>
        lucide.createIcons();
    </script>

</body>
</html>