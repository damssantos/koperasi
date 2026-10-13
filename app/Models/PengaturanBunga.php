<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanBunga extends Model
{
    protected $table = 'pengaturan_bunga';

    protected $fillable = ['kategori', 'persen_bunga'];

    protected $casts = ['persen_bunga' => 'float'];

    public const KATEGORI = ['Pegawai', 'Umum'];

    public static function persenUntuk(string $kategori): float
    {
        // Fallback default jika admin belum mengatur bunga
        $default = ['Pegawai' => 0.75, 'Umum' => 1.25][$kategori] ?? 0.0;

        $row = static::where('kategori', $kategori)->first();

        return $row ? (float) $row->persen_bunga : $default;
    }
}