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
        Schema::create('alat_pancing', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->string('nama_alat');
            $table->integer('harga');
            $table->integer('jumlah');
            $table->enum('status', ['available', 'not available'])->default('available');
            $table->text('spesifikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat_pancing');
    }
};
