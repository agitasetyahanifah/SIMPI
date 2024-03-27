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
            $table->string('jenis_ikan');
            $table->integer('jumlah');
            $table->string('kondisi_ikan');
            $table->text('catatan')->nullable();
            $table->timestamps();
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
