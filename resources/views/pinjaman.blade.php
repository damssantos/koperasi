@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Pinjaman Koperasi')

@section('styles')
    <style>
        .btn-cancel {
            background-color: #334155 !important; /* slate-700 */
            color: #f1f5f9 !important; /* slate-100 */
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            transition: all 0.2s ease-in-out !important;
            cursor: pointer;
        }
        .btn-cancel:hover {
            background-color: #475569 !important; /* slate-600 */
            color: #ffffff !important;
            transform: scale(1.02) !important;
        }
        .btn-cancel:active {
            transform: scale(0.98) !important;
        }
        .btn-save {
            background-color: #2f54eb !important; /* brand blue */
            color: #ffffff !important;
            border: none !important;
            transition: all 0.2s ease-in-out !important;
            box-shadow: 0 4px 14px 0 rgba(47, 84, 235, 0.2) !important;
            cursor: pointer;
        }
        .btn-save:hover {
            background-color: #4361ee !important;
            transform: scale(1.02) !important;
        }
        .btn-save:active {
            transform: scale(0.98) !important;
        }
    </style>
@endsection

@section('content')
    <!-- Page Header Title and Action buttons -->
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 pb-6 border-b border-[#1f243d]">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Pinjaman Koperasi</h2>
            <p class="text-xs text-[#8f9bb3] mt-0.5">Kelola seluruh proses pinjaman anggota, mulai dari pengajuan hingga pelunasan.</p>
        </div>
        
        <!-- Action Buttons Group -->
        <div class="flex items-center gap-3">
            <button onclick="openNewLoanModal()" class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg transition duration-150 text-xs font-bold shadow-md shadow-blue-500/10">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                <span>Tambah Pengajuan</span>
            </button>
        </div>
    </div>

    <!-- Metrics Overview Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
        <!-- Card 1: Total Pinjaman -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-4 hover:border-[#8f9bb3]/20 transition duration-300 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-blue-500/5 rounded-full blur-xl group-hover:bg-blue-500/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-md flex items-center justify-center shrink-0" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); color: #60a5fa;">
                        <i data-lucide="wallet" class="w-3.5 h-3.5"></i>
                    </div>
                    <p class="text-xs font-semibold text-[#8f9bb3] whitespace-nowrap">Total Pinjaman</p>
                </div>
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded flex items-center gap-0.5" style="background-color: rgba(16, 185, 129, 0.1); color: #34d399;">
                    <i data-lucide="trending-up" class="w-2.5 h-2.5"></i>
                    <span>+12%</span>
                </span>
            </div>
            <div class="space-y-0.5 mt-1.5">
                <h3 class="text-xl font-extrabold text-white" id="metric-total">Rp {{ number_format((int) $totalPinjaman, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Card 2: Pinjaman Aktif -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-4 hover:border-[#8f9bb3]/20 transition duration-300 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-blue-500/5 rounded-full blur-xl group-hover:bg-blue-500/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-md flex items-center justify-center shrink-0" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); color: #60a5fa;">
                        <i data-lucide="users" class="w-3.5 h-3.5"></i>
                    </div>
                    <p class="text-xs font-semibold text-[#8f9bb3] whitespace-nowrap">Pinjaman Aktif</p>
                </div>
            </div>
            <div class="space-y-0.5 mt-1.5">
                <h3 class="text-xl font-extrabold text-white">{{ $pinjamanAktifCount }} Anggota</h3>
            </div>
        </div>

        <!-- Card 3: Menunggak -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-4 hover:border-[#8f9bb3]/20 transition duration-300 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-rose-500/5 rounded-full blur-xl group-hover:bg-rose-500/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-md flex items-center justify-center shrink-0" style="background-color: rgba(244, 63, 94, 0.1); border: 1px solid rgba(244, 63, 94, 0.2); color: #fb7185;">
                        <i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i>
                    </div>
                    <p class="text-xs font-semibold text-[#8f9bb3] whitespace-nowrap">Menunggak</p>
                </div>
            </div>
            <div class="space-y-0.5 mt-1.5">
                <h3 class="text-xl font-extrabold text-white">{{ $pinjamanMenunggakCount }} Anggota</h3>
            </div>
        </div>

        <!-- Card 4: Pinjaman Lunas -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-4 hover:border-[#8f9bb3]/20 transition duration-300 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/10 transition-colors"></div>
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-md flex items-center justify-center shrink-0" style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399;">
                        <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                    </div>
                    <p class="text-xs font-semibold text-[#8f9bb3] whitespace-nowrap">Pinjaman Lunas</p>
                </div>
            </div>
            <div class="space-y-0.5 mt-1.5">
                <h3 class="text-xl font-extrabold text-white">{{ $pinjamanLunasCount }} Anggota</h3>
            </div>
        </div>
    </div>

    <!-- Filters Control Panel -->
    <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-4 mt-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <!-- Search and Filter Tabs -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
            <!-- Search Bar -->
            <div class="relative w-full sm:w-64">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#8f9bb3]"></i>
                <input type="text" id="searchInput" oninput="applyFilters()" placeholder="Cari nama anggota..." class="w-full pl-9 pr-4 py-1.5 bg-[#0d0f1d] border border-[#1f243d] rounded-lg text-xs text-white placeholder-slate-600 focus:outline-none focus:border-[#2f54eb] focus:ring-1 focus:ring-[#2f54eb] transition duration-150">
            </div>
            <!-- Tabs -->
            <div class="flex bg-[#0d0f1d] border border-[#1f243d] rounded-lg p-0.5 shrink-0">
                <button onclick="setFilterStatus('All')" id="tab-all" class="px-4 py-1 rounded-md text-xs font-semibold transition duration-150 bg-[#2f54eb] text-white">Semua</button>
                <button onclick="setFilterStatus('Aktif')" id="tab-aktif" class="px-4 py-1 rounded-md text-xs font-semibold transition duration-150 text-[#8f9bb3] hover:text-white">Aktif</button>
                <button onclick="setFilterStatus('Menunggak')" id="tab-menunggak" class="px-4 py-1 rounded-md text-xs font-semibold transition duration-150 text-[#8f9bb3] hover:text-white">Menunggak</button>
                <button onclick="setFilterStatus('Lunas')" id="tab-lunas" class="px-4 py-1 rounded-md text-xs font-semibold transition duration-150 text-[#8f9bb3] hover:text-white">Lunas</button>
            </div>
        </div>
        <!-- Sort Control -->
        <div class="flex items-center gap-3 w-full md:w-auto justify-end">
            <span class="text-xs text-[#8f9bb3] whitespace-nowrap">Urutan:</span>
            <div class="relative w-40">
                <select id="sortBy" onchange="applyFilters()" class="w-full px-3 py-1.5 bg-[#0d0f1d] border border-[#1f243d] rounded-lg text-xs text-white focus:outline-none focus:border-[#2f54eb] appearance-none cursor-pointer">
                    <option value="date-desc">Terbaru</option>
                    <option value="date-asc">Terlama</option>
                    <option value="amount-desc">Nominal Terbesar</option>
                    <option value="amount-asc">Nominal Terkecil</option>
                </select>
                <i data-lucide="chevron-down" class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#8f9bb3] pointer-events-none"></i>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-[#16192b] border border-[#1f243d] rounded-xl overflow-hidden mt-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-[#1f243d] bg-[#0d0f1d]/40">
                        <th class="px-6 py-4 text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Tanggal Pengajuan</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Nama Anggota</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Nominal Pinjaman</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Tenor</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Progress Cicilan</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Sisa Pinjaman</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="loansTableBody" class="divide-y divide-[#1f243d]/60">
                    <!-- Dynamic Rows Loaded via JS -->
                </tbody>
            </table>
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="hidden py-16 flex flex-col items-center justify-center text-center space-y-4">
            <div class="w-12 h-12 rounded-full bg-slate-800/40 border border-slate-700/20 flex items-center justify-center text-slate-500">
                <i data-lucide="inbox" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-white">Tidak ada data pinjaman</p>
                <p class="text-[10px] text-[#8f9bb3] mt-1">Gunakan kata kunci lain atau tambah pengajuan baru.</p>
            </div>
        </div>

        <!-- Table Footer Pagination -->
        <div class="px-6 py-4 border-t border-[#1f243d] flex flex-col sm:flex-row items-center justify-between gap-4 bg-[#0d0f1d]/20">
            <span class="text-[11px] text-[#8f9bb3]" id="paginationText">Menampilkan 0 dari 0 data pinjaman</span>
            <div class="flex items-center gap-1.5" id="paginationControls">
                <!-- Dynamic pagination buttons -->
            </div>
        </div>
    </div>

    @push('modals')
    <!-- NEW LOAN MODAL -->
    <div id="newLoanModal" class="fixed inset-0 flex items-center justify-center p-4 hidden" style="z-index: 9999; backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); background-color: rgba(7, 8, 15, 0.75);">
        <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-6">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-2 border-b border-[#1f243d]">
                <h3 class="text-base font-bold text-white">Tambah Pengajuan Pinjaman</h3>
                <button onclick="closeNewLoanModal()" class="text-slate-400 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <!-- Form -->
            <form action="{{ route('pinjaman.store') }}" method="POST" class="space-y-4">
                @csrf
                <!-- Nama Anggota -->
                <div class="relative">
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">NAMA ANGGOTA*</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#8f9bb3] pointer-events-none">
                            <i data-lucide="search" class="w-4 h-4"></i>
                        </span>
                        <input type="text" id="memberSearchInput" onfocus="showMemberDropdown()" oninput="filterMembers()" placeholder="Cari nama anggota..." class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-10 pr-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500">
                        <input type="hidden" name="anggota_id" id="selectedMemberId" required>
                    </div>
                    
                    <!-- Dropdown List -->
                    <div id="memberDropdownList" class="absolute left-0 right-0 mt-1 max-h-48 overflow-y-auto bg-[#0d0f1d] border border-[#1f243d] rounded-lg shadow-xl z-50 hidden divide-y divide-[#1f243d]/60">
                        @foreach($anggota as $item)
                            <div onclick="selectMember({{ $item->id }}, '{{ $item->nama }} ({{ $item->id_anggota }})')" class="px-4 py-2.5 text-xs text-white hover:bg-blue-600 hover:text-white cursor-pointer transition-colors duration-150">
                                {{ $item->nama }} ({{ $item->id_anggota }})
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Nominal and Tenor Side by Side -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Nominal * -->
                    <div>
                        <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">NOMINAL PINJAMAN*</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 text-[#8f9bb3] text-xs font-bold pointer-events-none">Rp</span>
                            <input type="number" id="inputNominal" name="nominal_pinjaman" oninput="calculateSummary()" required placeholder="Masukkan nominal pinjaman" min="1000" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-8 pr-2 py-2 text-xs text-white placeholder-slate-500 placeholder:text-[10px] focus:outline-none focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Tenor * -->
                    <div>
                        <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">TENOR*</label>
                        <div class="relative">
                            <input type="number" id="inputTenor" name="tenor" oninput="calculateSummary()" required placeholder="Masukkan tenor pinjaman" min="1" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-3 pr-11 py-2 text-xs text-white placeholder-slate-500 placeholder:text-[10px] focus:outline-none focus:border-blue-500">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-2.5 text-[#8f9bb3] text-[10px] font-semibold pointer-events-none">bulan</span>
                        </div>
                    </div>
                </div>

                <!-- Keterangan (Opsional) -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">KETERANGAN (OPSIONAL)</label>
                    <textarea name="keterangan" rows="3" placeholder="Masukkan keterangan..." class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 resize-none"></textarea>
                </div>

                <!-- Tanggal Pengajuan * -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">TANGGAL PENGAJUAN*</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#8f9bb3] pointer-events-none">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </span>
                        <input type="date" name="tanggal_pengajuan" required value="{{ date('Y-m-d') }}" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-10 pr-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <!-- Ringkasan Pinjaman Box -->
                <div class="bg-[#0d0f1d]/60 border border-[#1f243d]/80 rounded-xl p-4 space-y-2">
                    <div class="flex items-center gap-2 text-xs font-bold text-white mb-1.5">
                        <i data-lucide="calculator" class="w-4 h-4 text-blue-400"></i>
                        <span>Ringkasan Pinjaman</span>
                    </div>
                    <div class="flex justify-between items-center text-[11px] text-[#8f9bb3]">
                        <span>Biaya Administrasi (1%)</span>
                        <span id="summaryAdminFee" class="font-semibold text-white">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center text-[11px] text-[#8f9bb3]">
                        <span>Estimasi Cicilan per Bulan</span>
                        <span id="summaryMonthlyPayment" class="font-semibold text-white">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center text-[11px] border-t border-[#1f243d]/60 pt-2 font-bold text-[#8f9bb3]">
                        <span>Total Pengembalian</span>
                        <span id="summaryTotalReturn" class="text-emerald-400 font-extrabold text-xs">Rp 0</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3 pt-4 justify-end">
                    <button type="button" onclick="closeNewLoanModal()" class="btn-cancel px-5 py-2.5 rounded-lg text-xs font-semibold">Batal</button>
                    <button type="submit" class="btn-save px-5 py-2.5 text-white rounded-lg text-xs font-bold shadow-lg shadow-blue-500/10">Ajukan Pinjaman</button>
                </div>
            </form>
        </div>
    </div>

    <!-- DETAIL LOAN MODAL -->
    <div id="detailLoanModal" class="fixed inset-0 flex items-center justify-center p-4 hidden" style="z-index: 9999; backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); background-color: rgba(7, 8, 15, 0.75);">
        <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-6">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-2 border-b border-[#1f243d]">
                <h3 class="text-base font-bold text-white">Detail Pinjaman</h3>
                <button onclick="closeDetailLoanModal()" class="text-slate-400 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <!-- Modal Content Grid -->
            <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.25rem 1.5rem; text-align: left;">
                <!-- ID Kontrak -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">ID Kontrak</label>
                    <span class="text-sm font-bold text-white text-wrap break-all" id="detailLoanId">PJ-000001</span>
                </div>
                <!-- Tanggal Pengajuan -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">Tanggal Pengajuan</label>
                    <span class="text-sm font-bold text-white" id="detailLoanDate">12 Mar 2024</span>
                </div>

                <!-- ID Anggota -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">ID Anggota</label>
                    <span class="text-sm font-bold text-[#8f9bb3]" id="detailMemberId">KSP-0021</span>
                </div>
                <!-- Nama Anggota -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">Nama Anggota</label>
                    <span class="text-sm font-bold text-white" id="detailMemberName">Budi Satria</span>
                </div>

                <!-- Nominal Pinjaman -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">Nominal Pinjaman</label>
                    <span class="text-sm font-extrabold text-white" id="detailAmount">Rp 10.000.000</span>
                </div>
                <!-- Tenor -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">Tenor</label>
                    <span class="text-sm font-bold text-white" id="detailTenor">12 Bulan</span>
                </div>

                <!-- Progress Cicilan -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">Progress Cicilan</label>
                    <span class="text-sm font-bold text-white" id="detailProgress">8 / 12</span>
                </div>
                <!-- Sisa Pinjaman -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">Sisa Pinjaman</label>
                    <span class="text-sm font-extrabold text-[#2f54eb]" id="detailRemaining">Rp 3.333.333</span>
                </div>

                <!-- Status -->
                <div class="col-span-2">
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">Status</label>
                    <span id="detailStatus" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold inline-block border">AKTIF</span>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="flex justify-end pt-2 border-t border-[#1f243d]">
                <button type="button" onclick="closeDetailLoanModal()" class="btn-cancel px-5 py-2.5 rounded-lg text-xs font-semibold">Tutup</button>
            </div>
        </div>
    </div>

    <!-- PAY INSTALLMENT MODAL -->
    <div id="payInstallmentModal" class="fixed inset-0 flex items-center justify-center p-4 hidden" style="z-index: 9999; backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); background-color: rgba(7, 8, 15, 0.75);">
        <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-5">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-2 border-b border-[#1f243d]">
                <h3 class="text-base font-bold text-white">Bayar Cicilan</h3>
                <button onclick="closePayInstallmentModal()" class="text-slate-400 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <!-- Form -->
            <form id="payInstallmentForm" method="POST" class="space-y-4">
                @csrf
                
                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-4 pb-1">
                    <div>
                        <span class="block text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Nama Anggota</span>
                        <span id="payMemberName" class="text-xs font-extrabold text-white mt-1 block">-</span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Nominal Pinjaman</span>
                        <span id="payLoanAmount" class="text-xs font-bold text-blue-400 mt-1 block">-</span>
                    </div>
                </div>
                
                <!-- Progress Cicilan -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center text-[10px] font-bold">
                        <span class="text-[#8f9bb3] uppercase tracking-wider">Progress Cicilan</span>
                        <span id="payProgressText" class="text-white">-</span>
                    </div>
                    <!-- Progress Bar Track -->
                    <div class="w-full bg-[#0d0f1d] rounded-full h-2 overflow-hidden border border-[#1f243d]/60">
                        <div id="payProgressBar" class="bg-blue-500 h-full rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                </div>
                
                <!-- Sisa Pinjaman -->
                <div class="flex justify-between items-center py-2.5 border-t border-b border-[#1f243d]/60">
                    <span class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Sisa Pinjaman</span>
                    <span id="payRemainingAmount" class="text-sm font-extrabold text-white">-</span>
                </div>
                
                <!-- Input Fields Side-by-Side -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Cicilan Ke -->
                    <div>
                        <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">Cicilan Ke</label>
                        <div class="relative">
                            <input type="text" id="payInstallmentNo" readonly class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3 py-2 text-xs text-white/70 select-none focus:outline-none pointer-events-none">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#8f9bb3]">
                                <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Nominal Cicilan -->
                    <div>
                        <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">Nominal Cicilan</label>
                        <div class="relative">
                            <input type="text" id="payInstallmentAmount" readonly class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3 py-2 text-xs text-white/70 select-none focus:outline-none pointer-events-none">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#8f9bb3]">
                                <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Tanggal Pembayaran -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">Tanggal Pembayaran*</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-[#8f9bb3] pointer-events-none">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </span>
                        <input type="date" name="tanggal_pembayaran" required value="{{ date('Y-m-d') }}" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-9 pr-4 py-2 text-xs text-white focus:outline-none focus:border-blue-500">
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center gap-3 pt-3 justify-end">
                    <button type="button" onclick="closePayInstallmentModal()" class="btn-cancel px-5 py-2.5 rounded-lg text-xs font-semibold">Batal</button>
                    <button type="submit" class="btn-save px-5 py-2.5 text-white rounded-lg text-xs font-bold shadow-lg shadow-blue-500/10">Konfirmasi Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
    @endpush
@endsection

@section('scripts')
    <script>
        const originalLoans = @json($loans);
        
        let currentFilterStatus = 'All';
        let currentPage = 1;
        const itemsPerPage = 10;
        let filteredLoans = [...originalLoans];

        // Format Rupiah helper
        function formatRupiah(value) {
            return 'Rp ' + new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0 }).format(value);
        }

        // Parse date for sorting helper
        function parseDate(dateStr) {
            return new Date(dateStr);
        }

        // Tab selection handler
        function setFilterStatus(status) {
            currentFilterStatus = status;
            
            // Toggle active classes in tabs
            const tabs = {
                'All': 'tab-all',
                'Aktif': 'tab-aktif',
                'Menunggak': 'tab-menunggak',
                'Lunas': 'tab-lunas'
            };

            Object.keys(tabs).forEach(key => {
                const el = document.getElementById(tabs[key]);
                if (key === status) {
                    el.classList.add('bg-[#2f54eb]', 'text-white');
                    el.classList.remove('text-[#8f9bb3]', 'hover:text-white');
                } else {
                    el.classList.remove('bg-[#2f54eb]', 'text-white');
                    el.classList.add('text-[#8f9bb3]', 'hover:text-white');
                }
            });

            currentPage = 1;
            applyFilters();
        }

        // Apply search, tabs, sorting & rendering
        function applyFilters() {
            const query = document.getElementById('searchInput').value.trim().toLowerCase();
            const sortBy = document.getElementById('sortBy').value;

            // 1. Filter by search input
            filteredLoans = originalLoans.filter(loan => {
                const matchesSearch = 
                    loan.name.toLowerCase().includes(query) || 
                    loan.formattedId.toLowerCase().includes(query) || 
                    loan.memberId.toLowerCase().includes(query);
                
                // 2. Filter by status tab
                const matchesTab = (currentFilterStatus === 'All' || loan.status === currentFilterStatus);
                
                return matchesSearch && matchesTab;
            });

            // 3. Sort loans
            filteredLoans.sort((a, b) => {
                if (sortBy === 'date-desc') {
                    return parseDate(b.date) - parseDate(a.date);
                } else if (sortBy === 'date-asc') {
                    return parseDate(a.date) - parseDate(b.date);
                } else if (sortBy === 'amount-desc') {
                    return b.amount - a.amount;
                } else if (sortBy === 'amount-asc') {
                    return a.amount - b.amount;
                }
                return 0;
            });

            renderTable();
        }

        // Render Table Rows
        function renderTable() {
            const tbody = document.getElementById('loansTableBody');
            tbody.innerHTML = '';

            const totalItems = filteredLoans.length;
            const hasItems = totalItems > 0;

            document.getElementById('emptyState').classList.toggle('hidden', hasItems);

            if (!hasItems) {
                document.getElementById('paginationText').textContent = 'Menampilkan 0 dari 0 data pinjaman';
                document.getElementById('paginationControls').innerHTML = '';
                return;
            }

            // Paginate items
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, totalItems);
            const paginatedItems = filteredLoans.slice(startIndex, endIndex);

            // Populate table rows
            paginatedItems.forEach(loan => {
                let statusClass = '';
                if (loan.status === 'Lunas') {
                    statusClass = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
                } else if (loan.status === 'Menunggak') {
                    statusClass = 'bg-rose-500/10 text-rose-400 border-rose-500/20';
                } else {
                    statusClass = 'bg-blue-500/10 text-blue-400 border-blue-500/20';
                }

                // Format month translation
                let displayDate = loan.formattedDate;
                displayDate = displayDate.replace('Sep', 'Sep').replace('Oct', 'Okt').replace('Nov', 'Nov').replace('Dec', 'Des');

                const row = document.createElement('tr');
                row.className = 'hover:bg-[#1f243d]/30 transition duration-150';
                row.innerHTML = `
                    <td class="px-6 py-4 text-xs text-[#8f9bb3]">${displayDate}</td>
                    <td class="px-6 py-4">
                        <div class="text-xs font-bold text-white">${loan.name}</div>
                        <div class="text-[10px] text-[#8f9bb3] mt-0.5">${loan.memberId}</div>
                    </td>
                    <td class="px-6 py-4 text-xs font-bold text-white">${formatRupiah(loan.amount)}</td>
                    <td class="px-6 py-4 text-xs text-[#8f9bb3]">${loan.tenor} Bln</td>
                    <td class="px-6 py-4 text-xs text-[#8f9bb3]">${loan.paid}/${loan.tenor}</td>
                    <td class="px-6 py-4 text-xs font-bold text-white">${loan.remaining > 0 ? formatRupiah(loan.remaining) : 'Rp 0'}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase border ${statusClass}">${loan.status}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="showDetail(${loan.id})" class="w-7 h-7 rounded-lg bg-slate-800/40 text-slate-400 border border-slate-700/20 flex items-center justify-center hover:bg-slate-700/60 hover:text-white transition-all duration-150" title="Lihat Detail">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                            </button>
                            <button onclick="openPayInstallmentModal(${loan.id})" class="w-7 h-7 rounded-lg bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center hover:bg-emerald-500/30 hover:text-emerald-300 transition-all duration-150 ${loan.status === 'Lunas' ? 'opacity-30 pointer-events-none' : ''}" title="Bayar Cicilan">
                                <i data-lucide="credit-card" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(row);
            });

            // Re-initialize Lucide Icons
            lucide.createIcons();

            // Pagination Text
            document.getElementById('paginationText').textContent = `Menampilkan ${startIndex + 1}-${endIndex} dari ${totalItems} data pinjaman`;

            // Pagination Controls
            renderPaginationControls(totalItems);
        }

        // Render Pagination buttons
        function renderPaginationControls(totalItems) {
            const container = document.getElementById('paginationControls');
            container.innerHTML = '';

            const totalPages = Math.ceil(totalItems / itemsPerPage);
            if (totalPages <= 1) return;

            // Previous Button
            const prevBtn = document.createElement('button');
            prevBtn.disabled = (currentPage === 1);
            prevBtn.onclick = () => { if (currentPage > 1) { currentPage--; renderTable(); } };
            prevBtn.className = `p-1 rounded bg-[#0d0f1d] border border-[#1f243d] text-[#8f9bb3] hover:text-white disabled:opacity-30 disabled:pointer-events-none transition duration-150`;
            prevBtn.innerHTML = '<i data-lucide="chevron-left" class="w-3.5 h-3.5"></i>';
            container.appendChild(prevBtn);

            // Page numbers logic
            const range = [];
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                    range.push(i);
                } else if (range[range.length - 1] !== '...') {
                    range.push('...');
                }
            }

            range.forEach(p => {
                if (p === '...') {
                    const dots = document.createElement('span');
                    dots.className = 'px-2 text-xs text-[#8f9bb3]';
                    dots.textContent = '...';
                    container.appendChild(dots);
                } else {
                    const btn = document.createElement('button');
                    btn.onclick = () => { currentPage = p; renderTable(); };
                    btn.className = `w-6 h-6 rounded text-xs font-semibold transition duration-150 ${currentPage === p ? 'bg-[#2f54eb] text-white' : 'bg-[#0d0f1d] border border-[#1f243d] text-[#8f9bb3] hover:text-white'}`;
                    btn.textContent = p;
                    container.appendChild(btn);
                }
            });

            // Next Button
            const nextBtn = document.createElement('button');
            nextBtn.disabled = (currentPage === totalPages);
            nextBtn.onclick = () => { if (currentPage < totalPages) { currentPage++; renderTable(); } };
            nextBtn.className = `p-1 rounded bg-[#0d0f1d] border border-[#1f243d] text-[#8f9bb3] hover:text-white disabled:opacity-30 disabled:pointer-events-none transition duration-150`;
            nextBtn.innerHTML = '<i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>';
            container.appendChild(nextBtn);

            lucide.createIcons();
        }

        // Show Detail Modal
        function showDetail(id) {
            const loan = originalLoans.find(l => l.id === id);
            if (!loan) return;

            document.getElementById('detailLoanId').textContent = loan.formattedId;
            document.getElementById('detailLoanDate').textContent = loan.formattedDate;
            document.getElementById('detailMemberId').textContent = loan.memberId;
            document.getElementById('detailMemberName').textContent = loan.name;
            document.getElementById('detailAmount').textContent = formatRupiah(loan.amount);
            document.getElementById('detailTenor').textContent = loan.tenor + ' Bulan';
            document.getElementById('detailProgress').textContent = `${loan.paid} / ${loan.tenor} Bulan`;
            document.getElementById('detailRemaining').textContent = loan.remaining > 0 ? formatRupiah(loan.remaining) : 'Rp 0';
            
            const detailStatus = document.getElementById('detailStatus');
            detailStatus.textContent = loan.status.toUpperCase();
            detailStatus.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-bold inline-block border';
            if (loan.status === 'Lunas') {
                detailStatus.classList.add('bg-emerald-500/10', 'text-emerald-400', 'border-emerald-500/20');
            } else if (loan.status === 'Menunggak') {
                detailStatus.classList.add('bg-rose-500/10', 'text-rose-400', 'border-rose-500/20');
            } else {
                detailStatus.classList.add('bg-blue-500/10', 'text-blue-400', 'border-blue-500/20');
            }

            document.getElementById('detailLoanModal').classList.remove('hidden');
        }

        function closeDetailLoanModal() {
            document.getElementById('detailLoanModal').classList.add('hidden');
        }

        // Searchable dropdown helpers for New Loan Modal
        function showMemberDropdown() {
            document.getElementById('memberDropdownList').classList.remove('hidden');
        }

        function filterMembers() {
            const val = document.getElementById('memberSearchInput').value.toLowerCase();
            const list = document.getElementById('memberDropdownList');
            const items = list.getElementsByTagName('div');
            
            for (let i = 0; i < items.length; i++) {
                const text = items[i].textContent.toLowerCase();
                if (text.includes(val)) {
                    items[i].classList.remove('hidden');
                } else {
                    items[i].classList.add('hidden');
                }
            }
            list.classList.remove('hidden');
        }

        function selectMember(id, displayText) {
            document.getElementById('selectedMemberId').value = id;
            document.getElementById('memberSearchInput').value = displayText;
            document.getElementById('memberDropdownList').classList.add('hidden');
        }

        // Hide dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const container = document.getElementById('memberSearchInput');
            const list = document.getElementById('memberDropdownList');
            if (container && list && !container.contains(e.target) && !list.contains(e.target)) {
                list.classList.add('hidden');
            }
        });

        // Real-time summary calculator
        function calculateSummary() {
            const nominalInput = document.getElementById('inputNominal');
            const tenorInput = document.getElementById('inputTenor');
            
            const nominal = parseFloat(nominalInput.value) || 0;
            const tenor = parseInt(tenorInput.value) || 0;
            
            const adminFee = nominal * 0.01;
            const totalReturn = nominal + adminFee;
            
            let monthlyPayment = 0;
            if (tenor > 0) {
                monthlyPayment = Math.round(totalReturn / tenor);
            }
            
            // Format currency helper
            function formatRupiahJs(val) {
                return 'Rp ' + new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0 }).format(val);
            }
            
            document.getElementById('summaryAdminFee').textContent = formatRupiahJs(adminFee);
            document.getElementById('summaryMonthlyPayment').textContent = formatRupiahJs(monthlyPayment);
            document.getElementById('summaryTotalReturn').textContent = formatRupiahJs(totalReturn);
        }

        // New Loan Modal Handlers
        function openNewLoanModal() {
            document.getElementById('selectedMemberId').value = '';
            document.getElementById('memberSearchInput').value = '';
            document.getElementById('inputNominal').value = '';
            document.getElementById('inputTenor').value = '';
            const textarea = document.querySelector('#newLoanModal textarea');
            if (textarea) textarea.value = '';
            calculateSummary();
            document.getElementById('newLoanModal').classList.remove('hidden');
        }

        function closeNewLoanModal() {
            document.getElementById('newLoanModal').classList.add('hidden');
        }

        // Reset Filter
        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('sortBy').value = 'date-desc';
            setFilterStatus('All');
        }

        // Pay Installment Modal handlers
        function openPayInstallmentModal(id) {
            const loan = originalLoans.find(l => l.id === id);
            if (!loan) return;
            
            // Set action URL dynamically
            document.getElementById('payInstallmentForm').action = `/pinjaman/${loan.id}/bayar`;
            
            // Set text values
            document.getElementById('payMemberName').textContent = loan.name;
            document.getElementById('payLoanAmount').textContent = formatRupiah(loan.amount);
            document.getElementById('payProgressText').textContent = `${loan.paid} / ${loan.tenor} Cicilan`;
            document.getElementById('payRemainingAmount').textContent = loan.remaining > 0 ? formatRupiah(loan.remaining) : 'Rp 0';
            
            // Set progress bar width
            const progressPercent = (loan.paid / loan.tenor) * 100;
            document.getElementById('payProgressBar').style.width = progressPercent + '%';
            
            // Set form values
            const nextInstallmentNo = parseInt(loan.paid) + 1;
            document.getElementById('payInstallmentNo').value = nextInstallmentNo;
            
            const remainingMonths = parseInt(loan.tenor) - parseInt(loan.paid);
            let installmentAmount = 0;
            if (remainingMonths > 0) {
                installmentAmount = Math.round(loan.remaining / remainingMonths);
            }
            document.getElementById('payInstallmentAmount').value = formatRupiah(installmentAmount);
            
            document.getElementById('payInstallmentModal').classList.remove('hidden');
        }
        
        function closePayInstallmentModal() {
            document.getElementById('payInstallmentModal').classList.add('hidden');
        }

        // Initial Load
        window.addEventListener('DOMContentLoaded', () => {
            applyFilters();
        });
    </script>
@endsection
