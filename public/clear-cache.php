<?php

/**
 * Clear Laravel Cache Script
 * Akses file ini via browser setelah deploy untuk clear cache
 * URL: https://capstone-dtei.um.ac.id/sitama/public/clear-cache.php
 */

// Path ke folder root Laravel
$laravelPath = dirname(__DIR__);

// Fungsi untuk menjalankan command artisan
function runArtisan($command)
{
    global $laravelPath;
    $output = shell_exec("cd $laravelPath && php artisan $command 2>&1");
    return $output;
}

echo "<html><head><title>Clear Cache - SITAMA</title>";
echo "<style>body{font-family:Arial,sans-serif;max-width:800px;margin:50px auto;padding:20px;}";
echo "h1{color:#0d6efd;}pre{background:#f8f9fa;padding:15px;border-radius:5px;overflow:auto;}";
echo ".success{color:#28a745;}.error{color:#dc3545;}</style></head><body>";

echo "<h1>🧹 Clear Laravel Cache - SITAMA</h1>";
echo "<p>Menjalankan perintah clear cache...</p>";

$commands = [
    'config:clear' => 'Clear Configuration Cache',
    'route:clear' => 'Clear Route Cache',
    'view:clear' => 'Clear View Cache',
    'cache:clear' => 'Clear Application Cache',
    'storage:link' => '🔗 Create Storage Symbolic Link (untuk gambar)',
    'config:cache' => 'Cache Configuration',
    'route:cache' => 'Cache Routes',
];

foreach ($commands as $command => $description) {
    echo "<h3>{$description}</h3>";
    echo "<pre>";
    $result = runArtisan($command);
    echo htmlspecialchars($result);
    echo "</pre>";
}

echo "<div class='success'><h2>✅ Selesai!</h2>";
echo "<p>Semua cache telah dibersihkan dan di-refresh.</p>";
echo "<p><a href='/'>← Kembali ke Halaman Utama</a></p></div>";

echo "</body></html>";

// Untuk keamanan, hapus atau rename file ini setelah digunakan
// atau tambahkan password protection
