@extends('pengawas.layouts.app')

@section('title', 'Laporan Pinjaman')

@section('page-title', 'Laporan Pinjaman')

@section('page-description', 'Informasi pinjaman anggota dan kondisi pinjaman koperasi.')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h2 class="text-lg font-bold text-zinc-900">
                Laporan Pinjaman
            </h2>

            <p class="text-sm text-zinc-500 mt-1">
                Ringkasan dan data pinjaman seluruh anggota koperasi.
            </p>
        </div>

        <div class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-zinc-100 text-zinc-600 text-xs font-medium">
            <span>🔒</span>
            View Only
        </div>

    </div>


    {{-- SUMMARY --}}

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

        {{-- TOTAL PLAFON --}}

        <div class="bg-white rounded-2xl border border-zinc-200 p-6">

            <p class="text-sm text-zinc-500">
                Total Plafon Pinjaman
            </p>

            <h2 class="text-xl font-bold text-zinc-900 mt-2">
                Rp {{ number_format($totalPlafon, 0, ',', '.') }}
            </h2>

            <p class="text-xs text-zinc-400 mt-4">
                Total nominal seluruh pinjaman
            </p>

        </div>


        {{-- TOTAL SISA --}}

        <div class="bg-white rounded-2xl border border-zinc-200 p-6">

            <p class="text-sm text-zinc-500">
                Sisa Pinjaman
            </p>

            <h2 class="text-xl font-bold text-zinc-900 mt-2">
                Rp {{ number_format($totalSisa, 0, ',', '.') }}
            </h2>

            <p class="text-xs text-zinc-400 mt-4">
                Pinjaman yang masih berjalan
            </p>

        </div>


        {{-- AKTIF --}}

        <div class="bg-white rounded-2xl border border-zinc-200 p-6">

            <p class="text-sm text-zinc-500">
                Pinjaman Aktif
            </p>

            <h2 class="text-xl font-bold text-zinc-900 mt-2">
                {{ number_format($jumlahAktif, 0, ',', '.') }}
            </h2>

            <p class="text-xs text-zinc-400 mt-4">
                Pinjaman yang sedang berjalan
            </p>

        </div>


        {{-- MENUNGGAK --}}

        <div class="bg-zinc-900 rounded-2xl p-6 text-white">

            <p class="text-sm text-zinc-400">
                Pinjaman Menunggak
            </p>

            <h2 class="text-xl font-bold mt-2">
                {{ number_format($jumlahMenunggak, 0, ',', '.') }}
            </h2>

            <p class="text-xs text-zinc-500 mt-4">
                Pinjaman yang membutuhkan perhatian
            </p>

        </div>

    </div>


    {{-- STATUS SUMMARY --}}

    <div class="bg-white rounded-2xl border border-zinc-200 p-6">

        <div class="mb-5">

            <h2 class="text-base font-bold text-zinc-900">
                Ringkasan Status Pinjaman
            </h2>

            <p class="text-sm text-zinc-500 mt-1">
                Distribusi status pinjaman dalam sistem.
            </p>

        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            <div class="rounded-xl bg-zinc-50 p-4">
                <p class="text-xs text-zinc-500">
                    Pengajuan
                </p>

                <p class="text-xl font-bold text-zinc-900 mt-1">
                    {{ number_format($jumlahPengajuan, 0, ',', '.') }}
                </p>
            </div>


            <div class="rounded-xl bg-zinc-50 p-4">
                <p class="text-xs text-zinc-500">
                    Aktif
                </p>

                <p class="text-xl font-bold text-zinc-900 mt-1">
                    {{ number_format($jumlahAktif, 0, ',', '.') }}
                </p>
            </div>


            <div class="rounded-xl bg-zinc-50 p-4">
                <p class="text-xs text-zinc-500">
                    Menunggak
                </p>

                <p class="text-xl font-bold text-zinc-900 mt-1">
                    {{ number_format($jumlahMenunggak, 0, ',', '.') }}
                </p>
            </div>


            <div class="rounded-xl bg-zinc-50 p-4">
                <p class="text-xs text-zinc-500">
                    Lunas
                </p>

                <p class="text-xl font-bold text-zinc-900 mt-1">
                    {{ number_format($jumlahLunas, 0, ',', '.') }}
                </p>
            </div>

        </div>

    </div>


    {{-- TABLE --}}

    <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden">

        {{-- TABLE HEADER --}}

        <div class="px-6 py-5 border-b border-zinc-200">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>

                    <h2 class="text-base font-bold text-zinc-900">
                        Data Pinjaman Anggota
                    </h2>

                    <p class="text-sm text-zinc-500 mt-1">
                        Data pinjaman seluruh anggota koperasi.
                    </p>

                </div>


                <div class="relative">

                    <input
                        type="text"
                        id="searchPinjaman"
                        placeholder="Cari anggota..."
                        class="w-full md:w-64 px-4 py-2.5 pl-10 rounded-lg border border-zinc-200 text-sm text-zinc-700 outline-none focus:border-zinc-400"
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
                            Nama
                        </th>

                        <th class="px-6 py-4 text-left font-semibold text-zinc-600">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-right font-semibold text-zinc-600">
                            Nominal
                        </th>

                        <th class="px-6 py-4 text-center font-semibold text-zinc-600">
                            Tenor
                        </th>

                        <th class="px-6 py-4 text-center font-semibold text-zinc-600">
                            Cicilan
                        </th>

                        <th class="px-6 py-4 text-right font-semibold text-zinc-600">
                            Sisa
                        </th>

                        <th class="px-6 py-4 text-center font-semibold text-zinc-600">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center font-semibold text-zinc-600">
                            Approval
                        </th>

                    </tr>

                </thead>


                <tbody
                    id="pinjamanTable"
                    class="divide-y divide-zinc-100"
                >

                    @forelse($pinjaman as $index => $item)

                        <tr
                            class="loan-row hover:bg-zinc-50 transition"
                            data-search="{{ strtolower(
                                ($item->anggota->id_anggota ?? '') . ' ' .
                                ($item->anggota->nama ?? '')
                            ) }}"
                        >

                            {{-- NO --}}

                            <td class="px-6 py-4 text-zinc-500">
                                {{ $index + 1 }}
                            </td>


                            {{-- ID ANGGOTA --}}

                            <td class="px-6 py-4">

                                <span class="font-semibold text-zinc-800">

                                    {{ $item->anggota->id_anggota
                                        ?? 'AGT-' . str_pad($item->anggota_id, 5, '0', STR_PAD_LEFT)
                                    }}

                                </span>

                            </td>


                            {{-- NAMA --}}

                            <td class="px-6 py-4">

                                <span class="font-medium text-zinc-900">

                                    {{ $item->anggota->nama ?? '-' }}

                                </span>

                            </td>


                            {{-- TANGGAL --}}

                            <td class="px-6 py-4 whitespace-nowrap text-zinc-600">

                                {{ optional($item->tanggal_pengajuan)->format('d M Y') ?? '-' }}

                            </td>


                            {{-- NOMINAL --}}

                            <td class="px-6 py-4 text-right whitespace-nowrap">

                                Rp {{ number_format(
                                    (int) $item->nominal_pinjaman,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </td>


                            {{-- TENOR --}}

                            <td class="px-6 py-4 text-center">

                                {{ $item->tenor }}
                                bulan

                            </td>


                            {{-- CICILAN --}}

                            <td class="px-6 py-4 text-center">

                                {{ $item->jumlah_cicilan_dibayar }}
                                / {{ $item->tenor }}

                            </td>


                            {{-- SISA --}}

                            <td class="px-6 py-4 text-right whitespace-nowrap">

                                Rp {{ number_format(
                                    (int) $item->sisa_pinjaman,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </td>


                            {{-- STATUS --}}

                            <td class="px-6 py-4 text-center">

                                @php
                                    $statusClass = match($item->status) {
                                        'Aktif' => 'bg-green-100 text-green-700',
                                        'Menunggak' => 'bg-red-100 text-red-700',
                                        'Lunas' => 'bg-blue-100 text-blue-700',
                                        'Pengajuan' => 'bg-yellow-100 text-yellow-700',
                                        'Ditolak' => 'bg-red-100 text-red-700',
                                        default => 'bg-zinc-100 text-zinc-600',
                                    };
                                @endphp

                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">

                                    {{ $item->status }}

                                </span>

                            </td>


                            {{-- APPROVAL --}}

                            <td class="px-6 py-4 text-center">

                                @php
                                    $approvalClass = match($item->status_persetujuan) {
                                        'Disetujui' => 'bg-green-100 text-green-700',
                                        'Ditolak' => 'bg-red-100 text-red-700',
                                        default => 'bg-yellow-100 text-yellow-700',
                                    };
                                @endphp

                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $approvalClass }}">

                                    {{ $item->status_persetujuan ?? 'Menunggu' }}

                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="10"
                                class="px-6 py-12 text-center"
                            >

                                <div class="text-4xl mb-3">
                                    📭
                                </div>

                                <p class="font-semibold text-zinc-700">
                                    Belum ada data pinjaman
                                </p>

                                <p class="text-sm text-zinc-400 mt-1">
                                    Data pinjaman belum tersedia.
                                </p>

                            </td>

                        </tr>

                    @endforelse


                    <tr
                        id="loanSearchEmpty"
                        style="display: none;"
                    >

                        <td
                            colspan="10"
                            class="px-6 py-12 text-center"
                        >

                            <div class="text-3xl mb-3">
                                🔍
                            </div>

                            <p class="font-semibold text-zinc-700">
                                Data tidak ditemukan
                            </p>

                            <p class="text-sm text-zinc-400 mt-1">
                                Coba gunakan nama atau ID anggota lain.
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

                    Total data:
                    <span class="font-semibold text-zinc-700">
                        {{ number_format($pinjaman->count(), 0, ',', '.') }}
                    </span>
                    pinjaman

                </p>

                <p class="text-xs text-zinc-400">
                    Data bersifat read-only untuk Pengawas.
                </p>

            </div>

        </div>

    </div>


    {{-- INFO --}}

    <div class="bg-zinc-900 rounded-2xl p-6 text-white">

        <div class="flex items-start gap-4">

            <div class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center text-xl">
                🛡️
            </div>

            <div>

                <h3 class="font-bold">
                    Informasi Laporan
                </h3>

                <p class="text-sm text-zinc-400 mt-2 leading-relaxed">
                    Pengawas hanya dapat melihat informasi pinjaman.
                    Tidak tersedia akses untuk membuat, mengubah,
                    menghapus, atau menyetujui pinjaman.
                </p>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>

    const searchPinjaman = document.getElementById('searchPinjaman');
    const loanRows = document.querySelectorAll('.loan-row');
    const loanSearchEmpty = document.getElementById('loanSearchEmpty');

    if (searchPinjaman) {

        searchPinjaman.addEventListener('input', function () {

            const keyword = this.value
                .toLowerCase()
                .trim();

            let visible = 0;

            loanRows.forEach(row => {

                const text = row.dataset.search || '';

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

            if (loanSearchEmpty) {

                loanSearchEmpty.style.display =
                    visible === 0 && keyword !== ''
                        ? ''
                        : 'none';

            }

        });

    }

</script>

@endpush