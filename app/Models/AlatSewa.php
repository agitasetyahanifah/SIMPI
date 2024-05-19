<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatSewa extends Model
{
    use HasFactory;

    protected $table = 'alat_sewa';

    // Definisikan relasi dengan model SewaAlat
    public function sewaAlat()
    {
        return $this->belongsTo(SewaAlat::class, 'sewa_id');
        // return $this->belongsTo(SewaAlat::class);
    }

    // Definisikan relasi dengan model AlatPancing
    public function alatPancing()
    {
        return $this->belongsTo(AlatPancing::class, 'alat_id');
        // return $this->belongsTo(AlatPancing::class);
    }

}
