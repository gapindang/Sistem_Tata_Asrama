<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Pemberitahuan extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'pemberitahuan';
    protected $primaryKey = 'id_notifikasi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_user', 'pesan', 'jenis', 'tanggal', 'status_baca'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_user');
    }
}
