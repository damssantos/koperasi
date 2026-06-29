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

        <a href="#" onclick="showNotImplementedAlert('Simpanan')" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-[#8f9bb3] hover:text-white hover:bg-[#16192b] transition-all duration-150">
            <i data-lucide="wallet" class="w-4 h-4"></i>
            <span class="font-bold text-xs uppercase tracking-wider">Simpanan</span>
        </a>

        <a href="#" onclick="showNotImplementedAlert('Pinjaman')" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-[#8f9bb3] hover:text-white hover:bg-[#16192b] transition-all duration-150">
            <i data-lucide="hand-coins" class="w-4 h-4"></i>
            <span class="font-bold text-xs uppercase tracking-wider">Pinjaman</span>
        </a>

        <a href="#" onclick="showNotImplementedAlert('Kas Usaha')" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-[#8f9bb3] hover:text-white hover:bg-[#16192b] transition-all duration-150">
            <i data-lucide="briefcase" class="w-4 h-4"></i>
            <span class="font-bold text-xs uppercase tracking-wider">Kas Usaha</span>
        </a>

        <a href="#" onclick="showNotImplementedAlert('Pembukuan')" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-[#8f9bb3] hover:text-white hover:bg-[#16192b] transition-all duration-150">
            <i data-lucide="book-open" class="w-4 h-4"></i>
            <span class="font-bold text-xs uppercase tracking-wider">Pembukuan</span>
        </a>

        <a href="#" onclick="showNotImplementedAlert('Laporan')" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-[#8f9bb3] hover:text-white hover:bg-[#16192b] transition-all duration-150">
            <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
            <span class="font-bold text-xs uppercase tracking-wider">Laporan</span>
        </a>
    </nav>

    <!-- Sidebar Footer logos (Pradita University / SI / Version Web) -->
    <div class="p-4 border-t border-[#1f243d] space-y-3">
    <div class="footer-full flex items-center justify-between pt-1 w-full">
        <span class="text-[10px] font-semibold text-[#8f9bb3] tracking-widest uppercase">VERSI WEB 1.1</span>
        
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="text-xs text-rose-400 hover:text-rose-300 font-semibold cursor-pointer">
                Keluar
            </button>
        </form>
    </div>
    
    <div class="footer-mini hidden text-center">
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="text-rose-400 hover:text-rose-300 w-full flex justify-center cursor-pointer">
                <i data-lucide="log-out" class="w-4 h-4 mx-auto"></i>
            </button>
        </form>
    </div>
</div>
</aside>
