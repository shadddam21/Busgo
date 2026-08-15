<x-layouts.public title="E-Ticket - {{ $order->order_code }}">
    <div class="bg-primary/5 py-8 border-b border-slate-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">E-Ticket Anda</h1>
                <p class="text-slate-600">Tunjukkan QR Code ini kepada petugas (Checker) saat naik bus.</p>
            </div>
            <a href="{{ route('customer.ticket.download', $order->id) }}" class="bg-primary hover:bg-primary-light text-white font-semibold py-2 px-6 rounded-lg transition shadow-md flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Unduh PDF
            </a>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200">
            <!-- Header Ticket -->
            <div class="bg-primary text-white p-6 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24"><path d="M4 16c0 .88.39 1.67 1 2.22V20c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h8v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1.78c.61-.55 1-1.34 1-2.22V6c0-3.5-3.58-4-8-4s-8 .5-8 4v10zm3.5 1c-.83 0-1.5-.67-1.5-1.5S6.67 14 7.5 14s1.5.67 1.5 1.5S8.33 17 7.5 17zm9 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-6H6V6h12v5z"/></svg>
                    <span class="text-2xl font-bold tracking-wider">BusGo</span>
                </div>
                <div class="text-right">
                    <div class="text-primary-100 text-sm">Booking ID</div>
                    <div class="text-xl font-bold font-mono">{{ $order->order_code }}</div>
                </div>
            </div>

            <!-- Body Ticket -->
            <div class="flex flex-col md:flex-row">
                <!-- Info Penumpang & Jadwal -->
                <div class="flex-1 p-8">
                    <div class="mb-8">
                        <div class="text-sm text-slate-500 mb-1">Nama Penumpang</div>
                        <div class="text-xl font-bold text-slate-800">{{ $order->user->name }}</div>
                        <div class="text-sm text-slate-500 mt-1">NIK: {{ $order->user->nik }}</div>
                    </div>

                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <div class="text-3xl font-bold text-slate-800">{{ substr($order->schedule->departure_time, 0, 5) }}</div>
                            <div class="text-slate-600 font-medium">{{ $order->schedule->route->origin->name }}</div>
                        </div>
                        <div class="flex-1 px-4 flex flex-col items-center">
                            <svg class="w-6 h-6 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            <div class="border-t-2 border-dashed border-slate-300 w-full"></div>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-slate-800">{{ substr($order->schedule->arrival_time, 0, 5) }}</div>
                            <div class="text-slate-600 font-medium">{{ $order->schedule->route->destination->name }}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <div class="text-sm text-slate-500 mb-1">Tanggal Berangkat</div>
                            <div class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($order->schedule->departure_date)->translatedFormat('l, d M Y') }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-slate-500 mb-1">Kelas Bus</div>
                            <div class="font-bold text-slate-800">Executive</div>
                        </div>
                        <div>
                            <div class="text-sm text-slate-500 mb-1">Nomor Kursi</div>
                            <div class="text-2xl font-black text-primary">{{ $order->seat->seat_number }}</div>
                        </div>
                    </div>
                </div>

                <!-- QR Code & Seat -->
                <div class="md:w-64 bg-slate-50 p-8 border-l border-dashed border-slate-300 flex flex-col items-center justify-center">
                    <div class="bg-white p-3 rounded-xl shadow-sm mb-4">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(160)->generate($order->qr_token) !!}
                    </div>
                    <div class="text-center">
                        <div class="text-xs text-slate-500 mb-1">Scan QR ini saat boarding</div>
                        @if($order->is_qr_used)
                            <div class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold mt-2">Sudah Digunakan</div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="bg-slate-100 p-4 text-center text-xs text-slate-500">
                Tiket ini adalah dokumen resmi. Harap tiba di terminal 30 menit sebelum jadwal keberangkatan.
            </div>
        </div>
        
        <div class="mt-6 text-center">
            <a href="/customer/orders" class="text-slate-500 hover:text-slate-700 font-medium text-sm transition">
                &larr; Kembali ke Pesanan Saya
            </a>
        </div>
    </div>
</x-layouts.public>
