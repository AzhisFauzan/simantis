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
        Schema::create('riwayat_cetak', function (Blueprint $table) {
            $table->id();
            $table->integer('id_ruangan')->nullable();
            $table->string('jenis')->default('pdf');
            $table->timestamp('dicetak_pada')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_cetak');
    }
};
