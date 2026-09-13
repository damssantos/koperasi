<?php

namespace App\Exports;

use App\Models\TransaksiSimpanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SimpananExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return TransaksiSimpanan::with('anggota')
            ->orderBy('tanggal_transaksi', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($transaksi, $index) {

                return [
                    $index + 1,

                    'SP-' . str_pad(
                        $transaksi->id,
                        5,
                        '0',
                        STR_PAD_LEFT
                    ),

                    $transaksi->anggota->id_anggota ?? '-',

                    $transaksi->anggota->nama ?? '-',

                    $transaksi->jenis_simpanan,

                    $transaksi->nominal,

                    $transaksi->tanggal_transaksi
                        ? $transaksi->tanggal_transaksi->format('Y-m-d')
                        : null,

                    $transaksi->status,

                    $transaksi->keterangan ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'ID Simpanan',
            'ID Anggota',
            'Nama Anggota',
            'Jenis Simpanan',
            'Nominal',
            'Tanggal Transaksi',
            'Status',
            'Keterangan',
        ];
    }
}