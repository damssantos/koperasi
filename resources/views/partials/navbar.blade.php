@php
    $navUser = auth()->user();
    $navAvatar = $navUser?->avatar;
    $hasNavAvatar = $navAvatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($navAvatar);
    $navInitial = strtoupper(substr(trim($navUser?->nama_lengkap ?: 'A'), 0, 1));
    $userRole = strtoupper($navUser?->role ?: 'ADMIN');
@endphp

<!-- TOP NAVBAR (Matching Customer Design System) -->
<header class="top-navbar h-16 bg-white border-b border-[#E2E8F0] flex items-center justify-between px-4 sm:px-6 fixed top-0 right-0 left-0 lg:left-[250px] z-40 transition-all duration-300">
    
    <!-- Left side: Mobile Brand / Toggles -->
    <div class="flex items-center gap-3">
        <!-- Mobile Sidebar Toggle -->
        <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-[#64748B] hover:text-[#0F172A] hover:bg-[#F1F5F9] transition-colors" title="Buka Menu">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>

        <!-- Mobile Brand Logo & Title -->
        <div class="flex items-center gap-2.5 lg:hidden">
            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center p-1 shadow-sm border border-[#E2E8F0]">
                <img src="{{ asset('images/logo-ypik.png') }}" alt="Logo YPIK" class="w-full h-full object-contain">
            </div>
            <span class="text-xs font-extrabold text-[#0F172A] tracking-tight">SOY YPIK</span>
        </div>

        <!-- Desktop Sidebar Collapse Toggle -->
        <button type="button" onclick="toggleSidebarCollapse()" class="hidden lg:flex p-2 rounded-xl text-[#64748B] hover:text-[#0F172A] hover:bg-[#F1F5F9] transition-colors" title="Sembunyikan/Tampilkan Menu">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>
    </div>

    <!-- Right side: Profile Pill & Dropdown -->
    <div class="flex items-center gap-3 relative">
        <!-- Profile Dropdown Trigger (Matching Customer user-pill) -->
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
                    {{ $navUser?->nama_lengkap ?? 'Administrator' }}
                </span>
                <span class="text-[9.5px] font-bold text-[#64748B] uppercase tracking-wider">
                    {{ $userRole }}
                </span>
            </div>

            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-[#64748B] group-hover:text-[#2563EB] transition-transform duration-200" id="profileChevron"></i>
        </button>

        <!-- Profile Dropdown Menu (Clean Customer Light Style) -->
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
                        <p class="text-xs font-bold text-[#0F172A] truncate">{{ $navUser?->nama_lengkap ?? 'Administrator' }}</p>
                        <p class="text-[10px] text-[#64748B] font-semibold uppercase tracking-wider">{{ $userRole }} Koperasi</p>
                    </div>
                </div>
            </div>

            <!-- Dropdown Actions -->
            <div class="p-2 space-y-1">
                <!-- Profil Saya Link -->
                <a href="{{ url('/profile') }}" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-[#475569] hover:text-[#0F172A] hover:bg-[#F1F5F9] transition-all duration-150">
                    <div class="w-7 h-7 rounded-lg bg-[#EFF6FF] text-[#2563EB] flex items-center justify-center">
                        <i data-lucide="user" class="w-3.5 h-3.5"></i>
                    </div>
                    <span>Profil Saya</span>
                </a>

                <div class="border-t border-[#E2E8F0] my-1"></div>

                <!-- Logout -->
                <button type="button" onclick="confirmLogout()" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 transition-all duration-150 text-left">
                    <div class="w-7 h-7 rounded-lg bg-rose-100/60 text-rose-600 flex items-center justify-center shrink-0">
                        <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                    </div>
                    <span>Keluar Akun</span>
                </button>
            </div>
        </div>
    </div>
</header>
