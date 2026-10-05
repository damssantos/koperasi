@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Detail Anggota')

@section('content')
    @php
        $formatRupiah = fn ($value) => 'Rp ' . number_format((int) $value, 0, ',', '.');
        
        $indonesianMonths = [
            'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
            'April' => 'April', 'May' => 'Mei', 'June' => 'Juni',
            'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September',
            'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
        ];
        $shortIndonesianMonths = [
            'Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Apr',
            'May' => 'Mei', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Agu',
            'Sep' => 'Sep', 'Oct' => 'Okt', 'Nov' => 'Nov', 'Dec' => 'Des'
        ];

        $dateObj = optional($anggota->tanggal_join ?? $anggota->created_at);
        $formattedDate = $dateObj ? $dateObj->format('d') . ' ' . ($indonesianMonths[$dateObj->format('F')] ?? $dateObj->format('F')) . ' ' . $dateObj->format('Y') : '-';
        $shortFormattedDate = $dateObj ? $dateObj->format('d') . ' ' . ($shortIndonesianMonths[$dateObj->format('M')] ?? $dateObj->format('M')) . ' ' . $dateObj->format('Y') : '-';
    @endphp

    <!-- PAGE HEADER CARD (Matching Customer Design) -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#2563EB] text-white flex items-center justify-center shadow-md shadow-blue-600/25 shrink-0">
                <i data-lucide="user-check" class="w-6 h-6 text-white" stroke="white"></i>
            </div>
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-xl sm:text-2xl font-extrabold text-[#0F172A] tracking-tight">{{ $anggota->nama }}</h1>
                    <span class="bg-blue-50 border border-blue-100 text-[#2563EB] text-xs font-extrabold px-2.5 py-1 rounded-md">
                        {{ $anggota->id_anggota ?? 'AGT-' . str_pad($anggota->id, 3, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-[#64748B] mt-0.5">Rincian data keanggotaan, simpanan, dan riwayat transaksi.</p>
            </div>
        </div>

        <a href="{{ route('anggota.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-[#E2E8F0] rounded-xl bg-white text-[#0F172A] hover:bg-[#F8FAFC] transition duration-150 text-xs font-bold shadow-sm">
            <i data-lucide="arrow-left" class="w-4 h-4 text-[#64748B]"></i>
            <span>Kembali ke Daftar Anggota</span>
        </a>
    </div>

    <!-- First Section: 3 Stat Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Total Simpanan -->
        <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 shadow-sm flex flex-col justify-between h-[135px] hover:shadow-md transition-shadow">
            <div class="flex justify-between items-center">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#2563EB]">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-[#64748B] uppercase tracking-wider">Total Simpanan</span>
            </div>
            <div>
                <h3 class="text-2xl font-extrabold text-[#0F172A]">{{ $formatRupiah($anggota->total_saldo ?: ($anggota->simpanan_pokok + $anggota->simpanan_wajib + $anggota->simpanan_sukarela)) }}</h3>
            </div>
        </div>

        <!-- Card 2: Pinjaman Aktif -->
        <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 shadow-sm flex flex-col justify-between h-[135px] hover:shadow-md transition-shadow">
            <div class="flex justify-between items-center">
                <div class="w-10 h-10 rounded-xl bg-orange-50 border border-orange-100 flex items-center justify-center text-orange-600">
                    <i data-lucide="hand-coins" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-[#64748B] uppercase tracking-wider">Pinjaman Aktif</span>
            </div>
            <div>
                <h3 class="text-2xl font-extrabold text-[#0F172A]">Rp 0</h3>
                <p class="text-[11px] text-[#64748B] font-semibold mt-0.5">0 Kontrak Berjalan</p>
            </div>
        </div>

        <!-- Card 3: Sisa Cicilan -->
        <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 shadow-sm flex flex-col justify-between h-[135px] hover:shadow-md transition-shadow">
            <div class="flex justify-between items-center">
                <div class="w-10 h-10 rounded-xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600">
                    <i data-lucide="history" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-[#64748B] uppercase tracking-wider">Sisa Cicilan</span>
            </div>
            <div>
                <h3 class="text-2xl font-extrabold text-[#0F172A]">Rp 0</h3>
                <p class="text-[11px] text-[#64748B] font-semibold mt-0.5">Jatuh tempo: -</p>
            </div>
        </div>
    </div>

    <!-- Second Section: Informasi Anggota Card -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-6 shadow-sm mt-6">
        <div class="flex items-center gap-2.5 border-b border-[#E2E8F0] pb-4 mb-6">
            <i data-lucide="user" class="w-4 h-4 text-[#2563EB]"></i>
            <h3 class="text-sm font-bold text-[#0F172A] tracking-wide">Informasi Profil Anggota</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-4">
                <div>
                    <p class="text-[10px] font-bold text-[#64748B] uppercase tracking-wider">ID Anggota</p>
                    <p class="text-sm font-extrabold text-[#0F172A] mt-1">{{ $anggota->id_anggota ?? 'AGT-' . str_pad($anggota->id, 3, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-[#64748B] uppercase tracking-wider">Nomor HP</p>
                    <p class="text-sm font-semibold text-[#0F172A] mt-1">{{ $anggota->no_hp ?? '-' }}</p>
                </div>
            </div>
            <div class="space-y-4">
                <div>
                    <p class="text-[10px] font-bold text-[#64748B] uppercase tracking-wider">Nama Lengkap</p>
                    <p class="text-sm font-extrabold text-[#0F172A] mt-1">{{ $anggota->nama }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-[#64748B] uppercase tracking-wider">Tanggal Bergabung</p>
                    <p class="text-sm font-semibold text-[#0F172A] mt-1">{{ $formattedDate }}</p>
                </div>
            </div>
            <div class="space-y-4">
                <div>
                    <p class="text-[10px] font-bold text-[#64748B] uppercase tracking-wider">No. Rekening / Bank</p>
                    <p class="text-sm font-semibold text-[#0F172A] mt-1">
                        @if(optional($anggota->user)->no_rekening)
                            {{ $anggota->user->nama_bank ? $anggota->user->nama_bank . ' - ' : '' }}{{ $anggota->user->no_rekening }}
                        @else
                            -
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Third Section: Tabs and Table Card -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-6 shadow-sm mt-6">
        <!-- Tabs Header -->
        <div class="flex border-b border-[#E2E8F0] mb-6 gap-2">
            <button id="tab-btn-simpanan" class="px-5 py-2.5 border-b-2 border-[#2563EB] text-xs font-extrabold text-[#2563EB] cursor-pointer" onclick="switchTab('simpanan')">Simpanan</button>
            <button id="tab-btn-pinjaman" class="px-5 py-2.5 border-b-2 border-transparent text-xs font-semibold text-[#64748B] hover:text-[#0F172A] cursor-pointer" onclick="switchTab('pinjaman')">Pinjaman</button>
            <button id="tab-btn-riwayat" class="px-5 py-2.5 border-b-2 border-transparent text-xs font-semibold text-[#64748B] hover:text-[#0F172A] cursor-pointer" onclick="switchTab('riwayat')">Riwayat</button>
        </div>
        
        <!-- Tab Content: Simpanan (Active) -->
        <div id="tab-content-simpanan">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse table-fixed">
                    <thead>
                        <tr class="border-b border-[#E2E8F0] bg-[#F8FAFC] text-[#64748B] text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-3.5 px-4 font-bold w-[25%]">Tanggal</th>
                            <th class="py-3.5 px-4 font-bold w-[35%]">Jenis Simpanan</th>
                            <th class="py-3.5 px-4 font-bold w-[25%]">Nominal</th>
                            <th class="py-3.5 px-4 font-bold text-center w-[15%]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E2E8F0]">
                        @forelse($anggota->transactions as $tx)
                            @php
                                $txDate = optional($tx->tanggal_transaksi ?? $tx->created_at);
                                $formattedTxDate = $txDate ? $txDate->format('d') . ' ' . ($shortIndonesianMonths[$txDate->format('M')] ?? $txDate->format('M')) . ' ' . $txDate->format('Y') : '-';
                            @endphp
                            <tr class="hover:bg-[#F8FAFC] transition duration-150">
                                <td class="py-4 px-4 text-xs text-[#64748B] w-[25%]">{{ $formattedTxDate }}</td>
                                <td class="py-4 px-4 text-xs w-[35%]">
                                    @if($tx->jenis_simpanan === 'Pokok')
                                        <span class="inline-flex px-2.5 py-1 text-[10px] font-bold tracking-wide rounded-full bg-blue-50 text-[#2563EB] border border-blue-100">Simpanan Pokok</span>
                                    @elseif($tx->jenis_simpanan === 'Wajib')
                                        <span class="inline-flex px-2.5 py-1 text-[10px] font-bold tracking-wide rounded-full bg-purple-50 text-purple-600 border border-purple-100">Simpanan Wajib</span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 text-[10px] font-bold tracking-wide rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100">Simpanan Sukarela</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-xs font-extrabold text-[#0F172A] w-[25%]">{{ $formatRupiah($tx->nominal) }}</td>
                                <td class="py-4 px-4 text-center w-[15%]">
                                    <div class="flex items-center justify-center">
                                        <button onclick='showSimpananDetail(@json($tx))' class="w-8 h-8 rounded-lg bg-blue-50 text-[#2563EB] border border-blue-100 flex items-center justify-center hover:bg-[#2563EB] hover:text-white transition-all duration-150 cursor-pointer" title="Detail Simpanan">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-xs text-[#64748B]">Belum ada transaksi simpanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Tab Content: Pinjaman -->
        <div id="tab-content-pinjaman" class="hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse table-fixed">
                    <thead>
                        <tr class="border-b border-[#E2E8F0] bg-[#F8FAFC] text-[#64748B] text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-3.5 px-4 font-bold w-[20%]">Tanggal</th>
                            <th class="py-3.5 px-4 font-bold w-[20%]">Nominal</th>
                            <th class="py-3.5 px-4 font-bold w-[15%]">Tenor</th>
                            <th class="py-3.5 px-4 font-bold w-[20%]">Sisa Pinjaman</th>
                            <th class="py-3.5 px-4 font-bold text-center w-[15%]">Status</th>
                            <th class="py-3.5 px-4 font-bold text-center w-[10%]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E2E8F0] text-xs text-[#0F172A]">
                        @forelse($anggota->pinjaman as $loan)
                            @php
                                $statusClass = '';
                                if ($loan->status === 'Lunas') {
                                    $statusClass = 'bg-emerald-50 text-emerald-600 border-emerald-200';
                                } elseif ($loan->status === 'Menunggak') {
                                    $statusClass = 'bg-rose-50 text-rose-600 border-rose-200';
                                } else {
                                    $statusClass = 'bg-blue-50 text-[#2563EB] border-blue-200';
                                }
                            @endphp
                            <tr class="hover:bg-[#F8FAFC] transition duration-150">
                                <td class="py-3 px-4 text-[#64748B] w-[20%]">{{ $loan->tanggal_pengajuan->format('d M Y') }}</td>
                                <td class="py-3 px-4 font-bold w-[20%]">Rp {{ number_format($loan->nominal_pinjaman, 0, ',', '.') }}</td>
                                <td class="py-3 px-4 text-[#64748B] w-[15%]">{{ $loan->tenor }} Bln ({{ $loan->jumlah_cicilan_dibayar }}/{{ $loan->tenor }})</td>
                                <td class="py-3 px-4 font-bold text-[#2563EB] w-[20%]">Rp {{ number_format($loan->sisa_pinjaman, 0, ',', '.') }}</td>
                                <td class="py-3 px-4 text-center w-[15%]">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase border {{ $statusClass }}">{{ $loan->status }}</span>
                                </td>
                                <td class="py-3 px-4 text-center w-[10%]">
                                    <div class="flex items-center justify-center">
                                        <button onclick='showPinjamanDetail(@json($loan))' class="w-8 h-8 rounded-lg bg-blue-50 text-[#2563EB] border border-blue-100 flex items-center justify-center hover:bg-[#2563EB] hover:text-white transition-all duration-150 cursor-pointer" title="Detail Pinjaman">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-xs text-[#64748B]">Belum ada transaksi pinjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Tab Content: Riwayat -->
        <div id="tab-content-riwayat" class="hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse table-fixed">
                    <thead>
                        <tr class="border-b border-[#E2E8F0] bg-[#F8FAFC] text-[#64748B] text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-3.5 px-4 font-bold w-[20%]">Tanggal Selesai</th>
                            <th class="py-3.5 px-4 font-bold w-[35%]">Jenis Riwayat</th>
                            <th class="py-3.5 px-4 font-bold w-[20%]">Nominal</th>
                            <th class="py-3.5 px-4 font-bold text-center w-[15%]">Status</th>
                            <th class="py-3.5 px-4 font-bold text-center w-[10%]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E2E8F0]">
                        @forelse($anggota->transactions as $tx)
                            @php
                                $txDate = optional($tx->tanggal_transaksi ?? $tx->created_at);
                                $formattedTxDate = $txDate ? $txDate->format('d') . ' ' . ($shortIndonesianMonths[$txDate->format('M')] ?? $txDate->format('M')) . ' ' . $txDate->format('Y') : '-';
                            @endphp
                            <tr class="hover:bg-[#F8FAFC] transition duration-150">
                                <td class="py-4 px-4 text-xs text-[#64748B] w-[20%]">{{ $formattedTxDate }}</td>
                                <td class="py-4 px-4 text-xs w-[35%]">
                                    @if($tx->jenis_simpanan === 'Pokok')
                                        <span class="inline-flex px-2.5 py-1 text-[10px] font-bold tracking-wide rounded-full bg-blue-50 text-[#2563EB] border border-blue-100">Simpanan Pokok</span>
                                    @elseif($tx->jenis_simpanan === 'Wajib')
                                        <span class="inline-flex px-2.5 py-1 text-[10px] font-bold tracking-wide rounded-full bg-purple-50 text-purple-600 border border-purple-100">Simpanan Wajib</span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 text-[10px] font-bold tracking-wide rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100">Simpanan Sukarela</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-xs font-extrabold text-[#0F172A] w-[20%]">{{ $formatRupiah($tx->nominal) }}</td>
                                <td class="py-4 px-4 text-center w-[15%]">
                                    @if($tx->status === 'Lunas')
                                        <span class="inline-flex px-2.5 py-1 text-[10px] font-bold tracking-wide rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100">LUNAS</span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 text-[10px] font-bold tracking-wide rounded-full bg-blue-50 text-[#2563EB] border border-blue-100">AKTIF</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center w-[10%]">
                                    <div class="flex items-center justify-center">
                                        <button onclick='showSimpananDetail(@json($tx))' class="w-8 h-8 rounded-lg bg-blue-50 text-[#2563EB] border border-blue-100 flex items-center justify-center hover:bg-[#2563EB] hover:text-white transition-all duration-150 cursor-pointer" title="Detail Simpanan">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-xs text-[#64748B]">Belum ada riwayat transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination -->
            <div class="flex justify-between items-center mt-5 pt-4 border-t border-[#E2E8F0]">
                <span class="text-xs font-semibold text-[#64748B]">Menampilkan {{ $anggota->transactions->count() }} dari {{ $anggota->transactions->count() }} transaksi</span>
            </div>
        </div>
    </div>

    <!-- DETAIL SIMPANAN MODAL -->
    <div id="detailSimpananModal" class="fixed inset-0 z-[99] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden transition-opacity">
        <div class="bg-white border border-[#E2E8F0] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-[#E2E8F0]">
                <h3 class="text-base font-extrabold text-[#0F172A]">Detail Transaksi Simpanan</h3>
                <button onclick="closeDetailSimpananModal()" class="text-[#64748B] hover:text-[#0F172A] transition-colors cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-2 gap-4 text-left">
                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">ID Transaksi</label>
                    <span class="text-sm font-bold text-[#0F172A]" id="detailSimpananTxId">-</span>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Tanggal</label>
                    <span class="text-sm font-bold text-[#0F172A]" id="detailSimpananTxDate">-</span>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Jenis Simpanan</label>
                    <div id="detailSimpananTypeBadge" class="mt-1"></div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Nominal</label>
                    <span class="text-sm font-extrabold text-[#2563EB]" id="detailSimpananTxAmount">-</span>
                </div>

                <div class="col-span-2 pt-3 border-t border-[#E2E8F0]">
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Keterangan</label>
                    <p class="text-xs text-[#0F172A] font-medium leading-relaxed" id="detailSimpananTxDesc">-</p>
                </div>
            </div>
        </div>
    </div>

    <!-- DETAIL PINJAMAN MODAL -->
    <div id="detailPinjamanModal" class="fixed inset-0 z-[99] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden transition-opacity">
        <div class="bg-white border border-[#E2E8F0] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-[#E2E8F0]">
                <h3 class="text-base font-extrabold text-[#0F172A]">Detail Transaksi Pinjaman</h3>
                <button onclick="closeDetailPinjamanModal()" class="text-[#64748B] hover:text-[#0F172A] transition-colors cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-2 gap-4 text-left">
                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">ID Pinjaman</label>
                    <span class="text-sm font-bold text-[#0F172A]" id="detailPinjamanId">-</span>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Tanggal Pengajuan</label>
                    <span class="text-sm font-bold text-[#0F172A]" id="detailPinjamanDate">-</span>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Tenor</label>
                    <span class="text-sm font-bold text-[#0F172A]" id="detailPinjamanTenor">-</span>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Status</label>
                    <div id="detailPinjamanStatusBadge" class="mt-1"></div>
                </div>

                <div class="pt-3 border-t border-[#E2E8F0]">
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Nominal Pinjaman</label>
                    <span class="text-sm font-extrabold text-[#0F172A]" id="detailPinjamanAmount">-</span>
                </div>
                <div class="pt-3 border-t border-[#E2E8F0]">
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Sisa Pinjaman</label>
                    <span class="text-sm font-extrabold text-rose-600" id="detailPinjamanRemaining">-</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function switchTab(tabName) {
            const tabs = ['simpanan', 'pinjaman', 'riwayat'];
            
            tabs.forEach(t => {
                const btn = document.getElementById(`tab-btn-${t}`);
                const content = document.getElementById(`tab-content-${t}`);
                
                if (t === tabName) {
                    btn.classList.remove('border-transparent', 'text-[#64748B]');
                    btn.classList.add('border-[#2563EB]', 'text-[#2563EB]', 'font-extrabold');
                    content.classList.remove('hidden');
                } else {
                    btn.classList.remove('border-[#2563EB]', 'text-[#2563EB]', 'font-extrabold');
                    btn.classList.add('border-transparent', 'text-[#64748B]', 'font-semibold');
                    content.classList.add('hidden');
                }
            });
        }

        function showSimpananDetail(tx) {
            const d = new Date(tx.tanggal_transaksi || tx.created_at);
            const yy = String(d.getFullYear()).slice(-2);
            const mm = String(d.getMonth() + 1).padStart(2, '0');
            const dd = String(d.getDate()).padStart(2, '0');
            const formattedDateForId = `${dd}${mm}${yy}`;
            document.getElementById('detailSimpananTxId').textContent = `TX-${formattedDateForId}-YPIK-${String(tx.id).padStart(5, '0')}`;

            const monthsId = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
            const formattedDateId = `${d.getDate()} ${monthsId[d.getMonth()]} ${d.getFullYear()}, ${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}`;
            document.getElementById('detailSimpananTxDate').textContent = formattedDateId;

            document.getElementById('detailSimpananTxAmount').textContent = `Rp ${Number(tx.nominal).toLocaleString('id-ID')}`;
            document.getElementById('detailSimpananTxDesc').textContent = tx.keterangan || `Setoran Simpanan ${tx.jenis_simpanan}`;

            const badgeContainer = document.getElementById('detailSimpananTypeBadge');
            let typeBadge = '';
            if (tx.jenis_simpanan === 'Pokok') {
                typeBadge = `<span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-[#2563EB] border border-blue-100">Simpanan Pokok</span>`;
            } else if (tx.jenis_simpanan === 'Wajib') {
                typeBadge = `<span class="px-2.5 py-1 rounded-full text-xs font-bold bg-purple-50 text-purple-600 border border-purple-100">Simpanan Wajib</span>`;
            } else {
                typeBadge = `<span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">Simpanan Sukarela</span>`;
            }
            badgeContainer.innerHTML = typeBadge;

            document.getElementById('detailSimpananModal').classList.remove('hidden');
            if (window.lucide) lucide.createIcons();
        }

        function closeDetailSimpananModal() {
            document.getElementById('detailSimpananModal').classList.add('hidden');
        }

        function showPinjamanDetail(loan) {
            const d = new Date(loan.tanggal_pengajuan || loan.created_at);
            const yy = String(d.getFullYear()).slice(-2);
            const mm = String(d.getMonth() + 1).padStart(2, '0');
            const dd = String(d.getDate()).padStart(2, '0');
            const formattedDateForId = `${dd}${mm}${yy}`;
            document.getElementById('detailPinjamanId').textContent = `PJ-${formattedDateForId}-YPIK-${String(loan.id).padStart(5, '0')}`;

            const monthsId = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
            const formattedDateId = `${d.getDate()} ${monthsId[d.getMonth()]} ${d.getFullYear()}`;
            document.getElementById('detailPinjamanDate').textContent = formattedDateId;

            document.getElementById('detailPinjamanTenor').textContent = `${loan.tenor} Bulan (${loan.jumlah_cicilan_dibayar}/${loan.tenor})`;
            document.getElementById('detailPinjamanAmount').textContent = `Rp ${Number(loan.nominal_pinjaman).toLocaleString('id-ID')}`;
            document.getElementById('detailPinjamanRemaining').textContent = `Rp ${Number(loan.sisa_pinjaman).toLocaleString('id-ID')}`;

            const badgeContainer = document.getElementById('detailPinjamanStatusBadge');
            let statusBadge = '';
            if (loan.status === 'Lunas') {
                statusBadge = `<span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">Lunas</span>`;
            } else if (loan.status === 'Menunggak') {
                statusBadge = `<span class="px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100">Menunggak</span>`;
            } else {
                statusBadge = `<span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-[#2563EB] border border-blue-100">Aktif</span>`;
            }
            badgeContainer.innerHTML = statusBadge;

            document.getElementById('detailPinjamanModal').classList.remove('hidden');
            if (window.lucide) lucide.createIcons();
        }

        function closeDetailPinjamanModal() {
            document.getElementById('detailPinjamanModal').classList.add('hidden');
        }
    </script>
@endsection
