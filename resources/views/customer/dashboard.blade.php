<x-layouts.customer title="Dashboard - BusGo">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Dashboard</h2>
        <p class="text-slate-600">Selamat datang kembali, {{ auth()->user()->name }}!</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 bg-blue-50 text-primary rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
            </div>
            <div>
                <div class="text-sm text-slate-500 font-medium">Total Tiket Aktif</div>
                <div class="text-2xl font-bold text-slate-800">
                    {{ \App\Models\Order::where('user_id', auth()->id())->whereIn('status', ['paid', 'confirmed'])->count() }}
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 bg-orange-50 text-orange-500 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-sm text-slate-500 font-medium">Menunggu Pembayaran</div>
                <div class="text-2xl font-bold text-slate-800">
                    {{ \App\Models\Order::where('user_id', auth()->id())->where('status', 'pending')->count() }}
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 bg-green-50 text-green-600 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-sm text-slate-500 font-medium">Perjalanan Selesai</div>
                <div class="text-2xl font-bold text-slate-800">
                    {{ \App\Models\Order::where('user_id', auth()->id())->where('status', 'departed')->count() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-slate-800">Pesanan Terbaru</h3>
            <a href="/customer/orders" class="text-primary text-sm font-semibold hover:underline">Lihat Semua</a>
        </div>

        <div class="space-y-4">
            @forelse($recentOrders as $order)
                <div class="border border-slate-100 rounded-xl p-4 flex flex-col md:flex-row justify-between items-center gap-4 hover:border-slate-200 transition">
                    <div class="flex items-center gap-4 w-full md:w-auto">
                        <div class="bg-slate-50 p-3 rounded-lg text-slate-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400 mb-1">ID Pesanan: {{ $order->order_code }}</div>
                            <div class="font-bold text-slate-800">{{ $order->schedule->route->origin->name }} &rarr; {{ $order->schedule->route->destination->name }}</div>
                            <div class="text-sm text-slate-600">{{ \Carbon\Carbon::parse($order->schedule->departure_date)->translatedFormat('d M Y') }} • {{ substr($order->schedule->departure_time, 0, 5) }} • Kursi {{ $order->seat->seat_number }}</div>
                        </div>
                    </div>
                    <div class="flex flex-row md:flex-col items-center md:items-end justify-between w-full md:w-auto gap-2">
                        <div class="font-bold text-slate-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                        @if($order->status == 'pending')
                            <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-xs font-bold">Menunggu Pembayaran</span>
                        @elseif($order->status == 'paid')
                            <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-bold">Menunggu Verifikasi</span>
                        @elseif($order->status == 'confirmed')
                            <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-bold">Tiket Aktif</span>
                        @else
                            <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-bold">{{ ucfirst($order->status) }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-slate-500">
                    Belum ada pesanan terbaru.
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.customer>
