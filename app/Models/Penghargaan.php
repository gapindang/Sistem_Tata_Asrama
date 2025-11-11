<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;

class Penghargaan extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'penghargaan';
    protected $primaryKey = 'id_penghargaan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nama_penghargaan', 'poin_reward', 'deskripsi', 'id_warga'];

    public function riwayatPenghargaan()
    {
        return $this->hasMany(RiwayatPenghargaan::class, 'id_penghargaan');
    }

    public function wargaAsrama()
    {
        return $this->belongsTo(WargaAsrama::class, 'id_warga');
    }
}
