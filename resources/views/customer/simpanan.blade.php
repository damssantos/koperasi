@extends('customer.layouts.app')

@section('title', 'Simpanan')

@section('page-title', 'Simpanan Saya')

@section('page-description', 'Ringkasan dan riwayat simpanan Anda')

@section('content')

    <style>
        /* =========================
           SUMMARY CARDS
        ========================= */

        .saving-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .saving-card {
            background: #FFFFFF;
            border-radius: 14px;
            padding: 22px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .saving-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.08);
        }

        .saving-card .label {
            color: #64748B;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .saving-card .amount {
            font-size: 23px;
            font-weight: 800;
            color: #1F2937;
        }

        .saving-card.total {
            background: linear-gradient(135deg, #1E40AF 0%, #2563EB 100%);
            color: white;
            border: none;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.25);
        }

        .saving-card.total .label {
            color: rgba(255, 255, 255, 0.85);
        }

        .saving-card.total .amount {
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
           MEMBER INFO
        ========================= */

        .member-info {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        @media (max-width: 900px) {
            .member-info {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .member-item {
            background: #F8FAFC;
            padding: 16px;
            border-radius: 12px;
            border: 1px solid #F1F5F9;
        }

        .member-item span {
            display: block;
            color: #64748B;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .member-item strong {
            font-size: 14px;
            font-weight: 700;
            color: #1F2937;
        }


        /* =========================
           TABLE
        ========================= */

        .table-wrapper {
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

        .badge-success {
            background: rgba(16, 185, 129, 0.12);
            color: #047857;
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.12);
            color: #B91C1C;
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
           ACTION HEADER
        ========================= */

        .saving-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
        }

        .saving-header .section-header {
            flex: 1;
        }

        .saving-actions {
            flex-shrink: 0;
        }


        /* =========================
           BUTTON
        ========================= */

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
           ALERT
        ========================= */

        .saving-alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .saving-alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #047857;
            border: 1px solid rgba(16, 185, 129, 0.25);
        }

        .saving-alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: #B91C1C;
            border: 1px solid rgba(239, 68, 68, 0.25);
        }


        /* =========================
           MODAL
        ========================= */

        .saving-modal {
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

        .saving-modal.active {
            display: flex;
        }

        .saving-modal-box {
            width: 100%;
            max-width: 520px;

            background: #FFFFFF;

            border-radius: 20px;

            padding: 28px;

            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid #E2E8F0;
        }


        /* =========================
           MODAL HEADER
        ========================= */

        .saving-modal-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;

            margin-bottom: 20px;
        }

        .saving-modal-header h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: #1F2937;
        }

        .saving-modal-header p {
            margin: 5px 0 0;
            font-size: 13px;
            color: #64748B;
        }

        .saving-modal-close {
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

        .saving-modal-close:hover {
            background: #E2E8F0;
            color: #1F2937;
        }


        /* =========================
           FORM
        ========================= */

        .saving-form-group {
            margin-bottom: 18px;
        }

        .saving-form-group label {
            display: block;

            font-size: 13px;

            font-weight: 700;

            margin-bottom: 7px;
            color: #1F2937;
        }

        .saving-form-group input,
        .saving-form-group select,
        .saving-form-group textarea {
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

        .saving-form-group select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748B' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 16px 16px;
            padding-right: 40px;
            cursor: pointer;
        }

        /* =========================
           CUSTOM SELECT COMPONENT
        ========================= */
        .custom-select-wrapper {
            position: relative;
            width: 100%;
        }

        .custom-select-trigger {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 14px;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            color: #1F2937;
            cursor: pointer;
            outline: none;
            transition: all 0.2s ease;
            text-align: left;
        }

        .custom-select-trigger:hover {
            background: #F1F5F9;
            border-color: #CBD5E1;
        }

        .custom-select-trigger:focus,
        .custom-select-wrapper.is-open .custom-select-trigger {
            background: #FFFFFF;
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .custom-select-value {
            display: flex;
            align-items: center;
            font-weight: 500;
            color: #1F2937;
        }

        .custom-select-value.is-placeholder {
            color: #94A3B8;
            font-weight: 400;
        }

        .custom-select-arrow {
            color: #64748B;
            transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1), color 0.2s ease;
            flex-shrink: 0;
        }

        .custom-select-wrapper.is-open .custom-select-arrow {
            transform: rotate(180deg);
            color: #2563EB;
        }

        .custom-select-dropdown {
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            right: 0;
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 6px;
            box-shadow: 0 20px 30px -10px rgba(15, 23, 42, 0.15), 0 10px 15px -5px rgba(15, 23, 42, 0.08);
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px) scale(0.98);
            transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
            pointer-events: none;
        }

        .custom-select-wrapper.is-open .custom-select-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        .custom-select-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            border-radius: 9px;
            cursor: pointer;
            transition: all 0.15s ease;
            gap: 12px;
        }

        .custom-select-option:hover {
            background: #F1F5F9;
        }

        .custom-select-option.is-selected {
            background: #EFF6FF;
        }

        .custom-select-option-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .custom-select-option-title {
            font-size: 13.5px;
            font-weight: 600;
            color: #1E293B;
            transition: color 0.15s ease;
        }

        .custom-select-option.is-selected .custom-select-option-title {
            color: #2563EB;
        }

        .custom-select-option-desc {
            font-size: 11.5px;
            color: #64748B;
        }

        .custom-select-option.is-selected .custom-select-option-desc {
            color: #3B82F6;
        }

        .custom-select-check {
            width: 18px;
            height: 18px;
            color: #2563EB;
            opacity: 0;
            transform: scale(0.6);
            transition: all 0.15s ease;
            flex-shrink: 0;
        }

        .custom-select-option.is-selected .custom-select-check {
            opacity: 1;
            transform: scale(1);
        }

        .visually-hidden-select {
            position: absolute !important;
            opacity: 0 !important;
            width: 1px !important;
            height: 1px !important;
            top: 20px !important;
            left: 20px !important;
            pointer-events: none !important;
            clip: rect(0, 0, 0, 0) !important;
        }

        .saving-form-group textarea {
            min-height: 90px;

            resize: vertical;
        }

        .saving-form-help {
            display: block;

            margin-top: 6px;

            color: #64748B;

            font-size: 11px;
        }

        .saving-error {
            color: #DC2626;

            font-size: 12px;

            margin-top: 5px;
        }

        /* =========================
           CURRENCY INPUT
        ========================= */
        .input-currency-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .input-currency-wrapper .currency-prefix {
            position: absolute;
            left: 14px;
            font-size: 14px;
            font-weight: 700;
            color: #64748B;
            pointer-events: none;
            user-select: none;
        }

        .input-currency-wrapper input {
            padding-left: 42px !important;
        }

        /* =========================
           DATEPICKER & FLATPICKR
        ========================= */
        .input-date-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .saving-date-alt-input {
            width: 100%;
            border: 1px solid #E2E8F0 !important;
            border-radius: 10px !important;
            padding: 12px 42px 12px 14px !important;
            font-size: 14px !important;
            font-family: inherit !important;
            outline: none !important;
            box-sizing: border-box !important;
            background: #F8FAFC !important;
            color: #1F2937 !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }

        .saving-date-alt-input:focus {
            border-color: #2563EB !important;
            background: #FFFFFF !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12) !important;
        }

        .input-date-wrapper .date-icon {
            position: absolute;
            right: 14px;
            color: #64748B;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .input-date-wrapper:hover .date-icon {
            color: #2563EB;
        }

        /* Flatpickr Custom Theme */
        .flatpickr-calendar {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif !important;
            border-radius: 18px !important;
            border: 1px solid #E2E8F0 !important;
            box-shadow: 0 20px 35px -10px rgba(15, 23, 42, 0.15), 0 10px 15px -5px rgba(15, 23, 42, 0.08) !important;
            padding: 14px 16px !important;
            background: #FFFFFF !important;
            width: 310px !important;
        }

        .flatpickr-calendar::before,
        .flatpickr-calendar::after {
            display: none !important;
        }

        .flatpickr-months {
            display: flex !important;
            align-items: center !important;
            padding-bottom: 8px !important;
            margin-bottom: 6px !important;
            border-bottom: 1px solid #F1F5F9 !important;
        }

        .flatpickr-months .flatpickr-month {
            color: #1E293B !important;
            height: 36px !important;
        }

        .flatpickr-current-month {
            font-size: 15px !important;
            font-weight: 700 !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .flatpickr-current-month .cur-month {
            font-weight: 700 !important;
            color: #0F172A !important;
        }

        .flatpickr-current-month input.cur-year {
            font-weight: 700 !important;
            color: #0F172A !important;
        }

        .flatpickr-months .flatpickr-prev-month,
        .flatpickr-months .flatpickr-next-month {
            padding: 6px !important;
            height: 32px !important;
            width: 32px !important;
            border-radius: 8px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #64748B !important;
            transition: all 0.2s ease !important;
        }

        .flatpickr-months .flatpickr-prev-month:hover,
        .flatpickr-months .flatpickr-next-month:hover {
            background: #F1F5F9 !important;
            color: #0F172A !important;
        }

        .flatpickr-months .flatpickr-prev-month svg,
        .flatpickr-months .flatpickr-next-month svg {
            fill: currentColor !important;
            width: 13px !important;
            height: 13px !important;
        }

        .flatpickr-weekdays {
            margin-bottom: 6px !important;
        }

        span.flatpickr-weekday {
            font-size: 11.5px !important;
            font-weight: 700 !important;
            color: #94A3B8 !important;
            text-transform: uppercase !important;
        }

        .flatpickr-days {
            width: 100% !important;
        }

        .dayContainer {
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            justify-content: space-around !important;
        }

        .flatpickr-day {
            height: 36px !important;
            line-height: 36px !important;
            max-width: 36px !important;
            border-radius: 10px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #334155 !important;
            border: none !important;
            margin: 2px 0 !important;
            transition: all 0.15s ease !important;
        }

        .flatpickr-day:hover {
            background: #F1F5F9 !important;
            color: #0F172A !important;
        }

        .flatpickr-day.today {
            border: 1.5px solid #2563EB !important;
            color: #2563EB !important;
            background: transparent !important;
        }

        .flatpickr-day.selected,
        .flatpickr-day.selected:hover {
            background: #2563EB !important;
            color: #FFFFFF !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35) !important;
            border-color: #2563EB !important;
        }

        .flatpickr-day.prevMonthDay,
        .flatpickr-day.nextMonthDay {
            color: #CBD5E1 !important;
        }

        .flatpickr-day.prevMonthDay:hover,
        .flatpickr-day.nextMonthDay:hover {
            background: #F8FAFC !important;
            color: #94A3B8 !important;
        }


        /* =========================
           MODAL FOOTER
        ========================= */

        .saving-modal-footer {
            display: flex;

            justify-content: flex-end;

            gap: 10px;

            margin-top: 24px;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .saving-cards {
                grid-template-columns: 1fr;
            }

            .member-info {
                grid-template-columns: 1fr;
            }

        }


        @media (max-width: 700px) {

            .saving-header {
                flex-direction: column;
            }

            .saving-actions {
                width: 100%;
            }

            .saving-actions .btn-primary {
                width: 100%;
            }

            .saving-modal-box {
                padding: 20px;
            }

        }
    </style>


    {{-- =====================================================
    NOTIFICATION
    ===================================================== --}}

    @if(session('success'))

        <div class="saving-alert saving-alert-success">

            {{ session('success') }}

        </div>

    @endif


    @if(session('error'))

        <div class="saving-alert saving-alert-error">

            {{ session('error') }}

        </div>

    @endif


    @if($errors->any())

        <div class="saving-alert saving-alert-error">

            {{ $errors->first() }}

        </div>

    @endif


    {{-- =====================================================
    SUMMARY SIMPANAN
    ===================================================== --}}

    <div class="saving-cards">


        {{-- SIMPANAN POKOK --}}

        <div class="saving-card">

            <div class="label">
                Simpanan Pokok
            </div>

            <div class="amount">

                Rp{{ number_format(
        $anggota->simpanan_pokok ?? 0,
        0,
        ',',
        '.'
    ) }}

            </div>

        </div>


        {{-- SIMPANAN WAJIB --}}

        <div class="saving-card">

            <div class="label">
                Simpanan Wajib
            </div>

            <div class="amount">

                Rp{{ number_format(
        $anggota->simpanan_wajib ?? 0,
        0,
        ',',
        '.'
    ) }}

            </div>

        </div>


        {{-- SIMPANAN SUKARELA --}}

        <div class="saving-card">

            <div class="label">
                Simpanan Sukarela
            </div>

            <div class="amount">

                Rp{{ number_format(
        $anggota->simpanan_sukarela ?? 0,
        0,
        ',',
        '.'
    ) }}

            </div>

        </div>


    </div>


    {{-- =====================================================
    TOTAL SALDO
    ===================================================== --}}

    <div class="saving-card total" style="margin-bottom:25px;">

        <div class="label">
            Total Saldo Simpanan
        </div>

        <div class="amount">

            Rp{{ number_format(
        $anggota->total_saldo ?? 0,
        0,
        ',',
        '.'
    ) }}

        </div>

    </div>


    {{-- =====================================================
    INFORMASI ANGGOTA
    ===================================================== --}}

    <div class="section">

        <div class="section-header">

            <h2>
                Informasi Anggota
            </h2>

            <p>
                Data keanggotaan yang terhubung dengan akun Anda.
            </p>

        </div>


        <div class="member-info">


            {{-- ID ANGGOTA --}}

            <div class="member-item">

                <span>
                    ID Anggota
                </span>

                <strong>

                    {{ $anggota->id_anggota ?? '-' }}

                </strong>

            </div>


            {{-- NAMA --}}

            <div class="member-item">

                <span>
                    Nama
                </span>

                <strong>

                    {{ $anggota->nama ?? '-' }}

                </strong>

            </div>


            {{-- TANGGAL BERGABUNG --}}

            <div class="member-item">

                <span>
                    Tanggal Bergabung
                </span>

                <strong>

                    @if($anggota->tanggal_join)

                                    {{ \Carbon\Carbon::parse(
                            $anggota->tanggal_join
                        )->format('d-m-Y') }}

                    @else

                        -

                    @endif

                </strong>

            </div>


            {{-- NO. REKENING --}}

            <div class="member-item">

                <span>
                    No. Rekening
                </span>

                <strong>

                    @if(auth()->user()->no_rekening)
                        {{ auth()->user()->nama_bank ? auth()->user()->nama_bank . ' - ' : '' }}{{ auth()->user()->no_rekening }}
                    @else
                        -
                    @endif

                </strong>

            </div>


        </div>

    </div>


    {{-- =====================================================
    RIWAYAT TRANSAKSI SIMPANAN
    ===================================================== --}}

    <div class="section">


        <div class="saving-header">


            <div class="section-header">

                <h2>
                    Riwayat Simpanan
                </h2>

                <p>
                    Riwayat transaksi simpanan Anda.
                </p>

            </div>


            {{-- BUTTON AJUKAN SIMPANAN --}}

            <div class="saving-actions">

                <button type="button" class="btn-primary" onclick="openSavingModal()">
                    + Ajukan Simpanan
                </button>

            </div>


        </div>


        @if($transaksi && $transaksi->count() > 0)

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                Jenis
                            </th>

                            <th>
                                Nominal
                            </th>

                            <th>
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($transaksi as $item)

                                    <tr>


                                        {{-- TANGGAL --}}

                                        <td>

                                            @if($item->tanggal_transaksi)

                                                            {{ \Carbon\Carbon::parse(
                                                    $item->tanggal_transaksi
                                                )->format('d-m-Y') }}
                                            @else

                                                -

                                            @endif

                                        </td>


                                        {{-- JENIS --}}

                                        <td>

                                            {{ $item->jenis_simpanan ?? '-' }}

                                        </td>


                                        {{-- NOMINAL --}}

                                        <td>

                                            Rp{{ number_format(
                                $item->nominal ?? 0,
                                0,
                                ',',
                                '.'
                            ) }}

                                        </td>


                                        {{-- STATUS --}}

                                        <td>

                                            <span class="badge badge-success">

                                                Berhasil

                                            </span>

                                        </td>


                                    </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty">

                Belum ada riwayat transaksi simpanan.

            </div>

        @endif


    </div>


    {{-- =====================================================
    MODAL AJUKAN SIMPANAN
    ===================================================== --}}

    <div id="savingModal" class="saving-modal" onclick="closeSavingModalOutside(event)">

        <div class="saving-modal-box" onclick="event.stopPropagation()">


            {{-- MODAL HEADER --}}

            <div class="saving-modal-header">

                <div>

                    <h3>
                        Ajukan Simpanan
                    </h3>

                    <p>
                        Masukkan data setoran simpanan Anda.
                    </p>

                </div>


                <button type="button" class="saving-modal-close" onclick="closeSavingModal()">
                    ×
                </button>

            </div>


            {{-- FORM --}}

            <form method="POST" action="{{ route('customer.simpanan.store') }}">

                @csrf


                {{-- JENIS SIMPANAN --}}

                <div class="saving-form-group">

                    <label for="jenis_simpanan">
                        Jenis Simpanan
                    </label>

                    <div class="custom-select-wrapper" id="customSelectWrapper">

                        <select id="jenis_simpanan" name="jenis_simpanan" required class="visually-hidden-select" tabindex="-1">
                            <option value="">Pilih jenis simpanan</option>
                            <option value="Pokok" {{ old('jenis_simpanan') == 'Pokok' ? 'selected' : '' }}>Simpanan Pokok</option>
                            <option value="Wajib" {{ old('jenis_simpanan') == 'Wajib' ? 'selected' : '' }}>Simpanan Wajib</option>
                            <option value="Sukarela" {{ old('jenis_simpanan') == 'Sukarela' ? 'selected' : '' }}>Simpanan Sukarela</option>
                        </select>

                        <button type="button" class="custom-select-trigger" id="customSelectTrigger" aria-haspopup="listbox" aria-expanded="false">
                            <span class="custom-select-value {{ old('jenis_simpanan') ? '' : 'is-placeholder' }}" id="customSelectValue">
                                @if(old('jenis_simpanan') == 'Pokok')
                                    Simpanan Pokok
                                @elseif(old('jenis_simpanan') == 'Wajib')
                                    Simpanan Wajib
                                @elseif(old('jenis_simpanan') == 'Sukarela')
                                    Simpanan Sukarela
                                @else
                                    Pilih jenis simpanan
                                @endif
                            </span>

                            <svg class="custom-select-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>

                        <div class="custom-select-dropdown" id="customSelectDropdown" role="listbox">

                            <div class="custom-select-option {{ old('jenis_simpanan') == 'Pokok' ? 'is-selected' : '' }}" data-value="Pokok">
                                <div class="custom-select-option-info">
                                    <span class="custom-select-option-title">Simpanan Pokok</span>
                                    <span class="custom-select-option-desc">Setoran awal wajib saat resmi menjadi anggota</span>
                                </div>
                                <svg class="custom-select-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>

                            <div class="custom-select-option {{ old('jenis_simpanan') == 'Wajib' ? 'is-selected' : '' }}" data-value="Wajib">
                                <div class="custom-select-option-info">
                                    <span class="custom-select-option-title">Simpanan Wajib</span>
                                    <span class="custom-select-option-desc">Setoran berkala setiap periode/bulan</span>
                                </div>
                                <svg class="custom-select-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>

                            <div class="custom-select-option {{ old('jenis_simpanan') == 'Sukarela' ? 'is-selected' : '' }}" data-value="Sukarela">
                                <div class="custom-select-option-info">
                                    <span class="custom-select-option-title">Simpanan Sukarela</span>
                                    <span class="custom-select-option-desc">Setoran fleksibel dengan nominal bebas</span>
                                </div>
                                <svg class="custom-select-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>

                        </div>

                    </div>


                    @error('jenis_simpanan')

                        <div class="saving-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- NOMINAL --}}

                <div class="saving-form-group">

                    <label for="nominal">
                        Nominal Simpanan
                    </label>

                    <div class="input-currency-wrapper">
                        <span class="currency-prefix">Rp</span>
                        <input type="text" id="nominal" name="nominal" inputmode="numeric" placeholder="Contoh: 500.000"
                            value="{{ old('nominal') ? number_format((int)preg_replace('/[^0-9]/', '', old('nominal')), 0, ',', '.') : '' }}"
                            oninput="this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"
                            required autocomplete="off">
                    </div>

                    <small class="saving-form-help">
                        Minimal simpanan Rp1.000.
                    </small>


                    @error('nominal')

                        <div class="saving-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- TANGGAL --}}

                <div class="saving-form-group">

                    <label for="tanggal_transaksi">
                        Tanggal Setoran
                    </label>

                    <div class="input-date-wrapper">
                        <input type="text" id="tanggal_transaksi" name="tanggal_transaksi"
                            value="{{ old('tanggal_transaksi', now()->format('Y-m-d')) }}"
                            placeholder="Pilih tanggal setoran"
                            required>
                        <svg class="date-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>


                    @error('tanggal_transaksi')

                        <div class="saving-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- KETERANGAN --}}

                <div class="saving-form-group">

                    <label for="keterangan">
                        Keterangan
                    </label>

                    <textarea id="keterangan" name="keterangan"
                        placeholder="Keterangan setoran (opsional)">{{ old('keterangan') }}</textarea>


                    @error('keterangan')

                        <div class="saving-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- FOOTER --}}

                <div class="saving-modal-footer">

                    <button type="button" class="btn-secondary" onclick="closeSavingModal()">
                        Batal
                    </button>


                    <button type="submit" class="btn-primary">
                        Simpan Setoran
                    </button>

                </div>


            </form>

        </div>

    </div>


    {{-- =====================================================
    JAVASCRIPT
    ===================================================== --}}

    <script>

        function openSavingModal() {

            const modal = document.getElementById('savingModal');

            if (modal) {

                modal.classList.add('active');

            }

        }


        function closeSavingModal() {

            const modal = document.getElementById('savingModal');

            if (modal) {

                modal.classList.remove('active');

            }

            closeCustomSelect();

        }


        function closeCustomSelect() {

            const wrapper = document.getElementById('customSelectWrapper');
            const trigger = document.getElementById('customSelectTrigger');

            if (wrapper) wrapper.classList.remove('is-open');
            if (trigger) trigger.setAttribute('aria-expanded', 'false');

        }


        function closeSavingModalOutside(event) {

            if (event.target.id === 'savingModal') {

                closeSavingModal();

            }

        }


        document.addEventListener('keydown', function (event) {

            if (event.key === 'Escape') {

                closeCustomSelect();
                closeSavingModal();

            }

        });


        document.addEventListener('DOMContentLoaded', function () {

            const wrapper = document.getElementById('customSelectWrapper');
            const select = document.getElementById('jenis_simpanan');
            const trigger = document.getElementById('customSelectTrigger');
            const valueEl = document.getElementById('customSelectValue');
            const dropdown = document.getElementById('customSelectDropdown');

            if (wrapper && trigger && select && valueEl && dropdown) {

                // Toggle dropdown open/close
                trigger.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const isOpen = wrapper.classList.toggle('is-open');
                    trigger.setAttribute('aria-expanded', isOpen);
                });

                // Select option
                const options = dropdown.querySelectorAll('.custom-select-option');
                options.forEach(function (opt) {
                    opt.addEventListener('click', function (e) {
                        e.stopPropagation();
                        const val = this.getAttribute('data-value');
                        const title = this.querySelector('.custom-select-option-title') ? this.querySelector('.custom-select-option-title').textContent.trim() : val;

                        select.value = val;
                        valueEl.textContent = title;
                        valueEl.classList.remove('is-placeholder');

                        // Reset error outline if previously invalid
                        trigger.style.borderColor = '';
                        trigger.style.boxShadow = '';

                        options.forEach(function (o) { o.classList.remove('is-selected'); });
                        this.classList.add('is-selected');

                        closeCustomSelect();
                        select.dispatchEvent(new Event('change', { bubbles: true }));
                    });
                });

                // Close dropdown on click outside
                document.addEventListener('click', function (e) {
                    if (!wrapper.contains(e.target)) {
                        closeCustomSelect();
                    }
                });

                // Auto format nominal dengan titik ribuan
                const nominalInput = document.getElementById('nominal');
                if (nominalInput) {
                    nominalInput.addEventListener('input', function () {
                        const clean = this.value.replace(/\D/g, '');
                        if (!clean) {
                            this.value = '';
                            return;
                        }
                        this.value = clean.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    });
                }

                // Validation on submit
                const form = select.closest('form');
                if (form) {
                    form.addEventListener('submit', function (e) {
                        if (!select.value) {
                            e.preventDefault();
                            wrapper.classList.add('is-open');
                            trigger.setAttribute('aria-expanded', 'true');
                            trigger.style.borderColor = '#DC2626';
                            trigger.style.boxShadow = '0 0 0 3px rgba(220, 38, 38, 0.15)';
                            trigger.focus();
                            return;
                        }

                        if (nominalInput) {
                            nominalInput.value = nominalInput.value.replace(/\D/g, '');
                        }
                    });
                }

                // Inisialisasi Flatpickr Tanggal Setoran
                if (typeof flatpickr !== 'undefined') {
                    flatpickr('#tanggal_transaksi', {
                        locale: 'id',
                        dateFormat: 'Y-m-d',
                        altInput: true,
                        altFormat: 'j F Y',
                        altInputClass: 'saving-date-alt-input',
                        defaultDate: "{{ old('tanggal_transaksi', now()->format('Y-m-d')) }}",
                        disableMobile: true
                    });
                }

            }

        });


        /*
         * Jika validasi Laravel gagal,
         * modal akan terbuka kembali.
         */

        @if($errors->any())

            document.addEventListener('DOMContentLoaded', function () {

                openSavingModal();

            });

        @endif

    </script>

@endsection