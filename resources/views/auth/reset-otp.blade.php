<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verifikasi OTP - SOY YPIK PAM JAYA</title>

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

                <div class="mx-auto mb-5 w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center">
                    <i data-lucide="shield-check"
                       class="w-7 h-7 text-[#2f54eb]"></i>
                </div>

                <h1 class="text-2xl font-extrabold text-slate-900">
                    Verifikasi OTP
                </h1>

                <p class="text-sm auth-muted mt-2 leading-relaxed">
                    Masukkan kode OTP 6 digit yang telah
                    dikirim ke email:
                </p>

                <p class="text-sm font-bold text-slate-800 mt-2 break-all">
                    {{ $email }}
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

            <!-- OTP Form -->
            <form
                action="{{ route('password.verify.submit') }}"
                method="POST"
                class="space-y-5"
            >

                @csrf

                <div>
                    <label
                        for="otp"
                        class="block text-xs font-bold text-slate-700 mb-2"
                    >
                        Kode OTP
                    </label>

                    <input
                        type="text"
                        id="otp"
                        name="otp"
                        value="{{ old('otp') }}"
                        maxlength="6"
                        inputmode="numeric"
                        pattern="[0-9]{6}"
                        autocomplete="one-time-code"
                        placeholder="000000"
                        required
                        autofocus
                        class="w-full px-4 py-4 rounded-xl border border-slate-200 bg-white text-slate-900 text-center text-2xl font-extrabold tracking-[0.5em] outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                    >

                    @error('otp')
                        <p class="text-xs text-red-600 mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Expired info -->
                <div class="flex items-start gap-3 rounded-xl bg-blue-50 border border-blue-100 p-4">

                    <i data-lucide="clock"
                       class="w-5 h-5 text-[#2f54eb] mt-0.5"></i>

                    <p class="text-xs text-blue-700 leading-relaxed">
                        Kode OTP berlaku selama
                        <strong>5 menit</strong>.
                        Jangan berikan kode ini kepada orang lain.
                    </p>

                </div>

                <!-- Button -->
                <button
                    type="submit"
                    class="w-full py-3.5 rounded-xl bg-[#2f54eb] hover:bg-[#1d39c4] text-white font-bold text-sm transition-all duration-200 shadow-lg shadow-blue-500/20"
                >
                    Verifikasi OTP
                </button>

            </form>

            <!-- Back -->
            <div class="text-center mt-6">

                <a
                    href="{{ route('password.request') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-[#2f54eb] hover:text-[#1d39c4] transition"
                >
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>

                    Gunakan Email Lain
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

        // Hanya izinkan angka
        document.getElementById('otp').addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 6);
        });
    </script>

</body>
</html>