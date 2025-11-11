<?php

namespace App\Mail;

use App\Models\Denda;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DendaNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $denda;
    public $wargaNama;
    public $pelanggaranNama;
    public $nominal;

    public function __construct(Denda $denda)
    {
        $this->denda = $denda;
        $this->wargaNama = $denda->riwayatPelanggaran->warga->nama ?? 'Warga';
        $this->pelanggaranNama = $denda->riwayatPelanggaran->pelanggaran->nama_pelanggaran ?? 'Pelanggaran';
        $this->nominal = $denda->nominal;
    }

    public function build()
    {
        return $this->subject('💰 Notifikasi Denda Baru - SITAMA')
            ->view('emails.denda-notification')
            ->with([
                'wargaNama' => $this->wargaNama,
                'pelanggaranNama' => $this->pelanggaranNama,
                'nominal' => $this->nominal,
                'statusBayar' => $this->denda->status_bayar,
                'tanggalBayar' => $this->denda->tanggal_bayar,
            ]);
    }
}
