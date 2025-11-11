<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Denda - SITAMA</title>
</head>

<body style="font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); overflow: hidden;">
        <tr>
            <td
                style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; text-align: center; padding: 30px 0;">
                <h1 style="margin: 0; font-size: 24px;">💰 NOTIFIKASI DENDA</h1>
                <p style="margin: 5px 0 0 0; font-size: 14px;">SITAMA - Sistem Tata Asrama</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 30px 40px; color: #333333;">
                <h2 style="margin-top: 0; color: #333;">Halo {{ $wargaNama }},</h2>
                <p style="font-size: 15px; line-height: 1.6;">
                    Terdapat denda baru yang diberikan terkait pelanggaran asrama. Silakan lakukan pembayaran sesuai
                    dengan nominal dan tenggat waktu yang ditentukan.
                </p>

                {{-- Status Badge --}}
                @if ($statusBayar === 'dibayar')
                    <div
                        style="background-color: #e8f5e9; border-left: 4px solid #4caf50; padding: 15px; border-radius: 5px; margin: 20px 0;">
                        <p style="margin: 0; color: #4caf50; font-weight: bold;">✓ DENDA SUDAH DIBAYAR</p>
                        <p style="margin: 5px 0 0 0; color: #666; font-size: 13px;">Terima kasih atas pembayaran Anda.
                        </p>
                    </div>
                @else
                    <div
                        style="background-color: #fff3cd; border-left: 4px solid #ff9800; padding: 15px; border-radius: 5px; margin: 20px 0;">
                        <p style="margin: 0; color: #ff9800; font-weight: bold;">⚠️ MENUNGGU PEMBAYARAN</p>
                        <p style="margin: 5px 0 0 0; color: #666; font-size: 13px;">Silakan segera lakukan pembayaran.
                        </p>
                    </div>
                @endif

                {{-- Detail Denda --}}
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
                            Nominal Denda</td>
                        <td
                            style="padding: 10px; color: #f5576c; font-weight: bold; font-size: 16px; border-bottom: 1px solid #e0e0e0;">
                            Rp {{ number_format($nominal, 0, ',', '.') }}</td>
                    </tr>
                    <tr style="background-color: #f4f6f8;">
                        <td style="padding: 10px; font-weight: bold; color: #333; border-bottom: 1px solid #e0e0e0;">
                            Status Pembayaran</td>
                        <td style="padding: 10px; color: #666; border-bottom: 1px solid #e0e0e0;">
                            @if ($statusBayar === 'dibayar')
                                <span
                                    style="background-color: #4caf50; color: white; padding: 5px 10px; border-radius: 3px; font-size: 12px;">Sudah
                                    Dibayar</span>
                            @else
                                <span
                                    style="background-color: #ff9800; color: white; padding: 5px 10px; border-radius: 3px; font-size: 12px;">Belum
                                    Dibayar</span>
                            @endif
                        </td>
                    </tr>
                    @if ($tanggalBayar)
                        <tr>
                            <td style="padding: 10px; font-weight: bold; color: #333;">Tanggal Pembayaran</td>
                            <td style="padding: 10px; color: #666;">
                                {{ \Carbon\Carbon::parse($tanggalBayar)->format('d M Y') }}</td>
                        </tr>
                    @endif
                </table>

                @if ($statusBayar === 'belum')
                    <div
                        style="background-color: #ffe0e0; border-left: 4px solid #ff6b6b; padding: 15px; border-radius: 5px; margin: 20px 0;">
                        <p style="margin: 0; color: #ff6b6b; font-weight: bold;">⚠️ TINDAKAN DIPERLUKAN</p>
                        <p style="margin: 5px 0 0 0; color: #666; font-size: 13px;">Silakan lakukan pembayaran denda
                            melalui portal SITAMA atau ke kasir asrama untuk menghindari konsekuensi lebih lanjut.</p>
                    </div>
                @endif

                <p style="font-size: 14px; line-height: 1.6; color: #555; margin-top: 20px;">
                    Jika Anda memiliki pertanyaan atau ingin melakukan pembayaran, silakan login ke portal SITAMA atau
                    hubungi pihak asrama.
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
