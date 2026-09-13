<?php

namespace App\Exports;

use App\Models\AnggotaKoperasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AnggotaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return AnggotaKoperasi::orderBy('id_anggota', 'asc')
            ->get()
            ->map(function ($anggota, $index) {
                return [
                    $index + 1,
                    $anggota->id_anggota,
                    $anggota->nama,
                    $anggota->no_hp ?? '-',
                    $anggota->tanggal_join?->format('Y-m-d'),
                    $anggota->simpanan_pokok ?? 0,
                    $anggota->simpanan_wajib ?? 0,
                    $anggota->simpanan_sukarela ?? 0,
                    $anggota->total_saldo ?? 0,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'ID Anggota',
            'Nama',
            'No HP',
            'Tanggal Join',
            'Simpanan Pokok',
            'Simpanan Wajib',
            'Simpanan Sukarela',
            'Total Saldo',
        ];
    }
}