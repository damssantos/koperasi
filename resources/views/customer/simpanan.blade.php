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

        .saving-form-group input:focus,
        .saving-form-group select:focus,
        .saving-form-group textarea:focus {
            border-color: #2563EB;
            background: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
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

                    <select id="jenis_simpanan" name="jenis_simpanan" required>

                        <option value="">
                            Pilih jenis simpanan
                        </option>

                        <option value="Pokok" {{ old('jenis_simpanan') == 'Pokok' ? 'selected' : '' }}>
                            Simpanan Pokok
                        </option>

                        <option value="Wajib" {{ old('jenis_simpanan') == 'Wajib' ? 'selected' : '' }}>
                            Simpanan Wajib
                        </option>

                        <option value="Sukarela" {{ old('jenis_simpanan') == 'Sukarela' ? 'selected' : '' }}>
                            Simpanan Sukarela
                        </option>

                    </select>


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

                    <input type="number" id="nominal" name="nominal" min="1000" step="1000" placeholder="Contoh: 500000"
                        value="{{ old('nominal') }}" required>

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

                    <input type="date" id="tanggal_transaksi" name="tanggal_transaksi" value="{{ old(
        'tanggal_transaksi',
        now()->format('Y-m-d')
    ) }}" required>


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

        }


        function closeSavingModalOutside(event) {

            if (event.target.id === 'savingModal') {

                closeSavingModal();

            }

        }


        document.addEventListener('keydown', function (event) {

            if (event.key === 'Escape') {

                closeSavingModal();

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