<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Ticket BusGo - {{ $order->order_code }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.6; }
        .ticket-box { border: 2px dashed #ccc; border-radius: 10px; padding: 20px; max-width: 600px; margin: 0 auto; position: relative; }
        .header { text-align: center; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { color: #1E3A8A; margin: 0; font-size: 28px; }
        .row { width: 100%; display: table; }
        .col { display: table-cell; vertical-align: top; width: 50%; }
        .label { font-size: 12px; color: #777; margin-bottom: 2px; }
        .value { font-size: 16px; font-weight: bold; margin-bottom: 15px; }
        .seat { font-size: 24px; font-weight: bold; color: #ea580c; }
        .qr-box { text-align: center; border-left: 1px solid #eee; padding-left: 20px; }
        .footer { text-align: center; font-size: 11px; color: #999; margin-top: 30px; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="ticket-box">
        <div class="header">
            <h1>BusGo E-Ticket</h1>
            <div>Booking ID: <strong>{{ $order->order_code }}</strong></div>
        </div>
        
        <div class="row">
            <div class="col" style="width: 65%;">
                <div class="label">Nama Penumpang</div>
                <div class="value">{{ $order->user->name }} ({{ $order->user->nik }})</div>

                <div class="label">Rute Perjalanan</div>
                <div class="value">{{ $order->schedule->route->origin->name }} &rarr; {{ $order->schedule->route->destination->name }}</div>

                <div class="row">
                    <div class="col">
                        <div class="label">Keberangkatan</div>
                        <div class="value">
                            {{ \Carbon\Carbon::parse($order->schedule->departure_date)->format('d M Y') }}<br>
                            {{ substr($order->schedule->departure_time, 0, 5) }} WIB
                        </div>
                    </div>
                    <div class="col">
                        <div class="label">Nomor Kursi</div>
                        <div class="seat">{{ $order->seat->seat_number }}</div>
                    </div>
                </div>
            </div>
            
            <div class="col qr-box" style="width: 35%;">
                <div class="label" style="margin-bottom: 10px;">Scan saat boarding:</div>
                <!-- Base64 encode the QR Code so dompdf can render it -->
                <img src="data:image/svg+xml;base64,{{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::size(150)->generate($order->qr_token)) }}" alt="QR Code">
            </div>
        </div>
        
        <div class="footer">
            Tiket ini adalah dokumen resmi. Harap tiba di terminal 30 menit sebelum jadwal keberangkatan.<br>
            Tunjukkan tiket ini beserta kartu identitas (KTP) kepada petugas saat boarding.
        </div>
    </div>
</body>
</html>
