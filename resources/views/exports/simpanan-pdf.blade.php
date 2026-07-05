<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Simpanan Koperasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #fff;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .text-right {
            text-align: right;
        }
        .footer-summary {
            margin-top: 20px;
            font-weight: bold;
            font-size: 13px;
            text-align: right;
            padding-right: 10px;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px; padding: 10px; background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; display: flex; justify-content: space-between; align-items: center;">
        <span>Pratinjau Cetak Laporan Simpanan. Tekan Ctrl+P jika dialog print tidak muncul otomatis.</span>
        <button onclick="window.print()" style="padding: 6px 12px; background-color: #2f54eb; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Cetak Sekarang</button>
    </div>

    <div class="header">
        <h1>Laporan Simpanan Koperasi</h1>
        <p>KOPERASI KARYAWAN SOY YPIK PAM JAYA</p>
        <p>Tanggal Cetak: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Anggota</th>
                <th>Nama Lengkap</th>
                <th class="text-right">Simpanan Pokok</th>
                <th class="text-right">Simpanan Wajib</th>
                <th class="text-right">Simpanan Sukarela</th>
                <th class="text-right">Total Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($anggota as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->id_anggota ?? 'AGT-' . str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td><strong>{{ $item->nama }}</strong></td>
                    <td class="text-right">Rp {{ number_format($item->simpanan_pokok, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->simpanan_wajib, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->simpanan_sukarela, 0, ',', '.') }}</td>
                    <td class="text-right"><strong>Rp {{ number_format($item->total_saldo, 0, ',', '.') }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer-summary" style="display: flex; flex-direction: column; align-items: flex-end; gap: 4px;">
        <div>Total Simpanan Pokok: Rp {{ number_format($anggota->sum('simpanan_pokok'), 0, ',', '.') }}</div>
        <div>Total Simpanan Wajib: Rp {{ number_format($anggota->sum('simpanan_wajib'), 0, ',', '.') }}</div>
        <div>Total Simpanan Sukarela: Rp {{ number_format($anggota->sum('simpanan_sukarela'), 0, ',', '.') }}</div>
        <div style="margin-top: 10px; border-top: 1.5px solid #333; padding-top: 5px; font-size: 14px;">Total Akumulasi Simpanan: Rp {{ number_format($anggota->sum('total_saldo'), 0, ',', '.') }}</div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
