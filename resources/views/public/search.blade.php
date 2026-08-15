<x-layouts.public title="Hasil Pencarian - BusGo">
    <div class="bg-primary/5 py-8 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Ubah Pencarian</h1>
            
            <form action="/search" method="GET" class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1 w-full">
                    <label class="text-xs text-slate-500 font-semibold mb-1">Dari</label>
                    <select name="origin" class="form-select w-full border-slate-200 rounded-lg focus:border-primary focus:ring-primary">
                        <option value="">Semua Kota</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ $origin == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex-1 w-full">
                    <label class="text-xs text-slate-500 font-semibold mb-1">Ke</label>
                    <select name="destination" class="form-select w-full border-slate-200 rounded-lg focus:border-primary focus:ring-primary">
                        <option value="">Semua Kota</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ $destination == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1 w-full">
                    <label class="text-xs text-slate-500 font-semibold mb-1">Tanggal</label>
                    <input type="date" name="date" class="form-input w-full border-slate-200 rounded-lg focus:border-primary focus:ring-primary" value="{{ $date }}">
                </div>

                <div class="flex-1 w-full">
                    <label class="text-xs text-slate-500 font-semibold mb-1">Penumpang</label>
                    <select name="passengers" class="form-select w-full border-slate-200 rounded-lg focus:border-primary focus:ring-primary">
                        @for($i=1; $i<=4; $i++)
                            <option value="{{ $i }}" {{ $passengers == $i ? 'selected' : '' }}>{{ $i }} Penumpang</option>
                        @endfor
                    </select>
                </div>

                <button type="submit" class="bg-primary hover:bg-primary-light text-white px-6 py-2 rounded-lg font-semibold h-[42px] transition w-full md:w-auto">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col md:flex-row gap-8">
        <!-- Sidebar Filter -->
        <div class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white border border-slate-200 rounded-xl p-4 sticky top-24">
                <h3 class="font-bold text-slate-800 mb-4">Filter</h3>
                
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Waktu Berangkat</h4>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" class="text-primary focus:ring-primary border-slate-300 rounded">
                            Pagi (06:00 - 12:00)
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" class="text-primary focus:ring-primary border-slate-300 rounded">
                            Siang (12:00 - 18:00)
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" class="text-primary focus:ring-primary border-slate-300 rounded">
                            Malam (18:00 - 06:00)
                        </label>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Kelas Bus</h4>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" class="text-primary focus:ring-primary border-slate-300 rounded">
                            Executive
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" class="text-primary focus:ring-primary border-slate-300 rounded">
                            VIP
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Result List -->
        <div class="flex-1">
            <h2 class="text-xl font-bold text-slate-800 mb-4">
                Tersedia {{ $schedules->count() }} Jadwal Keberangkatan
            </h2>

            <div class="space-y-4">
                @forelse($schedules as $schedule)
                    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                        <div class="flex flex-col md:flex-row justify-between gap-6">
                            <!-- Info Bus -->
                            <div class="flex gap-4">
                                <div class="w-16 h-16 bg-blue-50 rounded-lg flex items-center justify-center text-primary flex-shrink-0">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800 text-lg">BusGo Executive</div>
                                    <div class="text-sm text-slate-500 mb-2">AC • Reclining Seat • Toilet • Snack</div>
                                    <div class="flex items-center gap-4 text-sm text-slate-600">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-800">{{ substr($schedule->departure_time, 0, 5) }}</span>
                                            <span>{{ $schedule->route->origin->name }}</span>
                                        </div>
                                        <div class="flex flex-col items-center px-4 relative">
                                            <span class="text-xs text-slate-400 mb-1">{{ $schedule->route->duration }}</span>
                                            <div class="h-px w-full bg-slate-300 absolute top-1/2 mt-1"></div>
                                        </div>
                                        <div class="flex flex-col text-right">
                                            <span class="font-bold text-slate-800">{{ substr($schedule->arrival_time, 0, 5) }}</span>
                                            <span>{{ $schedule->route->destination->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Harga & CTA -->
                            <div class="flex flex-col items-end justify-between border-t md:border-t-0 md:border-l border-slate-200 pt-4 md:pt-0 md:pl-6">
                                <div class="text-right mb-4">
                                    <div class="text-xs text-slate-500">Harga per kursi</div>
                                    <div class="text-2xl font-bold text-primary">Rp {{ number_format($schedule->price, 0, ',', '.') }}</div>
                                    <div class="text-xs text-orange-500 font-semibold mt-1">Sisa {{ $schedule->seats()->where('status', 'available')->count() }} Kursi</div>
                                </div>
                                <a href="/booking/{{ $schedule->id }}?passengers={{ $passengers }}" class="bg-primary hover:bg-primary-light text-white font-semibold py-2 px-8 rounded-lg transition text-center w-full md:w-auto">
                                    Pilih Kursi
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border border-slate-200 rounded-xl p-12 text-center">
                        <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Maaf, jadwal tidak ditemukan</h3>
                        <p class="text-slate-500">Coba ubah rute atau tanggal keberangkatan Anda.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.public>
