<?php
// Script untuk restore database KerjaKita dan menghapus tabel yang tidak terpakai

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Memulai proses pembersihan database...\n\n";

// Daftar tabel yang akan dihapus (tabel Laravel default yang tidak terpakai)
$tabelTidakTerpakai = [
    'password_reset_tokens',
    'sessions',
    'cache',
    'cache_locks',
    'jobs',
    'job_batches',
    'failed_jobs',
];

// Hapus tabel yang tidak terpakai
foreach ($tabelTidakTerpakai as $tabel) {
    try {
        DB::statement("DROP TABLE IF EXISTS `$tabel`");
        echo "✓ Tabel '$tabel' berhasil dihapus\n";
    } catch (Exception $e) {
        echo "✗ Gagal menghapus tabel '$tabel': " . $e->getMessage() . "\n";
    }
}

// Tambahkan kolom gambar ke tabel lowongan jika belum ada
try {
    $hasGambarColumn = DB::select("SHOW COLUMNS FROM `lowongan` LIKE 'gambar'");
    
    if (empty($hasGambarColumn)) {
        DB::statement("ALTER TABLE `lowongan` ADD COLUMN `gambar` TEXT NULL AFTER `deskripsi`");
        echo "\n✓ Kolom 'gambar' berhasil ditambahkan ke tabel 'lowongan'\n";
    } else {
        echo "\n✓ Kolom 'gambar' sudah ada di tabel 'lowongan'\n";
    }
} catch (Exception $e) {
    echo "\n✗ Gagal menambahkan kolom 'gambar': " . $e->getMessage() . "\n";
}

echo "\n=== Proses selesai! ===\n";
echo "Database sudah dibersihkan dari tabel yang tidak terpakai.\n";
