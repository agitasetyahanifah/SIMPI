<?php

namespace Database\Factories;

use App\Models\Keuangan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Keuangan>
 */
class KeuanganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Keuangan::class;

    public function definition(): array
    {
        return [
            'tanggal_transaksi' => $this->faker->date(),
            'jumlah' => $this->faker->randomFloat(2, 10, 1000),
            'jenis_transaksi' => $this->faker->randomElement(['pemasukan', 'pengeluaran']),
            'keterangan' => $this->faker->sentence(),
        ];
    }
}
