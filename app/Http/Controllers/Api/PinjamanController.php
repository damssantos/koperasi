<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use App\Services\AuditService;
use App\Services\LedgerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PinjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pinjaman::with('anggota:id,id_anggota,nama')->latest('tanggal_pengajuan')->latest('id');
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('anggota_id')) $query->where('anggota_id', $request->anggota_id);
        return response()->json(['data' => $query->paginate(min((int) $request->input('per_page', 20), 100))]);
    }

    public function update(Request $request, Pinjaman $pinjaman)
    {
        if ($pinjaman->jumlah_cicilan_dibayar > 0) return response()->json(['message' => 'Pinjaman yang telah dicicil tidak dapat diubah nominal atau tenor.'], 422);
        $data = $request->validate(['nominal_pinjaman' => ['required', 'integer', 'min:1000'], 'tenor' => ['required', 'integer', 'min:1', 'max:360'], 'tanggal_pengajuan' => ['required', 'date'], 'keterangan' => ['nullable', 'string', 'max:1000'], 'status' => ['required', 'in:Aktif,Menunggak']]);
        $before = $pinjaman->toArray();
        DB::transaction(function () use ($pinjaman, $data) {
            $pinjaman->update($data + ['sisa_pinjaman' => $data['nominal_pinjaman'], 'diperbarui_oleh' => request()->user()->id]);
            LedgerService::catat($pinjaman, 'PENCAIRAN_PINJAMAN', 'KELUAR', $pinjaman->nominal_pinjaman, $pinjaman->anggota_id, 'PJC-' . str_pad((string) $pinjaman->id, 6, '0', STR_PAD_LEFT), $pinjaman->keterangan);
        });
        AuditService::catat('ubah_pinjaman', $pinjaman, $before, $pinjaman->fresh()->toArray());
        return response()->json(['data' => $pinjaman->fresh('anggota')]);
    }

    public function batalkan(Request $request, Pinjaman $pinjaman)
    {
        $data = $request->validate(['alasan_pembatalan' => ['required', 'string', 'max:1000']]);
        if ($pinjaman->jumlah_cicilan_dibayar > 0) return response()->json(['message' => 'Pinjaman yang telah memiliki pembayaran tidak dapat dibatalkan.'], 422);
        $before = $pinjaman->toArray();
        $pinjaman->update(['status' => 'Dibatalkan', 'dibatalkan_pada' => now(), 'alasan_pembatalan' => $data['alasan_pembatalan'], 'diperbarui_oleh' => $request->user()->id]);
        AuditService::catat('batalkan_pinjaman', $pinjaman, $before, $pinjaman->fresh()->toArray());
        return response()->json(['data' => $pinjaman->fresh()]);
    }
}
