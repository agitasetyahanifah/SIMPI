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
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali');
            $table->integer('biaya_sewa')->nullable();
            $table->enum('status', ['sudah dibayar', 'belum dibayar'])->default('belum dibayar');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Tabel pivot untuk relasi many-to-many
        Schema::create('alat_sewa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sewa_id');
            $table->unsignedBigInteger('alat_id');
            $table->timestamps();

            $table->foreign('sewa_id')->references('id')->on('sewa_alat')->onDelete('cascade');
            $table->foreign('alat_id')->references('id')->on('alat_pancing')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat_sewa');
        Schema::dropIfExists('sewa_alat');    }
};
