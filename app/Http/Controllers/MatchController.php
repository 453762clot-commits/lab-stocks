<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FootballMatch;
use Inertia\Inertia;

class MatchController extends Controller
{
    public function index()
    {
        // Get matches with relations
        $matches = FootballMatch::with(['homeTeam', 'awayTeam', 'stadium'])
            ->orderBy('match_date')
            ->get();

        return Inertia::render('Matches/Index', [
            'matches' => $matches
        ]);
    }

    public function show(FootballMatch $match)
    {
        $match->load(['homeTeam', 'awayTeam', 'stadium.sectors.seats.matchSeats' => function($query) use ($match) {
            $query->where('match_id', $match->id);
        }]);

        return Inertia::render('Matches/Show', [
            'match' => $match
        ]);
    }
}
