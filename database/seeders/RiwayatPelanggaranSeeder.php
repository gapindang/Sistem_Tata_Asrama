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
        $warga = WargaAsrama::first();
        $petugas = Pengguna::where('role', 'petugas')->first();
        $pelanggaran = Pelanggaran::first();

        if (!$warga || !$petugas || !$pelanggaran) {
            $this->command->warn('Data warga/petugas/pelanggaran belum ada. Jalankan seeder lain dulu.');
            return;
        }

        RiwayatPelanggaran::create([
            'id_riwayat_pelanggaran' => Str::uuid(),
            'id_warga' => $warga->id_warga,
            'id_pelanggaran' => $pelanggaran->id_pelanggaran,
            'id_petugas' => $petugas->id_user,
            'tanggal' => now(),
            'status_sanksi' => 'belum',
        ]);
    }
}
