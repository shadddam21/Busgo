<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Schedule;
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

        /**
         * Validasi Bertingkat:
         * 1. Pastikan tiket berstatus 'confirmed' (sudah lunas dan tervalidasi).
         * 2. Pastikan tiket belum pernah di-scan sebelumnya untuk mencegah duplikasi check-in.
         */
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

        /**
         * MENGGUNAKAN DATABASE TRANSACTION
         * Penjelasan: Jika CheckerLog gagal disimpan (misalnya ada bug database),
         * maka tiket tidak akan hangus (tidak akan diupdate jadi 'departed').
         */
        \Illuminate\Support\Facades\DB::transaction(function () use ($order) {
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
        });

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

    public function manifest(Request $request)
    {
        $date = $request->query('date', date('Y-m-d'));

        // Ambil semua jadwal yang berangkat pada tanggal yang dipilih
        $schedules = Schedule::with(['route.origin', 'route.destination'])
            ->whereDate('departure_date', $date)
            ->orderBy('departure_time', 'asc')
            ->get();
            
        $scheduleId = $request->query('schedule_id');
        
        $orders = collect();
        if ($schedules->count() > 0) {
            if (!$scheduleId || !$schedules->contains('id', $scheduleId)) {
                $scheduleId = $schedules->first()->id;
            }

            $orders = Order::with(['user', 'schedule.route.origin', 'schedule.route.destination', 'seat'])
                ->where('orders.schedule_id', $scheduleId)
                ->whereIn('orders.status', ['confirmed', 'departed'])
                ->join('seats', 'orders.seat_id', '=', 'seats.id')
                ->orderBy('seats.seat_number', 'asc')
                ->select('orders.*') // Hindari konflik kolom ID antar tabel dengan hanya mengambil kolom spesifik dari tabel orders
                ->get();
        }
            
        return view('checker.manifest', compact('orders', 'date', 'schedules', 'scheduleId'));
    }
}
