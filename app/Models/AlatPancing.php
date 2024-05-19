<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatPancing extends Model
{
    use HasFactory;

    protected $table = 'alat_pancing';

    protected $guarded = ['id'];

    public function sewaAlat()
    {
        return $this->belongsToMany(SewaAlat::class, 'alat_sewa', 'alat_id', 'sewa_id');
    }

    public function alatSewa()
    {
        return $this->hasMany(AlatSewa::class, 'alat_id');
        // return $this->hasMany(AlatSewa::class);
    }
}
