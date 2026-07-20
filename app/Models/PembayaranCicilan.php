<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembayaranCicilan extends Model
{
    protected $table = 'pembayaran_cicilan';
    protected $fillable = ['pinjaman_id', 'tanggal_pembayaran', 'nominal_pokok', 'denda', 'metode_pembayaran', 'nomor_bukti', 'bukti_bayar', 'keterangan', 'dicatat_oleh'];
    protected $casts = ['tanggal_pembayaran' => 'date'];

    public function pinjaman(): BelongsTo { return $this->belongsTo(Pinjaman::class); }
    public function pencatat(): BelongsTo { return $this->belongsTo(User::class, 'dicatat_oleh'); }
}
