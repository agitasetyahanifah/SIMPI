<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Blog;
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

    protected $model = Blog::class;

    public function definition(): array
    {
        $judul = $this->faker->sentence;
        
        return [
            'judul' => $judul,
            'slug' => Str::slug($judul),
            'kategori_id' => KategoriBlog::inRandomOrder()->first()->id,
            'image' => '../images/ex-blog.png',
            'body' => implode("\n\n", $this->faker->paragraphs(5)),
        ];
    }
}
