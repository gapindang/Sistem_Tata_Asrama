<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Akun SITAMA</title>
</head>

<body style="font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); overflow: hidden;">
        <tr>
            <td style="background-color: #007bff; color: white; text-align: center; padding: 20px 0;">
                <h1 style="margin: 0; font-size: 22px;">SITAMA</h1>
                <p style="margin: 0; font-size: 14px;">Sistem Tata Asrama</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 30px 40px; color: #333333;">
                <h2 style="margin-top: 0; color: #007bff;">Halo!</h2>
                <p style="font-size: 15px; line-height: 1.6;">
                    Terima kasih telah mendaftar di <strong>SITAMA</strong>.<br>
                    Berikut adalah kode OTP untuk verifikasi akun kamu:
                </p>
                <div style="text-align: center; margin: 30px 0;">
                    <span
                        style="display: inline-block; font-size: 36px; font-weight: bold; color: #007bff; background-color: #eef5ff; padding: 15px 40px; border-radius: 8px; letter-spacing: 6px;">
                        {{ $otp }}
                    </span>
                </div>
                <p style="font-size: 14px; line-height: 1.6; color: #555;">
                    Kode ini berlaku selama <strong>10 menit</strong> sejak email ini dikirim.
                    Jika kamu tidak merasa mendaftar di SITAMA, abaikan email ini.
                </p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #f4f6f8; text-align: center; padding: 15px 0; font-size: 13px; color: #777;">
                © {{ date('Y') }} SITAMA. All rights reserved.
            </td>
        </tr>
    </table>
</body>

</html>
