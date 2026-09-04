<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verifikasi Email - SOY YPIK PAM JAYA</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --bg-page: #0d0f17;
            --bg-card: rgba(22, 25, 43, 0.7);
            --border-card: rgba(255, 255, 255, 0.06);
            --text-title: #ffffff;
            --text-muted: #94a3b8;
            --text-body: #d1d5db;
            --bg-input: rgba(7, 8, 15, 0.6);
            --border-input: rgba(255, 255, 255, 0.08);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background:
                radial-gradient(
                    at 0% 0%,
                    rgba(47, 84, 235, 0.12) 0,
                    transparent 40%
                ),
                radial-gradient(
                    at 100% 100%,
                    rgba(99, 102, 241, 0.12) 0,
                    transparent 40%
                ),
                #0d0f17;

            color: var(--text-body);
        }

        .auth-card {
            background: var(--bg-card);
            border-color: var(--border-card);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 relative overflow-x-hidden">

    <!-- Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">

        <div class="absolute -top-40 -left-40 w-96 h-96
            bg-blue-500/10 rounded-full blur-3xl opacity-60">
        </div>

        <div class="absolute -bottom-40 -right-40 w-96 h-96
            bg-indigo-500/10 rounded-full blur-3xl opacity-60">
        </div>

    </div>

    <!-- Card -->
    <div class="w-full max-w-md auth-card border rounded-2xl shadow-xl
        overflow-hidden relative z-10">

        <!-- Top bar -->
        <div class="h-1.5 w-full bg-gradient-to-r
            from-blue-600 via-indigo-500 to-blue-600">
        </div>

        <div class="p-8 space-y-6">

            <!-- Logo -->
            <div class="flex flex-col items-center text-center space-y-3">

                <div class="w-16 h-16 rounded-full overflow-hidden
                    bg-white shadow-lg shadow-blue-500/10">

                    <img
                        src="{{ asset('images/logo-ypik.png') }}"
                        alt="Logo YPIK PAM JAYA"
                        class="w-full h-full object-cover"
                    >

                </div>

                <div>

                    <h2 class="text-xl font-extrabold text-white">
                        Verifikasi Email
                    </h2>

                    <p class="text-slate-400 text-xs font-semibold
                        tracking-wide uppercase mt-1">

                        SOY YPIK PAM JAYA

                    </p>

                </div>

            </div>

            <!-- Description -->
            <div class="text-center">

                <p class="text-sm text-slate-400 leading-relaxed">

                    Kode OTP telah dikirim ke:

                </p>

                <p class="text-sm text-white font-semibold mt-1 break-all">

                    {{ $email }}

                </p>

                <p class="text-xs text-slate-500 mt-2">

                    Masukkan kode 6 digit yang kami kirimkan
                    ke email Anda.

                </p>

            </div>

            <!-- Success -->
            @if(session('success'))

                <div class="bg-emerald-500/10 border
                    border-emerald-500/20 text-emerald-400
                    text-xs p-3.5 rounded-xl">

                    {{ session('success') }}

                </div>

            @endif

            <!-- Error -->
            @if(session('error'))

                <div class="bg-rose-500/10 border
                    border-rose-500/20 text-rose-400
                    text-xs p-3.5 rounded-xl">

                    {{ session('error') }}

                </div>

            @endif

            <!-- OTP Form -->
            <form
                action="{{ route('register.verify.otp') }}"
                method="POST"
                class="space-y-5"
            >

                @csrf

                <div>

                    <label class="block text-xs font-bold text-slate-400 mb-2">
                        Kode OTP
                    </label>

                    <input
                        type="text"
                        name="otp"
                        inputmode="numeric"
                        maxlength="6"
                        autocomplete="one-time-code"
                        placeholder="Masukkan 6 digit OTP"
                        class="w-full bg-black/30 border
                            border-white/10 rounded-xl
                            px-4 py-3 text-center text-xl
                            tracking-[0.5em] text-white
                            focus:outline-none focus:border-blue-500
                            transition"
                        required
                    >

                    @error('otp')

                        <p class="text-rose-400 text-xs mt-2">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

                <button
                    type="submit"
                    class="w-full bg-[#2f54eb]
                        hover:bg-[#1d39c4]
                        text-white font-bold py-3
                        rounded-xl text-sm
                        transition-all shadow-md"
                >
                    Verifikasi OTP
                </button>

            </form>

            <!-- Resend -->
            <div class="text-center pt-2 border-t border-white/5">

                <p class="text-xs text-slate-500 mb-3">
                    Tidak menerima kode?
                </p>

                <form
                    action="{{ route('register.resend') }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="text-[#2f54eb]
                            hover:text-blue-400
                            text-xs font-semibold
                            hover:underline"
                    >
                        Kirim Ulang OTP
                    </button>

                </form>

            </div>

            <!-- Back -->
            <div class="text-center">

                <a
                    href="{{ route('register') }}"
                    class="text-xs text-slate-500
                        hover:text-white transition"
                >
                    ← Kembali ke halaman pendaftaran
                </a>

            </div>

        </div>

    </div>

    <script>
        lucide.createIcons();
    </script>

</body>

</html>