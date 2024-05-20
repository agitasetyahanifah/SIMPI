<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SewaPemancingan extends Model
{
    use HasFactory;

    protected $table = 'sewa_pemancingan';

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::creating(function ($sewaPemancingan) {
            $sewaPemancingan->kode_booking = strtoupper('LNI' . uniqid());
        });
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'user_id', 'id');
    }

    public function alatPancing()
    {
        return $this->belongsToMany(AlatPancing::class, 'alat_sewa', 'sewa_id', 'alat_id')
            ->withTimestamps();
    }

}
