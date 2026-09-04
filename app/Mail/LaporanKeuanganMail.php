<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LaporanKeuanganMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $periode;

    protected string $pdfData;
    protected string $namaFile;

    public function __construct(
        string $periode,
        string $pdfData,
        string $namaFile
    ) {
        $this->periode = $periode;
        $this->pdfData = $pdfData;
        $this->namaFile = $namaFile;
    }

    public function build()
    {
        return $this
            ->subject('Laporan Keuangan SOY YPIK PAM JAYA')
            ->view('auth.emails.laporan-keuangan')
            ->with([
                'periode' => $this->periode,
            ])
            ->attachData(
                $this->pdfData,
                $this->namaFile,
                [
                    'mime' => 'application/pdf',
                ]
            );
    }
}