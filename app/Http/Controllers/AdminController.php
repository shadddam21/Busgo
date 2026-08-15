<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\City;
use App\Models\Route;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingPayments = Payment::where('status', 'pending')->count();
        $todayOrders = Order::whereDate('created_at', date('Y-m-d'))->count();
        $totalRevenue = Order::whereIn('status', ['paid', 'confirmed', 'departed'])->sum('total_price');
        $activeSchedules = Schedule::whereDate('departure_date', '>=', date('Y-m-d'))->count();

        $recentPayments = Payment::with(['user', 'order.schedule.route.origin', 'order.schedule.route.destination'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('pendingPayments', 'todayOrders', 'totalRevenue', 'activeSchedules', 'recentPayments'));
    }

    public function payments()
    {
        $payments = Payment::with(['user', 'order.schedule.route.origin', 'order.schedule.route.destination'])
            ->orderByRaw("FIELD(status, 'pending') DESC")
            ->orderBy('created_at', 'desc')
            ->get();
            
        $pendingPayments = Payment::where('status', 'pending')->count();
        return view('admin.payments.index', compact('payments', 'pendingPayments'));
    }

    public function verifyPayment(Request $request, Payment $payment)
    {
        $payment->update(['status' => 'verified']);
        $payment->order->update(['status' => 'confirmed']); // QR Token is generated at creation

        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function rejectPayment(Request $request, Payment $payment)
    {
        $payment->update(['status' => 'rejected']);
        $payment->order->update(['status' => 'cancelled']);
        
        // Free up the seat
        $payment->order->seat->update(['status' => 'available']);

        return back()->with('success', 'Pembayaran ditolak. Kursi kembali tersedia.');
    }

    // Mock other pages for now
    public function schedules() { 
        $schedules = Schedule::with(['route.origin', 'route.destination'])->orderBy('departure_date', 'desc')->get();
        return view('admin.schedules.index', compact('schedules')); 
    }

    public function createSchedule()
    {
        $routes = \App\Models\Route::with(['origin', 'destination'])->get();
        return view('admin.schedules.create', compact('routes'));
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'route_id' => 'required|exists:routes,id',
            'departure_date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i',
            'price' => 'required|numeric|min:0',
        ]);

        $schedule = Schedule::create([
            'route_id' => $request->route_id,
            'departure_date' => $request->departure_date,
            'departure_time' => $request->departure_time . ':00',
            'arrival_time' => $request->arrival_time . ':00',
            'price' => $request->price,
            'total_seats' => 40
        ]);

        // Generate Seats (A1-A10, B1-B10, C1-C10, D1-D10)
        $rows = ['A', 'B', 'C', 'D'];
        foreach ($rows as $row) {
            for ($num = 1; $num <= 10; $num++) {
                \App\Models\Seat::create([
                    'schedule_id' => $schedule->id,
                    'seat_number' => $row . $num,
                    'status' => 'available'
                ]);
            }
        }

        return redirect('/admin/schedules')->with('success', 'Jadwal dan 40 kursi berhasil ditambahkan.');
    }

    public function editSchedule(Schedule $schedule)
    {
        $routes = \App\Models\Route::with(['origin', 'destination'])->get();
        return view('admin.schedules.edit', compact('schedule', 'routes'));
    }

    public function updateSchedule(Request $request, Schedule $schedule)
    {
        $request->validate([
            'route_id' => 'required|exists:routes,id',
            'departure_date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i',
            'price' => 'required|numeric|min:0',
        ]);

        $schedule->update([
            'route_id' => $request->route_id,
            'departure_date' => $request->departure_date,
            'departure_time' => strlen($request->departure_time) == 5 ? $request->departure_time . ':00' : $request->departure_time,
            'arrival_time' => strlen($request->arrival_time) == 5 ? $request->arrival_time . ':00' : $request->arrival_time,
            'price' => $request->price,
        ]);

        return redirect('/admin/schedules')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function deleteSchedule(Schedule $schedule)
    {
        // Delete seats related to this schedule first (or rely on cascading foreign keys, but safe to delete manually if needed)
        \App\Models\Seat::where('schedule_id', $schedule->id)->delete();
        $schedule->delete();

        return redirect('/admin/schedules')->with('success', 'Jadwal berhasil dihapus.');
    }

    public function orders()
    {
        $orders = Order::with(['user', 'schedule.route.origin', 'schedule.route.destination', 'seat'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function createOrder()
    {
        $schedules = Schedule::with(['route.origin', 'route.destination'])
            ->whereDate('departure_date', '>=', date('Y-m-d'))
            ->orderBy('departure_date', 'asc')
            ->get();
            
        return view('admin.orders.create', compact('schedules'));
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'schedule_id' => 'required|exists:schedules,id',
        ]);
        
        $user = \App\Models\User::firstOrCreate(
            ['email' => $request->customer_email],
            [
                'name' => $request->customer_name,
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'customer',
                'phone' => $request->customer_phone,
                'nik' => '0000000000000000'
            ]
        );

        $schedule = Schedule::findOrFail($request->schedule_id);
        $seat = $schedule->seats()->where('status', 'available')->orderBy('seat_number')->first();

        if (!$seat) {
            return back()->withErrors(['schedule_id' => 'Jadwal ini sudah penuh (tidak ada kursi tersedia).']);
        }

        $order = Order::create([
            'order_code' => 'ORD-' . strtoupper(\Illuminate\Support\Str::random(8)),
            'user_id' => $user->id,
            'schedule_id' => $schedule->id,
            'seat_id' => $seat->id,
            'total_price' => $schedule->price,
            'status' => 'confirmed', 
            'qr_token' => (string) \Illuminate\Support\Str::uuid(),
            'is_qr_used' => false
        ]);

        Payment::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'bank_name' => 'CASH/MANUAL',
            'account_name' => 'ADMIN: ' . \Illuminate\Support\Facades\Auth::user()->name,
            'amount' => $schedule->price,
            'proof_image' => 'manual',
            'status' => 'verified'
        ]);

        $seat->update(['status' => 'booked']);

        return redirect('/admin/orders')->with('success', 'Pesanan manual berhasil dibuat untuk kursi: ' . $seat->seat_number);
    }
    public function driverLetters() { 
        $schedules = Schedule::with(['route.origin', 'route.destination'])->orderBy('departure_date', 'asc')->get();
        return view('admin.driver_letters.index', compact('schedules')); 
    }

    public function downloadSuratJalan(Schedule $schedule)
    {
        $orders = Order::with(['user', 'seat'])
            ->where('schedule_id', $schedule->id)
            ->whereIn('status', ['confirmed', 'departed'])
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.driver_letters.pdf', compact('schedule', 'orders'));
        return $pdf->download('Surat-Jalan-BusGo-' . \Carbon\Carbon::parse($schedule->departure_date)->format('Ymd') . '-' . $schedule->id . '.pdf');
    }
    public function cities() { 
        $cities = City::all();
        return view('admin.cities.index', compact('cities')); 
    }
    public function routes() { 
        $routes = Route::with(['origin', 'destination'])->get();
        return view('admin.routes.index', compact('routes')); 
    }
    public function reports(Request $request) { 
        $startDate = $request->query('start_date', \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->query('end_date', \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d'));

        $orders = Order::with(['schedule.route.origin', 'schedule.route.destination', 'user', 'seat'])
            ->whereIn('status', ['confirmed', 'departed'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $orders->sum('total_price');
        $totalTickets = $orders->count();

        return view('admin.reports.index', compact('orders', 'startDate', 'endDate', 'totalRevenue', 'totalTickets')); 
    }
    public function users() { return view('admin.users.index'); }
}
