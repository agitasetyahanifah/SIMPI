<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyewaanAlat extends Model
{
    use HasFactory;

    protected $table = 'penyewaan_alat';

    protected $guarded = ['id'];

    // Relasi dengan model AlatPancing
    public function alatPancing()
    {
        return $this->belongsTo(AlatPancing::class);
    }

}
