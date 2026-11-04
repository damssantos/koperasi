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
        'denda',
        'potongan_admin',
        'bukti_potongan',
        'jumlah_cicilan_dibayar',
        'sisa_pinjaman',
        'tanggal_pengajuan',
        'tanggal_pelunasan',
        'bukti_transfer',
        'status',
        'status_persetujuan',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
    ];

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(AnggotaKoperasi::class, 'anggota_id');
    }

    /**
     * Denda otomatis: hitung bulan telat dari jatuh tempo cicilan berikutnya
     * (tanggal_pengajuan + cicilan_dibayar + 1 bulan). Denda per bulan =
     * nominal cicilan * denda_persen kategori debitur.
     */
    public function hitungDenda(): int
    {
        if (!in_array($this->status, ['Aktif', 'Menunggak'])) {
            return 0;
        }

        $persen = PengaturanBunga::dendaPersenUntuk($this->kategori_debitur);
        if ($persen <= 0) {
            return 0;
        }

        $jatuhTempo = \Carbon\Carbon::parse($this->tanggal_pengajuan)
            ->addMonths($this->jumlah_cicilan_dibayar + 1);

        $bulanTelat = (int) floor($jatuhTempo->startOfDay()->diffInMonths(now()->startOfDay(), false));

        if ($bulanTelat <= 0) {
            return 0;
        }

        $remainingMonths = max(1, $this->tenor - $this->jumlah_cicilan_dibayar);
        $cicilan = round(($this->sisa_pinjaman - $this->denda) / $remainingMonths);

        return (int) ($bulanTelat * round($cicilan * ($persen / 100)));
    }

    /** Sinkronkan kolom denda + status Menunggak dengan hasil hitungan. Idempoten. */
    public function sinkronDenda(): void
    {
        if (!in_array($this->status, ['Aktif', 'Menunggak'])) {
            return;
        }

        $dendaBaru = $this->hitungDenda();
        $telat = $dendaBaru > 0;

        $this->update([
            'denda' => $dendaBaru,
            // sisa = pokok sisa (tanpa denda) + denda
            'sisa_pinjaman' => max(0, ($this->sisa_pinjaman - $this->denda) + $dendaBaru),
            'status' => $telat ? 'Menunggak' : 'Aktif',
        ]);
    }
}
