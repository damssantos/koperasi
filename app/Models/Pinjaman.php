<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pinjaman extends Model
{
    protected $table = 'pinjaman';

    protected $fillable = [
        'anggota_id',
        'nominal_pinjaman',
        'tenor',
        'kategori_debitur',
        'persentase_bunga',
        'total_bunga',
        'jumlah_cicilan_dibayar',
        'sisa_pinjaman',
        'tanggal_pengajuan',
        'tanggal_pelunasan',
        'bukti_transfer',
        'status',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
    ];

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(AnggotaKoperasi::class, 'anggota_id');
    }
}
