@extends('pengawas.layouts.app')

@section('title', 'Laporan Kas Usaha')

@section('content')

    <!-- Page Header Title -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-2">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Kas Usaha</h1>
            <p class="text-xs text-gray-500 mt-1">Monitoring arus kas operasional, penerimaan pendapatan, dan pengeluaran usaha.</p>
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

        <!-- Card 1: Total Pemasukan -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-emerald-300 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-[#10B981] shrink-0">
                    <i data-lucide="arrow-down-right" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-100 tracking-wider uppercase">PEMASUKAN</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-500">Total Pemasukan</p>
                <h3 class="text-xl font-extrabold text-gray-900 mt-1 tracking-tight">
                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-gray-500 mt-2 flex items-center gap-1">
                    <i data-lucide="check" class="w-3.5 h-3.5 text-[#10B981]"></i>
                    <span>{{ number_format($jumlahPemasukan, 0, ',', '.') }} transaksi penerimaan</span>
                </p>
            </div>
        </div>

        <!-- Card 2: Total Pengeluaran -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-rose-300 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                    <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-100 tracking-wider uppercase">PENGELUARAN</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-500">Total Pengeluaran</p>
                <h3 class="text-xl font-extrabold text-gray-900 mt-1 tracking-tight">
                    Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-gray-500 mt-2 flex items-center gap-1">
                    <i data-lucide="check" class="w-3.5 h-3.5 text-rose-500"></i>
                    <span>{{ number_format($jumlahPengeluaran, 0, ',', '.') }} transaksi pengeluaran</span>
                </p>
            </div>
        </div>

        <!-- Card 3: Saldo Kas -->
        <div class="bg-white border-2 border-blue-200 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-blue-400 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center text-white shrink-0 shadow-sm">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-100 tracking-wider uppercase">SALDO BERSIH</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-500">Saldo Kas Usaha</p>
                <h3 class="text-xl font-extrabold {{ $saldoKas >= 0 ? 'text-blue-700' : 'text-rose-600' }} mt-1 tracking-tight">
                    Rp {{ number_format($saldoKas, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-gray-500 mt-2 flex items-center gap-1">
                    <i data-lucide="scale" class="w-3.5 h-3.5 text-[#2563EB]"></i>
                    <span>Net akumulasi kas usaha</span>
                </p>
            </div>
        </div>

        <!-- Card 4: Total Transaksi -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-purple-300 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600 shrink-0">
                    <i data-lucide="receipt" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-100 tracking-wider uppercase">MUTASI</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-500">Total Transaksi</p>
                <h3 class="text-xl font-extrabold text-gray-900 mt-1 tracking-tight">
                    {{ number_format($transaksi->count(), 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-gray-500 mt-2 flex items-center gap-1">
                    <i data-lucide="activity" class="w-3.5 h-3.5 text-purple-600"></i>
                    <span>Arus kas operasional tercatat</span>
                </p>
            </div>
        </div>

    </div>

    <!-- ========================================== -->
    <!-- TABEL RIWAYAT TRANSAKSI KAS                -->
    <!-- ========================================== -->
    <div class="bg-white border border-gray-200/80 rounded-2xl overflow-hidden shadow-sm">
        
        <!-- Header & Search -->
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-gray-900 tracking-tight">Riwayat Arus Kas Usaha</h3>
                <p class="text-xs text-gray-500 mt-0.5">Daftar mutasi penerimaan dan pengeluaran kas usaha koperasi.</p>
            </div>

            <div class="relative w-full md:w-72">
                <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input
                    type="text"
                    id="searchKas"
                    placeholder="Cari jenis atau keterangan..."
                    class="w-full bg-[#F8FAFC] border border-gray-200 rounded-lg pl-10 pr-4 py-2 text-xs text-gray-900 placeholder-gray-400 focus:bg-white focus:border-[#2563EB] focus:outline-none transition"
                >
            </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#F8FAFC] border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px]">No</th>
                        <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px]">Tanggal</th>
                        <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px]">Jenis Transaksi</th>
                        <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px]">Keterangan</th>
                        <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px] text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody id="kasTable" class="divide-y divide-gray-100 text-gray-700">
                    @forelse($transaksi as $index => $item)
                        <tr class="kas-row hover:bg-blue-50/40 transition duration-150"
                            data-search="{{ strtolower(($item->jenis_transaksi ?? '') . ' ' . ($item->keterangan ?? '')) }}">
                            
                            <!-- No -->
                            <td class="px-6 py-4 text-gray-400 font-medium">
                                {{ $index + 1 }}
                            </td>

                            <!-- Tanggal -->
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                {{ optional($item->tanggal)->format('d M Y') ?? '-' }}
                            </td>

                            <!-- Jenis -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->jenis_transaksi === 'PENERIMAAN')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <i data-lucide="arrow-down-left" class="w-3 h-3 text-emerald-600"></i>
                                        PENERIMAAN
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        <i data-lucide="arrow-up-right" class="w-3 h-3 text-rose-600"></i>
                                        PENGELUARAN
                                    </span>
                                @endif
                            </td>

                            <!-- Keterangan -->
                            <td class="px-6 py-4 font-medium text-gray-900 max-w-md">
                                {{ $item->keterangan ?? '-' }}
                            </td>

                            <!-- Nominal -->
                            <td class="px-6 py-4 text-right whitespace-nowrap font-bold">
                                @if($item->jenis_transaksi === 'PENERIMAAN')
                                    <span class="text-emerald-600 font-mono text-sm">
                                        + Rp {{ number_format((int) $item->nominal, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-rose-600 font-mono text-sm">
                                        - Rp {{ number_format((int) $item->nominal, 0, ',', '.') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center mx-auto mb-3 text-gray-400">
                                    <i data-lucide="inbox" class="w-6 h-6"></i>
                                </div>
                                <p class="font-bold text-gray-800 text-sm">Belum Ada Transaksi Kas</p>
                                <p class="text-xs text-gray-400 mt-1">Data riwayat arus kas belum tersedia.</p>
                            </td>
                        </tr>
                    @endforelse

                    <!-- Search Empty State -->
                    <tr id="kasSearchEmpty" style="display: none;">
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center mx-auto mb-3 text-gray-400">
                                <i data-lucide="search-x" class="w-6 h-6"></i>
                            </div>
                            <p class="font-bold text-gray-800 text-sm">Data Tidak Ditemukan</p>
                            <p class="text-xs text-gray-400 mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Table Footer -->
        <div class="p-4 border-t border-gray-100 bg-[#F8FAFC] flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs text-gray-500">
            <p>
                Total Transaksi: <span class="font-bold text-gray-900">{{ number_format($transaksi->count(), 0, ',', '.') }}</span> mutasi kas
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
            Pencatatan kas usaha mencakup seluruh pemasukan dari operasional koperasi serta pengeluaran yang telah diverifikasi oleh bagian keuangan.
        </p>
    </div>

@endsection

@push('scripts')
<script>
    const searchKas = document.getElementById('searchKas');
    const kasRows = document.querySelectorAll('.kas-row');
    const kasSearchEmpty = document.getElementById('kasSearchEmpty');

    if (searchKas) {
        searchKas.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            let visible = 0;

            kasRows.forEach(row => {
                const text = row.dataset.search || '';
                if (keyword === '' || text.includes(keyword)) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (kasSearchEmpty) {
                kasSearchEmpty.style.display = (visible === 0 && keyword !== '') ? '' : 'none';
            }
        });
    }
</script>
@endpush