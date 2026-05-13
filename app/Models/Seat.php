<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = ['sector_id', 'row', 'number'];

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function matchSeats()
    {
        return $this->hasMany(MatchSeat::class);
    }
}
