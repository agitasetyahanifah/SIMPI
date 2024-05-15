<?php

namespace Database\Factories;
use App\Models\SewaAlat;
use App\Models\Member;
use App\Models\AlatPancing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SewaAlat>
 */
class SewaAlatFactory extends Factory
{
    protected $model = SewaAlat::class;

    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('2024-01-01', '2024-12-31');
        $endDate = $this->faker->dateTimeBetween($startDate, '2024-12-31');

        return [
            'user_id' => Member::factory(),
            'tgl_pinjam' => $startDate->format('Y-m-d'),
            'tgl_kembali' => $endDate->format('Y-m-d'),
            'biaya_sewa' => $this->faker->numberBetween(1000, 10000),
            // 'status' => $this->faker->randomElement(['sudah dibayar', 'belum dibayar']),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (SewaAlat $sewaAlat) {
            $alatIds = AlatPancing::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $sewaAlat->alat()->attach($alatIds);
        });
    }
}
