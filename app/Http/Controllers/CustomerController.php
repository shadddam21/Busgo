<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $recentOrders = Order::with(['schedule.route.origin', 'schedule.route.destination', 'seat'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        return view('customer.dashboard', compact('recentOrders'));
    }

    public function orders()
    {
        $orders = Order::with(['schedule.route.origin', 'schedule.route.destination', 'seat'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('customer.orders.index', compact('orders'));
    }

    public function profile()
    {
        return view('customer.profile');
    }

    public function ticket(Order $order)
    {
        if ($order->user_id !== Auth::id() || !in_array($order->status, ['confirmed', 'departed'])) {
            abort(404);
        }
        return view('customer.orders.ticket', compact('order'));
    }

    public function downloadTicket(Order $order)
    {
        if ($order->user_id !== Auth::id() || !in_array($order->status, ['confirmed', 'departed'])) {
            abort(404);
        }
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('customer.orders.ticket_pdf', compact('order'));
        return $pdf->download('E-Ticket-BusGo-' . $order->order_code . '.pdf');
    }
}
