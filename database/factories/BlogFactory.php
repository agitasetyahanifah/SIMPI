<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Blog;
use App\Models\KategoriBlog;
use App\Models\User;

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

    protected $model = Blog::class;

    public function definition(): array
    {
        $judul = $this->faker->sentence;

        // Pastikan ada setidaknya satu record KategoriBlog, jika tidak ada maka buat satu
        $kategori = KategoriBlog::inRandomOrder()->first() ?? KategoriBlog::factory()->create();

        // Pastikan ada setidaknya satu record User, jika tidak ada maka buat satu
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        return [
            'judul' => $judul,
            'slug' => Str::slug($judul),
            'kategori_id' => $kategori->id,
            'user_id' => $user->id,
            'image' => '../images/ex-blog.png', // Sesuaikan path jika diperlukan
            'body' => implode("\n\n", $this->faker->paragraphs(5)),
        ];
    }
}
