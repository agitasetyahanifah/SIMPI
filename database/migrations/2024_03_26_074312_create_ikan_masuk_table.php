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
        Schema::create('ikan_masuk', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('jenis_ikan', [
                'Ikan Lele',
                'Ikan Mas',
                'Ikan Nila',
                'Ikan Gurame',
                'Ikan Patin',
                'Ikan Gabus',
                'Ikan Bawal',
                'Ikan Kakap',
                'Ikan Bandeng',
                'Ikan Kerapu',
            ])->default('Ikan Mas');
            $table->integer('jumlah');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ikan_masuk');
    }
};
