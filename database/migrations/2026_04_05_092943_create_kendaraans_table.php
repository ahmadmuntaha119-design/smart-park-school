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
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->cascadeOnDelete();
            $table->foreignId('id_zona')->nullable()->constrained('zona_parkirs')->nullOnDelete();
            $table->foreignId('id_merek')->constrained('merek_motors');
            $table->string('model_motor', 50);
            $table->string('plat_nomor', 15)->unique();
            $table->string('kelas', 20);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};
