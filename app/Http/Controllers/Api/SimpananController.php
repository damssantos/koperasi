<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKoperasi;
use App\Models\TransaksiSimpanan;
use App\Services\AuditService;
use App\Services\LedgerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimpananController extends Controller
{
    public function index(Request $request)
    {
        $query = TransaksiSimpanan::with('anggota:id,id_anggota,nama')->latest('tanggal_transaksi')->latest('id');
        foreach (['anggota_id', 'jenis_simpanan', 'arah'] as $field) if ($request->filled($field)) $query->where($field, $request->$field);
        if ($request->filled('dari')) $query->whereDate('tanggal_transaksi', '>=', $request->dari);
        if ($request->filled('sampai')) $query->whereDate('tanggal_transaksi', '<=', $request->sampai);
        return response()->json(['data' => $query->paginate(min((int) $request->input('per_page', 20), 100))]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['anggota_id' => ['required', 'exists:anggota_koperasi,id'], 'jenis_simpanan' => ['required', 'in:Pokok,Wajib,Sukarela'], 'nominal' => ['required', 'integer', 'min:1000'], 'tanggal_transaksi' => ['required', 'date'], 'keterangan' => ['nullable', 'string', 'max:1000']]);
        return response()->json(['data' => $this->simpan($data, 'MASUK')], 201);
    }

    public function tarik(Request $request)
    {
        $data = $request->validate(['anggota_id' => ['required', 'exists:anggota_koperasi,id'], 'jenis_simpanan' => ['required', 'in:Pokok,Wajib,Sukarela'], 'nominal' => ['required', 'integer', 'min:1000'], 'tanggal_transaksi' => ['required', 'date'], 'keterangan' => ['required', 'string', 'max:1000']]);
        $member = AnggotaKoperasi::findOrFail($data['anggota_id']);
        $field = 'simpanan_' . strtolower($data['jenis_simpanan']);
        if ($member->$field < $data['nominal']) return response()->json(['message' => 'Saldo simpanan tidak mencukupi.'], 422);
        return response()->json(['data' => $this->simpan($data, 'KELUAR')], 201);
    }

    private function simpan(array $data, string $arah): TransaksiSimpanan
    {
        return DB::transaction(function () use ($data, $arah) {
            $member = AnggotaKoperasi::lockForUpdate()->findOrFail($data['anggota_id']);
            $field = 'simpanan_' . strtolower($data['jenis_simpanan']);
            if ($arah === 'KELUAR' && $member->$field < $data['nominal']) abort(422, 'Saldo simpanan tidak mencukupi.');
            $member->$field += $arah === 'MASUK' ? $data['nominal'] : -$data['nominal'];
            $member->total_saldo = $member->simpanan_pokok + $member->simpanan_wajib + $member->simpanan_sukarela;
            $member->save();
            $tx = TransaksiSimpanan::create($data + ['arah' => $arah, 'status' => 'Aktif']);
            $bukti = ($arah === 'MASUK' ? 'SMP' : 'TRK') . '-' . now()->format('Ymd') . '-' . str_pad((string) $tx->id, 6, '0', STR_PAD_LEFT);
            LedgerService::catat($tx, $arah === 'MASUK' ? 'SETORAN_SIMPANAN' : 'PENARIKAN_SIMPANAN', $arah, $tx->nominal, $tx->anggota_id, $bukti, $tx->keterangan);
            AuditService::catat($arah === 'MASUK' ? 'catat_setoran_simpanan' : 'catat_penarikan_simpanan', $tx, null, $tx->toArray());
            return $tx->fresh('anggota');
        });
    }
}
