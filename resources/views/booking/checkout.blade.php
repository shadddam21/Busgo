<x-layouts.public title="Checkout - BusGo">
    <div class="bg-primary/5 py-8 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-slate-800 mb-2">Checkout Pembayaran</h1>
            <div class="text-slate-600 flex items-center gap-2">
                <span>Selesaikan pembayaran Anda untuk mengamankan tiket.</span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col md:flex-row gap-8">
        <div class="w-full md:w-2/3">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm mb-6">
                <h2 class="text-lg font-bold text-slate-800 mb-6 pb-4 border-b border-slate-100">Detail Penumpang</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs text-slate-500 font-semibold mb-1 block">Nama Lengkap</label>
                        <div class="font-semibold text-slate-800">{{ auth()->user()->name }}</div>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500 font-semibold mb-1 block">Email</label>
                        <div class="font-semibold text-slate-800">{{ auth()->user()->email }}</div>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500 font-semibold mb-1 block">No HP</label>
                        <div class="font-semibold text-slate-800">{{ auth()->user()->phone }}</div>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500 font-semibold mb-1 block">NIK KTP</label>
                        <div class="font-semibold text-slate-800">{{ auth()->user()->nik }}</div>
                    </div>
                </div>
            </div>

            <form action="{{ route('booking.process', $schedule->id) }}" method="POST" enctype="multipart/form-data" id="checkoutForm">
                @csrf
                <input type="hidden" name="seat_id" value="{{ $seat->id }}">
                
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-800 mb-6 pb-4 border-b border-slate-100">Metode Pembayaran</h2>
                    
                    <div class="bg-blue-50 border-l-4 border-primary p-4 rounded-r-xl mb-6 flex gap-4">
                        <svg class="w-6 h-6 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <h4 class="font-semibold text-primary mb-1">Transfer Bank</h4>
                            <p class="text-sm text-slate-600">Silakan transfer sesuai nominal ke salah satu rekening berikut:<br>
                            - BCA: <strong>1234567890</strong> a.n. PT BusGo Indonesia<br>
                            - Mandiri: <strong>0987654321</strong> a.n. PT BusGo Indonesia</p>
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100 mb-6">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Bank Pengirim</label>
                            <input name="bank_name" type="text" required class="form-input rounded-xl w-full px-4 py-3 border-slate-200 focus:border-primary focus:ring-primary" placeholder="Contoh: BCA">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Pemilik Rekening</label>
                            <input name="account_name" type="text" required class="form-input rounded-xl w-full px-4 py-3 border-slate-200 focus:border-primary focus:ring-primary" placeholder="Sesuai buku tabungan">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Upload Bukti Transfer</label>
                            <input name="proof_image" type="file" required accept="image/*" class="form-input rounded-xl w-full px-4 py-2 border-slate-200 focus:border-primary focus:ring-primary file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary hover:file:bg-primary-100">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="w-full md:w-1/3">
            <div class="bg-white border border-slate-200 rounded-xl p-6 sticky top-24 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-6 text-lg">Ringkasan Pesanan</h3>
                
                <div class="space-y-4 mb-6 pb-6 border-b border-slate-100">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Rute</span>
                        <span class="font-semibold text-slate-800 text-right">{{ $schedule->route->origin->name }} - {{ $schedule->route->destination->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Waktu</span>
                        <span class="font-semibold text-slate-800 text-right">{{ substr($schedule->departure_time, 0, 5) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Tanggal</span>
                        <span class="font-semibold text-slate-800 text-right">{{ \Carbon\Carbon::parse($schedule->departure_date)->translatedFormat('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">No Kursi</span>
                        <span class="font-bold text-primary">{{ $seat->seat_number }}</span>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <span class="font-bold text-slate-800">Total Harga</span>
                    <span class="font-bold text-slate-800 text-2xl">Rp {{ number_format($schedule->price, 0, ',', '.') }}</span>
                </div>

                <button type="button" onclick="document.getElementById('checkoutForm').submit()" class="w-full bg-primary hover:bg-primary-light text-white font-semibold py-3 px-4 rounded-xl transition shadow-md shadow-primary/20 text-lg flex justify-center items-center gap-2">
                    Selesaikan Pembayaran
                </button>
            </div>
        </div>
    </div>
</x-layouts.public>
