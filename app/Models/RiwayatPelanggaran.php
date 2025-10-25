<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;

class RiwayatPelanggaran extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'riwayat_pelanggaran';
    protected $primaryKey = 'id_riwayat_pelanggaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_warga', 'id_pelanggaran', 'tanggal', 'status_sanksi', 'bukti', 'id_petugas'];

    public function warga()
    {
        return $this->belongsTo(WargaAsrama::class, 'id_warga');
    }

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'id_pelanggaran');
    }

    public function petugas()
    {
        return $this->belongsTo(Pengguna::class, 'id_petugas');
    }

    public function denda()
    {
        return $this->hasOne(Denda::class, 'id_riwayat_pelanggaran');
    }
}
