<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatPancing extends Model
{
    use HasFactory;

    protected $table = 'alat_pancing';

    protected $guarded = ['id'];

    public function sewaAlats()
    {
        return $this->hasMany(SewaAlat::class);
    }

    // public function alatSewa()
    // {
    //     return $this->hasMany(AlatSewa::class, 'alat_id');
    //     // return $this->hasMany(AlatSewa::class);
    // }
}
