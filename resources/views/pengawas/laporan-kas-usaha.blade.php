@extends('pengawas.layouts.app')

@section('title', 'Kas Usaha')

@section('page-title', 'Kas Usaha')

@section('page-description', 'Informasi pemasukan, pengeluaran, dan saldo kas usaha koperasi.')

@section('content')

<div class="space-y-6">

    {{-- ========================================== --}}
    {{-- HEADER --}}
    {{-- ========================================== --}}

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>

            <h2 class="text-lg font-bold text-zinc-900">
                Kas Usaha
            </h2>

            <p class="text-sm text-zinc-500 mt-1">
                Ringkasan dan riwayat transaksi kas usaha koperasi.
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


        {{-- TOTAL PEMASUKAN --}}

        <div class="bg-white rounded-2xl border border-zinc-200 p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-zinc-500">
                        Total Pemasukan
                    </p>

                    <h2 class="text-xl font-bold text-zinc-900 mt-2">
                        Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                    </h2>

                </div>


                <div class="w-11 h-11 rounded-xl bg-zinc-100 flex items-center justify-center text-xl">
                    📥
                </div>

            </div>


            <p class="text-xs text-zinc-400 mt-4">
                Total penerimaan kas usaha
            </p>

        </div>


        {{-- TOTAL PENGELUARAN --}}

        <div class="bg-white rounded-2xl border border-zinc-200 p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-zinc-500">
                        Total Pengeluaran
                    </p>

                    <h2 class="text-xl font-bold text-zinc-900 mt-2">
                        Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                    </h2>

                </div>


                <div class="w-11 h-11 rounded-xl bg-zinc-100 flex items-center justify-center text-xl">
                    📤
                </div>

            </div>


            <p class="text-xs text-zinc-400 mt-4">
                Total pengeluaran kas usaha
            </p>

        </div>


        {{-- SALDO KAS --}}

        <div class="bg-zinc-900 rounded-2xl p-6 text-white">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-zinc-400">
                        Saldo Kas
                    </p>

                    <h2 class="text-xl font-bold mt-2">
                        Rp {{ number_format($saldoKas, 0, ',', '.') }}
                    </h2>

                </div>


                <div class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center text-xl">
                    💰
                </div>

            </div>


            <p class="text-xs text-zinc-500 mt-4">
                Pemasukan dikurangi pengeluaran
            </p>

        </div>


        {{-- TOTAL TRANSAKSI --}}

        <div class="bg-white rounded-2xl border border-zinc-200 p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-zinc-500">
                        Total Transaksi
                    </p>

                    <h2 class="text-xl font-bold text-zinc-900 mt-2">
                        {{ number_format($transaksi->count(), 0, ',', '.') }}
                    </h2>

                </div>


                <div class="w-11 h-11 rounded-xl bg-zinc-100 flex items-center justify-center text-xl">
                    📋
                </div>

            </div>


            <p class="text-xs text-zinc-400 mt-4">
                Seluruh transaksi kas usaha
            </p>

        </div>

    </div>


    {{-- ========================================== --}}
    {{-- RINGKASAN TRANSAKSI --}}
    {{-- ========================================== --}}

    <div class="bg-white rounded-2xl border border-zinc-200 p-6">

        <div class="mb-5">

            <h2 class="text-base font-bold text-zinc-900">
                Ringkasan Transaksi
            </h2>

            <p class="text-sm text-zinc-500 mt-1">
                Jumlah transaksi berdasarkan jenis transaksi.
            </p>

        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


            {{-- PEMASUKAN --}}

            <div class="rounded-xl bg-zinc-50 border border-zinc-100 p-5">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-zinc-500">
                            Transaksi Pemasukan
                        </p>

                        <p class="text-2xl font-bold text-zinc-900 mt-2">
                            {{ number_format($jumlahPemasukan, 0, ',', '.') }}
                        </p>

                    </div>


                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                        📥
                    </div>

                </div>

            </div>


            {{-- PENGELUARAN --}}

            <div class="rounded-xl bg-zinc-50 border border-zinc-100 p-5">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-zinc-500">
                            Transaksi Pengeluaran
                        </p>

                        <p class="text-2xl font-bold text-zinc-900 mt-2">
                            {{ number_format($jumlahPengeluaran, 0, ',', '.') }}
                        </p>

                    </div>


                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                        📤
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================== --}}
    {{-- RIWAYAT TRANSAKSI --}}
    {{-- ========================================== --}}

    <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden">


        {{-- TABLE HEADER --}}

        <div class="px-6 py-5 border-b border-zinc-200">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">


                <div>

                    <h2 class="text-base font-bold text-zinc-900">
                        Riwayat Kas Usaha
                    </h2>

                    <p class="text-sm text-zinc-500 mt-1">
                        Seluruh transaksi kas usaha koperasi.
                    </p>

                </div>


                {{-- SEARCH --}}

                <div class="relative">

                    <input
                        type="text"
                        id="searchKas"
                        placeholder="Cari transaksi..."
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
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left font-semibold text-zinc-600">
                            Jenis Transaksi
                        </th>

                        <th class="px-6 py-4 text-left font-semibold text-zinc-600">
                            Keterangan
                        </th>

                        <th class="px-6 py-4 text-right font-semibold text-zinc-600">
                            Nominal
                        </th>

                    </tr>

                </thead>


                <tbody
                    id="kasTable"
                    class="divide-y divide-zinc-100"
                >


                    @forelse($transaksi as $index => $item)


                        <tr
                            class="kas-row hover:bg-zinc-50 transition"
                            data-search="{{ strtolower(
                                ($item->jenis_transaksi ?? '') . ' ' .
                                ($item->keterangan ?? '')
                            ) }}"
                        >


                            {{-- NO --}}

                            <td class="px-6 py-4 text-zinc-500">

                                {{ $index + 1 }}

                            </td>


                            {{-- TANGGAL --}}

                            <td class="px-6 py-4 whitespace-nowrap text-zinc-600">

                                {{ optional($item->tanggal)->format('d M Y') ?? '-' }}

                            </td>


                            {{-- JENIS --}}

                            <td class="px-6 py-4">

                                @if($item->jenis_transaksi === 'PENERIMAAN')

                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">

                                        PENERIMAAN

                                    </span>

                                @else

                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">

                                        PENGELUARAN

                                    </span>

                                @endif

                            </td>


                            {{-- KETERANGAN --}}

                            <td class="px-6 py-4">

                                <span class="text-zinc-800">

                                    {{ $item->keterangan ?? '-' }}

                                </span>

                            </td>


                            {{-- NOMINAL --}}

                            <td class="px-6 py-4 text-right whitespace-nowrap">


                                @if($item->jenis_transaksi === 'PENERIMAAN')

                                    <span class="font-semibold text-green-700">

                                        + Rp {{ number_format(
                                            (int) $item->nominal,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </span>

                                @else

                                    <span class="font-semibold text-red-700">

                                        - Rp {{ number_format(
                                            (int) $item->nominal,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </span>

                                @endif


                            </td>

                        </tr>


                    @empty


                        <tr>

                            <td
                                colspan="5"
                                class="px-6 py-12 text-center"
                            >

                                <div class="text-4xl mb-3">
                                    📭
                                </div>

                                <p class="font-semibold text-zinc-700">
                                    Belum ada transaksi
                                </p>

                                <p class="text-sm text-zinc-400 mt-1">
                                    Belum ada data kas usaha.
                                </p>

                            </td>

                        </tr>


                    @endforelse


                    {{-- SEARCH EMPTY --}}

                    <tr
                        id="kasSearchEmpty"
                        style="display: none;"
                    >

                        <td
                            colspan="5"
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

                    Total transaksi:

                    <span class="font-semibold text-zinc-700">

                        {{ number_format($transaksi->count(), 0, ',', '.') }}

                    </span>

                </p>


                <p class="text-xs text-zinc-400">

                    Data bersifat read-only untuk Pengawas.

                </p>

            </div>

        </div>


    </div>


    {{-- ========================================== --}}
    {{-- INFORMATION --}}
    {{-- ========================================== --}}

    <div class="bg-zinc-900 rounded-2xl p-6 text-white">

        <div class="flex items-start gap-4">


            <div class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center text-xl flex-shrink-0">
                🛡️
            </div>


            <div>

                <h3 class="font-bold text-base">
                    Akses Pengawas
                </h3>


                <p class="text-sm text-zinc-400 mt-2 leading-relaxed">

                    Pengawas hanya dapat melihat informasi Kas Usaha.
                    Tidak tersedia akses untuk menambah, mengubah,
                    atau menghapus transaksi.

                </p>

            </div>

        </div>

    </div>


</div>

@endsection


{{-- ========================================== --}}
{{-- SEARCH --}}
{{-- ========================================== --}}

@push('scripts')

<script>

    const searchKas =
        document.getElementById('searchKas');

    const kasRows =
        document.querySelectorAll('.kas-row');

    const kasSearchEmpty =
        document.getElementById('kasSearchEmpty');


    if (searchKas) {

        searchKas.addEventListener('input', function () {

            const keyword =
                this.value
                    .toLowerCase()
                    .trim();


            let visible = 0;


            kasRows.forEach(row => {

                const text =
                    row.dataset.search || '';


                if (
                    keyword === '' ||
                    text.includes(keyword)
                ) {

                    row.style.display = '';

                    visible++;

                } else {

                    row.style.display = 'none';

                }

            });


            if (kasSearchEmpty) {

                kasSearchEmpty.style.display =
                    visible === 0 && keyword !== ''
                        ? ''
                        : 'none';

            }

        });

    }

</script>

@endpush