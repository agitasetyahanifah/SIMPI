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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alatPancing()
    {
        return $this->belongsToMany(AlatPancing::class, 'alat_sewa', 'sewa_id', 'alat_id')
            ->withTimestamps();
    }

    public function spot()
    {
        return $this->belongsTo(Spot::class);
    }

    public function updateSesiSewaSpot()
    {
        return $this->belongsTo(UpdateSesiSewaSpot::class, 'sesi_id');
    }

    public function updateHargaSewaSpot()
    {
        return $this->belongsTo(UpdateHargaSewaSpot::class, 'harga_id');
    }

    public function keuangans()
    {
        return $this->hasMany(Keuangan::class, 'sewa_spot_id');
    }
}
