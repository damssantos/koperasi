<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="color-scheme" content="light" />
    <meta name="supported-color-schemes" content="light" />
    <title>{{ $type === 'register' ? 'Verifikasi Alamat Email' : 'Reset Kata Sandi' }} - SOY YPIK PAM JAYA</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style type="text/css">
        /* Client-specific resets */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; outline: none; text-decoration: none; }
        
        body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            min-width: 100% !important;
            background-color: #ffffff !important;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* Mobile Responsive */
        @media only screen and (max-width: 640px) {
            .content-table {
                width: 100% !important;
            }
            .content-cell {
                padding-left: 16px !important;
                padding-right: 16px !important;
            }
            .otp-digits {
                font-size: 30px !important;
                letter-spacing: 8px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; width: 100% !important; min-width: 100% !important; background-color: #ffffff; font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">

    <!-- Hidden Preheader Preview Text -->
    <div style="display: none; font-size: 1px; color: #ffffff; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all;">
        @if($type === 'register')
            Kode OTP Verifikasi Email Anda adalah {{ $otp }}. Berlaku selama 5 menit.
        @else
            Kode OTP Reset Password Anda adalah {{ $otp }}. Berlaku selama 5 menit.
        @endif
        &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
    </div>

    @php
        $logoUrl = null;
        if (isset($message) && is_object($message) && method_exists($message, 'embed') && file_exists(public_path('images/logo-ypik.png'))) {
            $logoUrl = $message->embed(public_path('images/logo-ypik.png'));
        } elseif (file_exists(public_path('images/logo-ypik.png'))) {
            $logoData = base64_encode(file_get_contents(public_path('images/logo-ypik.png')));
            $logoUrl = 'data:image/png;base64,' . $logoData;
        } else {
            $logoUrl = asset('images/logo-ypik.png');
        }
    @endphp

    <!-- Full-Width Outer Container (No empty sidebars) -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" style="width: 100%; margin: 0; padding: 0; background-color: #ffffff; border-collapse: collapse;">
        
        <!-- Top Gradient Accent Line spanning 100% edge-to-edge -->
        <tr>
            <td height="5" style="background: linear-gradient(90deg, #2563eb 0%, #4f46e5 50%, #06b6d4 100%); font-size: 0px; line-height: 0px; width: 100%;">&nbsp;</td>
        </tr>

        <!-- Main Body Content Row -->
        <tr>
            <td class="content-cell" align="center" style="padding: 40px 24px 30px; background-color: #ffffff;">
                
                <!-- Inner Centered Content Column (Fluid on mobile, readable max-width on large screens) -->
                <table class="content-table" border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" style="max-width: 640px; width: 100%; margin: 0 auto; text-align: left;">
                    
                    <!-- Brand Header Section -->
                    <tr>
                        <td align="center" style="padding-bottom: 28px; text-align: center;">
                            
                            <!-- Logo Avatar with subtle glowing ring -->
                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin: 0 auto;">
                                <tr>
                                    <td align="center" style="width: 76px; height: 76px; background: #ffffff; border-radius: 50%; box-shadow: 0 4px 16px rgba(37, 99, 235, 0.12), 0 0 0 1px #e2e8f0; vertical-align: middle; text-align: center;">
                                        <img src="{{ $logoUrl }}" alt="Logo SOY YPIK PAM JAYA" width="58" height="58" style="display: block; margin: 0 auto; width: 58px; height: 58px; border-radius: 50%; object-fit: cover;" />
                                    </td>
                                </tr>
                            </table>

                            <!-- Brand Name & Badge -->
                            <div style="margin-top: 14px;">
                                <h1 style="margin: 0; font-size: 21px; font-weight: 800; color: #0f172a; letter-spacing: -0.3px; font-family: 'Plus Jakarta Sans', sans-serif;">
                                    SOY YPIK PAM JAYA
                                </h1>
                                <div style="margin-top: 6px;">
                                    <span style="display: inline-block; padding: 4px 14px; background-color: #eff6ff; color: #2563eb; font-size: 11px; font-weight: 700; border-radius: 9999px; letter-spacing: 0.6px; text-transform: uppercase; border: 1px solid #dbeafe;">
                                        Sistem Operasional Koperasi
                                    </span>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <!-- Divider -->
                    <tr>
                        <td style="padding-bottom: 28px;">
                            <div style="height: 1px; background-color: #e2e8f0; width: 100%;"></div>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td>

                            @if($type === 'register')
                                <!-- Register Verification Header -->
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom: 12px;">
                                    <tr>
                                        <td style="vertical-align: middle; padding-right: 10px;">
                                            <div style="width: 34px; height: 34px; background-color: #eff6ff; border-radius: 10px; text-align: center; line-height: 34px; font-size: 17px;">
                                                ✉️
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <h2 style="margin: 0; font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.2px;">
                                                Verifikasi Alamat Email
                                            </h2>
                                        </td>
                                    </tr>
                                </table>

                                <p style="margin: 0 0 14px; font-size: 14px; line-height: 1.7; color: #475569;">
                                    Halo, terima kasih telah mendaftarkan akun di <strong>SOY YPIK PAM JAYA</strong>.
                                </p>
                                <p style="margin: 0 0 24px; font-size: 14px; line-height: 1.7; color: #475569;">
                                    Untuk memverifikasi alamat email dan melanjutkan proses pendaftaran akun Anda, silakan gunakan kode One-Time Password (OTP) berikut:
                                </p>
                            @else
                                <!-- Reset Password Header -->
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom: 12px;">
                                    <tr>
                                        <td style="vertical-align: middle; padding-right: 10px;">
                                            <div style="width: 34px; height: 34px; background-color: #eff6ff; border-radius: 10px; text-align: center; line-height: 34px; font-size: 17px;">
                                                🔑
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <h2 style="margin: 0; font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.2px;">
                                                Atur Ulang Kata Sandi
                                            </h2>
                                        </td>
                                    </tr>
                                </table>

                                <p style="margin: 0 0 14px; font-size: 14px; line-height: 1.7; color: #475569;">
                                    Halo, kami menerima permintaan untuk mengatur ulang kata sandi akun <strong>SOY YPIK PAM JAYA</strong> Anda.
                                </p>
                                <p style="margin: 0 0 24px; font-size: 14px; line-height: 1.7; color: #475569;">
                                    Gunakan kode One-Time Password (OTP) berikut untuk memverifikasi permintaan Anda:
                                </p>
                            @endif

                            <!-- Modern OTP Container Card -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" style="margin: 10px 0 28px; background: linear-gradient(135deg, #f8faff 0%, #eff4fe 100%); border-radius: 16px; border: 1.5px dashed #3b82f6; text-align: center;">
                                <tr>
                                    <td style="padding: 26px 20px; text-align: center;">
                                        
                                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; color: #3b82f6; margin-bottom: 10px;">
                                            Kode Verifikasi OTP
                                        </div>

                                        <!-- OTP Digits -->
                                        <div class="otp-digits" style="font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Consolas, monospace; font-size: 38px; font-weight: 800; letter-spacing: 12px; color: #1d4ed8; text-indent: 12px; line-height: 1.2;">
                                            {{ $otp }}
                                        </div>

                                        <div style="margin-top: 10px; font-size: 12px; color: #64748b;">
                                            Salin atau masukkan 6 digit angka di atas ke aplikasi
                                        </div>

                                    </td>
                                </tr>
                            </table>

                            <!-- Expiry & Security Callout -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" style="margin-bottom: 24px; background-color: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #2563eb; border-radius: 10px;">
                                <tr>
                                    <td style="padding: 16px 18px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                            <tr>
                                                <td style="padding-bottom: 8px; font-size: 13px; color: #334155; line-height: 1.55;">
                                                    <strong style="color: #0f172a;">⏱️ Masa Berlaku:</strong> Kode ini hanya berlaku selama <strong>5 menit</strong>.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 13px; color: #475569; line-height: 1.55;">
                                                    <strong style="color: #0f172a;">🔒 Keamanan:</strong> Jangan pernah membagikan kode OTP ini kepada siapa pun, termasuk pihak yang mengaku sebagai pengurus atau staf Koperasi.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Reassurance note -->
                            <p style="margin: 0; font-size: 13px; line-height: 1.65; color: #64748b;">
                                Jika Anda tidak merasa melakukan pendaftaran atau permintaan reset password ini, abaikan pesan ini. Akun Anda tetap aman dan tidak ada perubahan yang akan dilakukan.
                            </p>

                        </td>
                    </tr>

                </table>
                <!-- End Inner Content Column -->

            </td>
        </tr>

        <!-- Full-Width Footer Section (Spanning edge-to-edge) -->
        <tr>
            <td align="center" style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 32px 24px;">
                <table class="content-table" border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" style="max-width: 640px; width: 100%; margin: 0 auto; text-align: center;">
                    <tr>
                        <td align="center" style="text-align: center;">
                            <p style="margin: 0 0 6px; font-size: 12px; font-weight: 600; color: #475569;">
                                Koperasi Konsumen Pegawai PAM JAYA (SOY YPIK)
                            </p>
                            <p style="margin: 0 0 10px; font-size: 11px; color: #94a3b8; line-height: 1.5;">
                                Sistem Informasi & Operasional Layanan Keanggotaan Koperasi
                            </p>
                            <div style="font-size: 11px; color: #94a3b8;">
                                &copy; {{ date('Y') }} SOY YPIK PAM JAYA. Hak cipta dilindungi undang-undang.
                            </div>
                            <p style="margin: 10px 0 0; font-size: 10px; color: #cbd5e1;">
                                Email ini dikirim secara otomatis oleh sistem, mohon untuk tidak membalas email ini.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
    <!-- End Full-Width Outer Container -->

</body>
</html>