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
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sewa_spot_id')->nullable();
            $table->unsignedBigInteger('sewa_alat_id')->nullable();
            $table->date('tanggal_transaksi');
            $table->time('waktu_transaksi');
            $table->integer('jumlah');
            $table->enum('jenis_transaksi', ['pemasukan', 'pengeluaran']);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        
            // Menambahkan foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sewa_spot_id')->references('id')->on('sewa_spots')->onDelete('cascade');
            $table->foreign('sewa_alat_id')->references('id')->on('sewa_alat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
