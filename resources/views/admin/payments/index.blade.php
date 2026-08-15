<x-layouts.admin title="Kelola Pembayaran - BusGo">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Verifikasi Pembayaran</h2>
        <p class="text-slate-600">Verifikasi bukti transfer dari customer untuk mengkonfirmasi tiket.</p>
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
                        <th class="px-6 py-4 font-semibold">Tgl & Jam</th>
                        <th class="px-6 py-4 font-semibold">Customer</th>
                        <th class="px-6 py-4 font-semibold">Pesanan</th>
                        <th class="px-6 py-4 font-semibold">Detail Rekening</th>
                        <th class="px-6 py-4 font-semibold text-center">Bukti Transfer</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-slate-500 whitespace-nowrap">{{ $payment->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $payment->user->name }}</td>
                            <td class="px-6 py-4 text-slate-600">
                                <div>{{ $payment->order->order_code }}</div>
                                <div class="font-bold text-primary mt-1">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                <div class="font-semibold">{{ $payment->bank_name }}</div>
                                <div class="text-xs">a.n {{ $payment->account_name }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="/storage/{{ $payment->proof_image }}" target="_blank" class="inline-block bg-slate-100 hover:bg-slate-200 text-slate-600 p-2 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($payment->status == 'pending')
                                    <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-xs font-bold">Pending</span>
                                @elseif($payment->status == 'verified')
                                    <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-bold">Terverifikasi</span>
                                @else
                                    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($payment->status == 'pending')
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="/admin/payments/{{ $payment->id }}/verify" method="POST">
                                            @csrf
                                            <button class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-lg transition" title="Verifikasi">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            </button>
                                        </form>
                                        <form action="/admin/payments/{{ $payment->id }}/reject" method="POST">
                                            @csrf
                                            <button class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition" title="Tolak">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-slate-400 text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                                Tidak ada data pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
