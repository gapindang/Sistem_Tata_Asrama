<?php

namespace App\Mail;

use App\Models\RiwayatPenghargaan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PenghargaanNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $riwayatPenghargaan;
    public $wargaNama;
    public $penghargaanNama;

    public function __construct(RiwayatPenghargaan $riwayatPenghargaan)
    {
        $this->riwayatPenghargaan = $riwayatPenghargaan;
        $this->wargaNama = $riwayatPenghargaan->warga->nama ?? 'Warga';
        $this->penghargaanNama = $riwayatPenghargaan->penghargaan->nama_penghargaan ?? 'Penghargaan';
    }

    public function build()
    {
        return $this->subject('🏆 Selamat! Anda Mendapat Penghargaan - SITAMA')
            ->view('emails.penghargaan-notification')
            ->with([
                'wargaNama' => $this->wargaNama,
                'penghargaanNama' => $this->penghargaanNama,
                'tanggal' => $this->riwayatPenghargaan->tanggal,
                'deskripsi' => $this->riwayatPenghargaan->penghargaan->deskripsi ?? '',
            ]);
    }
}
