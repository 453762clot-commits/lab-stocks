<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Team;
use App\Models\Stadium;
use App\Models\Sector;
use App\Models\Seat;
use App\Models\FootballMatch;
use App\Models\MatchSeat;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Usuarios (Usando 'customer' para coincidir con LoyaltyService)
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@labstocks.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'points' => 150,
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'points' => 280,
        ]);

        // 2. Equipos
        $teamsData = [
            ['name' => 'FC Barcelona', 'logo_path' => 'barca.png'],
            ['name' => 'Real Madrid', 'logo_path' => 'madrid.png'],
            ['name' => 'Manchester City', 'logo_path' => 'city.png'],
            ['name' => 'Bayern Munich', 'logo_path' => 'bayern.png'],
            ['name' => 'Liverpool FC', 'logo_path' => 'liverpool.png'],
            ['name' => 'AC Milan', 'logo_path' => 'milan.png'],
        ];

        foreach ($teamsData as $data) {
            Team::create($data);
        }

        // 3. Estadios
        $stadiums = [
            ['name' => 'Camp Nou', 'location' => 'Barcelona', 'capacity' => 99354],
            ['name' => 'Santiago Bernabéu', 'location' => 'Madrid', 'capacity' => 81044],
            ['name' => 'Etihad Stadium', 'location' => 'Manchester', 'capacity' => 53000],
        ];

        $createdStadiums = [];
        foreach ($stadiums as $sData) {
            $createdStadiums[] = Stadium::create($sData);
        }

        $sectors = [
            ['name' => 'Tribuna VIP', 'price_modifier' => 2.5],
            ['name' => 'Lateral', 'price_modifier' => 1.5],
            ['name' => 'Gol Norte', 'price_modifier' => 1.0],
        ];

        foreach ($createdStadiums as $stadium) {
            foreach ($sectors as $sectorData) {
                $sector = Sector::create([
                    'stadium_id' => $stadium->id,
                    'name' => $sectorData['name'],
                    'price_modifier' => $sectorData['price_modifier'],
                ]);

                for ($i = 1; $i <= 2; $i++) {
                    for ($j = 1; $j <= 5; $j++) {
                        Seat::create([
                            'sector_id' => $sector->id,
                            'row' => $i,
                            'number' => $j,
                        ]);
                    }
                }
            }
        }

        // 4. Partidos
        $matchesData = [
            [
                'home_team_id' => 1, 'away_team_id' => 2,
                'stadium_id' => $createdStadiums[0]->id, 'match_date' => now()->addDays(7),
                'base_price' => 120.0, 'competition' => 'La Liga', 'status' => 'scheduled',
            ],
            [
                'home_team_id' => 3, 'away_team_id' => 1,
                'stadium_id' => $createdStadiums[2]->id, 'match_date' => now()->addDays(10),
                'base_price' => 150.0, 'competition' => 'Champions League', 'status' => 'scheduled',
            ],
            [
                'home_team_id' => 2, 'away_team_id' => 4,
                'stadium_id' => $createdStadiums[1]->id, 'match_date' => now()->addDays(12),
                'base_price' => 140.0, 'competition' => 'Champions League', 'status' => 'scheduled',
            ],
            [
                'home_team_id' => 5, 'away_team_id' => 3,
                'stadium_id' => $createdStadiums[2]->id, 'match_date' => now()->addDays(15),
                'base_price' => 95.0, 'competition' => 'Premier League', 'status' => 'scheduled',
            ],
        ];

        foreach ($matchesData as $mData) {
            $match = FootballMatch::create($mData);
            
            $stadiumSeats = Seat::whereHas('sector', function($q) use ($match) {
                $q->where('stadium_id', $match->stadium_id);
            })->get();

            foreach ($stadiumSeats as $seat) {
                MatchSeat::create([
                    'match_id' => $match->id,
                    'seat_id' => $seat->id,
                    'status' => 'available',
                ]);
            }
        }
    }
}
