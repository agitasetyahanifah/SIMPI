<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AlatPancing>
 */
class AlatPancingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'foto' => $this->faker->imageUrl(), // Generate random image URL
            'nama_alat' => $this->faker->word, // Generate random word
            'harga' => $this->faker->numberBetween(10000, 100000), // Generate random price
            'jumlah' => $this->faker->numberBetween(1, 50), // Generate random quantity
            'status' => $this->faker->randomElement(['available', 'not available']), // Generate random status
            'spesifikasi' => $this->faker->paragraph(), // Generate random specification
        ];
    }
}
