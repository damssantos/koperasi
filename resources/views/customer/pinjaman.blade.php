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
            background: #FFFFFF;
            border-radius: 14px;
            padding: 22px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .loan-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.08);
        }

        .loan-card.dark {
            background: linear-gradient(135deg, #1E40AF 0%, #2563EB 100%);
            color: white;
            border: none;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.25);
        }

        .loan-card .label {
            font-size: 12px;
            font-weight: 600;
            color: #64748B;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .loan-card.dark .label {
            color: rgba(255, 255, 255, 0.85);
        }

        .loan-card .value {
            font-size: 23px;
            font-weight: 800;
            color: #1F2937;
        }

        .loan-card.dark .value {
            color: white;
        }


        /* =========================
           SECTION
        ========================= */

        .section {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.03);
        }

        .section-header {
            margin-bottom: 20px;
        }

        .section-header h2 {
            font-size: 18px;
            font-weight: 700;
            color: #1F2937;
            margin-bottom: 4px;
        }

        .section-header p {
            color: #64748B;
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
            background: #2563EB;
            color: white;
            padding: 11px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .btn-primary:hover {
            background: #1D4ED8;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
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
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #E2E8F0;
            background: #F8FAFC;
            color: #64748B;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid #E2E8F0;
            font-size: 14px;
            color: #1F2937;
        }

        tbody tr:hover {
            background: #F8FAFC;
        }


        /* =========================
           BADGE
        ========================= */

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.12);
            color: #D97706;
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.12);
            color: #047857;
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.12);
            color: #B91C1C;
        }

        .badge-info {
            background: rgba(14, 165, 233, 0.12);
            color: #0284C7;
        }


        /* =========================
           EMPTY
        ========================= */

        .empty {
            text-align: center;
            padding: 30px;
            color: #64748B;
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
            background: #F8FAFC;
            padding: 16px;
            border-radius: 12px;
            border: 1px solid #F1F5F9;
        }

        .detail-item span {
            display: block;
            color: #64748B;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-item strong {
            font-size: 15px;
            font-weight: 700;
            color: #1F2937;
        }


        /* =========================
           ALERT
        ========================= */

        .loan-alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .loan-alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #047857;
            border: 1px solid rgba(16, 185, 129, 0.25);
        }

        .loan-alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: #B91C1C;
            border: 1px solid rgba(239, 68, 68, 0.25);
        }


        /* =========================
           MODAL
        ========================= */

        .loan-modal {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(4px);
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
            background: #FFFFFF;
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid #E2E8F0;
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
            font-weight: 800;
            color: #1F2937;
        }

        .loan-modal-header p {
            margin: 5px 0 0;
            font-size: 13px;
            color: #64748B;
        }

        .loan-modal-close {
            border: none;
            background: #F1F5F9;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            color: #64748B;
            transition: all 0.2s ease;
        }

        .loan-modal-close:hover {
            background: #E2E8F0;
            color: #1F2937;
        }


        /* =========================
           FORM
        ========================= */

        .loan-form-group {
            margin-bottom: 18px;
        }

        .loan-form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 7px;
            color: #1F2937;
        }

        .loan-form-group input,
        .loan-form-group select,
        .loan-form-group textarea {
            width: 100%;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 14px;
            outline: none;
            box-sizing: border-box;
            background: #F8FAFC;
            color: #1F2937;
            transition: all 0.2s ease;
        }

        .loan-form-group input:focus,
        .loan-form-group select:focus,
        .loan-form-group textarea:focus {
            border-color: #2563EB;
            background: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .loan-form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .loan-form-help {
            display: block;
            margin-top: 6px;
            color: #64748B;
            font-size: 11px;
        }

        .loan-error {
            color: #DC2626;
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
            margin-top: 24px;
        }

        .btn-secondary {
            border: 1px solid #E2E8F0;
            background: #F8FAFC;
            color: #1F2937;
            padding: 11px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-secondary:hover {
            background: #E2E8F0;
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