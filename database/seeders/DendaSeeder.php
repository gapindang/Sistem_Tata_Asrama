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
        $riwayatPelanggarans = RiwayatPelanggaran::with('pelanggaran')->get();

        if ($riwayatPelanggarans->isEmpty()) {
            $this->command->warn('⚠️ Data riwayat pelanggaran belum ada, seeder dilewati.');
            return;
        }

        $statusOptions = ['belum', 'dibayar'];

        // Create fines for each violation record
        foreach ($riwayatPelanggarans as $riwayat) {
            $status = $statusOptions[array_rand($statusOptions)];
            $nominal = $riwayat->pelanggaran->denda ?? 10000;

            // If paid, set payment date between violation date and now
            $tanggalBayar = null;
            if ($status === 'dibayar') {
                $tanggalBayar = \Carbon\Carbon::parse($riwayat->tanggal)->addDays(rand(1, 30))->format('Y-m-d');
            }

            Denda::create([
                'id_denda' => Str::uuid(),
                'id_riwayat_pelanggaran' => $riwayat->id_riwayat_pelanggaran,
                'nominal' => $nominal,
                'status_bayar' => $status,
                'tanggal_bayar' => $tanggalBayar,
            ]);
        }
    }
}
