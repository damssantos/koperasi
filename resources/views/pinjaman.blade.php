@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Pinjaman Koperasi')

@section('styles')
<style>
    .btn-cancel {
        background-color: #334155 !important;
        color: #f1f5f9 !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        transition: all 0.2s ease-in-out !important;
        cursor: pointer;
    }

    .btn-cancel:hover {
        background-color: #475569 !important;
        color: #ffffff !important;
        transform: scale(1.02) !important;
    }

    .btn-cancel:active {
        transform: scale(0.98) !important;
    }

    .btn-save {
        background-color: #2f54eb !important;
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

<!-- ========================================================= -->
<!-- PAGE HEADER -->
<!-- ========================================================= -->

<div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 pb-6 border-b border-[#1f243d]">

    <div>
        <h2 class="text-2xl font-bold text-white tracking-tight">
            Pinjaman Koperasi
        </h2>

        <p class="text-xs text-[#8f9bb3] mt-0.5">
            Kelola seluruh proses pinjaman anggota, mulai dari pengajuan hingga pelunasan.
        </p>
    </div>

    <div class="flex items-center gap-3">

        <!-- EXPORT -->
        <a
            href="{{ route('pinjaman.export') }}"
            class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white rounded-lg transition duration-150 text-xs font-bold shadow-md shadow-blue-500/10"
        >
            <i data-lucide="file-down" class="w-3.5 h-3.5"></i>
            <span>Export Excel</span>
        </a>


        <!-- IMPORT -->
        <button
            type="button"
            onclick="openImportModal()"
            class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white rounded-lg transition duration-150 text-xs font-bold shadow-md shadow-emerald-500/10"
        >
            <i data-lucide="file-up" class="w-3.5 h-3.5"></i>
            <span>Import Excel</span>
        </button>


        <!-- TAMBAH -->
        <button
            type="button"
            onclick="openNewLoanModal()"
            class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg transition duration-150 text-xs font-bold shadow-md shadow-blue-500/10"
        >
            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
            <span>Tambah Pengajuan</span>
        </button>

    </div>

</div>


<!-- ========================================================= -->
<!-- METRICS -->
<!-- ========================================================= -->

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">

    <!-- TOTAL -->
    <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-4 hover:border-[#8f9bb3]/20 transition duration-300 relative overflow-hidden group">

        <div class="absolute -top-10 -right-10 w-24 h-24 bg-blue-500/5 rounded-full blur-xl group-hover:bg-blue-500/10 transition-colors"></div>

        <div class="flex items-center justify-between mb-2">

            <div class="flex items-center gap-2">

                <div
                    class="w-7 h-7 rounded-md flex items-center justify-center shrink-0"
                    style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); color: #60a5fa;"
                >
                    <i data-lucide="wallet" class="w-3.5 h-3.5"></i>
                </div>

                <p class="text-xs font-semibold text-[#8f9bb3] whitespace-nowrap">
                    Total Pinjaman
                </p>

            </div>

            <span
                class="text-[10px] font-bold px-1.5 py-0.5 rounded flex items-center gap-0.5"
                style="background-color: rgba(16, 185, 129, 0.1); color: #34d399;"
            >
                <i data-lucide="trending-up" class="w-2.5 h-2.5"></i>
                <span>+12%</span>
            </span>

        </div>

        <div class="space-y-0.5 mt-1.5">

            <h3
                class="text-xl font-extrabold text-white"
                id="metric-total"
            >
                Rp {{ number_format((int) $totalPinjaman, 0, ',', '.') }}
            </h3>

        </div>

    </div>


    <!-- AKTIF -->
    <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-4 hover:border-[#8f9bb3]/20 transition duration-300 relative overflow-hidden group">

        <div class="absolute -top-10 -right-10 w-24 h-24 bg-blue-500/5 rounded-full blur-xl group-hover:bg-blue-500/10 transition-colors"></div>

        <div class="flex items-center gap-2 mb-2">

            <div
                class="w-7 h-7 rounded-md flex items-center justify-center shrink-0"
                style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); color: #60a5fa;"
            >
                <i data-lucide="users" class="w-3.5 h-3.5"></i>
            </div>

            <p class="text-xs font-semibold text-[#8f9bb3] whitespace-nowrap">
                Pinjaman Aktif
            </p>

        </div>

        <div class="space-y-0.5 mt-1.5">

            <h3 class="text-xl font-extrabold text-white">
                {{ $pinjamanAktifCount }} Anggota
            </h3>

        </div>

    </div>


    <!-- MENUNGGAK -->
    <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-4 hover:border-[#8f9bb3]/20 transition duration-300 relative overflow-hidden group">

        <div class="absolute -top-10 -right-10 w-24 h-24 bg-rose-500/5 rounded-full blur-xl group-hover:bg-rose-500/10 transition-colors"></div>

        <div class="flex items-center gap-2 mb-2">

            <div
                class="w-7 h-7 rounded-md flex items-center justify-center shrink-0"
                style="background-color: rgba(244, 63, 94, 0.1); border: 1px solid rgba(244, 63, 94, 0.2); color: #fb7185;"
            >
                <i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i>
            </div>

            <p class="text-xs font-semibold text-[#8f9bb3] whitespace-nowrap">
                Menunggak
            </p>

        </div>

        <div class="space-y-0.5 mt-1.5">

            <h3 class="text-xl font-extrabold text-white">
                {{ $pinjamanMenunggakCount }} Anggota
            </h3>

        </div>

    </div>


    <!-- LUNAS -->
    <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-4 hover:border-[#8f9bb3]/20 transition duration-300 relative overflow-hidden group">

        <div class="absolute -top-10 -right-10 w-24 h-24 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/10 transition-colors"></div>

        <div class="flex items-center gap-2 mb-2">

            <div
                class="w-7 h-7 rounded-md flex items-center justify-center shrink-0"
                style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399;"
            >
                <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
            </div>

            <p class="text-xs font-semibold text-[#8f9bb3] whitespace-nowrap">
                Pinjaman Lunas
            </p>

        </div>

        <div class="space-y-0.5 mt-1.5">

            <h3 class="text-xl font-extrabold text-white">
                {{ $pinjamanLunasCount }} Anggota
            </h3>

        </div>

    </div>

</div>


<!-- ========================================================= -->
<!-- FILTER -->
<!-- ========================================================= -->

<div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-4 mt-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">

    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">

        <!-- SEARCH -->
        <div class="relative w-full sm:w-64">

            <i
                data-lucide="search"
                class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#8f9bb3]"
            ></i>

            <input
                type="text"
                id="searchInput"
                oninput="applyFilters()"
                placeholder="Cari nama anggota..."
                class="w-full pl-9 pr-4 py-1.5 bg-[#0d0f1d] border border-[#1f243d] rounded-lg text-xs text-white placeholder-slate-600 focus:outline-none focus:border-[#2f54eb] focus:ring-1 focus:ring-[#2f54eb] transition duration-150"
            >

        </div>


        <!-- TABS -->
        <div class="flex bg-[#0d0f1d] border border-[#1f243d] rounded-lg p-0.5 shrink-0">

            <button
                type="button"
                onclick="setFilterStatus('All')"
                id="tab-all"
                class="px-4 py-1 rounded-md text-xs font-semibold transition duration-150 bg-[#2f54eb] text-white"
            >
                Semua
            </button>

            <button
                type="button"
                onclick="setFilterStatus('Aktif')"
                id="tab-aktif"
                class="px-4 py-1 rounded-md text-xs font-semibold transition duration-150 text-[#8f9bb3] hover:text-white"
            >
                Aktif
            </button>

            <button
                type="button"
                onclick="setFilterStatus('Menunggak')"
                id="tab-menunggak"
                class="px-4 py-1 rounded-md text-xs font-semibold transition duration-150 text-[#8f9bb3] hover:text-white"
            >
                Menunggak
            </button>

            <button
                type="button"
                onclick="setFilterStatus('Lunas')"
                id="tab-lunas"
                class="px-4 py-1 rounded-md text-xs font-semibold transition duration-150 text-[#8f9bb3] hover:text-white"
            >
                Lunas
            </button>

        </div>

    </div>


    <!-- SORT -->
    <div class="flex items-center gap-3 w-full md:w-auto justify-end">

        <span class="text-xs text-[#8f9bb3] whitespace-nowrap">
            Urutan:
        </span>

        <div class="relative w-40">

            <select
                id="sortBy"
                onchange="applyFilters()"
                class="w-full px-3 py-1.5 bg-[#0d0f1d] border border-[#1f243d] rounded-lg text-xs text-white focus:outline-none focus:border-[#2f54eb] appearance-none cursor-pointer"
            >
                <option value="date-desc">Terbaru</option>
                <option value="date-asc">Terlama</option>
                <option value="amount-desc">Nominal Terbesar</option>
                <option value="amount-asc">Nominal Terkecil</option>
            </select>

            <i
                data-lucide="chevron-down"
                class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#8f9bb3] pointer-events-none"
            ></i>

        </div>

    </div>

</div>


<!-- ========================================================= -->
<!-- TABLE -->
<!-- ========================================================= -->

<div class="bg-[#16192b] border border-[#1f243d] rounded-xl overflow-hidden mt-6">

    <div class="overflow-x-auto">

        <table class="w-full text-left border-collapse">

            <thead>

                <tr class="border-b border-[#1f243d] bg-[#0d0f1d]/40">

                    <th class="px-6 py-4 text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">
                        Tanggal Pengajuan
                    </th>

                    <th class="px-6 py-4 text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">
                        Nama Anggota
                    </th>

                    <th class="px-6 py-4 text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">
                        Nominal Pinjaman
                    </th>

                    <th class="px-6 py-4 text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">
                        Tenor
                    </th>

                    <th class="px-6 py-4 text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">
                        Progress Cicilan
                    </th>

                    <th class="px-6 py-4 text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">
                        Sisa Pinjaman
                    </th>

                    <th class="px-6 py-4 text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">
                        Status
                    </th>

                    <th class="px-6 py-4 text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">
                        Approval
                    </th>

                    <th class="px-6 py-4 text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider text-center">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody
                id="loansTableBody"
                class="divide-y divide-[#1f243d]/60"
            >
            </tbody>

        </table>

    </div>


    <!-- EMPTY -->
    <div
        id="emptyState"
        class="hidden py-16 flex flex-col items-center justify-center text-center space-y-4"
    >

        <div class="w-12 h-12 rounded-full bg-slate-800/40 border border-slate-700/20 flex items-center justify-center text-slate-500">
            <i data-lucide="inbox" class="w-6 h-6"></i>
        </div>

        <div>

            <p class="text-xs font-semibold text-white">
                Tidak ada data pinjaman
            </p>

            <p class="text-[10px] text-[#8f9bb3] mt-1">
                Gunakan kata kunci lain atau tambah pengajuan baru.
            </p>

        </div>

    </div>


    <!-- PAGINATION -->
    <div class="px-6 py-4 border-t border-[#1f243d] flex flex-col sm:flex-row items-center justify-between gap-4 bg-[#0d0f1d]/20">

        <span
            class="text-[11px] text-[#8f9bb3]"
            id="paginationText"
        >
            Menampilkan 0 dari 0 data pinjaman
        </span>

        <div
            class="flex items-center gap-1.5"
            id="paginationControls"
        ></div>

    </div>

</div>


@push('modals')

<!-- ========================================================= -->
<!-- NEW LOAN MODAL -->
<!-- ========================================================= -->

<div
    id="newLoanModal"
    class="fixed inset-0 flex items-center justify-center p-4 hidden"
    style="z-index: 9999; backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); background-color: rgba(7, 8, 15, 0.75);"
>

    <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-6">

        <div class="flex justify-between items-center pb-2 border-b border-[#1f243d]">

            <h3 class="text-base font-bold text-white">
                Tambah Pengajuan Pinjaman
            </h3>

            <button
                type="button"
                onclick="closeNewLoanModal()"
                class="text-slate-400 hover:text-white transition-colors"
            >
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

        </div>


        <form
            action="{{ route('pinjaman.store') }}"
            method="POST"
            class="space-y-4"
        >

            @csrf

            <!-- ANGGOTA -->
            <div class="relative">

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">
                    NAMA ANGGOTA*
                </label>

                <div class="relative">

                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#8f9bb3] pointer-events-none">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>

                    <input
                        type="text"
                        id="memberSearchInput"
                        onfocus="showMemberDropdown()"
                        oninput="filterMembers()"
                        placeholder="Cari nama anggota..."
                        autocomplete="off"
                        class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-10 pr-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500"
                    >

                    <input
                        type="hidden"
                        name="anggota_id"
                        id="selectedMemberId"
                        required
                    >

                </div>


                <div
                    id="memberDropdownList"
                    class="absolute left-0 right-0 mt-1 max-h-48 overflow-y-auto bg-[#0d0f1d] border border-[#1f243d] rounded-lg shadow-xl z-50 hidden divide-y divide-[#1f243d]/60"
                >

                    @foreach($anggota as $item)

                        <div
                            data-member-id="{{ $item->id }}"
                            data-member-name="{{ $item->nama }}"
                            data-member-code="{{ $item->id_anggota }}"
                            onclick="selectMember({{ $item->id }}, this.dataset.memberName + ' (' + this.dataset.memberCode + ')')"
                            class="px-4 py-2.5 text-xs text-white hover:bg-blue-600 hover:text-white cursor-pointer transition-colors duration-150"
                        >
                            {{ $item->nama }} ({{ $item->id_anggota }})
                        </div>

                    @endforeach

                </div>

            </div>


            <!-- NOMINAL + TENOR -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>

                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">
                        NOMINAL PINJAMAN*
                    </label>

                    <div class="relative">

                        <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 text-[#8f9bb3] text-xs font-bold pointer-events-none">
                            Rp
                        </span>

                        <input
                            type="number"
                            id="inputNominal"
                            name="nominal_pinjaman"
                            oninput="calculateSummary()"
                            required
                            placeholder="Masukkan nominal pinjaman"
                            min="1000"
                            class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-8 pr-2 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500"
                        >

                    </div>

                </div>


                <div>

                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">
                        TENOR*
                    </label>

                    <div class="relative">

                        <input
                            type="number"
                            id="inputTenor"
                            name="tenor"
                            oninput="calculateSummary()"
                            required
                            placeholder="Masukkan tenor pinjaman"
                            min="1"
                            class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-3 pr-11 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500"
                        >

                        <span class="absolute inset-y-0 right-0 flex items-center pr-2.5 text-[#8f9bb3] text-[10px] font-semibold pointer-events-none">
                            bulan
                        </span>

                    </div>

                </div>

            </div>


            <!-- KETERANGAN -->
            <div>

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">
                    KETERANGAN (OPSIONAL)
                </label>

                <textarea
                    name="keterangan"
                    rows="3"
                    placeholder="Masukkan keterangan..."
                    class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 resize-none"
                ></textarea>

            </div>


            <!-- TANGGAL -->
            <div>

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">
                    TANGGAL PENGAJUAN*
                </label>

                <div class="relative">

                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#8f9bb3] pointer-events-none">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                    </span>

                    <input
                        type="date"
                        name="tanggal_pengajuan"
                        required
                        value="{{ date('Y-m-d') }}"
                        class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-10 pr-4 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500"
                    >

                </div>

            </div>


            <!-- SUMMARY -->
            <div class="bg-[#0d0f1d]/60 border border-[#1f243d]/80 rounded-xl p-4 space-y-2">

                <div class="flex items-center gap-2 text-xs font-bold text-white mb-1.5">

                    <i data-lucide="calculator" class="w-4 h-4 text-blue-400"></i>

                    <span>
                        Ringkasan Pinjaman
                    </span>

                </div>

                <div class="flex justify-between items-center text-[11px] text-[#8f9bb3]">

                    <span>
                        Biaya Administrasi (1%)
                    </span>

                    <span
                        id="summaryAdminFee"
                        class="font-semibold text-white"
                    >
                        Rp 0
                    </span>

                </div>

                <div class="flex justify-between items-center text-[11px] text-[#8f9bb3]">

                    <span>
                        Estimasi Cicilan per Bulan
                    </span>

                    <span
                        id="summaryMonthlyPayment"
                        class="font-semibold text-white"
                    >
                        Rp 0
                    </span>

                </div>

                <div class="flex justify-between items-center text-[11px] border-t border-[#1f243d]/60 pt-2 font-bold text-[#8f9bb3]">

                    <span>
                        Total Pengembalian
                    </span>

                    <span
                        id="summaryTotalReturn"
                        class="text-emerald-400 font-extrabold text-xs"
                    >
                        Rp 0
                    </span>

                </div>

            </div>


            <!-- BUTTON -->
            <div class="flex items-center gap-3 pt-4 justify-end">

                <button
                    type="button"
                    onclick="closeNewLoanModal()"
                    class="btn-cancel px-5 py-2.5 rounded-lg text-xs font-semibold"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="btn-save px-5 py-2.5 text-white rounded-lg text-xs font-bold shadow-lg shadow-blue-500/10"
                >
                    Ajukan Pinjaman
                </button>

            </div>

        </form>

    </div>

</div>


<!-- ========================================================= -->
<!-- IMPORT EXCEL MODAL -->
<!-- ========================================================= -->

<div
    id="importModal"
    class="fixed inset-0 flex items-center justify-center p-4 hidden"
    style="z-index: 9999; backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); background-color: rgba(7, 8, 15, 0.75);"
>

    <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-5">

        <div class="flex justify-between items-center pb-3 border-b border-[#1f243d]">

            <div>

                <h3 class="text-base font-bold text-white">
                    Import Data Pinjaman
                </h3>

                <p class="text-[10px] text-[#8f9bb3] mt-1">
                    Import data pinjaman menggunakan file Excel.
                </p>

            </div>

            <button
                type="button"
                onclick="closeImportModal()"
                class="text-slate-400 hover:text-white transition-colors"
            >
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

        </div>


        <!-- INFO -->
        <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-3">

            <div class="flex gap-2">

                <i
                    data-lucide="info"
                    class="w-4 h-4 text-blue-400 shrink-0 mt-0.5"
                ></i>

                <div class="text-[10px] text-[#8f9bb3] leading-relaxed">

                    <p class="text-blue-400 font-bold mb-1">
                        Format Excel
                    </p>

                    <p>
                        Gunakan template yang sudah disediakan agar data dapat masuk ke sistem dengan benar.
                    </p>

                </div>

            </div>

        </div>


        <!-- TEMPLATE -->
        <div class="flex items-center justify-between bg-[#0d0f1d] border border-[#1f243d] rounded-lg p-3">

            <div class="flex items-center gap-2">

                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">

                    <i
                        data-lucide="file-spreadsheet"
                        class="w-4 h-4 text-emerald-400"
                    ></i>

                </div>

                <div>

                    <p class="text-xs font-semibold text-white">
                        Template Excel
                    </p>

                    <p class="text-[9px] text-[#8f9bb3]">
                        Download template terlebih dahulu
                    </p>

                </div>

            </div>

            <a
                href="{{ route('pinjaman.template') }}"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-bold transition"
            >
                <i data-lucide="download" class="w-3 h-3"></i>
                Download
            </a>

        </div>


        <!-- UPLOAD -->
        <form
            action="{{ route('pinjaman.import') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-4"
        >

            @csrf

            <div>

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">
                    FILE EXCEL*
                </label>

                <input
                    type="file"
                    name="file"
                    required
                    accept=".xlsx,.xls"
                    class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3 py-2 text-xs text-white file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-[#2f54eb] file:text-white hover:file:bg-blue-600 cursor-pointer"
                >

                <p class="text-[9px] text-[#8f9bb3] mt-1.5">
                    Format XLSX atau XLS. Maksimal 5MB.
                </p>

            </div>


            <div class="flex items-center gap-3 pt-3 justify-end">

                <button
                    type="button"
                    onclick="closeImportModal()"
                    class="btn-cancel px-5 py-2.5 rounded-lg text-xs font-semibold"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="btn-save px-5 py-2.5 rounded-lg text-xs font-bold"
                >
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="upload" class="w-3.5 h-3.5"></i>
                        Import Data
                    </span>
                </button>

            </div>

        </form>

    </div>

</div>


<!-- ========================================================= -->
<!-- DETAIL MODAL -->
<!-- ========================================================= -->

<div
    id="detailLoanModal"
    class="fixed inset-0 flex items-center justify-center p-4 hidden"
    style="z-index: 9999; backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); background-color: rgba(7, 8, 15, 0.75);"
>

    <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-6">

        <div class="flex justify-between items-center pb-2 border-b border-[#1f243d]">

            <h3 class="text-base font-bold text-white">
                Detail Pinjaman
            </h3>

            <button
                type="button"
                onclick="closeDetailLoanModal()"
                class="text-slate-400 hover:text-white transition-colors"
            >
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

        </div>


        <div
            style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.25rem 1.5rem; text-align: left;"
        >

            <div>

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">
                    ID Kontrak
                </label>

                <span
                    class="text-sm font-bold text-white text-wrap break-all"
                    id="detailLoanId"
                >
                    -
                </span>

            </div>


            <div>

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">
                    Tanggal Pengajuan
                </label>

                <span
                    class="text-sm font-bold text-white"
                    id="detailLoanDate"
                >
                    -
                </span>

            </div>


            <div>

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">
                    ID Anggota
                </label>

                <span
                    class="text-sm font-bold text-[#8f9bb3]"
                    id="detailMemberId"
                >
                    -
                </span>

            </div>


            <div>

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">
                    Nama Anggota
                </label>

                <span
                    class="text-sm font-bold text-white"
                    id="detailMemberName"
                >
                    -
                </span>

            </div>


            <div>

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">
                    Nominal Pinjaman
                </label>

                <span
                    class="text-sm font-extrabold text-white"
                    id="detailAmount"
                >
                    -
                </span>

            </div>


            <div>

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">
                    Tenor
                </label>

                <span
                    class="text-sm font-bold text-white"
                    id="detailTenor"
                >
                    -
                </span>

            </div>


            <div>

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">
                    Progress Cicilan
                </label>

                <span
                    class="text-sm font-bold text-white"
                    id="detailProgress"
                >
                    -
                </span>

            </div>


            <div>

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">
                    Sisa Pinjaman
                </label>

                <span
                    class="text-sm font-extrabold text-[#2f54eb]"
                    id="detailRemaining"
                >
                    -
                </span>

            </div>


            <!-- STATUS -->
            <div class="col-span-2">

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">
                    Status
                </label>

                <span
                    id="detailStatus"
                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold inline-block border"
                >
                    -
                </span>

            </div>


            <!-- APPROVAL -->
            <div class="col-span-2">

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">
                    Status Approval
                </label>

                <span
                    id="detailApproval"
                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold inline-block border"
                >
                    -
                </span>

            </div>


            <!-- KETERANGAN -->
            <div class="col-span-2">

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">
                    Keterangan
                </label>

                <div
                    id="detailKeterangan"
                    class="bg-[#0d0f1d] border border-[#1f243d] rounded-lg px-3 py-2.5 text-xs text-[#8f9bb3] whitespace-pre-wrap break-words"
                >
                    -
                </div>

            </div>


            <!-- BUKTI -->
            <div class="col-span-2">

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">
                    Bukti Pembayaran
                </label>

                <div
                    id="detailProofContainer"
                    class="bg-[#0d0f1d] border border-[#1f243d] rounded-lg px-3 py-3"
                >

                    <span
                        id="detailProofText"
                        class="text-xs text-[#8f9bb3]"
                    >
                        Belum ada bukti pembayaran
                    </span>

                    <a
                        href="#"
                        id="detailProofLink"
                        target="_blank"
                        class="hidden inline-flex items-center gap-2 text-xs text-blue-400 hover:text-blue-300 font-semibold"
                    >
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                        Lihat Bukti Pembayaran
                    </a>

                </div>

            </div>

        </div>


        <div class="flex justify-end pt-2 border-t border-[#1f243d]">

            <button
                type="button"
                onclick="closeDetailLoanModal()"
                class="btn-cancel px-5 py-2.5 rounded-lg text-xs font-semibold"
            >
                Tutup
            </button>

        </div>

    </div>

</div>


<!-- ========================================================= -->
<!-- PAY INSTALLMENT MODAL -->
<!-- ========================================================= -->

<div
    id="payInstallmentModal"
    class="fixed inset-0 flex items-center justify-center p-4 hidden"
    style="z-index: 9999; backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); background-color: rgba(7, 8, 15, 0.75);"
>

    <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-5">

        <div class="flex justify-between items-center pb-2 border-b border-[#1f243d]">

            <h3 class="text-base font-bold text-white">
                Bayar Cicilan
            </h3>

            <button
                type="button"
                onclick="closePayInstallmentModal()"
                class="text-slate-400 hover:text-white transition-colors"
            >
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

        </div>


        <form
            id="payInstallmentForm"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-4"
        >

            @csrf


            <!-- INFO -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-1">

                <div>

                    <span class="block text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">
                        Nama Anggota
                    </span>

                    <span
                        id="payMemberName"
                        class="text-xs font-extrabold text-white mt-1 block"
                    >
                        -
                    </span>

                </div>


                <div>

                    <span class="block text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">
                        Nominal Pinjaman
                    </span>

                    <span
                        id="payLoanAmount"
                        class="text-xs font-bold text-blue-400 mt-1 block"
                    >
                        -
                    </span>

                </div>

            </div>


            <!-- PROGRESS -->
            <div class="space-y-1.5">

                <div class="flex justify-between items-center text-[10px] font-bold">

                    <span class="text-[#8f9bb3] uppercase tracking-wider">
                        Progress Cicilan
                    </span>

                    <span
                        id="payProgressText"
                        class="text-white"
                    >
                        -
                    </span>

                </div>


                <div class="w-full bg-[#0d0f1d] rounded-full h-2 overflow-hidden border border-[#1f243d]/60">

                    <div
                        id="payProgressBar"
                        class="bg-blue-500 h-full rounded-full transition-all duration-300"
                        style="width: 0%"
                    ></div>

                </div>

            </div>


            <!-- REMAINING -->
            <div class="flex justify-between items-center py-2.5 border-t border-b border-[#1f243d]/60">

                <span class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">
                    Sisa Pinjaman
                </span>

                <span
                    id="payRemainingAmount"
                    class="text-sm font-extrabold text-white"
                >
                    -
                </span>

            </div>


            <!-- CICILAN -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>

                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">
                        Cicilan Ke
                    </label>

                    <div class="relative">

                        <input
                            type="text"
                            id="payInstallmentNo"
                            readonly
                            class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3 py-2 text-xs text-white/70 select-none focus:outline-none pointer-events-none"
                        >

                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#8f9bb3]">
                            <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                        </span>

                    </div>

                </div>


                <div>

                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">
                        Nominal Cicilan
                    </label>

                    <div class="relative">

                        <input
                            type="text"
                            id="payInstallmentAmount"
                            readonly
                            class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3 py-2 text-xs text-white/70 select-none focus:outline-none pointer-events-none"
                        >

                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#8f9bb3]">
                            <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                        </span>

                    </div>

                </div>

            </div>


            <!-- TANGGAL -->
            <div>

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">
                    TANGGAL PEMBAYARAN*
                </label>

                <div class="relative">

                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-[#8f9bb3] pointer-events-none">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                    </span>

                    <input
                        type="date"
                        name="tanggal_pembayaran"
                        required
                        value="{{ date('Y-m-d') }}"
                        class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-9 pr-4 py-2 text-xs text-white focus:outline-none focus:border-blue-500"
                    >

                </div>

            </div>


            <!-- STATUS -->
            <div>

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">
                    STATUS*
                </label>

                <div class="relative">

                    <select
                        name="status"
                        id="payStatus"
                        required
                        class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500 appearance-none cursor-pointer"
                    >
                        <option value="Aktif">Aktif</option>
                        <option value="Menunggak">Menunggak</option>
                        <option value="Lunas">Lunas</option>
                    </select>

                    <i
                        data-lucide="chevron-down"
                        class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#8f9bb3] pointer-events-none"
                    ></i>

                </div>

            </div>


            <!-- BUKTI -->
            <div>

                <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">
                    BUKTI PEMBAYARAN*
                </label>

                <input
                    type="file"
                    name="bukti_transfer"
                    id="buktiTransfer"
                    required
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3 py-2 text-xs text-white file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-[#2f54eb] file:text-white hover:file:bg-blue-600 cursor-pointer"
                >

                <p class="text-[9px] text-[#8f9bb3] mt-1.5">
                    Format JPG, JPEG, PNG atau WEBP. Maksimal 2MB.
                </p>

            </div>


            <!-- BUTTON -->
            <div class="flex items-center gap-3 pt-3 justify-end">

                <button
                    type="button"
                    onclick="closePayInstallmentModal()"
                    class="btn-cancel px-5 py-2.5 rounded-lg text-xs font-semibold"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="btn-save px-5 py-2.5 text-white rounded-lg text-xs font-bold shadow-lg shadow-blue-500/10"
                >
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

/*
|--------------------------------------------------------------------------
| MODAL IMPORT
|--------------------------------------------------------------------------
*/

function openImportModal() {

    const modal = document.getElementById('importModal');

    if (modal) {
        modal.classList.remove('hidden');
    }
}


function closeImportModal() {

    const modal = document.getElementById('importModal');

    if (modal) {
        modal.classList.add('hidden');
    }
}


/*
|--------------------------------------------------------------------------
| DATA
|--------------------------------------------------------------------------
*/

const originalLoans = @json($loans ?? []);

let currentFilterStatus = 'All';

let currentPage = 1;

const itemsPerPage = 10;

let filteredLoans = Array.isArray(originalLoans)
    ? [...originalLoans]
    : [];


/*
|--------------------------------------------------------------------------
| HELPERS
|--------------------------------------------------------------------------
*/

function formatRupiah(value) {

    const number = Number(value) || 0;

    return 'Rp ' + new Intl.NumberFormat('id-ID', {
        minimumFractionDigits: 0
    }).format(number);
}


function parseDate(dateStr) {

    if (!dateStr) {
        return new Date(0);
    }

    return new Date(dateStr);
}


/*
|--------------------------------------------------------------------------
| FILTER STATUS
|--------------------------------------------------------------------------
*/

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

        if (!el) {
            return;
        }


        if (key === status) {

            el.classList.add(
                'bg-[#2f54eb]',
                'text-white'
            );

            el.classList.remove(
                'text-[#8f9bb3]',
                'hover:text-white'
            );

        } else {

            el.classList.remove(
                'bg-[#2f54eb]',
                'text-white'
            );

            el.classList.add(
                'text-[#8f9bb3]',
                'hover:text-white'
            );

        }

    });


    currentPage = 1;

    applyFilters();
}


/*
|--------------------------------------------------------------------------
| FILTER + SORT
|--------------------------------------------------------------------------
*/

function applyFilters() {

    const searchElement =
        document.getElementById('searchInput');

    const sortElement =
        document.getElementById('sortBy');


    const query =
        searchElement
            ? searchElement.value.trim().toLowerCase()
            : '';


    const sortBy =
        sortElement
            ? sortElement.value
            : 'date-desc';


    filteredLoans = originalLoans.filter(loan => {

        const name =
            String(loan.name ?? '').toLowerCase();

        const formattedId =
            String(loan.formattedId ?? '').toLowerCase();

        const memberId =
            String(loan.memberId ?? '').toLowerCase();

        const status =
            String(loan.status ?? 'Aktif');


        const matchesSearch =
            name.includes(query) ||
            formattedId.includes(query) ||
            memberId.includes(query);


        const matchesTab =
            currentFilterStatus === 'All' ||
            status === currentFilterStatus;


        return matchesSearch && matchesTab;

    });


    /*
    | SORT
    */

    filteredLoans.sort((a, b) => {

        if (sortBy === 'date-desc') {

            return parseDate(b.date) -
                parseDate(a.date);
        }


        if (sortBy === 'date-asc') {

            return parseDate(a.date) -
                parseDate(b.date);
        }


        if (sortBy === 'amount-desc') {

            return (Number(b.amount) || 0) -
                (Number(a.amount) || 0);
        }


        if (sortBy === 'amount-asc') {

            return (Number(a.amount) || 0) -
                (Number(b.amount) || 0);
        }


        return 0;

    });


    renderTable();
}


/*
|--------------------------------------------------------------------------
| RENDER TABLE
|--------------------------------------------------------------------------
*/

function renderTable() {

    const tbody =
        document.getElementById('loansTableBody');

    const emptyState =
        document.getElementById('emptyState');

    const paginationText =
        document.getElementById('paginationText');

    const paginationControls =
        document.getElementById('paginationControls');


    if (!tbody) {
        return;
    }


    tbody.innerHTML = '';


    const totalItems =
        filteredLoans.length;

    const hasItems =
        totalItems > 0;


    if (emptyState) {

        emptyState.classList.toggle(
            'hidden',
            hasItems
        );

    }


    if (!hasItems) {

        if (paginationText) {

            paginationText.textContent =
                'Menampilkan 0 dari 0 data pinjaman';
        }


        if (paginationControls) {

            paginationControls.innerHTML = '';
        }


        return;
    }


    /*
    | PAGINATION
    */

    const startIndex =
        (currentPage - 1) *
        itemsPerPage;


    const endIndex =
        Math.min(
            startIndex + itemsPerPage,
            totalItems
        );


    const paginatedItems =
        filteredLoans.slice(
            startIndex,
            endIndex
        );


    /*
    | ROWS
    */

    paginatedItems.forEach(loan => {

        const status =
            String(loan.status ?? 'Aktif');


        /*
        |--------------------------------------------------------------------------
        | FIX UTAMA:
        | statusPersetujuan SEKARANG DIDEFINISIKAN
        |--------------------------------------------------------------------------
        */

        const statusPersetujuan =
            String(
                loan.statusPersetujuan ?? 'Menunggu'
            );


        const name =
            String(
                loan.name ?? '-'
            );


        const memberId =
            String(
                loan.memberId ?? '-'
            );


        const formattedDate =
            String(
                loan.formattedDate ?? '-'
            );


        const amount =
            Number(loan.amount) || 0;


        const tenor =
            Number(loan.tenor) || 0;


        const paid =
            Number(loan.paid) || 0;


        const remaining =
            Number(loan.remaining) || 0;


        /*
        |--------------------------------------------------------------------------
        | STATUS COLOR
        |--------------------------------------------------------------------------
        */

        let statusClass =
            'bg-blue-500/10 text-blue-400 border-blue-500/20';


        if (status === 'Pengajuan') {

            statusClass =
                'bg-amber-500/10 text-amber-400 border-amber-500/20';

        } else if (status === 'Lunas') {

            statusClass =
                'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';

        } else if (status === 'Menunggak') {

            statusClass =
                'bg-rose-500/10 text-rose-400 border-rose-500/20';
        }


        /*
        |--------------------------------------------------------------------------
        | APPROVAL COLOR
        |--------------------------------------------------------------------------
        */

        let approvalClass =
            'bg-amber-500/10 text-amber-400 border-amber-500/20';


        if (statusPersetujuan === 'Disetujui') {

            approvalClass =
                'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';

        } else if (statusPersetujuan === 'Ditolak') {

            approvalClass =
                'bg-rose-500/10 text-rose-400 border-rose-500/20';
        }


        /*
        |--------------------------------------------------------------------------
        | DATE
        |--------------------------------------------------------------------------
        */

        let displayDate =
            formattedDate;


        displayDate =
            displayDate
                .replace('Oct', 'Okt')
                .replace('Dec', 'Des');


        /*
        |--------------------------------------------------------------------------
        | PAYMENT BUTTON
        |--------------------------------------------------------------------------
        */

        const paymentButton =
            status === 'Lunas'
                ? `
                    <button
                        type="button"
                        disabled
                        class="w-7 h-7 rounded-lg bg-slate-800/20 text-slate-600 border border-slate-700/20 flex items-center justify-center opacity-30 cursor-not-allowed"
                        title="Pinjaman sudah lunas"
                    >
                        <i data-lucide="credit-card" class="w-3.5 h-3.5"></i>
                    </button>
                `
                : `
                    <button
                        type="button"
                        onclick="openPayInstallmentModal(${loan.id})"
                        class="w-7 h-7 rounded-lg bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center hover:bg-emerald-500/30 hover:text-emerald-300 transition-all duration-150"
                        title="Bayar Cicilan"
                    >
                        <i data-lucide="credit-card" class="w-3.5 h-3.5"></i>
                    </button>
                `;


        /*
        |--------------------------------------------------------------------------
        | APPROVAL BUTTON
        |--------------------------------------------------------------------------
        */

       /*
|--------------------------------------------------------------------------
| APPROVAL BUTTON
|--------------------------------------------------------------------------
*/

let approvalButtons = '';

if (
    status === 'Pengajuan' &&
    statusPersetujuan === 'Menunggu'
) {

    const approvalUrl = @json(
        url('/pinjaman')
    ) + '/' + loan.id + '/approval';

    approvalButtons = `
        <form
            method="POST"
            action="${approvalUrl}"
            class="inline"
        >
            <input
                type="hidden"
                name="_token"
                value="{{ csrf_token() }}"
            >

            <input
                type="hidden"
                name="status_persetujuan"
                value="Disetujui"
            >

            <button
                type="submit"
                onclick="return confirm('Yakin ingin menyetujui pengajuan pinjaman ini?')"
                class="px-3 py-2 rounded-lg bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500/20 transition"
                title="Setujui"
            >
                <i
                    data-lucide="check"
                    class="w-4 h-4"
                ></i>
            </button>

        </form>

        <form
            method="POST"
            action="${approvalUrl}"
            class="inline"
        >
            <input
                type="hidden"
                name="_token"
                value="{{ csrf_token() }}"
            >

            <input
                type="hidden"
                name="status_persetujuan"
                value="Ditolak"
            >

            <button
                type="submit"
                onclick="return confirm('Yakin ingin menolak pengajuan pinjaman ini?')"
                class="px-3 py-2 rounded-lg bg-rose-500/10 text-rose-400 border border-rose-500/20 hover:bg-rose-500/20 transition"
                title="Tolak"
            >
                <i
                    data-lucide="x"
                    class="w-4 h-4"
                ></i>
            </button>

        </form>
    `;
}

        /*
        |--------------------------------------------------------------------------
        | ROW
        |--------------------------------------------------------------------------
        */

        const row =
            document.createElement('tr');


        row.className =
            'hover:bg-[#1f243d]/30 transition duration-150';


        row.innerHTML = `

            <!-- DATE -->
            <td class="px-6 py-4 text-xs text-[#8f9bb3]">
                ${displayDate}
            </td>


            <!-- MEMBER -->
            <td class="px-6 py-4">

                <div class="text-xs font-bold text-white">
                    ${name}
                </div>

                <div class="text-[10px] text-[#8f9bb3] mt-0.5">
                    ${memberId}
                </div>

            </td>


            <!-- AMOUNT -->
            <td class="px-6 py-4 text-xs font-bold text-white">
                ${formatRupiah(amount)}
            </td>


            <!-- TENOR -->
            <td class="px-6 py-4 text-xs text-[#8f9bb3]">
                ${tenor} Bln
            </td>


            <!-- PROGRESS -->
            <td class="px-6 py-4 text-xs text-[#8f9bb3]">
                ${paid}/${tenor}
            </td>


            <!-- REMAINING -->
            <td class="px-6 py-4 text-xs font-bold text-white">
                ${
                    remaining > 0
                        ? formatRupiah(remaining)
                        : 'Rp 0'
                }
            </td>


            <!-- STATUS -->
            <td class="px-6 py-4">

                <span
                    class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase border ${statusClass}"
                >
                    ${status}
                </span>

            </td>


            <!-- APPROVAL -->
            <td class="px-6 py-4">

                <span
                    class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase border ${approvalClass}"
                >
                    ${statusPersetujuan}
                </span>

            </td>


            <!-- ACTION -->
            <td class="px-6 py-4">

                <div class="flex items-center justify-center gap-2">

                    ${approvalButtons}


                    <!-- DETAIL -->
                    <button
                        type="button"
                        onclick="showDetail(${loan.id})"
                        class="w-7 h-7 rounded-lg bg-slate-800/40 text-slate-400 border border-slate-700/20 flex items-center justify-center hover:bg-slate-700/60 hover:text-white transition-all duration-150"
                        title="Lihat Detail"
                    >
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                    </button>


                    ${paymentButton}

                </div>

            </td>

        `;


        tbody.appendChild(row);

    });


    /*
    |--------------------------------------------------------------------------
    | LUCIDE
    |--------------------------------------------------------------------------
    */

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }


    /*
    |--------------------------------------------------------------------------
    | PAGINATION TEXT
    |--------------------------------------------------------------------------
    */

    if (paginationText) {

        paginationText.textContent =
            `Menampilkan ${startIndex + 1}-${endIndex} dari ${totalItems} data pinjaman`;

    }


    renderPaginationControls(totalItems);
}


/*
|--------------------------------------------------------------------------
| PAGINATION
|--------------------------------------------------------------------------
*/

function renderPaginationControls(totalItems) {

    const container =
        document.getElementById('paginationControls');


    if (!container) {
        return;
    }


    container.innerHTML = '';


    const totalPages =
        Math.ceil(
            totalItems / itemsPerPage
        );


    if (totalPages <= 1) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | PREVIOUS
    |--------------------------------------------------------------------------
    */

    const prevBtn =
        document.createElement('button');


    prevBtn.type = 'button';


    prevBtn.disabled =
        currentPage === 1;


    prevBtn.onclick = () => {

        if (currentPage > 1) {

            currentPage--;

            renderTable();
        }

    };


    prevBtn.className =
        'p-1 rounded bg-[#0d0f1d] border border-[#1f243d] text-[#8f9bb3] hover:text-white disabled:opacity-30 disabled:pointer-events-none transition duration-150';


    prevBtn.innerHTML =
        '<i data-lucide="chevron-left" class="w-3.5 h-3.5"></i>';


    container.appendChild(prevBtn);


    /*
    |--------------------------------------------------------------------------
    | PAGE NUMBERS
    |--------------------------------------------------------------------------
    */

    const range = [];


    for (
        let i = 1;
        i <= totalPages;
        i++
    ) {

        if (
            i === 1 ||
            i === totalPages ||
            (
                i >= currentPage - 1 &&
                i <= currentPage + 1
            )
        ) {

            range.push(i);

        } else if (
            range[range.length - 1] !== '...'
        ) {

            range.push('...');

        }

    }


    range.forEach(p => {

        if (p === '...') {

            const dots =
                document.createElement('span');


            dots.className =
                'px-2 text-xs text-[#8f9bb3]';


            dots.textContent =
                '...';


            container.appendChild(dots);


            return;
        }


        const btn =
            document.createElement('button');


        btn.type = 'button';


        btn.onclick = () => {

            currentPage = p;

            renderTable();

        };


        btn.className =
            `w-6 h-6 rounded text-xs font-semibold transition duration-150 ${
                currentPage === p
                    ? 'bg-[#2f54eb] text-white'
                    : 'bg-[#0d0f1d] border border-[#1f243d] text-[#8f9bb3] hover:text-white'
            }`;


        btn.textContent =
            p;


        container.appendChild(btn);

    });


    /*
    |--------------------------------------------------------------------------
    | NEXT
    |--------------------------------------------------------------------------
    */

    const nextBtn =
        document.createElement('button');


    nextBtn.type = 'button';


    nextBtn.disabled =
        currentPage === totalPages;


    nextBtn.onclick = () => {

        if (currentPage < totalPages) {

            currentPage++;

            renderTable();

        }

    };


    nextBtn.className =
        'p-1 rounded bg-[#0d0f1d] border border-[#1f243d] text-[#8f9bb3] hover:text-white disabled:opacity-30 disabled:pointer-events-none transition duration-150';


    nextBtn.innerHTML =
        '<i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>';


    container.appendChild(nextBtn);


    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

}


/*
|--------------------------------------------------------------------------
| DETAIL
|--------------------------------------------------------------------------
*/

function showDetail(id) {

    const loan =
        originalLoans.find(
            l => Number(l.id) === Number(id)
        );


    if (!loan) {

        console.error(
            'Data pinjaman tidak ditemukan:',
            id
        );

        return;
    }


    const detailLoanId =
        document.getElementById('detailLoanId');

    const detailLoanDate =
        document.getElementById('detailLoanDate');

    const detailMemberId =
        document.getElementById('detailMemberId');

    const detailMemberName =
        document.getElementById('detailMemberName');

    const detailAmount =
        document.getElementById('detailAmount');

    const detailTenor =
        document.getElementById('detailTenor');

    const detailProgress =
        document.getElementById('detailProgress');

    const detailRemaining =
        document.getElementById('detailRemaining');

    const detailStatus =
        document.getElementById('detailStatus');

    const detailApproval =
        document.getElementById('detailApproval');

    const detailKeterangan =
        document.getElementById('detailKeterangan');


    if (detailLoanId) {

        detailLoanId.textContent =
            loan.formattedId ?? '-';

    }


    if (detailLoanDate) {

        detailLoanDate.textContent =
            loan.formattedDate ?? '-';

    }


    if (detailMemberId) {

        detailMemberId.textContent =
            loan.memberId ?? '-';

    }


    if (detailMemberName) {

        detailMemberName.textContent =
            loan.name ?? '-';

    }


    if (detailAmount) {

        detailAmount.textContent =
            formatRupiah(loan.amount);

    }


    if (detailTenor) {

        detailTenor.textContent =
            `${loan.tenor ?? 0} Bulan`;

    }


    if (detailProgress) {

        detailProgress.textContent =
            `${loan.paid ?? 0} / ${loan.tenor ?? 0} Bulan`;

    }


    if (detailRemaining) {

        detailRemaining.textContent =
            Number(loan.remaining) > 0
                ? formatRupiah(loan.remaining)
                : 'Rp 0';

    }


    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    const status =
        loan.status ?? 'Aktif';


    if (detailStatus) {

        detailStatus.textContent =
            status.toUpperCase();


        detailStatus.className =
            'px-2.5 py-0.5 rounded-full text-[10px] font-bold inline-block border';


        if (status === 'Pengajuan') {

            detailStatus.classList.add(
                'bg-amber-500/10',
                'text-amber-400',
                'border-amber-500/20'
            );

        } else if (status === 'Lunas') {

            detailStatus.classList.add(
                'bg-emerald-500/10',
                'text-emerald-400',
                'border-emerald-500/20'
            );

        } else if (status === 'Menunggak') {

            detailStatus.classList.add(
                'bg-rose-500/10',
                'text-rose-400',
                'border-rose-500/20'
            );

        } else {

            detailStatus.classList.add(
                'bg-blue-500/10',
                'text-blue-400',
                'border-blue-500/20'
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | APPROVAL
    |--------------------------------------------------------------------------
    */

    const approval =
        loan.statusPersetujuan ?? 'Menunggu';


    if (detailApproval) {

        detailApproval.textContent =
            approval.toUpperCase();


        detailApproval.className =
            'px-2.5 py-0.5 rounded-full text-[10px] font-bold inline-block border';


        if (approval === 'Disetujui') {

            detailApproval.classList.add(
                'bg-emerald-500/10',
                'text-emerald-400',
                'border-emerald-500/20'
            );

        } else if (approval === 'Ditolak') {

            detailApproval.classList.add(
                'bg-rose-500/10',
                'text-rose-400',
                'border-rose-500/20'
            );

        } else {

            detailApproval.classList.add(
                'bg-amber-500/10',
                'text-amber-400',
                'border-amber-500/20'
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | KETERANGAN
    |--------------------------------------------------------------------------
    */

    if (detailKeterangan) {

        detailKeterangan.textContent =
            loan.keterangan ?? '-';

    }


    /*
    |--------------------------------------------------------------------------
    | BUKTI TRANSFER
    |--------------------------------------------------------------------------
    */

    const proofText =
        document.getElementById('detailProofText');

    const proofLink =
        document.getElementById('detailProofLink');


    const bukti =
        loan.bukti_transfer ?? null;


    if (bukti) {

        let proofUrl =
            String(bukti);


        if (
            !proofUrl.startsWith('http://') &&
            !proofUrl.startsWith('https://') &&
            !proofUrl.startsWith('/storage/')
        ) {

            proofUrl =
                '/storage/' +
                proofUrl.replace(/^\/+/, '');

        }


        if (proofText) {

            proofText.classList.add('hidden');

        }


        if (proofLink) {

            proofLink.href =
                proofUrl;

            proofLink.classList.remove(
                'hidden'
            );

        }

    } else {

        if (proofText) {

            proofText.textContent =
                'Belum ada bukti pembayaran';

            proofText.classList.remove(
                'hidden'
            );

        }


        if (proofLink) {

            proofLink.classList.add(
                'hidden'
            );

            proofLink.removeAttribute(
                'href'
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | OPEN
    |--------------------------------------------------------------------------
    */

    const modal =
        document.getElementById(
            'detailLoanModal'
        );


    if (modal) {

        modal.classList.remove(
            'hidden'
        );

    }


    if (typeof lucide !== 'undefined') {

        lucide.createIcons();

    }

}


function closeDetailLoanModal() {

    const modal =
        document.getElementById(
            'detailLoanModal'
        );


    if (modal) {

        modal.classList.add(
            'hidden'
        );

    }

}


/*
|--------------------------------------------------------------------------
| MEMBER DROPDOWN
|--------------------------------------------------------------------------
*/

function showMemberDropdown() {

    const list =
        document.getElementById(
            'memberDropdownList'
        );


    if (list) {

        list.classList.remove(
            'hidden'
        );

    }

}


function filterMembers() {

    const input =
        document.getElementById(
            'memberSearchInput'
        );

    const list =
        document.getElementById(
            'memberDropdownList'
        );


    if (!input || !list) {

        return;

    }


    const val =
        input.value.toLowerCase();


    const items =
        list.children;


    for (
        let i = 0;
        i < items.length;
        i++
    ) {

        const text =
            items[i]
                .textContent
                .toLowerCase();


        if (text.includes(val)) {

            items[i]
                .classList
                .remove('hidden');

        } else {

            items[i]
                .classList
                .add('hidden');

        }

    }


    list.classList.remove(
        'hidden'
    );

}


function selectMember(
    id,
    displayText
) {

    const selectedMember =
        document.getElementById(
            'selectedMemberId'
        );

    const input =
        document.getElementById(
            'memberSearchInput'
        );

    const list =
        document.getElementById(
            'memberDropdownList'
        );


    if (selectedMember) {

        selectedMember.value =
            id;

    }


    if (input) {

        input.value =
            displayText;

    }


    if (list) {

        list.classList.add(
            'hidden'
        );

    }

}


/*
|--------------------------------------------------------------------------
| CLOSE DROPDOWN
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'click',
    function(e) {

        const input =
            document.getElementById(
                'memberSearchInput'
            );

        const list =
            document.getElementById(
                'memberDropdownList'
            );


        if (
            input &&
            list &&
            !input.contains(e.target) &&
            !list.contains(e.target)
        ) {

            list.classList.add(
                'hidden'
            );

        }

    }
);


/*
|--------------------------------------------------------------------------
| SUMMARY
|--------------------------------------------------------------------------
*/

function calculateSummary() {

    const nominalInput =
        document.getElementById(
            'inputNominal'
        );

    const tenorInput =
        document.getElementById(
            'inputTenor'
        );


    if (!nominalInput || !tenorInput) {

        return;

    }


    const nominal =
        parseFloat(
            nominalInput.value
        ) || 0;


    const tenor =
        parseInt(
            tenorInput.value
        ) || 0;


    const adminFee =
        nominal * 0.01;


    const totalReturn =
        nominal + adminFee;


    let monthlyPayment =
        0;


    if (tenor > 0) {

        monthlyPayment =
            Math.round(
                totalReturn / tenor
            );

    }


    function formatRupiahJs(val) {

        return 'Rp ' +
            new Intl.NumberFormat(
                'id-ID',
                {
                    minimumFractionDigits: 0
                }
            ).format(val);

    }


    const summaryAdminFee =
        document.getElementById(
            'summaryAdminFee'
        );

    const summaryMonthlyPayment =
        document.getElementById(
            'summaryMonthlyPayment'
        );

    const summaryTotalReturn =
        document.getElementById(
            'summaryTotalReturn'
        );


    if (summaryAdminFee) {

        summaryAdminFee.textContent =
            formatRupiahJs(
                adminFee
            );

    }


    if (summaryMonthlyPayment) {

        summaryMonthlyPayment.textContent =
            formatRupiahJs(
                monthlyPayment
            );

    }


    if (summaryTotalReturn) {

        summaryTotalReturn.textContent =
            formatRupiahJs(
                totalReturn
            );

    }

}


/*
|--------------------------------------------------------------------------
| NEW LOAN MODAL
|--------------------------------------------------------------------------
*/

function openNewLoanModal() {

    const selectedMember =
        document.getElementById(
            'selectedMemberId'
        );

    const memberSearch =
        document.getElementById(
            'memberSearchInput'
        );

    const inputNominal =
        document.getElementById(
            'inputNominal'
        );

    const inputTenor =
        document.getElementById(
            'inputTenor'
        );


    if (selectedMember) {

        selectedMember.value =
            '';

    }


    if (memberSearch) {

        memberSearch.value =
            '';

    }


    if (inputNominal) {

        inputNominal.value =
            '';

    }


    if (inputTenor) {

        inputTenor.value =
            '';

    }


    const textarea =
        document.querySelector(
            '#newLoanModal textarea'
        );


    if (textarea) {

        textarea.value =
            '';

    }


    calculateSummary();


    const modal =
        document.getElementById(
            'newLoanModal'
        );


    if (modal) {

        modal.classList.remove(
            'hidden'
        );

    }


    if (typeof lucide !== 'undefined') {

        lucide.createIcons();

    }

}


function closeNewLoanModal() {

    const modal =
        document.getElementById(
            'newLoanModal'
        );


    if (modal) {

        modal.classList.add(
            'hidden'
        );

    }

}


/*
|--------------------------------------------------------------------------
| RESET FILTER
|--------------------------------------------------------------------------
*/

function resetFilters() {

    const searchInput =
        document.getElementById(
            'searchInput'
        );

    const sortBy =
        document.getElementById(
            'sortBy'
        );


    if (searchInput) {

        searchInput.value =
            '';

    }


    if (sortBy) {

        sortBy.value =
            'date-desc';

    }


    setFilterStatus(
        'All'
    );

}


/*
|--------------------------------------------------------------------------
| PAY INSTALLMENT
|--------------------------------------------------------------------------
*/

function openPayInstallmentModal(id) {

    const loan =
        originalLoans.find(
            l => Number(l.id) === Number(id)
        );


    if (!loan) {

        console.error(
            'Data pinjaman tidak ditemukan:',
            id
        );

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | FORM ACTION
    |--------------------------------------------------------------------------
    */

    const form =
        document.getElementById(
            'payInstallmentForm'
        );


    if (form) {

        form.action =
            `/pinjaman/${loan.id}/bayar`;

    }


    /*
    |--------------------------------------------------------------------------
    | INFO
    |--------------------------------------------------------------------------
    */

    const payMemberName =
        document.getElementById(
            'payMemberName'
        );

    const payLoanAmount =
        document.getElementById(
            'payLoanAmount'
        );

    const payProgressText =
        document.getElementById(
            'payProgressText'
        );

    const payRemainingAmount =
        document.getElementById(
            'payRemainingAmount'
        );


    if (payMemberName) {

        payMemberName.textContent =
            loan.name ?? '-';

    }


    if (payLoanAmount) {

        payLoanAmount.textContent =
            formatRupiah(
                loan.amount
            );

    }


    if (payProgressText) {

        payProgressText.textContent =
            `${loan.paid ?? 0} / ${loan.tenor ?? 0} Cicilan`;

    }


    if (payRemainingAmount) {

        payRemainingAmount.textContent =
            Number(loan.remaining) > 0
                ? formatRupiah(loan.remaining)
                : 'Rp 0';

    }


    /*
    |--------------------------------------------------------------------------
    | PROGRESS
    |--------------------------------------------------------------------------
    */

    const tenor =
        Number(loan.tenor) || 0;


    const paid =
        Number(loan.paid) || 0;


    const progressPercent =
        tenor > 0
            ? Math.min(
                (paid / tenor) * 100,
                100
            )
            : 0;


    const progressBar =
        document.getElementById(
            'payProgressBar'
        );


    if (progressBar) {

        progressBar.style.width =
            progressPercent + '%';

    }


    /*
    |--------------------------------------------------------------------------
    | CICILAN BERIKUTNYA
    |--------------------------------------------------------------------------
    */

    const nextInstallmentNo =
        paid + 1;


    const installmentNo =
        document.getElementById(
            'payInstallmentNo'
        );


    if (installmentNo) {

        installmentNo.value =
            nextInstallmentNo;

    }


    /*
    |--------------------------------------------------------------------------
    | NOMINAL CICILAN
    |--------------------------------------------------------------------------
    */

    const remaining =
        Number(loan.remaining) || 0;


    const remainingMonths =
        tenor - paid;


    let installmentAmount =
        0;


    if (remainingMonths > 0) {

        installmentAmount =
            Math.round(
                remaining /
                remainingMonths
            );

    }


    const installmentAmountInput =
        document.getElementById(
            'payInstallmentAmount'
        );


    if (installmentAmountInput) {

        installmentAmountInput.value =
            formatRupiah(
                installmentAmount
            );

    }


    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    const statusSelect =
        document.getElementById(
            'payStatus'
        );


    if (statusSelect) {

        const currentStatus =
            loan.status ?? 'Aktif';


        statusSelect.value =
            [
                'Aktif',
                'Menunggak',
                'Lunas'
            ].includes(
                currentStatus
            )
                ? currentStatus
                : 'Aktif';

    }


    /*
    |--------------------------------------------------------------------------
    | RESET FILE
    |--------------------------------------------------------------------------
    */

    const fileInput =
        document.getElementById(
            'buktiTransfer'
        );


    if (fileInput) {

        fileInput.value =
            '';

    }


    /*
    |--------------------------------------------------------------------------
    | OPEN
    |--------------------------------------------------------------------------
    */

    const modal =
        document.getElementById(
            'payInstallmentModal'
        );


    if (modal) {

        modal.classList.remove(
            'hidden'
        );

    }


    if (typeof lucide !== 'undefined') {

        lucide.createIcons();

    }

}


function closePayInstallmentModal() {

    const modal =
        document.getElementById(
            'payInstallmentModal'
        );


    if (modal) {

        modal.classList.add(
            'hidden'
        );

    }

}


/*
|--------------------------------------------------------------------------
| FILE VALIDATION
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    function() {

        const fileInput =
            document.getElementById(
                'buktiTransfer'
            );


        if (!fileInput) {

            return;

        }


        fileInput.addEventListener(
            'change',
            function() {

                const file =
                    this.files[0];


                if (!file) {

                    return;

                }


                /*
                | MAX 2MB
                */

                if (
                    file.size >
                    2 * 1024 * 1024
                ) {

                    alert(
                        'Ukuran bukti pembayaran maksimal 2MB.'
                    );


                    this.value =
                        '';


                    return;

                }


                /*
                | FORMAT
                */

                const allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];


                if (
                    !allowedTypes.includes(
                        file.type
                    )
                ) {

                    alert(
                        'Format bukti pembayaran harus JPG, JPEG, PNG atau WEBP.'
                    );


                    this.value =
                        '';

                }

            }
        );

    }
);


/*
|--------------------------------------------------------------------------
| INITIAL LOAD
|--------------------------------------------------------------------------
*/

window.addEventListener(
    'DOMContentLoaded',
    function() {

        applyFilters();


        if (typeof lucide !== 'undefined') {

            lucide.createIcons();

        }

    }
);

</script>

@endsection