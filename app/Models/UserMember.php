<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserMember extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';

    protected $guarded = ['id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sewaAlat()
    {
        return $this->hasMany(SewaAlat::class);
    }
}
