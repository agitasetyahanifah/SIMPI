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
        Schema::create('sewa_alat', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sewa')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('alat_id');
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali');
            $table->integer('jumlah');
            $table->integer('biaya_sewa')->nullable();
            $table->integer('denda')->nullable();
            // $table->unsignedBigInteger('denda_id')->nullable();
            $table->enum('status', ['menunggu pembayaran', 'sudah dibayar', 'dibatalkan'])->default('menunggu pembayaran');
            $table->enum('status_pengembalian', ['proses', 'sudah kembali', 'terlambat kembali'])->nullable();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('alat_id')->references('id')->on('alat_pancing')->onDelete('cascade');
            // $table->foreign('denda_id')->references('id')->on('denda')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewa_alat');
    }
};
