<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('spots', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_spot');
            $table->timestamps();
        });

        // Menambahkan data nomor spot dari 1 hingga 40
        for ($i = 1; $i <= 40; $i++) {
            DB::table('spots')->insert([
                'nomor_spot' => sprintf('%02d', $i), // Format nomor menjadi dua digit
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spots');
    }
};
