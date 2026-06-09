<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_id',
        'player_id',
        'minute',
    ];

    
    public function match()
    {
        return $this->belongsTo(MatchModel::class);
    }

    
    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
