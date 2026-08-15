<x-layouts.admin title="Laporan Pemesanan - BusGo">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Laporan Penjualan Tiket</h2>
        <p class="text-slate-600">Pantau performa penjualan tiket berdasarkan rentang waktu tertentu.</p>
    </div>

    <!-- Filter -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 mb-8">
        <form action="/admin/reports" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div>
                <label class="text-sm font-semibold text-slate-700 mb-1 block">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="form-input rounded-xl border-slate-200 focus:border-primary focus:ring-primary px-4 py-2">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 mb-1 block">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="form-input rounded-xl border-slate-200 focus:border-primary focus:ring-primary px-4 py-2">
            </div>
            <button type="submit" class="bg-primary hover:bg-primary-light text-white font-semibold py-2.5 px-6 rounded-xl transition shadow-md">
                Terapkan Filter
            </button>
        </form>
    </div>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-50 to-white p-6 rounded-2xl border border-blue-100 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-sm text-slate-500 font-medium">Total Pendapatan</div>
                <div class="text-3xl font-bold text-slate-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-green-50 to-white p-6 rounded-2xl border border-green-100 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
            </div>
            <div>
                <div class="text-sm text-slate-500 font-medium">Tiket Terjual (Berhasil)</div>
                <div class="text-3xl font-bold text-slate-800">{{ $totalTickets }} Tiket</div>
            </div>
        </div>
    </div>

    <!-- Data Transaksi -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-200">
            <h3 class="font-bold text-slate-800">Rincian Transaksi Sukses</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Tgl Transaksi</th>
                        <th class="px-6 py-4 font-semibold">Booking ID</th>
                        <th class="px-6 py-4 font-semibold">Penumpang</th>
                        <th class="px-6 py-4 font-semibold">Rute & Waktu Berangkat</th>
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
                            <td class="px-6 py-4 font-bold text-slate-800 text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                Tidak ada data transaksi yang sukses pada rentang tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
