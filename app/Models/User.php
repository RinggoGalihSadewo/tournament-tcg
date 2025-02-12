<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable 
{
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'id_user';

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

