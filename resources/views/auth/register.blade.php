<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota - SOY YPIK PAM JAYA</title>
    
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
            padding: 36px 20px;
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

        /* Floating Card Matching Login */
        .register-card {
            width: 100%;
            max-width: 1000px;
            min-height: 580px;
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
           LEFT ARTWORK PANEL (Full Blue Fluid Waves)
        ========================================= */
        .art-panel {
            width: 38%;
            flex: 0 0 38%;
            position: relative;
            background: linear-gradient(150deg, #0F2042 0%, #1E3A8A 32%, #1D4ED8 68%, #2563EB 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 44px 40px;
            overflow: hidden;
            min-height: 580px;
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

        /* Brand Logo */
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

        /* =========================================
           RIGHT FORM PANEL
        ========================================= */
        .form-panel {
            width: 62%;
            flex: 0 0 62%;
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 48px;
            overflow-y: auto;
        }

        .form-content {
            width: 100%;
            max-width: 520px;
        }

        /* Header */
        .register-title {
            font-size: 28px;
            font-weight: 800;
            color: #1E293B;
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .register-subtitle {
            font-size: 13px;
            color: #94A3B8;
            font-weight: 500;
            margin-bottom: 22px;
            line-height: 1.4;
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px 16px;
        }

        .col-span-2 {
            grid-column: span 2;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: #64748B;
            margin-bottom: 6px;
        }

        /* Input with Leading Icon */
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
            height: 42px;
            background: #FFFFFF;
            border: 1.5px solid #E2E8F0;
            border-radius: 8px;
            padding: 0 14px 0 38px;
            font-size: 13.5px;
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

        /* Password Toggle */
        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-container .form-input {
            padding-right: 40px;
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

        /* Error Text */
        .form-error {
            color: #DC2626;
            font-size: 11.5px;
            font-weight: 600;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Submit Button */
        .btn-register {
            width: 100%;
            height: 46px;
            background: #2563EB;
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            font-size: 14.5px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
            transition: all 0.2s ease;
            margin-top: 18px;
        }

        .btn-register:hover {
            background: #1D4ED8;
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.45);
            transform: translateY(-1px);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        /* Bottom Login Link */
        .signin-text {
            margin-top: 20px;
            text-align: center;
            font-size: 12.5px;
            color: #94A3B8;
            font-weight: 500;
        }

        .signin-link {
            color: #2563EB;
            font-weight: 700;
            text-decoration: none;
            margin-left: 3px;
            transition: color 0.15s ease;
        }

        .signin-link:hover {
            color: #1D4ED8;
            text-decoration: underline;
        }

        .hidden {
            display: none !important;
        }

        /* Responsive Breakpoint */
        @media (max-width: 860px) {
            body {
                padding: 20px 14px;
            }

            .register-card {
                flex-direction: column;
                max-width: 520px;
                min-height: auto;
                border-radius: 16px;
            }

            .art-panel {
                width: 100%;
                flex: none;
                min-height: 180px;
                height: auto;
                padding: 28px 24px;
            }

            .form-panel {
                width: 100%;
                flex: none;
                padding: 32px 24px 38px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .col-span-2 {
                grid-column: span 1;
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
    <div class="register-card">

        <!-- =========================================
             LEFT PANEL: FLUID WAVES & BRAND LOGO
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
             RIGHT PANEL: REGISTER FORM
        ========================================= -->
        <div class="form-panel">
            <div class="form-content">
                <!-- Header -->
                <h2 class="register-title">Daftar Akun</h2>
                <p class="register-subtitle">Lengkapi formulir di bawah ini untuk bergabung menjadi anggota koperasi.</p>

                <!-- Form -->
                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="form-grid">

                        <!-- Nama Lengkap -->
                        <div class="form-group">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <i data-lucide="user" style="width: 16px; height: 16px;"></i>
                                </span>
                                <input 
                                    type="text" 
                                    id="nama_lengkap"
                                    name="nama_lengkap" 
                                    value="{{ old('nama_lengkap') }}" 
                                    class="form-input @error('nama_lengkap') is-invalid @enderror" 
                                    placeholder="Nama lengkap sesuai KTP" 
                                    required
                                    autofocus
                                >
                            </div>
                            @error('nama_lengkap') 
                                <div class="form-error">
                                    <i data-lucide="alert-circle" style="width: 13px; height: 13px;"></i>
                                    <span>{{ $message }}</span>
                                </div> 
                            @enderror
                        </div>

                        <!-- NIK (16 Digit) -->
                        <div class="form-group">
                            <label for="nik" class="form-label">NIK (16 Digit)</label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <i data-lucide="credit-card" style="width: 16px; height: 16px;"></i>
                                </span>
                                <input 
                                    type="text" 
                                    id="nik"
                                    name="nik" 
                                    value="{{ old('nik') }}" 
                                    class="form-input @error('nik') is-invalid @enderror" 
                                    placeholder="16 digit NIK KTP" 
                                    maxlength="16"
                                    required
                                >
                            </div>
                            @error('nik') 
                                <div class="form-error">
                                    <i data-lucide="alert-circle" style="width: 13px; height: 13px;"></i>
                                    <span>{{ $message }}</span>
                                </div> 
                            @enderror
                        </div>

                        <!-- Nomor Handphone -->
                        <div class="form-group">
                            <label for="no_hp" class="form-label">Nomor Handphone</label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <i data-lucide="phone" style="width: 16px; height: 16px;"></i>
                                </span>
                                <input 
                                    type="text" 
                                    id="no_hp"
                                    name="no_hp" 
                                    value="{{ old('no_hp') }}" 
                                    class="form-input @error('no_hp') is-invalid @enderror" 
                                    placeholder="08xxxxxxxxxx" 
                                    required
                                >
                            </div>
                            @error('no_hp') 
                                <div class="form-error">
                                    <i data-lucide="alert-circle" style="width: 13px; height: 13px;"></i>
                                    <span>{{ $message }}</span>
                                </div> 
                            @enderror
                        </div>

                        <!-- Email Aktif -->
                        <div class="form-group">
                            <label for="email" class="form-label">Email Aktif</label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <i data-lucide="mail" style="width: 16px; height: 16px;"></i>
                                </span>
                                <input 
                                    type="email" 
                                    id="email"
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    class="form-input @error('email') is-invalid @enderror" 
                                    placeholder="nama@email.com" 
                                    required
                                >
                            </div>
                            @error('email') 
                                <div class="form-error">
                                    <i data-lucide="alert-circle" style="width: 13px; height: 13px;"></i>
                                    <span>{{ $message }}</span>
                                </div> 
                            @enderror
                        </div>

                        <!-- Alamat Rumah (Full Width) -->
                        <div class="form-group col-span-2">
                            <label for="alamat" class="form-label">Alamat Rumah</label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <i data-lucide="map-pin" style="width: 16px; height: 16px;"></i>
                                </span>
                                <input 
                                    type="text" 
                                    id="alamat"
                                    name="alamat" 
                                    value="{{ old('alamat') }}" 
                                    class="form-input @error('alamat') is-invalid @enderror" 
                                    placeholder="Alamat lengkap tempat tinggal" 
                                    required
                                >
                            </div>
                            @error('alamat') 
                                <div class="form-error">
                                    <i data-lucide="alert-circle" style="width: 13px; height: 13px;"></i>
                                    <span>{{ $message }}</span>
                                </div> 
                            @enderror
                        </div>

                        <!-- Kata Sandi (Full Width) -->
                        <div class="form-group col-span-2">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <div class="input-wrapper password-container">
                                <span class="input-icon">
                                    <i data-lucide="lock" style="width: 16px; height: 16px;"></i>
                                </span>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="form-input @error('password') is-invalid @enderror" 
                                    placeholder="Minimal 6 karakter" 
                                    required
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePasswordVisibility('password', this)" 
                                    class="password-toggle-btn"
                                    aria-label="Tampilkan / Sembunyikan Kata Sandi"
                                >
                                    <i data-lucide="eye" class="eye-icon" style="width: 16px; height: 16px;"></i>
                                    <i data-lucide="eye-off" class="eye-off-icon hidden" style="width: 16px; height: 16px;"></i>
                                </button>
                            </div>
                            @error('password') 
                                <div class="form-error">
                                    <i data-lucide="alert-circle" style="width: 13px; height: 13px;"></i>
                                    <span>{{ $message }}</span>
                                </div> 
                            @enderror
                        </div>

                    </div>

                    <!-- Action Button -->
                    <button type="submit" class="btn-register">
                        Daftar Sekarang
                    </button>

                </form>

                <!-- Bottom Link -->
                <p class="signin-text">
                    Sudah memiliki akun anggota? <a href="{{ route('login') }}" class="signin-link">Masuk Akun</a>
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