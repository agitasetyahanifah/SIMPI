<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    use HasFactory;

    protected $table = 'spots';

    protected $guarded = ['id'];

    // Definisikan relasi dengan SewaSpot
    // public function sewaSpots()
    // {
    //     return $this->hasMany(SewaSpot::class, 'spot_id', 'id');
    // }

    public function sewaSpots()
    {
        return $this->hasMany(SewaSpot::class);
    }

    // public function checkAvailability($tanggalSewa)
    // {
    //     $bookedSpots = SewaSpot::where('tanggal_sewa', $tanggalSewa)
    //         ->join('spots', 'sewa_spots.spot_id', '=', 'spots.id')
    //         ->pluck('spots.nomor_spot')
    //         ->toArray();
    
    //     $allSpots = Spot::pluck('nomor_spot')->toArray();
    
    //     return array_diff($allSpots, $bookedSpots);
    // }
 
}
