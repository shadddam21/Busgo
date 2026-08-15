<?php
namespace Database\Seeders;
use App\Models\City;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Seat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Users
        User::create(['name' => 'Admin Utama', 'email' => 'admin@busgo.com', 'password' => Hash::make('password'), 'role' => 'admin', 'phone' => '08110000001']);
        User::create(['name' => 'Checker Terminal', 'email' => 'checker@busgo.com', 'password' => Hash::make('password'), 'role' => 'checker', 'phone' => '08110000002']);
        
        $customers = [];
        for ($i=1; $i<=5; $i++) {
            $customers[] = User::create([
                'name' => "Customer $i",
                'email' => "customer$i@busgo.com",
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => "0822000000$i",
                'nik' => "3170000000000$i"
            ]);
        }

        // 2. Cities
        $cityNames = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang', 'Malang', 'Solo', 'Cirebon', 'Denpasar', 'Banyuwangi'];
        $cities = [];
        foreach ($cityNames as $name) {
            $cities[] = City::create(['name' => $name]);
        }

        // 3. Routes
        $routes = [
            ['origin' => 0, 'destination' => 2, 'price' => 350000, 'duration' => '10 Jam'], // Jkt - Sby
            ['origin' => 2, 'destination' => 0, 'price' => 350000, 'duration' => '10 Jam'], // Sby - Jkt
            ['origin' => 0, 'destination' => 1, 'price' => 150000, 'duration' => '3 Jam'],  // Jkt - Bdg
            ['origin' => 1, 'destination' => 0, 'price' => 150000, 'duration' => '3 Jam'],  // Bdg - Jkt
            ['origin' => 0, 'destination' => 3, 'price' => 250000, 'duration' => '8 Jam'],  // Jkt - Yog
            ['origin' => 3, 'destination' => 4, 'price' => 100000, 'duration' => '3 Jam'],  // Yog - Smg
            ['origin' => 0, 'destination' => 5, 'price' => 300000, 'duration' => '12 Jam'], // Jkt - Mlg
            ['origin' => 2, 'destination' => 8, 'price' => 200000, 'duration' => '7 Jam'],  // Sby - Dps
        ];
        
        $routeModels = [];
        foreach ($routes as $r) {
            $routeModels[] = Route::create([
                'origin_city_id' => $cities[$r['origin']]->id,
                'destination_city_id' => $cities[$r['destination']]->id,
                'price' => $r['price'],
                'duration' => $r['duration'],
            ]);
        }

        // 4. Schedules & 5. Seats
        $now = Carbon::now();
        foreach ($routeModels as $route) {
            for ($day=0; $day<3; $day++) {
                $schedule = Schedule::create([
                    'route_id' => $route->id,
                    'departure_date' => $now->copy()->addDays($day)->toDateString(),
                    'departure_time' => '08:00:00',
                    'arrival_time' => '18:00:00',
                    'price' => $route->price,
                    'total_seats' => 40
                ]);

                // Generate Seats (A1-A10, B1-B10, C1-C10, D1-D10)
                $rows = ['A', 'B', 'C', 'D'];
                foreach ($rows as $row) {
                    for ($num=1; $num<=10; $num++) {
                        Seat::create([
                            'schedule_id' => $schedule->id,
                            'seat_number' => $row.$num,
                            'status' => 'available'
                        ]);
                    }
                }
            }
        }
    }
}
