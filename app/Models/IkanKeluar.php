<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IkanKeluar extends Model
{
    use HasFactory;

    protected $table = 'ikan_keluar';

    protected $guarded = ['id'];
}
