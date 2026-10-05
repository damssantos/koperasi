<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - SOY YPIK PAM JAYA</title>

    <!-- Google Font: Plus Jakarta Sans -->
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

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #EEF2F6;
            background-image: 
                radial-gradient(at 10% 15%, rgba(37, 99, 235, 0.16) 0px, transparent 45%),
                radial-gradient(at 90% 85%, rgba(56, 189, 248, 0.18) 0px, transparent 45%),
                radial-gradient(at 85% 15%, rgba(99, 102, 241, 0.12) 0px, transparent 40%),
                radial-gradient(at 15% 90%, rgba(30, 58, 138, 0.14) 0px, transparent 40%),
                radial-gradient(#CBD5E1 1.2px, transparent 1.2px);
            background-size: 100% 100%, 100% 100%, 100% 100%, 100% 100%, 28px 28px;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
            position: relative;
            overflow-x: hidden;
            color: #1E293B;
        }

        /* Ambient Glowing Aurora Blobs in Background */
        .bg-blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
            opacity: 0.65;
            animation: blobFloat 12s ease-in-out infinite alternate;
        }

        .bg-blob-1 {
            width: 480px;
            height: 480px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.28), rgba(99, 102, 241, 0.18));
            top: -140px;
            left: -120px;
        }

        .bg-blob-2 {
            width: 440px;
            height: 440px;
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.25), rgba(37, 99, 235, 0.2));
            bottom: -120px;
            right: -100px;
            animation-delay: -6s;
        }

        @keyframes blobFloat {
            0% {
                transform: translate(0, 0) scale(1);
            }
            100% {
                transform: translate(30px, 20px) scale(1.08);
            }
        }

        .page-wrapper {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
        }

        /* Auth Card */
        .auth-card {
            width: 100%;
            background: #FFFFFF;
            border: 1px solid rgba(255, 255, 255, 0.85);
            border-radius: 20px;
            padding: 38px 34px;
            box-shadow: 0 25px 65px -15px rgba(15, 23, 42, 0.15), 0 10px 25px -10px rgba(37, 99, 235, 0.12);
        }

        /* Logo */
        .logo-container {
            width: 58px;
            height: 58px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #FFFFFF;
            border: 1.5px solid #E2E8F0;
            border-radius: 16px;
            padding: 8px;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.1);
        }

        .logo-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 24px;
        }

        .header h1 {
            font-size: 24px;
            line-height: 1.3;
            font-weight: 800;
            color: #1E293B;
            letter-spacing: -0.02em;
        }

        .header p {
            margin-top: 8px;
            font-size: 13px;
            line-height: 1.55;
            color: #94A3B8;
            font-weight: 500;
        }

        /* Alerts */
        .alert {
            width: 100%;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 14px;
            margin-bottom: 18px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            line-height: 1.5;
        }

        .alert-success {
            background: #ECFDF5;
            border: 1px solid #A7F3D0;
            color: #065F46;
        }

        .alert-error {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            color: #991B1B;
        }

        /* Form */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            margin-bottom: 7px;
            color: #64748B;
            font-size: 12.5px;
            font-weight: 600;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: #94A3B8;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-input {
            width: 100%;
            height: 44px;
            padding: 0 14px 0 40px;
            background: #FFFFFF;
            border: 1.5px solid #E2E8F0;
            border-radius: 8px;
            color: #1E293B;
            font-family: inherit;
            font-size: 13.5px;
            font-weight: 500;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-input::placeholder {
            color: #CBD5E1;
            font-weight: 400;
        }

        .form-input:hover {
            border-color: #CBD5E1;
        }

        .form-input:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .form-input.is-invalid {
            border-color: #EF4444;
            background-color: #FFF5F5;
        }

        .input-error {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 5px;
            color: #DC2626;
            font-size: 11.5px;
            font-weight: 600;
        }

        /* Info Box */
        .info-box {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 14px;
            margin-bottom: 20px;
            background: #EFF6FF;
            border: 1px solid #DBEAFE;
            border-radius: 10px;
        }

        .info-icon {
            color: #2563EB;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .info-text {
            color: #1E40AF;
            font-size: 12px;
            line-height: 1.5;
        }

        .info-text strong {
            color: #1D4ED8;
            font-weight: 700;
        }

        /* Submit Button */
        .submit-button {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 8px;
            background: #2563EB;
            color: #FFFFFF;
            font-family: inherit;
            font-size: 14.5px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
            transition: all 0.2s ease;
        }

        .submit-button:hover {
            background: #1D4ED8;
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.45);
            transform: translateY(-1px);
        }

        .submit-button:active {
            transform: translateY(0);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 22px 0;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: #E2E8F0;
        }

        .divider-text {
            color: #94A3B8;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        /* Back Link */
        .back-login {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            color: #64748B;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .back-login:hover {
            color: #2563EB;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer-main {
            color: #94A3B8;
            font-size: 11.5px;
            font-weight: 500;
        }

        .footer-sub {
            color: #CBD5E1;
            font-size: 10.5px;
            margin-top: 2px;
        }
    </style>
</head>
<body>

    <!-- Ambient Glowing Aurora Blobs in Background -->
    <div class="bg-blob bg-blob-1"></div>
    <div class="bg-blob bg-blob-2"></div>

    <div class="page-wrapper">

        <div class="auth-card">

            <!-- LOGO -->
            <div class="logo-container">
                <img src="{{ asset('images/logo-ypik.png') }}" alt="SOY YPIK PAM JAYA">
            </div>

            <!-- HEADER -->
            <div class="header">
                <h1>Lupa Kata Sandi?</h1>
                <p>Jangan khawatir. Masukkan email yang terdaftar untuk mendapatkan kode OTP dan mengatur ulang kata sandi Anda.</p>
            </div>

            <!-- SUCCESS -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i data-lucide="check-circle" style="width: 16px; height: 16px;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- ERROR -->
            @if(session('error'))
                <div class="alert alert-error">
                    <i data-lucide="alert-circle" style="width: 16px; height: 16px;"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- FORM -->
            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <!-- EMAIL -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Terdaftar</label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <i data-lucide="mail" style="width: 16px; height: 16px;"></i>
                        </div>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            autocomplete="email"
                            autofocus
                            required
                            class="form-input @error('email') is-invalid @enderror"
                        >
                    </div>

                    @error('email')
                        <div class="input-error">
                            <i data-lucide="alert-circle" style="width: 13px; height: 13px;"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- INFO -->
                <div class="info-box">
                    <i data-lucide="info" class="info-icon" style="width: 16px; height: 16px;"></i>
                    <div class="info-text">
                        Pastikan email yang Anda masukkan masih aktif. Kode OTP akan dikirim ke email tersebut dan berlaku selama <strong>5 menit</strong>.
                    </div>
                </div>

                <!-- BUTTON -->
                <button type="submit" class="submit-button">
                    <i data-lucide="send" style="width: 16px; height: 16px;"></i>
                    <span>Kirim Kode OTP</span>
                </button>

            </form>

            <!-- DIVIDER -->
            <div class="divider">
                <div class="divider-line"></div>
                <span class="divider-text">atau</span>
                <div class="divider-line"></div>
            </div>

            <!-- BACK -->
            <a href="{{ route('login') }}" class="back-login">
                <i data-lucide="arrow-left" style="width: 15px; height: 15px;"></i>
                <span>Kembali ke Login</span>
            </a>

        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p class="footer-main">© {{ date('Y') }} SOY YPIK PAM JAYA</p>
            <p class="footer-sub">Sistem Operasional Koperasi</p>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>

</body>
</html>