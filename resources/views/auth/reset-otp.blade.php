<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verifikasi OTP - SOY YPIK PAM JAYA</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

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
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 24px;

            font-family: 'Plus Jakarta Sans', sans-serif;

            background:
                radial-gradient(
                    circle at 0% 0%,
                    rgba(47, 84, 235, 0.14),
                    transparent 38%
                ),
                radial-gradient(
                    circle at 100% 100%,
                    rgba(30, 64, 175, 0.12),
                    transparent 38%
                ),
                #080a12;

            color: #ffffff;
        }

        /* =========================
           PAGE
        ========================= */

        .page-wrapper {
            width: 100%;
            max-width: 430px;
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

        .logo-wrapper {
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

        .logo-wrapper img {
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

            margin-bottom: 26px;
        }

        .otp-icon {
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

        .otp-icon svg {
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
            margin-top: 9px;

            font-size: 12px;

            line-height: 1.7;

            color: #8993aa;
        }

        /* =========================
           EMAIL
        ========================= */

        .email-box {
            width: 100%;

            padding: 13px 15px;

            margin-bottom: 22px;

            text-align: center;

            background: #111522;

            border: 1px solid #20263a;

            border-radius: 12px;
        }

        .email-label {
            display: block;

            margin-bottom: 5px;

            color: #69748b;

            font-size: 10px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: 0.7px;
        }

        .email-address {
            display: block;

            color: #e8ecf5;

            font-size: 12px;

            font-weight: 600;

            word-break: break-word;
        }

        /* =========================
           ALERT
        ========================= */

        .alert {
            width: 100%;

            display: flex;

            align-items: flex-start;

            gap: 10px;

            padding: 12px 13px;

            margin-bottom: 18px;

            border-radius: 12px;

            font-size: 11px;

            line-height: 1.5;
        }

        .alert svg {
            width: 16px;
            height: 16px;

            flex-shrink: 0;

            margin-top: 1px;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.08);

            border: 1px solid rgba(16, 185, 129, 0.20);

            color: #6ee7b7;
        }

        .alert-error {
            background: rgba(244, 63, 94, 0.08);

            border: 1px solid rgba(244, 63, 94, 0.20);

            color: #fda4af;
        }

        /* =========================
           FORM
        ========================= */

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;

            margin-bottom: 9px;

            color: #e8ecf5;

            font-size: 12px;

            font-weight: 700;

            text-align: center;
        }

        /* =========================
           OTP INPUT
        ========================= */

        .otp-input {
            width: 100%;

            height: 58px;

            padding: 0 18px;

            background: #111522;

            border: 1px solid #292f43;

            border-radius: 13px;

            outline: none;

            color: #ffffff;

            font-family: 'Plus Jakarta Sans', sans-serif;

            font-size: 23px;

            font-weight: 800;

            letter-spacing: 0.55em;

            text-align: center;

            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                background 0.2s ease;
        }

        .otp-input::placeholder {
            color: #4d566b;

            font-size: 13px;

            font-weight: 500;

            letter-spacing: 0.15em;
        }

        .otp-input:hover {
            border-color: #343c54;
        }

        .otp-input:focus {
            border-color: #2f54eb;

            background: #121625;

            box-shadow:
                0 0 0 3px rgba(47, 84, 235, 0.12);
        }

        .input-error {
            display: flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            margin-top: 8px;

            color: #fb7185;

            font-size: 11px;
        }

        .input-error svg {
            width: 13px;
            height: 13px;
        }

        /* =========================
           INFO
        ========================= */

        .info-box {
            width: 100%;

            display: flex;

            align-items: flex-start;

            gap: 10px;

            padding: 13px 14px;

            margin-bottom: 20px;

            background: #111522;

            border: 1px solid #20263a;

            border-radius: 12px;
        }

        .info-box svg {
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

        .verify-button {
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

            box-shadow:
                0 10px 25px rgba(47, 84, 235, 0.20);

            transition:
                background 0.2s ease,
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .verify-button svg {
            width: 17px;
            height: 17px;
        }

        .verify-button:hover {
            background: #1d39c4;

            transform: translateY(-1px);

            box-shadow:
                0 14px 30px rgba(47, 84, 235, 0.28);
        }

        .verify-button:active {
            transform: translateY(0);
        }

        /* =========================
           BACK
        ========================= */

        .back-link {
            display: flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            margin-top: 22px;

            color: #69748b;

            font-size: 11px;

            font-weight: 600;

            text-decoration: none;

            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: #ffffff;
        }

        .back-link svg {
            width: 15px;
            height: 15px;
        }

        /* =========================
           FOOTER
        ========================= */

        .footer {
            text-align: center;

            margin-top: 20px;
        }

        .footer-main {
            color: #596276;

            font-size: 10px;
        }

        .footer-sub {
            color: #3f4658;

            font-size: 9px;

            margin-top: 5px;
        }

        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 480px) {

            body {
                padding: 16px;
            }

            .auth-card {
                padding: 28px 22px;

                border-radius: 20px;
            }

            .logo-wrapper {
                width: 70px;
                height: 70px;
            }

            .logo-wrapper img {
                width: 53px;
                height: 53px;
            }

            .header h1 {
                font-size: 22px;
            }

            .header p {
                font-size: 11px;
            }

            .otp-input {
                height: 54px;

                font-size: 21px;
            }
        }
    </style>
</head>

<body>

    <div class="page-wrapper">

        <div class="auth-card">

            <!-- LOGO -->
            <div class="logo-wrapper">

                <img
                    src="{{ asset('images/logo-ypik.png') }}"
                    alt="SOY YPIK PAM JAYA"
                >

            </div>

            <!-- HEADER -->
            <div class="header">

                <div class="otp-icon">

                    <i data-lucide="shield-check"></i>

                </div>

                <h1>
                    Verifikasi OTP
                </h1>

                <p>
                    Masukkan kode OTP yang telah
                    dikirimkan ke email Anda.
                </p>

            </div>

            <!-- EMAIL -->
            <div class="email-box">

                <span class="email-label">
                    Kode dikirim ke
                </span>

                <span class="email-address">
                    {{ $email }}
                </span>

            </div>

            <!-- SUCCESS MESSAGE -->
            @if(session('success'))

                <div class="alert alert-success">

                    <i data-lucide="check-circle"></i>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif

            <!-- ERROR MESSAGE -->
            @if(session('error'))

                <div class="alert alert-error">

                    <i data-lucide="alert-circle"></i>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>

            @endif

            <!-- OTP FORM -->
            <form
                action="{{ route('password.verify.submit') }}"
                method="POST"
            >

                @csrf

                <div class="form-group">

                    <label
                        for="otp"
                        class="form-label"
                    >
                        Kode OTP 6 Digit
                    </label>

                    <input
                        type="text"
                        id="otp"
                        name="otp"
                        value="{{ old('otp') }}"
                        maxlength="6"
                        minlength="6"
                        inputmode="numeric"
                        pattern="[0-9]{6}"
                        autocomplete="one-time-code"
                        placeholder="000000"
                        required
                        autofocus
                        class="otp-input"
                    >

                    @error('otp')

                        <div class="input-error">

                            <i data-lucide="alert-circle"></i>

                            <span>
                                {{ $message }}
                            </span>

                        </div>

                    @enderror

                </div>

                <!-- INFO -->
                <div class="info-box">

                    <i data-lucide="clock"></i>

                    <div class="info-text">

                        Kode OTP berlaku selama
                        <strong>5 menit</strong>.
                        Jangan berikan kode OTP Anda
                        kepada orang lain.

                    </div>

                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="verify-button"
                >

                    <i data-lucide="shield-check"></i>

                    <span>
                        Verifikasi OTP
                    </span>

                </button>

            </form>

            <!-- BACK -->
            <a
                href="{{ route('password.request') }}"
                class="back-link"
            >

                <i data-lucide="arrow-left"></i>

                <span>
                    Gunakan Email Lain
                </span>

            </a>

        </div>

        <!-- FOOTER -->
        <div class="footer">

            <p class="footer-main">
                © {{ date('Y') }} SOY YPIK PAM JAYA
            </p>

            <p class="footer-sub">
                Sistem Operasional Koperasi
            </p>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            const otpInput = document.getElementById('otp');

            if (otpInput) {

                otpInput.addEventListener('input', function () {

                    this.value = this.value
                        .replace(/\D/g, '')
                        .slice(0, 6);

                });

            }

        });
    </script>

</body>

</html>