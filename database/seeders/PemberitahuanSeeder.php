<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Pemberitahuan;
use App\Models\Pengguna;

class PemberitahuanSeeder extends Seeder
{
    public function run(): void
    {
        $penggunas = Pengguna::where('role', 'warga')->get();

        if ($penggunas->isEmpty()) {
            $this->command->warn('⚠️ Data warga belum ada, seeder dilewati.');
            return;
        }

        $notifikasiTemplates = [
            ['pesan' => 'Selamat datang di Sistem Tata Asrama! Silakan lengkapi profil Anda.', 'jenis' => 'umum'],
            ['pesan' => 'Jangan lupa mengikuti apel pagi besok jam 06.00 WIB.', 'jenis' => 'umum'],
            ['pesan' => 'Anda mendapatkan pelanggaran: Terlambat Masuk Asrama. Silakan cek detail di menu Riwayat Pelanggaran.', 'jenis' => 'pelanggaran'],
            ['pesan' => 'Selamat! Anda mendapatkan penghargaan: Kamar Terbersih. Lihat detail di menu Riwayat Penghargaan.', 'jenis' => 'penghargaan'],
            ['pesan' => 'Anda memiliki denda yang belum dibayar sebesar Rp 10.000. Mohon segera dilunasi.', 'jenis' => 'denda'],
            ['pesan' => 'Pengumuman: Akan ada inspeksi kebersihan kamar pada hari Jumat, 15 November 2025.', 'jenis' => 'umum'],
            ['pesan' => 'Reminder: Jadwal piket Anda hari ini. Jangan lupa melaksanakan tugas piket.', 'jenis' => 'umum'],
            ['pesan' => 'Denda Anda telah berhasil dibayar. Terima kasih atas kepatuhan Anda.', 'jenis' => 'denda'],
            ['pesan' => 'Pemberitahuan: Rapat warga akan diadakan pada hari Sabtu, 16 November 2025 pukul 16.00 WIB.', 'jenis' => 'umum'],
            ['pesan' => 'Anda tercatat tidak mengikuti piket kemarin. Harap segera konfirmasi ke petugas.', 'jenis' => 'pelanggaran'],
        ];

        $statusOptions = [true, false];

        // Create multiple notifications for each warga
        foreach ($penggunas as $pengguna) {
            // Each warga gets 3-5 random notifications
            $notifCount = rand(3, 5);
            $selectedNotifs = array_rand($notifikasiTemplates, $notifCount);

            if (!is_array($selectedNotifs)) {
                $selectedNotifs = [$selectedNotifs];
            }

            foreach ($selectedNotifs as $index) {
                $template = $notifikasiTemplates[$index];
                $statusBaca = $statusOptions[array_rand($statusOptions)];
                $tanggal = now()->subDays(rand(0, 30));

                Pemberitahuan::create([
                    'id_notifikasi' => Str::uuid(),
                    'id_user' => $pengguna->id_user,
                    'pesan' => $template['pesan'],
                    'jenis' => $template['jenis'],
                    'tanggal' => $tanggal,
                    'status_baca' => $statusBaca,
                ]);
            }
        }
    }
}
