<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdateSesiSewaSpot extends Model
{
    use HasFactory;

    protected $table = 'update_sesi_sewa_spots';
    // protected $fillable = ['waktu_mulai', 'waktu_selesai', 'user_id'];
    protected $guarded = ['id'];

    // Menggunakan event untuk mengisi waktu_sesi secara otomatis
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Ensure waktu_mulai and waktu_selesai are not null
            if (!is_null($model->waktu_mulai) && !is_null($model->waktu_selesai)) {
                $model->waktu_sesi = $model->waktu_mulai . ' - ' . $model->waktu_selesai;
            }
        });
    }
}
