<?php

namespace App\Exports;

use App\Models\Pinjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PinjamanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Pinjaman::with('anggota')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($loan, $index) {
                return [
                    $index + 1,
                    'PJ-' . str_pad($loan->id, 5, '0', STR_PAD_LEFT),
                    $loan->anggota->id_anggota ?? '-',
                    $loan->anggota->nama ?? '-',
                    $loan->nominal_pinjaman,
                    $loan->tenor,
                    $loan->jumlah_cicilan_dibayar,
                    $loan->sisa_pinjaman,
                    $loan->tanggal_pengajuan?->format('Y-m-d'),
                    $loan->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'ID Pinjaman',
            'ID Anggota',
            'Nama Anggota',
            'Nominal Pinjaman',
            'Tenor',
            'Cicilan Dibayar',
            'Sisa Pinjaman',
            'Tanggal Pengajuan',
            'Status',
        ];
    }
}