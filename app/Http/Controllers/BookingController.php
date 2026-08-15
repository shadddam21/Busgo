<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Seat;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function seat(Schedule $schedule)
    {
        $seats = $schedule->seats()->orderBy('seat_number')->get();
        return view('booking.seat', compact('schedule', 'seats'));
    }

    public function checkout(Request $request, Schedule $schedule)
    {
        $request->validate([
            'seat_id' => 'required|exists:seats,id'
        ]);

        $seat = Seat::findOrFail($request->seat_id);
        if ($seat->status !== 'available') {
            return back()->withErrors(['seat_id' => 'Kursi sudah dipesan.']);
        }

        return view('booking.checkout', compact('schedule', 'seat'));
    }

    public function process(Request $request, Schedule $schedule)
    {
        $request->validate([
            'seat_id' => 'required|exists:seats,id',
            'bank_name' => 'required|string',
            'account_name' => 'required|string',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $seat = Seat::findOrFail($request->seat_id);
        
        // Validasi ulang ketersediaan kursi untuk mencegah kondisi balapan data (race condition)
        if ($seat->status !== 'available') {
            return redirect()->route('booking.seat', $schedule->id)->withErrors(['seat' => 'Kursi baru saja dipesan orang lain.']);
        }

        // Proses unggah dan simpan aset bukti pembayaran ke direktori penyimpanan lokal
        $imagePath = $request->file('proof_image')->store('payments', 'public');

        /**
         * MENGGUNAKAN DATABASE TRANSACTION
         * Transaksi ini menjamin sifat ACID (Atomik) untuk proses pemesanan.
         * Pembuatan Order, Payment, dan penguncian Seat harus berhasil seluruhnya.
         * Jika salah satu gagal, maka perubahan akan di-rollback untuk menghindari inkonsistensi.
         */
        \Illuminate\Support\Facades\DB::transaction(function () use ($schedule, $seat, $request, $imagePath) {
            // 1. Inisiasi entitas Pesanan (Order)
            $order = Order::create([
                'order_code' => 'ORD-' . strtoupper(Str::random(8)),
                'user_id' => Auth::id(),
                'schedule_id' => $schedule->id,
                'seat_id' => $seat->id,
                'total_price' => $schedule->price,
                'status' => 'pending',
                'qr_token' => (string) Str::uuid(),
                'is_qr_used' => false
            ]);

            // 2. Inisiasi entitas Pembayaran (Payment) yang berelasi dengan Pesanan di atas
            Payment::create([
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'bank_name' => $request->bank_name,
                'account_name' => $request->account_name,
                'amount' => $schedule->price,
                'proof_image' => $imagePath,
                'status' => 'pending'
            ]);

            // 3. Modifikasi status kursi menjadi 'booked' untuk mengunci ketersediaan
            $seat->update(['status' => 'booked']);
        });

        return redirect('/customer/orders')->with('success', 'Pemesanan berhasil dibuat, menunggu verifikasi admin.');
    }
}
