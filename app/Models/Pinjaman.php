<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pinjaman extends Model
{
    protected $table = 'pinjaman';

    protected $fillable = [
        'anggota_id',
        'nominal_pinjaman',
        'tenor',
        'jumlah_cicilan_dibayar',
        'sisa_pinjaman',
        'tanggal_pengajuan',
        'status',
        'keterangan',
        'status_persetujuan',
        'tanggal_pencairan',
        'dibatalkan_pada',
        'alasan_pembatalan',
        'dibuat_oleh',
        'diperbarui_oleh',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_pencairan' => 'datetime',
        'dibatalkan_pada' => 'datetime',
    ];

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(AnggotaKoperasi::class, 'anggota_id');
    }

    public function pembayaranCicilan(): HasMany
    {
        return $this->hasMany(PembayaranCicilan::class);
    }
}
