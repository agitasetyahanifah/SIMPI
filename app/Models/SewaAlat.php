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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function alatPancing()
    {
        return $this->belongsTo(AlatPancing::class, 'alat_id');
    }

    protected static function booted()
    {
        static::creating(function ($sewaAlat) {
            $sewaAlat->kode_sewa = strtoupper('LN' . uniqid());
        });
    }
}
