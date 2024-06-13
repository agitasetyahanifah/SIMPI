<?php

namespace Database\Factories;
use App\Models\SewaAlat;
use App\Models\User;
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
        $tglPinjam = $this->faker->dateTimeBetween('-1 month', 'now');
        $tglKembali = $this->faker->dateTimeBetween($tglPinjam, '+1 month');

        // Get random user ID and alat pancing ID
        $user = User::inRandomOrder()->first();
        $alatPancing = AlatPancing::inRandomOrder()->first();

        // Calculate biaya sewa based on random number
        $biayaSewa = $this->faker->numberBetween(10000, 100000);

        return [
            'kode_sewa' => strtoupper('LN' . uniqid()),
            'user_id' => $user->id,
            'alat_id' => $alatPancing->id,
            'tgl_pinjam' => $tglPinjam,
            'tgl_kembali' => $tglKembali,
            'biaya_sewa' => $biayaSewa,
            'jumlah' => $this->faker->numberBetween(1, 5), // Random quantity between 1 to 5 units
            'status' => $this->faker->randomElement(['menunggu pembayaran', 'sudah dibayar', 'dibatalkan']),
            'status_pengembalian' => $this->faker->optional()->randomElement(['proses', 'sudah kembali', 'terlambat kembali']),
        ];
    }
}
