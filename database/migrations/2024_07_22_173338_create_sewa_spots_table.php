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
        Schema::create('sewa_spots', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe_sewa', ['member', 'non member']);
            $table->string('kode_booking')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('tanggal_sewa');
            $table->unsignedBigInteger('spot_id');
            $table->enum('status', ['sudah dibayar', 'menunggu pembayaran', 'dibatalkan'])->default('menunggu pembayaran');
            $table->enum('status_kehadiran', ['tidak hadir', 'belum hadir', 'sudah hadir'])->default('belum hadir');
            $table->unsignedBigInteger('sesi_id');
            $table->unsignedBigInteger('harga_id');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('spot_id')->references('id')->on('spots')->onDelete('cascade');
            $table->foreign('sesi_id')->references('id')->on('update_sesi_sewa_spots')->onDelete('cascade');
            $table->foreign('harga_id')->references('id')->on('update_harga_sewa_spots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sewa_spots', function (Blueprint $table) {
            // Drop foreign key constraints before dropping the columns
            $table->dropForeign(['user_id']);
            $table->dropForeign(['spot_id']);
            $table->dropForeign(['sesi_id']);
            $table->dropForeign(['harga_id']);
        });

        Schema::dropIfExists('sewa_spots');
    }
};
