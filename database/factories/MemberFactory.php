<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = User::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name('id_ID'),
            'telepon' => $this->faker->phoneNumber('id_ID'),
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('@Member2024'),
            'status' => $this->faker->randomElement(['aktif', 'tidak aktif']),
            'role' => 'member',
            // 'created_at' => $this->faker->dateTime(),
            // 'updated_at' => $this->faker->dateTime(),
        ];
    }
}
