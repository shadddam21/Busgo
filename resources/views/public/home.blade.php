<x-layouts.public title="BusGo - Pesan Tiket Bus Mudah & Aman">
    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center pt-16 pb-24 gap-12">
            <div class="w-full md:w-1/2 z-10">
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 leading-tight mb-6">
                    Pesan Tiket Bus <br>
                    <span class="text-primary">Mudah & Aman</span>
                </h1>
                <p class="text-lg text-slate-600 mb-8">
                    Temukan berbagai rute, pilihan kursi terbaik, dan perjalanan nyaman untuk Anda.
                </p>

                <!-- Search Form Card -->
                <div class="bg-white p-6 rounded-2xl shadow-xl border border-slate-100 relative">
                    <!-- Tabs -->
                    <div class="flex gap-4 mb-6 border-b border-slate-100 pb-2">
                        <button class="text-primary font-semibold border-b-2 border-primary px-2 py-1 text-sm">Sekali Jalan</button>
                        <button class="text-slate-400 font-medium px-2 py-1 text-sm hover:text-slate-600">Pulang Pergi</button>
                    </div>

                    <form action="/search" method="GET" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Dari -->
                        <div class="flex flex-col">
                            <label class="text-xs text-slate-500 font-semibold mb-1">Dari</label>
                            <select name="origin" class="form-select border-0 border-b border-slate-200 focus:ring-0 focus:border-primary p-0 text-lg font-medium text-slate-800 pb-1">
                                <option value="1">Jakarta</option>
                                <option value="2">Bandung</option>
                                <option value="3">Surabaya</option>
                                <option value="4">Yogyakarta</option>
                            </select>
                            <div class="text-xs text-slate-400 mt-1">Pilih kota asal</div>
                        </div>

                        <!-- Switch Icon -->
                        <div class="absolute left-1/2 top-[55%] -translate-x-1/2 -translate-y-1/2 bg-white rounded-full p-2 shadow border border-slate-100 hidden sm:block z-10">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        </div>

                        <!-- Ke -->
                        <div class="flex flex-col">
                            <label class="text-xs text-slate-500 font-semibold mb-1">Ke</label>
                            <select name="destination" class="form-select border-0 border-b border-slate-200 focus:ring-0 focus:border-primary p-0 text-lg font-medium text-slate-800 pb-1">
                                <option value="3" selected>Surabaya</option>
                                <option value="1">Jakarta</option>
                                <option value="2">Bandung</option>
                                <option value="4">Yogyakarta</option>
                            </select>
                            <div class="text-xs text-slate-400 mt-1">Pilih kota tujuan</div>
                        </div>

                        <!-- Tanggal Berangkat -->
                        <div class="flex flex-col mt-4">
                            <label class="text-xs text-slate-500 font-semibold mb-1">Tanggal Berangkat</label>
                            <input type="date" name="date" class="form-input border-0 border-b border-slate-200 focus:ring-0 focus:border-primary p-0 text-lg font-medium text-slate-800 pb-1" value="{{ date('Y-m-d') }}">
                            <div class="text-xs text-slate-400 mt-1">{{ \Carbon\Carbon::now()->translatedFormat('l') }}</div>
                        </div>

                        <!-- Penumpang & Cari -->
                        <div class="flex flex-col sm:flex-row gap-4 mt-4 items-end">
                            <div class="flex flex-col w-full">
                                <label class="text-xs text-slate-500 font-semibold mb-1">Penumpang</label>
                                <select name="passengers" class="form-select border-0 border-b border-slate-200 focus:ring-0 focus:border-primary p-0 text-lg font-medium text-slate-800 pb-1">
                                    <option value="1">1 Penumpang</option>
                                    <option value="2">2 Penumpang</option>
                                    <option value="3">3 Penumpang</option>
                                    <option value="4">4 Penumpang</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full bg-primary hover:bg-primary-light text-white font-semibold py-3 px-6 rounded-lg transition shadow-md flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                Cari Tiket
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Image -->
            <div class="w-full md:w-1/2 absolute right-0 top-0 bottom-0 hidden md:block" style="z-index: 0; clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);">
                <!-- Fallback to a gradient if image not available -->
                <div class="w-full h-full bg-gradient-to-br from-blue-100 to-slate-200 object-cover object-left flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Bus Travel" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-2xl font-bold text-slate-800 mb-8">Kenapa pilih BusGo?</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Feature 1 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-start gap-4">
                <div class="bg-blue-50 p-3 rounded-xl text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-slate-800 text-sm mb-1">Harga Terbaik</h3>
                    <p class="text-xs text-slate-500">Kami memberikan harga terbaik untuk perjalanan Anda.</p>
                </div>
            </div>
            
            <!-- Feature 2 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-start gap-4">
                <div class="bg-blue-50 p-3 rounded-xl text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-slate-800 text-sm mb-1">Aman & Nyaman</h3>
                    <p class="text-xs text-slate-500">Perjalanan aman dengan fasilitas terbaik.</p>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-start gap-4">
                <div class="bg-blue-50 p-3 rounded-xl text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-slate-800 text-sm mb-1">Pembayaran Mudah</h3>
                    <p class="text-xs text-slate-500">Berbagai metode pembayaran yang aman.</p>
                </div>
            </div>

            <!-- Feature 4 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-start gap-4">
                <div class="bg-blue-50 p-3 rounded-xl text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-slate-800 text-sm mb-1">Tiket Digital</h3>
                    <p class="text-xs text-slate-500">Tiket digital dengan QR Code, praktis dan modern.</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
