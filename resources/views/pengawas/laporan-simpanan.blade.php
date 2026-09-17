@extends('pengawas.layouts.app')

@section('title', 'Laporan Simpanan')

@section('content')

    <!-- Page Header Title -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-2">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Laporan Simpanan</h1>
            <p class="text-xs text-gray-500 mt-1">Ringkasan dan data rincian saldo simpanan seluruh anggota koperasi.</p>
        </div>
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-white border border-gray-200 shadow-sm text-xs font-semibold text-gray-700">
            <i data-lucide="shield-check" class="w-4 h-4 text-[#2563EB]"></i>
            <span>Mode View Only</span>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- SUMMARY STATS CARDS                        -->
    <!-- ========================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- Simpanan Pokok -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-blue-300 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#2563EB] shrink-0">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-100 tracking-wider uppercase">POKOK</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-500">Simpanan Pokok</p>
                <h3 class="text-xl font-extrabold text-gray-900 mt-1 tracking-tight">
                    Rp {{ number_format($totalPokok, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-gray-500 mt-2 flex items-center gap-1">
                    <i data-lucide="check" class="w-3.5 h-3.5 text-[#2563EB]"></i>
                    <span>Total simpanan pokok anggota</span>
                </p>
            </div>
        </div>

        <!-- Simpanan Wajib -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-sky-300 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center text-[#0EA5E9] shrink-0">
                    <i data-lucide="arrow-down-circle" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-100 tracking-wider uppercase">WAJIB</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-500">Simpanan Wajib</p>
                <h3 class="text-xl font-extrabold text-gray-900 mt-1 tracking-tight">
                    Rp {{ number_format($totalWajib, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-gray-500 mt-2 flex items-center gap-1">
                    <i data-lucide="check" class="w-3.5 h-3.5 text-[#0EA5E9]"></i>
                    <span>Total simpanan wajib anggota</span>
                </p>
            </div>
        </div>

        <!-- Simpanan Sukarela -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-emerald-300 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-[#10B981] shrink-0">
                    <i data-lucide="banknote" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-100 tracking-wider uppercase">SUKARELA</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-500">Simpanan Sukarela</p>
                <h3 class="text-xl font-extrabold text-gray-900 mt-1 tracking-tight">
                    Rp {{ number_format($totalSukarela, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-gray-500 mt-2 flex items-center gap-1">
                    <i data-lucide="check" class="w-3.5 h-3.5 text-[#10B981]"></i>
                    <span>Total simpanan sukarela anggota</span>
                </p>
            </div>
        </div>

        <!-- Total Simpanan -->
        <div class="bg-white border-2 border-blue-200 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-blue-400 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center text-white shrink-0 shadow-sm">
                    <i data-lucide="landmark" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-100 tracking-wider uppercase">TOTAL SALDO</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-semibold text-gray-500">Total Simpanan</p>
                <h3 class="text-xl font-extrabold text-blue-700 mt-1 tracking-tight">
                    Rp {{ number_format($totalSimpanan, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-gray-500 mt-2 flex items-center gap-1">
                    <i data-lucide="check-check" class="w-3.5 h-3.5 text-[#2563EB]"></i>
                    <span>Total seluruh simpanan anggota</span>
                </p>
            </div>
        </div>

    </div>

    <!-- ========================================== -->
    <!-- TABEL DATA SIMPANAN                        -->
    <!-- ========================================== -->
    <div class="bg-white border border-gray-200/80 rounded-2xl overflow-hidden shadow-sm">
        
        <!-- Header & Search Input -->
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-gray-900 tracking-tight">Data Simpanan Anggota</h3>
                <p class="text-xs text-gray-500 mt-0.5">Daftar saldo simpanan seluruh anggota koperasi.</p>
            </div>

            <!-- Search Field -->
            <div class="relative w-full md:w-72">
                <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input
                    type="text"
                    id="searchAnggota"
                    placeholder="Cari ID, nama, atau no HP..."
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
                        <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px]">ID Anggota</th>
                        <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px]">Nama Anggota</th>
                        <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px] text-right">Simpanan Pokok</th>
                        <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px] text-right">Simpanan Wajib</th>
                        <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px] text-right">Simpanan Sukarela</th>
                        <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-[11px] text-right">Total Saldo</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="divide-y divide-gray-100 text-gray-700">
                    @forelse($anggota as $index => $item)
                        <tr class="member-row hover:bg-blue-50/40 transition duration-150"
                            data-search="{{ strtolower(($item->id_anggota ?? '') . ' ' . ($item->nama ?? '') . ' ' . ($item->no_hp ?? '')) }}">
                            
                            <!-- No -->
                            <td class="px-6 py-4 text-gray-400 font-medium">
                                {{ $index + 1 }}
                            </td>

                            <!-- ID Anggota -->
                            <td class="px-6 py-4 font-semibold">
                                <span class="bg-gray-100 text-gray-800 px-2.5 py-1 rounded border border-gray-200 font-mono text-[11px]">
                                    {{ $item->id_anggota ?? 'AGT-' . str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            <!-- Nama Anggota -->
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900 text-xs">{{ $item->nama }}</div>
                                @if($item->no_hp)
                                    <div class="text-[11px] text-gray-400 mt-0.5 flex items-center gap-1">
                                        <i data-lucide="phone" class="w-3 h-3 text-gray-400"></i>
                                        <span>{{ $item->no_hp }}</span>
                                    </div>
                                @endif
                            </td>

                            <!-- Pokok -->
                            <td class="px-6 py-4 text-right whitespace-nowrap font-medium text-gray-600">
                                Rp {{ number_format((int) $item->simpanan_pokok, 0, ',', '.') }}
                            </td>

                            <!-- Wajib -->
                            <td class="px-6 py-4 text-right whitespace-nowrap font-medium text-gray-600">
                                Rp {{ number_format((int) $item->simpanan_wajib, 0, ',', '.') }}
                            </td>

                            <!-- Sukarela -->
                            <td class="px-6 py-4 text-right whitespace-nowrap font-medium text-gray-600">
                                Rp {{ number_format((int) $item->simpanan_sukarela, 0, ',', '.') }}
                            </td>

                            <!-- Total -->
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <span class="font-bold text-gray-900 text-sm">
                                    Rp {{ number_format((int) $item->total_saldo, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center mx-auto mb-3 text-gray-400">
                                    <i data-lucide="inbox" class="w-6 h-6"></i>
                                </div>
                                <p class="font-bold text-gray-800 text-sm">Belum Ada Data Anggota</p>
                                <p class="text-xs text-gray-400 mt-1">Data simpanan anggota belum tersedia di sistem.</p>
                            </td>
                        </tr>
                    @endforelse

                    <!-- Search Empty State -->
                    <tr id="searchEmpty" style="display: none;">
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
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
                Total Anggota: <span class="font-bold text-gray-900">{{ number_format($anggota->count(), 0, ',', '.') }}</span>
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
            Laporan ini merepresentasikan saldo simpanan secara langsung berdasarkan buku catatan kas anggota. Hak akses Pengawas diperuntukkan khusus tujuan pemeriksaan dan pengawasan.
        </p>
    </div>

@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('searchAnggota');
    const rows = document.querySelectorAll('.member-row');
    const searchEmpty = document.getElementById('searchEmpty');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            let visibleRows = 0;

            rows.forEach(row => {
                const searchText = row.dataset.search || '';
                if (keyword === '' || searchText.includes(keyword)) {
                    row.style.display = '';
                    visibleRows++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (searchEmpty) {
                searchEmpty.style.display = (visibleRows === 0 && keyword !== '') ? '' : 'none';
            }
        });
    }
</script>
@endpush