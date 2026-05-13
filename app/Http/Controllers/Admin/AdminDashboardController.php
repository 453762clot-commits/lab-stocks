<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FootballMatch;
use App\Models\Ticket;
use App\Models\User;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_tickets_sold' => Ticket::count(),
            'total_revenue' => Ticket::sum('price_paid'),
            'total_users' => User::where('role', 'customer')->count(),
            'active_matches' => FootballMatch::where('status', 'scheduled')->count(),
            'recent_tickets' => Ticket::with(['user', 'match'])->latest()->limit(5)->get(),
            'top_users' => User::where('role', 'customer')->orderByDesc('points')->limit(5)->get(),
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats
        ]);
    }
}
