<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\SewaPemancingan;
use Illuminate\Database\Seeder;

class SewaPemancinganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        SewaPemancingan::factory()->count(10)->create();
    }
}
