@extends('customer.layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('page-description', 'Ringkasan aktivitas koperasi Anda')

@section('content')

    <style>
        /* ================= CARDS ================= */

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 22px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .card h3 {
            font-size: 14px;
            color: #777;
            margin-bottom: 10px;
        }

        .card .value {
            font-size: 25px;
            font-weight: bold;
        }

        /* ================= SECTION ================= */

        .section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }

        .section h2 {
            margin-bottom: 20px;
            font-size: 19px;
        }

        /* ================= INFORMATION ================= */

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .info-item {
            background: #f5f6f8;
            padding: 18px;
            border-radius: 10px;
        }

        .info-item span {
            display: block;
            color: #777;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .info-item strong {
            font-size: 16px;
        }

        /* ================= SAVING ================= */

        .saving-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .saving-item {
            background: #f5f6f8;
            padding: 18px;
            border-radius: 10px;
        }

        .saving-item span {
            display: block;
            color: #777;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .saving-item strong {
            font-size: 18px;
        }

        /* ================= TABLE ================= */

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 13px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            color: #777;
            font-size: 13px;
            font-weight: 600;
        }

        td {
            font-size: 14px;
        }

        /* ================= EMPTY ================= */

        .empty {
            text-align: center;
            padding: 25px;
            color: #888;
            font-size: 14px;
        }

        /* ================= RESPONSIVE ================= */

        @media (max-width: 900px) {
            .cards {
                grid-template-columns: 1fr;
            }

            .info-grid,
            .saving-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>


    {{-- =========================================================
    SUMMARY CARDS
    ========================================================= --}}

    <div class="cards">

        <div class="card">
            <h3>Total Saldo Simpanan</h3>

            <div class="value">
                Rp{{ number_format($anggota->total_saldo ?? 0, 0, ',', '.') }}
            </div>
        </div>


        <div class="card">
            <h3>Total Pinjaman</h3>

            <div class="value">
                Rp0
            </div>
        </div>


        <div class="card">
            <h3>Status Keanggotaan</h3>

            <div class="value">
                Aktif
            </div>
        </div>

    </div>


    {{-- =========================================================
    INFORMASI ANGGOTA
    ========================================================= --}}

    <div class="section">

        <h2>Informasi Anggota</h2>

        @if($anggota)

            <div class="info-grid">

                <div class="info-item">
                    <span>ID Anggota</span>

                    <strong>
                        {{ $anggota->id_anggota ?? '-' }}
                    </strong>
                </div>


                <div class="info-item">
                    <span>Nama</span>

                    <strong>
                        {{ $anggota->nama ?? auth()->user()->nama_lengkap }}
                    </strong>
                </div>


                <div class="info-item">
                    <span>No. HP</span>

                    <strong>
                        {{ $anggota->no_hp ?? '-' }}
                    </strong>
                </div>

            </div>

        @else

            <div class="empty">
                Data anggota belum terhubung dengan akun Anda.
            </div>

        @endif

    </div>


    {{-- =========================================================
    RINGKASAN SIMPANAN
    ========================================================= --}}

    <div class="section">

        <h2>Ringkasan Simpanan</h2>

        @if($anggota)

            <div class="saving-grid">

                <div class="saving-item">

                    <span>Simpanan Pokok</span>

                    <strong>
                        Rp{{ number_format($anggota->simpanan_pokok ?? 0, 0, ',', '.') }}
                    </strong>

                </div>


                <div class="saving-item">

                    <span>Simpanan Wajib</span>

                    <strong>
                        Rp{{ number_format($anggota->simpanan_wajib ?? 0, 0, ',', '.') }}
                    </strong>

                </div>


                <div class="saving-item">

                    <span>Simpanan Sukarela</span>

                    <strong>
                        Rp{{ number_format($anggota->simpanan_sukarela ?? 0, 0, ',', '.') }}
                    </strong>

                </div>

            </div>

        @else

            <div class="empty">
                Data simpanan belum tersedia.
            </div>

        @endif

    </div>


    {{-- =========================================================
    PINJAMAN
    ========================================================= --}}

    <div class="section">

        <h2>Pinjaman Saya</h2>

        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Approval</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>-</td>
                        <td>Rp0</td>
                        <td>Belum ada</td>
                        <td>-</td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>


    {{-- =========================================================
    AKTIVITAS TERBARU
    ========================================================= --}}

    <div class="section">

        <h2>Aktivitas Terbaru</h2>

        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Aktivitas</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>-</td>
                        <td>Belum ada aktivitas</td>
                        <td>-</td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

@endsection