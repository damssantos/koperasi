@extends('pengawas.layouts.app')

@section('title', 'Laporan Simpanan')

@section('page-title', 'Laporan Simpanan')

@section('page-description', 'Informasi simpanan anggota koperasi secara keseluruhan.')

@section('content')

<div class="space-y-6">

    {{-- ========================================== --}}
    {{-- HEADER LAPORAN --}}
    {{-- ========================================== --}}

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h2 class="text-lg font-bold text-zinc-900">
                Laporan Simpanan
            </h2>

            <p class="text-sm text-zinc-500 mt-1">
                Ringkasan dan data simpanan seluruh anggota koperasi.
            </p>
        </div>

        <div class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-zinc-100 text-zinc-600 text-xs font-medium">
            <span>🔒</span>
            View Only
        </div>

    </div>


    {{-- ========================================== --}}
    {{-- SUMMARY --}}
    {{-- ========================================== --}}

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

        {{-- SIMPANAN POKOK --}}
        <div class="bg-white rounded-2xl border border-zinc-200 p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-zinc-500">
                        Simpanan Pokok
                    </p>

                    <h2 class="text-xl font-bold text-zinc-900 mt-2">
                        Rp {{ number_format($totalPokok, 0, ',', '.') }}
                    </h2>

                </div>

                <div class="w-11 h-11 rounded-xl bg-zinc-100 flex items-center justify-center text-xl">
                    💰
                </div>

            </div>

            <p class="text-xs text-zinc-400 mt-4">
                Total simpanan pokok anggota
            </p>

        </div>


        {{-- SIMPANAN WAJIB --}}
        <div class="bg-white rounded-2xl border border-zinc-200 p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-zinc-500">
                        Simpanan Wajib
                    </p>

                    <h2 class="text-xl font-bold text-zinc-900 mt-2">
                        Rp {{ number_format($totalWajib, 0, ',', '.') }}
                    </h2>

                </div>

                <div class="w-11 h-11 rounded-xl bg-zinc-100 flex items-center justify-center text-xl">
                    📥
                </div>

            </div>

            <p class="text-xs text-zinc-400 mt-4">
                Total simpanan wajib anggota
            </p>

        </div>


        {{-- SIMPANAN SUKARELA --}}
        <div class="bg-white rounded-2xl border border-zinc-200 p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-zinc-500">
                        Simpanan Sukarela
                    </p>

                    <h2 class="text-xl font-bold text-zinc-900 mt-2">
                        Rp {{ number_format($totalSukarela, 0, ',', '.') }}
                    </h2>

                </div>

                <div class="w-11 h-11 rounded-xl bg-zinc-100 flex items-center justify-center text-xl">
                    💵
                </div>

            </div>

            <p class="text-xs text-zinc-400 mt-4">
                Total simpanan sukarela anggota
            </p>

        </div>


        {{-- TOTAL SIMPANAN --}}
        <div class="bg-zinc-900 rounded-2xl p-6 text-white">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-zinc-400">
                        Total Simpanan
                    </p>

                    <h2 class="text-xl font-bold mt-2">
                        Rp {{ number_format($totalSimpanan, 0, ',', '.') }}
                    </h2>

                </div>

                <div class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center text-xl">
                    🏦
                </div>

            </div>

            <p class="text-xs text-zinc-500 mt-4">
                Total saldo seluruh anggota
            </p>

        </div>

    </div>


    {{-- ========================================== --}}
    {{-- TABEL DATA --}}
    {{-- ========================================== --}}

    <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden">

        {{-- HEADER TABLE --}}
        <div class="px-6 py-5 border-b border-zinc-200">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>

                    <h2 class="text-base font-bold text-zinc-900">
                        Data Simpanan Anggota
                    </h2>

                    <p class="text-sm text-zinc-500 mt-1">
                        Menampilkan data simpanan seluruh anggota koperasi.
                    </p>

                </div>


                {{-- SEARCH --}}
                <div class="relative">

                    <input
                        type="text"
                        id="searchAnggota"
                        placeholder="Cari anggota..."
                        class="w-full md:w-64 px-4 py-2.5 pl-10 rounded-lg border border-zinc-200 text-sm text-zinc-700 outline-none focus:border-zinc-400 focus:ring-0"
                    >

                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400">
                        🔍
                    </span>

                </div>

            </div>

        </div>


        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-zinc-50 border-b border-zinc-200">

                    <tr>

                        <th class="px-6 py-4 text-left font-semibold text-zinc-600">
                            No
                        </th>

                        <th class="px-6 py-4 text-left font-semibold text-zinc-600">
                            ID Anggota
                        </th>

                        <th class="px-6 py-4 text-left font-semibold text-zinc-600">
                            Nama Anggota
                        </th>

                        <th class="px-6 py-4 text-right font-semibold text-zinc-600">
                            Simpanan Pokok
                        </th>

                        <th class="px-6 py-4 text-right font-semibold text-zinc-600">
                            Simpanan Wajib
                        </th>

                        <th class="px-6 py-4 text-right font-semibold text-zinc-600">
                            Simpanan Sukarela
                        </th>

                        <th class="px-6 py-4 text-right font-semibold text-zinc-600">
                            Total Saldo
                        </th>

                    </tr>

                </thead>


                <tbody
                    id="tableBody"
                    class="divide-y divide-zinc-100"
                >

                    @forelse($anggota as $index => $item)

                        <tr
                            class="member-row hover:bg-zinc-50 transition"
                            data-search="{{ strtolower(
                                ($item->id_anggota ?? '') . ' ' .
                                ($item->nama ?? '') . ' ' .
                                ($item->no_hp ?? '')
                            ) }}"
                        >

                            {{-- NO --}}
                            <td class="px-6 py-4 text-zinc-500">
                                {{ $index + 1 }}
                            </td>


                            {{-- ID --}}
                            <td class="px-6 py-4">

                                <span class="font-semibold text-zinc-800">
                                    {{ $item->id_anggota ?? 'AGT-' . str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                                </span>

                            </td>


                            {{-- NAMA --}}
                            <td class="px-6 py-4">

                                <div class="font-medium text-zinc-900">
                                    {{ $item->nama }}
                                </div>

                                @if($item->no_hp)
                                    <div class="text-xs text-zinc-400 mt-1">
                                        {{ $item->no_hp }}
                                    </div>
                                @endif

                            </td>


                            {{-- POKOK --}}
                            <td class="px-6 py-4 text-right whitespace-nowrap">

                                Rp {{ number_format(
                                    (int) $item->simpanan_pokok,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </td>


                            {{-- WAJIB --}}
                            <td class="px-6 py-4 text-right whitespace-nowrap">

                                Rp {{ number_format(
                                    (int) $item->simpanan_wajib,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </td>


                            {{-- SUKARELA --}}
                            <td class="px-6 py-4 text-right whitespace-nowrap">

                                Rp {{ number_format(
                                    (int) $item->simpanan_sukarela,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </td>


                            {{-- TOTAL --}}
                            <td class="px-6 py-4 text-right whitespace-nowrap">

                                <span class="font-bold text-zinc-900">

                                    Rp {{ number_format(
                                        (int) $item->total_saldo,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-12 text-center"
                            >

                                <div class="text-4xl mb-3">
                                    📭
                                </div>

                                <p class="font-semibold text-zinc-700">
                                    Belum ada data anggota
                                </p>

                                <p class="text-sm text-zinc-400 mt-1">
                                    Data simpanan anggota belum tersedia.
                                </p>

                            </td>

                        </tr>

                    @endforelse


                    {{-- SEARCH EMPTY --}}
                    <tr
                        id="searchEmpty"
                        style="display: none;"
                    >

                        <td
                            colspan="7"
                            class="px-6 py-12 text-center"
                        >

                            <div class="text-3xl mb-3">
                                🔍
                            </div>

                            <p class="font-semibold text-zinc-700">
                                Data tidak ditemukan
                            </p>

                            <p class="text-sm text-zinc-400 mt-1">
                                Coba gunakan kata pencarian lain.
                            </p>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        {{-- FOOTER --}}
        <div class="px-6 py-4 border-t border-zinc-200 bg-zinc-50">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">

                <p class="text-xs text-zinc-500">

                    Total anggota:
                    <span class="font-semibold text-zinc-700">
                        {{ number_format($anggota->count(), 0, ',', '.') }}
                    </span>

                </p>

                <p class="text-xs text-zinc-400">
                    Data bersifat read-only untuk Pengawas.
                </p>

            </div>

        </div>

    </div>


    {{-- ========================================== --}}
    {{-- INFORMASI --}}
    {{-- ========================================== --}}

    <div class="bg-zinc-900 rounded-2xl p-6 text-white">

        <div class="flex items-start gap-4">

            <div class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center text-xl flex-shrink-0">
                🛡️
            </div>

            <div>

                <h3 class="font-bold">
                    Informasi Laporan
                </h3>

                <p class="text-sm text-zinc-400 mt-2 leading-relaxed">
                    Laporan ini hanya dapat digunakan untuk melihat
                    kondisi simpanan koperasi. Pengawas tidak memiliki
                    akses untuk menambah, mengubah, atau menghapus
                    data simpanan.
                </p>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>

    const searchInput = document.getElementById('searchAnggota');
    const rows = document.querySelectorAll('.member-row');
    const searchEmpty = document.getElementById('searchEmpty');

    if (searchInput) {

        searchInput.addEventListener('input', function () {

            const keyword = this.value
                .toLowerCase()
                .trim();

            let visibleRows = 0;

            rows.forEach(row => {

                const searchText =
                    row.dataset.search || '';

                if (
                    keyword === '' ||
                    searchText.includes(keyword)
                ) {

                    row.style.display = '';

                    visibleRows++;

                } else {

                    row.style.display = 'none';

                }

            });


            if (searchEmpty) {

                searchEmpty.style.display =
                    visibleRows === 0 && keyword !== ''
                        ? ''
                        : 'none';

            }

        });

    }

</script>

@endpush