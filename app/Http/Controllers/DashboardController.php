<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Calculate Rank
        $rank = User::where('points', '>', $user->points)->count() + 1;
        
        // Active Tickets
        $activeTicketsCount = Ticket::where('user_id', $user->id)
            ->where('status', 'valid')
            ->count();
            
        return Inertia::render('Dashboard', [
            'userRank' => $rank,
            'activeTicketsCount' => $activeTicketsCount,
            'points' => $user->points,
        ]);
    }
}
