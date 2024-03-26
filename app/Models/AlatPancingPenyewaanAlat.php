<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatPancingPenyewaanAlat extends Model
{
    use HasFactory;

    protected $table = 'alat_pancing_penyewaan_alat';

    protected $guarded = ['id'];

    public function penyewaanAlat()
    {
        return $this->belongsTo(PenyewaanAlat::class, 'penyewaan_alat_id');
    }    

}
