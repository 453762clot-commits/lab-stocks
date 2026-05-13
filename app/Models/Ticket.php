<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'uuid', 'user_id', 'match_id', 'seat_id', 'price_paid', 'qr_code_path', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function match()
    {
        return $this->belongsTo(FootballMatch::class, 'match_id');
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}
