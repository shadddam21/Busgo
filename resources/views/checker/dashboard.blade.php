<x-layouts.checker title="Dashboard - BusGo">
    <div class="mt-4 mb-8">
        <h2 class="text-2xl font-bold text-white">Dashboard</h2>
        <p class="text-white/60 text-sm">Selamat bekerja, {{ auth()->user()->name }}</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 gap-4 mb-8">
        <div class="bg-[#1C1C1E] border border-white/10 rounded-2xl p-4 flex flex-col items-center justify-center text-center">
            <div class="w-12 h-12 bg-primary/20 text-primary rounded-full flex items-center justify-center mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="text-3xl font-bold text-white mb-1">{{ $todayScans }}</div>
            <div class="text-xs text-white/50">Tiket Ter-scan Hari Ini</div>
        </div>
        
        <a href="/checker/scan" class="bg-primary hover:bg-primary-light transition rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-lg shadow-primary/20">
            <div class="w-12 h-12 bg-white/20 text-white rounded-full flex items-center justify-center mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
            </div>
            <div class="font-bold text-white">Scan Sekarang</div>
            <div class="text-xs text-white/70">Buka Kamera</div>
        </a>
    </div>

    <!-- Riwayat -->
    <div class="mb-24">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-white">Scan Terakhir</h3>
        </div>

        <div class="space-y-3">
            @forelse($recentLogs as $log)
                <div class="bg-[#1C1C1E] border border-white/5 rounded-xl p-4 flex items-center gap-4">
                    <div class="w-10 h-10 {{ $log->status == 'valid' ? 'bg-green-500/20 text-green-500' : 'bg-red-500/20 text-red-500' }} rounded-full flex items-center justify-center flex-shrink-0">
                        @if($log->status == 'valid')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-white truncate">{{ $log->order->user->name ?? 'Unknown' }}</div>
                        <div class="text-xs text-white/50 truncate">{{ $log->order->order_code ?? '-' }} • {{ $log->order->schedule->route->origin->name ?? '-' }}</div>
                    </div>
                    <div class="text-xs text-white/40 text-right">
                        {{ $log->scanned_at->diffForHumans() }}
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-white/40 text-sm">
                    Belum ada riwayat scan hari ini.
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.checker>
