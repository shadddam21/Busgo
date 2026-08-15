<x-layouts.admin title="Buat Pesanan Baru - BusGo">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Buat Pesanan Tiket (Manual)</h2>
        <p class="text-slate-600">Fitur untuk Admin membuatkan tiket bagi pelanggan (misal: bayar tunai di terminal).</p>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 max-w-2xl">
        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100 mb-6">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/admin/orders" method="POST">
            @csrf
            
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Pelanggan</label>
                        <input type="text" name="customer_name" required class="w-full border border-slate-200 rounded-xl px-4 py-2 focus:ring-primary focus:border-primary" placeholder="Masukkan nama">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">No. HP Pelanggan</label>
                        <input type="text" name="customer_phone" required class="w-full border border-slate-200 rounded-xl px-4 py-2 focus:ring-primary focus:border-primary" placeholder="08123456789">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email Pelanggan</label>
                    <input type="email" name="customer_email" required class="w-full border border-slate-200 rounded-xl px-4 py-2 focus:ring-primary focus:border-primary" placeholder="email@contoh.com">
                    <p class="text-xs text-slate-500 mt-1">Sistem akan membuat akun baru jika email belum terdaftar.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Jadwal & Rute</label>
                    <select name="schedule_id" required class="w-full border border-slate-200 rounded-xl px-4 py-2 focus:ring-primary focus:border-primary">
                        <option value="">-- Pilih Jadwal --</option>
                        @foreach($schedules as $s)
                            <option value="{{ $s->id }}">
                                {{ $s->route->origin->name }} - {{ $s->route->destination->name }} 
                                | {{ \Carbon\Carbon::parse($s->departure_date)->format('d M Y') }} ({{ substr($s->departure_time, 0, 5) }})
                                | Rp {{ number_format($s->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="bg-blue-50 text-blue-800 p-4 rounded-xl text-sm border border-blue-100 flex gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <strong>Catatan:</strong><br>
                        Sistem akan otomatis mencarikan kursi yang masih kosong (dari nomor paling depan). Pembayaran akan ditandai lunas (Cash).
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="/admin/orders" class="px-5 py-2 text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl font-semibold transition">Batal</a>
                    <button type="submit" class="bg-primary hover:bg-primary-light text-white px-5 py-2 rounded-xl font-semibold transition shadow-sm">
                        Buat Pesanan
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.admin>
