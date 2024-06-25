<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Galeri>
 */
class GaleriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil user dengan peran (role) admin secara acak
        $adminUser = User::where('role', 'admin')->inRandomOrder()->first();

        return [
            'filename' => '../images/galeri.png',
            'user_id' => $adminUser->id,
        ];
    }
}
