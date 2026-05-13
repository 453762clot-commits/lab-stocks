<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchSeat extends Model
{
    protected $fillable = ['match_id', 'seat_id', 'status', 'user_id', 'locked_at'];

    public function match()
    {
        return $this->belongsTo(FootballMatch::class, 'match_id');
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
