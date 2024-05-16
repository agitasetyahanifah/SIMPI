<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $guarded = ['id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sewaAlat()
    {
        return $this->hasMany(SewaAlat::class);
    }
}
