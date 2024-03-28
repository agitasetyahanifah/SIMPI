<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $kategori = 'nama_kategori';
        $kategori = ['Pemancingan', 'Tips & Trik', 'Jenis-Jenis Ikan', 'Alat Pancing'];
        $randomKategori = $this->faker->randomElement($kategori);

        return [
            'judul' => $judul,
            'slug' => Str::slug($judul),
            'kategori' => $randomKategori,
            'image' => 'path/to/your/image.jpg',
            'body' => $this->faker->paragraph,
        ];
    }
}
