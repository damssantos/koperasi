@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Transaksi Simpanan')

@section('content')
    <!-- Page Header Title and Action buttons -->
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 pb-6 border-b border-[#1f243d]">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Simpanan</h2>
            <p class="text-xs text-[#8f9bb3] mt-0.5">Kelola seluruh transaksi simpanan anggota koperasi secara terpadu.</p>
        </div>
        
        <!-- Action Buttons Group -->
        <div class="flex items-center gap-3">
            <a href="{{ route('simpanan.print') }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-1.5 border border-[#1f243d] rounded-lg bg-[#16192b] text-[#8f9bb3] hover:text-white hover:bg-[#1f243d] transition duration-150 text-xs font-semibold">
                <i data-lucide="download" class="w-3.5 h-3.5"></i>
                <span>Ekspor Laporan</span>
            </a>
            <button onclick="openNewTransactionModal()" class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg transition duration-150 text-xs font-bold shadow-md shadow-blue-500/10">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                <span>Tambah Simpanan</span>
            </button>
        </div>
    </div>

    <!-- Metrics Overview Grid -->
    <div class="flex flex-nowrap gap-4 overflow-x-auto">
        <!-- Card 1: Total Simpanan -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-4 flex-1 min-w-[220px] hover:border-[#8f9bb3]/20 transition duration-300 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-blue-500/5 rounded-full blur-xl group-hover:bg-blue-500/10 transition-colors"></div>
            <div class="flex items-center gap-2 mb-2">
                <div class="w-7 h-7 rounded-md flex items-center justify-center shrink-0" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); color: #60a5fa;">
                    <i data-lucide="wallet" class="w-3.5 h-3.5"></i>
                </div>
                <p class="text-xs font-semibold text-[#8f9bb3] whitespace-nowrap">Total Simpanan</p>
            </div>
            <div class="flex items-baseline gap-2">
                <h3 class="text-xl font-extrabold text-white" id="metric-total">Rp {{ number_format((int) $totalSimpanan, 0, ',', '.') }}</h3>
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded" style="background-color: rgba(16, 185, 129, 0.1); color: #34d399;">+12.5%</span>
            </div>
        </div>

        <!-- Card 2: Simpanan Pokok -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-4 flex-1 min-w-[220px] hover:border-[#8f9bb3]/20 transition duration-300 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-indigo-500/5 rounded-full blur-xl group-hover:bg-indigo-500/10 transition-colors"></div>
            <div class="flex items-center gap-2 mb-2">
                <div class="w-7 h-7 rounded-md flex items-center justify-center shrink-0" style="background-color: rgba(99, 102, 241, 0.1); border: 1px solid rgba(99, 102, 241, 0.2); color: #818cf8;">
                    <i data-lucide="landmark" class="w-3.5 h-3.5"></i>
                </div>
                <p class="text-xs font-semibold text-[#8f9bb3] whitespace-nowrap">Simpanan Pokok</p>
            </div>
            <h3 class="text-xl font-extrabold text-white" id="metric-pokok">Rp {{ number_format((int) $totalPokok, 0, ',', '.') }}</h3>
        </div>

        <!-- Card 3: Simpanan Wajib -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-4 flex-1 min-w-[220px] hover:border-[#8f9bb3]/20 transition duration-300 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/10 transition-colors"></div>
            <div class="flex items-center gap-2 mb-2">
                <div class="w-7 h-7 rounded-md flex items-center justify-center shrink-0" style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399;">
                    <i data-lucide="coins" class="w-3.5 h-3.5"></i>
                </div>
                <p class="text-xs font-semibold text-[#8f9bb3] whitespace-nowrap">Simpanan Wajib</p>
            </div>
            <h3 class="text-xl font-extrabold text-white" id="metric-wajib">Rp {{ number_format((int) $totalWajib, 0, ',', '.') }}</h3>
        </div>

        <!-- Card 4: Simpanan Sukarela -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-4 flex-1 min-w-[220px] hover:border-[#8f9bb3]/20 transition duration-300 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-purple-500/5 rounded-full blur-xl group-hover:bg-purple-500/10 transition-colors"></div>
            <div class="flex items-center gap-2 mb-2">
                <div class="w-7 h-7 rounded-md flex items-center justify-center shrink-0" style="background-color: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.2); color: #a855f7;">
                    <i data-lucide="piggy-bank" class="w-3.5 h-3.5"></i>
                </div>
                <p class="text-xs font-semibold text-[#8f9bb3] whitespace-nowrap">Simpanan Sukarela</p>
            </div>
            <h3 class="text-xl font-extrabold text-white" id="metric-sukarela">Rp {{ number_format((int) $totalSukarela, 0, ',', '.') }}</h3>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-6 space-y-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Perkembangan Simpanan</h3>
                <p class="text-[10px] text-[#8f9bb3] mt-0.5">Grafik akumulasi dana simpanan tahun berjalan</p>
            </div>
            
            <!-- Chart Filters -->
            <div class="flex items-center gap-4">
                <!-- Legend -->
                <div class="flex items-center gap-2 text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#2f54eb]"></span>
                    <span>Total Dana (Miliar)</span>
                </div>
                <!-- Time Range -->
                <div class="bg-[#07080f] border border-[#1f243d] rounded-lg p-0.5 flex">
                    <button onclick="changeChartRange('weekly')" class="chart-tab px-2.5 py-1 text-[10px] font-bold uppercase rounded-md text-[#8f9bb3] hover:text-white transition duration-150">Mingguan</button>
                    <button onclick="changeChartRange('monthly')" class="chart-tab px-2.5 py-1 text-[10px] font-bold uppercase rounded-md bg-[#2f54eb] text-white transition duration-150">Bulanan</button>
                    <button onclick="changeChartRange('yearly')" class="chart-tab px-2.5 py-1 text-[10px] font-bold uppercase rounded-md text-[#8f9bb3] hover:text-white transition duration-150">Tahunan</button>
                </div>
            </div>
        </div>
        
        <!-- Canvas wrapper -->
        <div class="h-64 w-full relative">
            <canvas id="simpananChart"></canvas>
        </div>
    </div>

    <!-- Data Table & Search controls Section -->
    <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-6 space-y-6">
        <!-- Search, Filter Tabs, and Sort bar -->
        <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4">
            <!-- Left: Search and Filters -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-grow max-w-2xl">
                <!-- Search input -->
                <div class="relative flex-grow max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#8f9bb3]">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" id="transactionSearch" oninput="filterTransactions()" placeholder="Cari nama atau ID anggota..." class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-10 pr-4 py-2 text-xs text-white placeholder-slate-600 focus:outline-none focus:border-blue-500">
                </div>

                <!-- Tab filters -->
                <div class="bg-[#07080f] border border-[#1f243d] rounded-lg p-0.5 flex">
                    <button onclick="setFilterType('Semua')" class="filter-tab px-3 py-1.5 text-[10px] font-bold uppercase rounded-md bg-[#2f54eb] text-white transition duration-150">Semua</button>
                    <button onclick="setFilterType('Pokok')" class="filter-tab px-3 py-1.5 text-[10px] font-bold uppercase rounded-md text-[#8f9bb3] hover:text-white transition duration-150">Pokok</button>
                    <button onclick="setFilterType('Wajib')" class="filter-tab px-3 py-1.5 text-[10px] font-bold uppercase rounded-md text-[#8f9bb3] hover:text-white transition duration-150">Wajib</button>
                    <button onclick="setFilterType('Sukarela')" class="filter-tab px-3 py-1.5 text-[10px] font-bold uppercase rounded-md text-[#8f9bb3] hover:text-white transition duration-150">Sukarela</button>
                </div>
            </div>

            <!-- Right: Sort filter -->
            <div class="flex items-center justify-end gap-2.5">
                <span class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Urutan:</span>
                <div class="relative">
                    <select id="sortSelect" onchange="sortTransactions()" class="appearance-none bg-[#07080f] border border-[#1f243d] rounded-lg pl-3.5 pr-8 py-2 text-xs text-white focus:outline-none focus:border-blue-500 cursor-pointer font-semibold">
                        <option value="terbaru">Terbaru</option>
                        <option value="terlama">Terlama</option>
                        <option value="nominal-tinggi">Nominal Tertinggi</option>
                        <option value="nominal-rendah">Nominal Terendah</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[#8f9bb3]">
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="overflow-x-auto">
            <table id="transactionsTable" class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="border-b border-[#1f243d] text-[#8f9bb3] text-[10px] font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-semibold w-[15%]">Tanggal</th>
                        <th class="py-3.5 px-4 font-semibold w-[15%]">ID Anggota</th>
                        <th class="py-3.5 px-4 font-semibold w-[25%]">Nama Anggota</th>
                        <th class="py-3.5 px-4 font-semibold w-[15%]">Jenis Simpanan</th>
                        <th class="py-3.5 px-4 font-semibold w-[10%]">Nominal</th>
                        <th class="py-3.5 px-4 font-semibold w-[10%]">Status</th>
                        <th class="py-3.5 px-4 font-semibold text-center w-[10%]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f243d]">
                    <!-- Rows will be injected and managed by Javascript -->
                </tbody>
            </table>

            <!-- Empty Search State -->
            <div id="emptyState" class="hidden py-12 flex flex-col items-center justify-center text-center space-y-3">
                <div class="w-12 h-12 rounded-full bg-slate-800/40 border border-slate-700/20 text-slate-400 flex items-center justify-center">
                    <i data-lucide="search-code" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">Transaksi Tidak Ditemukan</p>
                    <p class="text-xs text-[#8f9bb3]">Coba gunakan kata kunci pencarian yang lain.</p>
                </div>
            </div>
        </div>

        <!-- Pagination Footer -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-4 border-t border-[#1f243d]">
            <p id="paginationInfo" class="text-[10px] font-semibold text-[#8f9bb3] uppercase tracking-wider">Menampilkan 10 dari 1,240 transaksi</p>
            
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

    <!-- NEW TRANSACTION MODAL -->
    <div id="transactionModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#07080f]/75 backdrop-blur-sm hidden transition-opacity">
        <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-2">
                <h3 class="text-base font-bold text-white">Tambah Transaksi Simpanan</h3>
                <button onclick="closeNewTransactionModal()" class="text-slate-400 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <!-- Form Inputs -->
            <form id="transactionForm" action="{{ route('simpanan.store') }}" method="POST" class="space-y-4">
                @csrf
                <!-- ID/Nama Anggota * -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">Anggota *</label>
                    <select id="txMemberSelect" name="anggota_id" required class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                        <option value="" disabled selected>Pilih Anggota</option>
                        @forelse($anggota as $member)
                            <option value="{{ $member->id }}">{{ $member->id_anggota ?? 'AGT-' . str_pad($member->id, 5, '0', STR_PAD_LEFT) }} - {{ $member->nama }}</option>
                        @empty
                            <option value="" disabled>Belum ada anggota di database</option>
                        @endforelse
                    </select>
                </div>

                <!-- Jenis Simpanan * -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">Jenis Simpanan *</label>
                    <select id="txTypeSelect" name="jenis_simpanan" required class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                        <option value="Pokok">Pokok</option>
                        <option value="Wajib">Wajib</option>
                        <option value="Sukarela">Sukarela</option>
                    </select>
                </div>

                <!-- Nominal * -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">Nominal (Rupiah) *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#8f9bb3] text-xs font-bold">Rp</span>
                        <input type="number" id="txAmount" name="nominal" required placeholder="Contoh: 500000" min="1000" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-10 pr-4 py-2.5 text-xs text-white placeholder-slate-600 focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <!-- Tanggal Transaksi * -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">Tanggal Transaksi *</label>
                    <input type="date" id="txDate" name="tanggal_transaksi" required class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                </div>

                <!-- Status * -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">Status *</label>
                    <select id="txStatus" name="status" required class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                        <option value="Aktif">Aktif</option>
                        <option value="Lunas">Lunas</option>
                    </select>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center gap-3 pt-4 justify-end">
                    <button type="button" onclick="closeNewTransactionModal()" class="px-5 py-2.5 border border-[#1f243d] rounded-lg bg-transparent text-white text-xs font-semibold hover:bg-[#16192b] transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg text-xs font-bold transition-all shadow-lg shadow-blue-500/10">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const originalTransactions = @json($transactions);

        // Active State
        let currentTransactions = [...originalTransactions];
        let filterType = 'Semua';
        let searchQuery = '';
        let currentSort = 'terbaru';
        let currentPage = 1;
        const rowsPerPage = 10;
        let chartInstance = null;

        // Chart Data Definitions
        const chartDataSets = {
            monthly: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
                data: [1.2, 1.4, 1.6, 1.75, 1.9, 2.05, 2.15, 2.22, 2.3, 2.38, 2.42, 2.45]
            },
            weekly: {
                labels: ["Minggu 1", "Minggu 2", "Minggu 3", "Minggu 4"],
                data: [2.35, 2.38, 2.41, 2.45]
            },
            yearly: {
                labels: ["2021", "2022", "2023", "2024"],
                data: [0.8, 1.3, 1.9, 2.45]
            }
        };

        // Initialize Page
        document.addEventListener('DOMContentLoaded', () => {
            renderTable();
        });

        // Initialize Chart when loader finishes (so parent container has correct layout size)
        window.addEventListener('page-loader-finished', () => {
            initChart('monthly');
        });

        // Open Modal
        function openNewTransactionModal() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('txDate').value = today;
            document.getElementById('transactionModal').classList.remove('hidden');
        }

        // Close Modal
        function closeNewTransactionModal() {
            document.getElementById('transactionModal').classList.add('hidden');
            document.getElementById('transactionForm').reset();
        }

        // Handle Form Submit
        function submitNewTransaction(event) {
            event.preventDefault();
            
            const memberSelectVal = document.getElementById('txMemberSelect').value;
            const type = document.getElementById('txTypeSelect').value;
            const amount = parseInt(document.getElementById('txAmount').value);
            const dateVal = document.getElementById('txDate').value;
            const status = document.getElementById('txStatus').value;

            if (!memberSelectVal) {
                alert('Pilih anggota terlebih dahulu.');
                return;
            }

            const [memberId, name] = memberSelectVal.split('|');

            // Format date display
            const dateParts = dateVal.split('-');
            let dateDisplay = dateVal;
            if(dateParts.length === 3) {
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                dateDisplay = `${parseInt(dateParts[2])} ${months[parseInt(dateParts[1]) - 1]} ${dateParts[0]}`;
            }

            const newTx = {
                id: originalTransactions.length + 1,
                date: dateDisplay,
                rawDate: dateVal,
                memberId: memberId,
                name: name,
                type: type,
                amount: amount,
                status: status
            };

            // Add to datasets
            originalTransactions.unshift(newTx);
            currentTransactions = [...originalTransactions];

            // Re-run filter and renders
            filterTransactions();
            updateMetrics(type, amount);

            closeNewTransactionModal();
            alert(`Transaksi simpanan ${type} untuk ${name} sebesar Rp ${amount.toLocaleString('id-ID')} berhasil ditambahkan!`);
        }

        // Update metrics on new transaction addition
        function updateMetrics(type, amount) {
            // Update Totals
            const currentTotalVal = 2450000000 + amount;
            document.getElementById('metric-total').textContent = `Rp ${currentTotalVal.toLocaleString('id-ID')}`;

            if(type === 'Pokok') {
                const currentPokokVal = 450000000 + amount;
                document.getElementById('metric-pokok').textContent = `Rp ${currentPokokVal.toLocaleString('id-ID')}`;
            } else if (type === 'Wajib') {
                const currentWajibVal = 800000000 + amount;
                document.getElementById('metric-wajib').textContent = `Rp ${currentWajibVal.toLocaleString('id-ID')}`;
            } else if (type === 'Sukarela') {
                const currentSukarelaVal = 1200000000 + amount;
                document.getElementById('metric-sukarela').textContent = `Rp ${currentSukarelaVal.toLocaleString('id-ID')}`;
            }
        }

        // Change filter tab type
        function setFilterType(type) {
            filterType = type;
            
            // Adjust active state buttons UI
            const tabs = document.querySelectorAll('.filter-tab');
            tabs.forEach(tab => {
                if (tab.textContent.trim().toLowerCase() === type.toLowerCase()) {
                    tab.classList.add('bg-[#2f54eb]', 'text-white');
                    tab.classList.remove('text-[#8f9bb3]', 'hover:text-white');
                } else {
                    tab.classList.remove('bg-[#2f54eb]', 'text-white');
                    tab.classList.add('text-[#8f9bb3]', 'hover:text-white');
                }
            });

            filterTransactions();
        }

        // Live search filter
        function filterTransactions() {
            searchQuery = document.getElementById('transactionSearch').value.toLowerCase().trim();

            currentTransactions = originalTransactions.filter(tx => {
                const matchesSearch = tx.name.toLowerCase().includes(searchQuery) || tx.memberId.toLowerCase().includes(searchQuery);
                const matchesType = filterType === 'Semua' || tx.type.toLowerCase() === filterType.toLowerCase();
                return matchesSearch && matchesType;
            });

            sortTransactions();
        }

        // Sorting Logic
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

            currentPage = 1; // Reset to page 1 on sort/filter change
            renderTable();
        }

        // Render Table Row Elements
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

                // Badges configurations
                let typeBadge = '';
                if(tx.type === 'Pokok') {
                    typeBadge = `<span class="px-2 py-0.5 rounded-full text-[10px] font-bold" style="background-color: rgba(99, 102, 241, 0.1); border: 1px solid rgba(99, 102, 241, 0.2); color: #818cf8;">Pokok</span>`;
                } else if(tx.type === 'Wajib') {
                    typeBadge = `<span class="px-2 py-0.5 rounded-full text-[10px] font-bold" style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399;">Wajib</span>`;
                } else {
                    typeBadge = `<span class="px-2 py-0.5 rounded-full text-[10px] font-bold" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); color: #60a5fa;">Sukarela</span>`;
                }

                let statusBadge = '';
                if(tx.status === 'Aktif') {
                    statusBadge = `<span class="px-2 py-0.5 rounded-full text-[10px] font-bold" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); color: #60a5fa;">Aktif</span>`;
                } else {
                    statusBadge = `<span class="px-2 py-0.5 rounded-full text-[10px] font-bold" style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399;">Lunas</span>`;
                }

                tr.innerHTML = `
                    <td class="py-4 px-4 text-xs text-slate-300 w-[15%]">${tx.date}</td>
                    <td class="py-4 px-4 text-xs text-[#8f9bb3] font-medium w-[15%]">${tx.memberId}</td>
                    <td class="py-4 px-4 text-xs font-bold text-white w-[25%]">${tx.name}</td>
                    <td class="py-4 px-4 text-xs w-[15%]">${typeBadge}</td>
                    <td class="py-4 px-4 text-xs font-bold text-white w-[10%]">Rp ${tx.amount.toLocaleString('id-ID')}</td>
                    <td class="py-4 px-4 text-xs w-[10%]">${statusBadge}</td>
                    <td class="py-4 px-4 text-center w-[10%]">
                        <div class="flex items-center justify-center gap-1.5">
                            <button onclick="window.location.href='{{ url('/anggota') }}/' + tx.memberDbId" class="w-7 h-7 rounded-lg text-blue-400 flex items-center justify-center hover:bg-blue-600 hover:text-white hover:border-transparent transition-all duration-200" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2);" title="Detail">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                            </button>
                            <button onclick="window.location.href='{{ url('/anggota') }}?edit=' + tx.memberDbId" class="w-7 h-7 rounded-lg text-slate-400 flex items-center justify-center hover:bg-[#2f54eb] hover:text-white hover:border-transparent transition-all duration-200" style="background-color: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08);" title="Edit">
                                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            // Update lucide icons inside generated rows
            lucide.createIcons();

            // Update Pagination info display
            document.getElementById('paginationInfo').textContent = `Menampilkan ${startIndex + 1}-${endIndex} dari ${totalRecords} transaksi`;
            renderPagination(totalRecords);
        }

        // Render Pagination UI buttons
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
                // Limit buttons to show for high counts (simple logic)
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
                button.className = `w-7 h-7 flex items-center justify-center text-xs font-bold rounded-lg transition duration-150 ${
                    currentPage === i 
                    ? 'bg-[#2f54eb] text-white shadow-md' 
                    : 'bg-[#16192b] text-[#8f9bb3] border border-[#1f243d] hover:text-white hover:bg-[#1f243d]'
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

        // Initialize Chart.js
        function initChart(rangeType) {
            const ctx = document.getElementById('simpananChart').getContext('2d');
            const dataConfig = chartDataSets[rangeType];

            // Destroy existing chart to prevent garbage canvas overlap on range switches
            if (chartInstance) {
                chartInstance.destroy();
            }

            // Create gradient fill background
            const gradientFill = ctx.createLinearGradient(0, 0, 0, 240);
            gradientFill.addColorStop(0, 'rgba(47, 84, 235, 0.25)'); // Indigo/Blue translucent
            gradientFill.addColorStop(1, 'rgba(47, 84, 235, 0)');    // Transparent

            chartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dataConfig.labels,
                    datasets: [{
                        label: 'Total Dana (Miliar)',
                        data: dataConfig.data,
                        borderColor: '#2f54eb',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#2f54eb',
                        pointBorderColor: '#16192b',
                        pointBorderWidth: 2,
                        pointRadius: rangeType === 'weekly' ? 5 : 3,
                        pointHoverRadius: 6,
                        tension: 0.4, // Curved smooth lines
                        fill: true,
                        backgroundColor: gradientFill
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Handled by custom html header legend
                        },
                        tooltip: {
                            backgroundColor: '#16192b',
                            titleColor: '#8f9bb3',
                            titleFont: { size: 9, weight: 'bold', family: 'Plus Jakarta Sans' },
                            bodyColor: '#ffffff',
                            bodyFont: { size: 11, weight: 'bold', family: 'Plus Jakarta Sans' },
                            borderColor: '#1f243d',
                            borderWidth: 1,
                            padding: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return `Rp ${context.raw} Miliar`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#7c83a7',
                                font: { size: 9, family: 'Plus Jakarta Sans' }
                            }
                        },
                        y: {
                            grid: {
                                color: '#1f243d'
                            },
                            ticks: {
                                color: '#7c83a7',
                                font: { size: 9, family: 'Plus Jakarta Sans' },
                                callback: function(value) {
                                    return `Rp ${value}M`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Switch chart range (weekly/monthly/yearly)
        function changeChartRange(rangeType) {
            // Update active state class in range tabs
            const tabs = document.querySelectorAll('.chart-tab');
            tabs.forEach(tab => {
                if (tab.textContent.trim().toLowerCase() === (rangeType === 'weekly' ? 'mingguan' : rangeType === 'monthly' ? 'bulanan' : 'tahunan')) {
                    tab.classList.add('bg-[#2f54eb]', 'text-white');
                    tab.classList.remove('text-[#8f9bb3]', 'hover:text-white');
                } else {
                    tab.classList.remove('bg-[#2f54eb]', 'text-white');
                    tab.classList.add('text-[#8f9bb3]', 'hover:text-white');
                }
            });

            initChart(rangeType);
        }
    </script>
@endsection
