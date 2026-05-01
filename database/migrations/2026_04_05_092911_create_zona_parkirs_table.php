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
        Schema::create('zona_parkirs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_zona', 20);
            $table->string('keterangan', 100)->nullable();
            $table->integer('kapasitas_total');
            $table->string('kode_warna', 7);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zona_parkirs');
    }
};
