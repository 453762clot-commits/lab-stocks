<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
    protected $table = 'stadiums';
    protected $fillable = ['name', 'location', 'capacity'];

    public function sectors()
    {
        return $this->hasMany(Sector::class);
    }

    public function matches()
    {
        return $this->hasMany(FootballMatch::class);
    }
}
