<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensi_parkirs', function (Blueprint $table) {
            // Dokumen foto bukti fisik (diambil dari kamera live)
            $table->string('foto_bukti_masuk')->nullable()->after('waktu_keluar');
            // Koordinat GPS saat check-in (bisa null jika permission ditolak)
            $table->decimal('latitude_masuk', 10, 7)->nullable()->after('foto_bukti_masuk');
            $table->decimal('longitude_masuk', 10, 7)->nullable()->after('latitude_masuk');
            // Jarak dalam meter dari pusat sekolah saat check-in
            $table->integer('jarak_dari_sekolah')->nullable()->after('longitude_masuk');
        });
    }

    public function down(): void
    {
        Schema::table('absensi_parkirs', function (Blueprint $table) {
            $table->dropColumn(['foto_bukti_masuk', 'latitude_masuk', 'longitude_masuk', 'jarak_dari_sekolah']);
        });
    }
};
