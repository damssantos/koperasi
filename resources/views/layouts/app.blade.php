<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'SOY YPIK PAM JAYA - Panel Admin')</title>

        <!-- Fonts: Plus Jakarta Sans (Matching Customer & Pengawas) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Tailwind CSS CDN (Instant dynamic utility compilation) -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        },
                        colors: {
                            brand: {
                                primary: '#2563EB',
                                primaryHover: '#1D4ED8',
                                secondary: '#0EA5E9',
                                accent: '#10B981',
                                sidebar: '#111524',
                                bg: '#EEF3FB',
                                panel: '#FFFFFF',
                            }
                        }
                    }
                }
            }
        </script>

        <!-- Chart.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Lucide Icons CDN -->
        <script src="https://unpkg.com/lucide@latest"></script>
        <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            body {
                font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
                background-color: #EEF3FB !important;
                color: #0F172A !important;
            }

            /* =========================================
               SIDEBAR (Matching Customer 100%)
               ========================================= */
            .sidebar, aside#sidebar {
                width: 250px !important;
                height: 100vh !important;
                position: fixed !important;
                left: 0 !important;
                top: 0 !important;
                background: #111524 !important;
                color: white !important;
                padding: 22px 16px !important;
                display: flex !important;
                flex-direction: column !important;
                overflow-y: auto !important;
                border-right: 1px solid rgba(255, 255, 255, 0.06) !important;
                z-index: 50 !important;
                transition: transform 0.3s ease !important;
            }

            /* LOGO BRAND */
            .sidebar-brand {
                display: flex !important;
                align-items: center !important;
                gap: 10px !important;
                padding: 4px 6px 20px !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
                margin-bottom: 16px !important;
            }

            .brand-logo-wrapper {
                width: 34px !important;
                height: 34px !important;
                min-width: 34px !important;
                max-width: 34px !important;
                border-radius: 50% !important;
                background: #FFFFFF !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 2px !important;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2) !important;
                overflow: hidden !important;
                flex-shrink: 0 !important;
            }

            .brand-logo-img {
                width: 100% !important;
                height: 100% !important;
                max-width: 30px !important;
                max-height: 30px !important;
                object-fit: contain !important;
                border-radius: 50% !important;
                display: block !important;
            }

            .brand-text {
                font-size: 14px !important;
                font-weight: 800 !important;
                color: #FFFFFF !important;
                letter-spacing: -0.2px !important;
                white-space: nowrap !important;
            }

            /* MENU */
            .menu {
                display: flex !important;
                flex-direction: column !important;
                gap: 4px !important;
            }

            .menu-title {
                color: #64748B !important;
                font-size: 11px !important;
                font-weight: 700 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.8px !important;
                padding: 12px 12px 6px !important;
            }

            .menu a {
                display: flex !important;
                align-items: center !important;
                gap: 12px !important;
                padding: 11px 14px !important;
                border-radius: 12px !important;
                color: #94A3B8 !important;
                text-decoration: none !important;
                font-size: 13.5px !important;
                font-weight: 600 !important;
                transition: all 0.2s ease !important;
            }

            .menu a:hover {
                background: rgba(255, 255, 255, 0.07) !important;
                color: #FFFFFF !important;
            }

            .menu a.active {
                background: #2563EB !important;
                color: #FFFFFF !important;
                font-weight: 700 !important;
                box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4) !important;
            }

            .menu a svg, .menu a i {
                width: 18px !important;
                height: 18px !important;
                flex-shrink: 0 !important;
            }

            /* SIDEBAR BOTTOM */
            .sidebar-bottom {
                margin-top: auto !important;
                padding-top: 16px !important;
                border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
            }

            .logout-button {
                width: 100% !important;
                border: none !important;
                background: transparent !important;
                color: #94A3B8 !important;
                padding: 11px 14px !important;
                border-radius: 12px !important;
                text-align: left !important;
                cursor: pointer !important;
                font-size: 13.5px !important;
                font-weight: 600 !important;
                display: flex !important;
                align-items: center !important;
                gap: 12px !important;
                transition: all 0.2s ease !important;
            }

            .logout-button:hover {
                background: rgba(239, 68, 68, 0.15) !important;
                color: #F87171 !important;
            }

            .logout-button svg, .logout-button i {
                width: 18px !important;
                height: 18px !important;
            }

            .version-tag {
                text-align: center !important;
                margin-top: 14px !important;
                font-size: 11px !important;
                font-weight: 600 !important;
                color: #475569 !important;
                letter-spacing: 0.5px !important;
            }

            /* =========================================
               LAYOUT CONTAINER & NAVBAR
               ========================================= */
            header.top-navbar {
                height: 64px !important;
                background: #FFFFFF !important;
                border-bottom: 1px solid #E2E8F0 !important;
                position: fixed !important;
                top: 0 !important;
                right: 0 !important;
                left: 250px !important;
                z-index: 40 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                padding: 0 24px !important;
                transition: left 0.3s ease !important;
            }

            #main-container {
                margin-left: 250px !important;
                padding-top: 64px !important;
                min-height: 100vh !important;
                background-color: #EEF3FB !important;
                transition: margin-left 0.3s ease !important;
            }

            /* Collapsed Sidebar on Desktop */
            body.sidebar-collapsed .sidebar {
                transform: translateX(-100%) !important;
            }
            body.sidebar-collapsed header.top-navbar {
                left: 0 !important;
            }
            body.sidebar-collapsed #main-container {
                margin-left: 0 !important;
            }

            /* Mobile (< 900px) */
            @media (max-width: 900px) {
                .sidebar {
                    transform: translateX(-100%) !important;
                }
                .sidebar.mobile-open {
                    transform: translateX(0) !important;
                }
                header.top-navbar {
                    left: 0 !important;
                    padding: 0 16px !important;
                }
                #main-container {
                    margin-left: 0 !important;
                }
            }

            /* Backdrop for mobile drawer */
            #sidebarBackdrop {
                position: fixed;
                inset: 0;
                background-color: rgba(15, 23, 42, 0.4);
                backdrop-filter: blur(4px);
                z-index: 45;
                transition: opacity 0.2s ease;
            }

            /* Dropdown Animation */
            @keyframes dropdownIn {
                from {
                    opacity: 0;
                    transform: translateY(-8px) scale(0.96);
                }
                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }
            .animate-dropdown {
                animation: dropdownIn 0.2s ease-out;
            }

            /* =========================================
               CARDS & PANELS (Light Royal Blue Theme)
               ========================================= */
            main .bg-\[\#16192b\],
            main .bg-card,
            .bg-\[\#16192b\]:not(.sidebar *):not(aside *) {
                background-color: var(--panel-bg) !important;
                border: 1px solid var(--border-color) !important;
                border-radius: 16px !important;
                box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03) !important;
            }

            main .bg-\[\#07080f\],
            main .bg-\[\#07080f\]\/40,
            main .bg-\[\#07080f\]\/30,
            main .bg-\[\#0d0f1a\],
            main .bg-\[\#111524\]:not(.sidebar *):not(aside *) {
                background-color: var(--item-bg) !important;
                border-color: var(--border-color) !important;
            }

            main .border-\[\#1f243d\],
            main .border-card,
            main .border-white\/10:not(.sidebar *):not(aside *) {
                border-color: var(--border-color) !important;
            }

            /* Typography */
            main h1, main h2, main h3, main h4 {
                color: var(--text-main) !important;
                letter-spacing: -0.02em;
            }

            main p.text-white,
            main span.text-white,
            main div.text-white,
            main h2.text-white,
            main h3.text-white,
            main td.text-white,
            main th.text-white {
                color: var(--text-main) !important;
            }

            main .text-muted,
            main .text-\[\#8f9bb3\],
            main .text-\[\#7c83a7\],
            main .text-slate-400,
            main .text-slate-300 {
                color: var(--text-muted) !important;
            }

            /* Buttons */
            .bg-\[\#2f54eb\], .bg-\[\#2563eb\] {
                background-color: var(--primary) !important;
                color: #FFFFFF !important;
                border-radius: 10px !important;
                box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25) !important;
                transition: all 0.2s ease !important;
            }
            .bg-\[\#2f54eb\]:hover, .bg-\[\#2563eb\]:hover {
                background-color: var(--primary-hover) !important;
                box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35) !important;
            }
            .bg-\[\#2f54eb\] *, .bg-\[\#2563eb\] * {
                color: #FFFFFF !important;
            }

            /* Secondary outline buttons */
            main a.border-\[\#1f243d\],
            main button.border-\[\#1f243d\],
            main a.bg-\[\#16192b\],
            main button.bg-\[\#16192b\] {
                background-color: var(--panel-bg) !important;
                border: 1px solid var(--border-color) !important;
                color: var(--text-main) !important;
                border-radius: 10px !important;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important;
                transition: all 0.2s ease !important;
            }
            main a.border-\[\#1f243d\]:hover,
            main button.border-\[\#1f243d\]:hover,
            main a.bg-\[\#16192b\]:hover,
            main button.bg-\[\#16192b\]:hover {
                background-color: var(--item-bg) !important;
                color: var(--primary) !important;
                border-color: #BFDBFE !important;
            }

            /* Tables */
            main table {
                background-color: transparent !important;
                width: 100%;
                border-collapse: collapse;
            }
            main table thead {
                background-color: var(--item-bg) !important;
                border-bottom: 1px solid var(--border-color) !important;
            }
            main table thead th {
                background-color: var(--item-bg) !important;
                color: var(--text-muted) !important;
                font-size: 11px !important;
                font-weight: 700 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.6px !important;
                border-bottom: 1px solid var(--border-color) !important;
                padding: 13px 16px !important;
            }
            main table tbody tr {
                background-color: var(--panel-bg) !important;
                border-bottom: 1px solid var(--border-color) !important;
                transition: background-color 0.15s ease;
            }
            main table tbody tr:hover {
                background-color: #F8FAFC !important;
            }
            main table td {
                border-bottom: 1px solid var(--border-color) !important;
                color: var(--text-main) !important;
                padding: 14px 16px !important;
                font-size: 13px !important;
            }

            /* Forms & Inputs */
            main input[type="text"],
            main input[type="number"],
            main input[type="date"],
            main input[type="email"],
            main input[type="password"],
            main input[type="search"],
            main select,
            main textarea {
                background-color: var(--panel-bg) !important;
                border: 1px solid var(--border-color) !important;
                border-radius: 10px !important;
                color: var(--text-main) !important;
                font-size: 13px !important;
                transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
            }
            main input:focus,
            main select:focus,
            main textarea:focus {
                border-color: var(--primary) !important;
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12) !important;
                outline: none !important;
            }

            /* Scrollbar */
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
            ::-webkit-scrollbar-track {
                background: #EEF3FB;
            }
            ::-webkit-scrollbar-thumb {
                background: #CBD5E1;
                border-radius: 3px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #94A3B8;
            }
        </style>
        @yield('styles')
    </head>
    <body class="h-full text-slate-900 antialiased bg-[#EEF3FB]">
        <!-- GLOBAL LOADER (Matching Customer Theme) -->
        <div id="global-loader" class="fixed inset-0 bg-[#EEF3FB] z-[9999] flex flex-col items-center justify-center transition-opacity duration-300">
            <div class="flex flex-col items-center space-y-4">
                <div class="relative w-14 h-14 flex items-center justify-center">
                    <div class="absolute inset-0 border-4 border-blue-200/50 rounded-full"></div>
                    <div class="absolute inset-0 border-4 border-[#2563EB] border-t-transparent rounded-full animate-spin"></div>
                </div>
                <span class="text-[11px] font-bold text-[#64748B] uppercase tracking-widest animate-pulse">Memuat Panel Admin</span>
            </div>
        </div>

        <!-- MAIN APP CONTENT (Hidden during loader) -->
        <div id="app-content" class="hidden opacity-0 transition-opacity duration-300 ease-in-out">
            <!-- TOP NAVBAR -->
            @include('partials.navbar')

            <!-- SIDEBAR -->
            @include('partials.sidebar')

            <!-- MOBILE BACKDROP -->
            <div id="sidebarBackdrop" onclick="toggleSidebar()" class="hidden"></div>

            <!-- MAIN CONTAINER -->
            <div id="main-container" class="flex-grow flex flex-col min-w-0">
                <!-- CONTENT WRAPPER -->
                <main class="flex-1 p-6 lg:p-8 space-y-6 w-full">
                    @if (session('success'))
                        <div class="rounded-xl px-4 py-3.5 text-xs font-semibold flex items-center gap-2.5 shadow-sm bg-emerald-50 border border-emerald-200 text-emerald-800">
                            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="rounded-xl px-4 py-3.5 text-xs font-semibold flex items-center gap-2.5 shadow-sm bg-rose-50 border border-rose-200 text-rose-800">
                            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 flex-shrink-0"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
            @stack('modals')
        </div>

        <!-- Common JavaScript -->
        <script>
            // Page Loader handling
            let loaderTimer;
            function runLoader() {
                const loader = document.getElementById('global-loader');
                const appContent = document.getElementById('app-content');
                if (!loader) return;

                loader.classList.remove('hidden', 'opacity-0');
                if (appContent) {
                    appContent.classList.add('hidden', 'opacity-0');
                }

                if (loaderTimer) clearTimeout(loaderTimer);

                loaderTimer = setTimeout(() => {
                    loader.classList.add('opacity-0');
                    if (appContent) {
                        appContent.classList.remove('hidden');
                        setTimeout(() => {
                            appContent.classList.remove('opacity-0');
                            window.dispatchEvent(new CustomEvent('page-loader-finished'));
                        }, 50);
                    }
                    setTimeout(() => {
                        loader.classList.add('hidden');
                    }, 300);
                }, 400);
            }

            window.addEventListener('DOMContentLoaded', runLoader);

            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (link) {
                    const href = link.getAttribute('href');
                    const target = link.getAttribute('target');
                    
                    if (href && 
                        !href.startsWith('#') && 
                        !href.startsWith('javascript:') && 
                        !link.hasAttribute('onclick') &&
                        target !== '_blank' && 
                        !e.ctrlKey && 
                        !e.metaKey && 
                        !e.shiftKey) {
                        
                        const loader = document.getElementById('global-loader');
                        if (loader) {
                            loader.classList.remove('hidden');
                            loader.offsetHeight;
                            loader.classList.remove('opacity-0');
                        }
                    }
                }
            });

            // Mobile Sidebar Toggle
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const backdrop = document.getElementById('sidebarBackdrop');
                if (sidebar) {
                    sidebar.classList.toggle('mobile-open');
                }
                if (backdrop) {
                    backdrop.classList.toggle('hidden');
                }
            }

            // Desktop Collapse Sidebar
            function toggleSidebarCollapse() {
                document.body.classList.toggle('sidebar-collapsed');
                if (window.lucide) lucide.createIcons();
            }

            // Profile Dropdown
            function toggleProfileDropdown() {
                const dropdown = document.getElementById('profileDropdown');
                const chevron = document.getElementById('profileChevron');
                if (dropdown) {
                    dropdown.classList.toggle('hidden');
                }
                if (chevron) {
                    chevron.style.transform = dropdown.classList.contains('hidden') ? '' : 'rotate(180deg)';
                }
            }

            document.addEventListener('click', function(e) {
                const dropdown = document.getElementById('profileDropdown');
                const btn = document.getElementById('profileDropdownBtn');
                if (dropdown && btn && !btn.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                    const chevron = document.getElementById('profileChevron');
                    if (chevron) chevron.style.transform = '';
                }
            });

            // Logout confirmation with SweetAlert2
            function confirmLogout() {
                Swal.fire({
                    icon: 'warning',
                    title: '<span style="font-size:17px;font-weight:700">Konfirmasi Keluar</span>',
                    html: '<span style="font-size:13px;color:#64748B">Apakah Anda yakin ingin keluar dari akun admin?<br>Sesi login Anda akan diakhiri.</span>',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#94A3B8',
                    width: '360px',
                    customClass: {
                        popup: 'border border-[#E2E8F0] rounded-2xl shadow-xl',
                        confirmButton: 'rounded-xl font-bold text-xs px-4 py-2.5 shadow-sm',
                        cancelButton: 'rounded-xl font-semibold text-xs px-4 py-2.5',
                    },
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById('sidebar-logout-form');
                        if (form) {
                            form.submit();
                        }
                    }
                });
            }

            // Initialize Lucide Icons
            if (window.lucide) {
                lucide.createIcons();
            }
        </script>
        @yield('scripts')
    </body>
</html>
