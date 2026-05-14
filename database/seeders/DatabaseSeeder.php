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
        // Limpiar tablas para evitar errores de duplicados si no se usa fresh
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        Team::truncate();
        Stadium::truncate();
        Sector::truncate();
        Seat::truncate();
        FootballMatch::truncate();
        MatchSeat::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Usuarios
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

        // 2. Equipos
        $teamsData = [
            ['name' => 'FC Barcelona', 'logo_path' => 'barca.png'],
            ['name' => 'Real Madrid', 'logo_path' => 'madrid.png'],
            ['name' => 'Manchester City', 'logo_path' => 'city.png'],
            ['name' => 'Bayern Munich', 'logo_path' => 'bayern.png'],
        ];

        foreach ($teamsData as $data) {
            Team::create($data);
        }

        // 3. Estadio único para simplificar y asegurar que funcione
        $stadium = Stadium::create([
            'name' => 'Stadium LAB STOCKS',
            'location' => 'Global',
            'capacity' => 1000,
        ]);

        $sectors = [
            ['name' => 'Tribuna VIP', 'price_modifier' => 2.0],
            ['name' => 'Lateral', 'price_modifier' => 1.0],
        ];

        foreach ($sectors as $sData) {
            $sector = Sector::create([
                'stadium_id' => $stadium->id,
                'name' => $sData['name'],
                'price_modifier' => $sData['price_modifier'],
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

        // 4. Partidos
        $matchesData = [
            [
                'home_team_id' => 1, 'away_team_id' => 2,
                'stadium_id' => $stadium->id, 'match_date' => now()->addDays(7),
                'base_price' => 100.0, 'competition' => 'Champions League', 'status' => 'scheduled',
            ],
            [
                'home_team_id' => 3, 'away_team_id' => 4,
                'stadium_id' => $stadium->id, 'match_date' => now()->addDays(14),
                'base_price' => 80.0, 'competition' => 'La Liga', 'status' => 'scheduled',
            ],
        ];

        $seats = Seat::all();
        foreach ($matchesData as $mData) {
            $match = FootballMatch::create($mData);
            foreach ($seats as $seat) {
                MatchSeat::create([
                    'match_id' => $match->id,
                    'seat_id' => $seat->id,
                    'status' => 'available',
                ]);
            }
        }
    }
}
