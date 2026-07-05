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

    <!-- Main Member Header Area -->
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px; margin-top: 8px; width: 100%; text-align: left;">
        <div style="text-align: left;">
            <h2 class="text-3xl font-extrabold text-white tracking-tight" style="font-size: 32px; font-weight: 800; color: #ffffff;">{{ $anggota->nama }}</h2>
            <div class="inline-flex items-center mt-2 px-3 py-1 bg-[#1e2238] border border-[#2a2f4c] text-xs font-semibold text-[#8f9bb3] rounded-lg">
                ID: {{ $anggota->id_anggota ?? 'AGT-' . str_pad($anggota->id, 3, '0', STR_PAD_LEFT) }}
            </div>
        </div>
        <a href="{{ route('anggota.index') }}?edit={{ $anggota->id }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg transition duration-150 text-xs font-bold shadow-md shadow-blue-500/10">
            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
            <span>Ubah</span>
        </a>
    </div>

    <!-- First Section: 3 Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <!-- Card 1: Total Simpanan -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl p-5 hover:border-[#8f9bb3]/20 transition duration-300 flex flex-col justify-between h-[135px] relative overflow-hidden group">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%;">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); color: #60a5fa;">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                </div>
                <span class="text-[9px] font-bold text-[#8f9bb3] uppercase tracking-wider">Total Simpanan</span>
            </div>
            <div style="margin-top: auto; text-align: left;">
                <h3 class="text-2xl font-extrabold text-white" style="text-align: left;">{{ $formatRupiah($anggota->total_saldo ?: ($anggota->simpanan_pokok + $anggota->simpanan_wajib + $anggota->simpanan_sukarela)) }}</h3>
                <p class="text-[10px] text-emerald-400 font-semibold mt-1 flex items-center gap-1" style="text-align: left;">
                    <span>↗</span>
                    <span>+Rp 450.000 bln ini</span>
                </p>
            </div>
        </div>

        <!-- Card 2: Pinjaman Aktif -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl p-5 hover:border-[#8f9bb3]/20 transition duration-300 flex flex-col justify-between h-[135px] relative overflow-hidden group">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%;">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: rgba(249, 115, 22, 0.1); border: 1px solid rgba(249, 115, 22, 0.2); color: #f97316;">
                    <i data-lucide="banknote" class="w-5 h-5"></i>
                </div>
                <span class="text-[9px] font-bold text-[#8f9bb3] uppercase tracking-wider">Pinjaman Aktif</span>
            </div>
            <div style="margin-top: auto; text-align: left;">
                <h3 class="text-2xl font-extrabold text-white" style="text-align: left;">Rp 0</h3>
                <p class="text-[10px] text-[#7c83a7] font-semibold mt-1" style="text-align: left;">0 Kontrak Berjalan</p>
            </div>
        </div>

        <!-- Card 3: Sisa Cicilan -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl p-5 hover:border-[#8f9bb3]/20 transition duration-300 flex flex-col justify-between h-[135px] relative overflow-hidden group">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%;">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.2); color: #a855f7;">
                    <i data-lucide="history" class="w-5 h-5"></i>
                </div>
                <span class="text-[9px] font-bold text-[#8f9bb3] uppercase tracking-wider">Sisa Cicilan</span>
            </div>
            <div style="margin-top: auto; text-align: left;">
                <h3 class="text-2xl font-extrabold text-white" style="text-align: left;">Rp 0</h3>
                <p class="text-[10px] text-[#7c83a7] font-semibold mt-1" style="text-align: left;">Jatuh tempo: -</p>
            </div>
        </div>
    </div>

    <!-- Second Section: Informasi Anggota Card -->
    <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl p-6 mt-6">
        <div class="flex items-center gap-2.5 border-b border-[#1f243d] pb-4 mb-6">
            <i data-lucide="user" class="w-4 h-4 text-[#8f9bb3]"></i>
            <h3 class="text-sm font-bold text-white tracking-wide" style="text-align: left;">Informasi Anggota</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12" style="text-align: left;">
            <!-- Column 1 -->
            <div class="space-y-6" style="text-align: left;">
                <div style="text-align: left;">
                    <p class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">ID Anggota</p>
                    <p class="text-sm font-semibold text-white mt-1">{{ $anggota->id_anggota ?? 'AGT-' . str_pad($anggota->id, 3, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div style="text-align: left;">
                    <p class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Nomor HP</p>
                    <p class="text-sm font-semibold text-white mt-1">{{ $anggota->no_hp ?? '-' }}</p>
                </div>
            </div>
            <!-- Column 2 -->
            <div class="space-y-6" style="text-align: left;">
                <div style="text-align: left;">
                    <p class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Nama Lengkap</p>
                    <p class="text-sm font-semibold text-white mt-1">{{ $anggota->nama }}</p>
                </div>
                <div style="text-align: left;">
                    <p class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Tanggal Bergabung</p>
                    <p class="text-sm font-semibold text-white mt-1">{{ $formattedDate }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Third Section: Tabs and Table Card -->
    <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl p-6 mt-6">
        <!-- Tabs Header -->
        <div class="flex border-b border-[#1f243d] mb-6">
            <button id="tab-btn-simpanan" class="px-5 py-3 border-b-2 border-[#2f54eb] text-xs font-bold text-white" onclick="switchTab('simpanan')">Simpanan</button>
            <button id="tab-btn-pinjaman" class="px-5 py-3 border-b-2 border-transparent text-xs font-semibold text-[#8f9bb3] hover:text-white" onclick="switchTab('pinjaman')">Pinjaman</button>
            <button id="tab-btn-transaksi" class="px-5 py-3 border-b-2 border-transparent text-xs font-semibold text-[#8f9bb3] hover:text-white" onclick="switchTab('transaksi')">Riwayat Transaksi</button>
        </div>
        
        <!-- Tab Content: Simpanan (Active) -->
        <div id="tab-content-simpanan">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse table-fixed">
                    <thead>
                        <tr class="border-b border-[#1f243d] text-[#8f9bb3] text-[10px] font-bold uppercase tracking-wider">
                            <th class="py-3.5 px-4 font-semibold w-[25%]">Tanggal</th>
                            <th class="py-3.5 px-4 font-semibold w-[35%]">Jenis Simpanan</th>
                            <th class="py-3.5 px-4 font-semibold w-[25%]">Nominal</th>
                            <th class="py-3.5 px-4 font-semibold text-center w-[15%]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1f243d]">
                        <!-- Simpanan Pokok -->
                        <tr class="hover:bg-[#07080f]/30 transition duration-150">
                            <td class="py-4 px-4 text-xs text-slate-300 w-[25%]">{{ $shortFormattedDate }}</td>
                            <td class="py-4 px-4 text-xs w-[35%]">
                                <span class="inline-flex px-2.5 py-1 text-[10px] font-bold tracking-wide rounded-full" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); color: #60a5fa;">Simpanan Pokok</span>
                            </td>
                            <td class="py-4 px-4 text-xs font-extrabold text-white w-[25%]">{{ $formatRupiah($anggota->simpanan_pokok) }}</td>
                            <td class="py-4 px-4 text-center text-xs font-bold text-[#2f54eb] hover:text-blue-400 cursor-pointer w-[15%]">Detail</td>
                        </tr>
                        <!-- Simpanan Wajib -->
                        <tr class="hover:bg-[#07080f]/30 transition duration-150">
                            <td class="py-4 px-4 text-xs text-slate-300 w-[25%]">{{ $shortFormattedDate }}</td>
                            <td class="py-4 px-4 text-xs w-[35%]">
                                <span class="inline-flex px-2.5 py-1 text-[10px] font-bold tracking-wide rounded-full" style="background-color: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.2); color: #c084fc;">Simpanan Wajib</span>
                            </td>
                            <td class="py-4 px-4 text-xs font-extrabold text-white w-[25%]">{{ $formatRupiah($anggota->simpanan_wajib) }}</td>
                            <td class="py-4 px-4 text-center text-xs font-bold text-[#2f54eb] hover:text-blue-400 cursor-pointer w-[15%]">Detail</td>
                        </tr>
                        <!-- Simpanan Sukarela -->
                        <tr class="hover:bg-[#07080f]/30 transition duration-150">
                            <td class="py-4 px-4 text-xs text-slate-300 w-[25%]">{{ $shortFormattedDate }}</td>
                            <td class="py-4 px-4 text-xs w-[35%]">
                                <span class="inline-flex px-2.5 py-1 text-[10px] font-bold tracking-wide rounded-full" style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399;">Simpanan Sukarela</span>
                            </td>
                            <td class="py-4 px-4 text-xs font-extrabold text-white w-[25%]">{{ $formatRupiah($anggota->simpanan_sukarela) }}</td>
                            <td class="py-4 px-4 text-center text-xs font-bold text-[#2f54eb] hover:text-blue-400 cursor-pointer w-[15%]">Detail</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Tab Content: Pinjaman (Empty state) -->
        <div id="tab-content-pinjaman" class="hidden py-12 flex flex-col items-center justify-center text-center space-y-3">
            <div class="w-10 h-10 rounded-full bg-slate-800/40 border border-slate-700/20 text-slate-400 flex items-center justify-center">
                <i data-lucide="info" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-white">Tidak ada data pinjaman</p>
                <p class="text-[10px] text-[#8f9bb3]">Anggota ini tidak memiliki pinjaman aktif.</p>
            </div>
        </div>
        
        <!-- Tab Content: Transaksi (Empty state) -->
        <div id="tab-content-transaksi" class="hidden py-12 flex flex-col items-center justify-center text-center space-y-3">
            <div class="w-10 h-10 rounded-full bg-slate-800/40 border border-slate-700/20 text-slate-400 flex items-center justify-center">
                <i data-lucide="history" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-white">Tidak ada riwayat transaksi</p>
                <p class="text-[10px] text-[#8f9bb3]">Belum ada mutasi atau transaksi tercatat.</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function switchTab(tabName) {
            const tabs = ['simpanan', 'pinjaman', 'transaksi'];
            
            tabs.forEach(t => {
                const btn = document.getElementById(`tab-btn-${t}`);
                const content = document.getElementById(`tab-content-${t}`);
                
                if (t === tabName) {
                    btn.classList.remove('border-transparent', 'text-[#8f9bb3]');
                    btn.classList.add('border-[#2f54eb]', 'text-white', 'font-bold');
                    content.classList.remove('hidden');
                } else {
                    btn.classList.remove('border-[#2f54eb]', 'text-white', 'font-bold');
                    btn.classList.add('border-transparent', 'text-[#8f9bb3]', 'font-semibold');
                    content.classList.add('hidden');
                }
            });
        }
    </script>
@endsection
