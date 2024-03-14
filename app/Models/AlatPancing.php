<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatPancing extends Model
{
    use HasFactory;

    protected $table = 'alat_pancing';

    protected $guarded = ['id'];

    public function penyewaanAlat()
    {
        return $this->belongsToMany(PenyewaanAlat::class)->withTimestamps();
    }
}
