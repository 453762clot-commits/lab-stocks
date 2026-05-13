<?php

namespace App\Services;

use App\Models\User;
use App\Models\LoyaltyPoint;

class LoyaltyService
{
    /**
     * Add points to a user.
     */
    public function addPoints(User $user, int $amount, string $description)
    {
        $user->increment('points', $amount);

        LoyaltyPoint::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'description' => $description,
            'type' => 'earned',
        ]);
    }

    /**
     * Get global ranking of users.
     */
    public function getGlobalRanking(int $limit = 10)
    {
        return User::where('role', 'customer')
            ->orderByDesc('points')
            ->limit($limit)
            ->get(['id', 'name', 'points']);
    }

    /**
     * Calculate discount based on points.
     */
    public function calculateDiscount(User $user, float $totalPrice): float
    {
        // Example: 100 points = 5% discount, max 20%
        $discountPercent = min(($user->points / 100) * 5, 20);
        return ($totalPrice * $discountPercent) / 100;
    }
}
