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
        Schema::create('motors', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('plat_nomor')->unique();
            $table->string('tipe');
            $table->integer('tahun_produksi');
            $table->string('warna');
            $table->double('harga_sewa');
            $table->enum('status', ['tersedia', 'disewa', 'maintenance'])->default('tersedia');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motors');
    }
};
