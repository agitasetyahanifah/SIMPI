<?php

namespace Database\Factories;

use App\Models\AlatPancing;
use App\Models\User;
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
        // Mengambil user dengan role admin
        $admin = User::where('role', 'admin')->inRandomOrder()->first();

        return [
            'foto' => '../images/ex-alat.png',
            'nama_alat' => $this->faker->word,
            'harga' => $this->faker->numberBetween(10000, 100000),
            'jumlah' => $this->faker->numberBetween(1, 50),
            'status' => $this->faker->randomElement(['available', 'not available']),
            'spesifikasi' => $this->faker->paragraph(4),
            'user_id' => $admin->id,
        ];
    }
}
