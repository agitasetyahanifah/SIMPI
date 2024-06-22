<?php

namespace Database\Factories;

use App\Models\Keuangan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
        $jenisTransaksi = $this->faker->randomElement(['pemasukan', 'pengeluaran']);
        $keterangan = $this->faker->sentence();
    
        $userId = function () use ($jenisTransaksi) {
            // Mengambil ID user dengan role 'admin'
            return User::where('role', 'admin')->inRandomOrder()->first()->id;
        };
    
        return [
            'kode_transaksi' => Str::upper(Str::random(13)),
            'user_id' => $userId(),
            'tanggal_transaksi' => $this->faker->dateTimeBetween('2024-01-01', '2024-06-30')->format('Y-m-d'),
            'waktu_transaksi' => $this->faker->time('H:i:s'),
            'jumlah' => $this->faker->numberBetween(100000, 10000000),
            'jenis_transaksi' => $jenisTransaksi,
            'keterangan' => $keterangan,
        ];
    }
    
}
