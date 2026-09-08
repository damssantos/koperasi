<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Buat Kata Sandi Baru - SOY YPIK PAM JAYA</title>

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

                <div class="mx-auto mb-5 w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center">
                    <i data-lucide="lock-keyhole"
                       class="w-7 h-7 text-green-600"></i>
                </div>

                <h1 class="text-2xl font-extrabold text-slate-900">
                    Buat Kata Sandi Baru
                </h1>

                <p class="text-sm auth-muted mt-2 leading-relaxed">
                    Buat kata sandi baru untuk mengamankan
                    akun Anda.
                </p>

            </div>

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
                action="{{ route('password.update') }}"
                method="POST"
                class="space-y-5"
            >

                @csrf

                <!-- Password -->
                <div>

                    <label
                        for="password"
                        class="block text-xs font-bold text-slate-700 mb-2"
                    >
                        Kata Sandi Baru
                    </label>

                    <div class="relative">

                        <i data-lucide="lock"
                           class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan kata sandi baru"
                            required
                            minlength="6"
                            class="w-full pl-12 pr-12 py-3.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                        >

                        <button
                            type="button"
                            onclick="togglePassword('password', 'eye-password')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700"
                        >
                            <i
                                id="eye-password"
                                data-lucide="eye"
                                class="w-5 h-5"
                            ></i>
                        </button>

                    </div>

                    @error('password')
                        <p class="text-xs text-red-600 mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <!-- Confirm Password -->
                <div>

                    <label
                        for="password_confirmation"
                        class="block text-xs font-bold text-slate-700 mb-2"
                    >
                        Konfirmasi Kata Sandi
                    </label>

                    <div class="relative">

                        <i data-lucide="shield-check"
                           class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Ulangi kata sandi baru"
                            required
                            minlength="6"
                            class="w-full pl-12 pr-12 py-3.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                        >

                        <button
                            type="button"
                            onclick="togglePassword('password_confirmation', 'eye-confirm')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700"
                        >
                            <i
                                id="eye-confirm"
                                data-lucide="eye"
                                class="w-5 h-5"
                            ></i>
                        </button>

                    </div>

                </div>

                <!-- Password Info -->
                <div class="flex items-start gap-3 rounded-xl bg-blue-50 border border-blue-100 p-4">

                    <i data-lucide="info"
                       class="w-5 h-5 text-[#2f54eb] mt-0.5"></i>

                    <p class="text-xs text-blue-700 leading-relaxed">
                        Kata sandi harus memiliki minimal
                        <strong>6 karakter</strong>.
                    </p>

                </div>

                <!-- Button -->
                <button
                    type="submit"
                    class="w-full py-3.5 rounded-xl bg-[#2f54eb] hover:bg-[#1d39c4] text-white font-bold text-sm transition-all duration-200 shadow-lg shadow-blue-500/20"
                >
                    Simpan Kata Sandi Baru
                </button>

            </form>

            <!-- Login -->
            <div class="text-center mt-6">

                <a
                    href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-[#2f54eb] hover:text-[#1d39c4] transition"
                >
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

        function togglePassword(inputId, iconId) {

            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {

                input.type = 'text';

                icon.setAttribute('data-lucide', 'eye-off');

            } else {

                input.type = 'password';

                icon.setAttribute('data-lucide', 'eye');

            }

            lucide.createIcons();
        }

    </script>

</body>
</html>