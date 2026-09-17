@extends('customer.layouts.app')

@section('title', 'Riwayat Transaksi')

@section('page-title', 'Riwayat Transaksi')

@section('page-description', 'Riwayat aktivitas transaksi simpanan Anda')

@section('content')

    <style>
        .history-card {
            background: white;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }

        .history-header {
            margin-bottom: 22px;
        }

        .history-header h2 {
            font-size: 19px;
            margin-bottom: 5px;
        }

        .history-header p {
            color: #777;
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

        .badge {
            display: inline-block;

            padding: 6px 10px;

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

        .empty {
            text-align: center;

            padding: 40px 20px;

            color: #888;

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