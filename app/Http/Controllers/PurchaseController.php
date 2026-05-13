<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MatchSeat;
use App\Models\Ticket;
use App\Services\LoyaltyService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends Controller
{
    protected $loyaltyService;

    public function __construct(LoyaltyService $loyaltyService)
    {
        $this->loyaltyService = $loyaltyService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'match_seat_id' => 'required|exists:match_seats,id',
        ]);

        $matchSeat = MatchSeat::with(['seat.sector', 'match'])->findOrFail($request->match_seat_id);

        if ($matchSeat->status !== 'reserved' || $matchSeat->user_id !== $request->user()->id) {
            return back()->withErrors(['message' => 'Seat is no longer reserved for you.']);
        }

        return DB::transaction(function () use ($matchSeat, $request) {
            $user = $request->user();
            $basePrice = $matchSeat->match->base_price;
            $modifier = $matchSeat->seat->sector->price_modifier;
            $totalPrice = $basePrice * $modifier;

            // Apply points discount (optional logic)
            $discount = $this->loyaltyService->calculateDiscount($user, $totalPrice);
            $finalPrice = $totalPrice - $discount;

            $uuid = Str::uuid();
            $qrPath = "qrcodes/{$uuid}.svg";
            
            // Generate QR (In a real app, this might be a URL to verify the ticket)
            Storage::disk('public')->put($qrPath, QrCode::format('svg')->size(200)->generate($uuid));

            $ticket = Ticket::create([
                'uuid' => $uuid,
                'user_id' => $user->id,
                'match_id' => $matchSeat->match_id,
                'seat_id' => $matchSeat->seat_id,
                'price_paid' => $finalPrice,
                'qr_code_path' => $qrPath,
                'status' => 'valid',
            ]);

            $matchSeat->update(['status' => 'sold']);

            // Award points (1 point per 10€ spent)
            $pointsEarned = (int)($finalPrice / 10);
            $this->loyaltyService->addPoints($user, $pointsEarned, "Purchase of ticket {$uuid}");

            return redirect()->route('tickets.show', $ticket);
        });
    }
}
