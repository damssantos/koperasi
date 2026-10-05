<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - SOY YPIK PAM JAYA</title>

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
        .logo-wrapper {
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

        .logo-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 22px;
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

        /* Email Box */
        .email-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 12px 14px;
            margin-bottom: 20px;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
        }

        .email-label {
            font-size: 11px;
            color: #94A3B8;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .email-address {
            font-size: 13.5px;
            color: #1E293B;
            font-weight: 700;
            margin-top: 2px;
            word-break: break-all;
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
            margin-bottom: 8px;
            color: #64748B;
            font-size: 12.5px;
            font-weight: 600;
            text-align: center;
        }

        .otp-input {
            width: 100%;
            height: 52px;
            background: #FFFFFF;
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            color: #1E293B;
            font-family: inherit;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 8px;
            text-align: center;
            outline: none;
            transition: all 0.2s ease;
        }

        .otp-input::placeholder {
            color: #CBD5E1;
            font-weight: 400;
            letter-spacing: 6px;
        }

        .otp-input:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .input-error {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            margin-top: 6px;
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

        .info-box svg {
            color: #2563EB;
            margin-top: 2px;
            flex-shrink: 0;
            width: 16px;
            height: 16px;
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

        /* Button */
        .verify-button {
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

        .verify-button:hover {
            background: #1D4ED8;
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.45);
            transform: translateY(-1px);
        }

        .verify-button:active {
            transform: translateY(0);
        }

        /* Resend Section */
        .resend-section {
            text-align: center;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid #E2E8F0;
        }

        .resend-text {
            font-size: 12px;
            color: #94A3B8;
            margin-bottom: 8px;
        }

        .resend-button {
            background: transparent;
            border: none;
            color: #2563EB;
            font-family: inherit;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: color 0.15s ease;
        }

        .resend-button:hover {
            color: #1D4ED8;
            text-decoration: underline;
        }

        /* Back Link */
        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 18px;
            color: #64748B;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .back-link:hover {
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
            <div class="logo-wrapper">
                <img src="{{ asset('images/logo-ypik.png') }}" alt="SOY YPIK PAM JAYA">
            </div>

            <!-- HEADER -->
            <div class="header">
                <h1>Verifikasi Email</h1>
                <p>Silakan verifikasi alamat email Anda untuk melanjutkan pendaftaran.</p>
            </div>

            <!-- EMAIL BOX -->
            <div class="email-box">
                <span class="email-label">Kode OTP dikirim ke</span>
                <span class="email-address">{{ $email }}</span>
            </div>

            <!-- SUCCESS MESSAGE -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i data-lucide="check-circle" style="width: 16px; height: 16px;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- ERROR MESSAGE -->
            @if(session('error'))
                <div class="alert alert-error">
                    <i data-lucide="alert-circle" style="width: 16px; height: 16px;"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- OTP FORM -->
            <form action="{{ route('register.verify.submit') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="otp" class="form-label">Kode OTP 6 Digit</label>
                    <input
                        type="text"
                        id="otp"
                        name="otp"
                        inputmode="numeric"
                        maxlength="6"
                        minlength="6"
                        pattern="[0-9]{6}"
                        autocomplete="one-time-code"
                        placeholder="••••••"
                        required
                        autofocus
                        class="otp-input"
                    >

                    @error('otp')
                        <div class="input-error">
                            <i data-lucide="alert-circle" style="width: 13px; height: 13px;"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- INFO -->
                <div class="info-box">
                    <i data-lucide="shield-alert"></i>
                    <div class="info-text">
                        Kode OTP berlaku selama <strong>5 menit</strong>. Masukkan kode digit yang dikirimkan ke email Anda.
                    </div>
                </div>

                <!-- BUTTON -->
                <button type="submit" class="verify-button">
                    <i data-lucide="shield-check" style="width: 16px; height: 16px;"></i>
                    <span>Verifikasi OTP</span>
                </button>
            </form>

            <!-- RESEND SECTION -->
            <div class="resend-section">
                <p class="resend-text">Tidak menerima kode OTP?</p>
                <form action="{{ route('register.resend') }}" method="POST">
                    @csrf
                    <button type="submit" class="resend-button">
                        Kirim Ulang Kode OTP
                    </button>
                </form>
            </div>

            <!-- BACK LINK -->
            <a href="{{ route('register') }}" class="back-link">
                <i data-lucide="arrow-left" style="width: 15px; height: 15px;"></i>
                <span>Kembali ke Pendaftaran</span>
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