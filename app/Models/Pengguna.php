<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasUuid;

class Pengguna extends Authenticatable
{
    use HasFactory, HasUuid, Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_user';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['nama', 'email', 'password', 'role', 'otp_code', 'otp_expires_at'];
    protected $hidden = ['password'];

    public function riwayatPelanggaranPetugas()
    {
        return $this->hasMany(RiwayatPelanggaran::class, 'id_petugas');
    }

    public function riwayatPenghargaanPetugas()
    {
        return $this->hasMany(RiwayatPenghargaan::class, 'id_petugas');
    }

    public function pemberitahuan()
    {
        return $this->hasMany(Pemberitahuan::class, 'id_user');
    }

    public function getAuthIdentifierName()
    {
        return 'id_user';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }
}
