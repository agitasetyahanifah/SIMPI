<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        return [
            'tanggal' => $this->faker->date(),
            'jenis_ikan' => $this->faker->randomElement(['Ikan Lele', 'Ikan Mas', 'Ikan Nila', 'Ikan Gurame', 'Ikan Patin', 'Ikan Gabus', 'Ikan Bawal', 'Ikan Kakap', 'Ikan Bandeng', 'Ikan Kerapu']),
            'jumlah' => $this->faker->numberBetween(1, 100),
            'kondisi_ikan' => $this->faker->randomElement(['Baik', 'Sakit', 'Mati']),
            'catatan' => $this->faker->sentence,
        ];
    }
}
