<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Pelanggaran - SITAMA</title>
</head>

<body style="font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); overflow: hidden;">
        <tr>
            <td
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-align: center; padding: 30px 0;">
                <h1 style="margin: 0; font-size: 24px;">⚠️ NOTIFIKASI PELANGGARAN</h1>
                <p style="margin: 5px 0 0 0; font-size: 14px;">SITAMA - Sistem Tata Asrama</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 30px 40px; color: #333333;">
                <h2 style="margin-top: 0; color: #333;">Halo {{ $wargaNama }},</h2>
                <p style="font-size: 15px; line-height: 1.6;">
                    Sistem kami telah mencatat adanya pelanggaran terbaru terhadap peraturan asrama. Berikut adalah
                    detail pelanggaran:
                </p>

                {{-- Severity Badge --}}
                @if ($severity === 'critical')
                    <div
                        style="background-color: #fff3cd; border-left: 4px solid #ff6b6b; padding: 15px; border-radius: 5px; margin: 20px 0;">
                        <p style="margin: 0; color: #ff6b6b; font-weight: bold;">⚠️ PELANGGARAN SERIUS</p>
                        <p style="margin: 5px 0 0 0; color: #666; font-size: 13px;">Poin pelanggaran tinggi. Harap
                            segera perhatikan.</p>
                    </div>
                @elseif ($severity === 'high')
                    <div
                        style="background-color: #ffe0e0; border-left: 4px solid #ff9800; padding: 15px; border-radius: 5px; margin: 20px 0;">
                        <p style="margin: 0; color: #ff9800; font-weight: bold;">⚠️ PELANGGARAN PENTING</p>
                        <p style="margin: 5px 0 0 0; color: #666; font-size: 13px;">Poin pelanggaran menengah.
                            Tingkatkan kedisiplinan.</p>
                    </div>
                @else
                    <div
                        style="background-color: #e8f5e9; border-left: 4px solid #4caf50; padding: 15px; border-radius: 5px; margin: 20px 0;">
                        <p style="margin: 0; color: #4caf50; font-weight: bold;">ℹ️ PELANGGARAN DICATAT</p>
                        <p style="margin: 5px 0 0 0; color: #666; font-size: 13px;">Poin pelanggaran ringan.</p>
                    </div>
                @endif

                {{-- Detail Pelanggaran --}}
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="margin: 20px 0; border-collapse: collapse;">
                    <tr style="background-color: #f4f6f8;">
                        <td style="padding: 10px; font-weight: bold; color: #333; border-bottom: 1px solid #e0e0e0;">
                            Jenis Pelanggaran</td>
                        <td style="padding: 10px; color: #666; border-bottom: 1px solid #e0e0e0;">{{ $pelanggaranNama }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: bold; color: #333; border-bottom: 1px solid #e0e0e0;">
                            Tanggal</td>
                        <td style="padding: 10px; color: #666; border-bottom: 1px solid #e0e0e0;">
                            {{ \Carbon\Carbon::parse($tanggal)->format('d M Y H:i') }}</td>
                    </tr>
                    <tr style="background-color: #f4f6f8;">
                        <td style="padding: 10px; font-weight: bold; color: #333;">Poin Pelanggaran</td>
                        <td style="padding: 10px; color: #ff6b6b; font-weight: bold;">{{ $poin }} Poin</td>
                    </tr>
                </table>

                <p style="font-size: 14px; line-height: 1.6; color: #555; margin-top: 20px;">
                    Harap perhatikan peraturan asrama dan tingkatkan kedisiplinan. Akumulasi poin pelanggaran dapat
                    mengakibatkan sanksi lebih lanjut.
                </p>

                <p style="font-size: 14px; line-height: 1.6; color: #555;">
                    Untuk informasi lebih lanjut, silakan login ke portal SITAMA atau hubungi pihak asrama.
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
