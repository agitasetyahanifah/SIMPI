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
            $table->unsignedBigInteger('alat_pancing_id');
            $table->unsignedBigInteger('penyewaan_alat_id');
            $table->timestamps();

            $table->foreign('alat_pancing_id')->references('id')->on('alat_pancing')->onDelete('cascade');
            $table->foreign('penyewaan_alat_id')->references('id')->on('penyewaan_alat')->onDelete('cascade');
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
