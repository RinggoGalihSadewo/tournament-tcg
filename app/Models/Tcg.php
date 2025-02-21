<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tcg extends Model 
{
    protected $table = 'tcg';
    protected $primaryKey = 'id_tcg';

    protected $guarded = [
        'id_tcg'
    ];

    public function tournament()
    {
        return $this->hasOne(Tcg::class);
    }

    public function decklog()
    {
        return $this->hasMany(Decklog::class, 'id_tcg');
    }
    
}
