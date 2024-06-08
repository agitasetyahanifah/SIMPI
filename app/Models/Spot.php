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
    public function sewaSpots()
    {
        return $this->hasMany(SewaSpot::class, 'spot_id', 'id');
    }
    
    // Metode untuk memeriksa apakah spot sudah dipesan pada sesi tersebut

 
}
