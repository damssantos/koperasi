<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiSimpanan extends Model
{
    protected $table = 'transaksi_simpanan';

    protected $fillable = [
        'anggota_id',
        'jenis_simpanan',
        'arah',
        'nominal',
        'status',
        'tanggal_transaksi',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'date',
    ];

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(AnggotaKoperasi::class, 'anggota_id');
    }
}
