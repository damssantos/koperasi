@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Ringkasan & Monitoring')

@section('content')
    <!-- Page Header Title and Action buttons -->
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 pb-6 border-b border-[#1f243d]">
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
            <a href="{{ route('simpanan') }}?action=new" class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg transition duration-150 text-xs font-bold shadow-md shadow-blue-500/10">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                <span>Transaksi Baru</span>
            </a>
        </div>
    </div>

    <!-- Top Layout Row: Left (1/3) Invoice Card, Right (2/3) Welcome Card -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mt-6">
        
        <!-- Card 1: Total Simpanan Anggota -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-4 flex flex-col justify-between min-h-[220px] relative overflow-hidden group hover:border-[#8f9bb3]/20 transition duration-300">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-blue-500/5 rounded-full blur-xl group-hover:bg-blue-500/10 transition-colors"></div>
            <div class="relative z-10 flex-grow flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-7 h-7 rounded-md flex items-center justify-center shrink-0" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); color: #60a5fa;">
                            <i data-lucide="wallet" class="w-3.5 h-3.5"></i>
                        </div>
                        <p class="text-xs font-semibold text-[#8f9bb3] whitespace-nowrap">Total Simpanan Anggota</p>
                    </div>
                    <h3 class="text-xl font-extrabold text-white">Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</h3>
                    <div class="flex items-center gap-1 text-[10px] text-[#7c83a7] mt-1.5">
                        <i data-lucide="clock" class="w-3 h-3"></i>
                        <span>Update WIB: <span id="current-time-label"></span></span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-[#1f243d] space-y-2">
                    <div class="flex items-center justify-between text-[10px] text-[#8f9bb3]">
                        <div>Pokok: <span class="text-white font-bold">Rp {{ number_format($totalPokok, 0, ',', '.') }}</span></div>
                        <div>Wajib: <span class="text-white font-bold">Rp {{ number_format($totalWajib, 0, ',', '.') }}</span></div>
                        <div>Sukarela: <span class="text-white font-bold">Rp {{ number_format($totalSukarela, 0, ',', '.') }}</span></div>
                    </div>
                    <a href="{{ route('simpanan') }}" class="text-xs font-bold text-[#2f54eb] hover:underline flex items-center gap-1 pt-1">
                        <span>Lihat Rincian Simpanan</span>
                        <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2: Welcome Banner Card -->
        <div class="xl:col-span-2 bg-[#16192b] border border-[#1f243d] rounded-xl p-4 flex flex-col justify-between min-h-[220px] relative overflow-hidden group hover:border-[#8f9bb3]/20 transition duration-300">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-blue-500/5 rounded-full blur-xl group-hover:bg-blue-500/10 transition-colors"></div>
            <div class="relative z-10 flex-grow flex flex-col justify-between">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/5 rounded-full border border-white/10 text-[10px] font-bold tracking-wide">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-white">Sistem Aktif</span>
                    </div>
                    <h3 class="text-lg lg:text-xl font-bold text-white mt-3 tracking-tight">Selamat Datang di Aplikasi Sistem Operasional Koperasi YPIK</h3>
                    <p class="text-[#8f9bb3] text-xs mt-1 max-w-2xl leading-relaxed">Pantau data tabungan, pinjaman berjalan, dan laporan keuangan kas secara real-time dari satu dashboard terpadu.</p>
                </div>

                <div class="grid grid-cols-3 gap-4 mt-4 pt-4 border-t border-[#1f243d]">
                    <div class="bg-[#07080f]/40 border border-[#1f243d] rounded-lg p-3">
                        <span class="text-[9px] font-bold text-[#8f9bb3] uppercase tracking-widest block">Modul Aktif</span>
                        <span class="text-xs lg:text-sm font-extrabold text-white mt-1 block">4 Modul</span>
                    </div>
                    <div class="bg-[#07080f]/40 border border-[#1f243d] rounded-lg p-3">
                        <span class="text-[9px] font-bold text-[#8f9bb3] uppercase tracking-widest block">Data Diperbarui</span>
                        <span class="text-xs lg:text-sm font-extrabold text-white mt-1 block">Otomatis</span>
                    </div>
                    <div class="bg-[#07080f]/40 border border-[#1f243d] rounded-lg p-3">
                        <span class="text-[9px] font-bold text-[#8f9bb3] uppercase tracking-widest block">Status</span>
                        <span class="text-xs lg:text-sm font-bold text-emerald-400 mt-1 block">Online</span>
                    </div>
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
            <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-4 flex flex-col justify-between min-h-[170px] relative overflow-hidden group hover:border-[#8f9bb3]/20 transition duration-300">
                <div class="absolute -top-10 -right-10 w-24 h-24 bg-purple-500/5 rounded-full blur-xl group-hover:bg-purple-500/10 transition-colors"></div>
                <div class="relative z-10 flex-grow flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-7 h-7 rounded-md flex items-center justify-center shrink-0" style="background-color: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.2); color: #c084fc;">
                                <i data-lucide="activity" class="w-3.5 h-3.5"></i>
                            </div>
                            <p class="text-xs font-semibold text-[#8f9bb3] whitespace-nowrap">Total Pinjaman Berjalan</p>
                        </div>
                        <h3 class="text-xl font-extrabold text-white">Rp {{ number_format($totalPinjamanBerjalan, 0, ',', '.') }}</h3>
                        <div class="text-[10px] text-[#7c83a7] mt-1.5">Sisa Tagihan Anggota dari Plafond Rp {{ number_format($totalPlafond, 0, ',', '.') }}</div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-[#1f243d] flex items-center justify-between text-[10px] text-[#8f9bb3]">
                        <div>Sudah Dibayar: <span class="text-white font-bold">Rp {{ number_format($totalPinjamanPaid, 0, ',', '.') }}</span></div>
                        <a href="{{ url('/pinjaman') }}" class="text-[#2f54eb] hover:underline font-bold">Rincian Pinjaman</a>
                    </div>
                </div>
            </div>

            <!-- Card 4: Saldo Kas Koperasi -->
            <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-4 flex flex-col justify-between min-h-[170px] relative overflow-hidden group hover:border-[#8f9bb3]/20 transition duration-300">
                <div class="absolute -top-10 -right-10 w-24 h-24 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/10 transition-colors"></div>
                <div class="relative z-10 flex-grow flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-7 h-7 rounded-md flex items-center justify-center shrink-0" style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399;">
                                <i data-lucide="landmark" class="w-3.5 h-3.5"></i>
                            </div>
                            <p class="text-xs font-semibold text-[#8f9bb3] whitespace-nowrap">Total Saldo Kas Koperasi</p>
                        </div>
                        <h3 class="text-xl font-extrabold text-white">Rp {{ number_format($totalKas, 0, ',', '.') }}</h3>
                        <div class="text-[10px] text-[#7c83a7] mt-1.5">Total likuiditas kas gabungan (Bank &amp; Kas Tunai)</div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-[#1f243d] flex items-center justify-between text-[10px] text-[#8f9bb3]">
                        <div>Di Rekening Bank: <span class="text-white font-bold">Rp {{ number_format($kasBank, 0, ',', '.') }}</span></div>
                        <div>Tunai Pegangan: <span class="text-white font-bold">Rp {{ number_format($kasTunai, 0, ',', '.') }}</span></div>
                    </div>
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
                    <a href="{{ url('/pinjaman') }}" class="text-xs font-semibold text-[#2f54eb] hover:underline">Lihat Semua</a>
                </div>
                <div class="divide-y divide-[#1f243d]">
                    @forelse ($pinjamanMenunggak as $loan)
                    <div class="py-4 flex items-center justify-between hover:bg-[#07080f]/30 px-2 rounded-lg transition-colors gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-orange-500/10 text-orange-400 flex items-center justify-center font-bold text-xs shrink-0">
                                {{ strtoupper(substr($loan->anggota->nama ?? 'A', 0, 2)) }}
                            </div>
                            <div>
                                <p class="font-bold text-white text-sm">{{ $loan->anggota->nama ?? 'N/A' }}</p>
                                <p class="text-[11px] text-[#8f9bb3] mt-0.5">Kontrak: PJ-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }} • Sisa Pinjaman: Rp {{ number_format($loan->sisa_pinjaman, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="inline-block text-[10px] font-bold text-rose-400 bg-rose-400/10 px-2.5 py-1 rounded-lg">Menunggak</span>
                        </div>
                    </div>
                    @empty
                    <div class="py-8 text-center text-xs text-[#8f9bb3]">Tidak ada pinjaman menunggak saat ini.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Cicilan Jatuh Tempo -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-5 flex flex-col justify-between h-full">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-[#1f243d]">
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">Cicilan Jatuh Tempo</h3>
                    <a href="{{ url('/pinjaman') }}" class="text-xs font-semibold text-[#2f54eb] hover:underline">Lihat Semua</a>
                </div>
                <div class="divide-y divide-[#1f243d]">
                    @forelse ($cicilanJatuhTempo as $loan)
                    @php
                        $remainingMonths = $loan->tenor - $loan->jumlah_cicilan_dibayar;
                        $nominalCicilan = $remainingMonths > 0 ? round($loan->sisa_pinjaman / $remainingMonths) : 0;
                        $cicilanKe = $loan->jumlah_cicilan_dibayar + 1;
                    @endphp
                    <div class="py-3.5 flex items-center justify-between hover:bg-[#07080f]/30 px-2 rounded-lg transition-colors gap-4">
                        <div class="flex items-center gap-3.5">
                            <div class="bg-rose-950/40 border border-rose-500/20 text-rose-400 rounded-lg p-2 text-center w-12 shrink-0">
                                <p class="text-[9px] uppercase font-bold tracking-wider">{{ $loan->tanggal_pengajuan->translatedFormat('M') }}</p>
                                <p class="text-base font-extrabold leading-none mt-0.5">{{ $loan->tanggal_pengajuan->format('d') }}</p>
                            </div>
                            <div>
                                <p class="font-bold text-white text-sm">{{ $loan->anggota->nama ?? 'N/A' }}</p>
                                <p class="text-[10px] text-[#8f9bb3] mt-0.5">Kontrak: PJ-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }} • Angsuran ke-{{ $cicilanKe }} dari {{ $loan->tenor }}</p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="font-bold text-white text-sm">Rp {{ number_format($nominalCicilan, 0, ',', '.') }}</p>
                            <p class="text-[9px] font-bold text-orange-400 mt-0.5 uppercase tracking-wide">Hari Ini</p>
                        </div>
                    </div>
                    @empty
                    <div class="py-8 text-center text-xs text-[#8f9bb3]">Tidak ada cicilan jatuh tempo saat ini.</div>
                    @endforelse
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
                    <tr class="border-b border-[#1f243d] text-slate-100 text-[10px] font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-semibold">Waktu</th>
                        <th class="py-3.5 px-4 font-semibold">ID Transaksi</th>
                        <th class="py-3.5 px-4 font-semibold">Jenis Transaksi</th>
                        <th class="py-3.5 px-4 font-semibold">Cara Bayar</th>
                        <th class="py-3.5 px-4 font-semibold">Petugas</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Jumlah Uang</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f243d]">
                    @forelse ($dbTransactions as $tx)
                    @php
                        $isIncome = in_array($tx->jenis_simpanan, ['Pokok', 'Wajib', 'Sukarela']);
                        $dotColor = $isIncome ? 'bg-emerald-500' : 'bg-rose-500';
                        $pulseClass = $isIncome ? 'animate-pulse' : '';
                        $textClass = $isIncome ? 'text-emerald-400' : 'text-rose-400';
                        $sign = $isIncome ? '+' : '-';
                    @endphp
                    <tr class="hover:bg-[#07080f]/30 transition duration-150">
                        <td class="py-4 px-4 text-sm text-slate-400">{{ $tx->tanggal_transaksi->format('d M Y, H:i') }} WIB</td>
                        <td class="py-4 px-4 text-sm text-[#8f9bb3] font-medium">TX-{{ str_pad($tx->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-4 px-4 text-sm">
                            <div class="flex items-center gap-2 text-slate-400">
                                <span class="w-2 h-2 rounded-full {{ $dotColor }} {{ $pulseClass }} shadow-sm shadow-emerald-500/50"></span>
                                <span>Simpanan {{ $tx->jenis_simpanan }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-sm text-[#8f9bb3]">Transfer Bank</td>
                        <td class="py-4 px-4 text-sm text-[#8f9bb3]">Admin Koperasi</td>
                        <td class="py-4 px-4 text-sm font-bold {{ $textClass }} text-right">{{ $sign }} Rp {{ number_format($tx->nominal, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-xs text-[#8f9bb3]">Belum ada transaksi simpanan tercatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
                labels: {!! json_encode($chartData['labels']) !!},
                pemasukan: {!! json_encode($chartData['pemasukan']) !!},
                pengeluaran: {!! json_encode($chartData['pengeluaran']) !!},
                saldo: {!! json_encode($chartData['saldo']) !!}
            },
            tahunan: {
                labels: ['2023', '2024', '2025', '2026'],
                pemasukan: [1800000000, 2400000000, 3200000000, {!! array_sum($chartData['pemasukan']) * 2 !!}],
                pengeluaran: [1200000000, 1500000000, 1900000000, {!! array_sum($chartData['pengeluaran']) * 2 !!}],
                saldo: [600000000, 1500000000, 2800000000, {!! end($chartData['saldo']) !!}]
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
    </script>
@endsection