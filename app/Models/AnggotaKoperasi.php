<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaKoperasi extends Model
{
    protected $table = 'anggota_koperasi';
    protected $fillable = [
        'id_anggota',
        'nama',
        'no_hp',
        'tanggal_join',
        'simpanan_pokok',
        'simpanan_wajib',
        'simpanan_sukarela',
        'total_saldo',
    ];

    protected $casts = [
        'tanggal_join' => 'date',
    ];

    public function transactions()
    {
        return $this->hasMany(TransaksiSimpanan::class, 'anggota_id');
    }
}
