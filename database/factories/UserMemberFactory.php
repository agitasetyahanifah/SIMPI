<?php

namespace Database\Factories;

use App\Models\UserMember;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as FakerFactory;

class UserMemberFactory extends Factory
{
    protected $model = UserMember::class;

    public function definition()
    {
        $faker = FakerFactory::create('id_ID'); // Menggunakan data Faker Indonesia

        return [
            'nama' => $faker->name,
            'telepon' => $faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('@Member2024'),
            'status' => $this->faker->randomElement(['aktif', 'tidak aktif']),
            'role' => 'member',
        ];
    }
}
