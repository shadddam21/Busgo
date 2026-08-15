<x-layouts.admin title="Manajemen Pemesanan - BusGo">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Daftar Pemesanan</h2>
            <p class="text-slate-600">Kelola semua transaksi tiket dari pengguna.</p>
        </div>
        <a href="/admin/orders/create" class="bg-primary hover:bg-primary-light text-white font-semibold py-2 px-4 rounded-xl shadow-sm transition">
            + Buat Pesanan Manual
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-6 font-medium border border-green-100">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Tgl Transaksi</th>
                        <th class="px-6 py-4 font-semibold">Booking ID</th>
                        <th class="px-6 py-4 font-semibold">Penumpang</th>
                        <th class="px-6 py-4 font-semibold">Rute & Waktu Berangkat</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Harga Tiket</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-slate-500">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 font-medium text-primary">{{ $order->order_code }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $order->user->name }}</div>
                                <div class="text-xs text-slate-500">Kursi: {{ $order->seat->seat_number }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-700">{{ $order->schedule->route->origin->name }} - {{ $order->schedule->route->destination->name }}</div>
                                <div class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($order->schedule->departure_date)->format('d M Y') }} | {{ substr($order->schedule->departure_time, 0, 5) }} WIB</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($order->status == 'pending')
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold">Menunggu Pembayaran</span>
                                @elseif($order->status == 'paid')
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">Menunggu Verifikasi</span>
                                @elseif($order->status == 'confirmed')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Berhasil / Aktif</span>
                                @elseif($order->status == 'departed')
                                    <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-xs font-bold">Berangkat / Hadir</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">Dibatalkan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-800 text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                Belum ada transaksi pemesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
