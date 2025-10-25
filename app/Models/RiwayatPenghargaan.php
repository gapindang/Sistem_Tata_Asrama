<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;

class RiwayatPenghargaan extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'riwayat_penghargaan';
    protected $primaryKey = 'id_riwayat_penghargaan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_warga', 'id_penghargaan', 'tanggal', 'id_petugas'];

    public function warga()
    {
        return $this->belongsTo(WargaAsrama::class, 'id_warga');
    }

    public function penghargaan()
    {
        return $this->belongsTo(Penghargaan::class, 'id_penghargaan');
    }

    public function petugas()
    {
        return $this->belongsTo(Pengguna::class, 'id_petugas');
    }
}
