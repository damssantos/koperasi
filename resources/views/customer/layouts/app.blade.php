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
                    <!-- Mobile / Desktop Sidebar Toggle Button -->
                    <button type="button" onclick="toggleSidebar()" class="p-2 rounded-xl text-[#64748B] hover:text-[#0F172A] hover:bg-[#F1F5F9] transition-colors" title="Buka/Tutup Menu Sidebar">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
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
                        <div class="user-info-text hidden sm:flex">
                            <span class="user-name-text">{{ $navUser?->nama_lengkap ?? 'Customer' }}</span>
                            <span class="user-role-text">CUSTOMER</span>
                        </div>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-[#64748B] group-hover:text-[#2563EB] transition-transform duration-200" id="profileChevron"></i>
                    </button>

                    <!-- Profile Dropdown Menu (Matching Admin Light Style) -->
                    <div id="profileDropdown" class="hidden absolute right-0 top-full mt-2 w-64 bg-white border border-[#E2E8F0] rounded-2xl shadow-xl shadow-slate-900/10 overflow-hidden z-[100] animate-dropdown">
                        <!-- User Header -->
                        <div class="px-4 py-3.5 border-b border-[#E2E8F0] bg-[#F8FAFC]">
                            <div class="flex items-center gap-3">
                                @if($hasNavAvatar)
                                    <img src="{{ asset('storage/' . $navAvatar) }}" alt="" class="w-10 h-10 rounded-full object-cover border border-[#E2E8F0] shadow-sm">
                                @else
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-extrabold bg-[#2563EB] shadow-sm">
                                        {{ $navInitial }}
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-[#0F172A] truncate">{{ $navUser?->nama_lengkap ?? 'Customer' }}</p>
                                    <p class="text-[10px] text-[#64748B] font-semibold uppercase tracking-wider">CUSTOMER KOPERASI</p>
                                </div>
                            </div>
                        </div>

                        <!-- Dropdown Actions -->
                        <div class="p-2 space-y-1">
                            <a href="{{ route('customer.profil') }}" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-[#475569] hover:text-[#0F172A] hover:bg-[#F1F5F9] transition-all duration-150">
                                <div class="w-7 h-7 rounded-lg bg-[#EFF6FF] text-[#2563EB] flex items-center justify-center">
                                    <i data-lucide="user" class="w-3.5 h-3.5"></i>
                                </div>
                                <span>Profil Saya</span>
                            </a>

                            <div class="border-t border-[#E2E8F0] my-1"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 transition-all duration-150 text-left">
                                    <div class="w-7 h-7 rounded-lg bg-rose-100/60 text-rose-600 flex items-center justify-center shrink-0">
                                        <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
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