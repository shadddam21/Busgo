<x-layouts.checker title="Scan Tiket - BusGo">
    <div class="mb-6 mt-4">
        <h2 class="text-2xl font-bold text-white mb-2">Scan E-Ticket</h2>
        <p class="text-white/60 text-sm">Arahkan kamera ke QR Code pada E-Ticket penumpang untuk check-in.</p>
    </div>

    <!-- Scanner Container -->
    <div class="bg-[#1C1C1E] rounded-3xl p-4 shadow-xl border border-white/5 mb-6 relative overflow-hidden">
        <div id="reader" class="w-full rounded-2xl overflow-hidden bg-black aspect-[3/4]"></div>
        
        <!-- Scanner Overlay Decoration -->
        <div class="absolute inset-0 pointer-events-none flex items-center justify-center">
            <div class="w-48 h-48 border-2 border-primary/50 rounded-xl relative">
                <div class="absolute top-0 left-0 w-4 h-4 border-t-4 border-l-4 border-primary rounded-tl-xl"></div>
                <div class="absolute top-0 right-0 w-4 h-4 border-t-4 border-r-4 border-primary rounded-tr-xl"></div>
                <div class="absolute bottom-0 left-0 w-4 h-4 border-b-4 border-l-4 border-primary rounded-bl-xl"></div>
                <div class="absolute bottom-0 right-0 w-4 h-4 border-b-4 border-r-4 border-primary rounded-br-xl"></div>
            </div>
        </div>
    </div>

    <!-- Manual Input Form -->
    <div class="bg-[#1C1C1E] rounded-3xl p-5 shadow-xl border border-white/5 mb-6">
        <h3 class="text-white font-semibold mb-3">Input Manual (Jika Scanner Gagal)</h3>
        <div class="flex gap-2">
            <input type="text" id="manualBookingId" placeholder="Masukkan Kode Booking (Cth: ORD-ABC123)" class="flex-1 bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-primary placeholder-white/30 uppercase">
            <button onclick="processManual()" class="bg-primary hover:bg-primary-light text-white px-6 py-3 rounded-xl font-semibold transition">
                Cek
            </button>
        </div>
    </div>

    <!-- Status Message -->
    <div id="scanResult" class="hidden rounded-2xl p-4 mb-24 transition-all">
        <div class="flex items-center gap-3 mb-2">
            <div id="statusIcon" class="w-8 h-8 rounded-full flex items-center justify-center"></div>
            <h3 id="statusTitle" class="font-bold text-lg"></h3>
        </div>
        <p id="statusMessage" class="text-sm opacity-90 mb-3"></p>
        <div id="passengerInfo" class="hidden bg-black/20 p-3 rounded-xl text-sm">
            <div class="flex justify-between mb-1"><span class="opacity-60">Nama:</span> <span id="pName" class="font-bold"></span></div>
            <div class="flex justify-between mb-1"><span class="opacity-60">Kursi:</span> <span id="pSeat" class="font-bold text-primary"></span></div>
            <div class="flex justify-between"><span class="opacity-60">Rute:</span> <span id="pRoute" class="font-medium"></span></div>
        </div>
        
        <button id="btnRescan" class="w-full mt-4 bg-white/10 hover:bg-white/20 text-white py-3 rounded-xl text-sm font-semibold transition hidden" onclick="resetScanner()">Scan Tiket Lain</button>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        let html5QrcodeScanner;
        let isScanning = true;

        document.addEventListener('DOMContentLoaded', function() {
            startScanner();
        });

        function startScanner() {
            if (!html5QrcodeScanner) {
                html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader", { fps: 10, qrbox: 250, aspectRatio: 3/4 }, false
                );
            }
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        }

        function onScanSuccess(decodedText, decodedResult) {
            if (!isScanning) return;
            isScanning = false;
            
            // Tampilkan loading state
            html5QrcodeScanner.pause();
            
            // Kirim ke backend
            fetch('/checker/scan/process', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ qr_token: decodedText })
            })
            .then(response => response.json())
            .then(data => {
                showResult(data);
            })
            .catch(error => {
                console.error('Error:', error);
                showResult({ success: false, message: 'Terjadi kesalahan jaringan.' });
            });
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning
        }

        function processManual() {
            const input = document.getElementById('manualBookingId');
            const bookingId = input.value.trim().toUpperCase();
            if (!bookingId) {
                alert('Silakan masukkan Kode Booking');
                return;
            }
            
            if (!isScanning) return;
            isScanning = false;
            if (html5QrcodeScanner) html5QrcodeScanner.pause();

            // Kirim ke backend menggunakan order_code
            fetch('/checker/scan/process', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order_code: bookingId })
            })
            .then(response => response.json())
            .then(data => {
                showResult(data);
                input.value = '';
            })
            .catch(error => {
                console.error('Error:', error);
                showResult({ success: false, message: 'Terjadi kesalahan jaringan.' });
            });
        }

        function showResult(data) {
            const resultDiv = document.getElementById('scanResult');
            const iconDiv = document.getElementById('statusIcon');
            const titleEl = document.getElementById('statusTitle');
            const msgEl = document.getElementById('statusMessage');
            const passInfo = document.getElementById('passengerInfo');
            const btnRescan = document.getElementById('btnRescan');

            resultDiv.classList.remove('hidden', 'bg-green-500/20', 'bg-red-500/20', 'text-green-500', 'text-red-500');
            iconDiv.innerHTML = '';
            
            if (data.success) {
                resultDiv.classList.add('bg-green-500/20', 'text-green-50');
                iconDiv.className = 'w-8 h-8 rounded-full flex items-center justify-center bg-green-500 text-white';
                iconDiv.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>';
                titleEl.innerText = 'Check-in Berhasil';
                
                document.getElementById('pName').innerText = data.data.passenger_name;
                document.getElementById('pSeat').innerText = data.data.seat_number;
                document.getElementById('pRoute').innerText = data.data.route;
                passInfo.classList.remove('hidden');
            } else {
                resultDiv.classList.add('bg-red-500/20', 'text-red-50');
                iconDiv.className = 'w-8 h-8 rounded-full flex items-center justify-center bg-red-500 text-white';
                iconDiv.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>';
                titleEl.innerText = 'Scan Gagal';
                passInfo.classList.add('hidden');
            }

            msgEl.innerText = data.message;
            resultDiv.classList.remove('hidden');
            btnRescan.classList.remove('hidden');
        }

        function resetScanner() {
            document.getElementById('scanResult').classList.add('hidden');
            isScanning = true;
            html5QrcodeScanner.resume();
        }
    </script>
</x-layouts.checker>
