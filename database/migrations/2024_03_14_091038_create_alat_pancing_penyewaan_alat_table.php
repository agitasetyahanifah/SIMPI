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
        Schema::create('alat_pancing_penyewaan_alat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyewaan_alat_id')->constrained('penyewaan_alat')->onDelete('cascade');
            $table->foreignId('alat_pancing_id')->constrained('alat_pancing')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat_pancing_penyewaan_alat');
    }
};
