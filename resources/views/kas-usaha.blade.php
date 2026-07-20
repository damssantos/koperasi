@extends('layouts.app')

@section('title', 'Koperasi Modern - Kas Usaha')

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
        /* Style adjustments to match image exactly */
        .select-custom {
            background-color: #16192b;
            border-color: #1f243d;
        }
        body.light .select-custom {
            background-color: #ffffff;
            border-color: #cbd5e1;
        }
    </style>
@endsection

@section('content')
    <!-- Page Header Title and Action buttons -->
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 pb-6 border-b border-[#1f243d]">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Kas Usaha</h2>
            <p class="text-xs text-[#8f9bb3] mt-0.5">Kelola transaksi kas operasional bidang usaha koperasi</p>
        </div>
        
        <!-- Action Buttons Group -->
        <div class="flex items-center gap-3">
            <button onclick="openNewTransactionModal()" class="inline-flex items-center gap-2 px-3.5 py-2 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg transition duration-150 text-xs font-bold shadow-md shadow-blue-500/10">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                <span>Tambah Transaksi</span>
            </button>
        </div>
    </div>

    <!-- Metrics Overview Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Saldo Kas -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-6 hover:border-[#8f9bb3]/20 transition duration-300 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-blue-500/5 rounded-full blur-xl group-hover:bg-blue-500/10 transition-colors"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0" style="background-color: rgba(47, 84, 235, 0.1); border: 1px solid rgba(47, 84, 235, 0.2); color: #2f54eb;">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                </div>
                <span class="text-[9px] font-bold text-[#8f9bb3] bg-[#07080f]/60 px-2 py-1 rounded tracking-wider uppercase">KESELURUHAN</span>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#8f9bb3] mb-1">Saldo Kas</p>
                <h3 class="text-2xl font-extrabold text-white">{{ App\Support\NumberHelper::formatM($saldoKas) }}</h3>
            </div>
        </div>

        <!-- Card 2: Total Penerimaan -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-6 hover:border-[#8f9bb3]/20 transition duration-300 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/10 transition-colors"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0" style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399;">
                    <i data-lucide="trending-up" class="w-5 h-5"></i>
                </div>
                <span class="text-[9px] font-bold text-[#8f9bb3] bg-[#07080f]/60 px-2 py-1 rounded tracking-wider uppercase">KESELURUHAN</span>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#8f9bb3] mb-1">Total Penerimaan</p>
                <h3 class="text-2xl font-extrabold text-white">{{ App\Support\NumberHelper::formatM($totalPenerimaan) }}</h3>
            </div>
        </div>

        <!-- Card 3: Total Pengeluaran -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-6 hover:border-[#8f9bb3]/20 transition duration-300 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-rose-500/5 rounded-full blur-xl group-hover:bg-rose-500/10 transition-colors"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0" style="background-color: rgba(244, 63, 94, 0.1); border: 1px solid rgba(244, 63, 94, 0.2); color: #fb7185;">
                    <i data-lucide="trending-down" class="w-5 h-5"></i>
                </div>
                <span class="text-[9px] font-bold text-[#8f9bb3] bg-[#07080f]/60 px-2 py-1 rounded tracking-wider uppercase">KESELURUHAN</span>
            </div>
            <div>
                <p class="text-xs font-semibold text-[#8f9bb3] mb-1">Total Pengeluaran</p>
                <h3 class="text-2xl font-extrabold text-white">{{ App\Support\NumberHelper::formatM($totalPengeluaran) }}</h3>
            </div>
        </div>
    </div>

    <!-- Data Table & Search controls Section -->
    <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-6 space-y-6">
        <!-- Search, Filter Tabs, and Sort bar -->
        <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4">
            <!-- Left: Search and Filters -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-grow">
                <!-- Search input -->
                <div class="relative flex-grow max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#8f9bb3]">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" id="transactionSearch" oninput="filterTransactions()" placeholder="Cari transaksi..." class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-10 pr-4 py-2.5 text-xs text-white placeholder-slate-600 focus:outline-none focus:border-blue-500">
                </div>

                <!-- Transaction type filter dropdown -->
                <div class="relative">
                    <select id="typeFilter" onchange="filterTransactions()" class="appearance-none bg-[#07080f] border border-[#1f243d] rounded-lg pl-3.5 pr-8 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500 cursor-pointer font-semibold min-w-[150px]">
                        <option value="Semua">Semua Transaksi</option>
                        <option value="PENERIMAAN">Penerimaan</option>
                        <option value="PENGELUARAN">Pengeluaran</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[#8f9bb3]">
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                    </div>
                </div>

                <!-- Period filter dropdown -->
                <div class="relative">
                    <select id="periodFilter" onchange="filterTransactions()" class="appearance-none bg-[#07080f] border border-[#1f243d] rounded-lg pl-3.5 pr-8 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500 cursor-pointer font-semibold min-w-[130px]">
                        <option value="Semua">Filter Periode</option>
                        <option value="Hari Ini">Hari Ini</option>
                        <option value="Minggu Ini">Minggu Ini</option>
                        <option value="Bulan Ini">Bulan Ini</option>
                        <option value="Tahun Ini">Tahun Ini</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[#8f9bb3]">
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                    </div>
                </div>
            </div>

            <!-- Right: Sort filter -->
            <div class="flex items-center justify-end gap-2.5">
                <span class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Urutan:</span>
                <div class="relative">
                    <select id="sortSelect" onchange="sortTransactions()" class="appearance-none bg-[#07080f] border border-[#1f243d] rounded-lg pl-3.5 pr-8 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500 cursor-pointer font-semibold">
                        <option value="terbaru">Terbaru</option>
                        <option value="terlama">Terlama</option>
                        <option value="nominal-tinggi">Nominal Tertinggi</option>
                        <option value="nominal-rendah">Nominal Terendah</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[#8f9bb3]">
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                    </div>
                </div>
                
                <!-- Filter icon button -->
                <button onclick="resetFilters()" class="p-2.5 border border-[#1f243d] rounded-lg bg-[#07080f] text-[#8f9bb3] hover:text-white hover:bg-[#1f243d] transition-all" title="Reset Filter">
                    <i data-lucide="sliders-horizontal" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="overflow-x-auto">
            <table id="transactionsTable" class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="border-b border-[#1f243d] text-slate-100 text-[10px] font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-semibold w-[20%]">Tanggal</th>
                        <th class="py-3.5 px-4 font-semibold w-[15%]">Jenis Transaksi</th>
                        <th class="py-3.5 px-4 font-semibold w-[25%]">Keterangan</th>
                        <th class="py-3.5 px-4 font-semibold w-[15%]">Nominal</th>
                        <th class="py-3.5 px-4 font-semibold w-[15%]">Saldo Akhir</th>
                        <th class="py-3.5 px-4 font-semibold text-center w-[10%]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f243d]">
                    <!-- Rows will be injected by Javascript -->
                </tbody>
            </table>

            <!-- Empty Search State -->
            <div id="emptyState" class="hidden py-12 flex flex-col items-center justify-center text-center space-y-3">
                <div class="w-12 h-12 rounded-full bg-slate-800/40 border border-slate-700/20 text-slate-400 flex items-center justify-center">
                    <i data-lucide="search-code" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">Transaksi Tidak Ditemukan</p>
                    <p class="text-xs text-[#8f9bb3]">Coba gunakan kata kunci pencarian yang lain atau ubah filter.</p>
                </div>
            </div>
        </div>

        <!-- Pagination Footer -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-4 border-t border-[#1f243d]">
            <p id="paginationInfo" class="text-[10px] font-semibold text-[#8f9bb3] uppercase tracking-wider">Menampilkan 10 dari 156 transaksi</p>
            
            <div class="flex items-center gap-1">
                <button onclick="prevPage()" class="p-2 border border-[#1f243d] rounded-lg bg-[#16192b] text-[#8f9bb3] hover:text-white hover:bg-[#1f243d] transition disabled:opacity-30 disabled:pointer-events-none">
                    <i data-lucide="chevron-left" class="w-3.5 h-3.5"></i>
                </button>
                <div id="paginationButtons" class="flex items-center gap-1">
                    <!-- Dynamic page numbers -->
                </div>
                <button onclick="nextPage()" class="p-2 border border-[#1f243d] rounded-lg bg-[#16192b] text-[#8f9bb3] hover:text-white hover:bg-[#1f243d] transition disabled:opacity-30 disabled:pointer-events-none">
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                </button>
            </div>
        </div>
    </div>

@push('modals')
    <!-- NEW TRANSACTION MODAL -->
    <div id="transactionModal" class="fixed inset-0 flex items-center justify-center p-4 hidden transition-opacity" style="z-index: 9999; backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); background-color: rgba(7, 8, 15, 0.75);">
        <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4 animate-fade-in">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 border-b border-[#1f243d]">
                <h3 class="text-base font-bold text-white">Tambah Transaksi Kas</h3>
                <button onclick="closeNewTransactionModal()" class="text-slate-400 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <!-- Form Inputs -->
            <form id="transactionForm" action="{{ route('kas-usaha.store') }}" method="POST" class="space-y-4">
                @csrf
                <!-- Jenis Transaksi * -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Jenis Transaksi *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#8f9bb3]">
                            <i data-lucide="wallet" class="w-4 h-4"></i>
                        </span>
                        <select id="txTypeSelect" name="jenis_transaksi" required class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-10 pr-10 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500 appearance-none">
                            <option value="PENERIMAAN">Penerimaan</option>
                            <option value="PENGELUARAN">Pengeluaran</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[#8f9bb3]">
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                        </div>
                    </div>
                </div>

                <!-- Nominal & Tanggal Grid Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nominal * -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Nominal Simpanan *</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-xs font-bold text-[#8f9bb3]">Rp</span>
                            <input type="number" id="txAmount" name="nominal" required placeholder="Masukkan nominal" min="1000" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-10 pr-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Tanggal Transaksi * -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Tanggal Transaksi *</label>
                        <input type="date" id="txDate" name="tanggal" required class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <!-- Keterangan * -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Keterangan (Opsional)</label>
                    <textarea name="keterangan" rows="3" placeholder="Tulis deskripsi singkat transaksi..." class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white placeholder-slate-600 focus:outline-none focus:border-blue-500"></textarea>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center gap-3 pt-4 border-t border-[#1f243d] justify-end">
                    <button type="button" onclick="closeNewTransactionModal()" class="px-5 py-2.5 border border-[#1f243d] bg-[#16192b] hover:bg-[#1f243d] text-slate-300 rounded-lg text-xs font-semibold transition">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-[#2f54eb] hover:bg-blue-600 text-white rounded-lg text-xs font-bold shadow-lg shadow-blue-500/10 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- DETAIL TRANSACTION MODAL -->
    <div id="detailTransactionModal" class="fixed inset-0 flex items-center justify-center p-4 hidden transition-opacity" style="z-index: 9999; backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); background-color: rgba(7, 8, 15, 0.75);">
        <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-5 animate-fade-in">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 border-b border-[#1f243d]">
                <h3 class="text-base font-bold text-white">Detail Transaksi Kas</h3>
                <button onclick="closeDetailTransactionModal()" class="text-slate-400 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <!-- Modal Content Grid -->
            <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.25rem 1.5rem; text-align: left;">
                <!-- ID Transaksi -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">ID Transaksi</label>
                    <span class="text-sm font-bold text-white" id="detailTxId">-</span>
                </div>
                <!-- Tanggal -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">Tanggal</label>
                    <span class="text-sm font-bold text-white" id="detailTxDate">-</span>
                </div>

                <!-- Jenis Transaksi -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">Jenis Transaksi</label>
                    <div id="detailTxTypeBadge" class="mt-1">
                        <!-- Badge injected by JS -->
                    </div>
                </div>
                <!-- Nominal -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">Nominal</label>
                    <span class="text-sm font-bold text-white" id="detailTxAmount">-</span>
                </div>

                <!-- Keterangan -->
                <div style="grid-column: span 2 / span 2; padding-top: 1.25rem; border-top: 1px solid #1f243d;">
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">Keterangan</label>
                    <p class="text-xs text-slate-300 leading-relaxed font-normal" id="detailTxDesc">-</p>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT TRANSACTION MODAL -->
    <div id="editTransactionModal" class="fixed inset-0 flex items-center justify-center p-4 hidden transition-opacity" style="z-index: 9999; backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); background-color: rgba(7, 8, 15, 0.75);">
        <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4 animate-fade-in">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 border-b border-[#1f243d]">
                <h3 class="text-base font-bold text-white">Ubah Transaksi Kas</h3>
                <button onclick="closeEditTransactionModal()" class="text-slate-400 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <!-- Form Inputs -->
            <form id="editTransactionForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <!-- Jenis Transaksi * -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Jenis Transaksi *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#8f9bb3]">
                            <i data-lucide="wallet" class="w-4 h-4"></i>
                        </span>
                        <select id="editTxTypeSelect" name="jenis_transaksi" required class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-10 pr-10 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500 appearance-none">
                            <option value="PENERIMAAN">Penerimaan</option>
                            <option value="PENGELUARAN">Pengeluaran</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[#8f9bb3]">
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                        </div>
                    </div>
                </div>

                <!-- Nominal & Tanggal Grid Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nominal * -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Nominal Simpanan *</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#8f9bb3] text-xs font-bold">Rp</span>
                            <input type="number" id="editTxAmount" name="nominal" required min="1000" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-10 pr-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Tanggal Transaksi * -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Tanggal Transaksi *</label>
                        <input type="date" id="editTxDate" name="tanggal" required class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <!-- Keterangan * -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Keterangan (Opsional)</label>
                    <textarea id="editTxDesc" name="keterangan" rows="3" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500"></textarea>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center gap-3 pt-4 border-t border-[#1f243d] justify-end">
                    <button type="button" onclick="closeEditTransactionModal()" class="px-5 py-2.5 border border-[#1f243d] bg-[#16192b] hover:bg-[#1f243d] text-slate-300 rounded-lg text-xs font-semibold transition">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-[#2f54eb] hover:bg-blue-600 text-white rounded-lg text-xs font-bold shadow-lg shadow-blue-500/10 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endpush
@endsection

@section('scripts')
    <script>
        // Set values from Laravel
        const originalTransactions = @json($transactions);
        let currentTransactions = [...originalTransactions];
        
        let typeFilter = 'Semua';
        let periodFilter = 'Semua';
        let searchQuery = '';
        let currentSort = 'terbaru';
        let currentPage = 1;
        const rowsPerPage = 10;
        let selectedTxId = null;

        // Initialize Page
        document.addEventListener('DOMContentLoaded', () => {
            renderTable();
        });

        // Open Modal
        function openNewTransactionModal() {
            // Set current date format (Y-m-d)
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            document.getElementById('txDate').value = now.toISOString().slice(0, 10);
            document.getElementById('transactionModal').classList.remove('hidden');
        }

        // Close Modal
        function closeNewTransactionModal() {
            document.getElementById('transactionModal').classList.add('hidden');
            document.getElementById('transactionForm').reset();
        }

        // Show Details Modal
        async function showTransactionDetail(txId) {
            try {
                const response = await fetch(`/kas-usaha/${txId}`);
                if (!response.ok) throw new Error('Gagal mengambil data dari server.');
                const tx = await response.json();

                selectedTxId = tx.id;
                
                // Format transaction ID like: TX-241023-YPIK-00912
                const d = new Date(tx.tanggal);
                const yy = String(d.getFullYear()).slice(-2);
                const mm = String(d.getMonth() + 1).padStart(2, '0');
                const dd = String(d.getDate()).padStart(2, '0');
                const formattedDateForId = `${dd}${mm}${yy}`; // e.g. 241023
                document.getElementById('detailTxId').textContent = `TX-${formattedDateForId}-YPIK-${String(tx.id).padStart(5, '0')}`;
                
                // Format Date in Indonesian: 24 Okt 2023, 14:20
                const monthsId = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
                const formattedDateId = `${d.getDate()} ${monthsId[d.getMonth()]} ${d.getFullYear()}, ${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}`;
                document.getElementById('detailTxDate').textContent = formattedDateId;
                
                document.getElementById('detailTxAmount').textContent = `Rp ${tx.nominal.toLocaleString('id-ID')}`;
                document.getElementById('detailTxDesc').textContent = tx.keterangan || '-';

                // Set type badge (proper case)
                const badgeContainer = document.getElementById('detailTxTypeBadge');
                let typeBadge = '';
                if(tx.jenis_transaksi === 'PENERIMAAN') {
                    typeBadge = `<span class="px-3 py-1 rounded-full text-xs font-semibold" style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399;">Penerimaan</span>`;
                } else {
                    typeBadge = `<span class="px-3 py-1 rounded-full text-xs font-semibold" style="background-color: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.2); color: #c084fc;">Pengeluaran</span>`;
                }
                badgeContainer.innerHTML = typeBadge;

                document.getElementById('detailTransactionModal').classList.remove('hidden');
                lucide.createIcons();
            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal mengambil detail transaksi.',
                    confirmButtonColor: '#2f54eb',
                    background: '#16192b',
                    color: '#e2e8f0'
                });
            }
        }

        function closeDetailTransactionModal() {
            document.getElementById('detailTransactionModal').classList.add('hidden');
        }

        // Open edit form from detail modal
        async function openEditFromDetail() {
            closeDetailTransactionModal();
            showTransactionEdit(selectedTxId);
        }

        // Show Edit Modal
        async function showTransactionEdit(txId) {
            try {
                const response = await fetch(`/kas-usaha/${txId}`);
                if (!response.ok) throw new Error('Gagal mengambil data dari server.');
                const tx = await response.json();

                document.getElementById('editTxDate').value = tx.tanggal.substring(0, 10);
                document.getElementById('editTxTypeSelect').value = tx.jenis_transaksi;
                document.getElementById('editTxDesc').value = tx.keterangan;
                document.getElementById('editTxAmount').value = tx.nominal;

                // Set form action dynamically
                const form = document.getElementById('editTransactionForm');
                form.action = `/kas-usaha/${tx.id}`;

                document.getElementById('editTransactionModal').classList.remove('hidden');
            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal mengambil data transaksi.',
                    confirmButtonColor: '#2f54eb',
                    background: '#16192b',
                    color: '#e2e8f0'
                });
            }
        }

        function closeEditTransactionModal() {
            document.getElementById('editTransactionModal').classList.add('hidden');
        }



        // Reset all filters
        function resetFilters() {
            document.getElementById('transactionSearch').value = '';
            document.getElementById('typeFilter').value = 'Semua';
            document.getElementById('periodFilter').value = 'Semua';
            document.getElementById('sortSelect').value = 'terbaru';
            
            filterTransactions();
        }

        // Filter Transactions
        function filterTransactions() {
            searchQuery = document.getElementById('transactionSearch').value.toLowerCase().trim();
            typeFilter = document.getElementById('typeFilter').value;
            periodFilter = document.getElementById('periodFilter').value;

            const now = new Date();
            const todayStr = now.toDateString();

            currentTransactions = originalTransactions.filter(tx => {
                const txDate = new Date(tx.tanggal);
                
                // 1. Search Query
                const matchesSearch = tx.keterangan.toLowerCase().includes(searchQuery) || 
                                      String(tx.nominal).includes(searchQuery) ||
                                      tx.jenis_transaksi.toLowerCase().includes(searchQuery);

                // 2. Type Filter
                const matchesType = typeFilter === 'Semua' || tx.jenis_transaksi === typeFilter;

                // 3. Period Filter
                let matchesPeriod = true;
                if(periodFilter === 'Hari Ini') {
                    matchesPeriod = txDate.toDateString() === todayStr;
                } else if(periodFilter === 'Minggu Ini') {
                    // Check if within last 7 days
                    const oneWeekAgo = new Date();
                    oneWeekAgo.setDate(now.getDate() - 7);
                    matchesPeriod = txDate >= oneWeekAgo && txDate <= now;
                } else if(periodFilter === 'Bulan Ini') {
                    matchesPeriod = txDate.getMonth() === now.getMonth() && txDate.getFullYear() === now.getFullYear();
                } else if(periodFilter === 'Tahun Ini') {
                    matchesPeriod = txDate.getFullYear() === now.getFullYear();
                }

                return matchesSearch && matchesType && matchesPeriod;
            });

            sortTransactions();
        }

        // Sort Transactions
        function sortTransactions() {
            currentSort = document.getElementById('sortSelect').value;

            if (currentSort === 'terbaru') {
                currentTransactions.sort((a, b) => new Date(b.tanggal) - new Date(a.tanggal));
            } else if (currentSort === 'terlama') {
                currentTransactions.sort((a, b) => new Date(a.tanggal) - new Date(b.tanggal));
            } else if (currentSort === 'nominal-tinggi') {
                currentTransactions.sort((a, b) => b.nominal - a.nominal);
            } else if (currentSort === 'nominal-rendah') {
                currentTransactions.sort((a, b) => a.nominal - b.nominal);
            }

            currentPage = 1;
            renderTable();
        }

        // Render Table Rows
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
                tr.className = 'hover:bg-[#07080f]/30 transition duration-150';

                // Format Tanggal
                const d = new Date(tx.tanggal);
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const formattedDate = `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}, ${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}`;

                // Jenis Transaksi Badge
                let typeBadge = '';
                if(tx.jenis_transaksi === 'PENERIMAAN') {
                    typeBadge = `<span class="px-2 py-0.5 rounded-full text-[10px] font-bold" style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399;">PENERIMAAN</span>`;
                } else if(tx.jenis_transaksi === 'PENGELUARAN') {
                    typeBadge = `<span class="px-2 py-0.5 rounded-full text-[10px] font-bold" style="background-color: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.2); color: #c084fc;">PENGELUARAN</span>`;
                } else {
                    // MODAL
                    typeBadge = `<span class="px-2 py-0.5 rounded-full text-[10px] font-bold" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); color: #60a5fa;">MODAL</span>`;
                }

                // Nominal Format with Sign
                const sign = tx.jenis_transaksi === 'PENGELUARAN' ? '-' : '+';
                const nominalFormatted = `${sign} Rp ${tx.nominal.toLocaleString('id-ID')}`;

                tr.innerHTML = `
                    <td class="py-4 px-4 text-xs text-slate-400 font-medium">${formattedDate}</td>
                    <td class="py-4 px-4 text-xs">${typeBadge}</td>
                    <td class="py-4 px-4 text-xs text-slate-300 font-semibold truncate max-w-[200px]" title="${tx.keterangan}">${tx.keterangan}</td>
                    <td class="py-4 px-4 text-xs font-bold text-slate-200">${nominalFormatted}</td>
                    <td class="py-4 px-4 text-xs font-bold text-slate-300">Rp ${tx.saldo_akhir.toLocaleString('id-ID')}</td>
                    <td class="py-4 px-4 text-center">
                        <div class="flex items-center justify-center">
                            <button onclick="showTransactionDetail(${tx.id})" class="w-7 h-7 rounded-lg bg-slate-800/40 text-slate-200 border border-slate-700/20 flex items-center justify-center hover:bg-[#2f54eb] hover:text-white hover:border-transparent transition-all duration-200" title="Lihat Detail">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            // Update lucide icons
            lucide.createIcons();

            // Update pagination text info
            document.getElementById('paginationInfo').textContent = `Menampilkan ${startIndex + 1}-${endIndex} dari ${totalRecords} transaksi`;
            renderPagination(totalRecords);
        }

        // Render Pagination Controls
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
                        span.className = 'text-xs text-[#8f9bb3] px-1.5';
                        span.textContent = '...';
                        paginationButtons.appendChild(span);
                    }
                    continue;
                }

                const button = document.createElement('button');
                button.className = `w-7 h-7 flex items-center justify-center text-xs font-bold rounded-lg transition duration-150
                    ${i === currentPage 
                        ? 'bg-[#2f54eb] text-white shadow-sm shadow-blue-500/20' 
                        : 'border border-[#1f243d] bg-[#16192b] text-[#8f9bb3] hover:text-white hover:bg-[#1f243d]'}`;
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
    </script>
@endsection
