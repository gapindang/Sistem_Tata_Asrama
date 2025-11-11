<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Denda;
use App\Models\RiwayatPelanggaran;

class DendaSeeder extends Seeder
{
    public function run(): void
    {
        $pelanggaran = RiwayatPelanggaran::first() ?? RiwayatPelanggaran::create([
            'id_riwayat_pelanggaran' => (string) Str::uuid(),
            'id_warga' => 'dummy-warga-id',
            'id_petugas' => 'dummy-petugas-id',
            'id_pelanggaran' => 'dummy-pelanggaran-id',
            'tanggal' => now(),
        ]);

        // Buat denda berdasarkan riwayat pelanggaran dummy
        Denda::create([
            'id_denda' => (string) Str::uuid(),
            'id_riwayat_pelanggaran' => $pelanggaran->id_riwayat_pelanggaran,
            'nominal' => 50000,
            'status_bayar' => 'belum',
            'tanggal_bayar' => null,
        ]);
    }
}
