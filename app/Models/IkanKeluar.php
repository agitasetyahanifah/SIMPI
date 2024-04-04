<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IkanKeluar extends Model
{
    use HasFactory;

    protected $table = 'ikan_keluar';

    protected $guarded = ['id'];

    // Relasi dengan JenisIkan
    public function jenisIkan()
    {
        return $this->belongsTo(JenisIkan::class, 'jenis_ikan_id');
    }
}
