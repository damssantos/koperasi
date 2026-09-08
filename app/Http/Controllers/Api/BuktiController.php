<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JurnalKeuangan;
use App\Support\SimplePdf;

class BuktiController extends Controller
{
    public function show(JurnalKeuangan $jurnal)
    {
        $rows = [['Nomor bukti', $jurnal->nomor_bukti ?? '-'], ['Tanggal', $jurnal->tanggal->format('d-m-Y H:i')], ['Jenis', $jurnal->jenis], ['Arah', $jurnal->arah], ['Nominal', 'Rp ' . number_format($jurnal->nominal, 0, ',', '.')], ['Keterangan', $jurnal->keterangan ?? '-']];
        return response(SimplePdf::table('Bukti Transaksi Koperasi', ['Keterangan', 'Nilai'], $rows), 200, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'attachment; filename="' . ($jurnal->nomor_bukti ?? 'bukti-transaksi') . '.pdf"']);
    }
}
