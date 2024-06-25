<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\IkanKeluar;
use App\Models\JenisIkan;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IkanKeluar>
 */
class IkanKeluarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = IkanKeluar::class;

    public function definition(): array
    {
        // Ambil user dengan role admin secara random
        $admin = User::where('role', 'admin')->inRandomOrder()->first();

        return [
            'tanggal' => $this->faker->dateTimeBetween('2024-01-01', '2024-06-30')->format('Y-m-d'),
            'jenis_ikan_id' => JenisIkan::inRandomOrder()->first()->id,
            'jumlah' => $this->faker->numberBetween(1, 100),
            'kondisi_ikan' => $this->faker->randomElement(['Baik', 'Sakit', 'Mati']),
            'catatan' => $this->faker->sentence,
            'user_id' => $admin->id,
        ];
    }
}
