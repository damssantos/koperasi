<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PembayaranCicilan;
use App\Models\Pinjaman;
use App\Services\AuditService;
use App\Services\LedgerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranCicilanController extends Controller
{
    public function index(Pinjaman $pinjaman)
    {
        return response()->json(['data' => $pinjaman->pembayaranCicilan()->with('pencatat:id,nama_lengkap,email')->latest('tanggal_pembayaran')->paginate(20)]);
    }

    public function store(Request $request, Pinjaman $pinjaman)
    {
        $data = $request->validate([
            'tanggal_pembayaran' => ['required', 'date'], 'nominal_pokok' => ['required', 'integer', 'min:1'],
            'denda' => ['nullable', 'integer', 'min:0'], 'metode_pembayaran' => ['required', 'in:Tunai,Transfer,QRIS'],
            'keterangan' => ['nullable', 'string', 'max:1000'], 'bukti_bayar' => ['nullable', 'string', 'max:255'],
        ]);
        if (in_array($pinjaman->status, ['Lunas', 'Dibatalkan'], true)) return response()->json(['message' => 'Pinjaman tidak dapat menerima pembayaran.'], 422);
        if ($data['nominal_pokok'] > $pinjaman->sisa_pinjaman) return response()->json(['message' => 'Nominal pokok melebihi sisa pinjaman.'], 422);

        $payment = DB::transaction(function () use ($data, $pinjaman) {
            $payment = PembayaranCicilan::create($data + ['pinjaman_id' => $pinjaman->id, 'denda' => $data['denda'] ?? 0, 'nomor_bukti' => 'ANG-' . now()->format('Ymd') . '-' . strtoupper(str()->random(6)), 'dicatat_oleh' => request()->user()->id]);
            $sisa = $pinjaman->sisa_pinjaman - $payment->nominal_pokok;
            $pinjaman->update(['jumlah_cicilan_dibayar' => $pinjaman->jumlah_cicilan_dibayar + 1, 'sisa_pinjaman' => $sisa, 'status' => $sisa === 0 ? 'Lunas' : 'Aktif', 'diperbarui_oleh' => request()->user()->id]);
            LedgerService::catat($payment, 'ANGSURAN_PINJAMAN', 'MASUK', $payment->nominal_pokok + $payment->denda, $pinjaman->anggota_id, $payment->nomor_bukti, $payment->keterangan);
            AuditService::catat('catat_pembayaran_cicilan', $payment, null, $payment->toArray());
            return $payment;
        });
        return response()->json(['data' => $payment->fresh('pinjaman.anggota')], 201);
    }

    public function update(Request $request, PembayaranCicilan $pembayaran)
    {
        $data = $request->validate(['tanggal_pembayaran' => ['required', 'date'], 'metode_pembayaran' => ['required', 'in:Tunai,Transfer,QRIS'], 'denda' => ['required', 'integer', 'min:0'], 'keterangan' => ['nullable', 'string', 'max:1000'], 'bukti_bayar' => ['nullable', 'string', 'max:255']]);
        $before = $pembayaran->toArray(); $pembayaran->update($data);
        LedgerService::catat($pembayaran, 'ANGSURAN_PINJAMAN', 'MASUK', $pembayaran->nominal_pokok + $pembayaran->denda, $pembayaran->pinjaman->anggota_id, $pembayaran->nomor_bukti, $pembayaran->keterangan);
        AuditService::catat('ubah_pembayaran_cicilan', $pembayaran, $before, $pembayaran->fresh()->toArray());
        return response()->json(['data' => $pembayaran->fresh()]);
    }
}
