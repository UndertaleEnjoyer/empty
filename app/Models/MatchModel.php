<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Team;
use App\Models\Player;

class MatchModel extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $fillable = [
        'team1_id',
        'team2_id',
        'date',
        'venue',
    ];

    public function team1()
    {
        return $this->belongsTo(Team::class, 'team1_id');
    }

    public function team2()
    {
        return $this->belongsTo(Team::class, 'team2_id');
    }


    public function goals()
    {
        return $this->hasMany(Goal::class, 'match_id');
    }


    public function players()
    {
        return $this->belongsToMany(
            Player::class,
            'goals',
            'match_id',
            'player_id'
        )->withPivot('minute');
    }
    protected $casts = [
    'date' => 'datetime',
];
}
