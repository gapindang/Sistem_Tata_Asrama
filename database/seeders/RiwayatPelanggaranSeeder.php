<?php

namespace Database\Seeders;

use App\Models\Pelanggaran;
use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\RiwayatPelanggaran;
use App\Models\WargaAsrama;

class RiwayatPelanggaranSeeder extends Seeder
{
    public function run(): void
    {
        $wargas = WargaAsrama::all();
        $petugases = Pengguna::where('role', 'petugas')->get();
        $pelanggarans = Pelanggaran::all();

        if ($wargas->isEmpty() || $petugases->isEmpty() || $pelanggarans->isEmpty()) {
            $this->command->warn('Data warga/petugas/pelanggaran belum ada. Jalankan seeder lain dulu.');
            return;
        }

        // Create 25 violation records with varied data
        $statusOptions = ['belum', 'proses', 'selesai'];

        for ($i = 0; $i < 25; $i++) {
            $warga = $wargas->random();
            $petugas = $petugases->random();
            $pelanggaran = $pelanggarans->random();
            $status = $statusOptions[array_rand($statusOptions)];

            // Random date within last 6 months
            $tanggal = now()->subDays(rand(0, 180));

            RiwayatPelanggaran::create([
                'id_riwayat_pelanggaran' => Str::uuid(),
                'id_warga' => $warga->id_warga,
                'id_pelanggaran' => $pelanggaran->id_pelanggaran,
                'id_petugas' => $petugas->id_user,
                'tanggal' => $tanggal,
                'status_sanksi' => $status,
            ]);
        }
    }
}
