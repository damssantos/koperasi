<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiKasUsaha extends Model
{
    protected $table = 'transaksi_kas_usaha';

    protected $fillable = [
        'tanggal',
        'jenis_transaksi',
        'keterangan',
        'nominal',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];
}
