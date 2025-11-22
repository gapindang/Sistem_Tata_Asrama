<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Denda extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'denda';
    protected $primaryKey = 'id_denda';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_riwayat_pelanggaran', 'nominal', 'status_bayar', 'tanggal_bayar', 'bukti_bayar'];

    public function riwayatPelanggaran()
    {
        return $this->belongsTo(RiwayatPelanggaran::class, 'id_riwayat_pelanggaran');
    }

    // Accessor untuk mendapatkan petugas melalui riwayat pelanggaran
    public function getPetugasAttribute()
    {
        return $this->riwayatPelanggaran?->petugas;
    }
}
