<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Penghargaan;

class PenghargaanSeeder extends Seeder
{
    public function run(): void
    {
        $penghargaanData = [
            [
                'nama_penghargaan' => 'Kamar Terbersih',
                'poin_reward' => 20,
                'deskripsi' => 'Penghargaan untuk warga yang memiliki kamar paling bersih dan rapi selama sebulan.'
            ],
            [
                'nama_penghargaan' => 'Kehadiran Sempurna',
                'poin_reward' => 15,
                'deskripsi' => 'Diberikan kepada warga yang tidak pernah absen dalam kegiatan apel pagi selama sebulan.'
            ],
            [
                'nama_penghargaan' => 'Warga Teladan',
                'poin_reward' => 30,
                'deskripsi' => 'Penghargaan tertinggi untuk warga yang menunjukkan perilaku terbaik dan menjadi panutan.'
            ],
            [
                'nama_penghargaan' => 'Prestasi Akademik',
                'poin_reward' => 25,
                'deskripsi' => 'Diberikan kepada warga yang meraih prestasi akademik gemilang di kampus.'
            ],
            [
                'nama_penghargaan' => 'Aktif Berorganisasi',
                'poin_reward' => 15,
                'deskripsi' => 'Penghargaan untuk warga yang aktif dalam kegiatan organisasi kemahasiswaan.'
            ],
            [
                'nama_penghargaan' => 'Piket Terbaik',
                'poin_reward' => 10,
                'deskripsi' => 'Warga yang selalu melaksanakan tugas piket dengan baik dan tepat waktu.'
            ],
            [
                'nama_penghargaan' => 'Peduli Lingkungan',
                'poin_reward' => 15,
                'deskripsi' => 'Diberikan kepada warga yang peduli dengan kebersihan dan kelestarian lingkungan asrama.'
            ],
            [
                'nama_penghargaan' => 'Inovasi Asrama',
                'poin_reward' => 20,
                'deskripsi' => 'Penghargaan untuk warga yang memberikan ide atau inovasi bermanfaat untuk asrama.'
            ],
        ];

        foreach ($penghargaanData as $data) {
            Penghargaan::create(array_merge($data, [
                'id_penghargaan' => Str::uuid(),
            ]));
        }
    }
}
