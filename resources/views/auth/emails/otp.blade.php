<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kode OTP</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #f4f6f8;
    font-family: Arial, sans-serif;
">

    <div style="
        max-width: 600px;
        margin: 40px auto;
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    ">

        <div style="
            background: #2f54eb;
            padding: 25px;
            text-align: center;
            color: white;
        ">
            <h2 style="margin: 0;">
                SOY YPIK PAM JAYA
            </h2>

            <p style="margin: 8px 0 0;">
                Sistem Operasional Koperasi
            </p>
        </div>

        <div style="padding: 35px;">

            @if($type === 'register')

                <h2 style="color: #111827;">
                    Verifikasi Email
                </h2>

                <p style="color: #4b5563;">
                    Terima kasih telah mendaftarkan akun di
                    SOY YPIK PAM JAYA.
                </p>

                <p style="color: #4b5563;">
                    Gunakan kode OTP berikut untuk memverifikasi alamat email Anda:
                </p>

            @else

                <h2 style="color: #111827;">
                    Reset Password
                </h2>

                <p style="color: #4b5563;">
                    Kami menerima permintaan untuk mengatur ulang password akun Anda.
                </p>

                <p style="color: #4b5563;">
                    Gunakan kode OTP berikut:
                </p>

            @endif

            <div style="
                margin: 30px 0;
                padding: 20px;
                background: #f1f5ff;
                border-radius: 10px;
                text-align: center;
            ">

                <div style="
                    font-size: 32px;
                    font-weight: bold;
                    letter-spacing: 8px;
                    color: #2f54eb;
                ">
                    {{ $otp }}
                </div>

            </div>

            <p style="
                color: #6b7280;
                font-size: 14px;
            ">
                Kode ini berlaku selama <strong>5 menit</strong>.
            </p>

            <p style="
                color: #6b7280;
                font-size: 14px;
            ">
                Jika Anda tidak melakukan permintaan ini,
                abaikan email ini.
            </p>

        </div>

        <div style="
            padding: 20px;
            background: #f9fafb;
            text-align: center;
            color: #9ca3af;
            font-size: 12px;
        ">
            © {{ date('Y') }} SOY YPIK PAM JAYA
        </div>

    </div>

</body>
</html>