<?php

namespace Database\Factories;

use App\Models\SewaPemancingan;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SewaPemancingan>
 */
class SewaPemancinganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = SewaPemancingan::class;

    public function definition(): array
    {
        return [
            'kode_booking' => $this->faker->unique()->text(5),
            'user_id' => function () {
                return \App\Models\Member::factory()->create()->id;
            },
            'tanggal_sewa' => $this->faker->dateTimeBetween('2024-01-01', '2024-05-31')->format('Y-m-d'),
            'jam_mulai' => $this->faker->time(),
            'jam_selesai' => $this->faker->time(),
            'jumlah_sewa' => $this->faker->numberBetween(1, 10),
            'biaya_sewa' => $this->faker->randomFloat(2, 100, 1000),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
