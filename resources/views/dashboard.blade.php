@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Ringkasan & Monitoring')

@section('content')
    <!-- Page Header Title and Action buttons -->
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Dashboard</h2>
            <p class="text-xs text-[#8f9bb3] mt-0.5">Sistem Operasional Yayasan YPIK - Ringkasan & Monitoring</p>
        </div>
        
        <!-- Action Buttons Group -->
        <div class="flex items-center gap-3">
            <a href="{{ route('simpanan.print') }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-1.5 border border-[#1f243d] rounded-lg bg-[#16192b] text-[#8f9bb3] hover:text-white hover:bg-[#1f243d] transition duration-150 text-xs font-semibold">
                <i data-lucide="download" class="w-3.5 h-3.5"></i>
                <span>Unduh Laporan</span>
            </a>
            <a href="{{ route('simpanan') }}" class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg transition duration-150 text-xs font-bold shadow-md shadow-blue-500/10">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                <span>Transaksi Baru</span>
            </a>
        </div>
    </div>

    <!-- Top Layout Row: Left (1/3) Invoice Card, Right (2/3) Welcome Card -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        
        <!-- Card 1: Total Simpanan Anggota -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-6 flex flex-col justify-between min-h-[220px] relative overflow-hidden group hover:border-[#8f9bb3]/30 transition-all duration-300">
            <div>
                <div class="w-9 h-9 rounded-lg bg-blue-500/10 text-[#2f54eb] flex items-center justify-center mb-4 border border-blue-500/25">
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50"></span>
                    <span class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Total Simpanan Anggota</span>
                </div>
                <h3 class="text-2xl lg:text-3xl font-extrabold text-white mt-2 tracking-tight">Rp 4.524.850.000,00</h3>
                <div class="flex items-center gap-1 text-[10px] text-[#7c83a7] mt-1.5">
                    <i data-lucide="clock" class="w-3 h-3"></i>
                    <span>Update WIB: <span id="current-time-label">24/05/2026 19:59:18</span></span>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-[#1f243d] space-y-2">
                <div class="flex items-center justify-between text-[10px] text-[#8f9bb3]">
                    <div>Pokok: <span class="text-white font-bold">2,10 Miliar</span></div>
                    <div>Wajib: <span class="text-white font-bold">1,50 Miliar</span></div>
                    <div>Sukarela: <span class="text-white font-bold">924 Juta</span></div>
                </div>
                <a href="{{ route('simpanan') }}" class="text-xs font-bold text-[#2f54eb] hover:underline flex items-center gap-1 pt-1">
                    <span>Lihat Rincian Simpanan</span>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                </a>
            </div>
        </div>

        <!-- Card 2: Welcome Banner Card -->
        <div class="xl:col-span-2 bg-gradient-to-r from-[#2f54eb]/95 to-[#1d39c4]/90 border border-blue-500/20 rounded-xl p-6 flex flex-col justify-between min-h-[220px] relative overflow-hidden text-white shadow-xl shadow-blue-500/5">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/10 rounded-full border border-white/20 text-[10px] font-bold tracking-wide">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Sistem Aktif</span>
                </div>
                <h3 class="text-lg lg:text-xl font-bold text-white mt-4 tracking-tight">Selamat Datang di Aplikasi Sistem Operasional Koperasi YPIK</h3>
                <p class="text-blue-100 text-xs mt-1.5 max-w-2xl leading-relaxed">Pantau data tabungan, pinjaman berjalan, dan laporan keuangan kas secara real-time dari satu dashboard terpadu.</p>
            </div>

            <div class="grid grid-cols-3 gap-4 mt-6 pt-4 border-t border-white/10">
                <div class="bg-white/5 border border-white/10 rounded-lg p-3">
                    <span class="text-[9px] font-bold text-blue-200 uppercase tracking-widest block">Modul Aktif</span>
                    <span class="text-sm lg:text-base font-extrabold text-white mt-1 block">4 Modul</span>
                </div>
                <div class="bg-white/5 border border-white/10 rounded-lg p-3">
                    <span class="text-[9px] font-bold text-blue-200 uppercase tracking-widest block">Data Diperbarui</span>
                    <span class="text-sm lg:text-base font-extrabold text-white mt-1 block">Otomatis</span>
                </div>
                <div class="bg-white/5 border border-white/10 rounded-lg p-3">
                    <span class="text-[9px] font-bold text-blue-200 uppercase tracking-widest block">Status</span>
                    <span class="text-sm lg:text-base font-extrabold text-emerald-400 mt-1 block">Online</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Superadmin Tools Section -->
    <div class="space-y-6 pt-2">
        <div class="flex items-center gap-3">
            <i data-lucide="shield" class="w-4 h-4 text-blue-500"></i>
            <h3 class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-widest">Ringkasan Data Kas &amp; Pinjaman</h3>
            <span class="h-px bg-[#1f243d] flex-grow"></span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Card 3: Pinjaman Berjalan -->
            <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-6 flex flex-col justify-between min-h-[170px] relative overflow-hidden group hover:border-[#8f9bb3]/30 transition-all duration-300">
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-purple-400"></span>
                        <span class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Total Pinjaman Berjalan</span>
                    </div>
                    <h3 class="text-2xl font-extrabold text-white mt-2 tracking-tight">Rp 2.842.150.000,00</h3>
                    <div class="text-[10px] text-[#7c83a7] mt-1.5">Sisa Tagihan Anggota dari Plafond Rp 3,20 Miliar</div>
                </div>
                <div class="mt-4 pt-3 border-t border-[#1f243d] flex items-center justify-between text-[10px] text-[#8f9bb3]">
                    <div>Sudah Dibayar: <span class="text-white font-bold">Rp 400 Juta</span></div>
                    <a href="#" onclick="alert('Pinjaman')" class="text-[#2f54eb] hover:underline font-bold">Rincian Pinjaman</a>
                </div>
            </div>

            <!-- Card 4: Saldo Kas Koperasi -->
            <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-6 flex flex-col justify-between min-h-[170px] relative overflow-hidden group hover:border-[#8f9bb3]/30 transition-all duration-300">
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                        <span class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Total Saldo Kas Koperasi</span>
                    </div>
                    <h3 class="text-2xl font-extrabold text-white mt-2 tracking-tight">Rp 1.250.000.000,00</h3>
                    <div class="text-[10px] text-[#7c83a7] mt-1.5">Total likuiditas kas gabungan (Bank &amp; Kas Tunai)</div>
                </div>
                <div class="mt-4 pt-3 border-t border-[#1f243d] flex items-center justify-between text-[10px] text-[#8f9bb3]">
                    <div>Di Rekening Bank: <span class="text-white font-bold">Rp 1,20 Miliar</span></div>
                    <div>Tunai Pegangan: <span class="text-white font-bold">Rp 50 Juta</span></div>
                </div>
            </div>

        </div>
    </div>

    <!-- Cash Flow Chart Section -->
    <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-6">
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
            
            <div class="xl:col-span-3 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-sm font-bold text-white uppercase tracking-wider">Grafik Uang Masuk &amp; Keluar</h3>
                        <div class="flex items-center gap-4 mt-2">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                                <span class="text-xs text-[#8f9bb3]">Uang Masuk</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-400"></span>
                                <span class="text-xs text-[#8f9bb3]">Uang Keluar</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                                <span class="text-xs text-[#8f9bb3]">Sisa Saldo</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="inline-flex p-1 bg-[#07080f] rounded-lg border border-[#1f243d] self-start sm:self-center">
                        <button onclick="changeChartPeriod('mingguan', this)" class="px-3.5 py-1.5 rounded-md text-xs font-semibold transition-all duration-150 text-[#8f9bb3] hover:text-white">Mingguan</button>
                        <button onclick="changeChartPeriod('bulanan', this)" class="px-3.5 py-1.5 rounded-md text-xs font-semibold transition-all duration-150 bg-[#2f54eb] text-white">Bulanan</button>
                        <button onclick="changeChartPeriod('tahunan', this)" class="px-3.5 py-1.5 rounded-md text-xs font-semibold transition-all duration-150 text-[#8f9bb3] hover:text-white">Tahunan</button>
                    </div>
                </div>

                <div class="w-full h-80 relative">
                    <canvas id="cashFlowChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <div class="xl:col-span-1 border-t xl:border-t-0 xl:border-l border-[#1f243d] pt-6 xl:pt-0 xl:pl-6 flex flex-col justify-between space-y-6">
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">Ringkasan Keuangan</h4>
                    <p class="text-[10px] text-[#8f9bb3] mt-1">Ulasan rata-rata aktivitas uang kas.</p>
                    
                    <div class="mt-5 space-y-4">
                        <div class="bg-[#07080f]/40 border border-[#1f243d]/60 rounded-xl p-3.5">
                            <span class="text-[10px] text-[#8f9bb3] font-semibold uppercase tracking-wider block">Rata-rata Uang Masuk</span>
                            <span class="text-sm font-extrabold text-white mt-1 block">Rp 458,3 Juta <span class="text-xs text-emerald-400 font-semibold ml-1">+12%</span></span>
                        </div>

                        <div class="bg-[#07080f]/40 border border-[#1f243d]/60 rounded-xl p-3.5">
                            <span class="text-[10px] text-[#8f9bb3] font-semibold uppercase tracking-wider block">Rata-rata Uang Keluar</span>
                            <span class="text-sm font-extrabold text-white mt-1 block">Rp 165,0 Juta <span class="text-xs text-rose-400 font-semibold ml-1">-4%</span></span>
                        </div>

                        <div class="bg-[#07080f]/40 border border-[#1f243d]/60 rounded-xl p-3.5">
                            <span class="text-[10px] text-[#8f9bb3] font-semibold uppercase tracking-wider block">Kenaikan Saldo Kas</span>
                            <span class="text-sm font-extrabold text-white mt-1 block">+14.2% <span class="text-[10px] text-emerald-400 font-semibold ml-1">Per Tahun</span></span>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-500/5 border border-blue-500/10 rounded-xl p-4 flex items-center gap-3">
                    <i data-lucide="shield-check" class="w-8 h-8 text-blue-400 shrink-0"></i>
                    <div>
                        <p class="text-xs font-bold text-white">Kondisi Keuangan</p>
                        <p class="text-[10px] text-[#8f9bb3] mt-0.5">Uang kas aman &amp; siap tersedia.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Double Column Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">
        
        <!-- Pinjaman Telat Bayar -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-5 flex flex-col justify-between h-full">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-[#1f243d]">
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">Pinjaman Telat Bayar</h3>
                    <a href="#" onclick="alert('Membuka seluruh daftar pinjaman')" class="text-xs font-semibold text-[#2f54eb] hover:underline">Lihat Semua</a>
                </div>
                <div class="divide-y divide-[#1f243d]">
                    <div class="py-4 flex items-center justify-between hover:bg-[#07080f]/30 px-2 rounded-lg transition-colors gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-orange-500/10 text-orange-400 flex items-center justify-center font-bold text-xs shrink-0">BS</div>
                            <div>
                                <p class="font-bold text-white text-sm">Budi Santoso</p>
                                <p class="text-[11px] text-[#8f9bb3] mt-0.5">Kontrak: PJ-2024-089 • Sisa Pinjaman: Rp 2.500.000</p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="inline-block text-[10px] font-bold text-orange-400 bg-orange-400/10 px-2.5 py-1 rounded-lg">Terlambat 15 Hari</span>
                        </div>
                    </div>
                    <div class="py-4 flex items-center justify-between hover:bg-[#07080f]/30 px-2 rounded-lg transition-colors gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-orange-500/10 text-orange-400 flex items-center justify-center font-bold text-xs shrink-0">SA</div>
                            <div>
                                <p class="font-bold text-white text-sm">Siti Aminah</p>
                                <p class="text-[11px] text-[#8f9bb3] mt-0.5">Kontrak: PJ-2024-102 • Sisa Pinjaman: Rp 1.200.000</p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="inline-block text-[10px] font-bold text-orange-400 bg-orange-400/10 px-2.5 py-1 rounded-lg">Terlambat 8 Hari</span>
                        </div>
                    </div>
                    <div class="py-4 flex items-center justify-between hover:bg-[#07080f]/30 px-2 rounded-lg transition-colors gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-rose-500/10 text-rose-400 flex items-center justify-center font-bold text-xs shrink-0">AW</div>
                            <div>
                                <p class="font-bold text-white text-sm">Andi Wijaya</p>
                                <p class="text-[11px] text-[#8f9bb3] mt-0.5">Kontrak: PJ-2024-054 • Sisa Pinjaman: Rp 4.750.000</p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="inline-block text-[10px] font-bold text-rose-400 bg-rose-400/10 px-2.5 py-1 rounded-lg">Terlambat 22 Hari</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cicilan Jatuh Tempo -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-5 flex flex-col justify-between h-full">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-[#1f243d]">
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">Cicilan Jatuh Tempo</h3>
                    <a href="#" onclick="alert('Membuka detail cicilan')" class="text-xs font-semibold text-[#2f54eb] hover:underline">Lihat Semua</a>
                </div>
                <div class="divide-y divide-[#1f243d]">
                    <div class="py-3.5 flex items-center justify-between hover:bg-[#07080f]/30 px-2 rounded-lg transition-colors gap-4">
                        <div class="flex items-center gap-3.5">
                            <div class="bg-rose-950/40 border border-rose-500/20 text-rose-400 rounded-lg p-2 text-center w-12 shrink-0">
                                <p class="text-[9px] uppercase font-bold tracking-wider">Mar</p>
                                <p class="text-base font-extrabold leading-none mt-0.5">12</p>
                            </div>
                            <div>
                                <p class="font-bold text-white text-sm">Rian Hidayat</p>
                                <p class="text-[10px] text-[#8f9bb3] mt-0.5">Kontrak: LN-2024-042 • Angsuran ke-12 dari 24</p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="font-bold text-white text-sm">Rp 1.250.000</p>
                            <p class="text-[9px] font-bold text-orange-400 mt-0.5 uppercase tracking-wide">Hari Ini</p>
                        </div>
                    </div>
                    <div class="py-3.5 flex items-center justify-between hover:bg-[#07080f]/30 px-2 rounded-lg transition-colors gap-4">
                        <div class="flex items-center gap-3.5">
                            <div class="bg-rose-950/40 border border-rose-500/20 text-rose-400 rounded-lg p-2 text-center w-12 shrink-0">
                                <p class="text-[9px] uppercase font-bold tracking-wider">Mar</p>
                                <p class="text-base font-extrabold leading-none mt-0.5">12</p>
                            </div>
                            <div>
                                <p class="font-bold text-white text-sm">Diana Putri</p>
                                <p class="text-[10px] text-[#8f9bb3] mt-0.5">Kontrak: LN-2024-118 • Angsuran ke-5 dari 12</p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="font-bold text-white text-sm">Rp 840.000</p>
                            <p class="text-[9px] font-bold text-orange-400 mt-0.5 uppercase tracking-wide">Hari Ini</p>
                        </div>
                    </div>
                    <div class="py-3.5 flex items-center justify-between hover:bg-[#07080f]/30 px-2 rounded-lg transition-colors gap-4">
                        <div class="flex items-center gap-3.5">
                            <div class="bg-slate-800/40 border border-slate-700/20 text-slate-400 rounded-lg p-2 text-center w-12 shrink-0">
                                <p class="text-[9px] uppercase font-bold tracking-wider">Mar</p>
                                <p class="text-base font-extrabold leading-none mt-0.5">13</p>
                            </div>
                            <div>
                                <p class="font-bold text-white text-sm">Ahmad Faisal</p>
                                <p class="text-[10px] text-[#8f9bb3] mt-0.5">Kontrak: LN-2024-009 • Angsuran ke-20 dari 36</p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="font-bold text-white text-sm">Rp 2.100.000</p>
                            <p class="text-[10px] text-[#8f9bb3] mt-0.5">Besok</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi Terakhir Table Card -->
    <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-6">
        <div class="flex items-center justify-between pb-4 border-b border-[#1f243d]">
            <h3 class="text-xs font-bold text-white uppercase tracking-wider">Transaksi Terakhir</h3>
            <a href="{{ route('simpanan') }}" class="text-xs font-semibold text-[#2f54eb] hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto mt-4">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-[#1f243d] text-[#8f9bb3] text-[10px] font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-semibold">Waktu</th>
                        <th class="py-3.5 px-4 font-semibold">ID Transaksi</th>
                        <th class="py-3.5 px-4 font-semibold">Jenis Transaksi</th>
                        <th class="py-3.5 px-4 font-semibold">Cara Bayar</th>
                        <th class="py-3.5 px-4 font-semibold">Petugas</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Jumlah Uang</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f243d]">
                    <tr class="hover:bg-[#07080f]/30 transition duration-150">
                        <td class="py-4 px-4 text-sm text-slate-300">12 Mar 2024, 09:45 WIB</td>
                        <td class="py-4 px-4 text-sm text-[#8f9bb3] font-medium">TX-120301</td>
                        <td class="py-4 px-4 text-sm">
                            <div class="flex items-center gap-2 text-slate-300">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50 animate-pulse"></span>
                                <span>Tabungan Sukarela</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-sm text-[#8f9bb3]">Transfer Bank</td>
                        <td class="py-4 px-4 text-sm text-[#8f9bb3]">Audy (IT Support)</td>
                        <td class="py-4 px-4 text-sm font-bold text-emerald-400 text-right">+ Rp 500.000</td>
                    </tr>
                    <tr class="hover:bg-[#07080f]/30 transition duration-150">
                        <td class="py-4 px-4 text-sm text-slate-300">12 Mar 2024, 08:30 WIB</td>
                        <td class="py-4 px-4 text-sm text-[#8f9bb3] font-medium">TX-120302</td>
                        <td class="py-4 px-4 text-sm">
                            <div class="flex items-center gap-2 text-slate-300">
                                <span class="w-2 h-2 rounded-full bg-rose-500 shadow-sm shadow-rose-500/50"></span>
                                <span>Pinjaman Keluar</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-sm text-[#8f9bb3]">Transfer Bank</td>
                        <td class="py-4 px-4 text-sm text-[#8f9bb3]">Audy (IT Support)</td>
                        <td class="py-4 px-4 text-sm font-bold text-rose-400 text-right">- Rp 15.000.000</td>
                    </tr>
                    <tr class="hover:bg-[#07080f]/30 transition duration-150">
                        <td class="py-4 px-4 text-sm text-slate-300">11 Mar 2024, 16:20 WIB</td>
                        <td class="py-4 px-4 text-sm text-[#8f9bb3] font-medium">TX-110304</td>
                        <td class="py-4 px-4 text-sm">
                            <div class="flex items-center gap-2 text-slate-300">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50 animate-pulse"></span>
                                <span>Bayar Cicilan</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-sm text-[#8f9bb3]">Tunai</td>
                        <td class="py-4 px-4 text-sm text-[#8f9bb3]">Admin Siti</td>
                        <td class="py-4 px-4 text-sm font-bold text-emerald-400 text-right">+ Rp 1.250.000</td>
                    </tr>
                    <tr class="hover:bg-[#07080f]/30 transition duration-150">
                        <td class="py-4 px-4 text-sm text-slate-300">11 Mar 2024, 14:15 WIB</td>
                        <td class="py-4 px-4 text-sm text-[#8f9bb3] font-medium">TX-110303</td>
                        <td class="py-4 px-4 text-sm">
                            <div class="flex items-center gap-2 text-slate-300">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50 animate-pulse"></span>
                                <span>Tabungan Pokok</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-sm text-[#8f9bb3]">Transfer Bank</td>
                        <td class="py-4 px-4 text-sm text-[#8f9bb3]">Admin Siti</td>
                        <td class="py-4 px-4 text-sm font-bold text-emerald-400 text-right">+ Rp 100.000</td>
                    </tr>
                    <tr class="hover:bg-[#07080f]/30 transition duration-150">
                        <td class="py-4 px-4 text-sm text-slate-300">11 Mar 2024, 10:05 WIB</td>
                        <td class="py-4 px-4 text-sm text-[#8f9bb3] font-medium">TX-110301</td>
                        <td class="py-4 px-4 text-sm">
                            <div class="flex items-center gap-2 text-slate-300">
                                <span class="w-2 h-2 rounded-full bg-rose-500 shadow-sm shadow-rose-500/50"></span>
                                <span>Biaya Operasional</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-sm text-[#8f9bb3]">Tunai</td>
                        <td class="py-4 px-4 text-sm text-[#8f9bb3]">Audy (IT Support)</td>
                        <td class="py-4 px-4 text-sm font-bold text-rose-400 text-right">- Rp 250.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- NEW TRANSACTION MODAL -->
    <div id="transactionModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#07080f]/75 backdrop-blur-sm hidden transition-opacity">
        <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex justify-between items-center border-b border-[#1f243d] pb-3">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Input Transaksi Baru</h3>
                <button onclick="closeNewTransactionModal()" class="text-slate-400 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="transactionForm" onsubmit="submitTransaction(event)" class="space-y-4">
                <div>
                    <label class="block text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider mb-2">Jenis Transaksi</label>
                    <select id="txType" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-sm text-white focus:outline-none focus:border-blue-500">
                        <option value="Tabungan Sukarela">Tabungan Sukarela (+)</option>
                        <option value="Tabungan Pokok">Tabungan Pokok (+)</option>
                        <option value="Bayar Cicilan">Bayar Cicilan (+)</option>
                        <option value="Pinjaman Keluar">Pinjaman Keluar (-)</option>
                        <option value="Biaya Operasional">Biaya Operasional (-)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider mb-2">Cara Bayar</label>
                    <select id="txMethod" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-sm text-white focus:outline-none focus:border-blue-500">
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="VA (Virtual Account)">VA (Virtual Account)</option>
                        <option value="Tunai">Tunai</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider mb-2">Jumlah Uang (Rp)</label>
                    <input type="number" id="txAmount" required placeholder="Contoh: 500000" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-sm text-white placeholder-slate-600 focus:outline-none focus:border-blue-500">
                </div>
                
                <div class="flex items-center gap-3 pt-4 border-t border-[#1f243d] justify-end">
                    <button type="button" onclick="closeNewTransactionModal()" class="px-4 py-2 border border-[#1f243d] rounded-lg bg-[#07080f] text-[#8f9bb3] hover:text-white text-sm font-semibold transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg text-sm font-bold transition-all shadow-lg shadow-blue-500/10">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Set current date in card
        const options = { day: 'numeric', month: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        const today = new Date();
        const formattedDate = today.toLocaleDateString('id-ID', options).replace(/\./g, '/').replace(',', '');
        const timeLabel = document.getElementById('current-time-label');
        if (timeLabel) {
            timeLabel.textContent = formattedDate;
        }

        // Chart Configuration & Setup
        const ctx = document.getElementById('cashFlowChart').getContext('2d');
        
        const chartData = {
            mingguan: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                pemasukan: [1200000, 1900000, 3000000, 2500000, 2200000, 3500000, 4200000],
                pengeluaran: [800000, 1500000, 1200000, 1100000, 1300000, 900000, 1000000],
                saldo: [400000, 800000, 2600000, 4000000, 4900000, 7500000, 10700000]
            },
            bulanan: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                pemasukan: [250000000, 200000000, 450000000, 600000000, 520000000, 700000000],
                pengeluaran: [110000000, 80000000, 150000000, 280000000, 140000000, 190000000],
                saldo: [140000000, 260000000, 560000000, 880000000, 1260000000, 1770000000]
            },
            tahunan: {
                labels: ['2021', '2022', '2023', '2024', '2025', '2026'],
                pemasukan: [1800000000, 2400000000, 3200000000, 4500000000, 5100000000, 6500000000],
                pengeluaran: [1200000000, 1500000000, 1900000000, 2800000000, 3100000000, 3900000000],
                saldo: [600000000, 1500000000, 2800000000, 4500000000, 6500000000, 9100000000]
            }
        };

        let currentPeriod = 'bulanan';

        const gradientBlue = ctx.createLinearGradient(0, 0, 0, 300);
        gradientBlue.addColorStop(0, 'rgba(47, 84, 235, 0.25)');
        gradientBlue.addColorStop(1, 'rgba(47, 84, 235, 0)');

        const gradientRose = ctx.createLinearGradient(0, 0, 0, 300);
        gradientRose.addColorStop(0, 'rgba(244, 63, 94, 0.15)');
        gradientRose.addColorStop(1, 'rgba(244, 63, 94, 0)');

        const gradientEmerald = ctx.createLinearGradient(0, 0, 0, 300);
        gradientEmerald.addColorStop(0, 'rgba(16, 185, 129, 0.15)');
        gradientEmerald.addColorStop(1, 'rgba(16, 185, 129, 0)');

        const cashFlowChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData[currentPeriod].labels,
                datasets: [
                    {
                        label: 'Uang Masuk',
                        data: chartData[currentPeriod].pemasukan,
                        borderColor: '#2f54eb',
                        borderWidth: 3,
                        backgroundColor: gradientBlue,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#2f54eb',
                        pointBorderColor: '#0f111a',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    },
                    {
                        label: 'Uang Keluar',
                        data: chartData[currentPeriod].pengeluaran,
                        borderColor: '#fb7185',
                        borderWidth: 3,
                        backgroundColor: gradientRose,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#fb7185',
                        pointBorderColor: '#0f111a',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    },
                    {
                        label: 'Sisa Saldo',
                        data: chartData[currentPeriod].saldo,
                        borderColor: '#34d399',
                        borderWidth: 3,
                        backgroundColor: gradientEmerald,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#34d399',
                        pointBorderColor: '#0f111a',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        padding: 12,
                        backgroundColor: '#16192b',
                        titleColor: '#8f9bb3',
                        borderColor: '#1f243d',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        grid: { color: '#1f243d', drawTicks: false },
                        ticks: {
                            color: '#8f9bb3',
                            callback: function(value) {
                                if (value >= 1000000000) { return (value / 1000000000).toFixed(1) + ' M'; }
                                if (value >= 1000000) { return (value / 1000000).toFixed(0) + ' Jt'; }
                                return value;
                            }
                        }
                    },
                    x: { grid: { display: false }, ticks: { color: '#8f9bb3' } }
                }
            }
        });

        function changeChartPeriod(period, button) {
            currentPeriod = period;
            const buttons = button.parentNode.querySelectorAll('button');
            buttons.forEach(btn => {
                btn.classList.remove('bg-[#2f54eb]', 'text-white');
                btn.classList.add('text-[#8f9bb3]', 'hover:text-white');
            });
            button.classList.remove('text-[#8f9bb3]', 'hover:text-white');
            button.classList.add('bg-[#2f54eb]', 'text-white');

            cashFlowChart.data.labels = chartData[period].labels;
            cashFlowChart.data.datasets[0].data = chartData[period].pemasukan;
            cashFlowChart.data.datasets[1].data = chartData[period].pengeluaran;
            cashFlowChart.data.datasets[2].data = chartData[period].saldo;
            cashFlowChart.update();
        }

        function openNewTransactionModal() {
            document.getElementById('transactionModal').classList.remove('hidden');
        }

        function closeNewTransactionModal() {
            document.getElementById('transactionModal').classList.add('hidden');
            document.getElementById('transactionForm').reset();
        }

        function submitTransaction(event) {
            event.preventDefault();
            const type = document.getElementById('txType').value;
            const method = document.getElementById('txMethod').value;
            const amount = parseInt(document.getElementById('txAmount').value);

            if (isNaN(amount) || amount <= 0) {
                alert('Nominal transaksi harus valid.');
                return;
            }

            const tbody = document.querySelector('table tbody');
            const now = new Date();
            const timeString = now.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) + `, ${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')} WIB`;
            const formattedAmount = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(amount).replace('Rp', '');
            const randomId = 'TX-' + Math.floor(100000 + Math.random() * 900000);

            const isIncome = ['Tabungan Sukarela', 'Tabungan Pokok', 'Bayar Cicilan'].includes(type);
            const dotColor = isIncome ? 'bg-emerald-500' : 'bg-rose-500';
            const pulseClass = isIncome ? 'animate-pulse' : '';
            const textClass = isIncome ? 'text-emerald-400' : 'text-rose-400';
            const sign = isIncome ? '+' : '-';

            const newRow = document.createElement('tr');
            newRow.className = 'hover:bg-[#07080f]/30 transition duration-150';
            newRow.innerHTML = `
                <td class="py-4 px-4 text-sm text-slate-300">${timeString}</td>
                <td class="py-4 px-4 text-sm text-[#8f9bb3] font-medium">${randomId}</td>
                <td class="py-4 px-4 text-sm">
                    <div class="flex items-center gap-2 text-slate-300">
                        <span class="w-2 h-2 rounded-full ${dotColor} ${pulseClass} shadow-sm"></span>
                        <span>${type}</span>
                    </div>
                </td>
                <td class="py-4 px-4 text-sm text-[#8f9bb3]">${method}</td>
                <td class="py-4 px-4 text-sm text-[#8f9bb3]">Audy (IT Support)</td>
                <td class="py-4 px-4 text-sm font-bold ${textClass} text-right">${sign} Rp ${formattedAmount.trim()}</td>
            `;

            tbody.insertBefore(newRow, tbody.firstChild);
            
            if (isIncome) {
                chartData.bulanan.pemasukan[5] += amount;
                chartData.bulanan.saldo[5] += amount;
            } else {
                chartData.bulanan.pengeluaran[5] += amount;
                chartData.bulanan.saldo[5] -= amount;
            }
            cashFlowChart.update();

            closeNewTransactionModal();
            alert('Transaksi berhasil ditambahkan!');
        }
    </script>
@endsection