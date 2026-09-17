@extends('customer.layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dasbor')

@section('page-description', 'Sistem Operasional Yayasan YPIK - Ringkasan & Pemantauan')

@section('content')

    <style>
        /* ================= STAT CARDS ================= */
        .stat-card-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 22px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.08);
        }

        .stat-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .stat-icon-box {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #EFF6FF;
            color: #2563EB;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .stat-label {
            font-size: 11px;
            font-weight: 700;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 6px;
        }

        .stat-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            color: #64748B;
            border-top: 1px dashed #E2E8F0;
            padding-top: 10px;
            margin-top: 8px;
        }

        .stat-link {
            color: #2563EB;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .stat-link:hover {
            color: #1D4ED8;
            text-decoration: underline;
        }

        /* ================= SECTION ================= */
        .section {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03);
        }

        .section-title {
            font-size: 17px;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .saving-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        @media (max-width: 900px) {
            .info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .info-item, .saving-item {
            background: #F8FAFC;
            padding: 16px 18px;
            border-radius: 12px;
            border: 1px solid #F1F5F9;
        }

        .info-item span, .saving-item span {
            display: block;
            color: #64748B;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-item strong {
            font-size: 15px;
            font-weight: 700;
            color: #0F172A;
        }

        .saving-item strong {
            font-size: 17px;
            font-weight: 800;
            color: #2563EB;
        }

        .section-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .badge-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            background: rgba(16, 185, 129, 0.12);
            color: #047857;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px 16px;
            border-bottom: 1px solid #E2E8F0;
            text-align: left;
        }

        th {
            background: #F8FAFC;
            color: #64748B;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            font-size: 13.5px;
            color: #0F172A;
        }

        tbody tr:hover {
            background: #F8FAFC;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #64748B;
            font-size: 14px;
        }

        @media (max-width: 900px) {
            .stat-card-grid {
                grid-template-columns: 1fr;
            }
            .info-grid, .saving-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>



    {{-- STAT CARDS GRID --}}
    <div class="stat-card-grid">

        {{-- CARD 1: SALDO SIMPANAN --}}
        <div class="stat-card">
            <div>
                <div class="stat-card-header">
                    <div class="stat-icon-box">
                        <i data-lucide="wallet"></i>
                    </div>
                    <div class="stat-label">• Total Saldo Simpanan</div>
                </div>
                <div class="stat-value">
                    Rp{{ number_format($anggota->total_saldo ?? 0, 0, ',', '.') }}
                </div>
            </div>
            <div class="stat-footer">
                <span>Diperbarui: {{ date('d/m/Y') }}</span>
                <a href="{{ route('customer.simpanan') }}" class="stat-link">
                    Lihat Cuplikan Keuangan →
                </a>
            </div>
        </div>

        {{-- CARD 2: PINJAMAN --}}
        <div class="stat-card">
            <div>
                <div class="stat-card-header">
                    <div class="stat-icon-box">
                        <i data-lucide="credit-card"></i>
                    </div>
                    <div class="stat-label">• Total Pinjaman</div>
                </div>
                <div class="stat-value">
                    Rp0
                </div>
            </div>
            <div class="stat-footer">
                <span>Status: Aktif</span>
                <a href="{{ route('customer.pinjaman') }}" class="stat-link">
                    Detail Pinjaman →
                </a>
            </div>
        </div>

        {{-- CARD 3: STATUS KEANGGOTAAN --}}
        <div class="stat-card">
            <div>
                <div class="stat-card-header">
                    <div class="stat-icon-box">
                        <i data-lucide="user-check"></i>
                    </div>
                    <div class="stat-label">• Status Keanggotaan</div>
                </div>
                <div class="stat-value text-emerald-600">
                    Aktif
                </div>
            </div>
            <div class="stat-footer">
                <span>ID: {{ $anggota->id_anggota ?? 'N/A' }}</span>
                <a href="{{ route('customer.profil') }}" class="stat-link">
                    Profil Saya →
                </a>
            </div>
        </div>

    </div>

    {{-- INFORMASI ANGGOTA --}}
    <div class="section">
        <h2 class="section-title">
            <i data-lucide="user-check" class="w-5 h-5 text-blue-600"></i>
            <span>Informasi Anggota</span>
        </h2>

        @if($anggota)
            <div class="info-grid">
                <div class="info-item">
                    <span>ID Anggota</span>
                    <strong>{{ $anggota->id_anggota ?? '-' }}</strong>
                </div>

                <div class="info-item">
                    <span>Nama Lengkap</span>
                    <strong>{{ $anggota->nama ?? auth()->user()->nama_lengkap }}</strong>
                </div>

                <div class="info-item">
                    <span>No. HP</span>
                    <strong>{{ $anggota->no_hp ?? '-' }}</strong>
                </div>

                <div class="info-item" style="{{ !auth()->user()->no_rekening ? 'border-color: #BFDBFE; background: #EFF6FF;' : '' }}">
                    <span>No. Rekening</span>
                    <strong>
                        @if(auth()->user()->no_rekening)
                            {{ auth()->user()->nama_bank ? auth()->user()->nama_bank . ' - ' : '' }}{{ auth()->user()->no_rekening }}
                        @else
                            <a href="{{ route('customer.profil') }}" style="color: #2563EB; font-size: 13px; font-weight: 700; text-decoration: underline; display: inline-flex; align-items: center; gap: 4px;">
                                <i data-lucide="alert-circle" style="width: 14px; height: 14px;"></i>
                                <span>Belum Diisi</span>
                            </a>
                        @endif
                    </strong>
                </div>
            </div>
        @else
            <div class="empty">
                Data anggota belum terhubung dengan akun Anda.
            </div>
        @endif
    </div>

    {{-- RINGKASAN SIMPANAN --}}
    <div class="section">
        <h2 class="section-title">
            <i data-lucide="vault" class="w-5 h-5 text-blue-600"></i>
            <span>Ringkasan Simpanan</span>
        </h2>

        @if($anggota)
            <div class="saving-grid">
                <div class="saving-item">
                    <span>Simpanan Pokok</span>
                    <strong>Rp{{ number_format($anggota->simpanan_pokok ?? 0, 0, ',', '.') }}</strong>
                </div>

                <div class="saving-item">
                    <span>Simpanan Wajib</span>
                    <strong>Rp{{ number_format($anggota->simpanan_wajib ?? 0, 0, ',', '.') }}</strong>
                </div>

                <div class="saving-item">
                    <span>Simpanan Sukarela</span>
                    <strong>Rp{{ number_format($anggota->simpanan_sukarela ?? 0, 0, ',', '.') }}</strong>
                </div>
            </div>
        @else
            <div class="empty">
                Data simpanan belum tersedia.
            </div>
        @endif
    </div>

    {{-- RIWAYAT TRANSAKSI TERBARU --}}
    <div class="section">
        <div class="section-header-row">
            <h2 class="section-title" style="margin-bottom: 0;">
                <i data-lucide="history" class="w-5 h-5 text-blue-600"></i>
                <span>Riwayat Transaksi Terbaru</span>
            </h2>
            <a href="{{ route('customer.riwayat') }}" class="stat-link">
                Lihat Semua →
            </a>
        </div>

        @if(isset($transaksi) && $transaksi->count() > 0)
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis Transaksi</th>
                            <th>Nominal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @php
                                        $tgl = $item->tanggal_transaksi ?? $item->tanggal ?? $item->created_at;
                                    @endphp
                                    {{ $tgl ? \Carbon\Carbon::parse($tgl)->format('d-m-Y H:i') : '-' }}
                                </td>
                                <td>
                                    <strong>{{ $item->jenis_simpanan ?? $item->jenis ?? 'Simpanan' }}</strong>
                                </td>
                                <td>
                                    <strong style="color: #2563EB;">Rp{{ number_format($item->nominal ?? 0, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    <span class="badge-status">
                                        {{ $item->status ?? 'Berhasil' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty">
                Belum ada riwayat transaksi.
            </div>
        @endif
    </div>

@endsection