<x-layouts.checker title="Manifest - BusGo">
    <div class="mt-4 mb-6">
        <h2 class="text-2xl font-bold text-white mb-1">Manifest Penumpang</h2>
        <p class="text-white/60 text-sm">Daftar penumpang per jadwal keberangkatan.</p>
    </div>

    <!-- Filter Form -->
    <form class="mb-6 space-y-3" method="GET" action="/checker/manifest">
        <div class="flex gap-2">
            <div class="flex-1">
                <label class="block text-xs text-white/50 mb-1">Tanggal Berangkat</label>
                <input type="date" name="date" value="{{ $date }}" class="w-full bg-[#1C1C1E] border border-white/10 rounded-xl px-3 py-2 text-white focus:border-primary focus:outline-none" onchange="this.form.submit()">
            </div>
            <div class="flex-[2]">
                <label class="block text-xs text-white/50 mb-1">Jadwal Bus</label>
                <select name="schedule_id" class="w-full bg-[#1C1C1E] border border-white/10 rounded-xl px-3 py-2 text-white focus:border-primary focus:outline-none" onchange="this.form.submit()">
                    @if($schedules->count() == 0)
                        <option value="">-- Tidak ada jadwal --</option>
                    @else
                        @foreach($schedules as $s)
                            <option value="{{ $s->id }}" {{ $scheduleId == $s->id ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($s->departure_time)->format('H:i') }} | {{ $s->route->origin->name }} - {{ $s->route->destination->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </form>

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
                    @if($schedules->count() == 0)
                        Tidak ada jadwal keberangkatan pada tanggal ini.
                    @else
                        Tidak ada penumpang pada jadwal ini.
                    @endif
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.checker>
