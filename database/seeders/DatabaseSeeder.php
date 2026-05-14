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
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
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
            'role' => 'client',
            'points' => 150,
        ]);

        // Teams
        $teamsData = [
            ['name' => 'FC Barcelona', 'logo_path' => 'barca.png'],
            ['name' => 'Real Madrid', 'logo_path' => 'madrid.png'],
            ['name' => 'Girona FC', 'logo_path' => 'girona.png'],
            ['name' => 'RCD Espanyol', 'logo_path' => 'espanyol.png'],
            ['name' => 'Manchester City', 'logo_path' => 'city.png'],
            ['name' => 'Bayern Munich', 'logo_path' => 'bayern.png'],
            ['name' => 'Paris Saint-Germain', 'logo_path' => 'psg.png'],
            ['name' => 'Liverpool FC', 'logo_path' => 'liverpool.png'],
            ['name' => 'AC Milan', 'logo_path' => 'milan.png'],
        ];

        $teams = [];
        foreach ($teamsData as $data) {
            $teams[] = Team::create($data);
        }

        // Stadiums
        $stadiums = [
            ['name' => 'Camp Nou', 'location' => 'Barcelona', 'capacity' => 99354],
            ['name' => 'Santiago Bernabéu', 'location' => 'Madrid', 'capacity' => 81044],
            ['name' => 'Etihad Stadium', 'location' => 'Manchester', 'capacity' => 53000],
            ['name' => 'Allianz Arena', 'location' => 'Munich', 'capacity' => 75000],
            ['name' => 'Anfield', 'location' => 'Liverpool', 'capacity' => 53394],
        ];

        $createdStadiums = [];
        foreach ($stadiums as $sData) {
            $createdStadiums[] = Stadium::create($sData);
        }

        $sectors = [
            ['name' => 'Tribuna VIP', 'price_modifier' => 2.5],
            ['name' => 'Lateral', 'price_modifier' => 1.5],
            ['name' => 'Gol Norte', 'price_modifier' => 1.0],
            ['name' => 'Gol Sur', 'price_modifier' => 1.0],
        ];

        foreach ($createdStadiums as $stadium) {
            foreach ($sectors as $sectorData) {
                $sector = Sector::create([
                    'stadium_id' => $stadium->id,
                    'name' => $sectorData['name'],
                    'price_modifier' => $sectorData['price_modifier'],
                ]);

                for ($i = 1; $i <= 2; $i++) {
                    for ($j = 1; $j <= 10; $j++) {
                        Seat::create([
                            'sector_id' => $sector->id,
                            'row' => $i,
                            'number' => $j,
                        ]);
                    }
                }
            }
        }

        // Matches
        $matchesData = [
            // La Liga
            [
                'home_team_id' => 1, 'away_team_id' => 2,
                'stadium_id' => $createdStadiums[0]->id, 'match_date' => now()->addDays(7),
                'base_price' => 120.0, 'competition' => 'La Liga', 'status' => 'scheduled',
            ],
            [
                'home_team_id' => 2, 'away_team_id' => 1,
                'stadium_id' => $createdStadiums[1]->id, 'match_date' => now()->addDays(20),
                'base_price' => 130.0, 'competition' => 'La Liga', 'status' => 'scheduled',
            ],
            // Champions League
            [
                'home_team_id' => 5, 'away_team_id' => 1,
                'stadium_id' => $createdStadiums[2]->id, 'match_date' => now()->addDays(10),
                'base_price' => 150.0, 'competition' => 'Champions League', 'status' => 'scheduled',
            ],
            [
                'home_team_id' => 6, 'away_team_id' => 2,
                'stadium_id' => $createdStadiums[3]->id, 'match_date' => now()->addDays(12),
                'base_price' => 140.0, 'competition' => 'Champions League', 'status' => 'scheduled',
            ],
            // Premier League
            [
                'home_team_id' => 8, 'away_team_id' => 5,
                'stadium_id' => $createdStadiums[4]->id, 'match_date' => now()->addDays(15),
                'base_price' => 95.0, 'competition' => 'Premier League', 'status' => 'scheduled',
            ],
            [
                'home_team_id' => 5, 'away_team_id' => 8,
                'stadium_id' => $createdStadiums[2]->id, 'match_date' => now()->addDays(25),
                'base_price' => 100.0, 'competition' => 'Premier League', 'status' => 'scheduled',
            ],
            // Champions Extra
            [
                'home_team_id' => 7, 'away_team_id' => 6, // PSG vs Bayern
                'stadium_id' => $createdStadiums[0]->id, 'match_date' => now()->addDays(30),
                'base_price' => 160.0, 'competition' => 'Champions League', 'status' => 'scheduled',
            ],
            [
                'home_team_id' => 9, 'away_team_id' => 5, // Milan vs City
                'stadium_id' => $createdStadiums[3]->id, 'match_date' => now()->addDays(35),
                'base_price' => 130.0, 'competition' => 'Champions League', 'status' => 'scheduled',
            ],
            // Serie A
            [
                'home_team_id' => 9, 'away_team_id' => 7, // Milan vs PSG (Friendly)
                'stadium_id' => $createdStadiums[4]->id, 'match_date' => now()->addDays(40),
                'base_price' => 75.0, 'competition' => 'Serie A', 'status' => 'scheduled',
            ],
        ];

        foreach ($matchesData as $mData) {
            $match = FootballMatch::create($mData);
            
            // Get only seats from the stadium where the match is played
            $stadiumSeats = Seat::whereHas('sector', function($query) use ($match) {
                $query->where('stadium_id', $match->stadium_id);
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
