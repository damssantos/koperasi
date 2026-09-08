<?php

namespace App\Services;

use App\Models\JurnalKeuangan;
use Illuminate\Database\Eloquent\Model;

class LedgerService
{
    public static function catat(Model $sumber, string $jenis, string $arah, int $nominal, ?int $anggotaId, string $nomorBukti, ?string $keterangan = null): JurnalKeuangan
    {
        return JurnalKeuangan::updateOrCreate(
            ['referensi_tipe' => $sumber::class, 'referensi_id' => $sumber->getKey()],
            [
                'tanggal' => $sumber->tanggal_pembayaran ?? $sumber->tanggal_transaksi ?? $sumber->tanggal_pengajuan ?? $sumber->tanggal ?? now(),
                'jenis' => $jenis,
                'arah' => $arah,
                'nominal' => $nominal,
                'nomor_bukti' => $nomorBukti,
                'keterangan' => $keterangan,
                'anggota_id' => $anggotaId,
                'dicatat_oleh' => auth()->id(),
            ]
        );
    }
}
