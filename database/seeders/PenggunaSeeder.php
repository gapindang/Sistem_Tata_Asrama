<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {

        Pengguna::create([
            'nama' => 'Admin Utama',
            'email' => 'admin@sitama.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        Pengguna::create([
            'nama' => 'Petugas Satu',
            'email' => 'petugas@sitama.com',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
        ]);

        Pengguna::create([
            'nama' => 'Warga Satu',
            'email' => 'warga@sitama.com',
            'password' => Hash::make('warga123'),
            'role' => 'warga',
        ]);
    }
}
