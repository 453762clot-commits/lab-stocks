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
            'match_seat_ids' => 'required|array',
            'match_seat_ids.*' => 'exists:match_seats,id',
        ]);

        return DB::transaction(function () use ($request) {
            $user = $request->user();
            $tickets = [];

            foreach ($request->match_seat_ids as $seatId) {
                $matchSeat = MatchSeat::with(['seat.sector', 'match'])->findOrFail($seatId);

                if ($matchSeat->status !== 'reserved' || $matchSeat->user_id !== $user->id) {
                    throw new \Exception("El asiento {$matchSeat->id} ya no está reservado.");
                }

                $basePrice = $matchSeat->match->base_price;
                $modifier = $matchSeat->seat->sector->price_modifier;
                $totalPrice = $basePrice * $modifier;

                $discount = $this->loyaltyService->calculateDiscount($user, $totalPrice);
                $finalPrice = $totalPrice - $discount;

                $uuid = Str::uuid();
                $qrPath = "qrcodes/{$uuid}.svg";
                
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
                
                $pointsEarned = (int)($finalPrice / 10);
                $this->loyaltyService->addPoints($user, $pointsEarned, "Compra de entrada {$uuid}");
                
                $tickets[] = $ticket;
            }

            // Redirect to the first ticket or a list? 
            // For now, redirect to the first one to avoid error.
            return redirect()->route('tickets.show', $tickets[0]);
        });
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['match.homeTeam', 'match.awayTeam', 'seat.sector', 'user']);
        
        return \Inertia\Inertia::render('Tickets/Show', [
            'ticket' => $ticket
        ]);
    }
}
