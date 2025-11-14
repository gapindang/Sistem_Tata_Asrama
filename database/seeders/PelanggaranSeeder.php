<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Pelanggaran;

class PelanggaranSeeder extends Seeder
{
    public function run(): void
    {
        $pelanggaranData = [
            [
                'nama_pelanggaran' => 'Terlambat Masuk Asrama',
                'kategori' => 'Ringan',
                'poin' => 5,
                'denda' => 10000,
                'deskripsi' => 'Melewati batas waktu masuk asrama yang telah ditentukan (melebihi jam 22.00).'
            ],
            [
                'nama_pelanggaran' => 'Tidak Mengikuti Apel Pagi',
                'kategori' => 'Ringan',
                'poin' => 10,
                'denda' => 15000,
                'deskripsi' => 'Tidak hadir dalam apel pagi tanpa keterangan yang jelas.'
            ],
            [
                'nama_pelanggaran' => 'Kamar Kotor',
                'kategori' => 'Ringan',
                'poin' => 5,
                'denda' => 20000,
                'deskripsi' => 'Kamar dalam kondisi tidak bersih saat inspeksi kebersihan rutin.'
            ],
            [
                'nama_pelanggaran' => 'Membuat Keributan',
                'kategori' => 'Sedang',
                'poin' => 15,
                'denda' => 30000,
                'deskripsi' => 'Membuat keributan yang mengganggu kenyamanan warga lain, terutama pada malam hari.'
            ],
            [
                'nama_pelanggaran' => 'Merokok di Area Asrama',
                'kategori' => 'Sedang',
                'poin' => 20,
                'denda' => 50000,
                'deskripsi' => 'Merokok di dalam area asrama yang telah ditetapkan sebagai zona bebas rokok.'
            ],
            [
                'nama_pelanggaran' => 'Merusak Fasilitas Asrama',
                'kategori' => 'Berat',
                'poin' => 30,
                'denda' => 100000,
                'deskripsi' => 'Dengan sengaja atau tidak sengaja merusak fasilitas asrama seperti pintu, jendela, atau peralatan lainnya.'
            ],
            [
                'nama_pelanggaran' => 'Membawa Tamu Tanpa Izin',
                'kategori' => 'Sedang',
                'poin' => 15,
                'denda' => 25000,
                'deskripsi' => 'Membawa tamu ke dalam asrama tanpa melaporkan ke petugas dan tanpa izin resmi.'
            ],
            [
                'nama_pelanggaran' => 'Tidak Ikut Piket',
                'kategori' => 'Ringan',
                'poin' => 5,
                'denda' => 10000,
                'deskripsi' => 'Tidak melaksanakan tugas piket kebersihan sesuai jadwal yang telah ditentukan.'
            ],
            [
                'nama_pelanggaran' => 'Kehilangan Kunci Kamar',
                'kategori' => 'Sedang',
                'poin' => 10,
                'denda' => 50000,
                'deskripsi' => 'Kehilangan kunci kamar yang menjadi tanggung jawab warga.'
            ],
            [
                'nama_pelanggaran' => 'Bertengkar dengan Warga Lain',
                'kategori' => 'Berat',
                'poin' => 50,
                'denda' => 150000,
                'deskripsi' => 'Terlibat perkelahian atau pertengkaran fisik dengan warga asrama lainnya.'
            ],
        ];

        foreach ($pelanggaranData as $data) {
            Pelanggaran::create(array_merge($data, [
                'id_pelanggaran' => Str::uuid(),
            ]));
        }
    }
}
