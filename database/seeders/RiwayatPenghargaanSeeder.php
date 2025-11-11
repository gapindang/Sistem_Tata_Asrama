<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use App\Models\Penghargaan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\RiwayatPenghargaan;
use App\Models\WargaAsrama;

class RiwayatPenghargaanSeeder extends Seeder
{
    public function run(): void
    {
        $warga = WargaAsrama::first();
        $petugas = Pengguna::where('role', 'petugas')->first();
        $penghargaan = Penghargaan::first();

        if (!$warga || !$petugas || !$penghargaan) {
            $this->command->warn('⚠️ Data warga/petugas/penghargaan belum ada, seeder dilewati.');
            return;
        }

        RiwayatPenghargaan::create([
            'id_riwayat_penghargaan' => Str::uuid(),
            'id_warga' => $warga->id_warga,
            'id_penghargaan' => $penghargaan->id_penghargaan,
            'id_petugas' => $petugas->id_user, // 🔥 WAJIB ditambahkan
            'tanggal' => now(),
        ]);
    }
}
