<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    protected $guarded = ['id'];

    // Relasi dengan Kategori Blog
    public function kategoriBlog()
    {
        return $this->belongsTo(KategoriBlog::class, 'kategori_id');
    }
}
