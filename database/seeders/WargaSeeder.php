<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\WargaAsrama;
use Illuminate\Support\Facades\DB;

class WargaSeeder extends Seeder
{
    public function run(): void
    {
        $idUser = Str::uuid();

        DB::table('pengguna')->insert([
            'id_user' => $idUser,
            'nama' => 'Warga Satu',
            'email' => 'warga1@example.com',
            'password' => bcrypt('password'),
        ]);

        DB::table('warga_asrama')->insert([
            'id_warga' => Str::uuid(),
            'nama' => 'Warga Satu',
            'nim' => '20210001',
            'kamar' => 'A1',
            'angkatan' => '2021',
            'status' => 'aktif',
            'id_user' => $idUser,
        ]);

        $idUser2 = Str::uuid();
        DB::table('pengguna')->insert([
            'id_user' => $idUser2,
            'nama' => 'Warga Dua',
            'email' => 'warga2@example.com',
            'password' => bcrypt('password'),
        ]);

        WargaAsrama::create([
            'id_warga' => Str::uuid(),
            'nama' => 'Warga Dua',
            'nim' => '20210002',
            'kamar' => 'A2',
            'angkatan' => '2021',
            'status' => 'aktif',
            'id_user' => $idUser2,
        ]);
    }
}
