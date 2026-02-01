<?php
// Script untuk menambahkan kategori Digital ke database

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Menambahkan kategori Digital...\n\n";

try {
    // Cek apakah kategori Digital sudah ada
    $exists = DB::table('kategori')->where('nama_kategori', 'Digital')->exists();
    
    if ($exists) {
        echo "✓ Kategori 'Digital' sudah ada di database\n";
    } else {
        // Tambahkan kategori Digital
        DB::table('kategori')->insert([
            'nama_kategori' => 'Digital',
            'deskripsi' => 'Pekerjaan digital seperti desain, programming, dll',
            'created_at' => now()
        ]);
        
        echo "✓ Kategori 'Digital' berhasil ditambahkan!\n";
    }
    
    // Tampilkan semua kategori
    echo "\n=== Daftar Semua Kategori ===\n";
    $kategori = DB::table('kategori')->select('id_kategori', 'nama_kategori')->get();
    
    foreach ($kategori as $kat) {
        echo "{$kat->id_kategori}. {$kat->nama_kategori}\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== Selesai! ===\n";
