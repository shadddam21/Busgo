<x-layouts.admin title="Tambah Jadwal Baru - BusGo">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Tambah Jadwal Bus Baru</h2>
        <p class="text-slate-600">Jadwal baru akan otomatis memiliki 40 kursi kosong.</p>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 max-w-2xl">
        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100 mb-6">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/admin/schedules" method="POST">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Rute Perjalanan</label>
                    <select name="route_id" required class="w-full border border-slate-200 rounded-xl px-4 py-2 focus:ring-primary focus:border-primary">
                        <option value="">-- Pilih Rute --</option>
                        @foreach($routes as $r)
                            <option value="{{ $r->id }}">
                                {{ $r->origin->name }} - {{ $r->destination->name }} 
                                (Estimasi: {{ $r->duration }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Keberangkatan</label>
                    <input type="date" name="departure_date" required min="{{ date('Y-m-d') }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 focus:ring-primary focus:border-primary">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Jam Berangkat</label>
                        <input type="time" name="departure_time" required class="w-full border border-slate-200 rounded-xl px-4 py-2 focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Jam Tiba (Estimasi)</label>
                        <input type="time" name="arrival_time" required class="w-full border border-slate-200 rounded-xl px-4 py-2 focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Harga Tiket (Rp)</label>
                    <input type="number" name="price" required min="10000" class="w-full border border-slate-200 rounded-xl px-4 py-2 focus:ring-primary focus:border-primary" placeholder="Contoh: 150000">
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="/admin/schedules" class="px-5 py-2 text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl font-semibold transition">Batal</a>
                    <button type="submit" class="bg-primary hover:bg-primary-light text-white px-5 py-2 rounded-xl font-semibold transition shadow-sm">
                        Simpan Jadwal Baru
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.admin>
