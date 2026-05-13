<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FootballMatch extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'stadium_id',
        'match_date',
        'base_price',
        'competition',
        'status',
        'image_path',
    ];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }

    public function matchSeats()
    {
        return $this->hasMany(MatchSeat::class, 'match_id');
    }
}
