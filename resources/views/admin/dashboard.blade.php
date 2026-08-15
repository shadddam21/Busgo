<x-layouts.admin title="Dashboard Admin - BusGo">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Dashboard Utama</h2>
        <p class="text-slate-600">Ringkasan performa dan operasional BusGo hari ini.</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 bg-blue-50 text-primary rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-sm text-slate-500 font-medium">Total Pendapatan</div>
                <div class="text-xl font-bold text-slate-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 bg-orange-50 text-orange-500 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            </div>
            <div>
                <div class="text-sm text-slate-500 font-medium">Pembayaran Pending</div>
                <div class="text-2xl font-bold text-slate-800">{{ $pendingPayments }}</div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 bg-green-50 text-green-600 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
            </div>
            <div>
                <div class="text-sm text-slate-500 font-medium">Tiket Terjual Hari Ini</div>
                <div class="text-2xl font-bold text-slate-800">{{ $todayOrders }}</div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <div class="text-sm text-slate-500 font-medium">Jadwal Aktif</div>
                <div class="text-2xl font-bold text-slate-800">{{ $activeSchedules }}</div>
            </div>
        </div>
    </div>

    <!-- Menunggu Verifikasi Pembayaran -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800">Menunggu Verifikasi Pembayaran</h3>
            <a href="/admin/payments" class="text-primary text-sm font-semibold hover:underline">Kelola Semua</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Tgl Bayar</th>
                        <th class="px-6 py-4 font-semibold">Customer</th>
                        <th class="px-6 py-4 font-semibold">Bank</th>
                        <th class="px-6 py-4 font-semibold">Rute</th>
                        <th class="px-6 py-4 font-semibold">Total Transfer</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentPayments as $payment)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-slate-500">{{ $payment->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $payment->user->name }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $payment->bank_name }} a.n {{ $payment->account_name }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $payment->order->schedule->route->origin->name }} &rarr; {{ $payment->order->schedule->route->destination->name }}</td>
                            <td class="px-6 py-4 font-bold text-primary">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($payment->status == 'pending')
                                    <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-xs font-bold">Pending</span>
                                @elseif($payment->status == 'verified')
                                    <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-bold">Terverifikasi</span>
                                @else
                                    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                Tidak ada pembayaran yang perlu diverifikasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
