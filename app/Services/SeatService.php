<?php

namespace App\Services;

use App\Models\MatchSeat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SeatService
{
    /**
     * Lock a seat for a user temporarily (10 minutes).
     */
    public function lockSeat(int $matchSeatId, int $userId): bool
    {
        return DB::transaction(function () use ($matchSeatId, $userId) {
            $seat = MatchSeat::where('id', $matchSeatId)
                ->where('status', 'available')
                ->lockForUpdate()
                ->first();

            if (!$seat) {
                return false;
            }

            $seat->update([
                'status' => 'reserved',
                'user_id' => $userId,
                'locked_at' => now(),
            ]);

            return true;
        });
    }

    /**
     * Release expired locks.
     */
    public function releaseExpiredLocks()
    {
        MatchSeat::where('status', 'reserved')
            ->where('locked_at', '<', now()->subMinutes(10))
            ->update([
                'status' => 'available',
                'user_id' => null,
                'locked_at' => null,
            ]);
    }

    /**
     * Get available seats for a match with their prices.
     */
    public function getMatchSeats(int $matchId)
    {
        return MatchSeat::with(['seat.sector'])
            ->where('match_id', $matchId)
            ->get()
            ->map(function ($ms) {
                $basePrice = $ms->match->base_price;
                $modifier = $ms->seat->sector->price_modifier;
                $ms->price = $basePrice * $modifier;
                return $ms;
            });
    }
}
