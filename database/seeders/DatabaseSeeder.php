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
        // 1. Limpieza Total
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MatchSeat::truncate();
        FootballMatch::truncate();
        Seat::truncate();
        Sector::truncate();
        Stadium::truncate();
        Team::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Usuarios
        User::create(['name' => 'Admin User', 'email' => 'admin@labstocks.com', 'password' => Hash::make('password'), 'role' => 'admin']);
        User::create(['name' => 'John Doe', 'email' => 'john@example.com', 'password' => Hash::make('password'), 'role' => 'customer', 'points' => 150]);
        User::create(['name' => 'Jane Smith', 'email' => 'jane@example.com', 'password' => Hash::make('password'), 'role' => 'customer', 'points' => 450]);

        // 3. Equipos
        $teams = [
            'barca' => Team::create(['name' => 'FC Barcelona', 'logo_path' => 'barca.png']),
            'madrid' => Team::create(['name' => 'Real Madrid', 'logo_path' => 'madrid.png']),
            'city' => Team::create(['name' => 'Manchester City', 'logo_path' => 'city.png']),
            'bayern' => Team::create(['name' => 'Bayern Munich', 'logo_path' => 'bayern.png']),
            'psg' => Team::create(['name' => 'Paris Saint-Germain', 'logo_path' => 'psg.png']),
            'liverpool' => Team::create(['name' => 'Liverpool FC', 'logo_path' => 'liverpool.png']),
            'milan' => Team::create(['name' => 'AC Milan', 'logo_path' => 'milan.png']),
            'inter' => Team::create(['name' => 'Inter Milan', 'logo_path' => 'inter.png']),
            'chelsea' => Team::create(['name' => 'Chelsea FC', 'logo_path' => 'chelsea.png']),
            'arsenal' => Team::create(['name' => 'Arsenal FC', 'logo_path' => 'arsenal.png']),
        ];

        // 4. Estadios
        $stadiums = [
            'camp_nou' => Stadium::create(['name' => 'Camp Nou', 'location' => 'Barcelona', 'capacity' => 99354]),
            'bernabeu' => Stadium::create(['name' => 'Santiago Bernabéu', 'location' => 'Madrid', 'capacity' => 81044]),
            'anfield' => Stadium::create(['name' => 'Anfield', 'location' => 'Liverpool', 'capacity' => 54000]),
            'san_siro' => Stadium::create(['name' => 'San Siro', 'location' => 'Milán', 'capacity' => 80000]),
            'parc_des_princes' => Stadium::create(['name' => 'Parc des Princes', 'location' => 'París', 'capacity' => 47000]),
        ];

        $sectorTypes = [
            ['name' => 'Tribuna VIP', 'price_modifier' => 2.5],
            ['name' => 'Lateral Alta', 'price_modifier' => 1.5],
            ['name' => 'Gol Fondo', 'price_modifier' => 1.0],
        ];

        foreach ($stadiums as $stadium) {
            foreach ($sectorTypes as $st) {
                $sector = Sector::create([
                    'stadium_id' => $stadium->id,
                    'name' => $st['name'],
                    'price_modifier' => $st['price_modifier'],
                    'capacity' => 50,
                ]);

                for ($i = 1; $i <= 2; $i++) {
                    for ($j = 1; $j <= 5; $j++) {
                        Seat::create(['sector_id' => $sector->id, 'row' => $i, 'number' => $j]);
                    }
                }
            }
        }

        // 5. Partidos
        $matchesData = [
            // Champions League
            ['h' => 'barca', 'a' => 'city', 's' => 'camp_nou', 'p' => 150, 'c' => 'Champions League', 'd' => 5],
            ['h' => 'madrid', 'a' => 'bayern', 's' => 'bernabeu', 'p' => 160, 'c' => 'Champions League', 'd' => 7],
            ['h' => 'psg', 'a' => 'liverpool', 's' => 'parc_des_princes', 'p' => 140, 'c' => 'Champions League', 'd' => 10],
            ['h' => 'milan', 'a' => 'madrid', 's' => 'san_siro', 'p' => 130, 'c' => 'Champions League', 'd' => 12],
            
            // Premier League
            ['h' => 'liverpool', 'a' => 'city', 's' => 'anfield', 'p' => 95, 'c' => 'Premier League', 'd' => 8],
            ['h' => 'chelsea', 'a' => 'arsenal', 's' => 'anfield', 'p' => 85, 'c' => 'Premier League', 'd' => 15],
            ['h' => 'city', 'a' => 'chelsea', 's' => 'camp_nou', 'p' => 110, 'c' => 'Premier League', 'd' => 18],

            // La Liga
            ['h' => 'barca', 'a' => 'madrid', 's' => 'camp_nou', 'p' => 180, 'c' => 'La Liga', 'd' => 20],
            ['h' => 'madrid', 'a' => 'barca', 's' => 'bernabeu', 'p' => 180, 'c' => 'La Liga', 'd' => 45],

            // Serie A
            ['h' => 'milan', 'a' => 'inter', 's' => 'san_siro', 'p' => 120, 'c' => 'Serie A', 'd' => 25],
            ['h' => 'inter', 'a' => 'milan', 's' => 'san_siro', 'p' => 120, 'c' => 'Serie A', 'd' => 60],
        ];

        foreach ($matchesData as $m) {
            $match = FootballMatch::create([
                'home_team_id' => $teams[$m['h']]->id,
                'away_team_id' => $teams[$m['a']]->id,
                'stadium_id' => $stadiums[$m['s']]->id,
                'match_date' => now()->addDays($m['d']),
                'base_price' => $m['p'],
                'competition' => $m['c'],
                'status' => 'scheduled',
            ]);

            $stadiumSeats = Seat::whereHas('sector', function($q) use ($match) {
                $q->where('stadium_id', $match->stadium_id);
            })->get();

            foreach ($stadiumSeats as $seat) {
                MatchSeat::create(['match_id' => $match->id, 'seat_id' => $seat->id, 'status' => 'available']);
            }
        }
    }
}
