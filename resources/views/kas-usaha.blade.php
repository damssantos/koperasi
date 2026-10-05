@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Kas Usaha')

@section('content')
    <!-- PAGE HEADER CARD (Matching Customer Design) -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#2563EB] text-white flex items-center justify-center shadow-md shadow-blue-600/25 shrink-0">
                <i data-lucide="briefcase" class="w-6 h-6 text-white" stroke="white"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-[#0F172A] tracking-tight">Kas Usaha</h1>
                <p class="text-xs sm:text-sm text-[#64748B] mt-0.5">Kelola transaksi kas operasional bidang usaha koperasi</p>
            </div>
        </div>
        
        <!-- Action Buttons Group -->
        <div class="flex items-center gap-3">
            <button type="button" onclick="openNewTransactionModal()" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-xl transition duration-150 text-xs font-bold shadow-md shadow-blue-600/25 cursor-pointer">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah Transaksi</span>
            </button>
        </div>
    </div>

    <!-- Metrics Overview Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Card 1: Saldo Kas -->
        <div class="bg-white border border-[#E2E8F0] rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#2563EB] shrink-0">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-[#64748B] bg-[#F8FAFC] px-2.5 py-1 rounded-full border border-[#E2E8F0] tracking-wider uppercase">KESELURUHAN</span>
            </div>
            <div>
                <p class="text-xs font-bold text-[#64748B] uppercase tracking-wider mb-1">Saldo Kas</p>
                <h3 class="text-2xl font-extrabold text-[#0F172A]">{{ App\Support\NumberHelper::formatM($saldoKas) }}</h3>
            </div>
        </div>

        <!-- Card 2: Total Penerimaan -->
        <div class="bg-white border border-[#E2E8F0] rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                    <i data-lucide="trending-up" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-[#64748B] bg-[#F8FAFC] px-2.5 py-1 rounded-full border border-[#E2E8F0] tracking-wider uppercase">KESELURUHAN</span>
            </div>
            <div>
                <p class="text-xs font-bold text-[#64748B] uppercase tracking-wider mb-1">Total Penerimaan</p>
                <h3 class="text-2xl font-extrabold text-[#0F172A]">{{ App\Support\NumberHelper::formatM($totalPenerimaan) }}</h3>
            </div>
        </div>

        <!-- Card 3: Total Pengeluaran -->
        <div class="bg-white border border-[#E2E8F0] rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                    <i data-lucide="trending-down" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-[#64748B] bg-[#F8FAFC] px-2.5 py-1 rounded-full border border-[#E2E8F0] tracking-wider uppercase">KESELURUHAN</span>
            </div>
            <div>
                <p class="text-xs font-bold text-[#64748B] uppercase tracking-wider mb-1">Total Pengeluaran</p>
                <h3 class="text-2xl font-extrabold text-[#0F172A]">{{ App\Support\NumberHelper::formatM($totalPengeluaran) }}</h3>
            </div>
        </div>
    </div>

    <!-- Data Table & Search controls Section -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-6 shadow-sm space-y-6">
        <!-- Search, Filter Tabs, and Sort bar -->
        <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4">
            <!-- Left: Search and Filters -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-grow">
                <!-- Search input -->
                <div class="relative flex-grow max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#64748B]">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" id="transactionSearch" oninput="filterTransactions()" placeholder="Cari transaksi..." class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-10 pr-4 py-2.5 text-xs text-[#0F172A] placeholder-[#94A3B8] focus:outline-none focus:border-[#2563EB]">
                </div>

                <!-- Transaction type filter dropdown -->
                <div class="relative">
                    <select id="typeFilter" onchange="filterTransactions()" class="appearance-none bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-3.5 pr-8 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB] cursor-pointer font-semibold min-w-[150px]">
                        <option value="Semua">Semua Transaksi</option>
                        <option value="PENERIMAAN">Penerimaan</option>
                        <option value="PENGELUARAN">Pengeluaran</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[#64748B]">
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                    </div>
                </div>

                <!-- Period filter dropdown -->
                <div class="relative">
                    <select id="periodFilter" onchange="filterTransactions()" class="appearance-none bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-3.5 pr-8 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB] cursor-pointer font-semibold min-w-[130px]">
                        <option value="Semua">Filter Periode</option>
                        <option value="Hari Ini">Hari Ini</option>
                        <option value="Minggu Ini">Minggu Ini</option>
                        <option value="Bulan Ini">Bulan Ini</option>
                        <option value="Tahun Ini">Tahun Ini</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[#64748B]">
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                    </div>
                </div>
            </div>

            <!-- Right: Sort filter -->
            <div class="flex items-center justify-end gap-2.5">
                <span class="text-xs font-bold text-[#64748B] uppercase tracking-wider">Urutan:</span>
                <div class="relative">
                    <select id="sortSelect" onchange="sortTransactions()" class="appearance-none bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-3.5 pr-8 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB] cursor-pointer font-semibold">
                        <option value="terbaru">Terbaru</option>
                        <option value="terlama">Terlama</option>
                        <option value="nominal-tinggi">Nominal Tertinggi</option>
                        <option value="nominal-rendah">Nominal Terendah</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[#64748B]">
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                    </div>
                </div>
                
                <button onclick="resetFilters()" class="p-2.5 border border-[#E2E8F0] rounded-xl bg-[#F8FAFC] text-[#64748B] hover:text-[#0F172A] hover:bg-[#E2E8F0] transition cursor-pointer" title="Reset Filter">
                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="overflow-x-auto">
            <table id="transactionsTable" class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="border-b border-[#E2E8F0] bg-[#F8FAFC] text-[#64748B] text-[11px] font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-bold w-[20%]">Tanggal</th>
                        <th class="py-3.5 px-4 font-bold w-[15%]">Jenis Transaksi</th>
                        <th class="py-3.5 px-4 font-bold w-[25%]">Keterangan</th>
                        <th class="py-3.5 px-4 font-bold w-[15%]">Nominal</th>
                        <th class="py-3.5 px-4 font-bold w-[15%]">Saldo Akhir</th>
                        <th class="py-3.5 px-4 font-bold text-center w-[10%]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E8F0]">
                    <!-- Rows injected by Javascript -->
                </tbody>
            </table>

            <!-- Empty Search State -->
            <div id="emptyState" class="hidden py-12 flex flex-col items-center justify-center text-center space-y-3">
                <div class="w-12 h-12 rounded-full bg-[#F8FAFC] border border-[#E2E8F0] text-[#64748B] flex items-center justify-center">
                    <i data-lucide="search-code" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-[#0F172A]">Transaksi Tidak Ditemukan</p>
                    <p class="text-xs text-[#64748B]">Coba gunakan kata kunci pencarian yang lain atau ubah filter.</p>
                </div>
            </div>
        </div>

        <!-- Pagination Footer -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-4 border-t border-[#E2E8F0]">
            <p id="paginationInfo" class="text-xs font-semibold text-[#64748B]">Menampilkan 10 dari 156 transaksi</p>
            
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
            <div class="flex justify-between items-center pb-3 border-b border-[#E2E8F0]">
                <h3 class="text-base font-extrabold text-[#0F172A]">Tambah Transaksi Kas</h3>
                <button onclick="closeNewTransactionModal()" class="text-[#64748B] hover:text-[#0F172A] transition-colors cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="transactionForm" action="{{ route('kas-usaha.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Jenis Transaksi <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#64748B]">
                            <i data-lucide="wallet" class="w-4 h-4"></i>
                        </span>
                        <select id="txTypeSelect" name="jenis_transaksi" required class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-10 pr-10 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB] appearance-none">
                            <option value="PENERIMAAN">Penerimaan</option>
                            <option value="PENGELUARAN">Pengeluaran</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[#64748B]">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Nominal <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-xs font-bold text-[#64748B]">Rp</span>
                            <input type="number" id="txAmount" name="nominal" required placeholder="Masukkan nominal" min="1000" class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-10 pr-4 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Tanggal Transaksi <span class="text-rose-500">*</span></label>
                        <input type="date" id="txDate" name="tanggal" required class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Keterangan (Opsional)</label>
                    <textarea name="keterangan" rows="3" placeholder="Tulis deskripsi singkat transaksi..." class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] placeholder-[#94A3B8] focus:outline-none focus:border-[#2563EB]"></textarea>
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
                <h3 class="text-base font-extrabold text-[#0F172A]">Detail Transaksi Kas</h3>
                <button onclick="closeDetailTransactionModal()" class="text-[#64748B] hover:text-[#0F172A] transition-colors cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-2 gap-4 text-left">
                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">ID Transaksi</label>
                    <span class="text-sm font-bold text-[#0F172A]" id="detailTxId">-</span>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Tanggal</label>
                    <span class="text-sm font-bold text-[#0F172A]" id="detailTxDate">-</span>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Jenis Transaksi</label>
                    <div id="detailTxTypeBadge" class="mt-1"></div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Nominal</label>
                    <span class="text-sm font-extrabold text-[#0F172A]" id="detailTxAmount">-</span>
                </div>

                <div class="col-span-2 pt-3 border-t border-[#E2E8F0]">
                    <label class="block text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Keterangan</label>
                    <p class="text-xs text-[#0F172A] font-medium leading-relaxed" id="detailTxDesc">-</p>
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
                <h3 class="text-base font-extrabold text-[#0F172A]">Ubah Transaksi Kas</h3>
                <button onclick="closeEditTransactionModal()" class="text-[#64748B] hover:text-[#0F172A] transition-colors cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="editTransactionForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Jenis Transaksi <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#64748B]">
                            <i data-lucide="wallet" class="w-4 h-4"></i>
                        </span>
                        <select id="editTxTypeSelect" name="jenis_transaksi" required class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-10 pr-10 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB] appearance-none">
                            <option value="PENERIMAAN">Penerimaan</option>
                            <option value="PENGELUARAN">Pengeluaran</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[#64748B]">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Nominal <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-xs font-bold text-[#64748B]">Rp</span>
                            <input type="number" id="editTxAmount" name="nominal" required min="1000" class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-10 pr-4 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Tanggal Transaksi <span class="text-rose-500">*</span></label>
                        <input type="date" id="editTxDate" name="tanggal" required class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Keterangan (Opsional)</label>
                    <textarea id="editTxDesc" name="keterangan" rows="3" class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB]"></textarea>
                </div>
                
                <div class="flex items-center gap-3 pt-4 border-t border-[#E2E8F0] justify-end">
                    <button type="button" onclick="closeEditTransactionModal()" class="px-5 py-2.5 border border-[#E2E8F0] bg-[#F1F5F9] text-[#475569] rounded-xl text-xs font-bold hover:bg-[#E2E8F0] transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/25 transition cursor-pointer">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endpush
@endsection

@section('scripts')
    <script>
        const originalTransactions = @json($transactions);
        let currentTransactions = [...originalTransactions];
        
        let typeFilter = 'Semua';
        let periodFilter = 'Semua';
        let searchQuery = '';
        let currentSort = 'terbaru';
        let currentPage = 1;
        const rowsPerPage = 10;
        let selectedTxId = null;

        document.addEventListener('DOMContentLoaded', () => {
            renderTable();
        });

        function openNewTransactionModal() {
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            document.getElementById('txDate').value = now.toISOString().slice(0, 10);
            document.getElementById('transactionModal').classList.remove('hidden');
        }

        function closeNewTransactionModal() {
            document.getElementById('transactionModal').classList.add('hidden');
            document.getElementById('transactionForm').reset();
        }

        async function showTransactionDetail(txId) {
            try {
                const response = await fetch(`/kas-usaha/${txId}`);
                if (!response.ok) throw new Error('Gagal mengambil data dari server.');
                const tx = await response.json();

                selectedTxId = tx.id;
                
                const d = new Date(tx.tanggal);
                const yy = String(d.getFullYear()).slice(-2);
                const mm = String(d.getMonth() + 1).padStart(2, '0');
                const dd = String(d.getDate()).padStart(2, '0');
                const formattedDateForId = `${dd}${mm}${yy}`;
                document.getElementById('detailTxId').textContent = `TX-${formattedDateForId}-YPIK-${String(tx.id).padStart(5, '0')}`;
                
                const monthsId = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
                const formattedDateId = `${d.getDate()} ${monthsId[d.getMonth()]} ${d.getFullYear()}, ${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}`;
                document.getElementById('detailTxDate').textContent = formattedDateId;
                
                document.getElementById('detailTxAmount').textContent = `Rp ${tx.nominal.toLocaleString('id-ID')}`;
                document.getElementById('detailTxDesc').textContent = tx.keterangan || '-';

                const badgeContainer = document.getElementById('detailTxTypeBadge');
                let typeBadge = '';
                if(tx.jenis_transaksi === 'PENERIMAAN') {
                    typeBadge = `<span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">Penerimaan</span>`;
                } else {
                    typeBadge = `<span class="px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100">Pengeluaran</span>`;
                }
                badgeContainer.innerHTML = typeBadge;

                document.getElementById('detailTransactionModal').classList.remove('hidden');
                if (window.lucide) lucide.createIcons();
            } catch (err) {
                console.error(err);
                alert('Gagal mengambil detail transaksi.');
            }
        }

        function closeDetailTransactionModal() {
            document.getElementById('detailTransactionModal').classList.add('hidden');
        }

        async function showTransactionEdit(txId) {
            try {
                const response = await fetch(`/kas-usaha/${txId}`);
                if (!response.ok) throw new Error('Gagal mengambil data dari server.');
                const tx = await response.json();

                document.getElementById('editTxDate').value = tx.tanggal.substring(0, 10);
                document.getElementById('editTxTypeSelect').value = tx.jenis_transaksi;
                document.getElementById('editTxDesc').value = tx.keterangan;
                document.getElementById('editTxAmount').value = tx.nominal;

                const form = document.getElementById('editTransactionForm');
                form.action = `/kas-usaha/${tx.id}`;

                document.getElementById('editTransactionModal').classList.remove('hidden');
            } catch (err) {
                console.error(err);
                alert('Gagal mengambil data transaksi.');
            }
        }

        function closeEditTransactionModal() {
            document.getElementById('editTransactionModal').classList.add('hidden');
        }

        function resetFilters() {
            document.getElementById('transactionSearch').value = '';
            document.getElementById('typeFilter').value = 'Semua';
            document.getElementById('periodFilter').value = 'Semua';
            document.getElementById('sortSelect').value = 'terbaru';
            
            filterTransactions();
        }

        function filterTransactions() {
            searchQuery = document.getElementById('transactionSearch').value.toLowerCase().trim();
            typeFilter = document.getElementById('typeFilter').value;
            periodFilter = document.getElementById('periodFilter').value;

            const now = new Date();
            const todayStr = now.toDateString();

            currentTransactions = originalTransactions.filter(tx => {
                const txDate = new Date(tx.tanggal);
                
                const matchesSearch = tx.keterangan.toLowerCase().includes(searchQuery) || 
                                      String(tx.nominal).includes(searchQuery) ||
                                      tx.jenis_transaksi.toLowerCase().includes(searchQuery);

                const matchesType = typeFilter === 'Semua' || tx.jenis_transaksi === typeFilter;

                let matchesPeriod = true;
                if(periodFilter === 'Hari Ini') {
                    matchesPeriod = txDate.toDateString() === todayStr;
                } else if(periodFilter === 'Minggu Ini') {
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

                const d = new Date(tx.tanggal);
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const formattedDate = `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}, ${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}`;

                let typeBadge = '';
                if(tx.jenis_transaksi === 'PENERIMAAN') {
                    typeBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">PENERIMAAN</span>`;
                } else if(tx.jenis_transaksi === 'PENGELUARAN') {
                    typeBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-100">PENGELUARAN</span>`;
                } else {
                    typeBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-[#2563EB] border border-blue-100">MODAL</span>`;
                }

                const sign = tx.jenis_transaksi === 'PENGELUARAN' ? '-' : '+';
                const signColor = tx.jenis_transaksi === 'PENGELUARAN' ? 'text-rose-600' : 'text-emerald-600';
                const nominalFormatted = `<span class="${signColor} font-bold">${sign} Rp ${tx.nominal.toLocaleString('id-ID')}</span>`;

                tr.innerHTML = `
                    <td class="py-4 px-4 text-xs text-[#64748B] font-medium">${formattedDate}</td>
                    <td class="py-4 px-4 text-xs">${typeBadge}</td>
                    <td class="py-4 px-4 text-xs text-[#0F172A] font-semibold truncate max-w-[200px]" title="${tx.keterangan}">${tx.keterangan}</td>
                    <td class="py-4 px-4 text-xs">${nominalFormatted}</td>
                    <td class="py-4 px-4 text-xs font-bold text-[#0F172A]">Rp ${tx.saldo_akhir.toLocaleString('id-ID')}</td>
                    <td class="py-4 px-4 text-center">
                        <div class="flex items-center justify-center">
                            <button onclick="showTransactionDetail(${tx.id})" class="w-8 h-8 rounded-xl bg-blue-50 text-[#2563EB] border border-blue-200/80 flex items-center justify-center hover:bg-[#2563EB] hover:text-white transition-all duration-150 cursor-pointer shadow-sm group" title="Lihat Detail">
                                <i data-lucide="eye" class="w-4 h-4 text-[#2563EB] group-hover:text-white"></i>
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
                    i === currentPage 
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
    </script>
@endsection
