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

    public function checkout(Request $request)
    {
        $request->validate([
            'match_seat_ids' => 'required|array',
            'match_seat_ids.*' => 'exists:match_seats,id',
        ]);

        $seats = MatchSeat::with(['seat.sector', 'match.homeTeam', 'match.awayTeam'])->whereIn('id', $request->match_seat_ids)->get();
        $match = $seats->first()->match;
        
        $total = 0;
        foreach ($seats as $ms) {
            $total += $ms->match->base_price * $ms->seat->sector->price_modifier;
        }

        return \Inertia\Inertia::render('Purchase/Checkout', [
            'seats' => $seats,
            'match' => $match,
            'total' => $total,
            'match_seat_ids' => $request->match_seat_ids
        ]);
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

                // For simulation, we allow if it's reserved OR available (to make it easier to test)
                if ($matchSeat->status === 'sold') {
                    throw new \Exception("El asiento {$matchSeat->id} ya ha sido vendido.");
                }

                $basePrice = $matchSeat->match->base_price;
                $modifier = $matchSeat->seat->sector->price_modifier;
                $totalPrice = $basePrice * $modifier;

                $discount = $this->loyaltyService->calculateDiscount($user, $totalPrice);
                $finalPrice = $totalPrice - $discount;

                $uuid = Str::uuid();
                $qrPath = "qrcodes/{$uuid}.svg";
                
                // Use SVG to avoid requiring the imagick PHP extension
                $qrCode = QrCode::format('svg')->size(300)->margin(1)->generate($uuid);
                Storage::disk('public')->put($qrPath, $qrCode);

                $ticket = Ticket::create([
                    'uuid' => $uuid,
                    'user_id' => $user->id,
                    'match_id' => $matchSeat->match_id,
                    'seat_id' => $matchSeat->seat_id,
                    'price_paid' => $finalPrice,
                    'qr_code_path' => $qrPath,
                    'status' => 'valid',
                ]);

                $matchSeat->update(['status' => 'sold', 'user_id' => $user->id]);
                
                $pointsEarned = (int)($finalPrice / 10);
                $this->loyaltyService->addPoints($user, $pointsEarned, "Compra de entrada {$uuid}");
                
                $tickets[] = $ticket;
            }

            if (count($tickets) === 1) {
                return redirect()->route('tickets.show', $tickets[0])->with('success', '¡Compra realizada con éxito! Se ha enviado una copia a tu correo.');
            }

            return redirect()->route('dashboard')->with('success', '¡Compra realizada con éxito! Tus ' . count($tickets) . ' entradas ya están disponibles abajo en tu panel.');
        });
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['match.homeTeam', 'match.awayTeam', 'seat.sector', 'user']);
        
        return \Inertia\Inertia::render('Tickets/Show', [
            'ticket' => $ticket
        ]);
    }

    public function downloadPdf(Ticket $ticket)
    {
        $ticket->load(['match.homeTeam', 'match.awayTeam', 'seat.sector', 'user']);
        
        $qrPath = storage_path('app/public/' . $ticket->qr_code_path);
        $qrBase64 = '';
        if (file_exists($qrPath)) {
            $qrContent = file_get_contents($qrPath);
            $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrContent);
        }

        $pdf = Pdf::loadView('pdf.ticket', compact('ticket', 'qrBase64'));
        
        return $pdf->download("ticket-{$ticket->uuid}.pdf");
    }
}
