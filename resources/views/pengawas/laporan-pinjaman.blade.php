@extends('pengawas.layouts.app')

@section('title', 'Laporan Pinjaman')

@section('content')

    <!-- Page Header Title -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-2">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Laporan Pinjaman</h1>
            <p class="text-xs text-gray-500 mt-1">Monitoring portofolio pembiayaan, riwayat angsuran, dan sisa tagihan anggota.</p>
        </div>
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-white border border-gray-200 shadow-sm text-xs font-semibold text-gray-700">
            <i data-lucide="shield-check" class="w-4 h-4 text-[#2563EB]"></i>
            <span>Mode View Only</span>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TOP SUMMARY METRICS                        -->
    <!-- ========================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- Card 1: Total Plafon -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-blue-300 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#2563EB] shrink-0">
                    <i data-lucide="hand-coins" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-100 tracking-wider uppercase">PLAFON</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-500">Total Plafon Pinjaman</p>
                <h3 class="text-xl font-extrabold text-gray-900 mt-1 tracking-tight">
                    Rp {{ number_format($totalPlafon, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-gray-500 mt-2 flex items-center gap-1">
                    <i data-lucide="check" class="w-3.5 h-3.5 text-[#2563EB]"></i>
                    <span>Total nominal seluruh pinjaman</span>
                </p>
            </div>
        </div>

        <!-- Card 2: Sisa Pinjaman -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-sky-300 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center text-[#0EA5E9] shrink-0">
                    <i data-lucide="hourglass" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-100 tracking-wider uppercase">OUTSTANDING</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-500">Sisa Pinjaman Berjalan</p>
                <h3 class="text-xl font-extrabold text-gray-900 mt-1 tracking-tight">
                    Rp {{ number_format($totalSisa, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-gray-500 mt-2 flex items-center gap-1">
                    <i data-lucide="clock" class="w-3.5 h-3.5 text-[#0EA5E9]"></i>
                    <span>Pinjaman aktif & menunggak</span>
                </p>
            </div>
        </div>

        <!-- Card 3: Pinjaman Aktif -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-emerald-300 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-[#10B981] shrink-0">
                    <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-100 tracking-wider uppercase">LANCAR</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-500">Pinjaman Aktif</p>
                <h3 class="text-xl font-extrabold text-gray-900 mt-1 tracking-tight">
                    {{ number_format($jumlahAktif, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-gray-500 mt-2 flex items-center gap-1">
                    <i data-lucide="trending-up" class="w-3.5 h-3.5 text-[#10B981]"></i>
                    <span>Status pembayaran berjalan lancar</span>
                </p>
            </div>
        </div>

        <!-- Card 4: Pinjaman Menunggak -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-rose-300 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-100 tracking-wider uppercase">PERHATIAN</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-500">Pinjaman Menunggak</p>
                <h3 class="text-xl font-extrabold text-rose-600 mt-1 tracking-tight">
                    {{ number_format($jumlahMenunggak, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-gray-500 mt-2 flex items-center gap-1">
                    <i data-lucide="alert-circle" class="w-3.5 h-3.5 text-rose-500"></i>
                    <span>Membutuhkan tindak lanjut</span>
                </p>
            </div>
        </div>

    </div>

    <!-- ========================================== -->
    <!-- STATUS DISTRIBUTION BREAKDOWN              -->
    <!-- ========================================== -->
    <div class="bg-white border border-gray-200/80 rounded-2xl p-6 shadow-sm">
        <div class="mb-4">
            <h3 class="text-base font-bold text-gray-900 tracking-tight">Distribusi Status Pinjaman</h3>
            <p class="text-xs text-gray-500 mt-0.5">Klasifikasi seluruh berkas pengajuan dan pinjaman anggota.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Pengajuan -->
            <div class="bg-amber-50/60 border border-amber-100 rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-amber-800">Pengajuan</span>
                    <i data-lucide="clock" class="w-4 h-4 text-amber-600"></i>
                </div>
                <h4 class="text-xl font-extrabold text-gray-900 mt-2">
                    {{ number_format($jumlahPengajuan, 0, ',', '.') }}
                </h4>
                <p class="text-[10px] text-amber-700 mt-1">Menunggu persetujuan</p>
            </div>

            <!-- Aktif -->
            <div class="bg-emerald-50/60 border border-emerald-100 rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-emerald-800">Aktif</span>
                    <i data-lucide="trending-up" class="w-4 h-4 text-emerald-600"></i>
                </div>
                <h4 class="text-xl font-extrabold text-gray-900 mt-2">
                    {{ number_format($jumlahAktif, 0, ',', '.') }}
                </h4>
                <p class="text-[10px] text-emerald-700 mt-1">Sedang diangsur</p>
            </div>

            <!-- Menunggak -->
            <div class="bg-rose-50/60 border border-rose-100 rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-rose-800">Menunggak</span>
                    <i data-lucide="alert-octagon" class="w-4 h-4 text-rose-600"></i>
                </div>
                <h4 class="text-xl font-extrabold text-gray-900 mt-2">
                    {{ number_format($jumlahMenunggak, 0, ',', '.') }}
                </h4>
                <p class="text-[10px] text-rose-700 mt-1">Melebihi jatuh tempo</p>
            </div>

            <!-- Lunas -->
            <div class="bg-blue-50/60 border border-blue-100 rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-blue-800">Lunas</span>
                    <i data-lucide="award" class="w-4 h-4 text-blue-600"></i>
                </div>
                <h4 class="text-xl font-extrabold text-gray-900 mt-2">
                    {{ number_format($jumlahLunas, 0, ',', '.') }}
                </h4>
                <p class="text-[10px] text-blue-700 mt-1">Kewajiban selesai</p>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TABEL DATA PINJAMAN                        -->
    <!-- ========================================== -->
    <div class="bg-white border border-gray-200/80 rounded-2xl overflow-hidden shadow-sm">
        
        <!-- Header & Search -->
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-gray-900 tracking-tight">Daftar Pinjaman Anggota</h3>
                <p class="text-xs text-gray-500 mt-0.5">Rincian data nominal pinjaman, tenor, cicilan, serta status anggota.</p>
            </div>

            <div class="relative w-full md:w-72">
                <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input
                    type="text"
                    id="searchPinjaman"
                    placeholder="Cari ID atau nama peminjam..."
                    class="w-full bg-[#F8FAFC] border border-gray-200 rounded-lg pl-10 pr-4 py-2 text-xs text-gray-900 placeholder-gray-400 focus:bg-white focus:border-[#2563EB] focus:outline-none transition"
                >
            </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#F8FAFC] border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px]">No</th>
                        <th class="px-5 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px]">ID Anggota</th>
                        <th class="px-5 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px]">Nama</th>
                        <th class="px-5 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px]">Tgl Pengajuan</th>
                        <th class="px-5 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px] text-right">Nominal</th>
                        <th class="px-5 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px] text-center">Tenor</th>
                        <th class="px-5 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px] text-center">Cicilan</th>
                        <th class="px-5 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px] text-right">Sisa Pinjaman</th>
                        <th class="px-5 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px] text-center">Status</th>
                        <th class="px-5 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px] text-center">Approval</th>
                    </tr>
                </thead>
                <tbody id="pinjamanTable" class="divide-y divide-gray-100 text-gray-700">
                    @forelse($pinjaman as $index => $item)
                        <tr class="loan-row hover:bg-blue-50/40 transition duration-150"
                            data-search="{{ strtolower(($item->anggota->id_anggota ?? '') . ' ' . ($item->anggota->nama ?? '')) }}">
                            
                            <!-- No -->
                            <td class="px-5 py-4 text-gray-400 font-medium">
                                {{ $index + 1 }}
                            </td>

                            <!-- ID Anggota -->
                            <td class="px-5 py-4 font-semibold">
                                <span class="bg-gray-100 text-gray-800 px-2.5 py-1 rounded border border-gray-200 font-mono text-[11px]">
                                    {{ $item->anggota->id_anggota ?? 'AGT-' . str_pad($item->anggota_id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            <!-- Nama -->
                            <td class="px-5 py-4 font-bold text-gray-900">
                                {{ $item->anggota->nama ?? '-' }}
                            </td>

                            <!-- Tanggal -->
                            <td class="px-5 py-4 whitespace-nowrap text-gray-500">
                                {{ optional($item->tanggal_pengajuan)->format('d M Y') ?? '-' }}
                            </td>

                            <!-- Nominal -->
                            <td class="px-5 py-4 text-right whitespace-nowrap font-medium text-gray-800">
                                Rp {{ number_format((int) $item->nominal_pinjaman, 0, ',', '.') }}
                            </td>

                            <!-- Tenor -->
                            <td class="px-5 py-4 text-center whitespace-nowrap text-gray-600">
                                {{ $item->tenor }} bln
                            </td>

                            <!-- Cicilan -->
                            <td class="px-5 py-4 text-center whitespace-nowrap font-mono text-gray-700 font-semibold">
                                {{ $item->jumlah_cicilan_dibayar }} / {{ $item->tenor }}
                            </td>

                            <!-- Sisa Pinjaman -->
                            <td class="px-5 py-4 text-right whitespace-nowrap font-bold text-gray-900">
                                Rp {{ number_format((int) $item->sisa_pinjaman, 0, ',', '.') }}
                            </td>

                            <!-- Status -->
                            <td class="px-5 py-4 text-center whitespace-nowrap">
                                @php
                                    $statusBadge = match($item->status) {
                                        'Aktif' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                                        'Menunggak' => 'bg-rose-50 text-rose-700 border border-rose-200',
                                        'Lunas' => 'bg-blue-50 text-blue-700 border border-blue-200',
                                        'Pengajuan' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                        'Ditolak' => 'bg-rose-50 text-rose-700 border border-rose-200',
                                        default => 'bg-gray-50 text-gray-600 border border-gray-200',
                                    };
                                @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusBadge }}">
                                    {{ $item->status }}
                                </span>
                            </td>

                            <!-- Approval -->
                            <td class="px-5 py-4 text-center whitespace-nowrap">
                                @php
                                    $approvalBadge = match($item->status_persetujuan) {
                                        'Disetujui' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                                        'Ditolak' => 'bg-rose-50 text-rose-700 border border-rose-200',
                                        default => 'bg-amber-50 text-amber-700 border border-amber-200',
                                    };
                                @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $approvalBadge }}">
                                    {{ $item->status_persetujuan ?? 'Menunggu' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                                <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center mx-auto mb-3 text-gray-400">
                                    <i data-lucide="inbox" class="w-6 h-6"></i>
                                </div>
                                <p class="font-bold text-gray-800 text-sm">Belum Ada Data Pinjaman</p>
                                <p class="text-xs text-gray-400 mt-1">Data pinjaman anggota belum tersedia di sistem.</p>
                            </td>
                        </tr>
                    @endforelse

                    <!-- Search Empty State -->
                    <tr id="loanSearchEmpty" style="display: none;">
                        <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                            <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center mx-auto mb-3 text-gray-400">
                                <i data-lucide="search-x" class="w-6 h-6"></i>
                            </div>
                            <p class="font-bold text-gray-800 text-sm">Data Tidak Ditemukan</p>
                            <p class="text-xs text-gray-400 mt-1">Coba gunakan nama atau ID anggota lain.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Table Footer -->
        <div class="p-4 border-t border-gray-100 bg-[#F8FAFC] flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs text-gray-500">
            <p>
                Total Data: <span class="font-bold text-gray-900">{{ number_format($pinjaman->count(), 0, ',', '.') }}</span> pinjaman
            </p>
            <p class="text-[11px] flex items-center gap-1.5">
                <i data-lucide="shield" class="w-3.5 h-3.5 text-[#2563EB]"></i>
                <span>Data bersifat read-only untuk Pengawas</span>
            </p>
        </div>

    </div>

    <!-- Info Box -->
    <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm flex items-start gap-3.5">
        <div class="w-9 h-9 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center text-[#2563EB] shrink-0">
            <i data-lucide="info" class="w-4 h-4"></i>
        </div>
        <p class="text-xs text-gray-600 leading-relaxed">
            Pengawas hanya memiliki izin membaca data pinjaman untuk memantau risiko kredit dan kelancaran pembayaran. Proses pencairan atau persetujuan pinjaman dilakukan oleh manajemen operasional.
        </p>
    </div>

@endsection

@push('scripts')
<script>
    const searchPinjaman = document.getElementById('searchPinjaman');
    const loanRows = document.querySelectorAll('.loan-row');
    const loanSearchEmpty = document.getElementById('loanSearchEmpty');

    if (searchPinjaman) {
        searchPinjaman.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            let visible = 0;

            loanRows.forEach(row => {
                const text = row.dataset.search || '';
                if (keyword === '' || text.includes(keyword)) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (loanSearchEmpty) {
                loanSearchEmpty.style.display = (visible === 0 && keyword !== '') ? '' : 'none';
            }
        });
    }
</script>
@endpush