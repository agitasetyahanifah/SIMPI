<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\KategoriBlog;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KategoriBlog>
 */
class KategoriBlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = KategoriBlog::class;

    public function definition(): array
    {
        return [
            'kategori_blog' => $this->faker->randomElement(['Pemancingan', 'Tips & Trik', 'Jenis-Jenis Ikan', 'Alat Pancing']),
        ];
    }
}
