# BusGo - Sistem Manajemen Tiket Bus

BusGo adalah sistem informasi berbasis web yang dirancang untuk mengelola operasional pemesanan tiket bus. Sistem ini mengintegrasikan alur reservasi oleh penumpang, verifikasi pembayaran oleh administrator, dan pencatatan manifest penumpang secara aktual di lapangan.

---

## Arsitektur Hak Akses

Sistem beroperasi menggunakan tiga tingkat hak akses utama:

### 1. Customer
- **Pencarian Jadwal**: Modul pencarian rute berbasis parameter kota asal dan tujuan.
- **Reservasi Kursi**: Antarmuka pemilihan tata letak kursi penumpang.
- **Transaksi**: Proses konfirmasi dan unggah bukti pembayaran.
- **E-Ticket**: Penerbitan tiket digital yang dilengkapi identifikasi QR Code.

### 2. Administrator
- **Dasbor Operasional**: Rekapitulasi metrik penjualan, pendapatan, dan status transaksi.
- **Validasi Transaksi**: Proses verifikasi persetujuan/penolakan pembayaran.
- **Manajemen Jadwal**: Entri dan modifikasi jadwal serta rute keberangkatan.
- **Penerbitan Manifest**: Pembuatan dokumen surat jalan berformat PDF untuk operasional bus.

### 3. Checker
- **Validasi Boarding**: Pemindaian QR Code tiket melalui perangkat penelusur web terintegrasi.
- **Manajemen Manifest**: Pemantauan logis data penumpang yang telah melakukan proses *check-in* pada jadwal spesifik.

---

## Spesifikasi Teknis

- **Framework Backend**: Laravel 11
- **Styling Frontend**: Tailwind CSS v4 & Blade Components
- **Database**: MySQL (Eloquent ORM)
- **Dependensi Tambahan**:
  - `barryvdh/laravel-dompdf`: Generator dokumen PDF.
  - `html5-qrcode`: Integrasi pemindai QR berbasis *client-side*.
  - `simplesoftwareio/simple-qrcode`: Generator QR Code tiket.

---

## Petunjuk Instalasi (Environment Lokal)

1. Kloning repositori:
   ```bash
   git clone https://github.com/shadddam21/Busgo.git
   cd Busgo
   ```

2. Instal dependensi ekosistem PHP dan Node.js:
   ```bash
   composer install
   npm install
   ```

3. Konfigurasi kredensial *environment*:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *(Catatan: Sesuaikan parameter `DB_*` di dalam file `.env` dengan konfigurasi server database lokal Anda).*

4. Eksekusi skema basis data dan pengisian data uji:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. Jalankan *development server* secara paralel:
   ```bash
   php artisan serve
   ```
   ```bash
   npm run dev
   ```

---

## Kredensial Pengujian (Seeder)

Proses migrasi telah menyertakan sekumpulan data *dummy* untuk keperluan pengujian sistem:

- **Akses Administrator**: `admin@busgo.com` | `password`
- **Akses Checker**: `checker@busgo.com` | `password`
- **Akses Customer**: `customer1@busgo.com` s/d `customer5@busgo.com` | `password`

---

## Alur Fungsional Utama

1. Login menggunakan akses **Customer** untuk menginisiasi pemesanan tiket hingga tahap pembayaran.
2. Beralih ke sesi **Administrator** untuk melakukan tindakan validasi pada pembayaran tersebut.
3. Gunakan sesi **Checker** pada menu *Scan* untuk menguji pemindaian QR Code dari E-Ticket yang telah tervalidasi.

