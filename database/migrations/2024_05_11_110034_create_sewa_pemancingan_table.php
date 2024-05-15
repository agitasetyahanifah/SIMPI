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
        Schema::create('sewa_pemancingan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->unique();
            $table->unsignedBigInteger('user_id');
            $table->date('tanggal_sewa');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('jumlah_sewa');
            $table->integer('biaya_sewa')->nullable();
            $table->enum('status', ['belum dibayar', 'sudah dibayar'])->default('belum dibayar');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewa_pemancingan');
    }
};
