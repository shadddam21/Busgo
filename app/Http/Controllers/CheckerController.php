<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\CheckerLog;
use Illuminate\Support\Facades\Auth;

class CheckerController extends Controller
{
    public function dashboard()
    {
        $todayScans = CheckerLog::where('user_id', Auth::id())
            ->whereDate('scanned_at', date('Y-m-d'))
            ->count();
            
        $recentLogs = CheckerLog::with(['order.user', 'order.schedule.route.origin'])
            ->where('user_id', Auth::id())
            ->orderBy('scanned_at', 'desc')
            ->take(5)
            ->get();
            
        return view('checker.dashboard', compact('todayScans', 'recentLogs'));
    }

    public function scan()
    {
        return view('checker.scan');
    }

    public function processScan(Request $request)
    {
        $token = $request->input('qr_token');
        $orderCode = $request->input('order_code');
        
        $query = Order::with(['user', 'schedule.route.origin', 'schedule.route.destination', 'seat']);
        
        if ($token) {
            $query->where('qr_token', $token);
        } else if ($orderCode) {
            $query->where('order_code', $orderCode);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Parameter tidak valid.'
            ]);
        }
        
        $order = $query->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan / QR Code tidak valid.'
            ]);
        }

        if ($order->status !== 'confirmed') {
            return response()->json([
                'success' => false,
                'message' => 'Status tiket bukan Aktif/Confirmed (Status saat ini: '.$order->status.').'
            ]);
        }

        if ($order->is_qr_used) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket sudah digunakan sebelumnya.'
            ]);
        }

        // Process Check-in
        $order->update([
            'is_qr_used' => true,
            'status' => 'departed'
        ]);

        CheckerLog::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'scanned_at' => now(),
            'status' => 'valid'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-in Berhasil!',
            'data' => [
                'passenger_name' => $order->user->name,
                'seat_number' => $order->seat->seat_number,
                'route' => $order->schedule->route->origin->name . ' - ' . $order->schedule->route->destination->name
            ]
        ]);
    }

    public function manifest()
    {
        $orders = Order::with(['user', 'schedule.route.origin', 'schedule.route.destination', 'seat'])
            ->whereDate('created_at', date('Y-m-d')) // simplistic: today's orders
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('checker.manifest', compact('orders'));
    }
}
