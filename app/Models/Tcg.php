<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tcg extends Model 
{
    protected $table = 'tcg';

    protected $guarded = [
        'id_tcg'
    ];

    public function tournament()
    {
        return $this->hasOne(Tcg::class);
    }

    public function decklog()
    {
        return $this->hasOne(Decklog::class);
    }
}
