<x-layouts.checker title="Manifest - BusGo">
    <div class="mt-4 mb-6">
        <h2 class="text-2xl font-bold text-white mb-1">Manifest Penumpang</h2>
        <p class="text-white/60 text-sm">Daftar penumpang hari ini.</p>
    </div>

    <div class="mb-24">
        <div class="space-y-3">
            @forelse($orders as $order)
                <div class="bg-[#1C1C1E] border {{ $order->is_qr_used ? 'border-primary/50' : 'border-white/5' }} rounded-xl p-4 flex items-center gap-4">
                    <div class="w-12 h-12 bg-black rounded-lg flex items-center justify-center text-xl font-bold {{ $order->is_qr_used ? 'text-primary' : 'text-white/40' }} flex-shrink-0">
                        {{ $order->seat->seat_number }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-white truncate">{{ $order->user->name }}</div>
                        <div class="text-xs text-white/50 truncate">{{ $order->order_code }}</div>
                        <div class="text-[10px] text-white/40 mt-1">{{ $order->schedule->route->origin->name }} - {{ $order->schedule->route->destination->name }}</div>
                    </div>
                    <div class="text-right flex-shrink-0">
                        @if($order->is_qr_used)
                            <span class="bg-primary/20 text-primary px-2 py-1 rounded text-[10px] font-bold">Checked In</span>
                        @elseif($order->status == 'confirmed')
                            <span class="bg-white/10 text-white/60 px-2 py-1 rounded text-[10px] font-bold">Belum Hadir</span>
                        @else
                            <span class="bg-red-500/20 text-red-500 px-2 py-1 rounded text-[10px] font-bold">Dibatalkan</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-white/40 text-sm">
                    Tidak ada penumpang hari ini.
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.checker>
