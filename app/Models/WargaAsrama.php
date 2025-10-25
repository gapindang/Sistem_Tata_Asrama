<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;

class WargaAsrama extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'warga_asrama';
    protected $primaryKey = 'id_warga';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nama', 'nim', 'kamar', 'angkatan', 'status'];

    public function riwayatPelanggaran()
    {
        return $this->hasMany(RiwayatPelanggaran::class, 'id_warga');
    }

    public function riwayatPenghargaan()
    {
        return $this->hasMany(RiwayatPenghargaan::class, 'id_warga');
    }
}
