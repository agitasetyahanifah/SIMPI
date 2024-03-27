<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IkanMasuk>
 */
class IkanMasukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenisIkan = ['Ikan Lele', 'Ikan Mas', 'Ikan Nila', 'Ikan Gurame', 'Ikan Patin', 'Ikan Gabus', 'Ikan Bawal', 'Ikan Kakap', 'Ikan Bandeng', 'Ikan Kerapu'];
        $randomJenisIkan = $this->faker->randomElement($jenisIkan);

        return [
            'tanggal' => $this->faker->date(),
            'jenis_ikan' => $randomJenisIkan,
            'jumlah' => $this->faker->numberBetween(1, 100),
            'catatan' => $this->faker->sentence,
        ];
    }
}
