<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel pengaduan_masuk menyimpan notifikasi pengaduan
     * yang dikirim dari SIPITRS ke sistemInventaris.
     */
    public function up(): void
    {
        Schema::create('pengaduan_masuk', function (Blueprint $table) {
            $table->id();
            $table->integer('id_ruangan');
            $table->string('nama_ruangan')->nullable();
            $table->text('deskripsi');
            $table->enum('status', ['Pending', 'Diproses', 'Selesai'])->default('Pending');
            $table->text('catatan')->nullable();          // catatan balasan dari teknisi
            $table->timestamp('tanggal')->nullable();     // waktu pengaduan dari SIPITRS
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan_masuk');
    }
};
