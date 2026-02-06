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
        // Create user table
        Schema::create('user', function (Blueprint $table) {
            $table->id('idUser');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('peran');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // Create kategori table
        Schema::create('kategori', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama_kategori');
            $table->text('deskripsi')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        // Create pemberikerja table
        Schema::create('pemberikerja', function (Blueprint $table) {
            $table->id('idPemberiKerja');
            $table->unsignedBigInteger('idUser');
            $table->string('nama_perusahaan')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('idUser')->references('idUser')->on('user')->onDelete('cascade');
            $table->unique('idUser');
        });

        // Create pekerja table
        Schema::create('pekerja', function (Blueprint $table) {
            $table->id('idPekerja');
            $table->unsignedBigInteger('idUser');
            $table->text('keahlian')->nullable();
            $table->text('pengalaman')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('idUser')->references('idUser')->on('user')->onDelete('cascade');
            $table->unique('idUser');
        });

        // Create lowongan table
        Schema::create('lowongan', function (Blueprint $table) {
            $table->id('idLowongan');
            $table->unsignedBigInteger('idPemberiKerja');
            $table->string('judul');
            $table->text('deskripsi');
            $table->text('gambar')->nullable();
            $table->string('lokasi');
            $table->decimal('upah', 15, 2)->nullable();
            $table->string('status')->default('aktif');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('idPemberiKerja')->references('idPemberiKerja')->on('pemberikerja')->onDelete('cascade');
            $table->index('status');
            $table->index('lokasi');
        });

        // Create lowongan_kategori table
        Schema::create('lowongan_kategori', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idLowongan');
            $table->unsignedBigInteger('id_kategori');

            $table->foreign('idLowongan')->references('idLowongan')->on('lowongan')->onDelete('cascade');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
            $table->unique(['idLowongan', 'id_kategori']);
        });

        // Create lamaran table
        Schema::create('lamaran', function (Blueprint $table) {
            $table->id('idLamaran');
            $table->unsignedBigInteger('idLowongan');
            $table->unsignedBigInteger('idPekerja');
            $table->date('tanggal_lamaran');
            $table->string('status_lamaran')->default('pending');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('idLowongan')->references('idLowongan')->on('lowongan')->onDelete('cascade');
            $table->foreign('idPekerja')->references('idPekerja')->on('pekerja')->onDelete('cascade');
            $table->unique(['idLowongan', 'idPekerja']);
            $table->index('status_lamaran');
        });

        // Create pekerjaan table
        Schema::create('pekerjaan', function (Blueprint $table) {
            $table->id('idPekerjaan');
            $table->unsignedBigInteger('idLamaran');
            $table->string('status_pekerjaan')->default('berjalan');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('idLamaran')->references('idLamaran')->on('lamaran')->onDelete('cascade');
            $table->index('status_pekerjaan');
        });

        // Create rating table
        Schema::create('rating', function (Blueprint $table) {
            $table->id('idRating');
            $table->unsignedBigInteger('idPekerjaan');
            $table->integer('nilai_rating');
            $table->text('ulasan')->nullable();
            $table->string('pemberi_rating');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('idPekerjaan')->references('idPekerjaan')->on('pekerjaan')->onDelete('cascade');
            $table->index('nilai_rating');
        });

        // Create favorit table
        Schema::create('favorit', function (Blueprint $table) {
            $table->id('id_favorit');
            $table->unsignedBigInteger('idPekerja');
            $table->unsignedBigInteger('idLowongan');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('idPekerja')->references('idPekerja')->on('pekerja')->onDelete('cascade');
            $table->foreign('idLowongan')->references('idLowongan')->on('lowongan')->onDelete('cascade');
            $table->unique(['idPekerja', 'idLowongan']);
        });

        // Create notifikasi table
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->unsignedBigInteger('idUser');
            $table->string('tipe_notifikasi');
            $table->text('pesan');
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('idUser')->references('idUser')->on('user')->onDelete('cascade');
        });

        // Create chat_conversation table
        Schema::create('chat_conversation', function (Blueprint $table) {
            $table->id('id_conversation');
            $table->unsignedBigInteger('idPekerja');
            $table->unsignedBigInteger('idPemberiKerja');
            $table->unsignedBigInteger('idLowongan')->nullable();
            $table->timestamp('last_message_time')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('idPekerja')->references('idPekerja')->on('pekerja')->onDelete('cascade');
            $table->foreign('idPemberiKerja')->references('idPemberiKerja')->on('pemberikerja')->onDelete('cascade');
            $table->foreign('idLowongan')->references('idLowongan')->on('lowongan')->nullOnDelete();
            $table->unique(['idPekerja', 'idPemberiKerja', 'idLowongan']);
        });

        // Create chat_message table
        Schema::create('chat_message', function (Blueprint $table) {
            $table->id('id_message');
            $table->unsignedBigInteger('id_conversation');
            $table->unsignedBigInteger('id_sender');
            $table->text('message_text');
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_conversation')->references('id_conversation')->on('chat_conversation')->onDelete('cascade');
            $table->foreign('id_sender')->references('idUser')->on('user')->onDelete('cascade');
        });

        // Create activity_log table
        Schema::create('activity_log', function (Blueprint $table) {
            $table->id('id_log');
            $table->unsignedBigInteger('idUser')->nullable();
            $table->string('activity_type');
            $table->text('description')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('idUser')->references('idUser')->on('user')->nullOnDelete();
        });

        // Create pencarian_log table
        Schema::create('pencarian_log', function (Blueprint $table) {
            $table->id('id_pencarian');
            $table->unsignedBigInteger('idUser')->nullable();
            $table->string('keyword');
            $table->string('lokasi')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('idUser')->references('idUser')->on('user')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencarian_log');
        Schema::dropIfExists('activity_log');
        Schema::dropIfExists('chat_message');
        Schema::dropIfExists('chat_conversation');
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('favorit');
        Schema::dropIfExists('rating');
        Schema::dropIfExists('pekerjaan');
        Schema::dropIfExists('lamaran');
        Schema::dropIfExists('lowongan_kategori');
        Schema::dropIfExists('lowongan');
        Schema::dropIfExists('pekerja');
        Schema::dropIfExists('pemberikerja');
        Schema::dropIfExists('kategori');
        Schema::dropIfExists('user');
    }
};
