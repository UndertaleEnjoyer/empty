<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MatchModel;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'full_name',
        'position',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    // MANY-TO-MANY
    public function matches()
    {
        return $this->belongsToMany(
            MatchModel::class,
            'goals',
            'player_id',
            'match_id'
        )->withPivot('minute')->withTimestamps();
    }
    public function goals()
{
    return $this->hasMany(Goal::class);
}
}
