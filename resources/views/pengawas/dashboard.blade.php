@extends('pengawas.layouts.app')

@section('title', 'Dashboard Pengawas')

@section('content')

    <!-- PAGE HEADER CARD (Matching Customer Design) -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#2563EB] text-white flex items-center justify-center shadow-md shadow-blue-600/25 shrink-0">
                <i data-lucide="layout-dashboard" class="w-6 h-6 text-white" stroke="white"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-[#0F172A] tracking-tight">Dashboard Pengawas</h1>
                <p class="text-xs sm:text-sm text-[#64748B] mt-0.5">Monitoring kondisi operasional dan kesehatan keuangan koperasi.</p>
            </div>
        </div>

        <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] shadow-sm text-xs font-bold text-[#0F172A]">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>Akses Audit & View Only</span>
        </div>
    </div>

    <!-- ============================= -->
    <!-- RINGKASAN DATA STATS GRID     -->
    <!-- ============================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- Card 1: Total Anggota -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-blue-300 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#2563EB] shrink-0">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-100 tracking-wider uppercase">ANGGOTA</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-500">Total Anggota</p>
                <h3 class="text-2xl font-extrabold text-gray-900 mt-1 tracking-tight">
                    {{ number_format($totalAnggota, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-gray-500 mt-2 flex items-center gap-1.5">
                    <i data-lucide="check" class="w-3.5 h-3.5 text-[#2563EB]"></i>
                    <span>Seluruh anggota terdaftar</span>
                </p>
            </div>
        </div>

        <!-- Card 2: Total Simpanan -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-emerald-300 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-[#10B981] shrink-0">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-100 tracking-wider uppercase">SIMPANAN</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-500">Total Simpanan</p>
                <h3 class="text-2xl font-extrabold text-gray-900 mt-1 tracking-tight">
                    Rp {{ number_format($totalSimpanan, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-gray-500 mt-2 flex items-center gap-1.5">
                    <i data-lucide="trending-up" class="w-3.5 h-3.5 text-[#10B981]"></i>
                    <span>Total saldo simpanan anggota</span>
                </p>
            </div>
        </div>

        <!-- Card 3: Total Pinjaman Aktif -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-sky-300 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center text-[#0EA5E9] shrink-0">
                    <i data-lucide="hand-coins" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-100 tracking-wider uppercase">OUTSTANDING</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-500">Total Pinjaman Aktif</p>
                <h3 class="text-2xl font-extrabold text-gray-900 mt-1 tracking-tight">
                    Rp {{ number_format($totalPinjamanAktif, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-gray-500 mt-2 flex items-center gap-1.5">
                    <i data-lucide="clock" class="w-3.5 h-3.5 text-[#0EA5E9]"></i>
                    <span>Sisa pinjaman berjalan</span>
                </p>
            </div>
        </div>

        <!-- Card 4: Jumlah Pinjaman Aktif -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-purple-300 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600 shrink-0">
                    <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-100 tracking-wider uppercase">DEBITUR</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-500">Pinjaman Aktif</p>
                <h3 class="text-2xl font-extrabold text-gray-900 mt-1 tracking-tight">
                    {{ number_format($jumlahPinjamanAktif, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-gray-500 mt-2 flex items-center gap-1.5">
                    <i data-lucide="file-text" class="w-3.5 h-3.5 text-purple-600"></i>
                    <span>Pinjaman sedang berjalan</span>
                </p>
            </div>
        </div>

    </div>

    <!-- ============================= -->
    <!-- MENU LAPORAN UTAMA            -->
    <!-- ============================= -->
    <div class="bg-white border border-gray-200/80 rounded-2xl overflow-hidden shadow-sm">
        
        <div class="px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-base font-bold text-gray-900 tracking-tight">Pusat Laporan Koperasi</h3>
                <p class="text-xs text-gray-500 mt-0.5">Pilih modul laporan yang ingin Anda periksa dan analisis.</p>
            </div>
            <span class="text-[11px] font-bold text-[#2563EB] bg-blue-50 border border-blue-100 px-3 py-1 rounded-md self-start sm:self-auto uppercase tracking-wider">
                Monitoring Aktif
            </span>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-5">

            <!-- Card 1: Laporan Simpanan -->
            <a href="{{ route('pengawas.laporan.simpanan') }}"
                class="group bg-[#F8FAFC] border border-gray-200 rounded-xl p-5 hover:border-[#2563EB] hover:bg-white hover:shadow-md transition duration-200 flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#2563EB] mb-4 group-hover:scale-105 transition-transform">
                        <i data-lucide="wallet" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-base group-hover:text-[#2563EB] transition-colors">
                        Laporan Simpanan
                    </h4>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                        Data rincian simpanan pokok, wajib, sukarela, dan total saldo simpanan seluruh anggota.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-200 flex items-center justify-between text-xs font-bold text-[#2563EB] group-hover:translate-x-1 transition-transform">
                    <span>Lihat Laporan</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </div>
            </a>

            <!-- Card 2: Laporan Pinjaman -->
            <a href="{{ route('pengawas.laporan.pinjaman') }}"
                class="group bg-[#F8FAFC] border border-gray-200 rounded-xl p-5 hover:border-[#0EA5E9] hover:bg-white hover:shadow-md transition duration-200 flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center text-[#0EA5E9] mb-4 group-hover:scale-105 transition-transform">
                        <i data-lucide="hand-coins" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-base group-hover:text-[#0EA5E9] transition-colors">
                        Laporan Pinjaman
                    </h4>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                        Data plafon pinjaman, tenor angsuran, cicilan berjalan, sisa pinjaman, dan status kelancaran.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-200 flex items-center justify-between text-xs font-bold text-[#0EA5E9] group-hover:translate-x-1 transition-transform">
                    <span>Lihat Laporan</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </div>
            </a>

            <!-- Card 3: Kas Usaha -->
            <a href="{{ route('pengawas.laporan.kas-usaha') }}"
                class="group bg-[#F8FAFC] border border-gray-200 rounded-xl p-5 hover:border-[#10B981] hover:bg-white hover:shadow-md transition duration-200 flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-[#10B981] mb-4 group-hover:scale-105 transition-transform">
                        <i data-lucide="briefcase" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-base group-hover:text-[#10B981] transition-colors">
                        Kas Usaha
                    </h4>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                        Monitoring mutasi kas operasional: pencatatan penerimaan, pengeluaran, dan saldo kas terkini.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-200 flex items-center justify-between text-xs font-bold text-[#10B981] group-hover:translate-x-1 transition-transform">
                    <span>Lihat Kas Usaha</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </div>
            </a>

        </div>

    </div>

    <!-- ============================= -->
    <!-- INFORMASI AKSES PENGAWAS      -->
    <!-- ============================= -->
    <div class="bg-white border border-gray-200/80 rounded-2xl p-6 shadow-sm flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#2563EB] shrink-0">
            <i data-lucide="shield" class="w-5 h-5"></i>
        </div>
        <div>
            <h4 class="text-sm font-bold text-gray-900 tracking-wide">
                Hak Akses Pengawasan (Audit & Read-Only)
            </h4>
            <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">
                Akun Pengawas memiliki hak akses untuk memantau seluruh transaksi dan rekapitulasi keuangan koperasi secara transparan. Sistem secara otomatis mengunci tindakan penambahan, pengubahan, atau penghapusan data untuk menjaga independensi pengawasan.
            </p>
        </div>
    </div>

@endsection