@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Transaksi Simpanan')

@section('content')
    <!-- PAGE HEADER CARD (Matching Customer Design) -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#2563EB] text-white flex items-center justify-center shadow-md shadow-blue-600/25 shrink-0">
                <i data-lucide="wallet" class="w-6 h-6 text-white" stroke="white"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-[#0F172A] tracking-tight">Transaksi Simpanan</h1>
                <p class="text-xs sm:text-sm text-[#64748B] mt-0.5">Kelola seluruh transaksi simpanan anggota koperasi secara terpadu.</p>
            </div>
        </div>
        
        <!-- Action Buttons Group -->
        <div class="flex items-center gap-2.5 flex-wrap">
            <a href="{{ route('simpanan.export') }}"
                class="inline-flex items-center gap-2 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white rounded-xl transition duration-150 text-xs font-bold shadow-md shadow-emerald-600/20">
                <i data-lucide="file-down" class="w-4 h-4"></i>
                <span>Export Excel</span>
            </a>
            
            <button type="button" onclick="openImportSimpananModal()"
                class="inline-flex items-center gap-2 px-3.5 py-2 border border-[#E2E8F0] bg-white text-[#0F172A] hover:bg-[#F8FAFC] rounded-xl transition duration-150 text-xs font-bold shadow-sm cursor-pointer">
                <i data-lucide="file-up" class="w-4 h-4 text-[#64748B]"></i>
                <span>Import Excel</span>
            </button>

            <button type="button" onclick="openNewTransactionModal()" 
                class="inline-flex items-center gap-2 px-4 py-2 bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-xl transition duration-150 text-xs font-bold shadow-md shadow-blue-600/25 cursor-pointer">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah Simpanan</span>
            </button>
        </div>
    </div>

    <!-- Metrics Overview Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Card 1: Total Simpanan -->
        <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-100 text-[#2563EB] flex items-center justify-center shrink-0">
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                </div>
                <p class="text-xs font-bold text-[#64748B] uppercase tracking-wider">Total Simpanan</p>
            </div>
            <div class="flex items-baseline justify-between mt-2">
                <h3 class="text-xl font-extrabold text-[#0F172A]" id="metric-total">Rp {{ number_format((int) $totalSimpanan, 0, ',', '.') }}</h3>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700">+12.5%</span>
            </div>
        </div>

        <!-- Card 2: Simpanan Pokok -->
        <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-100 text-[#2563EB] flex items-center justify-center shrink-0">
                    <i data-lucide="landmark" class="w-4 h-4"></i>
                </div>
                <p class="text-xs font-bold text-[#64748B] uppercase tracking-wider">Simpanan Pokok</p>
            </div>
            <h3 class="text-xl font-extrabold text-[#0F172A] mt-2" id="metric-pokok">Rp {{ number_format((int) $totalPokok, 0, ',', '.') }}</h3>
        </div>

        <!-- Card 3: Simpanan Wajib -->
        <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 rounded-lg bg-purple-50 border border-purple-100 text-purple-600 flex items-center justify-center shrink-0">
                    <i data-lucide="coins" class="w-4 h-4"></i>
                </div>
                <p class="text-xs font-bold text-[#64748B] uppercase tracking-wider">Simpanan Wajib</p>
            </div>
            <h3 class="text-xl font-extrabold text-[#0F172A] mt-2" id="metric-wajib">Rp {{ number_format((int) $totalWajib, 0, ',', '.') }}</h3>
        </div>

        <!-- Card 4: Simpanan Sukarela -->
        <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                    <i data-lucide="piggy-bank" class="w-4 h-4"></i>
                </div>
                <p class="text-xs font-bold text-[#64748B] uppercase tracking-wider">Simpanan Sukarela</p>
            </div>
            <h3 class="text-xl font-extrabold text-[#0F172A] mt-2" id="metric-sukarela">Rp {{ number_format((int) $totalSukarela, 0, ',', '.') }}</h3>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-6 shadow-sm mb-6 space-y-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h3 class="text-sm font-bold text-[#0F172A] uppercase tracking-wider">Perkembangan Simpanan</h3>
                <p class="text-xs text-[#64748B] mt-0.5">Grafik akumulasi dana simpanan tahun berjalan</p>
            </div>
            
            <!-- Chart Filters -->
            <div class="flex items-center gap-4 flex-wrap">
                <!-- Legend -->
                <div class="flex items-center gap-2 text-xs font-bold text-[#64748B]">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#2563EB]"></span>
                    <span>Total Dana ({{ $chartDataSets['unit'] }})</span>
                </div>
                <!-- Time Range -->
                <div class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-1 flex">
                    <button onclick="changeChartRange('daily')" class="chart-tab px-3 py-1 text-xs font-bold rounded-lg text-[#64748B] hover:text-[#0F172A] transition">Harian</button>
                    <button onclick="changeChartRange('weekly')" class="chart-tab px-3 py-1 text-xs font-bold rounded-lg text-[#64748B] hover:text-[#0F172A] transition">Mingguan</button>
                    <button onclick="changeChartRange('monthly')" class="chart-tab px-3 py-1 text-xs font-bold rounded-lg bg-[#2563EB] text-white shadow-sm transition">Bulanan</button>
                    <button onclick="changeChartRange('quarterly')" class="chart-tab px-3 py-1 text-xs font-bold rounded-lg text-[#64748B] hover:text-[#0F172A] transition">Triwulan</button>
                    <button onclick="changeChartRange('yearly')" class="chart-tab px-3 py-1 text-xs font-bold rounded-lg text-[#64748B] hover:text-[#0F172A] transition">Tahunan</button>
                </div>
            </div>
        </div>
        
        <!-- Canvas wrapper -->
        <div class="h-64 w-full relative">
            <canvas id="simpananChart"></canvas>
        </div>
    </div>

    <!-- Data Table & Search controls Section -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-6 shadow-sm space-y-6">
        <!-- Title Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h3 class="text-sm font-bold text-[#0F172A] uppercase tracking-wider">Daftar Transaksi Simpanan</h3>
                <p class="text-xs text-[#64748B] mt-0.5">Daftar riwayat transaksi simpanan anggota</p>
            </div>
        </div>

        <!-- Search, Filter Tabs, and Sort bar -->
        <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4">
            <!-- Left: Search and Filters -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-grow max-w-2xl">
                <!-- Search input -->
                <div class="relative flex-grow max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#64748B]">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" id="transactionSearch" oninput="filterTransactions()" placeholder="Cari nama atau ID anggota..." class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-10 pr-4 py-2 text-xs text-[#0F172A] placeholder-[#94A3B8] focus:outline-none focus:border-[#2563EB]">
                </div>

                <!-- Tab filters -->
                <div class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-1 flex">
                    <button onclick="setFilterType('Semua')" class="filter-tab px-3 py-1.5 text-xs font-bold rounded-lg bg-[#2563EB] text-white shadow-sm transition">Semua</button>
                    <button onclick="setFilterType('Pokok')" class="filter-tab px-3 py-1.5 text-xs font-bold rounded-lg text-[#64748B] hover:text-[#0F172A] transition">Pokok</button>
                    <button onclick="setFilterType('Wajib')" class="filter-tab px-3 py-1.5 text-xs font-bold rounded-lg text-[#64748B] hover:text-[#0F172A] transition">Wajib</button>
                    <button onclick="setFilterType('Sukarela')" class="filter-tab px-3 py-1.5 text-xs font-bold rounded-lg text-[#64748B] hover:text-[#0F172A] transition">Sukarela</button>
                </div>
            </div>

            <!-- Right: Sort filter -->
            <div class="flex items-center justify-end gap-2.5">
                <span class="text-xs font-bold text-[#64748B] uppercase tracking-wider">Urutan:</span>
                <div class="relative">
                    <select id="sortSelect" onchange="sortTransactions()" class="appearance-none bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-3.5 pr-8 py-2 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB] cursor-pointer font-semibold">
                        <option value="terbaru">Terbaru</option>
                        <option value="terlama">Terlama</option>
                        <option value="nominal-tinggi">Nominal Tertinggi</option>
                        <option value="nominal-rendah">Nominal Terendah</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[#64748B]">
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="overflow-x-auto">
            <table id="transactionsTable" class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="border-b border-[#E2E8F0] bg-[#F8FAFC] text-[#64748B] text-[11px] font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-bold w-[15%]">Tanggal</th>
                        <th class="py-3.5 px-4 font-bold w-[15%]">ID Anggota</th>
                        <th class="py-3.5 px-4 font-bold w-[25%]">Nama Anggota</th>
                        <th class="py-3.5 px-4 font-bold w-[15%]">Jenis Simpanan</th>
                        <th class="py-3.5 px-4 font-bold w-[10%]">Nominal</th>
                        <th class="py-3.5 px-4 font-bold w-[10%]">Status</th>
                        <th class="py-3.5 px-4 font-bold text-center w-[10%]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E8F0]">
                    <!-- Rows injected by JS -->
                </tbody>
            </table>

            <!-- Empty Search State -->
            <div id="emptyState" class="hidden py-12 flex flex-col items-center justify-center text-center space-y-3">
                <div class="w-12 h-12 rounded-full bg-[#F8FAFC] border border-[#E2E8F0] text-[#64748B] flex items-center justify-center">
                    <i data-lucide="search-code" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-[#0F172A]">Transaksi Tidak Ditemukan</p>
                    <p class="text-xs text-[#64748B]">Coba gunakan kata kunci pencarian yang lain.</p>
                </div>
            </div>
        </div>

        <!-- Pagination Footer -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-4 border-t border-[#E2E8F0]">
            <p id="paginationInfo" class="text-xs font-semibold text-[#64748B]">Menampilkan 10 dari 1,240 transaksi</p>
            
            <div class="flex items-center gap-1">
                <button onclick="prevPage()" class="p-2 border border-[#E2E8F0] rounded-xl bg-white text-[#64748B] hover:text-[#0F172A] hover:bg-[#F8FAFC] transition disabled:opacity-30 disabled:pointer-events-none cursor-pointer">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </button>
                <div id="paginationButtons" class="flex items-center gap-1">
                    <!-- Dynamic page numbers -->
                </div>
                <button onclick="nextPage()" class="p-2 border border-[#E2E8F0] rounded-xl bg-white text-[#64748B] hover:text-[#0F172A] hover:bg-[#F8FAFC] transition disabled:opacity-30 disabled:pointer-events-none cursor-pointer">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    </div>

@push('modals')
    <!-- MODAL 1: NEW TRANSACTION MODAL -->
    <div id="transactionModal" class="fixed inset-0 flex items-center justify-center p-4 hidden transition-opacity z-[999] bg-slate-900/50 backdrop-blur-sm">
        <div class="bg-white border border-[#E2E8F0] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-3 border-b border-[#E2E8F0]">
                <h3 class="text-base font-extrabold text-[#0F172A]">Tambah Simpanan Baru</h3>
                <button type="button" onclick="closeNewTransactionModal()" class="text-[#64748B] hover:text-[#0F172A] transition-colors cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <!-- Form Inputs -->
            <form id="transactionForm" action="{{ route('simpanan.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Anggota <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#64748B]">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </span>
                        <select id="txMemberSelect" name="anggota_id" required class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-10 pr-10 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB] appearance-none">
                            <option value="" disabled selected>Cari nama atau ID anggota...</option>
                            @forelse($anggota as $member)
                                <option value="{{ $member->id }}">{{ $member->id_anggota ?? 'AGT-' . str_pad($member->id, 5, '0', STR_PAD_LEFT) }} - {{ $member->nama }}</option>
                            @empty
                                <option value="" disabled>Belum ada anggota di database</option>
                            @endforelse
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[#64748B]">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Jenis Simpanan <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#64748B]">
                            <i data-lucide="wallet" class="w-4 h-4"></i>
                        </span>
                        <select id="txTypeSelect" name="jenis_simpanan" required class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-10 pr-10 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB] appearance-none">
                            <option value="Pokok">Simpanan Pokok</option>
                            <option value="Wajib">Simpanan Wajib</option>
                            <option value="Sukarela">Simpanan Sukarela</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[#64748B]">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Nominal Simpanan <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-xs font-bold text-[#64748B]">Rp</span>
                            <input type="number" id="txAmount" name="nominal" required placeholder="Masukkan nominal" min="1000" class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-10 pr-4 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Tanggal Transaksi <span class="text-rose-500">*</span></label>
                        <input type="date" id="txDate" name="tanggal_transaksi" required class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB]">
                    </div>
                </div>

                <input type="hidden" name="status" id="txStatus" value="Lunas">

                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Keterangan (Opsional)</label>
                    <textarea name="keterangan" rows="3" placeholder="Tambahkan keterangan..." class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] placeholder-[#94A3B8] focus:outline-none focus:border-[#2563EB]"></textarea>
                </div>
                
                <div class="flex items-center gap-3 pt-4 border-t border-[#E2E8F0] justify-end">
                    <button type="button" onclick="closeNewTransactionModal()" class="px-5 py-2.5 border border-[#E2E8F0] bg-[#F1F5F9] text-[#475569] rounded-xl text-xs font-bold hover:bg-[#E2E8F0] transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/25 transition cursor-pointer">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: DETAIL TRANSACTION MODAL -->
    <div id="detailTransactionModal" class="fixed inset-0 flex items-center justify-center p-4 hidden transition-opacity z-[999] bg-slate-900/50 backdrop-blur-sm">
        <div class="bg-white border border-[#E2E8F0] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-[#E2E8F0]">
                <h3 class="text-base font-extrabold text-[#0F172A]">Detail Transaksi Simpanan</h3>
                <button onclick="closeDetailTransactionModal()" class="text-[#64748B] hover:text-[#0F172A] transition-colors cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-2 gap-4 text-left">
                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">ID Transaksi</label>
                    <span class="text-sm font-bold text-[#0F172A]" id="detailTxId">TX-000001</span>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Tanggal</label>
                    <span class="text-sm font-bold text-[#0F172A]" id="detailTxDate">12 Mar 2024</span>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">ID Anggota</label>
                    <span class="text-sm font-bold text-[#0F172A]" id="detailMemberId">KSP-0021</span>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Nama Anggota</label>
                    <span class="text-sm font-bold text-[#0F172A]" id="detailMemberName">Budi Satria</span>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Jenis Simpanan</label>
                    <div id="detailTxTypeBadge" class="mt-1"></div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Nominal</label>
                    <span class="text-sm font-extrabold text-[#2563EB]" id="detailTxAmount">Rp 500.000</span>
                </div>

                <div class="col-span-2 pt-3 border-t border-[#E2E8F0]">
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Keterangan</label>
                    <p class="text-xs text-[#0F172A] font-medium leading-relaxed" id="detailTxDesc">Setoran rutin bulanan Mei 2024.</p>
                </div>
            </div>
            
            <div class="flex justify-end pt-2 border-t border-[#E2E8F0]">
                <button type="button" onclick="closeDetailTransactionModal()" class="px-5 py-2.5 rounded-xl border border-[#E2E8F0] bg-[#F1F5F9] text-[#475569] text-xs font-bold hover:bg-[#E2E8F0] transition cursor-pointer">Tutup</button>
            </div>
        </div>
    </div>

    <!-- MODAL 3: EDIT TRANSACTION MODAL -->
    <div id="editTransactionModal" class="fixed inset-0 flex items-center justify-center p-4 hidden transition-opacity z-[999] bg-slate-900/50 backdrop-blur-sm">
        <div class="bg-white border border-[#E2E8F0] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex justify-between items-center pb-3 border-b border-[#E2E8F0]">
                <h3 class="text-base font-extrabold text-[#0F172A]">Ubah Transaksi Simpanan</h3>
                <button onclick="closeEditTransactionModal()" class="text-[#64748B] hover:text-[#0F172A] transition-colors cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="editTransactionForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Anggota</label>
                    <input type="text" id="editTxMemberText" disabled class="w-full bg-[#F1F5F9] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#64748B] font-semibold cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Jenis Simpanan</label>
                    <input type="text" id="editTxTypeText" disabled class="w-full bg-[#F1F5F9] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#64748B] font-semibold cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Nominal (Rupiah) <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#64748B] text-xs font-bold">Rp</span>
                        <input type="number" id="editTxAmount" name="nominal" required min="1000" class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-10 pr-4 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Tanggal Transaksi <span class="text-rose-500">*</span></label>
                    <input type="date" id="editTxDate" name="tanggal_transaksi" required class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Status <span class="text-rose-500">*</span></label>
                    <select id="editTxStatus" name="status" required class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB]">
                        <option value="Aktif">Aktif</option>
                        <option value="Lunas">Lunas</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Keterangan</label>
                    <textarea id="editTxDesc" name="keterangan" rows="2" class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2 text-xs text-[#0F172A] placeholder-[#94A3B8] focus:outline-none focus:border-[#2563EB]"></textarea>
                </div>
                
                <div class="flex items-center gap-3 pt-4 border-t border-[#E2E8F0] justify-end">
                    <button type="button" onclick="closeEditTransactionModal()" class="px-5 py-2.5 rounded-xl border border-[#E2E8F0] bg-[#F1F5F9] text-[#475569] text-xs font-bold hover:bg-[#E2E8F0] transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/25 transition cursor-pointer">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 4: IMPORT SIMPANAN MODAL -->
    <div id="importSimpananModal" class="fixed inset-0 z-[999] hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm px-4">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-[#E2E8F0] overflow-hidden space-y-4 p-6">
            <div class="flex items-center justify-between pb-3 border-b border-[#E2E8F0]">
                <div>
                    <h3 class="text-base font-extrabold text-[#0F172A]">Import Data Simpanan</h3>
                    <p class="text-xs text-[#64748B] mt-0.5">Import data simpanan menggunakan file Excel.</p>
                </div>
                <button type="button" onclick="closeImportSimpananModal()" class="text-[#64748B] hover:text-[#0F172A] transition cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('simpanan.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="p-4 bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl flex items-start gap-3">
                    <div class="p-2 bg-blue-50 border border-blue-100 rounded-lg shrink-0 text-[#2563EB]">
                        <i data-lucide="file-spreadsheet" class="w-5 h-5"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-[#0F172A]">Format Excel</p>
                        <p class="text-xs text-[#64748B] mt-0.5">Gunakan template agar format kolom sesuai dengan sistem.</p>
                        <a href="{{ route('simpanan.template') }}" class="inline-flex items-center gap-2 mt-3 px-3.5 py-1.5 bg-[#2563EB] hover:bg-[#1D4ED8] text-white text-xs font-bold rounded-lg transition shadow-sm">
                            <i data-lucide="download" class="w-3.5 h-3.5"></i>
                            Download Template
                        </a>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Pilih File Excel</label>
                    <input type="file" name="file" accept=".xlsx,.xls" required class="block w-full text-xs text-[#64748B] bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-3 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-[#2563EB] file:text-white file:text-xs file:font-bold hover:file:bg-[#1D4ED8] cursor-pointer">
                    <p class="text-[10px] text-[#94A3B8] mt-1.5">Format: .xlsx atau .xls — maksimal 5 MB</p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#E2E8F0]">
                    <button type="button" onclick="closeImportSimpananModal()" class="px-5 py-2.5 rounded-xl border border-[#E2E8F0] bg-[#F1F5F9] text-[#475569] text-xs font-bold hover:bg-[#E2E8F0] transition cursor-pointer">Batal</button>
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#2563EB] hover:bg-[#1D4ED8] text-white text-xs font-bold transition shadow-md shadow-blue-600/25 cursor-pointer">
                        <i data-lucide="upload" class="w-3.5 h-3.5"></i>
                        Import Excel
                    </button>
                </div>
            </form>
        </div>
    </div>
@endpush
@endsection

@section('scripts')
    <script>
        function openImportSimpananModal() {
            const modal = document.getElementById('importSimpananModal');
            if (!modal) return;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeImportSimpananModal() {
            const modal = document.getElementById('importSimpananModal');
            if (!modal) return;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        const originalTransactions = @json($transactions);

        let currentTransactions = [...originalTransactions];
        let filterType = 'Semua';
        let searchQuery = '';
        let currentSort = 'terbaru';
        let currentPage = 1;
        const rowsPerPage = 10;
        let chartInstance = null;

        const chartDataSets = @json($chartDataSets);

        const rangeLabels = {
            daily: 'harian',
            weekly: 'mingguan',
            monthly: 'bulanan',
            quarterly: 'triwulan',
            yearly: 'tahunan'
        };

        document.addEventListener('DOMContentLoaded', () => {
            renderTable();
            initChart('monthly');
            
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('action') === 'new') {
                openNewTransactionModal();
            }
        });

        function openNewTransactionModal() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('txDate').value = today;
            document.getElementById('transactionModal').classList.remove('hidden');
        }

        function closeNewTransactionModal() {
            document.getElementById('transactionModal').classList.add('hidden');
            document.getElementById('transactionForm').reset();
        }

        async function showTransactionDetail(txId) {
            try {
                const response = await fetch(`/simpanan/${txId}`);
                if (!response.ok) throw new Error('Failed to fetch transaction details');
                const tx = await response.json();

                document.getElementById('detailTxId').textContent = tx.formattedId;
                document.getElementById('detailTxDate').textContent = tx.date;
                document.getElementById('detailMemberId').textContent = tx.memberId;
                document.getElementById('detailMemberName').textContent = tx.name;
                document.getElementById('detailTxAmount').textContent = `Rp ${tx.amount.toLocaleString('id-ID')}`;
                document.getElementById('detailTxDesc').textContent = tx.keterangan || '-';

                const badgeContainer = document.getElementById('detailTxTypeBadge');
                badgeContainer.innerHTML = '';
                
                let typeBadge = '';
                if(tx.type === 'Pokok') {
                    typeBadge = `<span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-[#2563EB] border border-blue-100">Simpanan Pokok</span>`;
                } else if(tx.type === 'Wajib') {
                    typeBadge = `<span class="px-2.5 py-1 rounded-full text-xs font-bold bg-purple-50 text-purple-600 border border-purple-100">Simpanan Wajib</span>`;
                } else {
                    typeBadge = `<span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">Simpanan Sukarela</span>`;
                }
                badgeContainer.innerHTML = typeBadge;

                document.getElementById('detailTransactionModal').classList.remove('hidden');
                if (window.lucide) lucide.createIcons();
            } catch (err) {
                console.error(err);
                alert('Gagal mengambil data detail transaksi dari server.');
            }
        }

        function closeDetailTransactionModal() {
            document.getElementById('detailTransactionModal').classList.add('hidden');
        }

        async function showTransactionEdit(txId) {
            try {
                const response = await fetch(`/simpanan/${txId}`);
                if (!response.ok) throw new Error('Failed to fetch transaction details');
                const tx = await response.json();

                document.getElementById('editTxMemberText').value = `${tx.name} (${tx.memberId})`;
                document.getElementById('editTxTypeText').value = `Simpanan ${tx.type}`;
                document.getElementById('editTxAmount').value = tx.amount;
                document.getElementById('editTxDate').value = tx.rawDate;
                document.getElementById('editTxStatus').value = tx.status;
                document.getElementById('editTxDesc').value = tx.keterangan !== '-' ? tx.keterangan : '';

                const form = document.getElementById('editTransactionForm');
                form.action = `/simpanan/${tx.id}`;

                document.getElementById('editTransactionModal').classList.remove('hidden');
            } catch (err) {
                console.error(err);
                alert('Gagal mengambil data transaksi untuk diedit.');
            }
        }

        function closeEditTransactionModal() {
            document.getElementById('editTransactionModal').classList.add('hidden');
        }

        function setFilterType(type) {
            filterType = type;
            
            const tabs = document.querySelectorAll('.filter-tab');
            tabs.forEach(tab => {
                if (tab.textContent.trim().toLowerCase() === type.toLowerCase()) {
                    tab.classList.add('bg-[#2563EB]', 'text-white', 'shadow-sm');
                    tab.classList.remove('text-[#64748B]', 'hover:text-[#0F172A]');
                } else {
                    tab.classList.remove('bg-[#2563EB]', 'text-white', 'shadow-sm');
                    tab.classList.add('text-[#64748B]', 'hover:text-[#0F172A]');
                }
            });

            filterTransactions();
        }

        function filterTransactions() {
            searchQuery = document.getElementById('transactionSearch').value.toLowerCase().trim();

            currentTransactions = originalTransactions.filter(tx => {
                const matchesSearch = tx.name.toLowerCase().includes(searchQuery) || tx.memberId.toLowerCase().includes(searchQuery);
                const matchesType = filterType === 'Semua' || tx.type.toLowerCase() === filterType.toLowerCase();
                return matchesSearch && matchesType;
            });

            sortTransactions();
        }

        function sortTransactions() {
            currentSort = document.getElementById('sortSelect').value;

            if (currentSort === 'terbaru') {
                currentTransactions.sort((a, b) => new Date(b.rawDate) - new Date(a.rawDate));
            } else if (currentSort === 'terlama') {
                currentTransactions.sort((a, b) => new Date(a.rawDate) - new Date(b.rawDate));
            } else if (currentSort === 'nominal-tinggi') {
                currentTransactions.sort((a, b) => b.amount - a.amount);
            } else if (currentSort === 'nominal-rendah') {
                currentTransactions.sort((a, b) => a.amount - b.amount);
            }

            currentPage = 1;
            renderTable();
        }

        function renderTable() {
            const tbody = document.querySelector('#transactionsTable tbody');
            tbody.innerHTML = '';

            const totalRecords = currentTransactions.length;

            if (totalRecords === 0) {
                document.getElementById('emptyState').classList.remove('hidden');
                document.getElementById('paginationInfo').textContent = 'Menampilkan 0 dari 0 transaksi';
                renderPagination(0);
                return;
            }

            document.getElementById('emptyState').classList.add('hidden');

            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = Math.min(startIndex + rowsPerPage, totalRecords);
            const paginatedData = currentTransactions.slice(startIndex, endIndex);

            paginatedData.forEach(tx => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-[#F8FAFC] transition duration-150';

                let typeBadge = '';
                if(tx.type === 'Pokok') {
                    typeBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-[#2563EB] border border-blue-100">Pokok</span>`;
                } else if(tx.type === 'Wajib') {
                    typeBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-purple-50 text-purple-600 border border-purple-100">Wajib</span>`;
                } else {
                    typeBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">Sukarela</span>`;
                }

                let statusBadge = '';
                if(tx.status === 'Aktif') {
                    statusBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-[#2563EB] border border-blue-100">Aktif</span>`;
                } else {
                    statusBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">Lunas</span>`;
                }

                tr.innerHTML = `
                    <td class="py-4 px-4 text-xs text-[#64748B] w-[15%]">${tx.date}</td>
                    <td class="py-4 px-4 text-xs font-semibold text-[#2563EB] w-[15%]">
                        <span class="bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-md text-xs">${tx.memberId}</span>
                    </td>
                    <td class="py-4 px-4 text-xs font-bold text-[#0F172A] w-[25%]"><a href="{{ url('/anggota') }}/${tx.memberDbId}" class="hover:text-[#2563EB] hover:underline transition-colors">${tx.name}</a></td>
                    <td class="py-4 px-4 text-xs w-[15%]">${typeBadge}</td>
                    <td class="py-4 px-4 text-xs font-extrabold text-[#0F172A] w-[10%]">Rp ${tx.amount.toLocaleString('id-ID')}</td>
                    <td class="py-4 px-4 text-xs w-[10%]">${statusBadge}</td>
                    <td class="py-4 px-4 text-center w-[10%]">
                        <div class="flex items-center justify-center gap-1.5">
                            <button onclick="showTransactionDetail(${tx.id})" class="w-8 h-8 rounded-xl bg-blue-50 text-[#2563EB] border border-blue-200/80 flex items-center justify-center hover:bg-[#2563EB] hover:text-white transition-all duration-150 cursor-pointer shadow-sm group" title="Lihat Detail">
                                <i data-lucide="eye" class="w-4 h-4 text-[#2563EB] group-hover:text-white"></i>
                            </button>
                            <button onclick="showTransactionEdit(${tx.id})" class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 border border-amber-200/80 flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all duration-150 cursor-pointer shadow-sm group" title="Ubah Data">
                                <i data-lucide="edit-3" class="w-4 h-4 text-amber-600 group-hover:text-white"></i>
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            if (window.lucide) lucide.createIcons();

            document.getElementById('paginationInfo').textContent = `Menampilkan ${startIndex + 1}-${endIndex} dari ${totalRecords} transaksi`;
            renderPagination(totalRecords);
        }

        function renderPagination(totalRecords) {
            const paginationButtons = document.getElementById('paginationButtons');
            paginationButtons.innerHTML = '';

            const totalPages = Math.ceil(totalRecords / rowsPerPage);

            if (totalPages <= 1) {
                document.querySelector('button[onclick="prevPage()"]').disabled = true;
                document.querySelector('button[onclick="nextPage()"]').disabled = true;
                return;
            }

            document.querySelector('button[onclick="prevPage()"]').disabled = currentPage === 1;
            document.querySelector('button[onclick="nextPage()"]').disabled = currentPage === totalPages;

            for (let i = 1; i <= totalPages; i++) {
                if(totalPages > 5 && i > 3 && i < totalPages) {
                    if (i === 4) {
                        const span = document.createElement('span');
                        span.className = 'text-xs text-[#64748B] px-1.5';
                        span.textContent = '...';
                        paginationButtons.appendChild(span);
                    }
                    continue;
                }

                const button = document.createElement('button');
                button.className = `w-8 h-8 flex items-center justify-center text-xs font-bold rounded-lg transition duration-150 cursor-pointer ${
                    currentPage === i 
                    ? 'bg-[#2563EB] text-white shadow-sm' 
                    : 'bg-white text-[#64748B] border border-[#E2E8F0] hover:text-[#0F172A] hover:bg-[#F8FAFC]'
                }`;
                button.textContent = i;
                button.onclick = () => {
                    currentPage = i;
                    renderTable();
                };
                paginationButtons.appendChild(button);
            }
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        }

        function nextPage() {
            const totalPages = Math.ceil(currentTransactions.length / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        }

        let activeRangeType = 'monthly';

        function initChart(rangeType) {
            const dataConfig = chartDataSets[rangeType];
            if (!dataConfig) return;

            activeRangeType = rangeType;
            const ctx = document.getElementById('simpananChart').getContext('2d');

            if (chartInstance) {
                chartInstance.destroy();
            }

            const gradientFill = ctx.createLinearGradient(0, 0, 0, 240);
            gradientFill.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
            gradientFill.addColorStop(1, 'rgba(37, 99, 235, 0)');

            chartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dataConfig.labels,
                    datasets: [{
                        label: `Total Dana (${chartDataSets.unit})`,
                        data: dataConfig.data,
                        borderColor: '#2563EB',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#2563EB',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointRadius: rangeType === 'weekly' || rangeType === 'daily' ? 5 : 3.5,
                        pointHoverRadius: 6,
                        tension: 0.35,
                        fill: true,
                        backgroundColor: gradientFill
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#FFFFFF',
                            titleColor: '#0F172A',
                            titleFont: { size: 10, weight: 'bold', family: 'Plus Jakarta Sans' },
                            bodyColor: '#64748B',
                            bodyFont: { size: 12, weight: 'bold', family: 'Plus Jakarta Sans' },
                            borderColor: '#E2E8F0',
                            borderWidth: 1,
                            padding: 10,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return `Rp ${context.raw} ${chartDataSets.unit}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: '#64748B',
                                font: { size: 10, family: 'Plus Jakarta Sans' }
                            }
                        },
                        y: {
                            grid: { color: '#E2E8F0' },
                            ticks: {
                                color: '#64748B',
                                font: { size: 10, family: 'Plus Jakarta Sans' },
                                callback: function(value) {
                                    return `Rp ${value}${chartDataSets.unit === 'Miliar' ? 'M' : 'Jt'}`;
                                }
                            }
                        }
                    }
                }
            });
        }

        function changeChartRange(rangeType) {
            const tabs = document.querySelectorAll('.chart-tab');
            tabs.forEach(tab => {
                if (tab.textContent.trim().toLowerCase() === rangeLabels[rangeType]) {
                    tab.classList.add('bg-[#2563EB]', 'text-white', 'shadow-sm');
                    tab.classList.remove('text-[#64748B]', 'hover:text-[#0F172A]');
                } else {
                    tab.classList.remove('bg-[#2563EB]', 'text-white', 'shadow-sm');
                    tab.classList.add('text-[#64748B]', 'hover:text-[#0F172A]');
                }
            });

            initChart(rangeType);
        }
    </script>
@endsection