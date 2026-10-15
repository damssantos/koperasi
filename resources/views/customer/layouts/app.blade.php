<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Dashboard Customer') - SOY YPIK PAM JAYA
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        if (typeof lucide === 'undefined') {
            document.write('<script src="{{ asset('js/lucide.min.js') }}"><\/script>');
        }
    </script>

    <!-- Flatpickr Datepicker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

    <style>
        :root {
            --primary: #2563EB;
            --primary-hover: #1D4ED8;
            --secondary: #0EA5E9;
            --accent: #10B981;
            --sidebar-bg: #111524;
            --page-bg: #EEF3FB;
            --panel-bg: #FFFFFF;
            --item-bg: #F8FAFC;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --border-color: #E2E8F0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background: var(--page-bg);
            color: var(--text-main);
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* =========================================
           SIDEBAR
        ========================================= */

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: var(--sidebar-bg);
            color: white;
            padding: 22px 16px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            border-right: 1px solid rgba(255, 255, 255, 0.06);
            z-index: 50;
        }

        /* LOGO BRAND */
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 6px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 18px;
        }

        .brand-logo-wrapper {
            width: 34px;
            height: 34px;
            min-width: 34px;
            border-radius: 50%;
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .brand-logo-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        .brand-text {
            font-size: 14px;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: -0.2px;
            white-space: nowrap;
        }

        /* MENU */
        .menu {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .menu-title {
            color: #64748B;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 12px 12px 6px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 12px;
            color: #94A3B8;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .menu a:hover {
            background: rgba(255, 255, 255, 0.07);
            color: #FFFFFF;
        }

        .menu a.active {
            background: var(--primary);
            color: #FFFFFF;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4);
        }

        .menu a svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        /* SIDEBAR BOTTOM */
        .sidebar-bottom {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .logout-button {
            width: 100%;
            border: none;
            background: transparent;
            color: #94A3B8;
            padding: 11px 14px;
            border-radius: 12px;
            text-align: left;
            cursor: pointer;
            font-size: 13.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease;
        }

        .logout-button:hover {
            background: rgba(239, 68, 68, 0.15);
            color: #F87171;
        }

        .logout-button svg {
            width: 18px;
            height: 18px;
        }

        .version-tag {
            text-align: center;
            margin-top: 14px;
            font-size: 11px;
            font-weight: 600;
            color: #475569;
            letter-spacing: 0.5px;
        }

        /* =========================================
           MAIN CONTENT
        ========================================= */

        .content {
            flex: 1;
            margin-left: 250px;
            min-width: 0;
            padding: 0 28px 32px;
        }

        /* =========================================
           TOP NAV BAR
        ========================================= */

        .top-navbar {
            height: 64px;
            margin: 0 -28px 24px;
            padding: 0 28px;
            background: #FFFFFF;
            border-bottom: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .top-navbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-toggle-btn {
            background: transparent;
            border: none;
            color: #64748B;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .menu-toggle-btn:hover {
            background: #F1F5F9;
            color: #0F172A;
        }

        .top-navbar-right {
            position: relative;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .mode-pill {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 8px;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 16px 6px 6px;
            border-radius: 9999px;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
            cursor: pointer;
        }

        .user-pill:hover,
        .user-pill.active {
            background: #EFF6FF;
            border-color: #BFDBFE;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.12);
        }

        /* =========================================
           PROFILE DROPDOWN (paritas dengan admin/pengawas)
        ========================================= */
        .hidden { display: none !important; }

        .user-info-text { display: none; }
        @media (min-width: 640px) {
            .user-info-text { display: flex; flex-direction: column; text-align: left; }
        }
        .user-name-text { font-size: 12px; font-weight: 700; color: #0F172A; line-height: 1.25; }
        .user-role-text { font-size: 9.5px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px; }

        #profileDropdown {
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 8px;
            width: 256px;
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.1), 0 8px 10px -6px rgba(15, 23, 42, 0.1);
            overflow: hidden;
            z-index: 100;
        }
        #profileDropdown .dd-header { padding: 14px 16px; border-bottom: 1px solid #E2E8F0; background: #F8FAFC; }
        #profileDropdown .dd-actions { padding: 8px; }
        #profileDropdown .dd-item {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            text-decoration: none;
            text-align: left;
            transition: all 0.15s ease;
        }
        #profileDropdown .dd-item { border: none; outline: none; background: transparent; font-family: inherit; cursor: pointer; }
        #profileDropdown .dd-item:hover { color: #0F172A; background: #F1F5F9; }
        #profileDropdown .dd-item.danger { color: #E11D48; }
        #profileDropdown .dd-item.danger:hover { background: #FFF1F2; }
        #profileDropdown .dd-icon {
            width: 28px; height: 28px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            background: #EFF6FF; color: #2563EB;
        }
        #profileDropdown .dd-icon.danger { background: rgba(254, 226, 226, 0.6); color: #E11D48; }
        #profileDropdown .dd-divider { border-top: 1px solid #E2E8F0; margin: 4px 0; }
        #profileDropdown .dd-avatar {
            width: 40px; height: 40px; border-radius: 50%;
            object-fit: cover; border: 1px solid #E2E8F0;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        #profileDropdown .dd-initial {
            width: 40px; height: 40px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #FFFFFF; font-size: 14px; font-weight: 800;
            background: #2563EB; box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .rotate-180 { transform: rotate(180deg); transition: transform 0.2s; }

        .user-avatar-circle,
        .user-avatar-img {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }

        .user-avatar-circle {
            background: #2563EB;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11.5px;
            font-weight: 800;
            box-shadow: 0 1px 3px rgba(37, 99, 235, 0.3);
        }

        .user-avatar-img {
            border: 1px solid #E2E8F0;
        }

        .user-info-text {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .user-name-text {
            font-size: 12px;
            font-weight: 700;
            color: #0F172A;
            line-height: 1.2;
            transition: color 0.2s ease;
        }

        .user-pill:hover .user-name-text {
            color: #2563EB;
        }

        .user-role-text {
            font-size: 9.5px;
            font-weight: 700;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        /* =========================================
           PAGE TITLE HEADER CARD
        ========================================= */

        .page-header-card {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 24px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-icon-box {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: #2563EB;
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            flex-shrink: 0;
        }

        .header-icon-box svg,
        .header-icon-box i {
            width: 22px;
            height: 22px;
            color: #FFFFFF !important;
        }

        .page-title {
            font-size: 22px;
            font-weight: 800;
            color: #0F172A;
            letter-spacing: -0.4px;
            line-height: 1.2;
        }

        .page-description {
            font-size: 13px;
            color: #64748B;
            margin-top: 3px;
        }

        /* =========================================
           ALERTS
        ========================================= */

        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #047857;
            border: 1px solid rgba(16, 185, 129, 0.25);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: #B91C1C;
            border: 1px solid rgba(239, 68, 68, 0.25);
        }

        .validation-errors {
            margin: 0;
            padding-left: 20px;
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 220px;
            }
            .content {
                margin-left: 220px;
                padding: 0 20px 25px;
            }
            .top-navbar {
                margin: 0 -20px 20px;
                padding: 0 20px;
            }
        }

        @media (max-width: 650px) {
            .layout {
                display: block;
            }
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }
            .content {
                margin-left: 0;
                padding: 0 16px 20px;
            }
            .top-navbar {
                margin: 0 -16px 16px;
                padding: 0 16px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
@php
    $navUser = auth()->user();
    $navAvatar = $navUser?->avatar;
    $hasNavAvatar = $navAvatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($navAvatar);
    $navInitial = strtoupper(substr(trim($navUser?->nama_lengkap ?: 'C'), 0, 1));
@endphp

    <div class="layout">

        <!-- SIDEBAR -->
        <aside class="sidebar">

            <!-- LOGO BRAND -->
            <div class="sidebar-brand">
                <div class="brand-logo-wrapper">
                    <img src="{{ asset('images/logo-ypik.png') }}" alt="Logo YPIK" class="brand-logo-img">
                </div>
                <span class="brand-text">SOY YPIK PAM JAYA</span>
            </div>

            <!-- MENU -->
            <nav class="menu">

                <div class="menu-title">
                    Menu Utama
                </div>

                <!-- DASHBOARD -->
                <a href="{{ route('customer.dashboard') }}" class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard"></i>
                    <span>Dashboard</span>
                </a>

                <!-- SIMPANAN -->
                <a href="{{ route('customer.simpanan') }}" class="{{ request()->routeIs('customer.simpanan') ? 'active' : '' }}">
                    <i data-lucide="wallet"></i>
                    <span>Simpanan</span>
                </a>

                <!-- PINJAMAN -->
                <a href="{{ route('customer.pinjaman') }}" class="{{ request()->routeIs('customer.pinjaman') ? 'active' : '' }}">
                    <i data-lucide="credit-card"></i>
                    <span>Pinjaman</span>
                </a>

                <!-- RIWAYAT -->
                <a href="{{ route('customer.riwayat') }}" class="{{ request()->routeIs('customer.riwayat') ? 'active' : '' }}">
                    <i data-lucide="history"></i>
                    <span>Riwayat Transaksi</span>
                </a>



            </nav>

            <!-- SIDEBAR BOTTOM -->
            <div class="sidebar-bottom">

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-button">
                        <i data-lucide="log-out"></i>
                        <span>Keluar</span>
                    </button>
                </form>

                <div class="version-tag">
                    Versi Web 1.1
                </div>

            </div>

        </aside>

        <!-- MAIN CONTENT -->
        <main class="content">

            <!-- TOP NAVBAR -->
            <header class="top-navbar">

                <div class="top-navbar-left">
                </div>

                <div class="top-navbar-right relative">
                    <!-- Profile Dropdown Trigger (Matching Admin Pill Design) -->
                    <button type="button" onclick="toggleProfileDropdown()" id="profileDropdownBtn" 
                            class="user-pill flex items-center gap-2.5 py-1.5 px-3 sm:pr-4 rounded-full bg-[#F8FAFC] border border-[#E2E8F0] hover:bg-[#EFF6FF] hover:border-[#BFDBFE] transition-all duration-200 group cursor-pointer shadow-sm">
                        @if($hasNavAvatar)
                            <img src="{{ asset('storage/' . $navAvatar) }}" alt="" class="user-avatar-img">
                        @else
                            <div class="user-avatar-circle">
                                {{ $navInitial }}
                            </div>
                        @endif
                        <div class="user-info-text">
                            <span class="user-name-text">{{ $navUser?->nama_lengkap ?? 'Customer' }}</span>
                            <span class="user-role-text">CUSTOMER</span>
                        </div>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-[#64748B] group-hover:text-[#2563EB] transition-transform duration-200" id="profileChevron"></i>
                    </button>

                    <!-- Profile Dropdown Menu (Matching Admin Light Style) -->
                    <div id="profileDropdown" class="hidden">
                        <!-- User Header -->
                        <div class="dd-header">
                            <div class="flex items-center gap-3" style="display:flex;align-items:center;gap:12px;">
                                @if($hasNavAvatar)
                                    <img src="{{ asset('storage/' . $navAvatar) }}" alt="" class="dd-avatar">
                                @else
                                    <div class="dd-initial">
                                        {{ $navInitial }}
                                    </div>
                                @endif
                                <div style="min-width:0;">
                                    <p style="font-size:12px;font-weight:700;color:#0F172A;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin:0;">{{ $navUser?->nama_lengkap ?? 'Customer' }}</p>
                                    <p style="font-size:10px;color:#64748B;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;margin:0;">CUSTOMER KOPERASI</p>
                                </div>
                            </div>
                        </div>

                        <!-- Dropdown Actions -->
                        <div class="dd-actions">
                            <a href="{{ route('customer.profil') }}" class="dd-item">
                                <div class="dd-icon">
                                    <i data-lucide="user" style="width:14px;height:14px;"></i>
                                </div>
                                <span>Profil Saya</span>
                            </a>

                            <div class="dd-divider"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dd-item danger">
                                    <div class="dd-icon danger">
                                        <i data-lucide="log-out" style="width:14px;height:14px;"></i>
                                    </div>
                                    <span>Keluar Akun</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </header>

            <!-- PAGE HEADER CARD -->
            <div class="page-header-card">
                <div class="header-icon-box">
                    @if(request()->routeIs('customer.simpanan'))
                        <i data-lucide="wallet"></i>
                    @elseif(request()->routeIs('customer.pinjaman'))
                        <i data-lucide="credit-card"></i>
                    @elseif(request()->routeIs('customer.riwayat'))
                        <i data-lucide="history"></i>
                    @elseif(request()->routeIs('customer.profil'))
                        <i data-lucide="user"></i>
                    @else
                        <i data-lucide="layout-dashboard"></i>
                    @endif
                </div>

                <div>
                    <h1 class="page-title">
                        @yield('page-title', 'Dashboard')
                    </h1>
                    <p class="page-description">
                        @yield('page-description', 'Sistem Operasional Yayasan YPIK - Ringkasan & Pemantauan')
                    </p>
                </div>
            </div>

            <!-- SUCCESS MESSAGE -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ERROR MESSAGE -->
            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <!-- VALIDATION ERRORS -->
            @if($errors->any())
                <div class="alert alert-error">
                    <ul class="validation-errors">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- PAGE CONTENT -->
            @yield('content')

        </main>

    </div>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });

        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            if (sidebar) {
                sidebar.classList.toggle('hidden');
            }
        }

        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            const chevron = document.getElementById('profileChevron');
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
            if (chevron) {
                chevron.classList.toggle('rotate-180');
            }
        }

        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('profileDropdown');
            const btn = document.getElementById('profileDropdownBtn');
            const chevron = document.getElementById('profileChevron');
            if (dropdown && btn && !btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
                if (chevron) chevron.classList.remove('rotate-180');
            }
        });
    </script>

</body>

</html>