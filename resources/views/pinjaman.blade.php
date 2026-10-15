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

            <!-- KATEGORI DEBITUR -->
            <div>
                <label class="block text-[11px] font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">KATEGORI DEBITUR*</label>
                <div class="relative">
                    <select name="kategori_debitur" id="inputKategori" onchange="calculateSummary()" required
                        class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs font-medium text-[#0F172A] focus:outline-none focus:border-[#2563EB] focus:bg-white transition appearance-none cursor-pointer">
                        @foreach(\App\Models\PengaturanBunga::KATEGORI as $kategori)
                            <option value="{{ $kategori }}">{{ $kategori }}</option>
                        @endforeach
                    </select>
                    <i data-lucide="chevron-down" class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-[#64748B] pointer-events-none"></i>
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
                    <span>Total Bunga (<span id="summaryPersen">0</span>%/bulan, flat)</span>
                    <span id="summaryBunga" class="font-bold text-[#0F172A]">Rp 0</span>
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

@php
    $bungaPerKategori = \App\Models\PengaturanBunga::pluck('persen_bunga', 'kategori')->toArray();
@endphp
<script>
    window.bungaPerKategori = @json($bungaPerKategori ?: ['Pegawai' => 0.75, 'Umum' => 1.25]);
</script>

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
                    <div id="detailProofImageWrap" class="hidden mt-2">
                        <a href="#" id="detailProofLink" target="_blank">
                            <img id="detailProofImage" src="" alt="Bukti Pembayaran"
                                class="max-h-64 w-auto rounded-lg border border-[#E2E8F0] cursor-zoom-in hover:opacity-90 transition" />
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center pt-3 border-t border-[#E2E8F0]">
            <button type="button" id="detailSendReminderBtn" onclick="sendReminderFromDetail()"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200/80 rounded-xl transition duration-150 shadow-sm">
                <i data-lucide="mail" class="w-4 h-4 text-amber-600"></i>
                <span>Kirim Pengingat Email</span>
            </button>
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

{{-- MODAL ACC / TOLAK PENGAJUAN --}}
<div id="accModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h3 class="text-base font-extrabold text-[#0F172A]">ACC Pengajuan Pinjaman</h3>
                <p class="text-xs text-[#64748B] mt-0.5">Atur bunga & potongan, lalu setujui.</p>
            </div>
            <button type="button" onclick="closeAccModal()" class="text-[#64748B] hover:text-[#0F172A] text-xl leading-none">×</button>
        </div>

        <div class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-3 mb-4 text-xs space-y-1">
            <div class="flex justify-between"><span class="text-[#64748B]">Peminjam</span><strong id="accNama" class="text-[#0F172A]">-</strong></div>
            <div class="flex justify-between"><span class="text-[#64748B]">Nominal</span><strong id="accNominal" class="text-[#0F172A]">-</strong></div>
            <div class="flex justify-between"><span class="text-[#64748B]">Tenor</span><strong id="accTenor" class="text-[#0F172A]">-</strong></div>
            <div class="flex justify-between"><span class="text-[#64748B]">Kategori</span><strong id="accKategori" class="text-[#0F172A]">-</strong></div>
        </div>

        <form id="accForm" method="POST" action="">
            @csrf
            <div class="mb-3">
                <label class="block text-[11px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Bunga per Bulan (%)</label>
                <input type="number" step="0.01" min="0" max="100" id="accPersen" name="persen_bunga" required
                    class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3 py-2 text-xs font-semibold text-[#0F172A] focus:outline-none focus:border-[#2563EB]">
                <p class="text-[10px] text-[#64748B] mt-1">Kosongkan penyesuaian & gunakan default kategori, atau ubah sesuai kebijakan.</p>
            </div>

            <div class="mb-4">
                <label class="block text-[11px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">Potongan Admin (Rp)</label>
                <input type="text" inputmode="numeric" id="accPotongan" name="potongan_admin"
                    class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3 py-2 text-xs font-semibold text-[#0F172A] focus:outline-none focus:border-[#2563EB]"
                    oninput="this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')">
                <p class="text-[10px] text-[#64748B] mt-1">Dipotong langsung dari nominal sebelum pencairan. Kosongkan = tanpa potongan.</p>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 mb-4 text-xs space-y-1">
                <div class="flex justify-between"><span class="text-[#64748B]">Total Bunga</span><strong id="accPreviewBunga">-</strong></div>
                <div class="flex justify-between"><span class="text-[#64748B]">Cicilan / Bulan</span><strong id="accPreviewCicilan">-</strong></div>
                <div class="flex justify-between"><span class="text-[#64748B]">Diterima Bersih</span><strong id="accPreviewBersih">-</strong></div>
            </div>

            <div class="flex items-center gap-3 justify-end">
                <button type="button" onclick="submitTolak()"
                    class="px-4 py-2 text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-xl transition">
                    Tolak
                </button>
                <button type="submit"
                    class="px-4 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition shadow-md shadow-emerald-600/20">
                    Setujui (ACC)
                </button>
            </div>
        </form>
    </div>
</div>

<!-- EMAIL REMINDER MODAL -->
<div id="emailReminderModal" class="fixed inset-0 flex items-center justify-center p-4 z-50 bg-slate-900/60 backdrop-blur-sm hidden transition-all duration-200">
    <div class="bg-white border border-[#E2E8F0] rounded-2xl max-w-md w-full p-6 shadow-2xl relative overflow-hidden">
        <!-- Top Gradient Accent Strip -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-600 via-indigo-600 to-cyan-500"></div>

        <!-- 1. FORM STATE -->
        <div id="reminderFormState" class="space-y-4 pt-1">
            <!-- Modal Header -->
            <div class="flex justify-between items-start pb-3 border-b border-[#E2E8F0]">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center shrink-0 shadow-sm">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-[#0F172A]">Kirim Pengingat Pembayaran</h3>
                        <p class="text-xs text-[#64748B] mt-0.5">Notifikasi tagihan resmi ke email customer</p>
                    </div>
                </div>
                <button type="button" onclick="closeEmailReminderModal()" class="text-[#64748B] hover:text-[#0F172A] p-1.5 rounded-lg hover:bg-[#F8FAFC] transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Loan Summary Box -->
            <div class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-3.5 space-y-2 text-xs">
                <div class="flex items-center justify-between pb-2 border-b border-[#E2E8F0]">
                    <span class="text-[#64748B] font-medium">Anggota</span>
                    <span class="font-bold text-[#0F172A]" id="remindMemberName">-</span>
                </div>
                <div class="grid grid-cols-2 gap-2.5 py-1">
                    <div>
                        <span class="text-[11px] text-[#64748B] block">No. Pinjaman</span>
                        <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-[#2563EB] border border-blue-200" id="remindLoanId">-</span>
                    </div>
                    <div>
                        <span class="text-[11px] text-[#64748B] block">Cicilan Ke</span>
                        <span class="font-bold text-[#0F172A] text-xs block mt-0.5" id="remindCicilanKe">-</span>
                    </div>
                    <div>
                        <span class="text-[11px] text-[#64748B] block">Estimasi Tagihan</span>
                        <span class="font-extrabold text-[#2563EB] text-sm block mt-0.5" id="remindTagihan">-</span>
                    </div>
                    <div>
                        <span class="text-[11px] text-[#64748B] block">Sisa Pinjaman</span>
                        <span class="font-bold text-rose-600 text-xs block mt-0.5" id="remindSisa">-</span>
                    </div>
                </div>
            </div>

            <!-- Email Input (Locked / Permanen) -->
            <div class="space-y-1.5">
                <label class="block font-bold text-[#0F172A] text-[11px] uppercase tracking-wider flex items-center justify-between">
                    <span>Email Customer</span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                        <i data-lucide="lock" class="w-3 h-3 text-slate-500"></i>
                        <span>Terkunci / Permanen</span>
                    </span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-[#64748B] pointer-events-none">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                    </span>
                    <input type="email" id="remindEmailInput" readonly tabindex="-1"
                        class="w-full bg-[#F1F5F9] border border-[#E2E8F0] rounded-xl pl-9 pr-3.5 py-2.5 text-xs font-bold text-[#1E293B] cursor-not-allowed select-none pointer-events-none">
                </div>
                <p class="text-[11px] text-[#64748B]">Email resmi anggota yang terdaftar di akun koperasi.</p>
            </div>

            <!-- Catatan Tambahan (Optional) -->
            <div class="space-y-1.5">
                <label class="block font-bold text-[#0F172A] text-[11px] uppercase tracking-wider">
                    Pesan / Catatan Tambahan <span class="text-[#94A3B8] font-normal lowercase">(opsional)</span>
                </label>
                <textarea id="remindCatatanInput" rows="2"
                    placeholder="Contoh: Mohon transfer sebelum tanggal jatuh tempo. Terima kasih."
                    class="w-full bg-white border border-[#E2E8F0] rounded-xl px-3.5 py-2 text-xs text-[#0F172A] placeholder-[#94A3B8] focus:outline-none focus:border-[#2563EB] focus:ring-2 focus:ring-blue-100 transition resize-none"></textarea>
            </div>

            <!-- Footer Buttons -->
            <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#E2E8F0]">
                <button type="button" onclick="closeEmailReminderModal()"
                    class="px-4 py-2.5 text-xs font-semibold text-[#64748B] hover:text-[#0F172A] bg-white border border-[#E2E8F0] hover:bg-[#F8FAFC] rounded-xl transition duration-150">
                    Batal
                </button>
                <button type="button" onclick="executeSendReminder()"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#2563EB] hover:bg-[#1D4ED8] text-white text-xs font-bold rounded-xl transition shadow-md shadow-blue-600/25">
                    <i data-lucide="send" class="w-3.5 h-3.5"></i>
                    <span>Kirim Email Sekarang</span>
                </button>
            </div>
        </div>

        <!-- 2. LOADING STATE -->
        <div id="reminderLoadingState" class="hidden py-8 flex flex-col items-center justify-center text-center space-y-4">
            <div class="relative w-20 h-20 flex items-center justify-center">
                <div class="absolute inset-0 rounded-full bg-blue-500/20 animate-ping"></div>
                <div class="relative w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center shadow-xl shadow-blue-500/30">
                    <i data-lucide="send" class="w-8 h-8 animate-pulse"></i>
                </div>
            </div>
            
            <div class="space-y-1.5 max-w-xs">
                <h4 class="text-base font-extrabold text-[#0F172A]">Mengirim Email Notifikasi...</h4>
                <p class="text-xs text-[#64748B] leading-relaxed">
                    Sedang menghubungkan ke server email dan mengirimkan rincian tagihan ke <span id="loadingTargetEmail" class="font-bold text-[#0F172A]">...</span>
                </p>
            </div>

            <!-- Flowing Progress Bar -->
            <div class="w-full max-w-xs bg-slate-100 rounded-full h-2 overflow-hidden border border-slate-200/80">
                <div class="h-full bg-gradient-to-r from-blue-600 via-indigo-600 to-cyan-500 rounded-full w-full animate-pulse"></div>
            </div>
        </div>

        <!-- 3. SUCCESS STATE -->
        <div id="reminderSuccessState" class="hidden py-6 flex flex-col items-center justify-center text-center space-y-4">
            <div class="w-16 h-16 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/10">
                <i data-lucide="check-circle" class="w-8 h-8 text-emerald-600"></i>
            </div>
            <div class="space-y-1.5 max-w-xs">
                <h4 class="text-base font-extrabold text-[#0F172A]">Email Berhasil Terkirim!</h4>
                <p class="text-xs text-[#64748B] leading-relaxed" id="reminderSuccessMsg">
                    Notifikasi tagihan cicilan telah berhasil dikirimkan ke email customer.
                </p>
            </div>
            <button type="button" onclick="closeEmailReminderModal()"
                class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-md shadow-emerald-600/20">
                Selesai
            </button>
        </div>

        <!-- 4. ERROR STATE -->
        <div id="reminderErrorState" class="hidden py-6 flex flex-col items-center justify-center text-center space-y-4">
            <div class="w-16 h-16 rounded-2xl bg-rose-50 border border-rose-200 text-rose-600 flex items-center justify-center shadow-lg shadow-rose-500/10">
                <i data-lucide="alert-circle" class="w-8 h-8 text-rose-600"></i>
            </div>
            <div class="space-y-1.5 max-w-xs">
                <h4 class="text-base font-extrabold text-[#0F172A]">Gagal Mengirim Email</h4>
                <p class="text-xs text-rose-600 leading-relaxed" id="reminderErrorMsg">
                    Terjadi kesalahan saat memproses pengiriman email.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" onclick="closeEmailReminderModal()"
                    class="px-4 py-2 text-xs font-semibold text-[#64748B] hover:text-[#0F172A] bg-white border border-[#E2E8F0] hover:bg-[#F8FAFC] rounded-xl transition">
                    Tutup
                </button>
                <button type="button" onclick="executeSendReminder()"
                    class="px-5 py-2 bg-[#2563EB] hover:bg-[#1D4ED8] text-white text-xs font-bold rounded-xl transition shadow-md shadow-blue-600/25">
                    Coba Lagi
                </button>
            </div>
        </div>

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
window.bungaPerKategori = @json(\App\Models\PengaturanBunga::orderBy('id')->pluck('persen_bunga', 'kategori'));
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

        let displayDate = formattedDate.replace('Oct', 'Okt').replace('Dec', 'Des');

        const paymentButton = status === 'Lunas'
            ? `<button type="button" disabled class="w-8 h-8 rounded-lg bg-slate-100 text-slate-300 border border-slate-200 flex items-center justify-center opacity-50 cursor-not-allowed" title="Pinjaman sudah lunas">
                    <i data-lucide="credit-card" class="w-4 h-4"></i>
               </button>`
            : status === 'Pengajuan'
            ? `<button type="button" onclick="openAccModal(${loan.id})" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center hover:bg-emerald-100 transition shadow-sm" title="ACC / Tolak Pengajuan">
                    <i data-lucide="check-check" class="w-4 h-4"></i>
               </button>`
            : `<button type="button" onclick="openPayInstallmentModal(${loan.id})" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center hover:bg-emerald-100 transition shadow-sm" title="Bayar Cicilan">
                    <i data-lucide="credit-card" class="w-4 h-4"></i>
               </button>`;

        const reminderButton = status === 'Lunas'
            ? `<button type="button" disabled class="w-8 h-8 rounded-lg bg-slate-100 text-slate-300 border border-slate-200 flex items-center justify-center opacity-50 cursor-not-allowed" title="Pinjaman sudah lunas">
                    <i data-lucide="mail" class="w-4 h-4"></i>
               </button>`
            : `<button type="button" onclick="openSendReminderModal(${loan.id})" class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 border border-amber-200/80 flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all duration-150 cursor-pointer shadow-sm group" title="Kirim Notifikasi Pembayaran via Email">
                    <i data-lucide="mail" class="w-4 h-4 text-amber-600 group-hover:text-white"></i>
               </button>`;

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
                <div class="flex items-center justify-center gap-1.5">
                    <button type="button" onclick="showDetail(${loan.id})" class="w-8 h-8 rounded-lg bg-blue-50 text-[#2563EB] border border-blue-200/80 flex items-center justify-center hover:bg-[#2563EB] hover:text-white transition-all duration-150 cursor-pointer shadow-sm group" title="Lihat Detail">
                        <i data-lucide="eye" class="w-4 h-4 text-[#2563EB] group-hover:text-white"></i>
                    </button>
                    ${paymentButton}
                    ${reminderButton}
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

let currentDetailLoanId = null;

function showDetail(id) {
    currentDetailLoanId = id;
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

    const detailReminderBtn = document.getElementById('detailSendReminderBtn');
    if (detailReminderBtn) {
        if (status === 'Lunas') {
            detailReminderBtn.classList.add('hidden');
        } else {
            detailReminderBtn.classList.remove('hidden');
        }
    }

    if (elKet) elKet.textContent = loan.keterangan ?? '-';

    const proofText = document.getElementById('detailProofText');
    const proofLink = document.getElementById('detailProofLink');
    const proofImage = document.getElementById('detailProofImage');
    const proofImageWrap = document.getElementById('detailProofImageWrap');
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
        if (proofImage) proofImage.src = proofUrl;
        if (proofImageWrap) proofImageWrap.classList.remove('hidden');
    } else {
        if (proofText) {
            proofText.textContent = 'Belum ada bukti pembayaran';
            proofText.classList.remove('hidden');
        }
        if (proofLink) {
            proofLink.classList.add('hidden');
            proofLink.removeAttribute('href');
        }
        if (proofImage) proofImage.removeAttribute('src');
        if (proofImageWrap) proofImageWrap.classList.add('hidden');
    }

    const modal = document.getElementById('detailLoanModal');
    if (modal) modal.classList.remove('hidden');
    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function sendReminderFromDetail() {
    if (currentDetailLoanId) {
        openSendReminderModal(currentDetailLoanId);
    }
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
    const kategoriInput = document.getElementById('inputKategori');
    if (!nominalInput || !tenorInput) return;

    const nominal = parseFloat(nominalInput.value) || 0;
    const tenor = parseInt(tenorInput.value) || 0;
    const kategori = kategoriInput ? kategoriInput.value : 'Pegawai';
    const persen = (window.bungaPerKategori && window.bungaPerKategori[kategori]) || 0;

    const totalBunga = Math.round(nominal * (persen / 100) * tenor);
    const totalReturn = nominal + totalBunga;
    let monthlyPayment = 0;
    if (tenor > 0) monthlyPayment = Math.round(totalReturn / tenor);

    const summaryPersen = document.getElementById('summaryPersen');
    const summaryBunga = document.getElementById('summaryBunga');
    const summaryMonthlyPayment = document.getElementById('summaryMonthlyPayment');
    const summaryTotalReturn = document.getElementById('summaryTotalReturn');

    if (summaryPersen) summaryPersen.textContent = persen;
    if (summaryBunga) summaryBunga.textContent = formatRupiah(totalBunga);
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

    const payForm = document.getElementById('payInstallmentForm');
    const pelunasanInfo = document.getElementById('payPelunasanInfo');
    const existingCheck = document.getElementById('payTipePelunasan');
    if (existingCheck) existingCheck.checked = false;
    const existingTipe = document.getElementById('payTipeInput');
    if (existingTipe) existingTipe.value = 'cicilan';
    if (pelunasanInfo) {
        pelunasanInfo.textContent = 'Pelunasan dipercepat: bayar seluruh sisa ' + formatRupiah(loan.remaining) + ' sekaligus, tanpa menunggu tenor habis.';
    }
    if (payForm && !document.getElementById('payTipePelunasanWrap')) {
        const wrap = document.createElement('div');
        wrap.id = 'payTipePelunasanWrap';
        wrap.className = 'bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-3 space-y-2';
        wrap.innerHTML = `
            <label class="flex items-center gap-2 text-xs font-medium text-[#0F172A]">
                <input type="checkbox" id="payTipePelunasan" onchange="togglePelunasan()" class="rounded border-[#E2E8F0] text-[#2563EB] focus:ring-[#2563EB]">
                <span>Pelunasan Dipercepat (bayar semua sisa sekaligus)</span>
            </label>
            <p id="payPelunasanInfo" class="text-[11px] text-[#64748B] leading-relaxed"></p>
        `;
        payForm.insertBefore(wrap, payForm.querySelector('.flex.items-center.gap-3.pt-3'));
    }

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

function togglePelunasan() {
    const checked = document.getElementById('payTipePelunasan')?.checked ?? false;
    let hidden = document.getElementById('payTipeInput');
    if (!hidden) {
        hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'tipe';
        hidden.id = 'payTipeInput';
        hidden.value = 'cicilan';
        document.getElementById('payInstallmentForm').appendChild(hidden);
    }
    hidden.value = checked ? 'pelunasan' : 'cicilan';
}

/* ==== ACC / TOLAK PENGAJUAN ==== */
let accLoan = null;

function openAccModal(id) {
    const loan = originalLoans.find(l => Number(l.id) === Number(id));
    if (!loan) return;
    accLoan = loan;

    const form = document.getElementById('accForm');
    form.action = `/pinjaman/${loan.id}/acc`;

    document.getElementById('accNama').textContent = loan.name ?? '-';
    document.getElementById('accNominal').textContent = formatRupiah(loan.amount);
    document.getElementById('accTenor').textContent = `${loan.tenor ?? 0} Bulan`;
    document.getElementById('accKategori').textContent = loan.kategori ?? '-';

    const defaultPersen = Number(window.bungaPerKategori?.[loan.kategori] ?? 0);
    document.getElementById('accPersen').value = defaultPersen;
    document.getElementById('accPotongan').value = '';

    updateAccPreview();

    const modal = document.getElementById('accModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeAccModal() {
    const modal = document.getElementById('accModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    accLoan = null;
}

function updateAccPreview() {
    if (!accLoan) return;

    const nominal = Number(accLoan.amount) || 0;
    const tenor = Number(accLoan.tenor) || 0;
    const persen = parseFloat(document.getElementById('accPersen').value) || 0;
    const potongan = Number(document.getElementById('accPotongan').value.replace(/\D/g, '')) || 0;

    const totalBunga = Math.round(nominal * (persen / 100) * tenor);
    const cicilan = tenor > 0 ? Math.round((nominal + totalBunga) / tenor) : 0;
    const bersih = Math.max(0, nominal - potongan);

    document.getElementById('accPreviewBunga').textContent = formatRupiah(totalBunga);
    document.getElementById('accPreviewCicilan').textContent = formatRupiah(cicilan);
    document.getElementById('accPreviewBersih').textContent = formatRupiah(bersih);
}

document.getElementById('accPersen')?.addEventListener('input', updateAccPreview);
document.getElementById('accPotongan')?.addEventListener('input', updateAccPreview);

function submitTolak() {
    if (!accLoan) return;

    if (!confirm(`Tolak pengajuan pinjaman #${accLoan.id}?`)) return;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/pinjaman/${accLoan.id}/tolak`;

    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = document.querySelector('meta[name="csrf-token"]')?.content
        ?? document.getElementById('accForm').querySelector('input[name="_token"]')?.value
        ?? '';
    form.appendChild(csrf);

    const alasan = prompt('Alasan penolakan (opsional):');
    if (alasan) {
        const alasanInput = document.createElement('input');
        alasanInput.type = 'hidden';
        alasanInput.name = 'alasan';
        alasanInput.value = alasan;
        form.appendChild(alasanInput);
    }

    document.body.appendChild(form);
    form.submit();
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

let currentReminderLoanId = null;

function openSendReminderModal(id) {
    const loan = originalLoans.find(l => Number(l.id) === Number(id));
    if (!loan) return;

    const email = (loan.email || '').trim();

    if (!email) {
        Swal.fire({
            icon: 'warning',
            title: 'Email Tidak Ditemukan',
            text: `Anggota ${loan.name} (${loan.memberId}) belum memiliki alamat email yang terdaftar di sistem.`,
            confirmButtonColor: '#2563EB',
            customClass: {
                popup: 'rounded-2xl border border-[#E2E8F0] shadow-2xl p-6',
                confirmButton: 'px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider'
            }
        });
        return;
    }

    currentReminderLoanId = id;

    // Set preview values
    const memberName = document.getElementById('remindMemberName');
    const loanId = document.getElementById('remindLoanId');
    const cicilanKe = document.getElementById('remindCicilanKe');
    const tagihan = document.getElementById('remindTagihan');
    const sisa = document.getElementById('remindSisa');
    const emailInput = document.getElementById('remindEmailInput');
    const catatanInput = document.getElementById('remindCatatanInput');

    if (memberName) memberName.textContent = `${loan.name} (${loan.memberId})`;
    if (loanId) loanId.textContent = loan.formattedId;
    if (cicilanKe) cicilanKe.textContent = `${loan.cicilanKe || (Number(loan.paid || 0) + 1)} dari ${loan.tenor} Bulan`;
    if (tagihan) tagihan.textContent = loan.cicilanPerBulan ? formatRupiah(loan.cicilanPerBulan) : '-';
    if (sisa) sisa.textContent = loan.remaining ? formatRupiah(loan.remaining) : '-';
    if (emailInput) emailInput.value = email;
    if (catatanInput) catatanInput.value = '';

    // Reset to form view
    setReminderState('form');

    const modal = document.getElementById('emailReminderModal');
    if (modal) modal.classList.remove('hidden');
    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function closeEmailReminderModal() {
    const modal = document.getElementById('emailReminderModal');
    if (modal) modal.classList.add('hidden');
}

function setReminderState(state) {
    const formState = document.getElementById('reminderFormState');
    const loadingState = document.getElementById('reminderLoadingState');
    const successState = document.getElementById('reminderSuccessState');
    const errorState = document.getElementById('reminderErrorState');

    if (formState) formState.classList.toggle('hidden', state !== 'form');
    if (loadingState) loadingState.classList.toggle('hidden', state !== 'loading');
    if (successState) successState.classList.toggle('hidden', state !== 'success');
    if (errorState) errorState.classList.toggle('hidden', state !== 'error');

    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function executeSendReminder() {
    if (!currentReminderLoanId) return;
    const loan = originalLoans.find(l => Number(l.id) === Number(currentReminderLoanId));
    if (!loan) return;

    const email = (loan.email || '').trim();
    const catatan = document.getElementById('remindCatatanInput')?.value.trim() || '';

    const targetLabel = document.getElementById('loadingTargetEmail');
    if (targetLabel) targetLabel.textContent = email;

    // Switch to sleek animated loading state
    setReminderState('loading');

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch(`/pinjaman/${loan.id}/kirim-notifikasi`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            email: email,
            catatan: catatan
        })
    })
    .then(async res => {
        const data = await res.json();
        if (!res.ok || !data.success) {
            throw new Error(data.message || 'Gagal mengirim email.');
        }
        return data;
    })
    .then(data => {
        const successMsg = document.getElementById('reminderSuccessMsg');
        if (successMsg) {
            successMsg.textContent = `Notifikasi tagihan cicilan telah berhasil dikirimkan ke ${email}.`;
        }
        setReminderState('success');
    })
    .catch(err => {
        const errorMsg = document.getElementById('reminderErrorMsg');
        if (errorMsg) {
            errorMsg.textContent = err.message || 'Terjadi kesalahan saat memproses pengiriman email.';
        }
        setReminderState('error');
    });
}

window.addEventListener('DOMContentLoaded', function() {
    applyFilters();
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>
@endsection