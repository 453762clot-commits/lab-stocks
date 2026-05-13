<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\SeatService;
use Illuminate\Http\Request;

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
            'match_seat_id' => 'required|exists:match_seats,id',
        ]);

        $success = $this->seatService->lockSeat($request->match_seat_id, $request->user()->id);

        if ($success) {
            return response()->json(['message' => 'Seat locked successfully']);
        }

        return response()->json(['message' => 'Seat is already taken or reserved'], 422);
    }
}
