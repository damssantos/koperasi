<?php

namespace App\Imports;

use App\Models\AnggotaKoperasi;
use App\Models\TransaksiSimpanan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class SimpananImport implements ToCollection, WithHeadingRow
{
    public int $jumlahBerhasil = 0;

    public int $jumlahDilewati = 0;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            /*
            |--------------------------------------------------------------------------
            | Ambil data Excel
            |--------------------------------------------------------------------------
            */

            $idAnggota = trim(
                (string) ($row['id_anggota'] ?? '')
            );

            $jenisSimpanan = trim(
                (string) ($row['jenis_simpanan'] ?? '')
            );

            $nominal = $row['nominal'] ?? null;

            $tanggalTransaksi = $row['tanggal_transaksi'] ?? null;

            $status = trim(
                (string) ($row['status'] ?? 'Aktif')
            );

            $keterangan = trim(
                (string) ($row['keterangan'] ?? '')
            );

            /*
            |--------------------------------------------------------------------------
            | Lewati baris kosong
            |--------------------------------------------------------------------------
            */

            if (
                $idAnggota === '' &&
                $jenisSimpanan === '' &&
                empty($nominal) &&
                empty($tanggalTransaksi)
            ) {
                $this->jumlahDilewati++;
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Cari anggota berdasarkan ID Anggota
            |--------------------------------------------------------------------------
            */

            $anggota = AnggotaKoperasi::where(
                'id_anggota',
                $idAnggota
            )->first();

            if (!$anggota) {
                throw new \Exception(
                    "ID Anggota {$idAnggota} tidak ditemukan di database."
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Validasi jenis simpanan
            |--------------------------------------------------------------------------
            */

            if (!in_array(
                $jenisSimpanan,
                ['Pokok', 'Wajib', 'Sukarela']
            )) {
                throw new \Exception(
                    "Jenis simpanan '{$jenisSimpanan}' tidak valid untuk anggota {$idAnggota}. Gunakan: Pokok, Wajib, atau Sukarela."
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Validasi nominal
            |--------------------------------------------------------------------------
            */

            $nominal = (int) $nominal;

            if ($nominal < 1000) {
                throw new \Exception(
                    "Nominal simpanan untuk {$idAnggota} minimal Rp1.000."
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Validasi status
            |--------------------------------------------------------------------------
            */

            if (!in_array(
                $status,
                ['Aktif', 'Lunas']
            )) {
                throw new \Exception(
                    "Status '{$status}' tidak valid untuk anggota {$idAnggota}. Gunakan: Aktif atau Lunas."
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Format tanggal
            |--------------------------------------------------------------------------
            */

            $tanggal = null;

            if (!empty($tanggalTransaksi)) {

                try {

                    if (is_numeric($tanggalTransaksi)) {

                        $tanggal = Carbon::instance(
                            ExcelDate::excelToDateTimeObject(
                                $tanggalTransaksi
                            )
                        )->format('Y-m-d');

                    } else {

                        $tanggal = Carbon::parse(
                            $tanggalTransaksi
                        )->format('Y-m-d');
                    }

                } catch (\Throwable $e) {

                    throw new \Exception(
                        "Tanggal transaksi pada anggota {$idAnggota} tidak valid."
                    );
                }

            } else {

                throw new \Exception(
                    "Tanggal transaksi untuk {$idAnggota} wajib diisi."
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan transaksi
            |--------------------------------------------------------------------------
            */

            TransaksiSimpanan::create([
                'anggota_id' => $anggota->id,
                'jenis_simpanan' => $jenisSimpanan,
                'nominal' => $nominal,
                'tanggal_transaksi' => $tanggal,
                'status' => $status,
                'keterangan' => $keterangan !== ''
                    ? $keterangan
                    : null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Update saldo anggota
            |--------------------------------------------------------------------------
            */

            $field = match ($jenisSimpanan) {

                'Pokok' => 'simpanan_pokok',

                'Wajib' => 'simpanan_wajib',

                'Sukarela' => 'simpanan_sukarela',
            };

            $anggota->{$field} =
                (int) $anggota->{$field} + $nominal;

            $anggota->total_saldo =
                (int) $anggota->simpanan_pokok
                + (int) $anggota->simpanan_wajib
                + (int) $anggota->simpanan_sukarela;

            $anggota->save();

            $this->jumlahBerhasil++;
        }
    }
}