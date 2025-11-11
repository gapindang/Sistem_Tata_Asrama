<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PenggunaSeeder::class,
            WargaSeeder::class,
            PelanggaranSeeder::class,
            PenghargaanSeeder::class,
            RiwayatPelanggaranSeeder::class,
            RiwayatPenghargaanSeeder::class,
            DendaSeeder::class,
            PemberitahuanSeeder::class,
        ]);
    }
}
