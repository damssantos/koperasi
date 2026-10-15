<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="color-scheme" content="light" />
    <meta name="supported-color-schemes" content="light" />
    <title>Pengingat Pembayaran Cicilan Pinjaman - SOY YPIK PAM JAYA</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style type="text/css">
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; outline: none; text-decoration: none; }
        
        body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            min-width: 100% !important;
            background-color: #f8fafc !important;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        @media only screen and (max-width: 640px) {
            .content-table {
                width: 100% !important;
            }
            .content-cell {
                padding-left: 16px !important;
                padding-right: 16px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; width: 100% !important; min-width: 100% !important; background-color: #f8fafc; font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">

    @php
        $idFormatted = 'PJ-' . str_pad($pinjaman->id, 5, '0', STR_PAD_LEFT);
        $memberId = $anggota->id_anggota ?? ('AGT-' . str_pad($anggota->id, 3, '0', STR_PAD_LEFT));
        $namaAnggota = $anggota->nama ?? 'Anggota';
        
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

    <!-- Hidden Preheader -->
    <div style="display: none; font-size: 1px; color: #f8fafc; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all;">
        Pengingat tagihan cicilan pinjaman {{ $idFormatted }} sebesar Rp {{ number_format($nominalCicilan, 0, ',', '.') }} untuk {{ $namaAnggota }}.
        &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
    </div>

    <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" style="width: 100%; margin: 0; padding: 0; background-color: #f8fafc; border-collapse: collapse;">
        
        <!-- Top Accent Gradient Line -->
        <tr>
            <td height="5" style="background: linear-gradient(90deg, #2563eb 0%, #3b82f6 50%, #06b6d4 100%); font-size: 0px; line-height: 0px; width: 100%;">&nbsp;</td>
        </tr>

        <!-- Main Body Row -->
        <tr>
            <td class="content-cell" align="center" style="padding: 40px 20px 30px; background-color: #f8fafc;">
                <table class="content-table" border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" style="max-width: 600px; width: 100%; margin: 0 auto; text-align: left; background-color: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 20px rgba(15, 23, 42, 0.05);">
                    
                    <!-- Brand Header with Logo -->
                    <tr>
                        <td align="center" style="padding: 32px 28px 20px; background-color: #ffffff; text-align: center; border-bottom: 1px solid #f1f5f9;">
                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin: 0 auto;">
                                <tr>
                                    <td align="center" style="width: 64px; height: 64px; background: #ffffff; border-radius: 50%; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.12), 0 0 0 1px #e2e8f0; vertical-align: middle; text-align: center;">
                                        <img src="{{ $logoUrl }}" alt="Logo SOY YPIK" width="48" height="48" style="display: block; margin: 0 auto; width: 48px; height: 48px; border-radius: 50%; object-fit: cover;" />
                                    </td>
                                </tr>
                            </table>

                            <div style="margin-top: 14px;">
                                <h1 style="margin: 0; font-size: 19px; font-weight: 800; color: #0f172a; letter-spacing: -0.2px;">
                                    SOY YPIK PAM JAYA
                                </h1>
                                <p style="margin: 4px 0 0; font-size: 12px; font-weight: 600; color: #64748b; letter-spacing: 0.3px; text-transform: uppercase;">
                                    Sistem Operasional Koperasi
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- Notification Body -->
                    <tr>
                        <td style="padding: 32px 32px 24px;">

                            <!-- Badge & Title -->
                            <div style="text-align: center; margin-bottom: 24px;">
                                <span style="display: inline-block; padding: 4px 12px; background-color: #fef3c7; color: #b45309; font-size: 11px; font-weight: 800; border-radius: 9999px; letter-spacing: 0.5px; text-transform: uppercase; border: 1px solid #fde68a;">
                                    Pengingat Pembayaran
                                </span>
                                <h2 style="margin: 12px 0 6px; font-size: 20px; font-weight: 800; color: #0f172a; letter-spacing: -0.3px;">
                                    Tagihan Cicilan Pinjaman
                                </h2>
                                <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.5;">
                                    Nomor Pinjaman: <strong style="color: #2563eb;">{{ $idFormatted }}</strong>
                                </p>
                            </div>

                            <!-- Greeting -->
                            <p style="margin: 0 0 16px; font-size: 14px; color: #334155; line-height: 1.6;">
                                Halo <strong>{{ $namaAnggota }}</strong> ({{ $memberId }}),
                            </p>
                            <p style="margin: 0 0 24px; font-size: 13.5px; color: #475569; line-height: 1.6;">
                                Kami menginformasikan pengingat untuk segera melakukan pembayaran cicilan pinjaman Anda di <strong>SOY YPIK PAM JAYA</strong>. Berikut adalah rincian tagihan pinjaman Anda saat ini:
                            </p>

                            <!-- Bill Summary Highlight Box -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" style="background-color: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; margin-bottom: 24px; border-collapse: separate;">
                                <tr>
                                    <td style="padding: 20px 20px 14px; border-bottom: 1px solid #e2e8f0; text-align: center; background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%); border-radius: 12px 12px 0 0;">
                                        <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Estimasi Tagihan Cicilan Bulan Ini
                                        </div>
                                        <div style="font-size: 26px; font-weight: 800; color: #2563eb; margin-top: 6px; letter-spacing: -0.5px;">
                                            Rp {{ number_format($nominalCicilan, 0, ',', '.') }}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" style="font-size: 13px;">
                                            <tr>
                                                <td style="padding: 6px 0; color: #64748b; font-weight: 500;">Progress Cicilan</td>
                                                <td style="padding: 6px 0; text-align: right; font-weight: 700; color: #0f172a;">Cicilan ke-{{ $cicilanKe }} dari {{ $pinjaman->tenor }} Bulan</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 6px 0; color: #64748b; font-weight: 500;">Plafond Pinjaman</td>
                                                <td style="padding: 6px 0; text-align: right; font-weight: 700; color: #0f172a;">Rp {{ number_format($pinjaman->nominal_pinjaman, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 6px 0; color: #64748b; font-weight: 500;">Sisa Pinjaman</td>
                                                <td style="padding: 6px 0; text-align: right; font-weight: 700; color: #dc2626;">Rp {{ number_format($pinjaman->sisa_pinjaman, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 6px 0; color: #64748b; font-weight: 500;">Status Pinjaman</td>
                                                <td style="padding: 6px 0; text-align: right;">
                                                    <span style="display: inline-block; padding: 2px 8px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-transform: uppercase; {{ $pinjaman->status === 'Menunggak' ? 'background-color: #fee2e2; color: #b91c1c;' : 'background-color: #eff6ff; color: #2563eb;' }}">
                                                        {{ $pinjaman->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            @if(!empty($catatanTambahan))
                            <!-- Admin Custom Note -->
                            <div style="background-color: #fefce8; border: 1px solid #fef08a; border-radius: 10px; padding: 14px 16px; margin-bottom: 24px;">
                                <div style="font-size: 12px; font-weight: 700; color: #854d0e; margin-bottom: 4px; display: flex; align-items: center;">
                                    📌 Catatan dari Pengurus Koperasi:
                                </div>
                                <div style="font-size: 13px; color: #713f12; line-height: 1.5;">
                                    {{ $catatanTambahan }}
                                </div>
                            </div>
                            @endif

                            <!-- CTA Button -->
                            <div style="text-align: center; margin: 30px 0 24px;">
                                <a href="{{ url('/customer/pinjaman') }}" target="_blank" style="display: inline-block; background-color: #2563eb; color: #ffffff; text-decoration: none; padding: 12px 28px; font-size: 13.5px; font-weight: 700; border-radius: 10px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                                    Buka Portal & Riwayat Pinjaman &rarr;
                                </a>
                            </div>

                            <p style="margin: 0; font-size: 12.5px; color: #64748b; line-height: 1.6; text-align: center;">
                                Jika Anda sudah melakukan pembayaran, silakan abaikan pesan ini atau konfirmasi bukti transfer Anda melalui portal koperasi.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 20px 28px; background-color: #f8fafc; border-top: 1px solid #e2e8f0; text-align: center;">
                            <p style="margin: 0 0 6px; font-size: 11.5px; font-weight: 600; color: #64748b;">
                                © {{ date('Y') }} SOY YPIK PAM JAYA. Hak Cipta Dilindungi.
                            </p>
                            <p style="margin: 0; font-size: 11px; color: #94a3b8;">
                                Email otomatis dikirim oleh Sistem Operasional Koperasi YPIK PAM JAYA.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
