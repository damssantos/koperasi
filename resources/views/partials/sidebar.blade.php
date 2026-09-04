<!-- SIDEBAR -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-[#07080f] border-r border-[#1f243d] transition-transform duration-300 -translate-x-full lg:translate-x-0 pt-16">
    <!-- Navigation Menu -->
    <nav class="flex-1 space-y-1 px-3 py-6 overflow-y-auto">
        <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->is('dashboard') ? 'bg-[#2f54eb] text-white shadow-md shadow-blue-500/10' : 'text-[#8f9bb3] hover:text-white hover:bg-[#16192b]' }} transition-all duration-150">
            <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
            <span class="font-bold text-xs uppercase tracking-wider">Dashboard</span>
        </a>
        
        <a href="{{ url('/anggota') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->is('anggota') ? 'bg-[#2f54eb] text-white shadow-md shadow-blue-500/10' : 'text-[#8f9bb3] hover:text-white hover:bg-[#16192b]' }} transition-all duration-150">
            <i data-lucide="users" class="w-4 h-4"></i>
            <span class="font-bold text-xs uppercase tracking-wider">Anggota</span>
        </a>

        <a href="{{ url('/simpanan') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->is('simpanan') ? 'bg-[#2f54eb] text-white shadow-md shadow-blue-500/10' : 'text-[#8f9bb3] hover:text-white hover:bg-[#16192b]' }} transition-all duration-150">
            <i data-lucide="wallet" class="w-4 h-4"></i>
            <span class="font-bold text-xs uppercase tracking-wider">Simpanan</span>
        </a>

        <a href="{{ url('/pinjaman') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->is('pinjaman') ? 'bg-[#2f54eb] text-white shadow-md shadow-blue-500/10' : 'text-[#8f9bb3] hover:text-white hover:bg-[#16192b]' }} transition-all duration-150">
            <i data-lucide="hand-coins" class="w-4 h-4"></i>
            <span class="font-bold text-xs uppercase tracking-wider">Pinjaman</span>
        </a>

        <a href="{{ route('kas-usaha') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->is('kas-usaha') ? 'bg-[#2f54eb] text-white shadow-md shadow-blue-500/10' : 'text-[#8f9bb3] hover:text-white hover:bg-[#16192b]' }} transition-all duration-150">
            <i data-lucide="briefcase" class="w-4 h-4"></i>
            <span class="font-bold text-xs uppercase tracking-wider">Kas Usaha</span>
        </a>


        <a href="{{ url('/laporan') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->is('laporan') ? 'bg-[#2f54eb] text-white shadow-md shadow-blue-500/10' : 'text-[#8f9bb3] hover:text-white hover:bg-[#16192b]' }} transition-all duration-150">
            <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
            <span class="font-bold text-xs uppercase tracking-wider">Laporan</span>
        </a>
    </nav>

    <!-- Sidebar Footer: Logout + Version -->
    <div class="p-4 space-y-0">
        <!-- Logout Button (Full) -->
        <div class="footer-full">
            <button type="button" onclick="confirmLogout()" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-[#8f9bb3] hover:text-rose-400 hover:bg-rose-500/5 transition-all duration-150 group">
                <div class="w-7 h-7 rounded-md flex items-center justify-center shrink-0" style="background-color: rgba(244, 63, 94, 0.08); border: 1px solid rgba(244, 63, 94, 0.15); color: #fb7185;">
                    <i data-lucide="log-out" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform duration-150"></i>
                </div>
                <span class="font-bold text-xs uppercase tracking-wider">Keluar</span>
            </button>

            <!-- Divider -->
            <div class="border-t border-[#1f243d] my-2 mx-2"></div>

            <!-- Version Info -->
            <div class="flex items-center justify-center px-4 py-1.5">
                <span class="text-[10px] font-semibold text-[#8f9bb3]/50 tracking-widest uppercase">Versi Web 1.1</span>
            </div>
        </div>

        <!-- Logout Button (Mini / Collapsed) -->
        <div class="footer-mini hidden">
            <button type="button" onclick="confirmLogout()" class="w-full flex justify-center py-2.5 rounded-lg text-[#8f9bb3] hover:text-rose-400 hover:bg-rose-500/5 transition-all duration-150 group">
                <div class="w-7 h-7 rounded-md flex items-center justify-center shrink-0" style="background-color: rgba(244, 63, 94, 0.08); border: 1px solid rgba(244, 63, 94, 0.15); color: #fb7185;">
                    <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                </div>
            </button>
        </div>
    </div>

    <!-- Hidden Logout Form -->
    <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</aside>
