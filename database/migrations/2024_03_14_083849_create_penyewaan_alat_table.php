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
        Schema::create('penyewaan_alat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali');
            $table->integer('biaya_sewa');
            $table->enum('status', ['sewa', 'selesai'])->default('sewa');
            $table->unsignedBigInteger('alat_pancing_id')->nullable(); // Ubah menjadi nullable
            $table->foreign('alat_pancing_id')->references('id')->on('alat_pancing')->onDelete('cascade');
            $table->foreignId('denda_id')->nullable()->constrained('denda');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyewaan_alat');
    }
};
