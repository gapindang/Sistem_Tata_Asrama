<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Berita extends Model
{
    use HasUuid;

    protected $table = 'berita';
    protected $primaryKey = 'id_berita';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'judul',
        'tanggal_mulai',
        'tanggal_selesai',
        'poster',
        'isi_berita',
        'id_pembuat',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function pembuat()
    {
        return $this->belongsTo(Pengguna::class, 'id_pembuat', 'id_user');
    }
}
