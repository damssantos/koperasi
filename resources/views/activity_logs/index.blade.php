@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#0b0f14] text-white px-4 py-6 sm:px-6 lg:px-8">

    <div class="max-w-7xl mx-auto">

        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">

            <div>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">
                    History Aktivitas
                </h1>

                <p class="text-sm text-gray-400 mt-1">
                    Riwayat aktivitas dan perubahan data yang dilakukan oleh pengguna.
                </p>
            </div>


            {{-- EXPORT EXCEL --}}

            <a
                href="{{ route('activity_logs.export', request()->query()) }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-white text-black px-5 py-3 text-sm font-semibold hover:bg-gray-200 transition"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" x2="12" y1="15" y2="3"/>
                </svg>

                Export Excel

            </a>

        </div>


        {{-- ========================================================= --}}
        {{-- FILTER --}}
        {{-- ========================================================= --}}

        <div class="bg-[#11161d] border border-white/10 rounded-2xl p-4 mb-6">

            <form
                method="GET"
                action="{{ route('activity_logs.index') }}"
                class="grid grid-cols-1 md:grid-cols-3 gap-3"
            >

                {{-- SEARCH --}}

                <div>

                    <label class="block text-xs text-gray-400 mb-2">
                        Cari aktivitas
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari aktivitas, deskripsi, user..."
                        class="w-full rounded-xl bg-[#0b0f14] border border-white/10 text-white placeholder-gray-500 px-4 py-3 text-sm focus:outline-none focus:border-white/30"
                    >

                </div>


                {{-- FILTER AKTIVITAS --}}

                <div>

                    <label class="block text-xs text-gray-400 mb-2">
                        Jenis aktivitas
                    </label>

                    <select
                        name="aktivitas"
                        class="w-full rounded-xl bg-[#0b0f14] border border-white/10 text-white px-4 py-3 text-sm focus:outline-none focus:border-white/30"
                    >

                        <option value="">
                            Semua aktivitas
                        </option>

                        @foreach ($aktivitas as $item)

                            <option
                                value="{{ $item }}"
                                @selected(request('aktivitas') === $item)
                            >
                                {{ ucwords(str_replace('_', ' ', $item)) }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- BUTTON --}}

                <div class="flex items-end gap-2">

                    <button
                        type="submit"
                        class="flex-1 rounded-xl bg-white text-black px-4 py-3 text-sm font-semibold hover:bg-gray-200 transition"
                    >
                        Cari
                    </button>

                    <a
                        href="{{ route('activity_logs.index') }}"
                        class="rounded-xl border border-white/10 px-4 py-3 text-sm text-gray-300 hover:bg-white/5 transition"
                    >
                        Reset
                    </a>

                </div>

            </form>

        </div>


        {{-- ========================================================= --}}
        {{-- TABLE --}}
        {{-- ========================================================= --}}

        <div class="bg-[#11161d] border border-white/10 rounded-2xl overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-white/[0.03] border-b border-white/10">

                        <tr>

                            <th class="text-left px-5 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                Waktu
                            </th>

                            <th class="text-left px-5 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                User
                            </th>

                            <th class="text-left px-5 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                Aktivitas
                            </th>

                            <th class="text-left px-5 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                Deskripsi
                            </th>

                            <th class="text-right px-5 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                Detail
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-white/5">

                        @forelse ($logs as $log)

                            <tr class="hover:bg-white/[0.02] transition">

                                {{-- WAKTU --}}

                                <td class="px-5 py-4 whitespace-nowrap">

                                    <div class="text-white font-medium">
                                        {{ $log->created_at->format('d M Y') }}
                                    </div>

                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $log->created_at->format('H:i:s') }}
                                    </div>

                                </td>


                                {{-- USER --}}

                                <td class="px-5 py-4">

                                    @if ($log->user)

                                        <div class="text-white font-medium">
                                            {{ $log->user->nama_lengkap }}
                                        </div>

                                        <div class="text-xs text-gray-500">
                                            {{ $log->user->email }}
                                        </div>

                                    @else

                                        <span class="text-gray-500">
                                            Sistem
                                        </span>

                                    @endif

                                </td>


                                {{-- AKTIVITAS --}}

                                <td class="px-5 py-4">

                                    @php
                                        $labelAktivitas = ucwords(
                                            str_replace('_', ' ', $log->aktivitas)
                                        );
                                    @endphp

                                    <span class="inline-flex items-center rounded-lg bg-white/5 border border-white/10 px-3 py-1.5 text-xs font-medium text-gray-200">
                                        {{ $labelAktivitas }}
                                    </span>

                                </td>


                                {{-- DESKRIPSI --}}

                                <td class="px-5 py-4">

                                    <div class="text-gray-200 max-w-md">
                                        {{ $log->deskripsi ?? '-' }}
                                    </div>

                                    @if ($log->subject_type && $log->subject_id)

                                        <div class="text-xs text-gray-500 mt-1">

                                            {{ class_basename($log->subject_type) }}

                                            #{{ $log->subject_id }}

                                        </div>

                                    @endif

                                </td>


                                {{-- DETAIL --}}

                                <td class="px-5 py-4 text-right">

                                    <button
                                        type="button"
                                        onclick="showActivityDetail({{ $log->id }})"
                                        class="inline-flex items-center gap-2 rounded-lg border border-white/10 px-3 py-2 text-xs text-gray-300 hover:bg-white/5 hover:text-white transition"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="14"
                                            height="14"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>

                                        Lihat

                                    </button>

                                </td>

                            </tr>


                            {{-- ================================================= --}}
                            {{-- DATA DETAIL TERSEMBUNYI --}}
                            {{-- ================================================= --}}

                            <script>

                                window.activityLogs = window.activityLogs || {};

                                window.activityLogs[{{ $log->id }}] = {

                                    id: @json($log->id),

                                    waktu: @json(
                                        $log->created_at->format('d M Y H:i:s')
                                    ),

                                    user: @json(
                                        $log->user?->nama_lengkap ?? 'Sistem'
                                    ),

                                    email: @json(
                                        $log->user?->email ?? '-'
                                    ),

                                    aktivitas: @json(
                                        ucwords(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $log->aktivitas
                                            )
                                        )
                                    ),

                                    deskripsi: @json(
                                        $log->deskripsi ?? '-'
                                    ),

                                    subject: @json(
                                        $log->subject_type && $log->subject_id
                                            ? class_basename($log->subject_type) . ' #' . $log->subject_id
                                            : '-'
                                    ),

                                    sebelum: @json(
                                        $log->data_sebelum
                                    ),

                                    sesudah: @json(
                                        $log->data_sesudah
                                    ),

                                    ip: @json(
                                        $log->ip_address ?? '-'
                                    ),

                                    userAgent: @json(
                                        $log->user_agent ?? '-'
                                    )

                                };

                            </script>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-5 py-12 text-center"
                                >

                                    <div class="text-gray-400">
                                        Belum ada aktivitas.
                                    </div>

                                    <div class="text-xs text-gray-600 mt-1">
                                        Aktivitas yang tercatat akan muncul di sini.
                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ========================================================= --}}
            {{-- PAGINATION --}}
            {{-- ========================================================= --}}

            @if ($logs->hasPages())

                <div class="px-5 py-4 border-t border-white/10">

                    {{ $logs->links() }}

                </div>

            @endif

        </div>

    </div>

</div>


{{-- ============================================================= --}}
{{-- MODAL DETAIL AKTIVITAS --}}
{{-- ============================================================= --}}

<div
    id="activityDetailModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm px-4 py-6"
>

    <div
        class="w-full max-w-5xl max-h-[92vh] overflow-hidden bg-[#11161d] border border-white/10 rounded-2xl shadow-2xl flex flex-col"
    >


        {{-- ========================================================= --}}
        {{-- MODAL HEADER --}}
        {{-- ========================================================= --}}

        <div class="px-6 py-5 border-b border-white/10 shrink-0">

            <div class="flex items-start justify-between gap-4">

                <div>

                    <div class="flex items-center gap-2">

                        <div class="w-8 h-8 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="text-blue-400"
                            >
                                <path d="M12 8v4l3 3"/>
                                <circle cx="12" cy="12" r="9"/>
                            </svg>

                        </div>

                        <h2 class="text-lg font-semibold text-white">
                            Detail Aktivitas
                        </h2>

                    </div>


                    <p
                        id="detailTime"
                        class="text-xs text-gray-500 mt-2"
                    >
                        -
                    </p>

                </div>


                {{-- CLOSE --}}

                <button
                    type="button"
                    onclick="closeActivityDetail()"
                    class="w-9 h-9 rounded-lg border border-transparent hover:border-white/10 hover:bg-white/5 text-gray-500 hover:text-white transition flex items-center justify-center"
                    aria-label="Tutup"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="18"
                        height="18"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M18 6 6 18"/>
                        <path d="m6 6 12 12"/>
                    </svg>

                </button>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- MODAL CONTENT --}}
        {{-- ========================================================= --}}

        <div class="overflow-y-auto">

            <div class="p-6 space-y-6">


                {{-- ================================================= --}}
                {{-- INFORMASI UTAMA --}}
                {{-- ================================================= --}}

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">


                    {{-- USER --}}

                    <div class="rounded-xl bg-[#0b0f14] border border-white/10 p-4">

                        <div class="flex items-center gap-2 mb-3">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="15"
                                height="15"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="text-gray-500"
                            >
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>

                            <span class="text-xs text-gray-500">
                                User
                            </span>

                        </div>


                        <div
                            id="detailUser"
                            class="text-sm font-semibold text-white"
                        >
                            -
                        </div>


                        <div
                            id="detailEmail"
                            class="text-xs text-gray-500 mt-1 truncate"
                        >
                            -
                        </div>

                    </div>


                    {{-- AKTIVITAS --}}

                    <div class="rounded-xl bg-[#0b0f14] border border-white/10 p-4">

                        <div class="flex items-center gap-2 mb-3">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="15"
                                height="15"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="text-gray-500"
                            >
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                            </svg>

                            <span class="text-xs text-gray-500">
                                Aktivitas
                            </span>

                        </div>


                        <div
                            id="detailActivity"
                            class="text-sm font-semibold text-white"
                        >
                            -
                        </div>

                    </div>


                    {{-- DATA --}}

                    <div class="rounded-xl bg-[#0b0f14] border border-white/10 p-4">

                        <div class="flex items-center gap-2 mb-3">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="15"
                                height="15"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="text-gray-500"
                            >
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
                            </svg>

                            <span class="text-xs text-gray-500">
                                Data
                            </span>

                        </div>


                        <div
                            id="detailSubject"
                            class="text-sm font-semibold text-white"
                        >
                            -
                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- DESKRIPSI --}}
                {{-- ================================================= --}}

                <div>

                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                        Deskripsi
                    </div>


                    <div
                        id="detailDescription"
                        class="rounded-xl bg-[#0b0f14] border border-white/10 px-4 py-3.5 text-sm text-gray-200 leading-relaxed"
                    >
                        -
                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- PERUBAHAN DATA --}}
                {{-- ================================================= --}}

                <div>

                    <div class="flex items-start justify-between gap-4 mb-3">

                        <div>

                            <h3 class="text-sm font-semibold text-white">
                                Perubahan Data
                            </h3>

                            <p class="text-xs text-gray-500 mt-1">
                                Menampilkan data yang benar-benar mengalami perubahan.
                            </p>

                        </div>


                        <div
                            id="changeCount"
                            class="shrink-0 text-[10px] font-semibold px-2.5 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400"
                        >
                            0 perubahan
                        </div>

                    </div>


                    <div
                        id="detailChanges"
                        class="rounded-xl bg-[#0b0f14] border border-white/10 overflow-hidden"
                    >
                        {{-- Diisi JavaScript --}}

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- INFORMASI DATA --}}
                {{-- ================================================= --}}

                <div>

                    <div class="mb-3">

                        <h3 class="text-sm font-semibold text-white">
                            Informasi Data
                        </h3>

                        <p class="text-xs text-gray-500 mt-1">
                            Ringkasan informasi setelah aktivitas dilakukan.
                        </p>

                    </div>


                    <div
                        id="detailCurrentData"
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3"
                    >
                        {{-- Diisi JavaScript --}}

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- INFORMASI TEKNIS --}}
                {{-- ================================================= --}}

                <details class="group rounded-xl border border-white/10 bg-[#0b0f14]">

                    <summary class="cursor-pointer list-none px-4 py-3.5 flex items-center justify-between">

                        <div class="flex items-center gap-3">

                            <div class="w-7 h-7 rounded-lg bg-white/5 flex items-center justify-center">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="14"
                                    height="14"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="text-gray-500"
                                >
                                    <rect width="20" height="14" x="2" y="5" rx="2"/>
                                    <line x1="2" x2="22" y1="10" y2="10"/>
                                </svg>

                            </div>


                            <div>

                                <div class="text-xs font-semibold text-gray-300">
                                    Informasi Teknis
                                </div>

                                <div class="text-[10px] text-gray-600 mt-0.5">
                                    Informasi sistem dan akses
                                </div>

                            </div>

                        </div>


                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="15"
                            height="15"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="text-gray-500 transition-transform duration-200 group-open:rotate-180"
                        >
                            <path d="m6 9 6 6 6-6"/>
                        </svg>

                    </summary>


                    <div class="border-t border-white/10 px-4 py-4 grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- IP --}}

                        <div>

                            <div class="text-[10px] uppercase tracking-wider text-gray-600 mb-1">
                                IP Address
                            </div>

                            <div
                                id="detailIp"
                                class="text-xs text-gray-400 font-mono"
                            >
                                -
                            </div>

                        </div>


                        {{-- USER AGENT --}}

                        <div>

                            <div class="text-[10px] uppercase tracking-wider text-gray-600 mb-1">
                                User Agent
                            </div>

                            <div
                                id="detailUserAgent"
                                class="text-xs text-gray-400 break-all"
                            >
                                -
                            </div>

                        </div>

                    </div>

                </details>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- FOOTER --}}
        {{-- ========================================================= --}}

        <div class="px-6 py-4 border-t border-white/10 flex justify-end shrink-0 bg-[#11161d]">

            <button
                type="button"
                onclick="closeActivityDetail()"
                class="rounded-xl bg-white text-black px-5 py-2.5 text-sm font-semibold hover:bg-gray-200 transition"
            >
                Tutup
            </button>

        </div>

    </div>

</div>


{{-- ============================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ============================================================= --}}

<script>

    /*
    |--------------------------------------------------------------------------
    | LABEL FIELD
    |--------------------------------------------------------------------------
    */

    const activityFieldLabels = {

        id: 'ID',

        anggota_id: 'ID Anggota',

        nominal_pinjaman: 'Nominal Pinjaman',

        tenor: 'Tenor',

        jumlah_cicilan_dibayar: 'Cicilan Dibayar',

        sisa_pinjaman: 'Sisa Pinjaman',

        tanggal_pengajuan: 'Tanggal Pengajuan',

        tanggal_pencairan: 'Tanggal Pencairan',

        status: 'Status',

        status_persetujuan: 'Status Persetujuan',

        keterangan: 'Keterangan',

        bukti_transfer: 'Bukti Transfer',

        dibatalkan_pada: 'Dibatalkan Pada',

        alasan_pembatalan: 'Alasan Pembatalan',

        dibuat_oleh: 'Dibuat Oleh',

        diperbarui_oleh: 'Diperbarui Oleh',

        created_at: 'Dibuat Pada',

        updated_at: 'Diperbarui Pada',

        user_id: 'User ID',

        nama: 'Nama',

        id_anggota: 'ID Anggota',

        no_hp: 'No. HP',

        tanggal_join: 'Tanggal Bergabung',

        simpanan_pokok: 'Simpanan Pokok',

        simpanan_wajib: 'Simpanan Wajib',

        simpanan_sukarela: 'Simpanan Sukarela',

        total_saldo: 'Total Saldo'

    };


    /*
    |--------------------------------------------------------------------------
    | FIELD TEKNIS YANG TIDAK DITAMPILKAN SEBAGAI PERUBAHAN
    |--------------------------------------------------------------------------
    */

    const hiddenAuditFields = [

        'id',

        'created_at',

        'updated_at',

        'tanggal_pencairan',

        'dibatalkan_pada',

        'dibuat_oleh',

        'diperbarui_oleh'

    ];


    /*
    |--------------------------------------------------------------------------
    | FIELD INFORMASI YANG DIUTAMAKAN
    |--------------------------------------------------------------------------
    */

    const preferredInformationFields = [

        'nominal_pinjaman',

        'tenor',

        'jumlah_cicilan_dibayar',

        'sisa_pinjaman',

        'status',

        'status_persetujuan',

        'simpanan_pokok',

        'simpanan_wajib',

        'simpanan_sukarela',

        'total_saldo',

        'tanggal_pengajuan',

        'tanggal_join',

        'no_hp',

        'nama'

    ];


    /*
    |--------------------------------------------------------------------------
    | LABEL FIELD
    |--------------------------------------------------------------------------
    */

    function getActivityFieldLabel(field) {

        if (activityFieldLabels[field]) {

            return activityFieldLabels[field];

        }


        return field
            .replaceAll('_', ' ')
            .replace(/\b\w/g, char => char.toUpperCase());

    }


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    function escapeActivityHtml(value) {

        if (
            value === null ||
            value === undefined
        ) {

            return '-';

        }


        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

    }


    /*
    |--------------------------------------------------------------------------
    | FORMAT RUPIAH
    |--------------------------------------------------------------------------
    */

    function formatActivityRupiah(value) {

        if (
            value === null ||
            value === undefined ||
            value === ''
        ) {

            return '-';

        }


        const number = Number(value);


        if (Number.isNaN(number)) {

            return String(value);

        }


        return new Intl.NumberFormat('id-ID', {

            style: 'currency',

            currency: 'IDR',

            maximumFractionDigits: 0

        }).format(number);

    }


    /*
    |--------------------------------------------------------------------------
    | FORMAT TANGGAL
    |--------------------------------------------------------------------------
    */

    function formatActivityDate(value) {

        if (
            value === null ||
            value === undefined ||
            value === ''
        ) {

            return '-';

        }


        let dateString = String(value);


        /*
        | Laravel biasanya menghasilkan microseconds:
        | 2026-09-12T18:23:20.000000Z
        |
        | JavaScript lebih aman jika menjadi:
        | 2026-09-12T18:23:20.000Z
        */

        dateString = dateString.replace(
            /\.(\d{3})\d+/,
            '.$1'
        );


        const date = new Date(dateString);


        if (Number.isNaN(date.getTime())) {

            return String(value);

        }


        return date.toLocaleString(
            'id-ID',
            {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | FORMAT NILAI
    |--------------------------------------------------------------------------
    */

    function formatActivityValue(field, value) {

        if (
            value === null ||
            value === undefined ||
            value === ''
        ) {

            return '-';

        }


        /*
        | FIELD RUPIAH
        */

        const rupiahFields = [

            'nominal_pinjaman',

            'sisa_pinjaman',

            'simpanan_pokok',

            'simpanan_wajib',

            'simpanan_sukarela',

            'total_saldo'

        ];


        if (rupiahFields.includes(field)) {

            return formatActivityRupiah(value);

        }


        /*
        | TENOR
        */

        if (field === 'tenor') {

            return `${value} bulan`;

        }


        /*
        | CICILAN
        */

        if (
            field === 'jumlah_cicilan_dibayar'
        ) {

            return `${value} kali`;

        }


        /*
        | TANGGAL
        */

        if (
            field.includes('tanggal') ||
            field.includes('_pada') ||
            field.includes('_at')
        ) {

            return formatActivityDate(value);

        }


        /*
        | NULL
        */

        if (
            value === null ||
            value === 'null'
        ) {

            return '-';

        }


        return String(value);

    }


    /*
    |--------------------------------------------------------------------------
    | CEK NILAI SAMA
    |--------------------------------------------------------------------------
    */

    function auditValuesEqual(before, after) {

        if (
            before === null ||
            before === undefined
        ) {

            before = null;

        }


        if (
            after === null ||
            after === undefined
        ) {

            after = null;

        }


        return JSON.stringify(before) ===
               JSON.stringify(after);

    }


    /*
    |--------------------------------------------------------------------------
    | RENDER PERUBAHAN DATA
    |--------------------------------------------------------------------------
    */

    function renderActivityChanges(before, after) {

        const container =
            document.getElementById(
                'detailChanges'
            );


        const count =
            document.getElementById(
                'changeCount'
            );


        if (!container) {

            return;

        }


        container.innerHTML = '';


        before = before || {};

        after = after || {};


        /*
        | Gabungkan semua field
        */

        const fields = new Set([

            ...Object.keys(before),

            ...Object.keys(after)

        ]);


        const changes = [];


        fields.forEach(field => {

            /*
            | Jangan tampilkan metadata teknis
            */

            if (
                hiddenAuditFields.includes(field)
            ) {

                return;

            }


            const beforeValue =
                before[field] ?? null;


            const afterValue =
                after[field] ?? null;


            /*
            | Hanya ambil field yang berubah
            */

            if (
                !auditValuesEqual(
                    beforeValue,
                    afterValue
                )
            ) {

                changes.push({

                    field: field,

                    before: beforeValue,

                    after: afterValue

                });

            }

        });


        /*
        |--------------------------------------------------------------------------
        | TIDAK ADA PERUBAHAN
        |--------------------------------------------------------------------------
        */

        if (changes.length === 0) {

            container.innerHTML = `

                <div class="px-5 py-7 text-center">

                    <div class="w-10 h-10 mx-auto rounded-full bg-gray-500/10 border border-gray-500/20 flex items-center justify-center mb-3">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="text-gray-500"
                        >
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>

                    </div>

                    <div class="text-sm text-gray-300">
                        Tidak ada perubahan data.
                    </div>

                    <div class="text-xs text-gray-600 mt-1">
                        Aktivitas ini tidak mengubah nilai data.
                    </div>

                </div>

            `;


            if (count) {

                count.textContent =
                    '0 perubahan';

            }


            return;

        }


        /*
        |--------------------------------------------------------------------------
        | JUMLAH PERUBAHAN
        |--------------------------------------------------------------------------
        */

        if (count) {

            count.textContent =
                `${changes.length} perubahan`;

        }


        /*
        |--------------------------------------------------------------------------
        | RENDER SETIAP PERUBAHAN
        |--------------------------------------------------------------------------
        */

        changes.forEach(
            (change, index) => {

                const fieldLabel =
                    getActivityFieldLabel(
                        change.field
                    );


                const beforeValue =
                    formatActivityValue(
                        change.field,
                        change.before
                    );


                const afterValue =
                    formatActivityValue(
                        change.field,
                        change.after
                    );


                const row =
                    document.createElement(
                        'div'
                    );


                row.className =
                    `px-5 py-4 ${
                        index <
                        changes.length - 1
                            ? 'border-b border-white/5'
                            : ''
                    }`;


                row.innerHTML = `

                    <div class="text-xs font-semibold text-gray-300 mb-3">
                        ${escapeActivityHtml(fieldLabel)}
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-[1fr_auto_1fr] gap-3 items-center">


                        {{-- SEBELUM --}}

                        <div class="rounded-lg bg-white/[0.02] border border-white/5 px-3.5 py-3">

                            <div class="text-[9px] uppercase tracking-wider text-gray-600 mb-1">
                                Sebelum
                            </div>

                            <div class="text-xs text-gray-400 break-words">
                                ${escapeActivityHtml(beforeValue)}
                            </div>

                        </div>


                        {{-- ARROW --}}

                        <div class="hidden md:flex w-8 h-8 rounded-full bg-white/5 border border-white/10 items-center justify-center">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="14"
                                height="14"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="text-gray-500"
                            >
                                <path d="M5 12h14"/>
                                <path d="m12 5 7 7-7 7"/>
                            </svg>

                        </div>


                        {{-- SESUDAH --}}

                        <div class="rounded-lg bg-emerald-500/[0.04] border border-emerald-500/10 px-3.5 py-3">

                            <div class="text-[9px] uppercase tracking-wider text-emerald-500/60 mb-1">
                                Sesudah
                            </div>

                            <div class="text-xs font-semibold text-emerald-300 break-words">
                                ${escapeActivityHtml(afterValue)}
                            </div>

                        </div>

                    </div>

                `;


                container.appendChild(row);

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | RENDER INFORMASI DATA
    |--------------------------------------------------------------------------
    */

    function renderActivityCurrentData(data) {

        const container =
            document.getElementById(
                'detailCurrentData'
            );


        if (!container) {

            return;

        }


        container.innerHTML = '';


        if (!data) {

            return;

        }


        /*
        | Ambil field penting terlebih dahulu
        */

        const availableFields =
            preferredInformationFields.filter(
                field =>
                    Object.prototype.hasOwnProperty.call(
                        data,
                        field
                    )
            );


        /*
        |--------------------------------------------------------------------------
        | RENDER
        |--------------------------------------------------------------------------
        */

        availableFields.forEach(
            field => {

                const value =
                    formatActivityValue(
                        field,
                        data[field]
                    );


                const card =
                    document.createElement(
                        'div'
                    );


                card.className =
                    'rounded-xl bg-[#0b0f14] border border-white/10 px-4 py-3';


                card.innerHTML = `

                    <div class="text-[10px] text-gray-600 mb-1">
                        ${escapeActivityHtml(
                            getActivityFieldLabel(field)
                        )}
                    </div>

                    <div class="text-xs font-semibold text-gray-200 break-words">
                        ${escapeActivityHtml(value)}
                    </div>

                `;


                container.appendChild(card);

            }
        );


        /*
        |--------------------------------------------------------------------------
        | JIKA TIDAK ADA INFORMASI
        |--------------------------------------------------------------------------
        */

        if (
            availableFields.length === 0
        ) {

            container.innerHTML = `

                <div class="sm:col-span-2 lg:col-span-4 rounded-xl bg-[#0b0f14] border border-white/10 px-4 py-6 text-center">

                    <div class="text-xs text-gray-500">
                        Tidak ada informasi tambahan.
                    </div>

                </div>

            `;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | SHOW DETAIL
    |--------------------------------------------------------------------------
    */

    function showActivityDetail(id) {

        const log =
            window.activityLogs?.[id];


        if (!log) {

            console.error(
                'Activity log tidak ditemukan:',
                id
            );

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | INFORMASI UTAMA
        |--------------------------------------------------------------------------
        */

        document.getElementById(
            'detailTime'
        ).textContent =
            log.waktu || '-';


        document.getElementById(
            'detailUser'
        ).textContent =
            log.user || 'Sistem';


        document.getElementById(
            'detailEmail'
        ).textContent =
            log.email || '-';


        document.getElementById(
            'detailActivity'
        ).textContent =
            log.aktivitas || '-';


        document.getElementById(
            'detailSubject'
        ).textContent =
            log.subject || '-';


        document.getElementById(
            'detailDescription'
        ).textContent =
            log.deskripsi || '-';


        /*
        |--------------------------------------------------------------------------
        | PERUBAHAN DATA
        |--------------------------------------------------------------------------
        */

        renderActivityChanges(

            log.sebelum,

            log.sesudah

        );


        /*
        |--------------------------------------------------------------------------
        | INFORMASI DATA SAAT INI
        |--------------------------------------------------------------------------
        */

        renderActivityCurrentData(
            log.sesudah
        );


        /*
        |--------------------------------------------------------------------------
        | INFORMASI TEKNIS
        |--------------------------------------------------------------------------
        */

        document.getElementById(
            'detailIp'
        ).textContent =
            log.ip || '-';


        document.getElementById(
            'detailUserAgent'
        ).textContent =
            log.userAgent || '-';


        /*
        |--------------------------------------------------------------------------
        | OPEN MODAL
        |--------------------------------------------------------------------------
        */

        const modal =
            document.getElementById(
                'activityDetailModal'
            );


        modal.classList.remove(
            'hidden'
        );


        modal.classList.add(
            'flex'
        );


        /*
        | Lock body scroll
        */

        document.body.classList.add(
            'overflow-hidden'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CLOSE DETAIL
    |--------------------------------------------------------------------------
    */

    function closeActivityDetail() {

        const modal =
            document.getElementById(
                'activityDetailModal'
            );


        modal.classList.add(
            'hidden'
        );


        modal.classList.remove(
            'flex'
        );


        /*
        | Unlock body scroll
        */

        document.body.classList.remove(
            'overflow-hidden'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CLICK OUTSIDE MODAL
    |--------------------------------------------------------------------------
    */

    const activityModal =
        document.getElementById(
            'activityDetailModal'
        );


    if (activityModal) {

        activityModal.addEventListener(
            'click',
            function(event) {

                if (
                    event.target === this
                ) {

                    closeActivityDetail();

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | ESCAPE KEY
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function(event) {

            if (
                event.key === 'Escape'
            ) {

                const modal =
                    document.getElementById(
                        'activityDetailModal'
                    );


                if (
                    modal &&
                    !modal.classList.contains(
                        'hidden'
                    )
                ) {

                    closeActivityDetail();

                }

            }

        }
    );

</script>

@endsection