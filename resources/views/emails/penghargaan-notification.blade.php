<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Penghargaan - SITAMA</title>
</head>

<body style="font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); overflow: hidden;">
        <tr>
            <td
                style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; text-align: center; padding: 30px 0;">
                <h1 style="margin: 0; font-size: 24px;">🏆 SELAMAT!</h1>
                <p style="margin: 5px 0 0 0; font-size: 14px;">SITAMA - Sistem Tata Asrama</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 30px 40px; color: #333333;">
                <h2 style="margin-top: 0; color: #333;">Halo {{ $wargaNama }},</h2>
                <p style="font-size: 15px; line-height: 1.6;">
                    Kami dengan senang hati menginformasikan bahwa Anda telah menerima penghargaan! Ini adalah bentuk
                    apresiasi atas dedikasi dan kedisiplinan Anda.
                </p>

                {{-- Penghargaan Badge --}}
                <div
                    style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 10px; padding: 20px; text-align: center; margin: 20px 0; color: white;">
                    <p style="margin: 0; font-size: 14px; opacity: 0.9;">Penghargaan</p>
                    <h3 style="margin: 10px 0 0 0; font-size: 22px;">{{ $penghargaanNama }}</h3>
                </div>

                {{-- Detail Penghargaan --}}
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="margin: 20px 0; border-collapse: collapse;">
                    <tr style="background-color: #f4f6f8;">
                        <td style="padding: 10px; font-weight: bold; color: #333; border-bottom: 1px solid #e0e0e0;">
                            Nama Penghargaan</td>
                        <td style="padding: 10px; color: #666; border-bottom: 1px solid #e0e0e0;">{{ $penghargaanNama }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: bold; color: #333; border-bottom: 1px solid #e0e0e0;">
                            Tanggal Diterima</td>
                        <td style="padding: 10px; color: #666; border-bottom: 1px solid #e0e0e0;">
                            {{ \Carbon\Carbon::parse($tanggal)->format('d M Y H:i') }}</td>
                    </tr>
                    @if ($deskripsi)
                        <tr style="background-color: #f4f6f8;">
                            <td
                                style="padding: 10px; font-weight: bold; color: #333; border-bottom: 1px solid #e0e0e0;">
                                Keterangan</td>
                            <td style="padding: 10px; color: #666; border-bottom: 1px solid #e0e0e0;">
                                {{ $deskripsi }}</td>
                        </tr>
                    @endif
                </table>

                <div
                    style="background-color: #e8f5e9; border-left: 4px solid #43e97b; padding: 15px; border-radius: 5px; margin: 20px 0;">
                    <p style="margin: 0; color: #43e97b; font-weight: bold;">✓ Penghargaan Dicatat</p>
                    <p style="margin: 5px 0 0 0; color: #666; font-size: 13px;">Penghargaan Anda telah terekam dalam
                        sistem. Terus tingkatkan prestasi!</p>
                </div>

                <p style="font-size: 14px; line-height: 1.6; color: #555; margin-top: 20px;">
                    Terimakasih atas komitmen dan disiplin Anda terhadap peraturan asrama. Kami berharap Anda terus
                    memberikan teladan yang baik bagi warga asrama yang lain.
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
