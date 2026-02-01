<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lowongan', function (Blueprint $table) {
            // Menambahkan kolom gambar setelah kolom deskripsi
            // Format: JSON array untuk menyimpan multiple image paths
            // Contoh: ["uploads/lowongan/img1.jpg", "uploads/lowongan/img2.jpg"]
            $table->text('gambar')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lowongan', function (Blueprint $table) {
            // Menghapus kolom gambar jika rollback
            $table->dropColumn('gambar');
        });
    }
};
