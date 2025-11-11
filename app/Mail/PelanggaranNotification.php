<?php

namespace App\Mail;

use App\Models\RiwayatPelanggaran;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PelanggaranNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $riwayatPelanggaran;
    public $wargaNama;
    public $pelanggaranNama;
    public $severity;

    public function __construct(RiwayatPelanggaran $riwayatPelanggaran)
    {
        $this->riwayatPelanggaran = $riwayatPelanggaran;
        $this->wargaNama = $riwayatPelanggaran->warga->nama ?? 'Warga';
        $this->pelanggaranNama = $riwayatPelanggaran->pelanggaran->nama_pelanggaran ?? 'Pelanggaran';

        // Determine severity level
        $point = $riwayatPelanggaran->pelanggaran->poin ?? 0;
        if ($point >= 15) {
            $this->severity = 'critical';
        } elseif ($point >= 10) {
            $this->severity = 'high';
        } else {
            $this->severity = 'medium';
        }
    }

    public function build()
    {
        return $this->subject('⚠️ Notifikasi Pelanggaran - SITAMA')
            ->view('emails.pelanggaran-notification')
            ->with([
                'wargaNama' => $this->wargaNama,
                'pelanggaranNama' => $this->pelanggaranNama,
                'tanggal' => $this->riwayatPelanggaran->tanggal,
                'severity' => $this->severity,
                'poin' => $this->riwayatPelanggaran->pelanggaran->poin ?? 0,
            ]);
    }
}
