<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model 
{
    protected $table = 'ranking';
    protected $primaryKey = 'id_ranking';

    protected $guarded = [
        'id_ranking'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'id_tournament');
    }
}
