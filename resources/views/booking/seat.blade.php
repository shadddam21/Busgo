<x-layouts.public title="Pilih Kursi - BusGo">
    <div class="bg-primary/5 py-8 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800 mb-2">Pilih Kursi</h1>
                    <div class="text-slate-600 flex items-center gap-2">
                        <span class="font-semibold text-slate-800">{{ $schedule->route->origin->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        <span class="font-semibold text-slate-800">{{ $schedule->route->destination->name }}</span>
                        <span class="mx-2 text-slate-300">|</span>
                        <span>{{ \Carbon\Carbon::parse($schedule->departure_date)->translatedFormat('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col md:flex-row gap-8">
        <!-- Seat Selection Map -->
        <div class="w-full md:w-2/3">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-800">Denah Tempat Duduk</h2>
                    <div class="flex gap-4 text-sm">
                        <div class="flex items-center gap-2"><div class="w-4 h-4 bg-white border-2 border-primary rounded"></div><span class="text-slate-600">Tersedia</span></div>
                        <div class="flex items-center gap-2"><div class="w-4 h-4 bg-primary rounded"></div><span class="text-slate-600">Dipilih</span></div>
                        <div class="flex items-center gap-2"><div class="w-4 h-4 bg-slate-300 rounded"></div><span class="text-slate-600">Terisi</span></div>
                    </div>
                </div>

                @if($errors->any())
                    <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100 mb-6">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('booking.checkout', $schedule->id) }}" method="POST" id="bookingForm">
                    @csrf
                    
                    <div class="max-w-md mx-auto bg-slate-50 p-8 rounded-3xl border-2 border-slate-200 shadow-inner relative">
                        <!-- Sopir Area -->
                        <div class="flex justify-end mb-10 border-b-2 border-slate-200 pb-4">
                            <div class="w-12 h-12 bg-slate-200 rounded-lg flex items-center justify-center text-slate-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/></svg>
                            </div>
                        </div>

                        <!-- Grid Kursi -->
                        <div class="flex justify-between gap-12">
                            <!-- Kiri (A & B) -->
                            <div class="grid grid-cols-2 gap-4">
                                @for($i=1; $i<=10; $i++)
                                    @foreach(['A', 'B'] as $row)
                                        @php
                                            $seatName = $row.$i;
                                            $seat = $seats->firstWhere('seat_number', $seatName);
                                        @endphp
                                        <div class="relative">
                                            @if($seat)
                                                <input type="radio" name="seat_id" value="{{ $seat->id }}" id="seat_{{ $seat->id }}" class="peer hidden" {{ $seat->status != 'available' ? 'disabled' : '' }} onchange="updateSummary('{{ $seat->seat_number }}', {{ $schedule->price }})">
                                                <label for="seat_{{ $seat->id }}" class="w-12 h-12 flex items-center justify-center rounded-lg text-sm font-bold cursor-pointer transition-all border-2 
                                                    {{ $seat->status == 'available' ? 'bg-white border-primary text-primary hover:bg-primary-50 peer-checked:bg-primary peer-checked:text-white' : 'bg-slate-300 border-slate-300 text-white cursor-not-allowed' }}">
                                                    {{ $seatName }}
                                                </label>
                                            @endif
                                        </div>
                                    @endforeach
                                @endfor
                            </div>

                            <!-- Kanan (C & D) -->
                            <div class="grid grid-cols-2 gap-4">
                                @for($i=1; $i<=10; $i++)
                                    @foreach(['C', 'D'] as $row)
                                        @php
                                            $seatName = $row.$i;
                                            $seat = $seats->firstWhere('seat_number', $seatName);
                                        @endphp
                                        <div class="relative">
                                            @if($seat)
                                                <input type="radio" name="seat_id" value="{{ $seat->id }}" id="seat_{{ $seat->id }}" class="peer hidden" {{ $seat->status != 'available' ? 'disabled' : '' }} onchange="updateSummary('{{ $seat->seat_number }}', {{ $schedule->price }})">
                                                <label for="seat_{{ $seat->id }}" class="w-12 h-12 flex items-center justify-center rounded-lg text-sm font-bold cursor-pointer transition-all border-2 
                                                    {{ $seat->status == 'available' ? 'bg-white border-primary text-primary hover:bg-primary-50 peer-checked:bg-primary peer-checked:text-white' : 'bg-slate-300 border-slate-300 text-white cursor-not-allowed' }}">
                                                    {{ $seatName }}
                                                </label>
                                            @endif
                                        </div>
                                    @endforeach
                                @endfor
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Summary -->
        <div class="w-full md:w-1/3">
            <div class="bg-white border border-slate-200 rounded-xl p-6 sticky top-24 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-6 text-lg">Ringkasan Pesanan</h3>
                
                <div class="flex justify-between items-center mb-4 pb-4 border-b border-slate-100">
                    <span class="text-slate-500">Kursi Terpilih</span>
                    <span class="font-bold text-primary text-lg" id="selectedSeatLabel">-</span>
                </div>

                <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-100">
                    <span class="text-slate-500">Total Harga</span>
                    <span class="font-bold text-slate-800 text-xl" id="totalPriceLabel">Rp 0</span>
                </div>

                <button type="button" onclick="document.getElementById('bookingForm').submit()" class="w-full bg-primary hover:bg-primary-light text-white font-semibold py-3 px-4 rounded-xl transition shadow-md shadow-primary/20 text-lg flex justify-center items-center gap-2">
                    Lanjutkan
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        function updateSummary(seatNumber, price) {
            document.getElementById('selectedSeatLabel').innerText = seatNumber;
            // Format to IDR
            document.getElementById('totalPriceLabel').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(price);
        }
    </script>
</x-layouts.public>
