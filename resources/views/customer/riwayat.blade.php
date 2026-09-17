@extends('customer.layouts.app')

@section('title', 'Riwayat Transaksi')

@section('page-title', 'Riwayat Transaksi')

@section('page-description', 'Riwayat aktivitas transaksi simpanan Anda')

@section('content')

    <style>
        .history-card {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 25px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.03);
        }

        .history-header {
            margin-bottom: 22px;
        }

        .history-header h2 {
            font-size: 18px;
            font-weight: 700;
            color: #1F2937;
            margin-bottom: 4px;
        }

        .history-header p {
            color: #64748B;
            font-size: 13px;
        }

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

        .empty {
            text-align: center;
            padding: 40px 20px;
            color: #64748B;
            font-size: 14px;
        }
    </style>


    <div class="history-card">


        <div class="history-header">

            <h2>
                Semua Riwayat Transaksi
            </h2>

            <p>
                Menampilkan transaksi yang terhubung dengan akun Anda.
            </p>

        </div>


        @if($transaksi && $transaksi->count() > 0)

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>
                                No
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                Jenis Transaksi
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

                                        <td>
                                            {{ $loop->iteration }}
                                        </td>


                                        <td>

                                            @if($item->tanggal)

                                                            {{ \Carbon\Carbon::parse(
                                                    $item->tanggal
                                                )->format('d-m-Y') }}

                                            @else

                                                -

                                            @endif

                                        </td>


                                        <td>
                                            {{ $item->jenis ?? '-' }}
                                        </td>


                                        <td>

                                            Rp{{ number_format(
                                $item->nominal ?? 0,
                                0,
                                ',',
                                '.'
                            ) }}

                                        </td>


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

                Belum ada riwayat transaksi.

            </div>

        @endif


    </div>

@endsection