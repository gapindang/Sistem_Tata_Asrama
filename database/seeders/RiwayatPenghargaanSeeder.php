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
        $wargas = WargaAsrama::all();
        $petugases = Pengguna::where('role', 'petugas')->get();
        $penghargaans = Penghargaan::all();

        if ($wargas->isEmpty() || $petugases->isEmpty() || $penghargaans->isEmpty()) {
            $this->command->warn('⚠️ Data warga/petugas/penghargaan belum ada, seeder dilewati.');
            return;
        }

        // Create 20 achievement records with varied data
        for ($i = 0; $i < 20; $i++) {
            $warga = $wargas->random();
            $petugas = $petugases->random();
            $penghargaan = $penghargaans->random();

            // Random date within last 6 months
            $tanggal = now()->subDays(rand(0, 180));

            RiwayatPenghargaan::create([
                'id_riwayat_penghargaan' => Str::uuid(),
                'id_warga' => $warga->id_warga,
                'id_penghargaan' => $penghargaan->id_penghargaan,
                'id_petugas' => $petugas->id_user,
                'tanggal' => $tanggal,
            ]);
        }
    }
}
