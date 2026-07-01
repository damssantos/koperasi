<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota - SOY YPIK PAM JAYA</title>
    <!-- Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS Browser CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <!-- Lucide Icons -->
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
            --focus-border: #2f54eb;
            --focus-ring: rgba(47, 84, 235, 0.25);
            --bg-glow: radial-gradient(at 0% 0%, rgba(47, 84, 235, 0.12) 0, transparent 40%), radial-gradient(at 100% 100%, rgba(99, 102, 241, 0.12) 0, transparent 40%), #0d0f17;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-glow);
            color: var(--text-body);
        }

        .auth-card {
            background: var(--bg-card);
            border-color: var(--border-card);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .auth-title {
            color: var(--text-title);
        }

        .auth-muted {
            color: var(--text-muted);
        }

        .auth-input {
            background-color: var(--bg-input);
            border-color: var(--border-input);
            color: var(--text-title);
        }

        .auth-input:focus {
            border-color: var(--focus-border);
            box-shadow: 0 0 0 3px var(--focus-ring);
        }

        /* Autofill Styling */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: var(--text-title) !important;
            -webkit-box-shadow: 0 0 0px 1000px var(--bg-input) inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-x-hidden py-12">

    <!-- Background Ambient Glows -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl opacity-60"></div>
    </div>

    <!-- CENTER CARD CONTAINER -->
    <div class="w-full max-w-2xl auth-card border rounded-2xl shadow-xl overflow-hidden relative z-10 transition-all duration-300 hover:shadow-2xl hover:scale-[1.005]">
        <!-- Top Glowing Bar -->
        <div class="h-1.5 w-full bg-gradient-to-r from-blue-600 via-indigo-500 to-blue-600"></div>

        <div class="p-8 space-y-6">
            <!-- Logo & Brand Header -->
            <div class="flex flex-col items-center text-center space-y-2.5">
                <div class="w-16 h-16 rounded-full overflow-hidden bg-white shadow-lg shadow-blue-500/10 flex items-center justify-center">
                    <img src="{{ asset('images/logo-ypik.png') }}" alt="Logo YPIK PAM JAYA" class="w-full h-full object-cover">
                </div>
                <div>
                    <h2 class="text-xl font-extrabold tracking-tight auth-title">SOY YPIK PAM JAYA</h2>
                    <p class="auth-muted text-xs font-semibold tracking-wide uppercase mt-0.5">Registrasi Anggota Koperasi</p>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Grid Container for Inputs -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5 gap-y-4">
                    
                    <!-- Nama Lengkap -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold auth-muted">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[var(--text-muted)]">
                                <i data-lucide="user" class="w-4 h-4"></i>
                            </span>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" 
                                   class="w-full auth-input border @error('nama_lengkap') border-rose-500 @else border-[var(--border-input)] @enderror rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none transition-all duration-200" 
                                   placeholder="Nama lengkap" required>
                        </div>
                        @error('nama_lengkap') 
                            <div class="flex items-center gap-1.5 text-rose-500 text-xs mt-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                <span>{{ $message }}</span>
                            </div> 
                        @enderror
                    </div>

                    <!-- NIK -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold auth-muted">NIK (16 Digit)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[var(--text-muted)]">
                                <i data-lucide="credit-card" class="w-4 h-4"></i>
                            </span>
                            <input type="text" name="nik" value="{{ old('nik') }}" 
                                   class="w-full auth-input border @error('nik') border-rose-500 @else border-[var(--border-input)] @enderror rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none transition-all duration-200" 
                                   placeholder="16 digit NIK" required>
                        </div>
                        @error('nik') 
                            <div class="flex items-center gap-1.5 text-rose-500 text-xs mt-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                <span>{{ $message }}</span>
                            </div> 
                        @enderror
                    </div>

                    <!-- Alamat Rumah (Full Width) -->
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="block text-xs font-bold auth-muted">Alamat Rumah</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[var(--text-muted)]">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                            </span>
                            <input type="text" name="alamat" value="{{ old('alamat') }}" 
                                   class="w-full auth-input border @error('alamat') border-rose-500 @else border-[var(--border-input)] @enderror rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none transition-all duration-200" 
                                   placeholder="Alamat lengkap" required>
                        </div>
                        @error('alamat') 
                            <div class="flex items-center gap-1.5 text-rose-500 text-xs mt-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                <span>{{ $message }}</span>
                            </div> 
                        @enderror
                    </div>

                    <!-- Nomor Handphone -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold auth-muted">Nomor Handphone</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[var(--text-muted)]">
                                <i data-lucide="phone" class="w-4 h-4"></i>
                            </span>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" 
                                   class="w-full auth-input border @error('no_hp') border-rose-500 @else border-[var(--border-input)] @enderror rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none transition-all duration-200" 
                                   placeholder="081234567890" required>
                        </div>
                        @error('no_hp') 
                            <div class="flex items-center gap-1.5 text-rose-500 text-xs mt-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                <span>{{ $message }}</span>
                            </div> 
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold auth-muted">Email Aktif</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[var(--text-muted)]">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                   class="w-full auth-input border @error('email') border-rose-500 @else border-[var(--border-input)] @enderror rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none transition-all duration-200" 
                                   placeholder="nama@email.com" required>
                        </div>
                        @error('email') 
                            <div class="flex items-center gap-1.5 text-rose-500 text-xs mt-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                <span>{{ $message }}</span>
                            </div> 
                        @enderror
                    </div>

                    <!-- Kata Sandi (Full Width) -->
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="block text-xs font-bold auth-muted">Kata Sandi</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[var(--text-muted)]">
                                <i data-lucide="lock" class="w-4 h-4"></i>
                            </span>
                            <input type="password" id="password" name="password" 
                                   class="w-full auth-input border @error('password') border-rose-500 @else border-[var(--border-input)] @enderror rounded-xl pl-10 pr-10 py-2.5 text-sm focus:outline-none transition-all duration-200" 
                                   placeholder="Minimal 6 karakter" required>
                            <button type="button" onclick="togglePasswordVisibility('password', this)" 
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-[var(--text-muted)] hover:text-[var(--text-title)] cursor-pointer transition-colors duration-150">
                                <i data-lucide="eye" class="w-4 h-4 eye-icon"></i>
                                <i data-lucide="eye-off" class="w-4 h-4 eye-off-icon hidden"></i>
                            </button>
                        </div>
                        @error('password') 
                            <div class="flex items-center gap-1.5 text-rose-500 text-xs mt-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                <span>{{ $message }}</span>
                            </div> 
                        @enderror
                    </div>

                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-[#2f54eb] hover:bg-[#1d39c4] text-white font-bold py-2.5 rounded-xl text-sm transition-all duration-150 shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 active:scale-[0.99] cursor-pointer mt-4">
                    Daftar Sekarang
                </button>
            </form>

            <!-- Bottom Link -->
            <p class="text-center text-xs auth-muted pt-2 border-t border-[var(--border-card)]">
                Sudah memiliki akun anggota? <a href="{{ route('login') }}" class="text-[#2f54eb] hover:text-[#1d39c4] font-semibold hover:underline">Masuk Akun</a>
            </p>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Toggle password visibility (robust class switcher)
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