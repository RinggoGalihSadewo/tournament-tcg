<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model 
{
    protected $table = 'registration';
    protected $primaryKey = 'id_registration';

    protected $guarded = [
        'id_registration'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
