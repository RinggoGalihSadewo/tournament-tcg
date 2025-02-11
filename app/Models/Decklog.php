<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Decklog extends Model 
{
    protected $table = 'decklog';

    protected $guarded = [
        'id_decklog'
    ];

    public function tcg()
    {
        return $this->belongsTo(Tcg::class);
    }
}
