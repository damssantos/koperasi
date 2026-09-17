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
            gap: 8px;
            padding: 5px 14px 5px 6px;
            border-radius: 20px;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            font-size: 13px;
            font-weight: 700;
            color: #0F172A;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .user-pill:hover,
        .user-pill.active {
            background: #EFF6FF;
            border-color: #BFDBFE;
            color: #2563EB;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.12);
        }

        .user-avatar-circle {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #2563EB;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .user-role-badge {
            background: #E2E8F0;
            color: #475569;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 6px;
            text-transform: uppercase;
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

        .header-icon-box svg {
            width: 22px;
            height: 22px;
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

                <div class="top-navbar-left"></div>

                <div class="top-navbar-right">
                    <a href="{{ route('customer.profil') }}" class="user-pill {{ request()->routeIs('customer.profil') ? 'active' : '' }}" title="Lihat Profil Saya">
                        <div class="user-avatar-circle">
                            <i data-lucide="user" class="w-3.5 h-3.5"></i>
                        </div>
                        <span>{{ auth()->user()->nama_lengkap }}</span>
                    </a>
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
    </script>

</body>

</html>