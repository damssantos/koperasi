@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Pinjaman Koperasi')

@section('content')

<!-- PAGE HEADER CARD (Matching Customer Design) -->
<div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-[#2563EB] text-white flex items-center justify-center shadow-md shadow-blue-600/25 shrink-0">
            <i data-lucide="hand-coins" class="w-6 h-6 text-white" stroke="white"></i>
        </div>
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-[#0F172A] tracking-tight">Pinjaman Koperasi</h1>
            <p class="text-xs sm:text-sm text-[#64748B] mt-0.5">Kelola seluruh proses pinjaman anggota, mulai dari pengajuan hingga pelunasan.</p>
        </div>
    </div>

    <div class="flex items-center gap-2.5 flex-wrap">
        <!-- EXPORT -->
        <a href="{{ route('pinjaman.export') }}"
           class="inline-flex items-center gap-2 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white rounded-xl transition duration-150 text-xs font-bold shadow-md shadow-emerald-600/20">
            <i data-lucide="file-down" class="w-4 h-4"></i>
            <span>Export Excel</span>
        </a>

        <!-- IMPORT -->
        <button type="button" onclick="openImportModal()"
                class="inline-flex items-center gap-2 px-3.5 py-2 border border-[#E2E8F0] bg-white text-[#0F172A] hover:bg-[#F8FAFC] rounded-xl transition duration-150 text-xs font-bold shadow-sm">
            <i data-lucide="file-up" class="w-4 h-4 text-[#64748B]"></i>
            <span>Import Excel</span>
        </button>

        <!-- TAMBAH -->
        <button type="button" onclick="openNewLoanModal()"
                class="inline-flex items-center gap-2 px-4 py-2 bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-xl transition duration-150 text-xs font-bold shadow-md shadow-blue-600/25">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Pengajuan</span>
        </button>
    </div>
</div>

<!-- METRICS CARDS -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
    <!-- TOTAL -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-200">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-[#2563EB] border border-blue-100 flex items-center justify-center shrink-0">
                    <i data-lucide="wallet" class="w-4.5 h-4.5"></i>
                </div>
                <span class="text-xs font-bold text-[#64748B]">Total Pinjaman</span>
            </div>
            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center gap-1">
                <i data-lucide="trending-up" class="w-3 h-3"></i>
                <span>+12%</span>
            </span>
        </div>
        <h3 class="text-2xl font-extrabold text-[#0F172A]" id="metric-total">
            Rp {{ number_format((int) $totalPinjaman, 0, ',', '.') }}
        </h3>
    </div>

    <!-- AKTIF -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-200">
        <div class="flex items-center gap-2.5 mb-3">
            <div class="w-9 h-9 rounded-xl bg-blue-50 text-[#2563EB] border border-blue-100 flex items-center justify-center shrink-0">
                <i data-lucide="users" class="w-4.5 h-4.5"></i>
            </div>
            <span class="text-xs font-bold text-[#64748B]">Pinjaman Aktif</span>
        </div>
        <h3 class="text-2xl font-extrabold text-[#0F172A]">
            {{ $pinjamanAktifCount }} Anggota
        </h3>
    </div>

    <!-- MENUNGGAK -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-200">
        <div class="flex items-center gap-2.5 mb-3">
            <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 border border-rose-100 flex items-center justify-center shrink-0">
                <i data-lucide="alert-triangle" class="w-4.5 h-4.5"></i>
            </div>
            <span class="text-xs font-bold text-[#64748B]">Menunggak</span>
        </div>
        <h3 class="text-2xl font-extrabold text-[#0F172A]">
            {{ $pinjamanMenunggakCount }} Anggota
        </h3>
    </div>

    <!-- LUNAS -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-200">
        <div class="flex items-center gap-2.5 mb-3">
            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0">
                <i data-lucide="check-circle" class="w-4.5 h-4.5"></i>
            </div>
            <span class="text-xs font-bold text-[#64748B]">Pinjaman Lunas</span>
        </div>
        <h3 class="text-2xl font-extrabold text-[#0F172A]">
            {{ $pinjamanLunasCount }} Anggota
        </h3>
    </div>
</div>

<!-- FILTER & SORT BAR -->
<div class="bg-white border border-[#E2E8F0] rounded-2xl p-4 sm:p-5 shadow-sm mt-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
        <!-- SEARCH -->
        <div class="relative w-full sm:w-64">
            <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-[#64748B]"></i>
            <input type="text" id="searchInput" oninput="applyFilters()" placeholder="Cari nama anggota..."
                class="w-full pl-9 pr-4 py-2 bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl text-xs text-[#0F172A] placeholder-[#64748B] focus:outline-none focus:border-[#2563EB] focus:bg-white transition duration-150">
        </div>

        <!-- TABS -->
        <div class="flex bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-1 shrink-0">
            <button type="button" onclick="setFilterStatus('All')" id="tab-all"
                class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition duration-150 bg-[#2563EB] text-white shadow-sm">
                Semua
            </button>
            <button type="button" onclick="setFilterStatus('Aktif')" id="tab-aktif"
                class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition duration-150 text-[#64748B] hover:text-[#0F172A]">
                Aktif
            </button>
            <button type="button" onclick="setFilterStatus('Menunggak')" id="tab-menunggak"
                class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition duration-150 text-[#64748B] hover:text-[#0F172A]">
                Menunggak
            </button>
            <button type="button" onclick="setFilterStatus('Lunas')" id="tab-lunas"
                class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition duration-150 text-[#64748B] hover:text-[#0F172A]">
                Lunas
            </button>
        </div>
    </div>

    <!-- SORT -->
    <div class="flex items-center gap-2 w-full md:w-auto justify-end">
        <span class="text-xs font-semibold text-[#64748B] whitespace-nowrap">Urutan:</span>
        <div class="relative w-44">
            <select id="sortBy" onchange="applyFilters()"
                class="w-full pl-3 pr-8 py-2 bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#0F172A] focus:outline-none focus:border-[#2563EB] focus:bg-white transition duration-150 appearance-none cursor-pointer">
                <option value="date-desc">Terbaru</option>
                <option value="date-asc">Terlama</option>
                <option value="amount-desc">Nominal Terbesar</option>
                <option value="amount-asc">Nominal Terkecil</option>
            </select>
            <i data-lucide="chevron-down" class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#64748B] pointer-events-none"></i>
        </div>
    </div>
</div>

<!-- DATA TABLE CARD -->
<div class="bg-white border border-[#E2E8F0] rounded-2xl shadow-sm overflow-hidden mt-6">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#F8FAFC] border-b border-[#E2E8F0]">
                    <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Tanggal Pengajuan</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Nama Anggota</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Nominal Pinjaman</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Tenor</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Progress Cicilan</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Sisa Pinjaman</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Approval</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="loansTableBody" class="divide-y divide-[#E2E8F0]">
            </tbody>
        </table>
    </div>

    <!-- EMPTY STATE -->
    <div id="emptyState" class="hidden py-16 flex flex-col items-center justify-center text-center space-y-3">
        <div class="w-12 h-12 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center text-[#64748B]">
            <i data-lucide="inbox" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-sm font-bold text-[#0F172A]">Tidak ada data pinjaman</p>
            <p class="text-xs text-[#64748B] mt-0.5">Gunakan kata kunci lain atau tambah pengajuan baru.</p>
        </div>
    </div>

    <!-- PAGINATION FOOTER -->
    <div class="px-6 py-4 border-t border-[#E2E8F0] flex flex-col sm:flex-row items-center justify-between gap-4 bg-[#F8FAFC]">
        <span class="text-xs font-semibold text-[#64748B]" id="paginationText">
            Menampilkan 0 dari 0 data pinjaman
        </span>
        <div class="flex items-center gap-1.5" id="paginationControls"></div>
    </div>
</div>

@push('modals')
<!-- NEW LOAN MODAL -->
<div id="newLoanModal" class="fixed inset-0 flex items-center justify-center p-4 z-50 bg-slate-900/50 backdrop-blur-sm hidden">
    <div class="bg-white border border-[#E2E8F0] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-6">
        <div class="flex justify-between items-center pb-3 border-b border-[#E2E8F0]">
            <h3 class="text-base font-extrabold text-[#0F172A]">Tambah Pengajuan Pinjaman</h3>
            <button type="button" onclick="closeNewLoanModal()" class="text-[#64748B] hover:text-[#0F172A] p-1 rounded-lg hover:bg-[#F8FAFC] transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('pinjaman.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- ANGGOTA -->
            <div class="relative">
                <label class="block text-[11px] font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">NAMA ANGGOTA*</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#64748B] pointer-events-none">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" id="memberSearchInput" onfocus="showMemberDropdown()" oninput="filterMembers()"
                        placeholder="Cari nama anggota..." autocomplete="off"
                        class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-10 pr-4 py-2.5 text-xs text-[#0F172A] placeholder-[#64748B] focus:outline-none focus:border-[#2563EB] focus:bg-white transition">
                    <input type="hidden" name="anggota_id" id="selectedMemberId" required>
                </div>

                <div id="memberDropdownList" class="absolute left-0 right-0 mt-1 max-h-48 overflow-y-auto bg-white border border-[#E2E8F0] rounded-xl shadow-xl z-50 hidden divide-y divide-[#E2E8F0]">
                    @foreach($anggota as $item)
                        <div data-member-id="{{ $item->id }}" data-member-name="{{ $item->nama }}" data-member-code="{{ $item->id_anggota }}"
                            onclick="selectMember({{ $item->id }}, this.dataset.memberName + ' (' + this.dataset.memberCode + ')')"
                            class="px-4 py-2.5 text-xs font-medium text-[#0F172A] hover:bg-[#2563EB] hover:text-white cursor-pointer transition-colors duration-150">
                            {{ $item->nama }} ({{ $item->id_anggota }})
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- NOMINAL + TENOR -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">NOMINAL PINJAMAN*</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-[#64748B] text-xs font-bold pointer-events-none">Rp</span>
                        <input type="number" id="inputNominal" name="nominal_pinjaman" oninput="calculateSummary()" required
                            placeholder="Nominal" min="1000"
                            class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-8 pr-3 py-2.5 text-xs font-medium text-[#0F172A] placeholder-[#64748B] focus:outline-none focus:border-[#2563EB] focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">TENOR*</label>
                    <div class="relative">
                        <input type="number" id="inputTenor" name="tenor" oninput="calculateSummary()" required
                            placeholder="Tenor" min="1"
                            class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-3 pr-12 py-2.5 text-xs font-medium text-[#0F172A] placeholder-[#64748B] focus:outline-none focus:border-[#2563EB] focus:bg-white transition">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#64748B] text-[11px] font-semibold pointer-events-none">bulan</span>
                    </div>
                </div>
            </div>

            <!-- KETERANGAN -->
            <div>
                <label class="block text-[11px] font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">KETERANGAN (OPSIONAL)</label>
                <textarea name="keterangan" rows="3" placeholder="Masukkan keterangan..."
                    class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2 text-xs font-medium text-[#0F172A] placeholder-[#64748B] focus:outline-none focus:border-[#2563EB] focus:bg-white transition resize-none"></textarea>
            </div>

            <!-- TANGGAL -->
            <div>
                <label class="block text-[11px] font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">TANGGAL PENGAJUAN*</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#64748B] pointer-events-none">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                    </span>
                    <input type="date" name="tanggal_pengajuan" required value="{{ date('Y-m-d') }}"
                        class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-10 pr-4 py-2.5 text-xs font-medium text-[#0F172A] focus:outline-none focus:border-[#2563EB] focus:bg-white transition">
                </div>
            </div>

            <!-- SUMMARY -->
            <div class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-4 space-y-2">
                <div class="flex items-center gap-2 text-xs font-bold text-[#0F172A] mb-1.5">
                    <i data-lucide="calculator" class="w-4 h-4 text-[#2563EB]"></i>
                    <span>Ringkasan Pinjaman</span>
                </div>
                <div class="flex justify-between items-center text-[11px] text-[#64748B]">
                    <span>Biaya Administrasi (1%)</span>
                    <span id="summaryAdminFee" class="font-bold text-[#0F172A]">Rp 0</span>
                </div>
                <div class="flex justify-between items-center text-[11px] text-[#64748B]">
                    <span>Estimasi Cicilan per Bulan</span>
                    <span id="summaryMonthlyPayment" class="font-bold text-[#0F172A]">Rp 0</span>
                </div>
                <div class="flex justify-between items-center text-[11px] border-t border-[#E2E8F0] pt-2 font-bold text-[#64748B]">
                    <span>Total Pengembalian</span>
                    <span id="summaryTotalReturn" class="text-emerald-600 font-extrabold text-xs">Rp 0</span>
                </div>
            </div>

            <!-- BUTTONS -->
            <div class="flex items-center gap-3 pt-3 justify-end">
                <button type="button" onclick="closeNewLoanModal()"
                    class="px-4 py-2 text-xs font-semibold text-[#64748B] hover:text-[#0F172A] bg-white border border-[#E2E8F0] hover:bg-[#F8FAFC] rounded-xl transition duration-150">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 text-xs font-bold text-white bg-[#2563EB] hover:bg-[#1D4ED8] rounded-xl transition duration-150 shadow-md shadow-blue-600/20">
                    Ajukan Pinjaman
                </button>
            </div>
        </form>
    </div>
</div>

<!-- IMPORT EXCEL MODAL -->
<div id="importModal" class="fixed inset-0 flex items-center justify-center p-4 z-50 bg-slate-900/50 backdrop-blur-sm hidden">
    <div class="bg-white border border-[#E2E8F0] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-5">
        <div class="flex justify-between items-center pb-3 border-b border-[#E2E8F0]">
            <div>
                <h3 class="text-base font-extrabold text-[#0F172A]">Import Data Pinjaman</h3>
                <p class="text-xs text-[#64748B] mt-0.5">Import data pinjaman menggunakan file Excel.</p>
            </div>
            <button type="button" onclick="closeImportModal()" class="text-[#64748B] hover:text-[#0F172A] p-1 rounded-lg hover:bg-[#F8FAFC] transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <div class="bg-blue-50 border border-blue-100 rounded-xl p-3.5">
            <div class="flex gap-2.5">
                <i data-lucide="info" class="w-4 h-4 text-[#2563EB] shrink-0 mt-0.5"></i>
                <div class="text-xs text-[#64748B] leading-relaxed">
                    <p class="text-[#2563EB] font-bold mb-0.5">Format Excel</p>
                    <p>Gunakan template yang sudah disediakan agar data dapat masuk ke sistem dengan benar.</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-3.5">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0">
                    <i data-lucide="file-spreadsheet" class="w-4.5 h-4.5"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-[#0F172A]">Template Excel</p>
                    <p class="text-[11px] text-[#64748B]">Download template terlebih dahulu</p>
                </div>
            </div>
            <a href="{{ route('pinjaman.template') }}"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm">
                <i data-lucide="download" class="w-3.5 h-3.5"></i>
                Download
            </a>
        </div>

        <form action="{{ route('pinjaman.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-[11px] font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">FILE EXCEL*</label>
                <input type="file" name="file" required accept=".xlsx,.xls"
                    class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3 py-2 text-xs text-[#0F172A] file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#2563EB] file:text-white hover:file:bg-[#1D4ED8] cursor-pointer">
                <p class="text-[11px] text-[#64748B] mt-1.5">Format XLSX atau XLS. Maksimal 5MB.</p>
            </div>

            <div class="flex items-center gap-3 pt-3 justify-end">
                <button type="button" onclick="closeImportModal()"
                    class="px-4 py-2 text-xs font-semibold text-[#64748B] hover:text-[#0F172A] bg-white border border-[#E2E8F0] hover:bg-[#F8FAFC] rounded-xl transition duration-150">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 text-xs font-bold text-white bg-[#2563EB] hover:bg-[#1D4ED8] rounded-xl transition duration-150 shadow-md shadow-blue-600/20 inline-flex items-center gap-2">
                    <i data-lucide="upload" class="w-4 h-4"></i>
                    <span>Import Data</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- DETAIL LOAN MODAL -->
<div id="detailLoanModal" class="fixed inset-0 flex items-center justify-center p-4 z-50 bg-slate-900/50 backdrop-blur-sm hidden">
    <div class="bg-white border border-[#E2E8F0] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-6">
        <div class="flex justify-between items-center pb-3 border-b border-[#E2E8F0]">
            <h3 class="text-base font-extrabold text-[#0F172A]">Detail Pinjaman</h3>
            <button type="button" onclick="closeDetailLoanModal()" class="text-[#64748B] hover:text-[#0F172A] p-1 rounded-lg hover:bg-[#F8FAFC] transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-[11px] font-bold text-[#64748B] mb-0.5 uppercase tracking-wider">ID Kontrak</label>
                <span class="text-sm font-bold text-[#0F172A] break-all" id="detailLoanId">-</span>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-[#64748B] mb-0.5 uppercase tracking-wider">Tanggal Pengajuan</label>
                <span class="text-sm font-bold text-[#0F172A]" id="detailLoanDate">-</span>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-[#64748B] mb-0.5 uppercase tracking-wider">ID Anggota</label>
                <span class="text-sm font-bold text-[#64748B]" id="detailMemberId">-</span>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-[#64748B] mb-0.5 uppercase tracking-wider">Nama Anggota</label>
                <span class="text-sm font-bold text-[#0F172A]" id="detailMemberName">-</span>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-[#64748B] mb-0.5 uppercase tracking-wider">Nominal Pinjaman</label>
                <span class="text-sm font-extrabold text-[#0F172A]" id="detailAmount">-</span>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-[#64748B] mb-0.5 uppercase tracking-wider">Tenor</label>
                <span class="text-sm font-bold text-[#0F172A]" id="detailTenor">-</span>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-[#64748B] mb-0.5 uppercase tracking-wider">Progress Cicilan</label>
                <span class="text-sm font-bold text-[#0F172A]" id="detailProgress">-</span>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-[#64748B] mb-0.5 uppercase tracking-wider">Sisa Pinjaman</label>
                <span class="text-sm font-extrabold text-[#2563EB]" id="detailRemaining">-</span>
            </div>

            <!-- STATUS -->
            <div class="col-span-2">
                <label class="block text-[11px] font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Status</label>
                <span id="detailStatus" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold inline-block border">-</span>
            </div>

            <!-- APPROVAL -->
            <div class="col-span-2">
                <label class="block text-[11px] font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Status Approval</label>
                <span id="detailApproval" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold inline-block border">-</span>
            </div>

            <!-- KETERANGAN -->
            <div class="col-span-2">
                <label class="block text-[11px] font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Keterangan</label>
                <div id="detailKeterangan" class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] whitespace-pre-wrap break-words">-</div>
            </div>

            <!-- BUKTI -->
            <div class="col-span-2">
                <label class="block text-[11px] font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Bukti Pembayaran</label>
                <div id="detailProofContainer" class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-3">
                    <span id="detailProofText" class="text-xs text-[#64748B]">Belum ada bukti pembayaran</span>
                    <a href="#" id="detailProofLink" target="_blank" class="hidden inline-flex items-center gap-2 text-xs text-[#2563EB] hover:text-[#1D4ED8] font-semibold">
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                        Lihat Bukti Pembayaran
                    </a>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-3 border-t border-[#E2E8F0]">
            <button type="button" onclick="closeDetailLoanModal()"
                class="px-4 py-2 text-xs font-semibold text-[#64748B] hover:text-[#0F172A] bg-white border border-[#E2E8F0] hover:bg-[#F8FAFC] rounded-xl transition duration-150">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- PAY INSTALLMENT MODAL -->
<div id="payInstallmentModal" class="fixed inset-0 flex items-center justify-center p-4 z-50 bg-slate-900/50 backdrop-blur-sm hidden">
    <div class="bg-white border border-[#E2E8F0] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-5">
        <div class="flex justify-between items-center pb-3 border-b border-[#E2E8F0]">
            <h3 class="text-base font-extrabold text-[#0F172A]">Bayar Cicilan</h3>
            <button type="button" onclick="closePayInstallmentModal()" class="text-[#64748B] hover:text-[#0F172A] p-1 rounded-lg hover:bg-[#F8FAFC] transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="payInstallmentForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- INFO -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-1">
                <div>
                    <span class="block text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Nama Anggota</span>
                    <span id="payMemberName" class="text-xs font-extrabold text-[#0F172A] mt-0.5 block">-</span>
                </div>
                <div>
                    <span class="block text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Nominal Pinjaman</span>
                    <span id="payLoanAmount" class="text-xs font-bold text-[#2563EB] mt-0.5 block">-</span>
                </div>
            </div>

            <!-- PROGRESS -->
            <div class="space-y-1.5">
                <div class="flex justify-between items-center text-[11px] font-bold">
                    <span class="text-[#64748B] uppercase tracking-wider">Progress Cicilan</span>
                    <span id="payProgressText" class="text-[#0F172A]">-</span>
                </div>
                <div class="w-full bg-[#F8FAFC] rounded-full h-2 overflow-hidden border border-[#E2E8F0]">
                    <div id="payProgressBar" class="bg-[#2563EB] h-full rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>

            <!-- REMAINING -->
            <div class="flex justify-between items-center py-2.5 border-t border-b border-[#E2E8F0]">
                <span class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Sisa Pinjaman</span>
                <span id="payRemainingAmount" class="text-sm font-extrabold text-[#0F172A]">-</span>
            </div>

            <!-- CICILAN -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Cicilan Ke</label>
                    <div class="relative">
                        <input type="text" id="payInstallmentNo" readonly
                            class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3 py-2 text-xs font-medium text-[#64748B] select-none focus:outline-none pointer-events-none">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#64748B]">
                            <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                        </span>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Nominal Cicilan</label>
                    <div class="relative">
                        <input type="text" id="payInstallmentAmount" readonly
                            class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3 py-2 text-xs font-medium text-[#64748B] select-none focus:outline-none pointer-events-none">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#64748B]">
                            <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                        </span>
                    </div>
                </div>
            </div>

            <!-- TANGGAL -->
            <div>
                <label class="block text-[11px] font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">TANGGAL PEMBAYARAN*</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-[#64748B] pointer-events-none">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                    </span>
                    <input type="date" name="tanggal_pembayaran" required value="{{ date('Y-m-d') }}"
                        class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-9 pr-4 py-2.5 text-xs font-medium text-[#0F172A] focus:outline-none focus:border-[#2563EB] focus:bg-white transition">
                </div>
            </div>

            <!-- STATUS -->
            <div>
                <label class="block text-[11px] font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">STATUS*</label>
                <div class="relative">
                    <select name="status" id="payStatus" required
                        class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs font-medium text-[#0F172A] focus:outline-none focus:border-[#2563EB] focus:bg-white appearance-none cursor-pointer">
                        <option value="Aktif">Aktif</option>
                        <option value="Menunggak">Menunggak</option>
                        <option value="Lunas">Lunas</option>
                    </select>
                    <i data-lucide="chevron-down" class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-[#64748B] pointer-events-none"></i>
                </div>
            </div>

            <!-- BUKTI -->
            <div>
                <label class="block text-[11px] font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">BUKTI PEMBAYARAN*</label>
                <input type="file" name="bukti_transfer" id="buktiTransfer" required
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3 py-2 text-xs text-[#0F172A] file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#2563EB] file:text-white hover:file:bg-[#1D4ED8] cursor-pointer">
                <p class="text-[11px] text-[#64748B] mt-1.5">Format JPG, JPEG, PNG atau WEBP. Maksimal 2MB.</p>
            </div>

            <!-- BUTTONS -->
            <div class="flex items-center gap-3 pt-3 justify-end">
                <button type="button" onclick="closePayInstallmentModal()"
                    class="px-4 py-2 text-xs font-semibold text-[#64748B] hover:text-[#0F172A] bg-white border border-[#E2E8F0] hover:bg-[#F8FAFC] rounded-xl transition duration-150">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 text-xs font-bold text-white bg-[#2563EB] hover:bg-[#1D4ED8] rounded-xl transition duration-150 shadow-md shadow-blue-600/20">
                    Konfirmasi Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>
@endpush

@endsection

@section('scripts')
<script>
function openImportModal() {
    const modal = document.getElementById('importModal');
    if (modal) modal.classList.remove('hidden');
}

function closeImportModal() {
    const modal = document.getElementById('importModal');
    if (modal) modal.classList.add('hidden');
}

const originalLoans = @json($loans ?? []);
let currentFilterStatus = 'All';
let currentPage = 1;
const itemsPerPage = 10;
let filteredLoans = Array.isArray(originalLoans) ? [...originalLoans] : [];

function formatRupiah(value) {
    const number = Number(value) || 0;
    return 'Rp ' + new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0 }).format(number);
}

function parseDate(dateStr) {
    if (!dateStr) return new Date(0);
    return new Date(dateStr);
}

function setFilterStatus(status) {
    currentFilterStatus = status;
    const tabs = {
        'All': 'tab-all',
        'Aktif': 'tab-aktif',
        'Menunggak': 'tab-menunggak',
        'Lunas': 'tab-lunas'
    };

    Object.keys(tabs).forEach(key => {
        const el = document.getElementById(tabs[key]);
        if (!el) return;
        if (key === status) {
            el.className = 'px-3.5 py-1.5 rounded-lg text-xs font-semibold transition duration-150 bg-[#2563EB] text-white shadow-sm';
        } else {
            el.className = 'px-3.5 py-1.5 rounded-lg text-xs font-semibold transition duration-150 text-[#64748B] hover:text-[#0F172A]';
        }
    });

    currentPage = 1;
    applyFilters();
}

function applyFilters() {
    const searchElement = document.getElementById('searchInput');
    const sortElement = document.getElementById('sortBy');

    const query = searchElement ? searchElement.value.trim().toLowerCase() : '';
    const sortBy = sortElement ? sortElement.value : 'date-desc';

    filteredLoans = originalLoans.filter(loan => {
        const name = String(loan.name ?? '').toLowerCase();
        const formattedId = String(loan.formattedId ?? '').toLowerCase();
        const memberId = String(loan.memberId ?? '').toLowerCase();
        const status = String(loan.status ?? 'Aktif');

        const matchesSearch = name.includes(query) || formattedId.includes(query) || memberId.includes(query);
        const matchesTab = currentFilterStatus === 'All' || status === currentFilterStatus;
        return matchesSearch && matchesTab;
    });

    filteredLoans.sort((a, b) => {
        if (sortBy === 'date-desc') return parseDate(b.date) - parseDate(a.date);
        if (sortBy === 'date-asc') return parseDate(a.date) - parseDate(b.date);
        if (sortBy === 'amount-desc') return (Number(b.amount) || 0) - (Number(a.amount) || 0);
        if (sortBy === 'amount-asc') return (Number(a.amount) || 0) - (Number(b.amount) || 0);
        return 0;
    });

    renderTable();
}

function renderTable() {
    const tbody = document.getElementById('loansTableBody');
    const emptyState = document.getElementById('emptyState');
    const paginationText = document.getElementById('paginationText');
    const paginationControls = document.getElementById('paginationControls');

    if (!tbody) return;
    tbody.innerHTML = '';

    const totalItems = filteredLoans.length;
    const hasItems = totalItems > 0;

    if (emptyState) emptyState.classList.toggle('hidden', hasItems);

    if (!hasItems) {
        if (paginationText) paginationText.textContent = 'Menampilkan 0 dari 0 data pinjaman';
        if (paginationControls) paginationControls.innerHTML = '';
        return;
    }

    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = Math.min(startIndex + itemsPerPage, totalItems);
    const paginatedItems = filteredLoans.slice(startIndex, endIndex);

    paginatedItems.forEach(loan => {
        const status = String(loan.status ?? 'Aktif');
        const statusPersetujuan = String(loan.statusPersetujuan ?? 'Menunggu');
        const name = String(loan.name ?? '-');
        const memberId = String(loan.memberId ?? '-');
        const formattedDate = String(loan.formattedDate ?? '-');
        const amount = Number(loan.amount) || 0;
        const tenor = Number(loan.tenor) || 0;
        const paid = Number(loan.paid) || 0;
        const remaining = Number(loan.remaining) || 0;

        let statusClass = 'bg-blue-50 text-[#2563EB] border-blue-200';
        if (status === 'Pengajuan') statusClass = 'bg-amber-50 text-amber-600 border-amber-200';
        else if (status === 'Lunas') statusClass = 'bg-emerald-50 text-emerald-600 border-emerald-200';
        else if (status === 'Menunggak') statusClass = 'bg-rose-50 text-rose-600 border-rose-200';

        let approvalClass = 'bg-amber-50 text-amber-600 border-amber-200';
        if (statusPersetujuan === 'Disetujui') approvalClass = 'bg-emerald-50 text-emerald-600 border-emerald-200';
        else if (statusPersetujuan === 'Ditolak') approvalClass = 'bg-rose-50 text-rose-600 border-rose-200';

        let displayDate = formattedDate.replace('Oct', 'Okt').replace('Dec', 'Des');

        const paymentButton = status === 'Lunas'
            ? `<button type="button" disabled class="w-8 h-8 rounded-lg bg-slate-100 text-slate-300 border border-slate-200 flex items-center justify-center opacity-50 cursor-not-allowed" title="Pinjaman sudah lunas">
                    <i data-lucide="credit-card" class="w-4 h-4"></i>
               </button>`
            : `<button type="button" onclick="openPayInstallmentModal(${loan.id})" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center hover:bg-emerald-100 transition shadow-sm" title="Bayar Cicilan">
                    <i data-lucide="credit-card" class="w-4 h-4"></i>
               </button>`;

        let approvalButtons = '';
        if (status === 'Pengajuan' && statusPersetujuan === 'Menunggu') {
            const approvalUrl = @json(url('/pinjaman')) + '/' + loan.id + '/approval';
            approvalButtons = `
                <form method="POST" action="${approvalUrl}" class="inline">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="status_persetujuan" value="Disetujui">
                    <button type="submit" onclick="return confirm('Yakin ingin menyetujui pengajuan pinjaman ini?')" class="p-1.5 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-200 hover:bg-emerald-100 transition" title="Setujui">
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </button>
                </form>
                <form method="POST" action="${approvalUrl}" class="inline">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="status_persetujuan" value="Ditolak">
                    <button type="submit" onclick="return confirm('Yakin ingin menolak pengajuan pinjaman ini?')" class="p-1.5 rounded-lg bg-rose-50 text-rose-600 border border-rose-200 hover:bg-rose-100 transition" title="Tolak">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </form>
            `;
        }

        const row = document.createElement('tr');
        row.className = 'hover:bg-[#F8FAFC] transition duration-150';
        row.innerHTML = `
            <td class="px-6 py-4 text-xs font-medium text-[#64748B]">${displayDate}</td>
            <td class="px-6 py-4">
                <div class="text-xs font-bold text-[#0F172A]">${name}</div>
                <div class="text-[11px] font-medium text-[#64748B] mt-0.5">${memberId}</div>
            </td>
            <td class="px-6 py-4 text-xs font-bold text-[#0F172A]">${formatRupiah(amount)}</td>
            <td class="px-6 py-4 text-xs font-medium text-[#64748B]">${tenor} Bln</td>
            <td class="px-6 py-4 text-xs font-medium text-[#64748B]">${paid}/${tenor}</td>
            <td class="px-6 py-4 text-xs font-bold text-[#0F172A]">${remaining > 0 ? formatRupiah(remaining) : 'Rp 0'}</td>
            <td class="px-6 py-4">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase border ${statusClass}">${status}</span>
            </td>
            <td class="px-6 py-4">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase border ${approvalClass}">${statusPersetujuan}</span>
            </td>
            <td class="px-6 py-4">
                <div class="flex items-center justify-center gap-2">
                    ${approvalButtons}
                    <button type="button" onclick="showDetail(${loan.id})" class="w-8 h-8 rounded-xl bg-blue-50 text-[#2563EB] border border-blue-200/80 flex items-center justify-center hover:bg-[#2563EB] hover:text-white transition-all duration-150 cursor-pointer shadow-sm group" title="Lihat Detail">
                        <i data-lucide="eye" class="w-4 h-4 text-[#2563EB] group-hover:text-white"></i>
                    </button>
                    ${paymentButton}
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });

    if (typeof lucide !== 'undefined') lucide.createIcons();

    if (paginationText) {
        paginationText.textContent = `Menampilkan ${startIndex + 1}-${endIndex} dari ${totalItems} data pinjaman`;
    }

    renderPaginationControls(totalItems);
}

function renderPaginationControls(totalItems) {
    const container = document.getElementById('paginationControls');
    if (!container) return;
    container.innerHTML = '';

    const totalPages = Math.ceil(totalItems / itemsPerPage);
    if (totalPages <= 1) return;

    const prevBtn = document.createElement('button');
    prevBtn.type = 'button';
    prevBtn.disabled = currentPage === 1;
    prevBtn.onclick = () => { if (currentPage > 1) { currentPage--; renderTable(); } };
    prevBtn.className = 'p-1.5 rounded-xl bg-white border border-[#E2E8F0] text-[#64748B] hover:text-[#0F172A] hover:bg-[#F8FAFC] disabled:opacity-40 disabled:pointer-events-none transition duration-150 shadow-sm';
    prevBtn.innerHTML = '<i data-lucide="chevron-left" class="w-4 h-4"></i>';
    container.appendChild(prevBtn);

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
            dots.className = 'px-2 text-xs text-[#64748B] font-semibold';
            dots.textContent = '...';
            container.appendChild(dots);
            return;
        }

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.onclick = () => { currentPage = p; renderTable(); };
        btn.className = `w-7 h-7 rounded-lg text-xs font-bold transition duration-150 ${
            currentPage === p
                ? 'bg-[#2563EB] text-white shadow-sm'
                : 'bg-white border border-[#E2E8F0] text-[#64748B] hover:text-[#0F172A] hover:bg-[#F8FAFC] shadow-sm'
        }`;
        btn.textContent = p;
        container.appendChild(btn);
    });

    const nextBtn = document.createElement('button');
    nextBtn.type = 'button';
    nextBtn.disabled = currentPage === totalPages;
    nextBtn.onclick = () => { if (currentPage < totalPages) { currentPage++; renderTable(); } };
    nextBtn.className = 'p-1.5 rounded-xl bg-white border border-[#E2E8F0] text-[#64748B] hover:text-[#0F172A] hover:bg-[#F8FAFC] disabled:opacity-40 disabled:pointer-events-none transition duration-150 shadow-sm';
    nextBtn.innerHTML = '<i data-lucide="chevron-right" class="w-4 h-4"></i>';
    container.appendChild(nextBtn);

    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function showDetail(id) {
    const loan = originalLoans.find(l => Number(l.id) === Number(id));
    if (!loan) return;

    const elId = document.getElementById('detailLoanId');
    const elDate = document.getElementById('detailLoanDate');
    const elMemberId = document.getElementById('detailMemberId');
    const elMemberName = document.getElementById('detailMemberName');
    const elAmount = document.getElementById('detailAmount');
    const elTenor = document.getElementById('detailTenor');
    const elProgress = document.getElementById('detailProgress');
    const elRemaining = document.getElementById('detailRemaining');
    const elStatus = document.getElementById('detailStatus');
    const elApproval = document.getElementById('detailApproval');
    const elKet = document.getElementById('detailKeterangan');

    if (elId) elId.textContent = loan.formattedId ?? '-';
    if (elDate) elDate.textContent = loan.formattedDate ?? '-';
    if (elMemberId) elMemberId.textContent = loan.memberId ?? '-';
    if (elMemberName) elMemberName.textContent = loan.name ?? '-';
    if (elAmount) elAmount.textContent = formatRupiah(loan.amount);
    if (elTenor) elTenor.textContent = `${loan.tenor ?? 0} Bulan`;
    if (elProgress) elProgress.textContent = `${loan.paid ?? 0} / ${loan.tenor ?? 0} Bulan`;
    if (elRemaining) elRemaining.textContent = Number(loan.remaining) > 0 ? formatRupiah(loan.remaining) : 'Rp 0';

    const status = loan.status ?? 'Aktif';
    if (elStatus) {
        elStatus.textContent = status.toUpperCase();
        elStatus.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-bold inline-block border';
        if (status === 'Pengajuan') elStatus.classList.add('bg-amber-50', 'text-amber-600', 'border-amber-200');
        else if (status === 'Lunas') elStatus.classList.add('bg-emerald-50', 'text-emerald-600', 'border-emerald-200');
        else if (status === 'Menunggak') elStatus.classList.add('bg-rose-50', 'text-rose-600', 'border-rose-200');
        else elStatus.classList.add('bg-blue-50', 'text-[#2563EB]', 'border-blue-200');
    }

    const approval = loan.statusPersetujuan ?? 'Menunggu';
    if (elApproval) {
        elApproval.textContent = approval.toUpperCase();
        elApproval.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-bold inline-block border';
        if (approval === 'Disetujui') elApproval.classList.add('bg-emerald-50', 'text-emerald-600', 'border-emerald-200');
        else if (approval === 'Ditolak') elApproval.classList.add('bg-rose-50', 'text-rose-600', 'border-rose-200');
        else elApproval.classList.add('bg-amber-50', 'text-amber-600', 'border-amber-200');
    }

    if (elKet) elKet.textContent = loan.keterangan ?? '-';

    const proofText = document.getElementById('detailProofText');
    const proofLink = document.getElementById('detailProofLink');
    const bukti = loan.bukti_transfer ?? null;

    if (bukti) {
        let proofUrl = String(bukti);
        if (!proofUrl.startsWith('http://') && !proofUrl.startsWith('https://') && !proofUrl.startsWith('/storage/')) {
            proofUrl = '/storage/' + proofUrl.replace(/^\/+/, '');
        }
        if (proofText) proofText.classList.add('hidden');
        if (proofLink) {
            proofLink.href = proofUrl;
            proofLink.classList.remove('hidden');
        }
    } else {
        if (proofText) {
            proofText.textContent = 'Belum ada bukti pembayaran';
            proofText.classList.remove('hidden');
        }
        if (proofLink) {
            proofLink.classList.add('hidden');
            proofLink.removeAttribute('href');
        }
    }

    const modal = document.getElementById('detailLoanModal');
    if (modal) modal.classList.remove('hidden');
    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function closeDetailLoanModal() {
    const modal = document.getElementById('detailLoanModal');
    if (modal) modal.classList.add('hidden');
}

function showMemberDropdown() {
    const list = document.getElementById('memberDropdownList');
    if (list) list.classList.remove('hidden');
}

function filterMembers() {
    const input = document.getElementById('memberSearchInput');
    const list = document.getElementById('memberDropdownList');
    if (!input || !list) return;

    const val = input.value.toLowerCase();
    const items = list.children;

    for (let i = 0; i < items.length; i++) {
        const text = items[i].textContent.toLowerCase();
        if (text.includes(val)) items[i].classList.remove('hidden');
        else items[i].classList.add('hidden');
    }
    list.classList.remove('hidden');
}

function selectMember(id, displayText) {
    const selectedMember = document.getElementById('selectedMemberId');
    const input = document.getElementById('memberSearchInput');
    const list = document.getElementById('memberDropdownList');
    if (selectedMember) selectedMember.value = id;
    if (input) input.value = displayText;
    if (list) list.classList.add('hidden');
}

document.addEventListener('click', function(e) {
    const input = document.getElementById('memberSearchInput');
    const list = document.getElementById('memberDropdownList');
    if (input && list && !input.contains(e.target) && !list.contains(e.target)) {
        list.classList.add('hidden');
    }
});

function calculateSummary() {
    const nominalInput = document.getElementById('inputNominal');
    const tenorInput = document.getElementById('inputTenor');
    if (!nominalInput || !tenorInput) return;

    const nominal = parseFloat(nominalInput.value) || 0;
    const tenor = parseInt(tenorInput.value) || 0;

    const adminFee = nominal * 0.01;
    const totalReturn = nominal + adminFee;
    let monthlyPayment = 0;
    if (tenor > 0) monthlyPayment = Math.round(totalReturn / tenor);

    const summaryAdminFee = document.getElementById('summaryAdminFee');
    const summaryMonthlyPayment = document.getElementById('summaryMonthlyPayment');
    const summaryTotalReturn = document.getElementById('summaryTotalReturn');

    if (summaryAdminFee) summaryAdminFee.textContent = formatRupiah(adminFee);
    if (summaryMonthlyPayment) summaryMonthlyPayment.textContent = formatRupiah(monthlyPayment);
    if (summaryTotalReturn) summaryTotalReturn.textContent = formatRupiah(totalReturn);
}

function openNewLoanModal() {
    const selectedMember = document.getElementById('selectedMemberId');
    const memberSearch = document.getElementById('memberSearchInput');
    const inputNominal = document.getElementById('inputNominal');
    const inputTenor = document.getElementById('inputTenor');

    if (selectedMember) selectedMember.value = '';
    if (memberSearch) memberSearch.value = '';
    if (inputNominal) inputNominal.value = '';
    if (inputTenor) inputTenor.value = '';

    const textarea = document.querySelector('#newLoanModal textarea');
    if (textarea) textarea.value = '';

    calculateSummary();

    const modal = document.getElementById('newLoanModal');
    if (modal) modal.classList.remove('hidden');
    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function closeNewLoanModal() {
    const modal = document.getElementById('newLoanModal');
    if (modal) modal.classList.add('hidden');
}

function resetFilters() {
    const searchInput = document.getElementById('searchInput');
    const sortBy = document.getElementById('sortBy');
    if (searchInput) searchInput.value = '';
    if (sortBy) sortBy.value = 'date-desc';
    setFilterStatus('All');
}

function openPayInstallmentModal(id) {
    const loan = originalLoans.find(l => Number(l.id) === Number(id));
    if (!loan) return;

    const form = document.getElementById('payInstallmentForm');
    if (form) form.action = `/pinjaman/${loan.id}/bayar`;

    const payMemberName = document.getElementById('payMemberName');
    const payLoanAmount = document.getElementById('payLoanAmount');
    const payProgressText = document.getElementById('payProgressText');
    const payRemainingAmount = document.getElementById('payRemainingAmount');

    if (payMemberName) payMemberName.textContent = loan.name ?? '-';
    if (payLoanAmount) payLoanAmount.textContent = formatRupiah(loan.amount);
    if (payProgressText) payProgressText.textContent = `${loan.paid ?? 0} / ${loan.tenor ?? 0} Cicilan`;
    if (payRemainingAmount) payRemainingAmount.textContent = Number(loan.remaining) > 0 ? formatRupiah(loan.remaining) : 'Rp 0';

    const tenor = Number(loan.tenor) || 0;
    const paid = Number(loan.paid) || 0;
    const progressPercent = tenor > 0 ? Math.min((paid / tenor) * 100, 100) : 0;

    const progressBar = document.getElementById('payProgressBar');
    if (progressBar) progressBar.style.width = progressPercent + '%';

    const nextInstallmentNo = paid + 1;
    const installmentNo = document.getElementById('payInstallmentNo');
    if (installmentNo) installmentNo.value = nextInstallmentNo;

    const remaining = Number(loan.remaining) || 0;
    const remainingMonths = tenor - paid;
    let installmentAmount = 0;
    if (remainingMonths > 0) installmentAmount = Math.round(remaining / remainingMonths);

    const installmentAmountInput = document.getElementById('payInstallmentAmount');
    if (installmentAmountInput) installmentAmountInput.value = formatRupiah(installmentAmount);

    const statusSelect = document.getElementById('payStatus');
    if (statusSelect) {
        const currentStatus = loan.status ?? 'Aktif';
        statusSelect.value = ['Aktif', 'Menunggak', 'Lunas'].includes(currentStatus) ? currentStatus : 'Aktif';
    }

    const fileInput = document.getElementById('buktiTransfer');
    if (fileInput) fileInput.value = '';

    const modal = document.getElementById('payInstallmentModal');
    if (modal) modal.classList.remove('hidden');
    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function closePayInstallmentModal() {
    const modal = document.getElementById('payInstallmentModal');
    if (modal) modal.classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('buktiTransfer');
    if (!fileInput) return;
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran bukti pembayaran maksimal 2MB.');
            this.value = '';
            return;
        }
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format bukti pembayaran harus JPG, JPEG, PNG atau WEBP.');
            this.value = '';
        }
    });
});

window.addEventListener('DOMContentLoaded', function() {
    applyFilters();
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>
@endsection