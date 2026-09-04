@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Laporan Keuangan')

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

        .btn-print-pdf {
            background-color: #2f54eb !important;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            transition: all 0.2s ease-in-out !important;
            cursor: pointer;
        }

        .btn-print-pdf:hover {
            background-color: #1e3fc7 !important;
            transform: scale(1.02) !important;
        }

        .btn-print-pdf:active {
            transform: scale(0.98) !important;
        }

        .btn-print-pdf:disabled {
            opacity: 0.6 !important;
            cursor: not-allowed !important;
            transform: none !important;
        }
    </style>
@endsection

@section('content')

    <!-- PAGE HEADER -->
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 pb-6 border-b border-[#1f243d]">

        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">
                Laporan Keuangan
            </h2>

            <p class="text-xs text-[#8f9bb3] mt-0.5">
                Kelola pencatatan jurnal dan buku besar secara otomatis berdasarkan transaksi koperasi.
            </p>
        </div>

        <!-- TOMBOL AKSI -->
        <div class="flex items-center gap-2 shrink-0">

            <!-- CETAK PDF -->
            <button
                id="btn-cetak-pdf"
                onclick="cetakLaporanPDF()"
                class="btn-print-pdf px-4 py-2.5 rounded-lg text-xs font-bold flex items-center gap-2"
            >
                <i data-lucide="printer" class="w-4 h-4"></i>

                <span id="btn-cetak-pdf-label">
                    Cetak Laporan PDF
                </span>
            </button>

            <!-- KIRIM EMAIL -->
            <button
                id="btn-kirim-email"
                onclick="bukaModalKirimEmail()"
                class="btn-print-pdf px-4 py-2.5 rounded-lg text-xs font-bold flex items-center gap-2"
            >
                <i data-lucide="mail" class="w-4 h-4"></i>

                <span>
                    Kirim ke Email
                </span>
            </button>

        </div>

    </div>


    <!-- TOP 3 STATS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">

        <!-- SALDO AKHIR -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-5 relative overflow-hidden group hover:border-[#2f54eb]/20 transition duration-300">

            <div class="absolute -top-10 -right-10 w-24 h-24 bg-blue-500/5 rounded-full blur-xl group-hover:bg-blue-500/10 transition-colors"></div>

            <div class="flex items-center justify-between">

                <div
                    class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0"
                    style="background-color: rgba(47, 84, 235, 0.1); border: 1px solid rgba(47, 84, 235, 0.2); color: #2f54eb;"
                >
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                </div>

                <span class="text-[9px] font-bold text-[#8f9bb3] bg-[#07080f]/60 px-2 py-1 rounded tracking-wider uppercase">
                    KESELURUHAN
                </span>

            </div>

            <div class="mt-4">

                <p class="text-xs font-semibold text-[#8f9bb3]">
                    Saldo Akhir
                </p>

                <h3
                    id="stat-saldo-akhir"
                    class="text-2xl font-extrabold text-white mt-1 tracking-tight"
                >
                    Rp 1.450.000.000
                </h3>

            </div>

        </div>


        <!-- PEMASUKAN -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-5 relative overflow-hidden group hover:border-emerald-500/20 transition duration-300">

            <div class="absolute -top-10 -right-10 w-24 h-24 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/10 transition-colors"></div>

            <div class="flex items-center justify-between">

                <div
                    class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0"
                    style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #10b981;"
                >
                    <i data-lucide="trending-up" class="w-4 h-4"></i>
                </div>

                <span class="text-[9px] font-bold text-[#8f9bb3] bg-[#07080f]/60 px-2 py-1 rounded tracking-wider uppercase">
                    KESELURUHAN
                </span>

            </div>

            <div class="mt-4">

                <p class="text-xs font-semibold text-[#8f9bb3]">
                    Total Pemasukan
                </p>

                <h3
                    id="stat-total-pemasukan"
                    class="text-2xl font-extrabold text-white mt-1 tracking-tight"
                >
                    Rp 2.900.000.000
                </h3>

            </div>

        </div>


        <!-- PENGELUARAN -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-5 relative overflow-hidden group hover:border-rose-500/20 transition duration-300">

            <div class="absolute -top-10 -right-10 w-24 h-24 bg-rose-500/5 rounded-full blur-xl group-hover:bg-rose-500/10 transition-colors"></div>

            <div class="flex items-center justify-between">

                <div
                    class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0"
                    style="background-color: rgba(244, 63, 94, 0.1); border: 1px solid rgba(244, 63, 94, 0.2); color: #f43f5e;"
                >
                    <i data-lucide="trending-down" class="w-4 h-4"></i>
                </div>

                <span class="text-[9px] font-bold text-[#8f9bb3] bg-[#07080f]/60 px-2 py-1 rounded tracking-wider uppercase">
                    KESELURUHAN
                </span>

            </div>

            <div class="mt-4">

                <p class="text-xs font-semibold text-[#8f9bb3]">
                    Total Pengeluaran
                </p>

                <h3
                    id="stat-total-pengeluaran"
                    class="text-2xl font-extrabold text-white mt-1 tracking-tight"
                >
                    Rp 1.450.000.000
                </h3>

            </div>

        </div>

    </div>


    <!-- RINGKASAN PERIODE -->
    <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-5 mt-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">

            <div class="flex items-center gap-2 text-white">

                <i
                    data-lucide="calendar"
                    class="w-4 h-4 text-[#8f9bb3]"
                ></i>

                <span class="text-sm font-bold tracking-tight">
                    Ringkasan Periode:
                </span>

            </div>

            <div class="relative min-w-[150px]">

                <select
                    id="select-periode-ringkasan"
                    onchange="onPeriodChange(this.value)"
                    class="w-full appearance-none bg-[#07080f] border border-[#1f243d] rounded-lg px-3 py-1.5 pr-8 text-xs font-semibold text-white focus:outline-none focus:border-[#2f54eb] cursor-pointer"
                >
                    <option value="all" selected>
                        Semua Periode
                    </option>

                    <option value="okt_2024">
                        Oktober 2024 (Mock)
                    </option>
                </select>

                <i
                    data-lucide="chevron-down"
                    class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-[#8f9bb3] pointer-events-none"
                ></i>

            </div>

        </div>


        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <!-- TOTAL TRANSAKSI -->
            <div class="bg-[#07080f]/40 border border-[#1f243d] rounded-xl p-4 flex items-center gap-3">

                <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-blue-500/10 border border-blue-500/20 text-[#2f54eb] shrink-0">

                    <i
                        data-lucide="file-text"
                        class="w-4 h-4"
                    ></i>

                </div>

                <div>

                    <span class="text-[10px] text-[#8f9bb3] font-semibold uppercase tracking-wider block">
                        Total Transaksi
                    </span>

                    <span
                        id="period-total-transaksi"
                        class="text-lg font-bold text-white mt-0.5 block"
                    >
                        128
                    </span>

                </div>

            </div>


            <!-- PEMASUKAN -->
            <div class="bg-[#07080f]/40 border border-[#1f243d] rounded-xl p-4 flex items-center gap-3">

                <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 shrink-0">

                    <i
                        data-lucide="arrow-up-circle"
                        class="w-4 h-4"
                    ></i>

                </div>

                <div>

                    <span class="text-[10px] text-[#8f9bb3] font-semibold uppercase tracking-wider block">
                        Pemasukan
                    </span>

                    <span
                        id="period-pemasukan"
                        class="text-lg font-bold text-white mt-0.5 block"
                    >
                        Rp 320.000.000
                    </span>

                </div>

            </div>


            <!-- PENGELUARAN -->
            <div class="bg-[#07080f]/40 border border-[#1f243d] rounded-xl p-4 flex items-center gap-3">

                <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-rose-500/10 border border-rose-500/20 text-rose-400 shrink-0">

                    <i
                        data-lucide="arrow-down-circle"
                        class="w-4 h-4"
                    ></i>

                </div>

                <div>

                    <span class="text-[10px] text-[#8f9bb3] font-semibold uppercase tracking-wider block">
                        Pengeluaran
                    </span>

                    <span
                        id="period-pengeluaran"
                        class="text-lg font-bold text-white mt-0.5 block"
                    >
                        Rp 185.000.000
                    </span>

                </div>

            </div>


            <!-- SALDO -->
            <div class="bg-[#07080f]/40 border border-[#1f243d] rounded-xl p-4 flex items-center gap-3">

                <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-blue-500/10 border border-blue-500/20 text-[#2f54eb] shrink-0">

                    <i
                        data-lucide="credit-card"
                        class="w-4 h-4"
                    ></i>

                </div>

                <div>

                    <span class="text-[10px] text-[#8f9bb3] font-semibold uppercase tracking-wider block">
                        Saldo Periode
                    </span>

                    <span
                        id="period-saldo"
                        class="text-lg font-bold text-white mt-0.5 block"
                    >
                        Rp 135.000.000
                    </span>

                </div>

            </div>

        </div>

    </div>


    <!-- FILTER & TABLE -->
    <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-5 mt-6">

        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 mb-5">

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-grow max-w-3xl">

                <!-- SEARCH -->
                <div class="relative flex-grow max-w-md">

                    <i
                        data-lucide="search"
                        class="absolute left-3 top-1/2 -translate-y-1/2 text-[#8f9bb3] w-3.5 h-3.5"
                    ></i>

                    <input
                        type="text"
                        id="search-input"
                        oninput="onSearchChange(this.value)"
                        placeholder="Cari transaksi..."
                        class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-9 pr-3 py-2 text-xs text-white placeholder-[#8f9bb3] focus:outline-none focus:border-[#2f54eb]"
                    >

                </div>


                <!-- TYPE -->
                <div class="relative min-w-[150px]">

                    <select
                        id="filter-type"
                        onchange="onTypeFilterChange(this.value)"
                        class="w-full appearance-none bg-[#07080f] border border-[#1f243d] rounded-lg px-3 py-2 pr-8 text-xs font-semibold text-white focus:outline-none focus:border-[#2f54eb] cursor-pointer"
                    >
                        <option value="ALL">
                            Semua Transaksi
                        </option>

                        <option value="SIMPANAN">
                            Simpanan
                        </option>

                        <option value="PINJAMAN">
                            Pinjaman
                        </option>

                        <option value="KAS USAHA">
                            Kas Usaha
                        </option>
                    </select>

                    <i
                        data-lucide="chevron-down"
                        class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-[#8f9bb3] pointer-events-none"
                    ></i>

                </div>


                <!-- DATE -->
                <div class="relative min-w-[150px]">

                    <select
                        id="filter-date"
                        onchange="onDateFilterChange(this.value)"
                        class="w-full appearance-none bg-[#07080f] border border-[#1f243d] rounded-lg px-3 py-2 pr-8 text-xs font-semibold text-white focus:outline-none focus:border-[#2f54eb] cursor-pointer"
                    >
                        <option value="ALL">
                            Filter Periode
                        </option>

                        <option value="2024">
                            Tahun 2024
                        </option>

                        <option value="2023">
                            Tahun 2023
                        </option>
                    </select>

                    <i
                        data-lucide="chevron-down"
                        class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-[#8f9bb3] pointer-events-none"
                    ></i>

                </div>

            </div>


            <!-- SORT -->
            <div class="flex items-center justify-between sm:justify-end gap-3 shrink-0">

                <div class="flex items-center">

                    <span class="text-xs text-[#8f9bb3] mr-2">
                        Urutkan:
                    </span>

                    <div class="relative min-w-[120px]">

                        <select
                            id="sort-order"
                            onchange="onSortChange(this.value)"
                            class="w-full appearance-none bg-[#07080f] border border-[#1f243d] rounded-lg px-3 py-2 pr-8 text-xs font-semibold text-white focus:outline-none focus:border-[#2f54eb] cursor-pointer"
                        >
                            <option value="NEWEST">
                                Terbaru
                            </option>

                            <option value="OLDEST">
                                Terlama
                            </option>

                            <option value="HIGHEST">
                                Nominal Terbesar
                            </option>

                            <option value="LOWEST">
                                Nominal Terkecil
                            </option>
                        </select>

                        <i
                            data-lucide="chevron-down"
                            class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-[#8f9bb3] pointer-events-none"
                        ></i>

                    </div>

                </div>


                <button
                    onclick="toggleSortDirection()"
                    class="w-8 h-8 rounded-lg bg-[#07080f] border border-[#1f243d] flex items-center justify-center text-[#8f9bb3] hover:text-white hover:border-[#2f54eb] transition"
                >
                    <i
                        data-lucide="sliders-horizontal"
                        class="w-3.5 h-3.5"
                    ></i>
                </button>

            </div>

        </div>


        <!-- TABLE -->
        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse">

                <thead>

                    <tr class="border-b border-[#1f243d] text-slate-100 text-[10px] font-bold uppercase tracking-wider">

                        <th class="py-3 px-4 font-semibold">
                            Tanggal
                        </th>

                        <th class="py-3 px-4 font-semibold">
                            Jenis Transaksi
                        </th>

                        <th class="py-3 px-4 font-semibold">
                            Keterangan
                        </th>

                        <th class="py-3 px-4 font-semibold text-left">
                            Nominal
                        </th>

                        <th class="py-3 px-4 font-semibold text-center w-20">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody
                    id="transaction-table-body"
                    class="divide-y divide-[#1f243d]/60 text-xs"
                >
                </tbody>

            </table>

        </div>


        <!-- PAGINATION -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-5 pt-3 border-t border-[#1f243d]/40">

            <div
                id="table-entries-info"
                class="text-xs text-[#8f9bb3]"
            >
                Menampilkan 1-10 dari 128 transaksi
            </div>

            <div
                id="pagination-controls"
                class="flex items-center gap-1.5"
            >
            </div>

        </div>

    </div>

@endsection


@section('scripts')

    <!-- PDF LIBRARY -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>


    <script>

        // =========================================================
        // DATA
        // =========================================================

        const realDataList = {!! json_encode($realTransactions) !!};

        const realTotalSaldo =
            "{{ number_format($realSaldoAkhir, 0, ',', '.') }}";

        const realTotalIn =
            "{{ number_format($realTotalPemasukan, 0, ',', '.') }}";

        const realTotalOut =
            "{{ number_format($realTotalPengeluaran, 0, ',', '.') }}";


        const realPeriodInfo = {

            count:
                "{{ $realPeriodTransaksiCount }}",

            pemasukan:
                "Rp {{ number_format($realPeriodPemasukan, 0, ',', '.') }}",

            pengeluaran:
                "Rp {{ number_format($realPeriodPengeluaran, 0, ',', '.') }}",

            saldo:
                "Rp {{ number_format($realPeriodSaldo, 0, ',', '.') }}"
        };


        // =========================================================
        // MOCK DATA
        // =========================================================

        const mockTotalSaldo =
            "1.450.000.000";

        const mockTotalIn =
            "2.900.000.000";

        const mockTotalOut =
            "1.450.000.000";


        const mockPeriodInfo = {

            count: 128,

            pemasukan:
                "Rp 320.000.000",

            pengeluaran:
                "Rp 185.000.000",

            saldo:
                "Rp 135.000.000"
        };


        const mockDataList = [

            {
                tanggal: '24 Okt 2023, 14:20',
                raw_date: '2023-10-24',
                jenis: 'SIMPANAN',
                keterangan: 'Simpanan Pokok - Budi Santoso',
                nominal: 1000000,
                is_positive: true,
                tx_id: 'TX-10021',
                member_id: 'AGT-001',
                member_name: 'Budi Santoso',
                sub_jenis: 'Simpanan Pokok'
            },

            {
                tanggal: '24 Okt 2023, 11:05',
                raw_date: '2023-10-24',
                jenis: 'PINJAMAN',
                keterangan: 'Pencairan Pinjaman - Siti Aminah',
                nominal: 5500000,
                is_positive: false,
                loan_id: 'PJ-20054',
                member_id: 'AGT-002',
                member_name: 'Siti Aminah',
                tenor: 12,
                paid: 6,
                remaining: 2750000,
                status: 'Aktif'
            },

            {
                tanggal: '23 Okt 2023, 16:45',
                raw_date: '2023-10-23',
                jenis: 'KAS USAHA',
                keterangan: 'Pembelian ATK Kantor',
                nominal: 350000,
                is_positive: false,
                tx_id: 'TX-40011',
                member_id: 'N/A',
                member_name: 'Yayasan YPIK',
                sub_jenis: 'Kas Usaha'
            },

            {
                tanggal: '23 Okt 2023, 10:15',
                raw_date: '2023-10-23',
                jenis: 'SIMPANAN',
                keterangan: 'Simpanan Wajib - Ahmad Fauzi',
                nominal: 200000,
                is_positive: true,
                tx_id: 'TX-10022',
                member_id: 'AGT-005',
                member_name: 'Ahmad Fauzi',
                sub_jenis: 'Simpanan Wajib'
            },

            {
                tanggal: '22 Okt 2023, 15:30',
                raw_date: '2023-10-22',
                jenis: 'PINJAMAN',
                keterangan: 'Angsuran Pinjaman - Diana Putri',
                nominal: 1250000,
                is_positive: true,
                loan_id: 'PJ-20055',
                member_id: 'AGT-008',
                member_name: 'Diana Putri',
                tenor: 12,
                paid: 8,
                remaining: 5000000,
                status: 'Aktif'
            }

        ];


        const firstNames = [
            'Rudi',
            'Bambang',
            'Sri',
            'Agus',
            'Herman',
            'Mulyadi',
            'Indah',
            'Fitri',
            'Eko',
            'Slamet',
            'Susilo',
            'Dewi',
            'Indra',
            'Andi',
            'Hendra'
        ];


        const lastNames = [
            'Hidayat',
            'Saputra',
            'Susanti',
            'Pratama',
            'Ningsih',
            'Wijaya',
            'Hartono',
            'Gunawan',
            'Kurniawan',
            'Santoso',
            'Rahayu'
        ];


        const types = [
            'SIMPANAN',
            'PINJAMAN',
            'KAS USAHA'
        ];


        const simpananTypes = [
            'Pokok',
            'Wajib',
            'Sukarela'
        ];


        let seedDate =
            new Date(2023, 9, 21);


        for (
            let i = 0;
            i < 123;
            i++
        ) {

            seedDate.setHours(
                seedDate.getHours() -
                Math.floor(Math.random() * 8) -
                1
            );

            seedDate.setMinutes(
                Math.floor(Math.random() * 60)
            );


            const randType =
                types[
                    Math.floor(
                        Math.random() *
                        types.length
                    )
                ];


            const randFirstName =
                firstNames[
                    Math.floor(
                        Math.random() *
                        firstNames.length
                    )
                ];


            const randLastName =
                lastNames[
                    Math.floor(
                        Math.random() *
                        lastNames.length
                    )
                ];


            const name =
                `${randFirstName} ${randLastName}`;


            let description = '';

            let isPositive = true;

            let nominalVal = 0;


            if (
                randType === 'SIMPANAN'
            ) {

                const sType =
                    simpananTypes[
                        Math.floor(
                            Math.random() *
                            simpananTypes.length
                        )
                    ];


                description =
                    `Simpanan ${sType} - ${name}`;


                isPositive = true;


                nominalVal =
                    sType === 'Pokok'
                        ? 1000000
                        : (
                            sType === 'Wajib'
                                ? 200000
                                : Math.floor(
                                    Math.random() * 20 + 1
                                ) * 50000
                        );

            }

            else if (
                randType === 'PINJAMAN'
            ) {

                const isDisbursement =
                    Math.random() > 0.5;


                if (isDisbursement) {

                    description =
                        `Pencairan Pinjaman - ${name}`;

                    isPositive = false;

                    nominalVal =
                        Math.floor(
                            Math.random() * 6 + 2
                        ) * 1000000;

                }

                else {

                    description =
                        `Angsuran Pinjaman - ${name}`;

                    isPositive = true;

                    nominalVal =
                        Math.floor(
                            Math.random() * 10 + 2
                        ) * 150000;

                }

            }

            else {

                const officeExpenses = [

                    'Pembelian ATK Kantor',
                    'Biaya Listrik & Internet',
                    'Pembelian Air Galon Kantor',
                    'Perawatan Pendingin Ruangan',
                    'Transportasi Dinas Pegawai',
                    'Konsumsi Rapat Pengurus'

                ];


                description =
                    officeExpenses[
                        Math.floor(
                            Math.random() *
                            officeExpenses.length
                        )
                    ];


                isPositive = false;


                nominalVal =
                    Math.floor(
                        Math.random() * 10 + 1
                    ) * 75000;

            }


            const formattedDateStr =
                seedDate.toLocaleDateString(
                    'id-ID',
                    {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    }
                )
                +
                ', '
                +
                seedDate.toLocaleTimeString(
                    'id-ID',
                    {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    }
                ).replace('.', ':');


            const year =
                seedDate.getFullYear();

            const month =
                String(
                    seedDate.getMonth() + 1
                ).padStart(2, '0');

            const day =
                String(
                    seedDate.getDate()
                ).padStart(2, '0');


            const isoDate =
                `${year}-${month}-${day}`;


            const mockItem = {

                tanggal:
                    formattedDateStr,

                raw_date:
                    isoDate,

                jenis:
                    randType,

                keterangan:
                    description,

                nominal:
                    nominalVal,

                is_positive:
                    isPositive

            };


            if (
                randType === 'SIMPANAN'
            ) {

                const sType =
                    description
                        .split(' - ')[0]
                        .replace(
                            'Simpanan ',
                            ''
                        );


                mockItem.tx_id =
                    `TX-${10000 + i}`;

                mockItem.member_id =
                    `AGT-${String(
                        1 + (i % 10)
                    ).padStart(3, '0')}`;

                mockItem.member_name =
                    name;

                mockItem.sub_jenis =
                    `Simpanan ${sType}`;

            }

            else if (
                randType === 'PINJAMAN'
            ) {

                mockItem.loan_id =
                    `PJ-${20000 + i}`;

                mockItem.member_id =
                    `AGT-${String(
                        1 + (i % 10)
                    ).padStart(3, '0')}`;

                mockItem.member_name =
                    name;

                mockItem.tenor =
                    12;

                mockItem.paid =
                    Math.floor(
                        Math.random() * 12
                    );

                mockItem.remaining =
                    Math.round(
                        nominalVal *
                        (
                            (12 - mockItem.paid) /
                            12
                        )
                    );

                mockItem.status =
                    mockItem.paid === 12
                        ? 'Lunas'
                        : (
                            Math.random() > 0.85
                                ? 'Menunggak'
                                : 'Aktif'
                        );

            }

            else {

                mockItem.tx_id =
                    `TX-${40000 + i}`;

                mockItem.member_id =
                    'N/A';

                mockItem.member_name =
                    'Yayasan YPIK';

                mockItem.sub_jenis =
                    'Kas Usaha';

            }


            mockDataList.push(
                mockItem
            );

        }


        // =========================================================
        // ACTIVE STATES
        // =========================================================

        let currentViewMode =
            'live';

        let filteredDataset = [];

        let currentPage = 1;

        const itemsPerPage = 10;


        let searchQuery = '';

        let typeFilter = 'ALL';

        let dateFilter = 'ALL';

        let sortBy = 'NEWEST';


        // =========================================================
        // INITIALIZE
        // =========================================================

        document.addEventListener(
            'DOMContentLoaded',
            () => {

                renderDashboard();

                lucide.createIcons();

            }
        );


        // =========================================================
        // MODE
        // =========================================================

        function changeViewMode(mode) {

            currentViewMode =
                mode;


            const btnDemo =
                document.getElementById(
                    'btn-mode-demo'
                );

            const btnLive =
                document.getElementById(
                    'btn-mode-live'
                );


            if (
                !btnDemo ||
                !btnLive
            ) {
                return;
            }


            if (
                mode === 'demo'
            ) {

                btnDemo.classList.add(
                    'bg-[#2f54eb]',
                    'text-white'
                );

                btnDemo.classList.remove(
                    'text-[#8f9bb3]',
                    'hover:text-white'
                );

                btnLive.classList.remove(
                    'bg-[#2f54eb]',
                    'text-white'
                );

                btnLive.classList.add(
                    'text-[#8f9bb3]',
                    'hover:text-white'
                );

            }

            else {

                btnLive.classList.add(
                    'bg-[#2f54eb]',
                    'text-white'
                );

                btnLive.classList.remove(
                    'text-[#8f9bb3]',
                    'hover:text-white'
                );

                btnDemo.classList.remove(
                    'bg-[#2f54eb]',
                    'text-white'
                );

                btnDemo.classList.add(
                    'text-[#8f9bb3]',
                    'hover:text-white'
                );

            }


            currentPage = 1;

            renderDashboard();


            Swal.fire({

                icon: 'success',

                title:
                    'Mode Tampilan Diubah',

                text:
                    mode === 'demo'
                        ? 'Menampilkan data mockup sesuai dengan spesifikasi desain.'
                        : 'Menampilkan data operasional real dari database.',

                timer: 1500,

                showConfirmButton: false,

                background:
                    '#16192b',

                color:
                    '#e2e8f0',

                customClass: {

                    popup:
                        'border border-[#1f243d] rounded-2xl'

                }

            });

        }


        // =========================================================
        // PERIOD
        // =========================================================

        function onPeriodChange(period) {

            const tCount =
                document.getElementById(
                    'period-total-transaksi'
                );

            const pIn =
                document.getElementById(
                    'period-pemasukan'
                );

            const pOut =
                document.getElementById(
                    'period-pengeluaran'
                );

            const pSaldo =
                document.getElementById(
                    'period-saldo'
                );


            if (
                currentViewMode === 'demo'
            ) {

                if (
                    period === 'okt_2024'
                ) {

                    tCount.innerText =
                        mockPeriodInfo.count;

                    pIn.innerText =
                        mockPeriodInfo.pemasukan;

                    pOut.innerText =
                        mockPeriodInfo.pengeluaran;

                    pSaldo.innerText =
                        mockPeriodInfo.saldo;

                }

                else {

                    tCount.innerText =
                        '128';

                    pIn.innerText =
                        'Rp 2.900.000.000';

                    pOut.innerText =
                        'Rp 1.450.000.000';

                    pSaldo.innerText =
                        'Rp 1.450.000.000';

                }

            }

            else {

                if (
                    period === 'okt_2024'
                ) {

                    tCount.innerText =
                        realPeriodInfo.count;

                    pIn.innerText =
                        realPeriodInfo.pemasukan;

                    pOut.innerText =
                        realPeriodInfo.pengeluaran;

                    pSaldo.innerText =
                        realPeriodInfo.saldo;

                }

                else {

                    tCount.innerText =
                        realDataList.length;

                    pIn.innerText =
                        'Rp ' +
                        realTotalIn;

                    pOut.innerText =
                        'Rp ' +
                        realTotalOut;

                    pSaldo.innerText =
                        'Rp ' +
                        realTotalSaldo;

                }

            }

        }


        // =========================================================
        // SEARCH
        // =========================================================

        function onSearchChange(val) {

            searchQuery =
                val
                    .trim()
                    .toLowerCase();

            currentPage = 1;

            applyFilters();

        }


        function onTypeFilterChange(val) {

            typeFilter =
                val;

            currentPage = 1;

            applyFilters();

        }


        // =========================================================
        // PERIOD FILTER OPTIONS
        // =========================================================

        function renderPeriodFilterOptions(dataSrc) {

            const selectEl =
                document.getElementById(
                    'filter-date'
                );


            if (!selectEl) {
                return;
            }


            const years =
                new Set();


            dataSrc.forEach(
                item => {

                    if (
                        item.raw_date
                    ) {

                        const parts =
                            item.raw_date.split('-');


                        if (
                            parts[0] &&
                            parts[0].length === 4 &&
                            !isNaN(parts[0])
                        ) {

                            years.add(
                                parts[0]
                            );

                        }

                    }

                }
            );


            const sortedYears =
                Array.from(years)
                    .sort(
                        (a, b) => b - a
                    );


            let html =
                '<option value="ALL">Semua Periode</option>';


            sortedYears.forEach(
                year => {

                    html +=
                        `<option value="${year}">Tahun ${year}</option>`;

                }
            );


            selectEl.innerHTML =
                html;


            if (
                dateFilter !== 'ALL' &&
                !years.has(dateFilter)
            ) {

                dateFilter =
                    'ALL';

            }


            selectEl.value =
                dateFilter;

        }


        function onDateFilterChange(val) {

            dateFilter =
                val;

            currentPage = 1;

            applyFilters();

        }


        function onSortChange(val) {

            sortBy =
                val;

            applyFilters();

        }


        function toggleSortDirection() {

            const sortSelect =
                document.getElementById(
                    'sort-order'
                );


            if (
                sortSelect.value === 'NEWEST'
            ) {

                sortSelect.value =
                    'OLDEST';

            }

            else if (
                sortSelect.value === 'OLDEST'
            ) {

                sortSelect.value =
                    'NEWEST';

            }

            else if (
                sortSelect.value === 'HIGHEST'
            ) {

                sortSelect.value =
                    'LOWEST';

            }

            else {

                sortSelect.value =
                    'HIGHEST';

            }


            sortBy =
                sortSelect.value;

            applyFilters();

        }


        // =========================================================
        // FORMAT RUPIAH
        // =========================================================

        function formatRupiah(angka) {

            return 'Rp ' +
                new Intl.NumberFormat(
                    'id-ID'
                ).format(
                    angka || 0
                );

        }


        // =========================================================
        // DETAIL TRANSACTION
        // =========================================================

        function viewTransactionDetailsByIndex(itemIndex) {

            const item =
                filteredDataset[itemIndex];


            if (!item) {
                return;
            }


            if (
                item.jenis === 'SIMPANAN' ||
                item.jenis === 'KAS USAHA'
            ) {

                document.getElementById(
                    'detailTxId'
                ).innerText =
                    item.tx_id || '-';


                document.getElementById(
                    'detailTxDate'
                ).innerText =
                    item.tanggal || '-';


                document.getElementById(
                    'detailMemberId'
                ).innerText =
                    item.member_id || '-';


                document.getElementById(
                    'detailMemberName'
                ).innerText =
                    item.member_name || '-';


                document.getElementById(
                    'detailTxDesc'
                ).innerText =
                    item.keterangan || '-';


                const sign =
                    item.is_positive
                        ? '+'
                        : '-';


                const amtEl =
                    document.getElementById(
                        'detailTxAmount'
                    );


                amtEl.innerText =
                    `${sign} ${formatRupiah(item.nominal)}`;


                const titleEl =
                    document.getElementById(
                        'modalTxTitle'
                    );


                const labelEl =
                    document.getElementById(
                        'modalTxTypeLabel'
                    );


                const badgeContainer =
                    document.getElementById(
                        'detailTxTypeBadge'
                    );


                if (
                    item.jenis === 'SIMPANAN'
                ) {

                    titleEl.innerText =
                        'Detail Simpanan';

                    labelEl.innerText =
                        'Jenis Simpanan';

                    badgeContainer.innerHTML =
                        `<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold" style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #10b981;">${item.sub_jenis || 'Simpanan'}</span>`;

                }

                else {

                    titleEl.innerText =
                        'Detail Kas Usaha';

                    labelEl.innerText =
                        'Kategori';

                    badgeContainer.innerHTML =
                        `<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold" style="background-color: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.2); color: #c084fc;">Kas Usaha</span>`;

                }


                document
                    .getElementById(
                        'detailTransactionModal'
                    )
                    .classList
                    .remove('hidden');

            }


            else if (
                item.jenis === 'PINJAMAN'
            ) {

                document.getElementById(
                    'detailLoanId'
                ).innerText =
                    item.loan_id || '-';


                document.getElementById(
                    'detailLoanDate'
                ).innerText =
                    item.tanggal || '-';


                document.getElementById(
                    'detailLoanMemberId'
                ).innerText =
                    item.member_id || '-';


                document.getElementById(
                    'detailLoanMemberName'
                ).innerText =
                    item.member_name || '-';


                document.getElementById(
                    'detailLoanAmount'
                ).innerText =
                    formatRupiah(
                        item.nominal
                    );


                document.getElementById(
                    'detailLoanTenor'
                ).innerText =
                    (item.tenor || 12) +
                    ' Bulan';


                document.getElementById(
                    'detailLoanProgress'
                ).innerText =
                    `${item.paid || 0} / ${item.tenor || 12} Bulan`;


                document.getElementById(
                    'detailLoanRemaining'
                ).innerText =
                    item.remaining > 0
                        ? formatRupiah(
                            item.remaining
                        )
                        : 'Rp 0';


                const statusBadge =
                    document.getElementById(
                        'detailLoanStatus'
                    );


                const statusText =
                    (
                        item.status ||
                        'Aktif'
                    ).toUpperCase();


                statusBadge.innerText =
                    statusText;


                statusBadge.className =
                    'px-2.5 py-0.5 rounded-full text-[10px] font-bold inline-block border';


                if (
                    statusText === 'LUNAS'
                ) {

                    statusBadge.classList.add(
                        'bg-emerald-500/10',
                        'text-emerald-400',
                        'border-emerald-500/20'
                    );

                }

                else if (
                    statusText === 'MENUNGGAK'
                ) {

                    statusBadge.classList.add(
                        'bg-rose-500/10',
                        'text-rose-400',
                        'border-rose-500/20'
                    );

                }

                else {

                    statusBadge.classList.add(
                        'bg-blue-500/10',
                        'text-blue-400',
                        'border-blue-500/20'
                    );

                }


                document
                    .getElementById(
                        'detailLoanModal'
                    )
                    .classList
                    .remove('hidden');

            }

        }


        function closeDetailTransactionModal() {

            document
                .getElementById(
                    'detailTransactionModal'
                )
                .classList
                .add('hidden');

        }


        function closeDetailLoanModal() {

            document
                .getElementById(
                    'detailLoanModal'
                )
                .classList
                .add('hidden');

        }


        // =========================================================
        // DASHBOARD
        // =========================================================

        function renderDashboard() {

            const cardSaldo =
                document.getElementById(
                    'stat-saldo-akhir'
                );


            const cardIn =
                document.getElementById(
                    'stat-total-pemasukan'
                );


            const cardOut =
                document.getElementById(
                    'stat-total-pengeluaran'
                );


            if (
                currentViewMode === 'demo'
            ) {

                cardSaldo.innerText =
                    'Rp ' +
                    mockTotalSaldo;

                cardIn.innerText =
                    'Rp ' +
                    mockTotalIn;

                cardOut.innerText =
                    'Rp ' +
                    mockTotalOut;

            }

            else {

                cardSaldo.innerText =
                    'Rp ' +
                    realTotalSaldo;

                cardIn.innerText =
                    'Rp ' +
                    realTotalIn;

                cardOut.innerText =
                    'Rp ' +
                    realTotalOut;

            }


            const dataSrc =
                currentViewMode === 'demo'
                    ? mockDataList
                    : realDataList;


            renderPeriodFilterOptions(
                dataSrc
            );


            const currentPeriodVal =
                document.getElementById(
                    'select-periode-ringkasan'
                ).value;


            onPeriodChange(
                currentPeriodVal
            );


            applyFilters();

        }


        // =========================================================
        // FILTER
        // =========================================================

        function applyFilters() {

            const dataSrc =
                currentViewMode === 'demo'
                    ? mockDataList
                    : realDataList;


            filteredDataset =
                dataSrc.filter(
                    item => {

                        const keterangan =
                            (
                                item.keterangan ||
                                ''
                            ).toLowerCase();


                        const jenis =
                            (
                                item.jenis ||
                                ''
                            ).toLowerCase();


                        const tanggal =
                            (
                                item.tanggal ||
                                ''
                            ).toLowerCase();


                        const termMatches =
                            keterangan.includes(
                                searchQuery
                            ) ||
                            jenis.includes(
                                searchQuery
                            ) ||
                            tanggal.includes(
                                searchQuery
                            );


                        const typeMatches =
                            typeFilter === 'ALL' ||
                            item.jenis === typeFilter;


                        let dateMatches =
                            true;


                        if (
                            dateFilter !== 'ALL'
                        ) {

                            dateMatches =
                                item.raw_date &&
                                item.raw_date.startsWith(
                                    dateFilter
                                );

                        }


                        return (
                            termMatches &&
                            typeMatches &&
                            dateMatches
                        );

                    }
                );


            filteredDataset.sort(
                (a, b) => {

                    if (
                        sortBy === 'NEWEST'
                    ) {

                        return (
                            new Date(
                                b.raw_date
                            ) -
                            new Date(
                                a.raw_date
                            )
                        );

                    }

                    else if (
                        sortBy === 'OLDEST'
                    ) {

                        return (
                            new Date(
                                a.raw_date
                            ) -
                            new Date(
                                b.raw_date
                            )
                        );

                    }

                    else if (
                        sortBy === 'HIGHEST'
                    ) {

                        return (
                            b.nominal -
                            a.nominal
                        );

                    }

                    else if (
                        sortBy === 'LOWEST'
                    ) {

                        return (
                            a.nominal -
                            b.nominal
                        );

                    }


                    return 0;

                }
            );


            renderTablePage();

        }


        // =========================================================
        // TABLE
        // =========================================================

        function renderTablePage() {

            const tbody =
                document.getElementById(
                    'transaction-table-body'
                );


            tbody.innerHTML =
                '';


            const totalItems =
                filteredDataset.length;


            const totalPages =
                Math.ceil(
                    totalItems /
                    itemsPerPage
                ) || 1;


            if (
                currentPage >
                totalPages
            ) {

                currentPage =
                    totalPages;

            }


            const startIndex =
                (
                    currentPage - 1
                ) *
                itemsPerPage;


            const endIndex =
                Math.min(
                    startIndex +
                    itemsPerPage,
                    totalItems
                );


            const pageData =
                filteredDataset.slice(
                    startIndex,
                    endIndex
                );


            if (
                pageData.length === 0
            ) {

                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="py-8 text-center text-xs text-[#8f9bb3]">
                            Tidak ada transaksi yang cocok dengan filter.
                        </td>
                    </tr>
                `;

            }

            else {

                pageData.forEach(
                    (item, index) => {

                        let badgeClass = '';


                        if (
                            item.jenis ===
                            'SIMPANAN'
                        ) {

                            badgeClass =
                                'text-emerald-400 bg-emerald-500/10 border border-emerald-500/20';

                        }

                        else if (
                            item.jenis ===
                            'PINJAMAN'
                        ) {

                            badgeClass =
                                'text-blue-400 bg-blue-500/10 border border-blue-500/20';

                        }

                        else {

                            badgeClass =
                                'text-purple-400 bg-purple-500/10 border border-purple-500/20';

                        }


                        const sign =
                            item.is_positive
                                ? '+'
                                : '-';


                        const formattedNominal =
                            `${sign} Rp ${new Intl.NumberFormat('id-ID').format(item.nominal)}`;


                        const tr =
                            document.createElement(
                                'tr'
                            );


                        tr.className =
                            'hover:bg-[#07080f]/30 transition duration-150 border-b border-[#1f243d]/60';


                        tr.innerHTML = `

                            <td class="py-3.5 px-4 text-xs text-slate-400 font-medium whitespace-nowrap">
                                ${item.tanggal}
                            </td>

                            <td class="py-3.5 px-4">

                                <span class="inline-flex items-center px-2 py-0.5 text-[9px] font-bold rounded-md ${badgeClass}">
                                    ${item.jenis}
                                </span>

                            </td>

                            <td class="py-3.5 px-4 text-xs text-slate-200 font-semibold">
                                ${item.keterangan}
                            </td>

                            <td class="py-3.5 px-4 text-xs text-left whitespace-nowrap text-white font-bold">
                                ${formattedNominal}
                            </td>

                            <td class="py-3.5 px-4 text-center">

                                <button
                                    onclick="viewTransactionDetailsByIndex(${startIndex + index})"
                                    class="text-[#8f9bb3] hover:text-white p-1 rounded hover:bg-[#1f243d] transition"
                                >

                                    <i
                                        data-lucide="eye"
                                        class="w-3.5 h-3.5"
                                    ></i>

                                </button>

                            </td>

                        `;


                        tbody.appendChild(
                            tr
                        );

                    }
                );

            }


            lucide.createIcons();


            const entriesInfo =
                document.getElementById(
                    'table-entries-info'
                );


            if (
                totalItems === 0
            ) {

                entriesInfo.innerText =
                    'Menampilkan 0-0 dari 0 transaksi';

            }

            else {

                entriesInfo.innerText =
                    `Menampilkan ${startIndex + 1}-${endIndex} dari ${totalItems} transaksi`;

            }


            renderPaginationControls(
                totalPages
            );

        }


        // =========================================================
        // PAGINATION
        // =========================================================

        function renderPaginationControls(
            totalPages
        ) {

            const wrapper =
                document.getElementById(
                    'pagination-controls'
                );


            wrapper.innerHTML =
                '';


            const prevBtn =
                document.createElement(
                    'button'
                );


            prevBtn.className =
                `w-7 h-7 rounded flex items-center justify-center bg-[#07080f] border border-[#1f243d] text-xs font-semibold text-[#8f9bb3] hover:text-white hover:border-[#2f54eb] transition ${
                    currentPage === 1
                        ? 'opacity-50 pointer-events-none'
                        : ''
                }`;


            prevBtn.onclick =
                () =>
                    changePage(
                        currentPage - 1
                    );


            prevBtn.innerHTML =
                `<i data-lucide="chevron-left" class="w-3.5 h-3.5"></i>`;


            wrapper.appendChild(
                prevBtn
            );


            const maxVisiblePages =
                5;


            let startPage =
                1;


            let endPage =
                totalPages;


            if (
                totalPages >
                maxVisiblePages
            ) {

                const half =
                    Math.floor(
                        maxVisiblePages / 2
                    );


                if (
                    currentPage <= half
                ) {

                    endPage =
                        maxVisiblePages;

                }

                else if (
                    currentPage + half >=
                    totalPages
                ) {

                    startPage =
                        totalPages -
                        maxVisiblePages +
                        1;

                }

                else {

                    startPage =
                        currentPage -
                        half;

                    endPage =
                        currentPage +
                        half;

                }

            }


            if (
                startPage > 1
            ) {

                const btn =
                    createPageButton(
                        1
                    );


                wrapper.appendChild(
                    btn
                );


                if (
                    startPage > 2
                ) {

                    const span =
                        document.createElement(
                            'span'
                        );


                    span.className =
                        'text-xs text-[#8f9bb3] px-1';


                    span.innerText =
                        '...';


                    wrapper.appendChild(
                        span
                    );

                }

            }


            for (
                let p = startPage;
                p <= endPage;
                p++
            ) {

                const btn =
                    createPageButton(
                        p
                    );


                wrapper.appendChild(
                    btn
                );

            }


            if (
                endPage <
                totalPages
            ) {

                if (
                    endPage <
                    totalPages - 1
                ) {

                    const span =
                        document.createElement(
                            'span'
                        );


                    span.className =
                        'text-xs text-[#8f9bb3] px-1';


                    span.innerText =
                        '...';


                    wrapper.appendChild(
                        span
                    );

                }


                const btn =
                    createPageButton(
                        totalPages
                    );


                wrapper.appendChild(
                    btn
                );

            }


            const nextBtn =
                document.createElement(
                    'button'
                );


            nextBtn.className =
                `w-7 h-7 rounded flex items-center justify-center bg-[#07080f] border border-[#1f243d] text-xs font-semibold text-[#8f9bb3] hover:text-white hover:border-[#2f54eb] transition ${
                    currentPage === totalPages
                        ? 'opacity-50 pointer-events-none'
                        : ''
                }`;


            nextBtn.onclick =
                () =>
                    changePage(
                        currentPage + 1
                    );


            nextBtn.innerHTML =
                `<i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>`;


            wrapper.appendChild(
                nextBtn
            );


            lucide.createIcons();

        }


        function createPageButton(
            pageNumber
        ) {

            const btn =
                document.createElement(
                    'button'
                );


            if (
                pageNumber ===
                currentPage
            ) {

                btn.className =
                    'w-7 h-7 rounded flex items-center justify-center bg-[#2f54eb] text-white text-xs font-bold shadow-md shadow-blue-500/10';

            }

            else {

                btn.className =
                    'w-7 h-7 rounded flex items-center justify-center bg-[#07080f] border border-[#1f243d] text-xs font-semibold text-[#8f9bb3] hover:text-white hover:border-[#2f54eb] transition';


                btn.onclick =
                    () =>
                        changePage(
                            pageNumber
                        );

            }


            btn.innerText =
                pageNumber;


            return btn;

        }


        function changePage(
            pageNumber
        ) {

            currentPage =
                pageNumber;


            renderTablePage();


            document
                .getElementById(
                    'search-input'
                )
                .scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });

        }


        // =========================================================
        // =========================================================
        // PDF GENERATOR
        // =========================================================
        // =========================================================

        function generateLaporanPDF() {

            if (
                typeof window.jspdf === 'undefined' ||
                typeof window.jspdf.jsPDF === 'undefined'
            ) {

                throw new Error(
                    'LIBRARY_PDF_NOT_READY'
                );

            }


            if (
                !filteredDataset ||
                filteredDataset.length === 0
            ) {

                throw new Error(
                    'NO_DATA'
                );

            }


            const {
                jsPDF
            } = window.jspdf;


            const doc =
                new jsPDF({

                    orientation:
                        'portrait',

                    unit:
                        'pt',

                    format:
                        'a4'

                });


            const pageWidth =
                doc.internal.pageSize
                    .getWidth();


            const marginX =
                40;


            let cursorY =
                50;


            // =====================================================
            // HEADER
            // =====================================================

            doc.setFont(
                'helvetica',
                'bold'
            );

            doc.setFontSize(
                14
            );

            doc.setTextColor(
                20,
                20,
                20
            );


            doc.text(
                'SOY YPIK PAM JAYA',
                marginX,
                cursorY
            );


            doc.setFontSize(
                11
            );

            doc.setFont(
                'helvetica',
                'normal'
            );


            cursorY += 16;


            doc.text(
                'Laporan Keuangan Transaksi Koperasi',
                marginX,
                cursorY
            );


            const now =
                new Date();


            const cetakInfo =
                'Dicetak: ' +
                now.toLocaleDateString(
                    'id-ID',
                    {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    }
                ) +
                ', ' +
                now.toLocaleTimeString(
                    'id-ID',
                    {
                        hour: '2-digit',
                        minute: '2-digit'
                    }
                );


            doc.setFontSize(
                8
            );


            doc.setTextColor(
                100,
                100,
                100
            );


            doc.text(
                cetakInfo,
                pageWidth - marginX,
                50,
                {
                    align: 'right'
                }
            );


            doc.text(
                'Mode Data: ' +
                (
                    currentViewMode === 'demo'
                        ? 'Demo / Mock'
                        : 'Live / Real'
                ),
                pageWidth - marginX,
                62,
                {
                    align: 'right'
                }
            );


            cursorY += 10;


            doc.setDrawColor(
                220,
                220,
                220
            );


            doc.line(
                marginX,
                cursorY,
                pageWidth - marginX,
                cursorY
            );


            cursorY += 20;


            // =====================================================
            // RINGKASAN UMUM
            // =====================================================

            const saldoAkhirText =
                document.getElementById(
                    'stat-saldo-akhir'
                ).innerText;


            const totalInText =
                document.getElementById(
                    'stat-total-pemasukan'
                ).innerText;


            const totalOutText =
                document.getElementById(
                    'stat-total-pengeluaran'
                ).innerText;


            doc.setFontSize(
                10
            );


            doc.setFont(
                'helvetica',
                'bold'
            );


            doc.setTextColor(
                20,
                20,
                20
            );


            doc.text(
                'Ringkasan Keseluruhan',
                marginX,
                cursorY
            );


            cursorY += 14;


            const ringkasanUmum = [

                [
                    'Saldo Akhir',
                    saldoAkhirText
                ],

                [
                    'Total Pemasukan',
                    totalInText
                ],

                [
                    'Total Pengeluaran',
                    totalOutText
                ]

            ];


            doc.autoTable({

                startY:
                    cursorY,

                theme:
                    'grid',

                margin: {
                    left:
                        marginX,

                    right:
                        marginX
                },

                styles: {

                    font:
                        'helvetica',

                    fontSize:
                        9,

                    cellPadding:
                        6,

                    textColor: [
                        30,
                        30,
                        30
                    ]

                },

                headStyles: {

                    fillColor: [
                        47,
                        84,
                        235
                    ],

                    textColor:
                        255,

                    fontStyle:
                        'bold'

                },

                head: [

                    [
                        'Ringkasan',
                        'Nilai'
                    ]

                ],

                body:
                    ringkasanUmum,

                columnStyles: {

                    1: {

                        halign:
                            'right',

                        fontStyle:
                            'bold'

                    }

                }

            });


            cursorY =
                doc.lastAutoTable.finalY +
                20;


            // =====================================================
            // RINGKASAN PERIODE
            // =====================================================

            const periodeSelectEl =
                document.getElementById(
                    'select-periode-ringkasan'
                );


            const periodeLabel =
                periodeSelectEl
                    .options[
                        periodeSelectEl
                            .selectedIndex
                    ]
                    .text;


            doc.setFontSize(
                10
            );


            doc.setFont(
                'helvetica',
                'bold'
            );


            doc.text(
                'Ringkasan Periode: ' +
                periodeLabel,
                marginX,
                cursorY
            );


            cursorY += 14;


            const ringkasanPeriode = [[

                document.getElementById(
                    'period-total-transaksi'
                ).innerText,

                document.getElementById(
                    'period-pemasukan'
                ).innerText,

                document.getElementById(
                    'period-pengeluaran'
                ).innerText,

                document.getElementById(
                    'period-saldo'
                ).innerText

            ]];


            doc.autoTable({

                startY:
                    cursorY,

                theme:
                    'grid',

                margin: {
                    left:
                        marginX,

                    right:
                        marginX
                },

                styles: {

                    font:
                        'helvetica',

                    fontSize:
                        9,

                    cellPadding:
                        6,

                    textColor: [
                        30,
                        30,
                        30
                    ],

                    halign:
                        'center'

                },

                headStyles: {

                    fillColor: [
                        51,
                        65,
                        85
                    ],

                    textColor:
                        255,

                    fontStyle:
                        'bold',

                    halign:
                        'center'

                },

                head: [[

                    'Total Transaksi',
                    'Pemasukan',
                    'Pengeluaran',
                    'Saldo Periode'

                ]],

                body:
                    ringkasanPeriode

            });


            cursorY =
                doc.lastAutoTable.finalY +
                20;


            // =====================================================
            // FILTER
            // =====================================================

            const filterTypeLabel =
                document.getElementById(
                    'filter-type'
                )
                .selectedOptions[0]
                .text;


            const filterDateLabel =
                document.getElementById(
                    'filter-date'
                )
                .selectedOptions[0]
                .text;


            const sortLabel =
                document.getElementById(
                    'sort-order'
                )
                .selectedOptions[0]
                .text;


            doc.setFontSize(
                8.5
            );


            doc.setFont(
                'helvetica',
                'italic'
            );


            doc.setTextColor(
                90,
                90,
                90
            );


            let filterInfoLine =
                `Filter aktif → Jenis: ${filterTypeLabel} | Periode: ${filterDateLabel} | Urutan: ${sortLabel}`;


            if (
                searchQuery
            ) {

                filterInfoLine +=
                    ` | Pencarian: "${searchQuery}"`;

            }


            doc.text(
                filterInfoLine,
                marginX,
                cursorY
            );


            cursorY += 16;


            // =====================================================
            // TRANSACTION TABLE
            // =====================================================

            const tableHead = [[

                'No',
                'Tanggal',
                'Jenis Transaksi',
                'Keterangan',
                'Nominal'

            ]];


            const tableBody =
                filteredDataset.map(
                    (
                        item,
                        idx
                    ) => {

                        const sign =
                            item.is_positive
                                ? '+'
                                : '-';


                        const nominalFormatted =
                            `${sign} Rp ${new Intl.NumberFormat('id-ID').format(item.nominal)}`;


                        return [

                            String(
                                idx + 1
                            ),

                            item.tanggal ||
                                '-',

                            item.jenis ||
                                '-',

                            item.keterangan ||
                                '-',

                            nominalFormatted

                        ];

                    }
                );


            doc.autoTable({

                startY:
                    cursorY,

                margin: {

                    left:
                        marginX,

                    right:
                        marginX,

                    bottom:
                        50

                },

                theme:
                    'striped',

                styles: {

                    font:
                        'helvetica',

                    fontSize:
                        8,

                    cellPadding:
                        5,

                    textColor: [
                        30,
                        30,
                        30
                    ],

                    overflow:
                        'linebreak'

                },

                headStyles: {

                    fillColor: [
                        7,
                        8,
                        15
                    ],

                    textColor:
                        255,

                    fontStyle:
                        'bold',

                    fontSize:
                        8.5

                },

                alternateRowStyles: {

                    fillColor: [
                        245,
                        246,
                        250
                    ]

                },

                columnStyles: {

                    0: {

                        cellWidth:
                            26,

                        halign:
                            'center'

                    },

                    1: {

                        cellWidth:
                            85

                    },

                    2: {

                        cellWidth:
                            75

                    },

                    3: {

                        cellWidth:
                            'auto'

                    },

                    4: {

                        cellWidth:
                            95,

                        halign:
                            'right',

                        fontStyle:
                            'bold'

                    }

                },

                head:
                    tableHead,

                body:
                    tableBody,


                didParseCell:
                    function(data) {

                        if (

                            data.section ===
                                'body' &&

                            data.column.index ===
                                4

                        ) {

                            const rawItem =
                                filteredDataset[
                                    data.row.index
                                ];


                            if (
                                rawItem
                            ) {

                                data.cell
                                    .styles
                                    .textColor =

                                    rawItem.is_positive

                                        ? [
                                            16,
                                            150,
                                            100
                                        ]

                                        : [
                                            220,
                                            50,
                                            70
                                        ];

                            }

                        }

                    },


                didDrawPage:
                    function() {

                        const pageCount =
                            doc.internal
                                .getNumberOfPages();


                        doc.setFontSize(
                            8
                        );


                        doc.setTextColor(
                            130,
                            130,
                            130
                        );


                        doc.text(

                            `Halaman ${doc.internal.getCurrentPageInfo().pageNumber} dari ${pageCount}`,

                            pageWidth -
                                marginX,

                            doc.internal
                                .pageSize
                                .getHeight() -
                                20,

                            {
                                align:
                                    'right'
                            }

                        );


                        doc.text(

                            'SOY YPIK PAM JAYA - Laporan Keuangan',

                            marginX,

                            doc.internal
                                .pageSize
                                .getHeight() -
                                20

                        );

                    }

            });


            // =====================================================
            // TOTAL
            // =====================================================

            let finalY =
                doc.lastAutoTable.finalY +
                16;


            const pageHeight =
                doc.internal
                    .pageSize
                    .getHeight();


            if (
                finalY >
                pageHeight - 60
            ) {

                doc.addPage();

                finalY =
                    50;

            }


            doc.setFontSize(
                9
            );


            doc.setFont(
                'helvetica',
                'bold'
            );


            doc.setTextColor(
                20,
                20,
                20
            );


            doc.text(

                `Total Data Ditampilkan: ${filteredDataset.length} transaksi`,

                marginX,

                finalY

            );


            // =====================================================
            // FILE NAME
            // =====================================================

            const fileDate =
                now.toISOString()
                    .slice(
                        0,
                        10
                    );


            const fileName =
                `Laporan-Keuangan-YPIK-PAM-JAYA-${fileDate}.pdf`;


            return {

                doc:
                    doc,

                fileName:
                    fileName,

                periodeLabel:
                    periodeLabel

            };

        }


        // =========================================================
        // CETAK / DOWNLOAD PDF
        // =========================================================

        function cetakLaporanPDF() {

            const btn =
                document.getElementById(
                    'btn-cetak-pdf'
                );


            const btnLabel =
                document.getElementById(
                    'btn-cetak-pdf-label'
                );


            btn.disabled =
                true;


            const originalLabel =
                btnLabel.innerText;


            btnLabel.innerText =
                'Menyiapkan PDF...';


            try {

                const pdfData =
                    generateLaporanPDF();


                pdfData.doc.save(
                    pdfData.fileName
                );


                Swal.fire({

                    icon:
                        'success',

                    title:
                        'PDF Berhasil Dibuat',

                    text:
                        `Laporan (${filteredDataset.length} transaksi) berhasil diunduh.`,

                    timer:
                        1800,

                    showConfirmButton:
                        false,

                    background:
                        '#16192b',

                    color:
                        '#e2e8f0',

                    customClass: {

                        popup:
                            'border border-[#1f243d] rounded-2xl'

                    }

                });

            }

            catch (err) {

                console.error(
                    'Gagal membuat PDF:',
                    err
                );


                let title =
                    'Gagal Membuat PDF';


                let text =
                    'Terjadi kesalahan saat membuat laporan PDF. Coba lagi.';


                if (
                    err.message ===
                    'LIBRARY_PDF_NOT_READY'
                ) {

                    title =
                        'Gagal Memuat Library PDF';


                    text =
                        'Library jsPDF belum siap. Silakan cek koneksi internet lalu muat ulang halaman.';

                }


                else if (
                    err.message ===
                    'NO_DATA'
                ) {

                    title =
                        'Tidak Ada Data';


                    text =
                        'Tidak ada transaksi pada filter saat ini untuk dicetak.';

                }


                Swal.fire({

                    icon:
                        err.message ===
                        'NO_DATA'
                            ? 'warning'
                            : 'error',

                    title:
                        title,

                    text:
                        text,

                    background:
                        '#16192b',

                    color:
                        '#e2e8f0',

                    customClass: {

                        popup:
                            'border border-[#1f243d] rounded-2xl'

                    }

                });

            }

            finally {

                btn.disabled =
                    false;

                btnLabel.innerText =
                    originalLabel;

            }

        }


        // =========================================================
        // =========================================================
        // MODAL KIRIM EMAIL
        // =========================================================
        // =========================================================

        function bukaModalKirimEmail() {

            if (
                !filteredDataset ||
                filteredDataset.length === 0
            ) {

                Swal.fire({

                    icon:
                        'warning',

                    title:
                        'Tidak Ada Data',

                    text:
                        'Tidak ada transaksi pada filter saat ini untuk dikirim.',

                    background:
                        '#16192b',

                    color:
                        '#e2e8f0',

                    customClass: {

                        popup:
                            'border border-[#1f243d] rounded-2xl'

                    }

                });

                return;

            }


            const modal =
                document.getElementById(
                    'emailReportModal'
                );


            if (!modal) {

                console.error(
                    'Modal email tidak ditemukan.'
                );

                return;

            }


            modal.classList.remove(
                'hidden'
            );


            setTimeout(
                () => {

                    const input =
                        document.getElementById(
                            'email-laporan'
                        );


                    if (input) {

                        input.focus();

                    }


                    lucide.createIcons();

                },
                100
            );

        }


        function tutupModalKirimEmail() {

            const modal =
                document.getElementById(
                    'emailReportModal'
                );


            if (modal) {

                modal.classList.add(
                    'hidden'
                );

            }

        }


        // =========================================================
        // KIRIM EMAIL
        // =========================================================

        async function kirimLaporanKeEmail() {

            const emailInput =
                document.getElementById(
                    'email-laporan'
                );


            const btn =
                document.getElementById(
                    'btn-submit-email'
                );


            const btnLabel =
                document.getElementById(
                    'btn-submit-email-label'
                );


            if (
                !emailInput ||
                !btn ||
                !btnLabel
            ) {

                return;

            }


            const email =
                emailInput.value.trim();


            // VALIDASI KOSONG
            if (!email) {

                Swal.fire({

                    icon:
                        'warning',

                    title:
                        'Email Belum Diisi',

                    text:
                        'Silakan masukkan email tujuan.',

                    background:
                        '#16192b',

                    color:
                        '#e2e8f0',

                    customClass: {

                        popup:
                            'border border-[#1f243d] rounded-2xl'

                    }

                });


                emailInput.focus();


                return;

            }


            // VALIDASI FORMAT
            const emailPattern =
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


            if (
                !emailPattern.test(
                    email
                )
            ) {

                Swal.fire({

                    icon:
                        'warning',

                    title:
                        'Email Tidak Valid',

                    text:
                        'Silakan masukkan alamat email yang valid.',

                    background:
                        '#16192b',

                    color:
                        '#e2e8f0',

                    customClass: {

                        popup:
                            'border border-[#1f243d] rounded-2xl'

                    }

                });


                emailInput.focus();


                return;

            }


            if (
                !filteredDataset ||
                filteredDataset.length === 0
            ) {

                Swal.fire({

                    icon:
                        'warning',

                    title:
                        'Tidak Ada Data',

                    text:
                        'Tidak ada transaksi untuk dikirim.',

                    background:
                        '#16192b',

                    color:
                        '#e2e8f0',

                    customClass: {

                        popup:
                            'border border-[#1f243d] rounded-2xl'

                    }

                });


                return;

            }


            // DISABLE BUTTON
            btn.disabled =
                true;


            const originalLabel =
                btnLabel.innerText;


            btnLabel.innerText =
                'Menyiapkan PDF...';


            try {

                // BUAT PDF YANG SAMA DENGAN CETAK PDF
                const pdfData =
                    generateLaporanPDF();


                // UBAH PDF MENJADI BLOB
                const pdfBlob =
                    pdfData.doc.output(
                        'blob'
                    );


                btnLabel.innerText =
                    'Mengirim Email...';


                // FORM DATA
                const formData =
                    new FormData();


                formData.append(
                    '_token',
                    '{{ csrf_token() }}'
                );


                formData.append(
                    'email',
                    email
                );


                formData.append(
                    'periode',
                    pdfData.periodeLabel
                );


                formData.append(
                    'filename',
                    pdfData.fileName
                );


                formData.append(
                    'pdf',
                    pdfBlob,
                    pdfData.fileName
                );


                // REQUEST KE LARAVEL
                const response =
                    await fetch(

                        '{{ route("laporan-keuangan.kirim-email") }}',

                        {

                            method:
                                'POST',

                            body:
                                formData,

                            headers: {

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    '{{ csrf_token() }}'

                            }

                        }

                    );


                const result =
                    await response.json();


                if (
                    !response.ok
                ) {

                    let message =
                        result.message ||
                        'Gagal mengirim laporan.';


                    if (
                        result.errors
                    ) {

                        message =
                            Object
                                .values(
                                    result.errors
                                )
                                .flat()
                                .join(
                                    '\n'
                                );

                    }


                    throw new Error(
                        message
                    );

                }


                // TUTUP MODAL
                tutupModalKirimEmail();


                emailInput.value =
                    '';


                // SUCCESS
                Swal.fire({

                    icon:
                        'success',

                    title:
                        'Laporan Berhasil Dikirim',

                    text:
                        `Laporan telah dikirim ke ${email}.`,

                    timer:
                        2500,

                    showConfirmButton:
                        false,

                    background:
                        '#16192b',

                    color:
                        '#e2e8f0',

                    customClass: {

                        popup:
                            'border border-[#1f243d] rounded-2xl'

                    }

                });


            }

            catch (error) {

                console.error(
                    'Gagal mengirim laporan:',
                    error
                );


                Swal.fire({

                    icon:
                        'error',

                    title:
                        'Gagal Mengirim Laporan',

                    text:
                        error.message ||
                        'Terjadi kesalahan saat mengirim laporan.',

                    background:
                        '#16192b',

                    color:
                        '#e2e8f0',

                    customClass: {

                        popup:
                            'border border-[#1f243d] rounded-2xl'

                    }

                });

            }

            finally {

                btn.disabled =
                    false;


                btnLabel.innerText =
                    originalLabel;

            }

        }


        // =========================================================
        // ENTER DI INPUT EMAIL
        // =========================================================

        document.addEventListener(
            'keydown',
            function(event) {

                const modal =
                    document.getElementById(
                        'emailReportModal'
                    );


                if (
                    !modal ||
                    modal.classList.contains(
                        'hidden'
                    )
                ) {

                    return;

                }


                if (
                    event.key ===
                    'Enter'
                ) {

                    event.preventDefault();

                    kirimLaporanKeEmail();

                }


                if (
                    event.key ===
                    'Escape'
                ) {

                    tutupModalKirimEmail();

                }

            }
        );

    </script>

@endsection


@push('modals')

    <!-- ========================================================= -->
    <!-- DETAIL TRANSACTION MODAL                                  -->
    <!-- ========================================================= -->

    <div
        id="detailTransactionModal"
        class="fixed inset-0 flex items-center justify-center p-4 hidden transition-opacity"
        style="z-index: 9999; backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); background-color: rgba(7, 8, 15, 0.75);"
    >

        <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-6">

            <div class="flex justify-between items-center pb-2 border-b border-[#1f243d]">

                <h3
                    id="modalTxTitle"
                    class="text-base font-bold text-white"
                >
                    Detail Transaksi
                </h3>

                <button
                    onclick="closeDetailTransactionModal()"
                    class="text-slate-400 hover:text-white transition-colors"
                >
                    <i
                        data-lucide="x"
                        class="w-5 h-5"
                    ></i>
                </button>

            </div>


            <div
                style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.25rem 1.5rem; text-align: left;"
            >

                <div>

                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">
                        ID Transaksi
                    </label>

                    <span
                        class="text-sm font-bold text-white"
                        id="detailTxId"
                    >
                        -
                    </span>

                </div>


                <div>

                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">
                        Tanggal
                    </label>

                    <span
                        class="text-sm font-bold text-white"
                        id="detailTxDate"
                    >
                        -
                    </span>

                </div>


                <div>

                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">
                        ID Anggota
                    </label>

                    <span
                        class="text-sm font-bold text-white"
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

                    <label
                        id="modalTxTypeLabel"
                        class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider"
                    >
                        Jenis Simpanan
                    </label>

                    <div
                        id="detailTxTypeBadge"
                        class="mt-1"
                    >
                    </div>

                </div>


                <div>

                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">
                        Nominal
                    </label>

                    <span
                        class="text-sm font-extrabold text-white"
                        id="detailTxAmount"
                    >
                        -
                    </span>

                </div>


                <div
                    style="grid-column: span 2 / span 2; padding-top: 1.25rem; border-top: 1px solid #1f243d;"
                >

                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1 uppercase tracking-wider">
                        Keterangan
                    </label>

                    <p
                        class="text-xs text-slate-300 leading-relaxed"
                        id="detailTxDesc"
                    >
                        -
                    </p>

                </div>

            </div>


            <div class="flex justify-end pt-2 border-t border-[#1f243d]">

                <button
                    type="button"
                    onclick="closeDetailTransactionModal()"
                    class="btn-cancel px-5 py-2.5 rounded-lg text-xs font-semibold"
                >
                    Tutup
                </button>

            </div>

        </div>

    </div>


    <!-- ========================================================= -->
    <!-- DETAIL LOAN MODAL                                         -->
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
                    onclick="closeDetailLoanModal()"
                    class="text-slate-400 hover:text-white transition-colors"
                >
                    <i
                        data-lucide="x"
                        class="w-5 h-5"
                    ></i>
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
                        id="detailLoanMemberId"
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
                        id="detailLoanMemberName"
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
                        id="detailLoanAmount"
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
                        id="detailLoanTenor"
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
                        id="detailLoanProgress"
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
                        id="detailLoanRemaining"
                    >
                        -
                    </span>

                </div>


                <div class="col-span-2">

                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider">
                        Status
                    </label>

                    <span
                        id="detailLoanStatus"
                        class="px-2.5 py-0.5 rounded-full text-[10px] font-bold inline-block border"
                    >
                        -
                    </span>

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
    <!-- KIRIM LAPORAN KE EMAIL MODAL                              -->
    <!-- ========================================================= -->

    <div
        id="emailReportModal"
        class="fixed inset-0 flex items-center justify-center p-4 hidden"
        style="z-index: 10000; backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); background-color: rgba(7, 8, 15, 0.75);"
    >

        <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-md w-full p-6 shadow-2xl">

            <!-- HEADER -->
            <div class="flex justify-between items-center pb-4 border-b border-[#1f243d]">

                <div>

                    <h3 class="text-base font-bold text-white">
                        Kirim Laporan ke Email
                    </h3>

                    <p class="text-[10px] text-[#8f9bb3] mt-1">
                        Laporan akan dikirim dalam bentuk PDF.
                    </p>

                </div>


                <button
                    type="button"
                    onclick="tutupModalKirimEmail()"
                    class="text-slate-400 hover:text-white transition-colors"
                >

                    <i
                        data-lucide="x"
                        class="w-5 h-5"
                    ></i>

                </button>

            </div>


            <!-- CONTENT -->
            <div class="space-y-4 mt-5">

                <div>

                    <label
                        for="email-laporan"
                        class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5 uppercase tracking-wider"
                    >
                        Email Tujuan
                    </label>


                    <input
                        type="email"
                        id="email-laporan"
                        placeholder="contoh@email.com"
                        autocomplete="email"
                        class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3 py-2.5 text-xs text-white placeholder-[#8f9bb3] focus:outline-none focus:border-[#2f54eb]"
                    >


                    <p class="text-[9px] text-[#8f9bb3] mt-1.5">
                        Masukkan email penerima laporan keuangan.
                    </p>

                </div>


                <!-- INFO PDF -->
                <div class="bg-[#07080f]/50 border border-[#1f243d] rounded-lg p-3">

                    <div class="flex items-start gap-2">

                        <i
                            data-lucide="file-text"
                            class="w-4 h-4 text-[#2f54eb] mt-0.5 shrink-0"
                        ></i>


                        <div>

                            <p class="text-[10px] font-semibold text-white">
                                Laporan yang dikirim
                            </p>

                            <p class="text-[9px] text-[#8f9bb3] mt-1 leading-relaxed">
                                PDF akan mengikuti data, pencarian,
                                filter jenis, filter periode,
                                dan urutan yang sedang aktif.
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            <!-- FOOTER -->
            <div class="flex justify-end gap-2 pt-5 mt-5 border-t border-[#1f243d]">

                <button
                    type="button"
                    onclick="tutupModalKirimEmail()"
                    class="btn-cancel px-5 py-2.5 rounded-lg text-xs font-semibold"
                >
                    Batal
                </button>


                <button
                    type="button"
                    id="btn-submit-email"
                    onclick="kirimLaporanKeEmail()"
                    class="btn-print-pdf px-5 py-2.5 rounded-lg text-xs font-bold flex items-center gap-2"
                >

                    <i
                        data-lucide="send"
                        class="w-4 h-4"
                    ></i>

                    <span id="btn-submit-email-label">
                        Kirim Laporan
                    </span>

                </button>

            </div>

        </div>

    </div>

@endpush