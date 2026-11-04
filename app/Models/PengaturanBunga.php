<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanBunga extends Model
{
    protected $table = 'pengaturan_bunga';

    protected $fillable = ['kategori', 'persen_bunga', 'limit_nominal', 'denda_persen'];

    protected $casts = ['persen_bunga' => 'float', 'denda_persen' => 'float'];

    public const KATEGORI = ['Pegawai', 'Umum'];

    public static function persenUntuk(string $kategori): float
    {
        // Fallback default jika admin belum mengatur bunga
        $default = ['Pegawai' => 0.75, 'Umum' => 1.25][$kategori] ?? 0.0;

        $row = static::where('kategori', $kategori)->first();

        return $row ? (float) $row->persen_bunga : $default;
    }

    /** Limit pinjaman per kategori. 0 = tanpa limit. */
    public static function limitUntuk(string $kategori): int
    {
        return (int) (static::where('kategori', $kategori)->value('limit_nominal') ?? 0);
    }

    /** Persen denda per bulan keterlambatan. */
    public static function dendaPersenUntuk(string $kategori): float
    {
        return (float) (static::where('kategori', $kategori)->value('denda_persen') ?? 0);
    }
}