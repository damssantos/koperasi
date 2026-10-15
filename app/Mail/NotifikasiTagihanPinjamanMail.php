<?php

namespace App\Mail;

use App\Models\Pinjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifikasiTagihanPinjamanMail extends Mailable
{
    use Queueable, SerializesModels;

    public Pinjaman $pinjaman;
    public int $nominalCicilan;
    public int $cicilanKe;
    public ?string $catatanTambahan;

    public function __construct(
        Pinjaman $pinjaman,
        int $nominalCicilan,
        int $cicilanKe,
        ?string $catatanTambahan = null
    ) {
        $this->pinjaman = $pinjaman;
        $this->nominalCicilan = $nominalCicilan;
        $this->cicilanKe = $cicilanKe;
        $this->catatanTambahan = $catatanTambahan;
    }

    public function build()
    {
        $idFormatted = 'PJ-' . str_pad($this->pinjaman->id, 5, '0', STR_PAD_LEFT);

        return $this
            ->subject('Pengingat Pembayaran Cicilan Pinjaman (' . $idFormatted . ') - SOY YPIK PAM JAYA')
            ->view('auth.emails.notifikasi-tagihan')
            ->with([
                'pinjaman' => $this->pinjaman,
                'anggota' => $this->pinjaman->anggota,
                'nominalCicilan' => $this->nominalCicilan,
                'cicilanKe' => $this->cicilanKe,
                'catatanTambahan' => $this->catatanTambahan,
            ]);
    }
}
