<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Schedule;

class PublicController extends Controller
{
    public function home()
    {
        $cities = City::all();
        return view('public.home', compact('cities'));
    }

    public function search(Request $request)
    {
        $origin = $request->query('origin');
        $destination = $request->query('destination');
        $date = $request->query('date', date('Y-m-d'));
        $passengers = $request->query('passengers', 1);

        $schedules = Schedule::with(['route.origin', 'route.destination'])
            ->whereHas('route', function($q) use ($origin, $destination) {
                if ($origin) $q->where('origin_city_id', $origin);
                if ($destination) $q->where('destination_city_id', $destination);
            })
            ->whereDate('departure_date', $date)
            ->get();

        $cities = City::all();

        return view('public.search', compact('schedules', 'origin', 'destination', 'date', 'passengers', 'cities'));
    }
}
