<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SewaSpot extends Model
{
    use HasFactory;

    protected $table = 'sewa_spots';

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::creating(function ($sewaSpot) {
            $sewaSpot->kode_booking = strtoupper('LNI' . uniqid());
        });
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function alatPancing()
    {
        return $this->belongsToMany(AlatPancing::class, 'alat_sewa', 'sewa_id', 'alat_id')
            ->withTimestamps();
    }

}
