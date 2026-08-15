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
    public function orders() { 
        $orders = Order::with(['user', 'schedule.route.origin', 'schedule.route.destination', 'seat'])->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders')); 
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
