@extends('customer.layouts.app')

@section('title', 'Pinjaman')

@section('page-title', 'Pinjaman Saya')

@section('page-description', 'Informasi pengajuan dan pinjaman Anda')

@section('content')

    <style>
        /* =========================
           SUMMARY
        ========================= */

        .loan-summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .loan-card {
            background: white;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }

        .loan-card.dark {
            background: #111;
            color: white;
        }

        .loan-card .label {
            font-size: 13px;
            color: #777;
            margin-bottom: 10px;
        }

        .loan-card.dark .label {
            color: #aaa;
        }

        .loan-card .value {
            font-size: 23px;
            font-weight: 700;
        }

        .loan-card.dark .value {
            color: white;
        }


        /* =========================
           SECTION
        ========================= */

        .section {
            background: white;
            border-radius: 14px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }

        .section-header {
            margin-bottom: 20px;
        }

        .section-header h2 {
            font-size: 19px;
            margin-bottom: 5px;
        }

        .section-header p {
            color: #777;
            font-size: 13px;
        }


        /* =========================
           HEADER ACTION
        ========================= */

        .section-title-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
        }

        .section-title-content {
            flex: 1;
        }

        .loan-actions {
            flex-shrink: 0;
        }

        .btn-primary {
            border: none;
            background: #111;
            color: white;
            padding: 11px 18px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-primary:hover {
            background: #333;
        }


        /* =========================
           TABLE
        ========================= */

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 13px;
            text-align: left;
            border-bottom: 1px solid #eee;
            color: #777;
            font-size: 12px;
            font-weight: 600;
        }

        td {
            padding: 14px 13px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        tbody tr:hover {
            background: #fafafa;
        }


        /* =========================
           BADGE
        ========================= */

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-warning {
            background: #fff4d6;
            color: #9a6700;
        }

        .badge-success {
            background: #e8f7ee;
            color: #18794e;
        }

        .badge-danger {
            background: #fdecec;
            color: #b42318;
        }

        .badge-info {
            background: #eaf2ff;
            color: #175cd3;
        }


        /* =========================
           EMPTY
        ========================= */

        .empty {
            text-align: center;
            padding: 30px;
            color: #888;
            font-size: 14px;
        }


        /* =========================
           DETAIL
        ========================= */

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .detail-item {
            background: #f5f6f8;
            padding: 16px;
            border-radius: 10px;
        }

        .detail-item span {
            display: block;
            color: #777;
            font-size: 12px;
            margin-bottom: 7px;
        }

        .detail-item strong {
            font-size: 15px;
        }


        /* =========================
           ALERT
        ========================= */

        .loan-alert {
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .loan-alert-success {
            background: #e8f7ee;
            color: #18794e;
        }

        .loan-alert-error {
            background: #fdecec;
            color: #b42318;
        }


        /* =========================
           MODAL
        ========================= */

        .loan-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 20px;
        }

        .loan-modal.active {
            display: flex;
        }

        .loan-modal-box {
            width: 100%;
            max-width: 520px;
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        }

        .loan-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .loan-modal-header h3 {
            margin: 0;
            font-size: 20px;
        }

        .loan-modal-header p {
            margin: 5px 0 0;
            font-size: 12px;
            color: #777;
        }

        .loan-modal-close {
            border: none;
            background: #f1f1f1;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            color: #333;
        }

        .loan-modal-close:hover {
            background: #e5e5e5;
        }


        /* =========================
           FORM
        ========================= */

        .loan-form-group {
            margin-bottom: 16px;
        }

        .loan-form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .loan-form-group input,
        .loan-form-group select,
        .loan-form-group textarea {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 9px;
            padding: 11px 12px;
            font-size: 14px;
            outline: none;
            box-sizing: border-box;
            background: white;
        }

        .loan-form-group input:focus,
        .loan-form-group select:focus,
        .loan-form-group textarea:focus {
            border-color: #111;
        }

        .loan-form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .loan-form-help {
            display: block;
            margin-top: 6px;
            color: #888;
            font-size: 11px;
        }

        .loan-error {
            color: #b42318;
            font-size: 12px;
            margin-top: 5px;
        }


        /* =========================
           MODAL FOOTER
        ========================= */

        .loan-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-secondary {
            border: none;
            background: #eee;
            color: #333;
            padding: 11px 18px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background: #ddd;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .loan-summary {
                grid-template-columns: 1fr;
            }

            .section-title-row {
                flex-direction: column;
            }

            .loan-actions {
                width: 100%;
            }

            .loan-actions .btn-primary {
                width: 100%;
            }

        }

        @media (max-width: 700px) {

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .loan-modal-box {
                padding: 20px;
            }

        }
    </style>


    {{-- =====================================================
    NOTIFICATION
    ===================================================== --}}

    @if(session('success'))

        <div class="loan-alert loan-alert-success">
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="loan-alert loan-alert-error">
            {{ session('error') }}
        </div>

    @endif


    @if($errors->any())

        <div class="loan-alert loan-alert-error">

            {{ $errors->first() }}

        </div>

    @endif


    {{-- =====================================================
    RINGKASAN PINJAMAN
    ===================================================== --}}

    @php

        $totalPinjaman = $pinjaman
            ->where('status', 'Aktif')
            ->sum('nominal_pinjaman');

        $totalSisaPinjaman = $pinjaman
            ->where('status', 'Aktif')
            ->sum('sisa_pinjaman');

        $jumlahPinjamanAktif = $pinjaman
            ->where('status', 'Aktif')
            ->count();

    @endphp


    <div class="loan-summary">


        {{-- TOTAL PINJAMAN --}}

        <div class="loan-card dark">

            <div class="label">
                Total Pinjaman Aktif
            </div>

            <div class="value">

                Rp{{ number_format(
        $totalPinjaman,
        0,
        ',',
        '.'
    ) }}

            </div>

        </div>


        {{-- SISA PINJAMAN --}}

        <div class="loan-card">

            <div class="label">
                Sisa Pinjaman
            </div>

            <div class="value">

                Rp{{ number_format(
        $totalSisaPinjaman,
        0,
        ',',
        '.'
    ) }}

            </div>

        </div>


        {{-- JUMLAH PINJAMAN --}}

        <div class="loan-card">

            <div class="label">
                Jumlah Pinjaman Aktif
            </div>

            <div class="value">

                {{ $jumlahPinjamanAktif }}

            </div>

        </div>


    </div>


    {{-- =====================================================
    DATA PINJAMAN
    ===================================================== --}}

    <div class="section">

        <div class="section-title-row">

            <div class="section-title-content">

                <div class="section-header">

                    <h2>
                        Daftar Pinjaman
                    </h2>

                    <p>
                        Daftar pengajuan dan pinjaman yang terhubung dengan akun Anda.
                    </p>

                </div>

            </div>


            {{-- BUTTON AJUKAN --}}

            <div class="loan-actions">

                <button type="button" class="btn-primary" onclick="openLoanModal()">
                    + Ajukan Pinjaman
                </button>

            </div>

        </div>


        @if($pinjaman && $pinjaman->count() > 0)

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Tanggal Pengajuan
                            </th>

                            <th>
                                Nominal
                            </th>

                            <th>
                                Tenor
                            </th>

                            <th>
                                Sisa Pinjaman
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Approval
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($pinjaman as $loan)

                                    <tr>


                                        {{-- TANGGAL --}}

                                        <td>

                                            @if($loan->tanggal_pengajuan)

                                                            {{ \Carbon\Carbon::parse(
                                                    $loan->tanggal_pengajuan
                                                )->format('d-m-Y') }}

                                            @else

                                                -

                                            @endif

                                        </td>


                                        {{-- NOMINAL --}}

                                        <td>

                                            Rp{{ number_format(
                                $loan->nominal_pinjaman ?? 0,
                                0,
                                ',',
                                '.'
                            ) }}

                                        </td>


                                        {{-- TENOR --}}

                                        <td>

                                            {{ $loan->tenor ?? 0 }}
                                            bulan

                                        </td>


                                        {{-- SISA --}}

                                        <td>

                                            Rp{{ number_format(
                                $loan->sisa_pinjaman ?? 0,
                                0,
                                ',',
                                '.'
                            ) }}

                                        </td>


                                        {{-- STATUS --}}

                                        <td>

                                            @if($loan->status === 'Aktif')

                                                <span class="badge badge-success">
                                                    Aktif
                                                </span>

                                            @elseif($loan->status === 'Pengajuan')

                                                <span class="badge badge-warning">
                                                    Pengajuan
                                                </span>

                                            @elseif($loan->status === 'Ditolak')

                                                <span class="badge badge-danger">
                                                    Ditolak
                                                </span>

                                            @elseif($loan->status === 'Lunas')

                                                <span class="badge badge-info">
                                                    Lunas
                                                </span>

                                            @else

                                                <span class="badge badge-info">
                                                    {{ $loan->status ?? '-' }}
                                                </span>

                                            @endif

                                        </td>


                                        {{-- APPROVAL --}}

                                        <td>

                                            @if($loan->status_persetujuan === 'Disetujui')

                                                <span class="badge badge-success">
                                                    Disetujui
                                                </span>

                                            @elseif($loan->status_persetujuan === 'Ditolak')

                                                <span class="badge badge-danger">
                                                    Ditolak
                                                </span>

                                            @else

                                                <span class="badge badge-warning">
                                                    Menunggu
                                                </span>

                                            @endif

                                        </td>


                                    </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty">

                Belum ada pinjaman atau pengajuan pinjaman.

            </div>

        @endif


    </div>


    {{-- =====================================================
    DETAIL PINJAMAN TERBARU
    ===================================================== --}}

    @if($pinjaman && $pinjaman->count() > 0)

        @php

            $latestLoan = $pinjaman->first();

        @endphp


        <div class="section">

            <div class="section-header">

                <h2>
                    Detail Pinjaman Terbaru
                </h2>

                <p>
                    Informasi detail pinjaman terakhir Anda.
                </p>

            </div>


            <div class="detail-grid">


                {{-- NOMINAL --}}

                <div class="detail-item">

                    <span>
                        Nominal Pinjaman
                    </span>

                    <strong>

                        Rp{{ number_format(
                $latestLoan->nominal_pinjaman ?? 0,
                0,
                ',',
                '.'
            ) }}

                    </strong>

                </div>


                {{-- TENOR --}}

                <div class="detail-item">

                    <span>
                        Tenor
                    </span>

                    <strong>

                        {{ $latestLoan->tenor ?? 0 }}
                        bulan

                    </strong>

                </div>


                {{-- CICILAN --}}

                <div class="detail-item">

                    <span>
                        Cicilan Dibayar
                    </span>

                    <strong>

                        {{ $latestLoan->jumlah_cicilan_dibayar ?? 0 }}
                        kali

                    </strong>

                </div>


                {{-- SISA --}}

                <div class="detail-item">

                    <span>
                        Sisa Pinjaman
                    </span>

                    <strong>

                        Rp{{ number_format(
                $latestLoan->sisa_pinjaman ?? 0,
                0,
                ',',
                '.'
            ) }}

                    </strong>

                </div>


                {{-- STATUS --}}

                <div class="detail-item">

                    <span>
                        Status
                    </span>

                    <strong>

                        {{ $latestLoan->status ?? '-' }}

                    </strong>

                </div>


                {{-- APPROVAL --}}

                <div class="detail-item">

                    <span>
                        Status Approval
                    </span>

                    <strong>

                        {{ $latestLoan->status_persetujuan ?? 'Menunggu' }}

                    </strong>

                </div>


                {{-- KETERANGAN --}}

                @if($latestLoan->keterangan)

                    <div class="detail-item" style="grid-column: 1 / -1;">

                        <span>
                            Keterangan
                        </span>

                        <strong>
                            {{ $latestLoan->keterangan }}
                        </strong>

                    </div>

                @endif


            </div>

        </div>

    @endif


    {{-- =====================================================
    MODAL AJUKAN PINJAMAN
    ===================================================== --}}

    <div id="loanModal" class="loan-modal" onclick="closeLoanModalOutside(event)">

        <div class="loan-modal-box" onclick="event.stopPropagation()">


            {{-- HEADER --}}

            <div class="loan-modal-header">

                <div>

                    <h3>
                        Ajukan Pinjaman
                    </h3>

                    <p>
                        Isi data pengajuan pinjaman Anda.
                    </p>

                </div>


                <button type="button" class="loan-modal-close" onclick="closeLoanModal()">
                    ×
                </button>

            </div>


            {{-- FORM --}}

            <form method="POST" action="{{ route('customer.pinjaman.store') }}">

                @csrf


                {{-- NOMINAL --}}

                <div class="loan-form-group">

                    <label for="nominal_pinjaman">
                        Nominal Pinjaman
                    </label>

                    <input type="number" id="nominal_pinjaman" name="nominal_pinjaman" min="1000" step="1000"
                        placeholder="Contoh: 5000000" value="{{ old('nominal_pinjaman') }}" required>

                    <small class="loan-form-help">
                        Minimal pinjaman Rp1.000.
                    </small>


                    @error('nominal_pinjaman')

                        <div class="loan-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- TENOR --}}

                <div class="loan-form-group">

                    <label for="tenor">
                        Tenor
                    </label>

                    <select id="tenor" name="tenor" required>

                        <option value="">
                            Pilih tenor
                        </option>

                        <option value="3" {{ old('tenor') == 3 ? 'selected' : '' }}>
                            3 bulan
                        </option>

                        <option value="6" {{ old('tenor') == 6 ? 'selected' : '' }}>
                            6 bulan
                        </option>

                        <option value="9" {{ old('tenor') == 9 ? 'selected' : '' }}>
                            9 bulan
                        </option>

                        <option value="12" {{ old('tenor') == 12 ? 'selected' : '' }}>
                            12 bulan
                        </option>

                        <option value="18" {{ old('tenor') == 18 ? 'selected' : '' }}>
                            18 bulan
                        </option>

                        <option value="24" {{ old('tenor') == 24 ? 'selected' : '' }}>
                            24 bulan
                        </option>

                        <option value="36" {{ old('tenor') == 36 ? 'selected' : '' }}>
                            36 bulan
                        </option>

                        <option value="48" {{ old('tenor') == 48 ? 'selected' : '' }}>
                            48 bulan
                        </option>

                        <option value="60" {{ old('tenor') == 60 ? 'selected' : '' }}>
                            60 bulan
                        </option>

                    </select>


                    @error('tenor')

                        <div class="loan-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- KETERANGAN --}}

                <div class="loan-form-group">

                    <label for="keterangan">
                        Keterangan
                    </label>

                    <textarea id="keterangan" name="keterangan"
                        placeholder="Jelaskan keperluan pengajuan pinjaman...">{{ old('keterangan') }}</textarea>


                    @error('keterangan')

                        <div class="loan-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- FOOTER --}}

                <div class="loan-modal-footer">

                    <button type="button" class="btn-secondary" onclick="closeLoanModal()">
                        Batal
                    </button>

                    <button type="submit" class="btn-primary">
                        Ajukan Pinjaman
                    </button>

                </div>


            </form>

        </div>

    </div>


    {{-- =====================================================
    JAVASCRIPT
    ===================================================== --}}

    <script>

        function openLoanModal() {

            const modal = document.getElementById('loanModal');

            if (modal) {
                modal.classList.add('active');
            }

        }


        function closeLoanModal() {

            const modal = document.getElementById('loanModal');

            if (modal) {
                modal.classList.remove('active');
            }

        }


        function closeLoanModalOutside(event) {

            if (event.target.id === 'loanModal') {
                closeLoanModal();
            }

        }


        document.addEventListener('keydown', function (event) {

            if (event.key === 'Escape') {
                closeLoanModal();
            }

        });


        /*
         * Jika validasi Laravel gagal,
         * buka modal otomatis supaya user
         * bisa melihat error form.
         */

        @if($errors->any())

            document.addEventListener('DOMContentLoaded', function () {
                openLoanModal();
            });

        @endif

    </script>

@endsection