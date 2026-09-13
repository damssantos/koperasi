<?php

namespace App\Imports;

use App\Models\AnggotaKoperasi;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class AnggotaImport implements ToCollection, WithHeadingRow
{
    public int $jumlahBerhasil = 0;
    public int $jumlahDilewati = 0;

    public function collection(\Illuminate\Support\Collection $rows)
    {
        foreach ($rows as $row) {

            $idAnggota = trim((string) ($row['id_anggota'] ?? ''));
            $nama = trim((string) ($row['nama'] ?? ''));

            // Lewati baris kosong
            if ($idAnggota === '' || $nama === '') {
                $this->jumlahDilewati++;
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Format tanggal
            |--------------------------------------------------------------------------
            */

            $tanggalJoin = null;

            if (!empty($row['tanggal_join'])) {

                try {

                    if (is_numeric($row['tanggal_join'])) {

                        $tanggalJoin = Carbon::instance(
                            ExcelDate::excelToDateTimeObject(
                                $row['tanggal_join']
                            )
                        )->format('Y-m-d');

                    } else {

                        $tanggalJoin = Carbon::parse(
                            $row['tanggal_join']
                        )->format('Y-m-d');
                    }

                } catch (\Throwable $e) {

                    $tanggalJoin = null;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan ke database
            |--------------------------------------------------------------------------
            |
            | updateOrCreate:
            | - Kalau ID belum ada -> buat anggota baru
            | - Kalau ID sudah ada -> update data anggota
            |
            */

            AnggotaKoperasi::updateOrCreate(
                [
                    'id_anggota' => $idAnggota,
                ],
                [
                    'nama' => $nama,

                    'no_hp' => !empty($row['no_hp'])
                        ? trim((string) $row['no_hp'])
                        : null,

                    'tanggal_join' => $tanggalJoin,

                    // Jangan menimpa saldo yang sudah ada
                ]
            );

            $this->jumlahBerhasil++;
        }
    }
}