<x-layouts.customer title="Pesanan Saya - BusGo">
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Pesanan Saya</h2>
            <p class="text-slate-600">Daftar riwayat pemesanan tiket Anda.</p>
        </div>
        <a href="/search" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-primary-light transition shadow">
            + Pesan Tiket Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-600 p-4 rounded-xl text-sm font-medium border border-green-100 mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">ID Pesanan</th>
                        <th class="px-6 py-4 font-semibold">Rute & Tanggal</th>
                        <th class="px-6 py-4 font-semibold">Kursi</th>
                        <th class="px-6 py-4 font-semibold">Total Harga</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $order->order_code }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $order->schedule->route->origin->name }} &rarr; {{ $order->schedule->route->destination->name }}</div>
                                <div class="text-slate-500 text-xs">{{ \Carbon\Carbon::parse($order->schedule->departure_date)->translatedFormat('d M Y') }} • {{ substr($order->schedule->departure_time, 0, 5) }}</div>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-700">{{ $order->seat->seat_number }}</td>
                            <td class="px-6 py-4 font-bold text-slate-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($order->status == 'pending')
                                    <span class="bg-orange-100 text-orange-600 px-2.5 py-1 rounded-full text-xs font-bold">Menunggu</span>
                                @elseif($order->status == 'paid')
                                    <span class="bg-blue-100 text-blue-600 px-2.5 py-1 rounded-full text-xs font-bold">Verifikasi</span>
                                @elseif($order->status == 'confirmed')
                                    <span class="bg-green-100 text-green-600 px-2.5 py-1 rounded-full text-xs font-bold">Aktif</span>
                                @else
                                    <span class="bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full text-xs font-bold">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <!-- Untuk tiket aktif, bisa cetak E-Ticket -->
                                @if(in_array($order->status, ['confirmed', 'departed']))
                                    <a href="{{ route('customer.ticket', $order->id) }}" class="text-primary font-semibold hover:underline text-sm">Lihat E-Ticket</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                Belum ada riwayat pesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.customer>
