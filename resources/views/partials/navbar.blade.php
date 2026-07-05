@php
    $navUser = auth()->user();
    $navAvatar = $navUser?->avatar;
    $hasNavAvatar = $navAvatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($navAvatar);
    $navInitial = strtoupper(substr(trim($navUser?->nama_lengkap ?: 'A'), 0, 1));
@endphp
<!-- TOP NAVBAR (Matching the Mockup Header Bar) -->
<header class="h-16 bg-[#07080f] border-b border-[#1f243d] flex items-center justify-between px-6 w-full fixed top-0 left-0 z-50">
    @if(Request::routeIs('anggota.show'))
        <!-- Left side: Back Arrow, Brand Logo/title matching Detail Anggota -->
        <div class="flex items-center gap-4">
            <a href="{{ route('anggota.index') }}" class="text-[#8f9bb3] hover:text-white transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <span class="text-sm font-bold tracking-wider text-white uppercase block leading-tight">Koperasi Simpan Pinjam</span>
                <span class="text-[9px] font-bold text-[#8f9bb3] uppercase tracking-widest block mt-0.5" style="color: #8f9bb3;">DETAIL ANGGOTA</span>
            </div>
        </div>

        <!-- Right side: Notification, Help, Profile Avatar initials -->
        <div class="flex items-center gap-4">
            <button class="text-[#8f9bb3] hover:text-white transition-colors">
                <i data-lucide="bell" class="w-5 h-5"></i>
            </button>
            <button class="text-[#8f9bb3] hover:text-white transition-colors">
                <i data-lucide="help-circle" class="w-5 h-5"></i>
            </button>
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-md shadow-blue-500/20 bg-[#2f54eb]" style="background-color: #2f54eb;">
                {{ $navInitial }}
            </div>
        </div>
    @else
        <!-- Left side: Brand Logo and Minimize Toggle Button -->
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-3">
                <!-- Logo YPIK PAM JAYA -->
                <div class="w-8 h-8 rounded-full overflow-hidden bg-white flex items-center justify-center shadow-sm">
                    <img src="{{ asset('images/logo-ypik.png') }}" alt="Logo YPIK PAM JAYA" class="w-full h-full object-cover">
                </div>
                <span class="text-sm font-bold tracking-wider text-white uppercase logo-full">SOY YPIK PAM JAYA</span>
                <span class="text-sm font-bold tracking-wider text-blue-500 uppercase logo-mini hidden">YPIK</span>
            </div>
            
            <!-- Desktop Sidebar Collapse Toggle -->
            <button onclick="toggleSidebarCollapse()" class="hidden lg:flex text-slate-400 hover:text-white p-1.5 hover:bg-[#16192b] rounded-lg transition-colors" title="Perkecil Menu">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>
            
            <!-- Mobile Sidebar Toggle -->
            <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-white p-1.5 hover:bg-[#16192b] rounded-lg transition-colors">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>

        <!-- Right side: Profile Dropdown -->
        <div class="flex items-center gap-3 relative">
            <!-- Profile Dropdown Toggle -->
            <button onclick="toggleProfileDropdown()" id="profileDropdownBtn" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg hover:bg-[#16192b] transition-all duration-200 group">
                @if($hasNavAvatar)
                    <img src="{{ asset('storage/' . $navAvatar) }}" alt="" class="w-8 h-8 rounded-full object-cover shadow-md shadow-blue-500/20 border border-[#1f243d]">
                @else
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-md shadow-blue-500/20" style="background: linear-gradient(135deg, #2563eb, #4338ca);">
                        {{ $navInitial }}
                    </div>
                @endif
                <span class="text-xs font-bold text-white hidden sm:block">{{ auth()->user()->nama_lengkap ?? 'User' }}</span>
                <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-[#8f9bb3] group-hover:text-white transition-transform duration-200" id="profileChevron"></i>
            </button>

            <!-- Profile Dropdown Menu -->
            <div id="profileDropdown" class="hidden absolute right-0 top-full mt-2 w-64 bg-[#16192b] border border-[#1f243d] rounded-xl shadow-2xl shadow-black/40 overflow-hidden z-[100] animate-dropdown">
                <!-- User Info Header -->
                <div class="px-4 py-3.5 border-b border-[#1f243d] bg-[#0d0f1a]">
                    <div class="flex items-center gap-3">
                        @if($hasNavAvatar)
                            <img src="{{ asset('storage/' . $navAvatar) }}" alt="" class="w-10 h-10 rounded-full object-cover shadow-lg shadow-blue-500/25 border border-[#1f243d]">
                        @else
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg shadow-blue-500/25" style="background: linear-gradient(135deg, #2563eb, #4338ca);">
                                {{ $navInitial }}
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-bold text-white">{{ auth()->user()->nama_lengkap ?? 'User' }}</p>
                            <p class="text-[10px] text-[#8f9bb3] font-medium">Anggota Koperasi</p>
                        </div>
                    </div>
                </div>

                <!-- Dropdown Items -->
                <div class="py-1.5">
                    <!-- Profil Saya Link -->
                    <a href="{{ url('/profile') }}" class="w-full flex items-center gap-3 px-4 py-2.5 text-xs text-[#8f9bb3] hover:text-white hover:bg-[#1f243d]/60 transition-all duration-150 group">
                        <div class="w-7 h-7 rounded-lg bg-[#1f243d] flex items-center justify-center group-hover:bg-[#2f54eb]/20 transition-colors">
                            <i data-lucide="user" class="w-3.5 h-3.5"></i>
                        </div>
                        <span class="font-semibold">Profil Saya</span>
                    </a>

                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode(event)" class="w-full flex items-center justify-between px-4 py-2.5 text-xs text-[#8f9bb3] hover:text-white hover:bg-[#1f243d]/60 transition-all duration-150 group">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-[#1f243d] flex items-center justify-center group-hover:bg-[#2f54eb]/20 transition-colors">
                                <i data-lucide="moon" class="w-3.5 h-3.5"></i>
                            </div>
                            <span class="font-semibold">Mode Gelap</span>
                        </div>
                        <!-- Toggle Switch -->
                        <div id="darkModeToggle" class="w-8 h-[18px] bg-[#2f54eb] rounded-full relative cursor-pointer transition-colors duration-200">
                            <div class="w-3.5 h-3.5 bg-white rounded-full absolute top-[2px] right-[2px] shadow-sm transition-all duration-200"></div>
                        </div>
                    </button>

                    <!-- Language Selector -->
                    <div class="relative">
                        <button onclick="toggleLanguageSubmenu(event)" class="w-full flex items-center justify-between px-4 py-2.5 text-xs text-[#8f9bb3] hover:text-white hover:bg-[#1f243d]/60 transition-all duration-150 group">
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-lg bg-[#1f243d] flex items-center justify-center group-hover:bg-[#2f54eb]/20 transition-colors">
                                    <i data-lucide="globe" class="w-3.5 h-3.5"></i>
                                </div>
                                <span class="font-semibold">Bahasa</span>
                            </div>
                            <span class="text-[10px] font-bold text-[#2f54eb] bg-[#2f54eb]/10 px-2 py-0.5 rounded-md" id="currentLangBadge">ID</span>
                        </button>
                        <!-- Language Sub-menu -->
                        <div id="languageSubmenu" class="hidden px-4 pb-2">
                            <div class="bg-[#0d0f1a] rounded-lg border border-[#1f243d] overflow-hidden">
                                <button onclick="setLanguage('ID', 'Indonesia')" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs text-white bg-[#2f54eb]/10 border-l-2 border-[#2f54eb] transition-colors">
                                    <span class="font-semibold">🇮🇩</span>
                                    <span class="font-semibold">Indonesia</span>
                                    <i data-lucide="check" class="w-3 h-3 ml-auto text-[#2f54eb]" id="langCheckID"></i>
                                </button>
                                <button onclick="setLanguage('EN', 'English')" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs text-[#8f9bb3] hover:text-white hover:bg-[#1f243d]/60 border-l-2 border-transparent transition-colors">
                                    <span class="font-semibold">🇺🇸</span>
                                    <span class="font-semibold">English</span>
                                    <i data-lucide="check" class="w-3 h-3 ml-auto text-[#2f54eb] hidden" id="langCheckEN"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-[#1f243d] my-1.5"></div>

                    <!-- Logout -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-xs text-rose-400 hover:text-rose-300 hover:bg-rose-500/5 transition-all duration-150 group">
                            <div class="w-7 h-7 rounded-lg bg-[#1f243d] flex items-center justify-center group-hover:bg-rose-500/10 transition-colors">
                                <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                            </div>
                            <span class="font-semibold">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</header>
