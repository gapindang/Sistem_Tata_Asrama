<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\OtpVerification;

class OtpVerificationSeeder extends Seeder
{
    public function run(): void
    {
        OtpVerification::create([
            'id' => Str::uuid(),
            'email' => 'admin@sitama.com',
            'otp' => '123456',
            'expires_at' => now()->addMinutes(10),
        ]);
    }
}
