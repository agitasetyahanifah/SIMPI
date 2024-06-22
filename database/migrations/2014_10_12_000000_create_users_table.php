<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telepon')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('status', ['aktif', 'tidak aktif'])->default('aktif');
            $table->enum('role', ['admin', 'member'])->default('member');
            $table->rememberToken();
            $table->timestamps();
        });

        // Insert default admin
        DB::table('users')->insert([
            [
                'nama' => 'Admin 2024',
                'telepon' => '02717851580',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('@Admin2024'),
                'status' => 'aktif',
                'role' => 'admin',
            ],
            [
                'nama' => 'Admin 2',
                'telepon' => '08123456789',
                'email' => 'admin2@gmail.com',
                'password' => Hash::make('@Admin2024'),
                'status' => 'aktif',
                'role' => 'admin',
            ],
            [
                'nama' => 'Admin 3',
                'telepon' => '08234567890',
                'email' => 'admin3@gmail.com',
                'password' => Hash::make('@Admin2024'),
                'status' => 'aktif',
                'role' => 'admin',
            ],
        ]);        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
