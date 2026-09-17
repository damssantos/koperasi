<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Buat Kata Sandi Baru - SOY YPIK PAM JAYA</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #080a12;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow-x: hidden;
        }

        /* Background glow */
        body::before {
            content: "";
            position: fixed;
            width: 500px;
            height: 500px;
            background: rgba(47, 84, 235, 0.12);
            border-radius: 50%;
            filter: blur(100px);
            top: -220px;
            left: -180px;
            pointer-events: none;
        }

        body::after {
            content: "";
            position: fixed;
            width: 450px;
            height: 450px;
            background: rgba(30, 64, 175, 0.10);
            border-radius: 50%;
            filter: blur(100px);
            right: -180px;
            bottom: -200px;
            pointer-events: none;
        }

        .page-wrapper {
            width: 100%;
            max-width: 430px;
            position: relative;
            z-index: 1;
        }

        /* =========================
           CARD
        ========================= */

        .auth-card {
            width: 100%;
            background: #0f121e;
            border: 1px solid #202538;
            border-radius: 24px;
            padding: 36px;
            box-shadow:
                0 25px 70px rgba(0, 0, 0, 0.45),
                0 10px 30px rgba(0, 0, 0, 0.20);
        }

        /* =========================
           LOGO
        ========================= */

        .logo-container {
            width: 78px;
            height: 78px;
            margin: 0 auto 24px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #151927;
            border: 1px solid #252b40;
            border-radius: 20px;
        }

        .logo-container img {
            width: 58px;
            height: 58px;
            object-fit: contain;
            display: block;
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            text-align: center;
            margin-bottom: 28px;
        }

        .header-icon {
            width: 46px;
            height: 46px;
            margin: 0 auto 16px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(47, 84, 235, 0.10);
            border: 1px solid rgba(47, 84, 235, 0.22);
            border-radius: 13px;

            color: #4f6ff5;
        }

        .header-icon svg {
            width: 21px;
            height: 21px;
        }

        .header h1 {
            font-size: 24px;
            line-height: 1.3;
            font-weight: 800;
            letter-spacing: -0.4px;
            color: #ffffff;
        }

        .header p {
            margin-top: 8px;
            font-size: 13px;
            line-height: 1.6;
            color: #8993aa;
        }

        /* =========================
           ALERTS
        ========================= */

        .alert {
            width: 100%;
            display: flex;
            align-items: flex-start;
            gap: 11px;

            padding: 13px 14px;
            margin-bottom: 20px;

            border-radius: 12px;
            font-size: 12px;
            line-height: 1.5;
        }

        .alert svg {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .alert-error {
            background: rgba(244, 63, 94, 0.08);
            border: 1px solid rgba(244, 63, 94, 0.20);
            color: #fda4af;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.20);
            color: #6ee7b7;
        }

        /* =========================
           FORM
        ========================= */

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;

            color: #f1f5f9;
            font-size: 12px;
            font-weight: 700;
        }

        .input-wrapper {
            position: relative;
            width: 100%;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);

            color: #667085;

            display: flex;
            align-items: center;
            justify-content: center;

            pointer-events: none;
        }

        .input-icon svg {
            width: 18px;
            height: 18px;
        }

        .toggle-btn {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);

            background: none;
            border: none;
            color: #667085;
            cursor: pointer;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 4px;
            transition: color 0.2s ease;
        }

        .toggle-btn:hover {
            color: #d1d5db;
        }

        .toggle-btn svg {
            width: 18px;
            height: 18px;
        }

        .form-input {
            width: 100%;
            height: 50px;

            padding: 0 46px 0 45px;

            background: #111522;
            border: 1px solid #292f43;
            border-radius: 12px;

            color: #ffffff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;

            outline: none;

            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                background 0.2s ease;
        }

        .form-input::placeholder {
            color: #626c82;
        }

        .form-input:hover {
            border-color: #343c54;
        }

        .form-input:focus {
            border-color: #2f54eb;
            background: #121625;
            box-shadow: 0 0 0 3px rgba(47, 84, 235, 0.12);
        }

        .form-input.has-error {
            border-color: rgba(244, 63, 94, 0.5);
        }

        .input-error {
            display: flex;
            align-items: center;
            gap: 6px;

            margin-top: 7px;

            color: #fb7185;
            font-size: 11px;
        }

        .input-error svg {
            width: 13px;
            height: 13px;
            flex-shrink: 0;
        }

        /* =========================
           INFO BOX
        ========================= */

        .info-box {
            width: 100%;

            display: flex;
            align-items: flex-start;
            gap: 11px;

            padding: 12px 14px;
            margin-bottom: 22px;

            background: #111522;
            border: 1px solid #20263a;
            border-radius: 12px;
        }

        .info-icon {
            width: 17px;
            height: 17px;

            flex-shrink: 0;
            margin-top: 1px;

            color: #4f6ff5;
        }

        .info-text {
            color: #7f899f;
            font-size: 11px;
            line-height: 1.6;
        }

        .info-text strong {
            color: #dce2ef;
            font-weight: 700;
        }

        /* =========================
           BUTTON
        ========================= */

        .submit-button {
            width: 100%;
            height: 50px;

            border: none;
            border-radius: 12px;

            background: #2f54eb;
            color: #ffffff;

            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 700;

            cursor: pointer;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            box-shadow: 0 10px 25px rgba(47, 84, 235, 0.20);

            transition:
                background 0.2s ease,
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .submit-button svg {
            width: 17px;
            height: 17px;
        }

        .submit-button:hover {
            background: #1d39c4;
            transform: translateY(-1px);
            box-shadow: 0 14px 30px rgba(47, 84, 235, 0.28);
        }

        .submit-button:active {
            transform: translateY(0);
        }

        /* =========================
           DIVIDER
        ========================= */

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;

            margin: 24px 0;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: #20263a;
        }

        .divider-text {
            color: #596276;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* =========================
           BACK LINK
        ========================= */

        .back-login {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;

            color: #4f6ff5;

            font-size: 12px;
            font-weight: 700;

            text-decoration: none;

            transition: color 0.2s ease;
        }

        .back-login:hover {
            color: #7189ff;
        }

        .back-login svg {
            width: 16px;
            height: 16px;
        }

        /* =========================
           FOOTER
        ========================= */

        .footer {
            text-align: center;
            margin-top: 22px;
        }

        .footer-main {
            color: #596276;
            font-size: 10px;
        }
    </style>
</head>
<body>

    <div class="page-wrapper">

        <!-- Card -->
        <div class="auth-card">

            <!-- Logo -->
            <div class="logo-container">
                <img
                    src="{{ asset('images/logo-ypik.png') }}"
                    alt="SOY YPIK PAM JAYA"
                >
            </div>

            <!-- Header -->
            <div class="header">
                <div class="header-icon">
                    <i data-lucide="lock-keyhole"></i>
                </div>

                <h1>Buat Kata Sandi Baru</h1>
                <p>Buat kata sandi baru untuk mengamankan akun Anda.</p>
            </div>

            <!-- Alert Error -->
            @if(session('error'))
                <div class="alert alert-error">
                    <i data-lucide="alert-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Alert Success -->
            @if(session('status') || session('success'))
                <div class="alert alert-success">
                    <i data-lucide="check-circle"></i>
                    <span>{{ session('status') ?? session('success') }}</span>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('password.update') }}" method="POST">
                @csrf

                <!-- Kata Sandi Baru -->
                <div class="form-group">
                    <label for="password" class="form-label">
                        Kata Sandi Baru
                    </label>

                    <div class="input-wrapper">
                        <span class="input-icon">
                            <i data-lucide="lock"></i>
                        </span>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan kata sandi baru"
                            required
                            minlength="6"
                            class="form-input @error('password') has-error @enderror"
                        >

                        <button
                            type="button"
                            onclick="togglePassword('password', 'eye-password')"
                            class="toggle-btn"
                            aria-label="Toggle password visibility"
                        >
                            <i id="eye-password" data-lucide="eye"></i>
                        </button>
                    </div>

                    @error('password')
                        <div class="input-error">
                            <i data-lucide="alert-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Konfirmasi Kata Sandi -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">
                        Konfirmasi Kata Sandi
                    </label>

                    <div class="input-wrapper">
                        <span class="input-icon">
                            <i data-lucide="shield-check"></i>
                        </span>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Ulangi kata sandi baru"
                            required
                            minlength="6"
                            class="form-input"
                        >

                        <button
                            type="button"
                            onclick="togglePassword('password_confirmation', 'eye-confirm')"
                            class="toggle-btn"
                            aria-label="Toggle confirm password visibility"
                        >
                            <i id="eye-confirm" data-lucide="eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="info-box">
                    <i data-lucide="info" class="info-icon"></i>
                    <p class="info-text">
                        Kata sandi harus memiliki minimal <strong>6 karakter</strong>.
                    </p>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-button">
                    <i data-lucide="check-circle"></i>
                    <span>Simpan Kata Sandi Baru</span>
                </button>
            </form>

            <!-- Divider -->
            <div class="divider">
                <span class="divider-line"></span>
                <span class="divider-text">atau</span>
                <span class="divider-line"></span>
            </div>

            <!-- Back to Login -->
            <a href="{{ route('login') }}" class="back-login">
                <i data-lucide="arrow-left"></i>
                <span>Kembali ke Login</span>
            </a>

        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-main">© {{ date('Y') }} SOY YPIK PAM JAYA</p>
        </div>

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