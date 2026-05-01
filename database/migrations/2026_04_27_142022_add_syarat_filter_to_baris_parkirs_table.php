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
        Schema::table('baris_parkirs', function (Blueprint $table) {
            $table->json('syarat_filter')->nullable()->after('kapasitas');
        });
    }

    public function down(): void
    {
        Schema::table('baris_parkirs', function (Blueprint $table) {
            $table->dropColumn('syarat_filter');
        });
    }
};
