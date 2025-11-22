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
        // Admin Users
        Pengguna::create([
            'nama' => 'Admin Utama',
            'email' => 'admin@sitama.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        Pengguna::create([
            'nama' => 'Admin Kedua',
            'email' => 'admin2@sitama.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Petugas Users
        Pengguna::create([
            'nama' => 'Petugas Bambang',
            'email' => 'petugas1@sitama.com',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
        ]);

        Pengguna::create([
            'nama' => 'Petugas Siti',
            'email' => 'petugas2@sitama.com',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
        ]);

        Pengguna::create([
            'nama' => 'Petugas Andi',
            'email' => 'petugas3@sitama.com',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
        ]);
    }
}
