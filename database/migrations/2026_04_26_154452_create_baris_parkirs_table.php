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
        Schema::create('baris_parkirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_zona')->constrained('zona_parkirs')->cascadeOnDelete();
            $table->string('nama_baris', 30); // Misal: "Baris 1", "Baris 2"
            $table->integer('kapasitas');     // Jumlah slot motor di baris ini
            $table->timestamps();

            // Tidak boleh ada duplikat nama baris dalam 1 zona
            $table->unique(['id_zona', 'nama_baris']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baris_parkirs');
    }
};
