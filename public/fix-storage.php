<?php

/**
 * Fix Storage Link - SITAMA
 * File ini untuk membuat symbolic link storage agar gambar bisa tampil
 * Akses via: https://capstone-dtei.um.ac.id/sitama/public/fix-storage.php
 */

echo "<html><head><title>Fix Storage Link - SITAMA</title>";
echo "<style>body{font-family:Arial,sans-serif;max-width:800px;margin:50px auto;padding:20px;}";
echo "h1{color:#0d6efd;}pre{background:#f8f9fa;padding:15px;border-radius:5px;}";
echo ".success{color:#28a745;background:#d4edda;padding:15px;border-radius:5px;margin:20px 0;}";
echo ".error{color:#dc3545;background:#f8d7da;padding:15px;border-radius:5px;margin:20px 0;}";
echo ".info{color:#0c5460;background:#d1ecf1;padding:15px;border-radius:5px;margin:20px 0;}</style></head><body>";

echo "<h1>🔧 Fix Storage Link - SITAMA</h1>";

$rootPath = dirname(__DIR__);
$publicPath = __DIR__;
$storagePath = $rootPath . '/storage/app/public';
$linkPath = $publicPath . '/storage';

echo "<div class='info'>";
echo "<h3>📍 Path Information:</h3>";
echo "<strong>Storage Source:</strong> {$storagePath}<br>";
echo "<strong>Public Link:</strong> {$linkPath}";
echo "</div>";

// Cek apakah link sudah ada
if (file_exists($linkPath)) {
    echo "<div class='error'>";
    echo "<h3>⚠️ Link sudah ada!</h3>";
    echo "<p>Symbolic link <code>public/storage</code> sudah ada.</p>";

    // Cek apakah itu symlink atau folder biasa
    if (is_link($linkPath)) {
        $target = readlink($linkPath);
        echo "<p>Link mengarah ke: <code>{$target}</code></p>";

        // Hapus link lama
        echo "<p>Menghapus link lama...</p>";
        @unlink($linkPath);
        echo "<p class='success'>✅ Link lama berhasil dihapus.</p>";
    } else {
        echo "<p class='error'>❌ <code>public/storage</code> adalah folder biasa, bukan symbolic link!</p>";
        echo "<p>Silakan hapus folder <code>public/storage</code> secara manual via FTP/File Manager, lalu refresh halaman ini.</p>";
        echo "</div></body></html>";
        exit;
    }
    echo "</div>";
}

// Buat symbolic link baru
echo "<h3>🔗 Membuat Symbolic Link...</h3>";

// Cek apakah folder storage/app/public ada
if (!file_exists($storagePath)) {
    echo "<div class='error'>";
    echo "<p>❌ Folder <code>storage/app/public</code> tidak ditemukan!</p>";
    echo "<p>Buat folder tersebut terlebih dahulu.</p>";
    echo "</div></body></html>";
    exit;
}

// Metode 1: symlink() function
$success = @symlink($storagePath, $linkPath);

if ($success) {
    echo "<div class='success'>";
    echo "<h3>✅ Berhasil!</h3>";
    echo "<p>Symbolic link berhasil dibuat dengan fungsi <code>symlink()</code></p>";
    echo "<p>Gambar sekarang seharusnya bisa ditampilkan.</p>";
    echo "</div>";
} else {
    // Metode 2: Via artisan command
    echo "<p>Metode symlink() gagal, mencoba via artisan...</p>";

    $output = shell_exec("cd {$rootPath} && php artisan storage:link 2>&1");

    echo "<pre>" . htmlspecialchars($output) . "</pre>";

    if (file_exists($linkPath)) {
        echo "<div class='success'>";
        echo "<h3>✅ Berhasil!</h3>";
        echo "<p>Symbolic link berhasil dibuat via artisan command.</p>";
        echo "<p>Gambar sekarang seharusnya bisa ditampilkan.</p>";
        echo "</div>";
    } else {
        echo "<div class='error'>";
        echo "<h3>❌ Gagal!</h3>";
        echo "<p>Tidak bisa membuat symbolic link secara otomatis.</p>";
        echo "<h4>Solusi Manual:</h4>";
        echo "<ol>";
        echo "<li>Login ke cPanel atau File Manager hosting</li>";
        echo "<li>Buka <strong>Terminal/SSH</strong></li>";
        echo "<li>Jalankan perintah:</li>";
        echo "<pre>cd " . $rootPath . "\nphp artisan storage:link</pre>";
        echo "<li>Atau hubungi support hosting untuk bantuan membuat symbolic link</li>";
        echo "</ol>";
        echo "</div>";
    }
}

echo "<hr>";
echo "<h3>🧪 Testing Storage Link</h3>";

if (file_exists($linkPath)) {
    echo "<p class='success'>✅ Folder <code>public/storage</code> ada</p>";

    if (is_link($linkPath)) {
        echo "<p class='success'>✅ Adalah symbolic link</p>";
        $target = readlink($linkPath);
        echo "<p>Target: <code>{$target}</code></p>";
    } else {
        echo "<p class='error'>⚠️ Bukan symbolic link (folder biasa)</p>";
    }

    // Test write permission
    $testFile = $linkPath . '/test.txt';
    if (@file_put_contents($testFile, 'test')) {
        echo "<p class='success'>✅ Permission: OK (bisa write)</p>";
        @unlink($testFile);
    } else {
        echo "<p class='error'>❌ Permission: Tidak bisa write</p>";
    }
} else {
    echo "<p class='error'>❌ Folder <code>public/storage</code> tidak ada</p>";
}

echo "<hr>";
echo "<div class='info'>";
echo "<h3>📝 Catatan:</h3>";
echo "<ul>";
echo "<li>Setelah symbolic link dibuat, upload gambar baru untuk testing</li>";
echo "<li>File ini bisa dihapus setelah masalah teratasi</li>";
echo "<li>Jika masih bermasalah, hubungi support hosting</li>";
echo "</ul>";
echo "<p><a href='/admin/pengaturan'>← Ke Halaman Pengaturan</a> | <a href='/'>Ke Beranda</a></p>";
echo "</div>";

echo "</body></html>";
