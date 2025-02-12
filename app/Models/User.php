<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable 
{
    protected $table = 'user';

    protected $guarded = [
        'id_user'
    ];

    public function registration()
    {
        return $this->hasOne(Registration::class);
    }

    public function ranking()
    {
        return $this->hasOne(Ranking::class);
    }
}
