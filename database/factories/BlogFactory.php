<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\KategoriBlog;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judul = $this->faker->sentence;
        
        return [
            'judul' => $judul,
            'slug' => Str::slug($judul),
            'kategori_id' => KategoriBlog::factory(), // Menggunakan factory KategoriBlog
            'image' => 'path/to/your/image.jpg',
            'body' => implode("\n\n", $this->faker->paragraphs(5)),
        ];
    }
}
