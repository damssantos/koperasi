<!-- SIDEBAR (Matching Customer Design System) -->
<aside id="sidebar" class="sidebar">

    <!-- LOGO BRAND -->
    <div class="sidebar-brand">
        <div class="brand-logo-wrapper" style="width: 34px; height: 34px; min-width: 34px; max-width: 34px; border-radius: 50%; background: #FFFFFF; display: flex; align-items: center; justify-content: center; padding: 2px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); flex-shrink: 0; overflow: hidden;">
            <img src="{{ asset('images/logo-ypik.png') }}" alt="Logo YPIK" class="brand-logo-img" style="width: 100%; height: 100%; max-width: 30px; max-height: 30px; object-fit: contain; border-radius: 50%; display: block;">
        </div>
        <span class="brand-text">SOY YPIK PAM JAYA</span>
    </div>

    <!-- MENU -->
    <nav class="menu">
        <div class="menu-title">
            Menu Utama
        </div>

        <!-- Dashboard -->
        <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
            <i data-lucide="layout-dashboard"></i>
            <span>Dashboard</span>
        </a>

        <!-- Anggota -->
        <a href="{{ url('/anggota') }}" class="{{ request()->is('anggota*') ? 'active' : '' }}">
            <i data-lucide="users"></i>
            <span>Anggota</span>
        </a>

        <!-- Simpanan -->
        <a href="{{ url('/simpanan') }}" class="{{ request()->is('simpanan*') ? 'active' : '' }}">
            <i data-lucide="wallet"></i>
            <span>Simpanan</span>
        </a>

        <!-- Pinjaman -->
        <a href="{{ url('/pinjaman') }}" class="{{ request()->is('pinjaman*') ? 'active' : '' }}">
            <i data-lucide="credit-card"></i>
            <span>Pinjaman</span>
        </a>

        <!-- Kas Usaha -->
        <a href="{{ route('kas-usaha') }}" class="{{ request()->is('kas-usaha*') ? 'active' : '' }}">
            <i data-lucide="briefcase"></i>
            <span>Kas Usaha</span>
        </a>

        <!-- Laporan -->
        <a href="{{ url('/laporan') }}" class="{{ request()->is('laporan*') ? 'active' : '' }}">
            <i data-lucide="bar-chart-3"></i>
            <span>Laporan</span>
        </a>

        <!-- History Aktivitas -->
        <a href="{{ route('activity_logs.index') }}" class="{{ request()->is('history*') ? 'active' : '' }}">
            <i data-lucide="history"></i>
            <span>Riwayat Transaksi</span>
        </a>
    </nav>

    <!-- SIDEBAR BOTTOM -->
    <div class="sidebar-bottom">
        <button type="button" onclick="confirmLogout()" class="logout-button">
            <i data-lucide="log-out"></i>
            <span>Keluar</span>
        </button>

        <div class="version-tag">
            Versi Web 1.1
        </div>
    </div>

    <!-- Hidden Logout Form -->
    <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</aside>