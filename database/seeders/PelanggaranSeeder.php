<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Pelanggaran;
use App\Models\WargaAsrama;

class PelanggaranSeeder extends Seeder
{
    public function run(): void
    {
        $warga = WargaAsrama::all();

        foreach ($warga as $item) {
            Pelanggaran::create([
                'id_pelanggaran' => Str::uuid(),
                'id_warga' => $item->id_warga,
                'nama_pelanggaran' => 'Terlambat Mengembalikan Kunci',
                'kategori' => 'Ringan',
                'poin' => 5,
                'denda' => 10000,
                'deskripsi' => 'Warga yang terlambat mengembalikan kunci kamar setelah keluar asrama.',
            ]);
        }
    }
}
