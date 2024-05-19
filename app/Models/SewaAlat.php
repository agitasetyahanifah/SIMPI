<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SewaAlat extends Model
{
    use HasFactory;

    protected $table = 'sewa_alat';

    protected $guarded = ['id'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'user_id');
    }

    public function alatSewa()
    {
        return $this->hasMany(AlatSewa::class, 'sewa_id');
        // return $this->hasMany(AlatSewa::class);
    }

    public function alatPancing()
    {
        // return $this->belongsToMany(AlatPancing::class, 'alat_sewa', 'sewa_id', 'alat_id');
        return $this->hasManyThrough(AlatPancing::class, AlatSewa::class, 'sewa_id', 'alat_id', 'id', 'id');
    }

    protected static function booted()
    {
        static::creating(function ($sewaAlat) {
            $sewaAlat->kode_sewa = strtoupper('LN' . uniqid());
        });
    }
}
