<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\WargaAsrama;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class WargaSeeder extends Seeder
{
    public function run(): void
    {
        $wargaData = [
            ['nama' => 'Ahmad Ridwan', 'email' => 'ahmad.ridwan@student.um.ac.id', 'nim' => '20210001', 'kamar' => 'A1', 'angkatan' => '2021'],
            ['nama' => 'Siti Aminah', 'email' => 'siti.aminah@student.um.ac.id', 'nim' => '20210002', 'kamar' => 'A2', 'angkatan' => '2021'],
            ['nama' => 'Budi Santoso', 'email' => 'budi.santoso@student.um.ac.id', 'nim' => '20210003', 'kamar' => 'A3', 'angkatan' => '2021'],
            ['nama' => 'Dewi Lestari', 'email' => 'dewi.lestari@student.um.ac.id', 'nim' => '20210004', 'kamar' => 'B1', 'angkatan' => '2021'],
            ['nama' => 'Eko Prasetyo', 'email' => 'eko.prasetyo@student.um.ac.id', 'nim' => '20210005', 'kamar' => 'B2', 'angkatan' => '2021'],
            ['nama' => 'Fitri Handayani', 'email' => 'fitri.handayani@student.um.ac.id', 'nim' => '20220001', 'kamar' => 'B3', 'angkatan' => '2022'],
            ['nama' => 'Gilang Ramadhan', 'email' => 'gilang.ramadhan@student.um.ac.id', 'nim' => '20220002', 'kamar' => 'C1', 'angkatan' => '2022'],
            ['nama' => 'Hana Pertiwi', 'email' => 'hana.pertiwi@student.um.ac.id', 'nim' => '20220003', 'kamar' => 'C2', 'angkatan' => '2022'],
            ['nama' => 'Irfan Hakim', 'email' => 'irfan.hakim@student.um.ac.id', 'nim' => '20220004', 'kamar' => 'C3', 'angkatan' => '2022'],
            ['nama' => 'Joko Widodo', 'email' => 'joko.widodo@student.um.ac.id', 'nim' => '20220005', 'kamar' => 'D1', 'angkatan' => '2022'],
            ['nama' => 'Kartika Sari', 'email' => 'kartika.sari@student.um.ac.id', 'nim' => '20230001', 'kamar' => 'D2', 'angkatan' => '2023'],
            ['nama' => 'Lukman Hakim', 'email' => 'lukman.hakim@student.um.ac.id', 'nim' => '20230002', 'kamar' => 'D3', 'angkatan' => '2023'],
            ['nama' => 'Maya Anggraini', 'email' => 'maya.anggraini@student.um.ac.id', 'nim' => '20230003', 'kamar' => 'E1', 'angkatan' => '2023'],
            ['nama' => 'Nanda Pratama', 'email' => 'nanda.pratama@student.um.ac.id', 'nim' => '20230004', 'kamar' => 'E2', 'angkatan' => '2023'],
            ['nama' => 'Olivia Rahman', 'email' => 'olivia.rahman@student.um.ac.id', 'nim' => '20230005', 'kamar' => 'E3', 'angkatan' => '2023'],
        ];

        foreach ($wargaData as $data) {
            $pengguna = Pengguna::create([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make('warga123'),
                'role' => 'warga',
            ]);

            WargaAsrama::create([
                'id_warga' => Str::uuid(),
                'nama' => $data['nama'],
                'nim' => $data['nim'],
                'kamar' => $data['kamar'],
                'angkatan' => $data['angkatan'],
                'status' => 'aktif',
                'id_user' => $pengguna->id_user,
            ]);
        }
    }
}
