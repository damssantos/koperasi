<?php

namespace App\Imports;

use App\Models\AnggotaKoperasi;
use App\Models\Pinjaman;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PinjamanImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Cari anggota berdasarkan ID anggota
        $anggota = AnggotaKoperasi::where('id_anggota', trim($row['id_anggota'] ?? ''))
            ->first();

        // Kalau anggota tidak ditemukan, jangan masukkan data
        if (!$anggota) {
            return null;
        }

        $nominal = (int) $row['nominal_pinjaman'];
        $tenor = (int) $row['tenor'];

        return new Pinjaman([
            'anggota_id' => $anggota->id,

            'nominal_pinjaman' => $nominal,

            'tenor' => $tenor,

            // Data awal otomatis
            'jumlah_cicilan_dibayar' => 0,

            // Sisa pinjaman = nominal awal
            'sisa_pinjaman' => $nominal,

            'tanggal_pengajuan' => Carbon::parse($row['tanggal_pengajuan']),

            // Status awal sistem
            'status' => 'Aktif',
        ]);
    }

    public function rules(): array
    {
        return [
            'id_anggota' => [
                'required',
                'string',
            ],

            'nominal_pinjaman' => [
                'required',
                'integer',
                'min:1000',
            ],

            'tenor' => [
                'required',
                'integer',
                'min:1',
            ],

            'tanggal_pengajuan' => [
                'required',
                'date',
            ],
        ];
    }
}