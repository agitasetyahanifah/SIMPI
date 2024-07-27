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
        Schema::create('update_sesi_sewa_spots', function (Blueprint $table) {
            $table->id();
            $table->string('waktu_mulai');
            $table->string('waktu_selesai');
            $table->string('waktu_sesi')->nullable();
            $table->unsignedBigInteger('user_id');

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('update_sesi_sewa_spots');
    }
};
