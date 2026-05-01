<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan: warna motor, jenis transmisi (Matic/Manual), dan relasi ke baris parkir.
     */
    public function up(): void
    {
        Schema::table('kendaraans', function (Blueprint $table) {
            // Warna motor (dipilih dari dropdown standar saat daftar)
            $table->string('warna', 50)->nullable()->after('model_motor');

            // Jenis transmisi motor
            $table->enum('jenis_transmisi', ['Matic', 'Manual'])->nullable()->after('warna');

            // Relasi ke baris parkir (nullable: bisa belum di-assign)
            $table->foreignId('id_baris')
                  ->nullable()
                  ->after('id_zona')
                  ->constrained('baris_parkirs')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kendaraans', function (Blueprint $table) {
            $table->dropForeign(['id_baris']);
            $table->dropColumn(['warna', 'jenis_transmisi', 'id_baris']);
        });
    }
};
