<?php

namespace Database\Seeders;

use App\Models\JenisIkan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisIkanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $jenisIkan = [
            'Ikan Lele', 
            'Ikan Mas', 
            'Ikan Nila', 
            'Ikan Gurame', 
            'Ikan Patin', 
            'Ikan Gabus', 
            'Ikan Bawal', 
            'Ikan Kakap', 
            'Ikan Bandeng', 
            'Ikan Kerapu'
        ];

        // Ambil user dengan role admin
        $admin = User::where('role', 'admin')->inRandomOrder()->first();

        // Cek apakah ada user admin
        if (!$admin) {
            throw new \Exception('No admin user found.');
        }

        // Iterasi melalui array jenis ikan dan tambahkan ke dalam database
        foreach ($jenisIkan as $jenis) {
            JenisIkan::create([
                'jenis_ikan' => $jenis,
                'user_id' => $admin->id,
            ]);
        }
    }
}
