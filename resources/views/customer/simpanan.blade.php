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
        background: white;
        border-radius: 14px;
        padding: 22px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    }

    .saving-card .label {
        color: #777;
        font-size: 13px;
        margin-bottom: 10px;
    }

    .saving-card .amount {
        font-size: 23px;
        font-weight: 700;
        color: #222;
    }

    .saving-card.total {
        background: #111;
        color: white;
    }

    .saving-card.total .label {
        color: #aaa;
    }

    .saving-card.total .amount {
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
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
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
       MEMBER INFO
    ========================= */

    .member-info {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    .member-item {
        background: #f5f6f8;
        padding: 16px;
        border-radius: 10px;
    }

    .member-item span {
        display: block;
        color: #777;
        font-size: 12px;
        margin-bottom: 7px;
    }

    .member-item strong {
        font-size: 14px;
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
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-success {
        background: #e8f7ee;
        color: #18794e;
    }

    .badge-danger {
        background: #fdecec;
        color: #b42318;
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
        background: #111;
        color: white;
        padding: 11px 18px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
        white-space: nowrap;
    }

    .btn-primary:hover {
        background: #333;
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
       ALERT
    ========================= */

    .saving-alert {
        padding: 14px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .saving-alert-success {
        background: #e8f7ee;
        color: #18794e;
    }

    .saving-alert-error {
        background: #fdecec;
        color: #b42318;
    }


    /* =========================
       MODAL
    ========================= */

    .saving-modal {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.55);

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

        background: white;

        border-radius: 16px;

        padding: 25px;

        box-shadow: 0 20px 50px rgba(0,0,0,0.2);
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
    }

    .saving-modal-header p {
        margin: 5px 0 0;
        font-size: 12px;
        color: #777;
    }

    .saving-modal-close {
        border: none;

        background: #f1f1f1;

        width: 34px;
        height: 34px;

        border-radius: 50%;

        cursor: pointer;

        font-size: 18px;

        color: #333;
    }

    .saving-modal-close:hover {
        background: #e5e5e5;
    }


    /* =========================
       FORM
    ========================= */

    .saving-form-group {
        margin-bottom: 16px;
    }

    .saving-form-group label {
        display: block;

        font-size: 13px;

        font-weight: 600;

        margin-bottom: 7px;
    }

    .saving-form-group input,
    .saving-form-group select,
    .saving-form-group textarea {
        width: 100%;

        border: 1px solid #ddd;

        border-radius: 9px;

        padding: 11px 12px;

        font-size: 14px;

        outline: none;

        box-sizing: border-box;

        background: white;
    }

    .saving-form-group input:focus,
    .saving-form-group select:focus,
    .saving-form-group textarea:focus {
        border-color: #111;
    }

    .saving-form-group textarea {
        min-height: 90px;

        resize: vertical;
    }

    .saving-form-help {
        display: block;

        margin-top: 6px;

        color: #888;

        font-size: 11px;
    }

    .saving-error {
        color: #b42318;

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

        margin-top: 20px;
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

<div
    class="saving-card total"
    style="margin-bottom:25px;"
>

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

            <button
                type="button"
                class="btn-primary"
                onclick="openSavingModal()"
            >
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

<div
    id="savingModal"
    class="saving-modal"
    onclick="closeSavingModalOutside(event)"
>

    <div
        class="saving-modal-box"
        onclick="event.stopPropagation()"
    >


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


            <button
                type="button"
                class="saving-modal-close"
                onclick="closeSavingModal()"
            >
                ×
            </button>

        </div>


        {{-- FORM --}}

        <form
            method="POST"
            action="{{ route('customer.simpanan.store') }}"
        >

            @csrf


            {{-- JENIS SIMPANAN --}}

            <div class="saving-form-group">

                <label for="jenis_simpanan">
                    Jenis Simpanan
                </label>

                <select
                    id="jenis_simpanan"
                    name="jenis_simpanan"
                    required
                >

                    <option value="">
                        Pilih jenis simpanan
                    </option>

                    <option
                        value="Pokok"
                        {{ old('jenis_simpanan') == 'Pokok' ? 'selected' : '' }}
                    >
                        Simpanan Pokok
                    </option>

                    <option
                        value="Wajib"
                        {{ old('jenis_simpanan') == 'Wajib' ? 'selected' : '' }}
                    >
                        Simpanan Wajib
                    </option>

                    <option
                        value="Sukarela"
                        {{ old('jenis_simpanan') == 'Sukarela' ? 'selected' : '' }}
                    >
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

                <input
                    type="number"
                    id="nominal"
                    name="nominal"
                    min="1000"
                    step="1000"
                    placeholder="Contoh: 500000"
                    value="{{ old('nominal') }}"
                    required
                >

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

                <input
                    type="date"
                    id="tanggal_transaksi"
                    name="tanggal_transaksi"
                    value="{{ old(
                        'tanggal_transaksi',
                        now()->format('Y-m-d')
                    ) }}"
                    required
                >


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

                <textarea
                    id="keterangan"
                    name="keterangan"
                    placeholder="Keterangan setoran (opsional)"
                >{{ old('keterangan') }}</textarea>


                @error('keterangan')

                    <div class="saving-error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- FOOTER --}}

            <div class="saving-modal-footer">

                <button
                    type="button"
                    class="btn-secondary"
                    onclick="closeSavingModal()"
                >
                    Batal
                </button>


                <button
                    type="submit"
                    class="btn-primary"
                >
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


    document.addEventListener('keydown', function(event) {

        if (event.key === 'Escape') {

            closeSavingModal();

        }

    });


    /*
     * Jika validasi Laravel gagal,
     * modal akan terbuka kembali.
     */

    @if($errors->any())

        document.addEventListener('DOMContentLoaded', function() {

            openSavingModal();

        });

    @endif

</script>

@endsection