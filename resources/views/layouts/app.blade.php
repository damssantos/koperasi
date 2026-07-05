<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'SOY YPIK PAM JAYA - Ringkasan & Monitoring')</title>

        <!-- Fonts: Plus Jakarta Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <!-- Fallback CDN Tailwind for easy rendering -->
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                            },
                        }
                    }
                }
            </script>
        @endif

        <!-- Chart.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Lucide Icons CDN -->
        <script src="https://unpkg.com/lucide@latest"></script>

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background-color: #0f111a;
            }
            .bg-page {
                background-color: #0f111a;
            }
            .bg-sidebar {
                background-color: #07080f;
            }
            .bg-card {
                background-color: #16192b;
            }
            .border-card {
                border-color: #1f243d;
            }
            .text-muted {
                color: #8f9bb3;
            }
            
            /* Sidebar and container transitions */
            aside {
                transition: width 0.3s ease, transform 0.3s ease;
            }
            #main-container {
                transition: padding-left 0.3s ease;
            }
            
            /* Sidebar collapsed state rules on Desktop */
            @media (min-width: 1024px) {
                .sidebar-collapsed aside {
                    width: 5rem; /* w-20 */
                }
                .sidebar-collapsed #main-container {
                    padding-left: 5rem; /* lg:pl-20 */
                }
                .sidebar-collapsed aside .logo-full {
                    display: none;
                }
                .sidebar-collapsed aside .logo-mini {
                    display: block;
                }
                .sidebar-collapsed aside nav a span {
                    display: none;
                }
                .sidebar-collapsed aside nav a {
                    justify-content: center;
                    padding-left: 0;
                    padding-right: 0;
                }
                .sidebar-collapsed aside .footer-full {
                    display: none;
                }
                .sidebar-collapsed aside .footer-mini {
                    display: block;
                }
                .sidebar-collapsed aside .sidebar-logos {
                    display: none;
                }
            }

            /* Custom scrollbars for a premium dark mode feel */
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
            ::-webkit-scrollbar-track {
                background: #0f111a;
            }
            ::-webkit-scrollbar-thumb {
                background: #1f243d;
                border-radius: 3px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #2b3152;
            }

            /* Profile Dropdown Animation */
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

            /* Fade In Animation */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(-4px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .animate-fade-in {
                animation: fadeIn 0.3s ease-out forwards;
            }

            /* Light Mode CSS Overrides */
            body.light {
                background-color: #f4f6fa;
                color: #1e293b !important;
            }
            body.light header {
                background-color: #ffffff !important;
                border-color: #e2e8f0 !important;
            }
            body.light header span.logo-full,
            body.light header button,
            body.light header button i,
            body.light header button span {
                color: #1e293b !important;
            }
            body.light header button:hover {
                background-color: #f1f5f9 !important;
            }
            body.light aside {
                background-color: #ffffff !important;
                border-color: #e2e8f0 !important;
            }
            body.light aside nav a {
                color: #64748b !important;
            }
            body.light aside nav a:hover {
                background-color: #f1f5f9 !important;
                color: #1e293b !important;
            }
            body.light aside nav a.bg-\[\#2f54eb\] {
                background-color: #2f54eb !important;
                color: #ffffff !important;
            }
            body.light aside .border-t {
                border-color: #e2e8f0 !important;
            }
            body.light aside .footer-full span {
                color: #64748b !important;
            }
            body.light #main-container {
                background-color: #f4f6fa !important;
            }
            body.light main h2,
            body.light main h3,
            body.light main h4,
            body.light main p.text-white,
            body.light main span.text-white {
                color: #1e293b !important;
            }
            /* Welcome card text rules for light mode to keep high contrast */
            body.light main .bg-gradient-to-r h3,
            body.light main .bg-gradient-to-r span,
            body.light main .bg-gradient-to-r p {
                color: #ffffff !important;
            }
            body.light main .bg-gradient-to-r span.text-blue-200 {
                color: #bfdbfe !important;
            }
            body.light main .bg-gradient-to-r span.text-emerald-400 {
                color: #34d399 !important;
            }
            body.light main p.text-blue-100 {
                color: #ffffff !important; /* Keep welcome text white on the gradient card */
            }
            /* General text contrast overrides for light mode */
            body.light .text-slate-300,
            body.light .text-slate-400 {
                color: #475569 !important;
            }
            body.light main .bg-\[\#16192b\],
            body.light main .bg-\[\#16192b\] > div,
            body.light main .bg-card {
                background-color: #ffffff !important;
                border-color: #e2e8f0 !important;
                box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.03), 0 2px 4px -2px rgb(0 0 0 / 0.03) !important;
            }
            body.light main .border-\[\#1f243d\],
            body.light main .border-card {
                border-color: #e2e8f0 !important;
            }
            body.light main .text-muted,
            body.light main .text-\[\#8f9bb3\],
            body.light main .text-\[\#7c83a7\] {
                color: #64748b !important;
            }
            body.light td, 
            body.light th {
                border-color: #e2e8f0 !important;
                color: #1e293b !important;
            }
            body.light td.text-slate-300,
            body.light td.text-\[\#8f9bb3\] {
                color: #475569 !important;
            }
            body.light table thead tr {
                border-color: #e2e8f0 !important;
            }
            body.light tr.hover\:bg-\[\#07080f\]\/30:hover {
                background-color: #f1f5f9 !important;
            }
            body.light .divide-y > div:hover {
                background-color: #f1f5f9 !important;
            }
            body.light .divide-y > div {
                border-color: #e2e8f0 !important;
            }
            body.light .bg-\[\#07080f\],
            body.light .bg-\[\#07080f\]\/40 {
                background-color: #f8fafc !important;
                border-color: #e2e8f0 !important;
            }
            body.light #profileDropdown {
                background-color: #ffffff !important;
                border-color: #e2e8f0 !important;
            }
            body.light #profileDropdown div.bg-\[\#0d0f1a\] {
                background-color: #f8fafc !important;
                border-color: #e2e8f0 !important;
            }
            body.light #profileDropdown p.text-white,
            body.light #profileDropdown span.font-semibold {
                color: #1e293b !important;
            }
            body.light #profileDropdown .bg-\[\#1f243d\] {
                background-color: #f1f5f9 !important;
                color: #64748b !important;
            }
            body.light #profileDropdown button:hover {
                background-color: #f1f5f9 !important;
            }
            body.light #languageSubmenu div.bg-\[\#0d0f1a\] {
                background-color: #ffffff !important;
                border-color: #e2e8f0 !important;
            }
            body.light .bg-blue-500\/5 {
                background-color: rgba(47, 84, 235, 0.05) !important;
                border-color: rgba(47, 84, 235, 0.15) !important;
            }
            body.light .bg-orange-500\/10 {
                background-color: rgba(249, 115, 22, 0.1) !important;
            }
            body.light .bg-rose-500\/10 {
                background-color: rgba(244, 63, 94, 0.1) !important;
            }
            body.light .bg-rose-950\/40 {
                background-color: rgba(244, 63, 94, 0.05) !important;
                border-color: rgba(244, 63, 94, 0.15) !important;
            }
            
            /* Modals & Forms Light Mode */
            body.light #transactionModal > div,
            body.light #memberModal > div {
                background-color: #ffffff !important;
                border-color: #e2e8f0 !important;
            }
            body.light #transactionModal h3,
            body.light #memberModal h3 {
                color: #1e293b !important;
            }
            body.light #transactionModal select,
            body.light #transactionModal input,
            body.light #memberModal select,
            body.light #memberModal input {
                background-color: #f8fafc !important;
                border-color: #cbd5e1 !important;
                color: #1e293b !important;
            }
            body.light #transactionModal select:focus,
            body.light #transactionModal input:focus,
            body.light #memberModal select:focus,
            body.light #memberModal input:focus {
                border-color: #2f54eb !important;
            }
            body.light #transactionModal button[onclick="closeNewTransactionModal()"],
            body.light #memberModal button[onclick="closeNewMemberModal()"] {
                background-color: #f1f5f9 !important;
                border-color: #cbd5e1 !important;
                color: #64748b !important;
            }
            body.light #transactionModal button[onclick="closeNewTransactionModal()"]:hover,
            body.light #memberModal button[onclick="closeNewMemberModal()"]:hover {
                color: #1e293b !important;
            }
        </style>
        @yield('styles')
    </head>
    <body class="h-full text-slate-100 antialiased bg-[#0f111a]">
        <script>
            if (localStorage.getItem('theme') === 'light') {
                document.body.classList.add('light');
            }
        </script>
        <!-- GLOBAL LOADER -->
        <div id="global-loader" class="fixed inset-0 bg-[#07080f] z-[9999] flex flex-col items-center justify-center transition-opacity duration-300">
            <div class="flex flex-col items-center space-y-4">
                <!-- Glowing Spinner ring -->
                <div class="relative w-16 h-16 flex items-center justify-center">
                    <div class="absolute inset-0 border-4 border-white/5 rounded-full"></div>
                    <div class="absolute inset-0 border-4 border-[#2f54eb] border-t-transparent rounded-full animate-spin"></div>
                </div>
                <span class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-widest animate-pulse">Memuat Halaman</span>
            </div>
        </div>

        <!-- MAIN APP CONTENT (Hidden during loader) -->
        <div id="app-content" class="hidden opacity-0 transition-opacity duration-500 ease-in-out">
            <!-- TOP NAVBAR -->
            @include('partials.navbar')

            <div class="flex h-full min-h-screen pt-16">
                
                <!-- SIDEBAR -->
                @if(!Request::routeIs('anggota.show'))
                    @include('partials.sidebar')
                @endif

                <!-- MAIN CONTAINER -->
                <div id="main-container" class="flex-grow flex flex-col min-w-0 {{ Request::routeIs('anggota.show') ? 'lg:pl-0' : 'lg:pl-64' }}">
                    <!-- CONTENT WRAPPER -->
                    <main class="flex-1 p-6 lg:p-8 space-y-8 w-full">
                        @if (session('success'))
                            <div class="rounded-xl px-4 py-3.5 text-xs font-semibold flex items-center gap-2.5 shadow-sm shadow-emerald-500/5 animate-fade-in" style="border: 1px solid rgba(16, 185, 129, 0.15); background-color: rgba(16, 185, 129, 0.05); color: #34d399;">
                                <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400 flex-shrink-0" style="color: #34d399;"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="rounded-xl px-4 py-3.5 text-xs font-semibold flex items-center gap-2.5 shadow-sm shadow-rose-500/5 animate-fade-in" style="border: 1px solid rgba(244, 63, 94, 0.15); background-color: rgba(244, 63, 94, 0.05); color: #fb7185;">
                                <i data-lucide="alert-circle" class="w-4 h-4 text-rose-400 flex-shrink-0" style="color: #fb7185;"></i>
                                <span>{{ $errors->first() }}</span>
                            </div>
                        @endif

                        @yield('content')
                    </main>
                </div>
            </div>
        </div>

        <!-- Common JavaScript -->
        <script>
            // Page Loader handling with 5-second delay
            let loaderTimer;
            function runLoader() {
                const loader = document.getElementById('global-loader');
                const appContent = document.getElementById('app-content');
                if (!loader) return;

                loader.classList.remove('hidden', 'opacity-0');
                if (appContent) {
                    appContent.classList.add('hidden', 'opacity-0');
                }

                // Clear any existing timers
                if (loaderTimer) clearTimeout(loaderTimer);

                // Run spinner for exactly 2 seconds
                loaderTimer = setTimeout(() => {
                    loader.classList.add('opacity-0');
                    if (appContent) {
                        appContent.classList.remove('hidden');
                        // Small delay to allow display block to apply before transitioning opacity
                        setTimeout(() => {
                            appContent.classList.remove('opacity-0');
                            // Notify scripts that the container is now visible and active
                            window.dispatchEvent(new CustomEvent('page-loader-finished'));
                        }, 50);
                    }
                    setTimeout(() => {
                        loader.classList.add('hidden');
                    }, 300);
                }, 2000); // 2 seconds
            }

            // Start loader on initial page load
            window.addEventListener('DOMContentLoaded', runLoader);

            // Show page loader on link navigation click
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
                            loader.offsetHeight; // Force reflow
                            loader.classList.remove('opacity-0');
                        }
                    }
                }
            });

            // Mobile Sidebar Toggle
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('-translate-x-full');
            }

            // Toggle Minimize Sidebar (Desktop Collapse)
            function toggleSidebarCollapse() {
                document.body.classList.toggle('sidebar-collapsed');
                lucide.createIcons();
            }

            // ===== Profile Dropdown Functions =====
            function toggleProfileDropdown() {
                const dropdown = document.getElementById('profileDropdown');
                const chevron = document.getElementById('profileChevron');
                dropdown.classList.toggle('hidden');
                chevron.style.transform = dropdown.classList.contains('hidden') ? '' : 'rotate(180deg)';
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                const dropdown = document.getElementById('profileDropdown');
                const btn = document.getElementById('profileDropdownBtn');
                if (dropdown && btn && !btn.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                    const chevron = document.getElementById('profileChevron');
                    if (chevron) chevron.style.transform = '';
                }
            });

            function updateThemeUI(isLight) {
                const toggle = document.getElementById('darkModeToggle');
                if (!toggle) return;
                const dot = toggle.querySelector('div');
                
                if (isLight) {
                    toggle.classList.remove('bg-[#2f54eb]');
                    toggle.classList.add('bg-[#1f243d]');
                    dot.style.right = 'auto';
                    dot.style.left = '2px';
                } else {
                    toggle.classList.remove('bg-[#1f243d]');
                    toggle.classList.add('bg-[#2f54eb]');
                    dot.style.left = 'auto';
                    dot.style.right = '2px';
                }
            }

            function toggleDarkMode(event) {
                event.stopPropagation();
                document.body.classList.toggle('light');
                const isLight = document.body.classList.contains('light');
                localStorage.setItem('theme', isLight ? 'light' : 'dark');
                updateThemeUI(isLight);
            }

            function toggleLanguageSubmenu(event) {
                event.stopPropagation();
                const submenu = document.getElementById('languageSubmenu');
                submenu.classList.toggle('hidden');
            }

            // Set app language display helper
            function setLanguage(code, name) {
                const badge = document.getElementById('currentLangBadge');
                badge.textContent = code;
                
                document.getElementById('langCheckID').classList.toggle('hidden', code !== 'ID');
                document.getElementById('langCheckEN').classList.toggle('hidden', code !== 'EN');
                
                const buttons = document.getElementById('languageSubmenu').querySelectorAll('button');
                buttons.forEach(btn => {
                    btn.classList.remove('text-white', 'bg-[#2f54eb]/10', 'border-[#2f54eb]');
                    btn.classList.add('text-[#8f9bb3]', 'border-transparent');
                });
                
                const activeBtn = code === 'ID' ? buttons[0] : buttons[1];
                activeBtn.classList.add('text-white', 'bg-[#2f54eb]/10', 'border-[#2f54eb]');
                activeBtn.classList.remove('text-[#8f9bb3]', 'border-transparent');
                
                lucide.createIcons();
                document.getElementById('languageSubmenu').classList.add('hidden');
            }

            // Alert for unimplemented menu items
            function showNotImplementedAlert(menuName) {
                alert(`Halaman untuk menu "${menuName}" sedang dalam tahap pengembangan dan belum tersedia.`);
            }

            // Initialize Lucide Icons
            lucide.createIcons();

            // Apply theme UI switch state on page load
            updateThemeUI(document.body.classList.contains('light'));
        </script>
        @yield('scripts')
    </body>
</html>
