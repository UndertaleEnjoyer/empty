<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    
    public function players()
    {
        return $this->hasMany(Player::class);
    }

    
    public function homeMatches()
    {
        return $this->hasMany(MatchModel::class, 'team1_id');
    }

    
    public function awayMatches()
    {
        return $this->hasMany(MatchModel::class, 'team2_id');
    }
}
