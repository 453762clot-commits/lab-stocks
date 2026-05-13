<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $fillable = ['stadium_id', 'name', 'price_modifier', 'capacity'];

    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
