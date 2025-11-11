<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Pemberitahuan;
use App\Models\Pengguna;
use Illuminate\Support\Facades\DB;

class PemberitahuanSeeder extends Seeder
{
    public function run(): void
    {
        $idUser = Pengguna::first()->id_user;

        DB::table('pemberitahuan')->insert([
            'id_notifikasi' => Str::uuid(),
            'id_user' => $idUser,
            'pesan' => 'Jangan lupa apel pagi besok!',
            'jenis' => 'umum',
            'tanggal' => now(),
            'status_baca' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
