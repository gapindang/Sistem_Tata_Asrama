<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;

class Pelanggaran extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'pelanggaran';
    protected $primaryKey = 'id_pelanggaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nama_pelanggaran', 'kategori', 'poin', 'denda', 'deskripsi', 'id_warga'];

    public function riwayatPelanggaran()
    {
        return $this->hasMany(RiwayatPelanggaran::class, 'id_pelanggaran');
    }

    public function wargaAsrama()
    {
        return $this->belongsTo(WargaAsrama::class, 'id_warga');
    }
}
