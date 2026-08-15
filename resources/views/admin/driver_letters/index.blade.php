<x-layouts.admin title="Surat Jalan - BusGo">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Cetak Surat Jalan</h2>
        <p class="text-slate-600">Pilih jadwal keberangkatan untuk mencetak surat jalan (manifest penumpang) untuk supir.</p>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Tgl Berangkat</th>
                        <th class="px-6 py-4 font-semibold">Jam</th>
                        <th class="px-6 py-4 font-semibold">Rute</th>
                        <th class="px-6 py-4 font-semibold">Plat Bus</th>
                        <th class="px-6 py-4 font-semibold">Total Penumpang</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($schedules as $schedule)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-medium text-slate-800">{{ \Carbon\Carbon::parse($schedule->departure_date)->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ substr($schedule->departure_time, 0, 5) }} WIB</td>
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $schedule->route->origin->name }} &rarr; {{ $schedule->route->destination->name }}</td>
                            <td class="px-6 py-4 text-slate-600">B {{ rand(1000, 9999) }} TX</td>
                            <td class="px-6 py-4 text-slate-600">
                                @php
                                    $count = \App\Models\Order::where('schedule_id', $schedule->id)->whereIn('status', ['confirmed', 'departed'])->count();
                                @endphp
                                <span class="bg-slate-100 px-3 py-1 rounded-full text-xs font-bold">{{ $count }} Penumpang</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="/admin/schedules/{{ $schedule->id }}/surat-jalan" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-light text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    Cetak PDF
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                Tidak ada data jadwal.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
