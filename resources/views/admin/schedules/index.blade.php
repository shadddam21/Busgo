<x-layouts.admin title="Manajemen Jadwal - BusGo">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Manajemen Jadwal Bus</h2>
            <p class="text-slate-600">Kelola jadwal keberangkatan dan harga tiket.</p>
        </div>
        <a href="/admin/schedules/create" class="bg-primary hover:bg-primary-light text-white font-semibold py-2 px-4 rounded-xl shadow-sm transition">
            + Tambah Jadwal Baru
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
                        <th class="px-6 py-4 font-semibold">Tgl Berangkat</th>
                        <th class="px-6 py-4 font-semibold">Rute (Asal - Tujuan)</th>
                        <th class="px-6 py-4 font-semibold">Jam Berangkat</th>
                        <th class="px-6 py-4 font-semibold">Jam Tiba</th>
                        <th class="px-6 py-4 font-semibold">Harga</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($schedules as $s)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-medium">{{ \Carbon\Carbon::parse($s->departure_date)->format('d M Y') }}</td>
                            <td class="px-6 py-4">{{ $s->route->origin->name }} - {{ $s->route->destination->name }}</td>
                            <td class="px-6 py-4">{{ substr($s->departure_time, 0, 5) }} WIB</td>
                            <td class="px-6 py-4">{{ substr($s->arrival_time, 0, 5) }} WIB</td>
                            <td class="px-6 py-4 font-bold text-primary">Rp {{ number_format($s->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-right flex justify-end gap-2">
                                <a href="/admin/schedules/{{ $s->id }}/edit" class="text-blue-600 hover:text-blue-800 bg-blue-50 px-3 py-1 rounded-lg text-sm font-semibold transition">Edit</a>
                                <form action="/admin/schedules/{{ $s->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini beserta semua kursi yang terkait?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 bg-red-50 px-3 py-1 rounded-lg text-sm font-semibold transition">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">Belum ada jadwal.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
