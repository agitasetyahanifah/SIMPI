<?php

namespace Database\Seeders;

use App\Models\JenisIkan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisIkanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $jenisIkan = ['Ikan Lele', 'Ikan Mas', 'Ikan Nila', 'Ikan Gurame', 'Ikan Patin', 'Ikan Gabus', 'Ikan Bawal', 'Ikan Kakap', 'Ikan Bandeng', 'Ikan Kerapu'];

        // Iterasi melalui array jenis ikan dan tambahkan ke dalam database
        foreach ($jenisIkan as $jenis) {
            JenisIkan::create(['jenis_ikan' => $jenis]);
        }
    }
}
