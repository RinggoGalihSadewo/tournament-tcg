<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model 
{
    protected $table = 'tournament';
    protected $primaryKey = 'id_tournament';

    protected $guarded = [
        'id_tournament'
    ];

    public function registration()
    {
        return $this->hasOne(Registration::class, 'id_tournament');
    }

    public function ranking()
    {
        return $this->hasOne(Ranking::class);
    }

    public function tcg()
    {
        return $this->belongsTo(Tcg::class);
    }
}
