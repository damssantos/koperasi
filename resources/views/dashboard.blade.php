@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Ringkasan & Monitoring')

@section('content')
    <!-- PAGE HEADER CARD (Matching Customer Design) -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#2563EB] text-white flex items-center justify-center shadow-md shadow-blue-600/25 shrink-0">
                <i data-lucide="layout-dashboard" class="w-6 h-6"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-[#0F172A] tracking-tight">Dashboard Admin</h1>
                <p class="text-xs sm:text-sm text-[#64748B] mt-0.5">Sistem Operasional Yayasan YPIK - Ringkasan & Monitoring</p>
            </div>
        </div>
        
        <!-- Action Buttons Group -->
        <div class="flex items-center gap-3">
            <a href="{{ route('simpanan.print') }}" target="_blank" 
               class="inline-flex items-center gap-2 px-4 py-2 border border-[#E2E8F0] rounded-xl bg-white text-[#0F172A] hover:bg-[#F8FAFC] hover:border-[#CBD5E1] transition duration-150 text-xs font-bold shadow-sm">
                <i data-lucide="download" class="w-3.5 h-3.5 text-[#64748B]"></i>
                <span>Unduh Laporan</span>
            </a>
            <a href="{{ route('simpanan') }}?action=new" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-xl transition duration-150 text-xs font-bold shadow-md shadow-blue-600/25">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                <span>Transaksi Baru</span>
            </a>
        </div>
    </div>

    <!-- STAT CARDS ROW (Matching Customer Portal Cards) -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        
        <!-- Card 1: Total Simpanan Anggota -->
        <div class="bg-white border border-[#E2E8F0] rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between min-h-[220px]">
            <div>
                <div class="flex items-center gap-2.5 mb-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 border border-blue-200/60 text-[#2563EB] flex items-center justify-center shrink-0">
                        <i data-lucide="wallet" class="w-4 h-4"></i>
                    </div>
                    <p class="text-xs font-bold text-[#64748B] uppercase tracking-wider">Total Simpanan Anggota</p>
                </div>
                <h3 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</h3>
                <div class="flex items-center gap-1.5 text-[11px] text-[#64748B] mt-1.5">
                    <i data-lucide="clock" class="w-3.5 h-3.5 text-[#94A3B8]"></i>
                    <span>Pembaruan: <span id="current-time-label"></span></span>
                </div>
            </div>

            <div class="mt-5 pt-4 border-t border-dashed border-[#E2E8F0] space-y-2">
                <div class="flex items-center justify-between text-xs text-[#64748B]">
                    <div>Pokok: <span class="text-[#0F172A] font-bold">Rp {{ number_format($totalPokok, 0, ',', '.') }}</span></div>
                    <div>Wajib: <span class="text-[#0F172A] font-bold">Rp {{ number_format($totalWajib, 0, ',', '.') }}</span></div>
                    <div>Sukarela: <span class="text-[#0F172A] font-bold">Rp {{ number_format($totalSukarela, 0, ',', '.') }}</span></div>
                </div>
                <a href="{{ route('simpanan') }}" class="text-xs font-bold text-[#2563EB] hover:text-[#1D4ED8] inline-flex items-center gap-1 pt-1 group">
                    <span>Lihat Rincian Simpanan</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Card 2: Welcome Banner Card -->
        <div class="xl:col-span-2 bg-white border border-[#E2E8F0] rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between min-h-[220px]">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 rounded-full border border-emerald-200/80 text-[11px] font-bold tracking-wide text-emerald-700">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Sistem Operasional Aktif</span>
                </div>
                <h3 class="text-lg lg:text-xl font-extrabold text-[#0F172A] mt-3 tracking-tight">Selamat Datang di Sistem Operasional Koperasi YPIK</h3>
                <p class="text-[#64748B] text-xs sm:text-sm mt-1 max-w-2xl leading-relaxed">Pantau data tabungan anggota, pinjaman berjalan, dan laporan keuangan kas secara terpadu dan real-time.</p>
            </div>

            <div class="grid grid-cols-3 gap-3 sm:gap-4 mt-5 pt-4 border-t border-dashed border-[#E2E8F0]">
                <div class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-3">
                    <span class="text-[10px] font-bold text-[#64748B] uppercase tracking-wider block">Modul Aktif</span>
                    <span class="text-xs lg:text-sm font-extrabold text-[#0F172A] mt-1 block">4 Modul Utama</span>
                </div>
                <div class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-3">
                    <span class="text-[10px] font-bold text-[#64748B] uppercase tracking-wider block">Pembaruan Data</span>
                    <span class="text-xs lg:text-sm font-extrabold text-[#0F172A] mt-1 block">Otomatis / Realtime</span>
                </div>
                <div class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-3">
                    <span class="text-[10px] font-bold text-[#64748B] uppercase tracking-wider block">Koneksi Layanan</span>
                    <span class="text-xs lg:text-sm font-bold text-emerald-600 mt-1 block flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Online
                    </span>
                </div>
            </div>
        </div>

    </div>

    <!-- Ringkasan Kas & Pinjaman Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Card 3: Pinjaman Berjalan -->
        <div class="bg-white border border-[#E2E8F0] rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between min-h-[170px]">
            <div>
                <div class="flex items-center gap-2.5 mb-2.5">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 border border-purple-200/60 text-purple-600 flex items-center justify-center shrink-0">
                        <i data-lucide="hand-coins" class="w-4 h-4"></i>
                    </div>
                    <p class="text-xs font-bold text-[#64748B] uppercase tracking-wider">Total Pinjaman Berjalan</p>
                </div>
                <h3 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Rp {{ number_format($totalPinjamanBerjalan, 0, ',', '.') }}</h3>
                <div class="text-[11px] text-[#64748B] mt-1.5">Sisa tagihan anggota dari plafond Rp {{ number_format($totalPlafond, 0, ',', '.') }}</div>
            </div>
            <div class="mt-4 pt-3 border-t border-dashed border-[#E2E8F0] flex items-center justify-between text-xs text-[#64748B]">
                <div>Sudah Dibayar: <span class="text-[#0F172A] font-bold">Rp {{ number_format($totalPinjamanPaid, 0, ',', '.') }}</span></div>
                <a href="{{ url('/pinjaman') }}" class="text-[#2563EB] hover:text-[#1D4ED8] font-bold">Rincian Pinjaman &rarr;</a>
            </div>
        </div>

        <!-- Card 4: Saldo Kas Koperasi -->
        <div class="bg-white border border-[#E2E8F0] rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between min-h-[170px]">
            <div>
                <div class="flex items-center gap-2.5 mb-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 border border-emerald-200/60 text-emerald-600 flex items-center justify-center shrink-0">
                        <i data-lucide="landmark" class="w-4 h-4"></i>
                    </div>
                    <p class="text-xs font-bold text-[#64748B] uppercase tracking-wider">Total Saldo Kas Koperasi</p>
                </div>
                <h3 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Rp {{ number_format($totalKas, 0, ',', '.') }}</h3>
                <div class="text-[11px] text-[#64748B] mt-1.5">Total likuiditas kas gabungan (Bank &amp; Kas Tunai)</div>
            </div>
            <div class="mt-4 pt-3 border-t border-dashed border-[#E2E8F0] flex items-center justify-between text-xs text-[#64748B]">
                <div>Rekening Bank: <span class="text-[#0F172A] font-bold">Rp {{ number_format($kasBank, 0, ',', '.') }}</span></div>
                <div>Kas Tunai: <span class="text-[#0F172A] font-bold">Rp {{ number_format($kasTunai, 0, ',', '.') }}</span></div>
            </div>
        </div>

    </div>

    <!-- Cash Flow Chart Section -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-6 shadow-sm">
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
            
            <div class="xl:col-span-3 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-sm font-bold text-[#0F172A] uppercase tracking-wider">Grafik Uang Masuk &amp; Keluar</h3>
                        <div class="flex items-center gap-4 mt-2">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#2563EB]"></span>
                                <span class="text-xs text-[#64748B] font-medium">Uang Masuk</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                                <span class="text-xs text-[#64748B] font-medium">Uang Keluar</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                <span class="text-xs text-[#64748B] font-medium">Sisa Saldo</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="inline-flex p-1 bg-[#F1F5F9] rounded-xl border border-[#E2E8F0] self-start sm:self-center">
                        <button onclick="changeChartPeriod('mingguan', this)" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all duration-150 text-[#64748B] hover:text-[#0F172A]">Mingguan</button>
                        <button onclick="changeChartPeriod('bulanan', this)" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all duration-150 bg-[#2563EB] text-white shadow-sm">Bulanan</button>
                        <button onclick="changeChartPeriod('tahunan', this)" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all duration-150 text-[#64748B] hover:text-[#0F172A]">Tahunan</button>
                    </div>
                </div>

                <div class="w-full h-80 relative">
                    <canvas id="cashFlowChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <div class="xl:col-span-1 border-t xl:border-t-0 xl:border-l border-[#E2E8F0] pt-6 xl:pt-0 xl:pl-6 flex flex-col justify-between space-y-6">
                <div>
                    <h4 class="text-xs font-bold text-[#0F172A] uppercase tracking-wider">Ringkasan Keuangan</h4>
                    <p class="text-[11px] text-[#64748B] mt-1">Ulasan rata-rata aktivitas uang kas.</p>
                    
                    <div class="mt-5 space-y-3.5">
                        <div class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-3.5">
                            <span class="text-[10px] text-[#64748B] font-bold uppercase tracking-wider block">Rata-rata Uang Masuk</span>
                            <span class="text-sm font-extrabold text-[#0F172A] mt-1 block">Rp 458,3 Juta <span class="text-xs text-emerald-600 font-semibold ml-1">+12%</span></span>
                        </div>

                        <div class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-3.5">
                            <span class="text-[10px] text-[#64748B] font-bold uppercase tracking-wider block">Rata-rata Uang Keluar</span>
                            <span class="text-sm font-extrabold text-[#0F172A] mt-1 block">Rp 165,0 Juta <span class="text-xs text-rose-600 font-semibold ml-1">-4%</span></span>
                        </div>

                        <div class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-3.5">
                            <span class="text-[10px] text-[#64748B] font-bold uppercase tracking-wider block">Kenaikan Saldo Kas</span>
                            <span class="text-sm font-extrabold text-[#0F172A] mt-1 block">+14.2% <span class="text-[10px] text-emerald-600 font-semibold ml-1">Per Tahun</span></span>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50/70 border border-blue-200/60 rounded-xl p-4 flex items-center gap-3">
                    <i data-lucide="shield-check" class="w-8 h-8 text-[#2563EB] shrink-0"></i>
                    <div>
                        <p class="text-xs font-bold text-[#0F172A]">Kondisi Keuangan Sehat</p>
                        <p class="text-[10px] text-[#64748B] mt-0.5">Uang kas likuid &amp; siap tersedia.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Double Column Grid (Pinjaman & Cicilan) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">
        
        <!-- Pinjaman Telat Bayar -->
        <div class="bg-white border border-[#E2E8F0] rounded-2xl p-6 shadow-sm flex flex-col justify-between h-full">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-[#E2E8F0]">
                    <h3 class="text-xs font-bold text-[#0F172A] uppercase tracking-wider">Pinjaman Telat Bayar</h3>
                    <a href="{{ url('/pinjaman') }}" class="text-xs font-bold text-[#2563EB] hover:underline">Lihat Semua</a>
                </div>
                <div class="divide-y divide-[#E2E8F0]">
                    @forelse ($pinjamanMenunggak as $loan)
                    <div class="py-3.5 flex items-center justify-between hover:bg-[#F8FAFC] px-2 rounded-xl transition-colors gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center font-extrabold text-xs shrink-0">
                                {{ strtoupper(substr($loan->anggota->nama ?? 'A', 0, 2)) }}
                            </div>
                            <div>
                                <p class="font-bold text-[#0F172A] text-sm">{{ $loan->anggota->nama ?? 'N/A' }}</p>
                                <p class="text-[11px] text-[#64748B] mt-0.5">Kontrak: PJ-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }} • Sisa: Rp {{ number_format($loan->sisa_pinjaman, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="inline-block text-[10px] font-bold text-rose-700 bg-rose-50 border border-rose-200 px-2.5 py-1 rounded-lg">Menunggak</span>
                        </div>
                    </div>
                    @empty
                    <div class="py-8 text-center text-xs text-[#64748B]">Tidak ada pinjaman menunggak saat ini.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Cicilan Jatuh Tempo -->
        <div class="bg-white border border-[#E2E8F0] rounded-2xl p-6 shadow-sm flex flex-col justify-between h-full">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-[#E2E8F0]">
                    <h3 class="text-xs font-bold text-[#0F172A] uppercase tracking-wider">Cicilan Jatuh Tempo</h3>
                    <a href="{{ url('/pinjaman') }}" class="text-xs font-bold text-[#2563EB] hover:underline">Lihat Semua</a>
                </div>
                <div class="divide-y divide-[#E2E8F0]">
                    @forelse ($cicilanJatuhTempo as $loan)
                    @php
                        $remainingMonths = $loan->tenor - $loan->jumlah_cicilan_dibayar;
                        $nominalCicilan = $remainingMonths > 0 ? round($loan->sisa_pinjaman / $remainingMonths) : 0;
                        $cicilanKe = $loan->jumlah_cicilan_dibayar + 1;
                    @endphp
                    <div class="py-3.5 flex items-center justify-between hover:bg-[#F8FAFC] px-2 rounded-xl transition-colors gap-4">
                        <div class="flex items-center gap-3.5">
                            <div class="bg-rose-50 border border-rose-200 text-rose-600 rounded-xl p-2 text-center w-12 shrink-0">
                                <p class="text-[9px] uppercase font-bold tracking-wider">{{ $loan->tanggal_pengajuan->translatedFormat('M') }}</p>
                                <p class="text-base font-extrabold leading-none mt-0.5">{{ $loan->tanggal_pengajuan->format('d') }}</p>
                            </div>
                            <div>
                                <p class="font-bold text-[#0F172A] text-sm">{{ $loan->anggota->nama ?? 'N/A' }}</p>
                                <p class="text-[10px] text-[#64748B] mt-0.5">Kontrak: PJ-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }} • Ke-{{ $cicilanKe }} dari {{ $loan->tenor }}</p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="font-bold text-[#0F172A] text-sm">Rp {{ number_format($nominalCicilan, 0, ',', '.') }}</p>
                            <p class="text-[9px] font-bold text-orange-600 mt-0.5 uppercase tracking-wide">Hari Ini</p>
                        </div>
                    </div>
                    @empty
                    <div class="py-8 text-center text-xs text-[#64748B]">Tidak ada cicilan jatuh tempo saat ini.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi Terakhir Table Card -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-6 shadow-sm">
        <div class="flex items-center justify-between pb-4 border-b border-[#E2E8F0]">
            <h3 class="text-xs font-bold text-[#0F172A] uppercase tracking-wider">Transaksi Terakhir</h3>
            <a href="{{ route('simpanan') }}" class="text-xs font-bold text-[#2563EB] hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto mt-4">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-[#E2E8F0] text-[#64748B] text-[11px] font-bold uppercase tracking-wider bg-[#F8FAFC]">
                        <th class="py-3 px-4">Waktu</th>
                        <th class="py-3 px-4">ID Transaksi</th>
                        <th class="py-3 px-4">Jenis Transaksi</th>
                        <th class="py-3 px-4 text-right">Jumlah Uang</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E8F0]">
                    @forelse ($dbTransactions as $tx)
                    @php
                        $isIncome = in_array($tx->jenis_simpanan, ['Pokok', 'Wajib', 'Sukarela']);
                        $dotColor = $isIncome ? 'bg-emerald-500' : 'bg-rose-500';
                        $pulseClass = $isIncome ? 'animate-pulse' : '';
                        $textClass = $isIncome ? 'text-emerald-600 font-bold' : 'text-rose-600 font-bold';
                        $sign = $isIncome ? '+' : '-';
                    @endphp
                    <tr class="hover:bg-[#F8FAFC] transition duration-150">
                        <td class="py-3.5 px-4 text-xs text-[#64748B] font-medium">{{ $tx->tanggal_transaksi->format('d M Y, H:i') }} WIB</td>
                        <td class="py-3.5 px-4 text-xs text-[#0F172A] font-semibold">TX-{{ str_pad($tx->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-3.5 px-4 text-xs">
                            <div class="flex items-center gap-2 text-[#0F172A]">
                                <span class="w-2 h-2 rounded-full {{ $dotColor }} {{ $pulseClass }}"></span>
                                <span>Simpanan {{ $tx->jenis_simpanan }}</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 text-xs {{ $textClass }} text-right">{{ $sign }} Rp {{ number_format($tx->nominal, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-xs text-[#64748B]">Belum ada transaksi simpanan tercatat.</td>
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
        gradientBlue.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
        gradientBlue.addColorStop(1, 'rgba(37, 99, 235, 0)');

        const gradientRose = ctx.createLinearGradient(0, 0, 0, 300);
        gradientRose.addColorStop(0, 'rgba(239, 68, 68, 0.15)');
        gradientRose.addColorStop(1, 'rgba(239, 68, 68, 0)');

        const gradientEmerald = ctx.createLinearGradient(0, 0, 0, 300);
        gradientEmerald.addColorStop(0, 'rgba(16, 185, 129, 0.15)');
        gradientEmerald.addColorStop(1, 'rgba(16, 185, 129, 0)');

        const gridColor = '#E2E8F0';
        const tickColor = '#64748B';
        const pointBorderColor = '#FFFFFF';

        const cashFlowChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData[currentPeriod].labels,
                datasets: [
                    {
                        label: 'Uang Masuk',
                        data: chartData[currentPeriod].pemasukan,
                        borderColor: '#2563EB',
                        borderWidth: 2.5,
                        backgroundColor: gradientBlue,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#2563EB',
                        pointBorderColor: pointBorderColor,
                        pointBorderWidth: 2,
                        pointRadius: 4.5,
                        pointHoverRadius: 6.5,
                    },
                    {
                        label: 'Uang Keluar',
                        data: chartData[currentPeriod].pengeluaran,
                        borderColor: '#EF4444',
                        borderWidth: 2.5,
                        backgroundColor: gradientRose,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#EF4444',
                        pointBorderColor: pointBorderColor,
                        pointBorderWidth: 2,
                        pointRadius: 4.5,
                        pointHoverRadius: 6.5,
                    },
                    {
                        label: 'Sisa Saldo',
                        data: chartData[currentPeriod].saldo,
                        borderColor: '#10B981',
                        borderWidth: 2.5,
                        backgroundColor: gradientEmerald,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#10B981',
                        pointBorderColor: pointBorderColor,
                        pointBorderWidth: 2,
                        pointRadius: 4.5,
                        pointHoverRadius: 6.5,
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
                        backgroundColor: '#FFFFFF',
                        titleColor: '#0F172A',
                        bodyColor: '#64748B',
                        borderColor: '#E2E8F0',
                        borderWidth: 1,
                        boxShadow: '0 10px 15px -3px rgba(0, 0, 0, 0.1)',
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
                        grid: { color: gridColor, drawTicks: false },
                        ticks: {
                            color: tickColor,
                            font: { family: 'Plus Jakarta Sans', size: 11 },
                            callback: function(value) {
                                if (value >= 1000000000) { return (value / 1000000000).toFixed(1) + ' M'; }
                                if (value >= 1000000) { return (value / 1000000).toFixed(0) + ' Jt'; }
                                return value;
                            }
                        }
                    },
                    x: { 
                        grid: { display: false }, 
                        ticks: { 
                            color: tickColor,
                            font: { family: 'Plus Jakarta Sans', size: 11 }
                        } 
                    }
                }
            }
        });

        function changeChartPeriod(period, button) {
            currentPeriod = period;
            const buttons = button.parentNode.querySelectorAll('button');
            buttons.forEach(btn => {
                btn.classList.remove('bg-[#2563EB]', 'text-white', 'shadow-sm');
                btn.classList.add('text-[#64748B]', 'hover:text-[#0F172A]');
            });
            button.classList.remove('text-[#64748B]', 'hover:text-[#0F172A]');
            button.classList.add('bg-[#2563EB]', 'text-white', 'shadow-sm');

            cashFlowChart.data.labels = chartData[period].labels;
            cashFlowChart.data.datasets[0].data = chartData[period].pemasukan;
            cashFlowChart.data.datasets[1].data = chartData[period].pengeluaran;
            cashFlowChart.data.datasets[2].data = chartData[period].saldo;
            cashFlowChart.update();
        }
    </script>
@endsection