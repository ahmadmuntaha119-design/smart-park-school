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
        Schema::create('barang_temuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_admin')->constrained('users')->cascadeOnDelete();
            $table->string('nama_barang', 100);
            $table->string('lokasi_ditemukan', 100);
            $table->string('path_foto', 255);
            $table->enum('status', ['Belum Diambil', 'Sudah Selesai'])->default('Belum Diambil');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_temuans');
    }
};
