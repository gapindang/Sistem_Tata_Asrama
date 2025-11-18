<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Checking Denda Database ===\n\n";

$dendaId = '45ac8a9f-18ec-4bf9-9d11-6a4c759e17b5';

// Get denda data
$denda = \App\Models\Denda::find($dendaId);

if ($denda) {
    echo "ID Denda: {$denda->id_denda}\n";
    echo "Bukti Bayar: " . ($denda->bukti_bayar ?? 'NULL') . "\n";
    echo "Tanggal Bayar: " . ($denda->tanggal_bayar ?? 'NULL') . "\n";
    echo "Status Bayar: {$denda->status_bayar}\n";
    echo "ID Riwayat Pelanggaran: {$denda->id_riwayat_pelanggaran}\n\n";

    echo "=== Checking Riwayat Pelanggaran ===\n\n";
    if ($denda->riwayatPelanggaran) {
        $riwayat = $denda->riwayatPelanggaran;
        echo "ID Riwayat: {$riwayat->id_riwayat_pelanggaran}\n";
        echo "ID Warga: {$riwayat->id_warga}\n";
        echo "Tanggal: {$riwayat->tanggal}\n";
        echo "Status Sanksi: {$riwayat->status_sanksi}\n";
        echo "Bukti (di riwayat): " . ($riwayat->bukti ?? 'NULL') . "\n";
    } else {
        echo "Riwayat Pelanggaran not found\n";
    }
} else {
    echo "Denda not found!\n";
}
