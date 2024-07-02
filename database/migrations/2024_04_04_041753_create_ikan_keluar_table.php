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
        Schema::create('ikan_keluar', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unsignedBigInteger('jenis_ikan_id');
            $table->integer('jumlah');
            $table->enum('kondisi_ikan', ['baik', 'sakit', 'mati']);
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('jenis_ikan_id')->references('id')->on('jenis_ikan');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ikan_keluar');
    }
};
