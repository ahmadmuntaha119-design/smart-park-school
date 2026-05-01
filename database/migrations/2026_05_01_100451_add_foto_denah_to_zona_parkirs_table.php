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
        Schema::table('zona_parkirs', function (Blueprint $table) {
            $table->string('foto_denah')->nullable()->after('keterangan');
        });
    }

    public function down(): void
    {
        Schema::table('zona_parkirs', function (Blueprint $table) {
            $table->dropColumn('foto_denah');
        });
    }
};
