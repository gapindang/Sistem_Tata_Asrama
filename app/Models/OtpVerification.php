<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class OtpVerification extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'otp_verifications';
    protected $fillable = ['email', 'otp', 'is_verified', 'expires_at'];
    protected $casts = [
        'expires_at' => 'datetime',
        'is_verified' => 'boolean'
    ];
}
