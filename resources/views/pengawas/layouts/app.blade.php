<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pengawas') - SOY YPIK PAM JAYA</title>

    <!-- Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
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
                            secondary: '#0EA5E9',
                            accent: '#10B981',
                            sidebar: '#1F2937',
                            bg: '#EEF3FB',
                            panel: '#FFFFFF',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #EEF3FB;
            color: #1F2937;
        }

        /* Sidebar & Container transitions */
        aside {
            transition: transform 0.3s ease, width 0.3s ease;
        }
        #main-container {
            transition: padding-left 0.3s ease;
        }

        /* Custom Scrollbar */
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

        /* Force Lucide icons inside solid blue backgrounds to have white color */
        .bg-\[\#2563EB\] svg, .bg-\[\#2563EB\] i,
        .header-icon-box svg, .header-icon-box i,
        [class*="bg-[#2563EB]"] svg, [class*="bg-[#2563EB]"] i,
        [class*="bg-blue-600"] svg, [class*="bg-blue-600"] i {
            color: #FFFFFF !important;
        }
    </style>
    @stack('styles')
</head>
<body class="h-full antialiased bg-[#EEF3FB] text-[#1F2937]">

    @php
        $navUser = auth()->user();
        $navAvatar = $navUser?->avatar;
        $hasNavAvatar = $navAvatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($navAvatar);
        $navInitial = strtoupper(substr(trim($navUser?->nama_lengkap ?: 'P'), 0, 1));
    @endphp

    <!-- TOP NAVBAR (#FFFFFF) -->
    <header class="h-16 bg-[#FFFFFF] border-b border-[#E5E7EB] flex items-center justify-between px-6 fixed top-0 right-0 left-0 lg:left-64 z-30 shadow-sm">
        
        <!-- Left Side: Mobile Toggle & Brand for Mobile -->
        <div class="flex items-center gap-3">
            <button onclick="toggleSidebar()" class="text-gray-500 hover:text-gray-900 p-2 hover:bg-gray-100 rounded-lg transition-colors" title="Toggle Sidebar">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>
            <div class="flex items-center gap-2.5 lg:hidden">
                <div class="w-7 h-7 rounded-full overflow-hidden bg-white flex items-center justify-center border border-gray-200">
                    <img src="{{ asset('images/logo-ypik.png') }}" alt="Logo YPIK" class="w-full h-full object-cover">
                </div>
                <span class="text-xs font-bold tracking-wider text-gray-900 uppercase">SOY YPIK</span>
            </div>
        </div>

        <!-- Right Side: User Profile -->
        <div class="flex items-center gap-3 relative">

            <!-- Profile Dropdown Button (Matching Admin Pill Design) -->
            <div class="relative">
                <button type="button" onclick="toggleProfileDropdown()" id="profileDropdownBtn" 
                        class="flex items-center gap-2.5 py-1.5 px-3 sm:pr-4 rounded-full bg-[#F8FAFC] border border-[#E2E8F0] hover:bg-[#EFF6FF] hover:border-[#BFDBFE] transition-all duration-200 group cursor-pointer shadow-sm">
                    @if($hasNavAvatar)
                        <img src="{{ asset('storage/' . $navAvatar) }}" alt="" class="w-7 h-7 rounded-full object-cover border border-[#E2E8F0]">
                    @else
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-extrabold bg-[#2563EB] shadow-sm">
                            {{ $navInitial }}
                        </div>
                    @endif

                    <div class="flex flex-col text-left hidden sm:flex">
                        <span class="text-xs font-bold text-[#0F172A] leading-tight group-hover:text-[#2563EB] transition-colors">
                            {{ $navUser?->nama_lengkap ?? 'Pengawas YPIK' }}
                        </span>
                        <span class="text-[9.5px] font-bold text-[#64748B] uppercase tracking-wider">
                            PENGAWAS
                        </span>
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
                                <p class="text-xs font-bold text-[#0F172A] truncate">{{ $navUser?->nama_lengkap ?? 'Pengawas YPIK' }}</p>
                                <p class="text-[10px] text-[#64748B] font-semibold uppercase tracking-wider">PENGAWAS KOPERASI</p>
                            </div>
                        </div>
                    </div>

                    <!-- Dropdown Actions -->
                    <div class="p-2 space-y-1">
                        <button type="button" onclick="confirmLogout()" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 transition-all duration-150 text-left">
                            <div class="w-7 h-7 rounded-lg bg-rose-100/60 text-rose-600 flex items-center justify-center shrink-0">
                                <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                            </div>
                            <span>Keluar Akun</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </header>

    <!-- SIDEBAR (#111524 - Matching Customer Design) -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-[#111524] border-r border-white/[0.06] transition-transform duration-300 -translate-x-full lg:translate-x-0 px-4 py-[22px] overflow-y-auto">
        
        <!-- LOGO BRAND -->
        <div class="flex items-center gap-2.5 pb-6 border-b border-white/[0.08] mb-4.5 shrink-0 px-1.5 pt-1">
            <div class="w-[34px] h-[34px] min-w-[34px] rounded-full bg-white flex items-center justify-center p-[2px] shadow-[0_4px_10px_rgba(0,0,0,0.2)] shrink-0" style="width: 34px; height: 34px; min-width: 34px; max-width: 34px; overflow: hidden;">
                <img src="{{ asset('images/logo-ypik.png') }}" alt="Logo YPIK" class="w-full h-full object-contain rounded-full" style="width: 100%; height: 100%; max-width: 30px; max-height: 30px; object-fit: contain; display: block;">
            </div>
            <span class="text-[14px] font-extrabold text-white tracking-[-0.2px] whitespace-nowrap">SOY YPIK PAM JAYA</span>
        </div>

        <!-- MENU -->
        <nav class="flex-1 flex flex-col gap-1 overflow-y-auto">
            
            <div class="text-[#64748B] text-[11px] font-bold uppercase tracking-[0.8px] px-3 pt-2.5 pb-1.5">
                Menu Utama
            </div>

            <!-- Dashboard -->
            <a href="{{ route('pengawas.dashboard') }}"
                class="flex items-center gap-3 px-3.5 py-[11px] rounded-xl text-[13.5px] transition-all duration-200 {{ request()->routeIs('pengawas.dashboard') ? 'bg-[#2563EB] text-white font-bold shadow-[0_4px_14px_rgba(37,99,235,0.4)]' : 'text-[#94A3B8] font-semibold hover:bg-white/[0.07] hover:text-white' }}">
                <i data-lucide="layout-dashboard" class="w-[18px] h-[18px] shrink-0"></i>
                <span>Dashboard</span>
            </a>

            <!-- Laporan Simpanan -->
            <a href="{{ route('pengawas.laporan.simpanan') }}"
                class="flex items-center gap-3 px-3.5 py-[11px] rounded-xl text-[13.5px] transition-all duration-200 {{ request()->routeIs('pengawas.laporan.simpanan') ? 'bg-[#2563EB] text-white font-bold shadow-[0_4px_14px_rgba(37,99,235,0.4)]' : 'text-[#94A3B8] font-semibold hover:bg-white/[0.07] hover:text-white' }}">
                <i data-lucide="wallet" class="w-[18px] h-[18px] shrink-0"></i>
                <span>Simpanan</span>
            </a>

            <!-- Laporan Pinjaman -->
            <a href="{{ route('pengawas.laporan.pinjaman') }}"
                class="flex items-center gap-3 px-3.5 py-[11px] rounded-xl text-[13.5px] transition-all duration-200 {{ request()->routeIs('pengawas.laporan.pinjaman') ? 'bg-[#2563EB] text-white font-bold shadow-[0_4px_14px_rgba(37,99,235,0.4)]' : 'text-[#94A3B8] font-semibold hover:bg-white/[0.07] hover:text-white' }}">
                <i data-lucide="credit-card" class="w-[18px] h-[18px] shrink-0"></i>
                <span>Pinjaman</span>
            </a>

            <!-- Kas Usaha -->
            <a href="{{ route('pengawas.laporan.kas-usaha') }}"
                class="flex items-center gap-3 px-3.5 py-[11px] rounded-xl text-[13.5px] transition-all duration-200 {{ request()->routeIs('pengawas.laporan.kas-usaha') ? 'bg-[#2563EB] text-white font-bold shadow-[0_4px_14px_rgba(37,99,235,0.4)]' : 'text-[#94A3B8] font-semibold hover:bg-white/[0.07] hover:text-white' }}">
                <i data-lucide="briefcase" class="w-[18px] h-[18px] shrink-0"></i>
                <span>Kas Usaha</span>
            </a>

        </nav>

        <!-- SIDEBAR BOTTOM -->
        <div class="mt-auto pt-4 border-t border-white/[0.08] shrink-0">
            <button type="button" onclick="confirmLogout()" class="w-full flex items-center gap-3 px-3.5 py-[11px] rounded-xl text-[#94A3B8] hover:bg-red-500/15 hover:text-red-400 font-semibold text-[13.5px] transition-all duration-200 text-left">
                <i data-lucide="log-out" class="w-[18px] h-[18px] shrink-0"></i>
                <span>Keluar</span>
            </button>

            <div class="text-center mt-3.5 text-[11px] font-semibold text-[#475569] tracking-[0.5px]">
                Versi Web 1.1
            </div>
        </div>

    </aside>

    <!-- Hidden Logout Form -->
    <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="hidden">
        @csrf
    </form>

    <!-- Backdrop for mobile sidebar -->
    <div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden backdrop-blur-sm transition-opacity"></div>

    <!-- MAIN CONTAINER (#EEF3FB) -->
    <div id="main-container" class="flex-grow flex flex-col min-w-0 lg:pl-64 pt-16 min-h-screen bg-[#EEF3FB]">
        
        <main class="flex-1 p-6 lg:p-8 space-y-6 w-full max-w-7xl mx-auto">
            
            <!-- Success Alert -->
            @if(session('success'))
                <div class="rounded-xl px-4 py-3.5 text-xs font-semibold flex items-center gap-2.5 bg-emerald-50 border border-emerald-200 text-emerald-800 shadow-sm animate-fade-in">
                    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Error Alert -->
            @if(session('error') || (isset($errors) && $errors->any()))
                <div class="rounded-xl px-4 py-3.5 text-xs font-semibold flex items-center gap-2.5 bg-rose-50 border border-rose-200 text-rose-800 shadow-sm animate-fade-in">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 shrink-0"></i>
                    <span>{{ session('error') ?? ($errors->first() ?? '') }}</span>
                </div>
            @endif

            @yield('content')

        </main>

    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar && backdrop) {
                sidebar.classList.toggle('-translate-x-full');
                backdrop.classList.toggle('hidden');
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

        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Keluar',
                text: 'Apakah Anda yakin ingin keluar dari portal Pengawas?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563EB',
                cancelButtonColor: '#9CA3AF',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                background: '#FFFFFF',
                color: '#1F2937',
                customClass: {
                    popup: 'border border-gray-200 shadow-xl rounded-2xl',
                    confirmButton: 'px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider',
                    cancelButton: 'px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>