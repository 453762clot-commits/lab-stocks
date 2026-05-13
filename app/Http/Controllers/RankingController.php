<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\LoyaltyService;
use Inertia\Inertia;

class RankingController extends Controller
{
    protected $loyaltyService;

    public function __construct(LoyaltyService $loyaltyService)
    {
        $this->loyaltyService = $loyaltyService;
    }

    public function index()
    {
        return Inertia::render('Ranking/Index', [
            'ranking' => $this->loyaltyService->getGlobalRanking()
        ]);
    }
}
