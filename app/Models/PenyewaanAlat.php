<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyewaanAlat extends Model
{
    use HasFactory;

    protected $table = 'penyewaan_alat';

    protected $guarded = ['id'];

    public function alatPancing()
    {
        return $this->hasMany(AlatPancingPenyewaanAlat::class);
    }

    public function alatPancingPenyewaanAlat()
    {
        return $this->hasMany(AlatPancingPenyewaanAlat::class, 'penyewaan_alat_id');
    }

}
