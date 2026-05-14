<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\SeatService;

class SeatController extends Controller
{
    protected $seatService;

    public function __construct(SeatService $seatService)
    {
        $this->seatService = $seatService;
    }

    public function lock(Request $request)
    {
        $request->validate([
            'match_seat_ids' => 'required|array',
            'match_seat_ids.*' => 'exists:match_seats,id',
        ]);

        $success = $this->seatService->lockSeats($request->match_seat_ids, $request->user()->id);

        if ($success) {
            return response()->json(['message' => 'Asientos bloqueados correctamente']);
        }

        return response()->json(['message' => 'Uno o más asientos ya no están disponibles'], 422);
    }
}
