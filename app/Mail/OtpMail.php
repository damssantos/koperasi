<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $type;

    public function __construct($otp, $type)
    {
        $this->otp = $otp;
        $this->type = $type;
    }

    public function build()
    {
        return $this->subject(
            $this->type === 'register'
                ? 'Kode OTP Verifikasi Email - SOY YPIK PAM JAYA'
                : 'Kode OTP Reset Password - SOY YPIK PAM JAYA'
        )
        ->view('auth.emails.otp')
        ->with([
            'otp' => $this->otp,
            'type' => $this->type,
        ]);
    }
}