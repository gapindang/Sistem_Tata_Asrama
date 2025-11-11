<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Penghargaan;
use App\Models\WargaAsrama;
use Illuminate\Support\Facades\DB;

class PenghargaanSeeder extends Seeder
{
    public function run(): void
    {
        $warga = WargaAsrama::all();

        foreach ($warga as $item) {
            DB::table('penghargaan')->insert([
                'id_penghargaan' => Str::uuid(),
                'id_warga' => $item->id_warga,
                'nama_penghargaan' => 'Kebersihan Asrama',
                'poin_reward' => 10,
                'deskripsi' => 'Warga yang selalu menjaga kebersihan dan kerapian kamar asrama.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
