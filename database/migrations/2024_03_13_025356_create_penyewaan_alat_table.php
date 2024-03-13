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
            $table->foreignId('alat_pancing_id')->constrained('alat_pancing');
            $table->foreignId('denda_id')->constrained('denda'); 
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
