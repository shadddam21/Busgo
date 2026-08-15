<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Jalan BusGo - {{ \Carbon\Carbon::parse($schedule->departure_date)->format('Ymd') }}-{{ $schedule->id }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.6; font-size: 14px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 2px; }
        .header p { margin: 5px 0 0; color: #555; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; }
        .info-table td strong { display: inline-block; width: 120px; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .data-table th, .data-table td { border: 1px solid #999; padding: 8px; text-align: left; }
        .data-table th { background-color: #f0f0f0; }
        .footer { width: 100%; display: table; margin-top: 50px; }
        .signature { display: table-cell; width: 50%; text-align: center; }
        .signature-line { margin-top: 60px; border-bottom: 1px solid #333; width: 200px; display: inline-block; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SURAT JALAN / MANIFEST PENUMPANG</h1>
        <p>PT BUSGO INDONESIA TRANSCORP</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="50%"><strong>Rute</strong>: {{ $schedule->route->origin->name }} - {{ $schedule->route->destination->name }}</td>
            <td width="50%"><strong>No. Polisi</strong>: B {{ rand(1000, 9999) }} TX</td>
        </tr>
        <tr>
            <td><strong>Tanggal</strong>: {{ \Carbon\Carbon::parse($schedule->departure_date)->translatedFormat('d F Y') }}</td>
            <td><strong>Nama Supir</strong>: ______________________</td>
        </tr>
        <tr>
            <td><strong>Jam Keberangkatan</strong>: {{ substr($schedule->departure_time, 0, 5) }} WIB</td>
            <td><strong>Total Penumpang</strong>: {{ $orders->count() }} Orang</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">No. Kursi</th>
                <th width="35%">Nama Penumpang</th>
                <th width="25%">Booking ID</th>
                <th width="20%">Status Hadir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $index => $order)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $order->seat->seat_number }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->order_code }}</td>
                    <td>[ &nbsp;&nbsp;&nbsp;&nbsp; ]</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada penumpang untuk jadwal ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Admin / Petugas Berangkat,</p>
            <div class="signature-line"></div>
            <p>{{ auth()->user()->name }}</p>
        </div>
        <div class="signature">
            <p>Supir,</p>
            <div class="signature-line"></div>
            <p>( Nama Terang )</p>
        </div>
    </div>
</body>
</html>
