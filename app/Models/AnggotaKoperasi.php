<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaKoperasi extends Model
{
    protected $table = 'anggota_koperasi';
    protected $fillable = ['nama', 'simpanan_pokok', 'simpanan_wajib', 'simpanan_sukarela', 'total_saldo'];
}