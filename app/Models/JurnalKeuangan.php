<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalKeuangan extends Model
{
    protected $table = 'jurnal_keuangan';
    protected $fillable = ['tanggal', 'jenis', 'arah', 'nominal', 'referensi_tipe', 'referensi_id', 'nomor_bukti', 'keterangan', 'anggota_id', 'dicatat_oleh'];
    protected $casts = ['tanggal' => 'datetime'];
}
