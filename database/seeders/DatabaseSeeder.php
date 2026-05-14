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
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@labstocks.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $user1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'points' => 150,
        ]);

        $user2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'points' => 320,
        ]);

        // 3. Equipos
        $barca = Team::create(['name' => 'FC Barcelona', 'logo_path' => 'barca.png']);
        $madrid = Team::create(['name' => 'Real Madrid', 'logo_path' => 'madrid.png']);
        $city = Team::create(['name' => 'Manchester City', 'logo_path' => 'city.png']);
        $bayern = Team::create(['name' => 'Bayern Munich', 'logo_path' => 'bayern.png']);

        // 4. Estadios
        $campNou = Stadium::create(['name' => 'Camp Nou', 'location' => 'Barcelona', 'capacity' => 99354]);
        $bernabeu = Stadium::create(['name' => 'Santiago Bernabéu', 'location' => 'Madrid', 'capacity' => 81044]);

        $stadiums = [$campNou, $bernabeu];
        $sectors = [
            ['name' => 'Tribuna VIP', 'price_modifier' => 2.5],
            ['name' => 'Lateral', 'price_modifier' => 1.2],
        ];

        foreach ($stadiums as $stadium) {
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
        }

        // 5. Partidos
        $matches = [
            [
                'home_team_id' => $barca->id, 'away_team_id' => $madrid->id,
                'stadium_id' => $campNou->id, 'match_date' => now()->addDays(7),
                'base_price' => 120.0, 'competition' => 'La Liga', 'status' => 'scheduled',
            ],
            [
                'home_team_id' => $city->id, 'away_team_id' => $barca->id,
                'stadium_id' => $campNou->id, 'match_date' => now()->addDays(10),
                'base_price' => 150.0, 'competition' => 'Champions League', 'status' => 'scheduled',
            ],
            [
                'home_team_id' => $madrid->id, 'away_team_id' => $bayern->id,
                'stadium_id' => $bernabeu->id, 'match_date' => now()->addDays(12),
                'base_price' => 140.0, 'competition' => 'Champions League', 'status' => 'scheduled',
            ],
        ];

        foreach ($matches as $mData) {
            $match = FootballMatch::create($mData);
            dump("Partido creado: " . $match->competition);
            
            // Asignar asientos del estadio correspondiente
            $stadiumSeats = Seat::whereHas('sector', function($q) use ($match) {
                $q->where('stadium_id', $match->stadium_id);
            })->get();
            
            dump("Asientos encontrados para este partido: " . $stadiumSeats->count());

            foreach ($stadiumSeats as $seat) {
                MatchSeat::create([
                    'match_id' => $match->id,
                    'seat_id' => $seat->id,
                    'status' => 'available',
                ]);
            }
        }
        dump("Seeder finalizado correctamente");
    }
}
