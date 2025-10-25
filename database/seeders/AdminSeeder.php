<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Pengguna;

class AdminSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        if (!Pengguna::where('email', 'admin@sitama.com')->exists()) {
            Pengguna::create([
                'id_user' => (string) Str::uuid(),
                'nama' => 'Administrator',
                'email' => 'admin@sitama.com',
                'password' => Hash::make('admin123'), // ubah sesuai keinginan
                'role' => 'admin',
            ]);

            echo "Admin berhasil dibuat (email: admin@sitama.com | password: admin123)\n";
        } else {
            echo "Admin sudah ada, tidak dibuat ulang.\n";
        }
    }
}
