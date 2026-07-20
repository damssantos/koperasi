<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JurnalKeuangan;
use App\Support\SimplePdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        [$dari, $sampai] = $this->periode($request);
        $rows = JurnalKeuangan::with('anggota:id,id_anggota,nama')->whereBetween('tanggal', [$dari, $sampai])->orderBy('tanggal')->get();
        return response()->json(['data' => ['periode' => ['dari' => $dari->toDateString(), 'sampai' => $sampai->toDateString()], 'ringkasan' => $this->ringkasan($rows), 'transaksi' => $rows]]);
    }

    public function export(Request $request, string $format)
    {
        abort_unless(in_array($format, ['csv', 'excel', 'pdf'], true), 404);
        [$dari, $sampai] = $this->periode($request);
        $rows = JurnalKeuangan::with('anggota:id,id_anggota,nama')->whereBetween('tanggal', [$dari, $sampai])->orderBy('tanggal')->get();
        $table = $rows->map(fn ($item) => [$item->tanggal->format('Y-m-d H:i'), $item->jenis, $item->arah, $item->anggota?->id_anggota ?? '-', $item->anggota?->nama ?? '-', $item->nomor_bukti ?? '-', $item->keterangan ?? '-', $item->nominal])->all();
        $name = 'laporan-keuangan-' . $dari->format('Ymd') . '-' . $sampai->format('Ymd');
        if ($format === 'pdf') return response(SimplePdf::table('Laporan Keuangan', ['Tanggal', 'Jenis', 'Arah', 'ID Anggota', 'Anggota', 'Bukti', 'Keterangan', 'Nominal'], $table, ['Periode: ' . $dari->format('d-m-Y') . ' s.d. ' . $sampai->format('d-m-Y')]), 200, ['Content-Type' => 'application/pdf', 'Content-Disposition' => "attachment; filename=\"$name.pdf\""]);
        $stream = fopen('php://temp', 'r+'); fputcsv($stream, ['Tanggal', 'Jenis', 'Arah', 'ID Anggota', 'Anggota', 'Nomor Bukti', 'Keterangan', 'Nominal']); foreach ($table as $line) fputcsv($stream, $line); rewind($stream); $contents = "\xEF\xBB\xBF" . stream_get_contents($stream);
        $extension = $format === 'excel' ? 'xls' : 'csv';
        return response($contents, 200, ['Content-Type' => $format === 'excel' ? 'application/vnd.ms-excel; charset=UTF-8' : 'text/csv; charset=UTF-8', 'Content-Disposition' => "attachment; filename=\"$name.$extension\""]);
    }

    private function periode(Request $request): array
    {
        $data = $request->validate(['dari' => ['nullable', 'date'], 'sampai' => ['nullable', 'date', 'after_or_equal:dari']]);
        return [isset($data['dari']) ? now()->parse($data['dari'])->startOfDay() : now()->startOfMonth(), isset($data['sampai']) ? now()->parse($data['sampai'])->endOfDay() : now()->endOfDay()];
    }

    private function ringkasan($rows): array
    {
        $masuk = (int) $rows->where('arah', 'MASUK')->sum('nominal'); $keluar = (int) $rows->where('arah', 'KELUAR')->sum('nominal');
        return ['pemasukan' => $masuk, 'pengeluaran' => $keluar, 'saldo_periode' => $masuk - $keluar, 'jumlah_transaksi' => $rows->count()];
    }
}
