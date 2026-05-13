<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Team;
use App\Models\Stadium;
use App\Models\Sector;
use App\Models\Seat;
use App\Models\FootballMatch;
use App\Models\MatchSeat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@labstocks.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Customer User
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'points' => 150,
        ]);

        // Teams
        $teams = [
            ['name' => 'FC Barcelona', 'logo_path' => 'logos/barca.png'],
            ['name' => 'Real Madrid', 'logo_path' => 'logos/madrid.png'],
            ['name' => 'Girona FC', 'logo_path' => 'logos/girona.png'],
            ['name' => 'RCD Espanyol', 'logo_path' => 'logos/espanyol.png'],
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }

        // Stadium
        $stadium = Stadium::create([
            'name' => 'Camp Nou',
            'location' => 'Barcelona',
            'capacity' => 100, // Small for testing
        ]);

        // Sectors
        $sectors = [
            ['stadium_id' => $stadium->id, 'name' => 'Tribuna', 'price_modifier' => 2.0, 'capacity' => 40],
            ['stadium_id' => $stadium->id, 'name' => 'Lateral', 'price_modifier' => 1.5, 'capacity' => 60],
        ];

        foreach ($sectors as $sectorData) {
            $sector = Sector::create($sectorData);
            // Create Seats
            for ($r = 1; $r <= 2; $r++) {
                for ($n = 1; $n <= 10; $n++) {
                    Seat::create([
                        'sector_id' => $sector->id,
                        'row' => "Row $r",
                        'number' => "Seat $n",
                    ]);
                }
            }
        }

        // Match
        $match = FootballMatch::create([
            'home_team_id' => 1,
            'away_team_id' => 2,
            'stadium_id' => $stadium->id,
            'match_date' => now()->addDays(7),
            'base_price' => 50.0,
            'competition' => 'La Liga',
            'status' => 'scheduled',
        ]);

        // Initialize Match Seats
        $seats = Seat::all();
        foreach ($seats as $seat) {
            MatchSeat::create([
                'match_id' => $match->id,
                'seat_id' => $seat->id,
                'status' => 'available',
            ]);
        }
    }
}
