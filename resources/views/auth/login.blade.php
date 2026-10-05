<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SOY YPIK PAM JAYA</title>
    
    <!-- Fonts: Plus Jakarta Sans -->
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
            width: 520px;
            height: 520px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.28), rgba(99, 102, 241, 0.18));
            top: -140px;
            left: -120px;
        }

        .bg-blob-2 {
            width: 480px;
            height: 480px;
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.25), rgba(37, 99, 235, 0.2));
            bottom: -120px;
            right: -100px;
            animation-delay: -6s;
        }

        .bg-blob-3 {
            width: 320px;
            height: 320px;
            background: linear-gradient(135deg, rgba(147, 197, 253, 0.35), rgba(59, 130, 246, 0.15));
            top: 35%;
            right: 18%;
            animation-duration: 15s;
        }

        @keyframes blobFloat {
            0% {
                transform: translate(0, 0) scale(1);
            }
            100% {
                transform: translate(35px, 25px) scale(1.08);
            }
        }

        /* Medium Sized Floating Card */
        .login-card {
            width: 100%;
            max-width: 900px;
            min-height: 540px;
            background: #FFFFFF;
            border-radius: 20px;
            box-shadow: 0 25px 65px -15px rgba(15, 23, 42, 0.15), 0 10px 25px -10px rgba(37, 99, 235, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.85);
            display: flex;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        /* =========================================
           LEFT ARTWORK PANEL (50% - FULL BLUE)
        ========================================= */
        .art-panel {
            flex: 1;
            width: 50%;
            position: relative;
            background: linear-gradient(150deg, #0F2042 0%, #1E3A8A 32%, #1D4ED8 68%, #2563EB 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 44px 44px;
            overflow: hidden;
            min-height: 540px;
        }

        /* SVG Fluid Wave Layer */
        .art-svg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        /* Brand Logo in Top-Left */
        .art-brand {
            position: relative;
            z-index: 5;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .art-logo-box {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.95);
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .art-logo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .art-brand-text {
            color: #FFFFFF;
            font-weight: 800;
            font-size: 15px;
            letter-spacing: -0.01em;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            line-height: 1.2;
        }

        .art-brand-sub {
            display: block;
            font-size: 10px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.85);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Welcome Text */
        .art-welcome-box {
            position: relative;
            z-index: 5;
            margin-top: auto;
            padding-bottom: 12px;
        }

        .art-welcome-title {
            color: #FFFFFF;
            font-size: 44px;
            font-weight: 800;
            line-height: 1.08;
            letter-spacing: -0.03em;
            text-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        }

        /* =========================================
           RIGHT FORM PANEL (50%)
        ========================================= */
        .form-panel {
            flex: 1;
            width: 50%;
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 44px 48px;
        }

        .form-content {
            width: 100%;
            max-width: 380px;
        }

        /* Title & Subtitle */
        .login-title {
            font-size: 28px;
            font-weight: 800;
            color: #1E293B;
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .login-subtitle {
            font-size: 13px;
            color: #94A3B8;
            font-weight: 500;
            margin-bottom: 24px;
            line-height: 1.4;
        }

        /* Form Inputs */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #94A3B8;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            height: 44px;
            background: #FFFFFF;
            border: 1.5px solid #E2E8F0;
            border-radius: 8px;
            padding: 0 14px;
            font-size: 14px;
            font-weight: 500;
            color: #1E293B;
            font-family: inherit;
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

        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-container .form-input {
            padding-right: 44px;
        }

        .password-toggle-btn {
            position: absolute;
            right: 12px;
            background: transparent;
            border: none;
            color: #94A3B8;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color 0.15s ease;
        }

        .password-toggle-btn:hover {
            color: #64748B;
        }

        /* Options Row (Remember Me & Forgot Password) */
        .options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 8px;
            margin-bottom: 24px;
            font-size: 12.5px;
            gap: 12px;
            white-space: nowrap;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748B;
            font-weight: 600;
            cursor: pointer;
            user-select: none;
        }

        /* Custom Checkbox */
        .custom-checkbox {
            appearance: none;
            -webkit-appearance: none;
            width: 17px;
            height: 17px;
            border: 1.5px solid #CBD5E1;
            border-radius: 4px;
            outline: none;
            cursor: pointer;
            position: relative;
            transition: all 0.15s ease;
            background: #FFFFFF;
        }

        .custom-checkbox:checked {
            background-color: #2563EB;
            border-color: #2563EB;
        }

        .custom-checkbox:checked::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 2px;
            width: 4px;
            height: 8px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .forgot-link {
            color: #94A3B8;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .forgot-link:hover {
            color: #2563EB;
            text-decoration: underline;
        }

        /* Login Button */
        .btn-login {
            width: 100%;
            height: 48px;
            background: #2563EB;
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            background: #1D4ED8;
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.45);
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Bottom Signup Text */
        .signup-text {
            margin-top: 28px;
            text-align: center;
            font-size: 13px;
            color: #94A3B8;
            font-weight: 500;
        }

        .signup-link {
            color: #2563EB;
            font-weight: 700;
            text-decoration: none;
            margin-left: 3px;
            transition: color 0.15s ease;
        }

        .signup-link:hover {
            color: #1D4ED8;
            text-decoration: underline;
        }

        /* Validation / Alert */
        .form-error {
            color: #DC2626;
            font-size: 11.5px;
            font-weight: 600;
            margin-top: 5px;
        }

        .alert-msg {
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            margin-bottom: 18px;
        }

        .alert-success {
            background: #ECFDF5;
            color: #065F46;
            border: 1px solid #A7F3D0;
        }

        .alert-error {
            background: #FEF2F2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        .hidden {
            display: none !important;
        }

        /* Responsive Breakpoint */
        @media (max-width: 820px) {
            body {
                padding: 20px 14px;
            }

            .login-card {
                flex-direction: column;
                max-width: 440px;
                min-height: auto;
                border-radius: 16px;
            }

            .art-panel {
                width: 100%;
                flex: none;
                min-height: 240px;
                height: auto;
                padding: 32px 28px;
            }

            .art-welcome-title {
                font-size: 34px;
            }

            .form-panel {
                width: 100%;
                flex: none;
                min-height: auto;
                height: auto;
                padding: 36px 28px 44px;
            }
        }
    </style>
</head>
<body>

    <!-- Ambient Glowing Aurora Blobs in Background -->
    <div class="bg-blob bg-blob-1"></div>
    <div class="bg-blob bg-blob-2"></div>
    <div class="bg-blob bg-blob-3"></div>

    <!-- Medium Sized Floating Card -->
    <div class="login-card">

        <!-- =========================================
             LEFT PANEL: FLUID WAVES & WELCOME BACK
        ========================================= -->
        <div class="art-panel">
            
            <!-- SVG Fluid Waves in Pure Blue Palette -->
            <svg class="art-svg" viewBox="0 0 460 560" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <!-- Deep Blue to Royal Blue -->
                    <linearGradient id="blueWave1" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#1E3A8A" />
                        <stop offset="50%" stop-color="#2563EB" />
                        <stop offset="100%" stop-color="#3B82F6" />
                    </linearGradient>

                    <!-- Electric Cobalt to Sky Blue -->
                    <linearGradient id="blueWave2" x1="0%" y1="100%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#1D4ED8" />
                        <stop offset="60%" stop-color="#3B82F6" />
                        <stop offset="100%" stop-color="#60A5FA" />
                    </linearGradient>

                    <!-- Bright Cyan-Blue Highlight -->
                    <linearGradient id="blueHighlight" x1="100%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#38BDF8" stop-opacity="0.75" />
                        <stop offset="60%" stop-color="#2563EB" stop-opacity="0.3" />
                        <stop offset="100%" stop-color="#1D4ED8" stop-opacity="0" />
                    </linearGradient>

                    <!-- Translucent Glow -->
                    <radialGradient id="blueGlow" cx="20%" cy="20%" r="70%">
                        <stop offset="0%" stop-color="#60A5FA" stop-opacity="0.35" />
                        <stop offset="100%" stop-color="#1E40AF" stop-opacity="0" />
                    </radialGradient>
                </defs>

                <!-- Soft upper ambient glow -->
                <circle cx="90" cy="90" r="220" fill="url(#blueGlow)" />

                <!-- Upper fluid wave shape -->
                <path d="M 0,0 
                         L 160,0 
                         C 170,80 200,130 250,160 
                         C 340,210 430,200 420,320 
                         C 400,420 280,430 200,410 
                         C 120,390 50,460 0,510 
                         Z" 
                      fill="url(#blueWave1)" opacity="0.9" />

                <!-- Flowing dynamic mid-to-bottom wave -->
                <path d="M 0,220 
                         C 80,180 170,200 240,260 
                         C 320,330 310,430 240,490 
                         C 180,540 90,560 0,560 
                         Z" 
                      fill="url(#blueWave2)" opacity="0.85" />

                <!-- Highlight sweep across bottom right -->
                <path d="M 100,560 
                         C 220,530 360,470 460,340 
                         L 460,560 
                         Z" 
                      fill="url(#blueHighlight)" />
            </svg>

            <!-- Top Brand Logo -->
            <div class="art-brand">
                <div class="art-logo-box">
                    <img src="{{ asset('images/logo-ypik.png') }}" alt="Logo YPIK">
                </div>
                <div>
                    <span class="art-brand-text">SOY YPIK</span>
                    <span class="art-brand-sub">PAM JAYA</span>
                </div>
            </div>

        </div>

        <!-- =========================================
             RIGHT PANEL: LOGIN FORM
        ========================================= -->
        <div class="form-panel">
            <div class="form-content">
                <!-- Header -->
                <h2 class="login-title">Masuk</h2>
                <p class="login-subtitle">Selamat datang kembali! Silakan masuk ke akun Anda.</p>

                <!-- Alerts -->
                @if(session('success'))
                    <div class="alert-msg alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert-msg alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <!-- User Name / Email -->
                    <div class="form-group">
                        <label for="akun" class="form-label">Email / Nama Pengguna</label>
                        <input 
                            type="email" 
                            id="akun"
                            name="akun" 
                            value="{{ old('akun') }}" 
                            class="form-input @error('akun') is-invalid @enderror" 
                            placeholder="nama@email.com" 
                            required 
                            autocomplete="email"
                            autofocus
                        >
                        @error('akun') 
                            <div class="form-error">
                                {{ $message }}
                            </div> 
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <div class="password-container">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-input @error('password') is-invalid @enderror" 
                                placeholder="••••••••••" 
                                required 
                                autocomplete="current-password"
                            >
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility('password', this)" 
                                class="password-toggle-btn"
                                aria-label="Tampilkan / Sembunyikan Kata Sandi"
                            >
                                <i data-lucide="eye" class="eye-icon" style="width: 17px; height: 17px;"></i>
                                <i data-lucide="eye-off" class="eye-off-icon hidden" style="width: 17px; height: 17px;"></i>
                            </button>
                        </div>
                        @error('password') 
                            <div class="form-error">
                                {{ $message }}
                            </div> 
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password Row -->
                    <div class="options-row">
                        <label class="remember-label">
                            <input type="checkbox" name="remember" class="custom-checkbox" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Ingat Saya</span>
                        </label>

                        <a href="{{ route('password.request') }}" class="forgot-link">
                            Lupa Kata Sandi?
                        </a>
                    </div>

                    <!-- Action Button -->
                    <button type="submit" class="btn-login">
                        Masuk
                    </button>

                </form>

                <!-- Bottom Link -->
                <p class="signup-text">
                    Belum punya akun? <a href="{{ route('register') }}" class="signup-link">Daftar</a>
                </p>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script>
        // Initialize Lucide Icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Toggle password visibility
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const eyeIcon = btn.querySelector('.eye-icon');
            const eyeOffIcon = btn.querySelector('.eye-off-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</body>
</html>