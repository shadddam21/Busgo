# BusGo - Sistem Pemesanan Tiket Bus Modern

BusGo adalah platform pemesanan tiket bus berbasis web yang dikembangkan khusus untuk memudahkan proses reservasi kursi, pembayaran, dan manajemen manifest penumpang. Sistem ini dirancang untuk menangani seluruh alur kerja operasional tiket bus mulai dari pelanggan memesan tiket secara mandiri, verifikasi oleh admin, hingga proses *check-in* (scan tiket) oleh petugas lapangan.

---

## Fitur Utama (Berdasarkan Kebutuhan Sistem)

Aplikasi ini memiliki **3 Role / Hak Akses** yang saling terintegrasi:

### 1. Customer (Pelanggan)
- **Pencarian Tiket**: Mencari jadwal bus berdasarkan kota asal dan tujuan.
- **Booking Kursi Interaktif**: Memilih kursi (Seat Layout) secara *real-time*.
- **Upload Bukti Pembayaran**: Melakukan checkout dan mengunggah foto bukti transfer.
- **E-Ticket & QR Code**: Mendapatkan tiket digital (*E-Ticket*) yang dilengkapi dengan **QR Code** untuk kemudahan validasi saat akan naik bus.

### 2. Admin (Pengelola)
- **Dashboard Ringkasan**: Melihat statistik harian, total pendapatan, dan tiket yang menunggu validasi.
- **Verifikasi Pembayaran**: Menerima/Menolak bukti transfer dari pelanggan.
- **Cetak Surat Jalan (Manifest PDF)**: Mengunduh Surat Jalan / Manifest Penumpang berformat PDF untuk diserahkan kepada Supir sebelum bus berangkat.
- **Laporan Pemesanan**: Melihat riwayat lengkap pesanan tiket yang sudah berhasil dibayar.

### 3. Checker (Petugas Terminal)
- **Scan QR Code**: Memindai tiket pelanggan langsung menggunakan kamera *Smartphone* atau Laptop (tanpa aplikasi tambahan, *pure* berbasis web).
- **Update Status Penumpang**: Mengubah status penumpang menjadi "Hadir" secara otomatis setelah tiket berhasil dipindai.
- **Manifest Kehadiran**: Mengecek daftar penumpang yang sudah *boarding*.

---

## Tech Stack
- **Framework**: Laravel 11 (Monolith)
- **Styling**: Tailwind CSS v4 & Blade Components
- **Database**: MySQL (via Eloquent ORM)
- **Libraries**:
  - `barryvdh/laravel-dompdf` (Cetak PDF Surat Jalan & E-Ticket)
  - `html5-qrcode` (Pemindai QR Kamera di sisi Client/Checker)
  - `simplesoftwareio/simple-qrcode` (Pembuat QR Code Tiket)

---

## Panduan Instalasi (Lokal)

Jika Anda ingin menjalankan proyek ini secara lokal, ikuti langkah-langkah berikut:

1. **Clone repositori ini:**
   ```bash
   git clone https://github.com/shadddam21/Busgo.git
   cd Busgo
   ```

2. **Install Dependensi (PHP & Node):**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment:**
   Salin `.env.example` menjadi `.env` lalu sesuaikan konfigurasi database Anda.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi & Dummy Data (Penting):**
   Jalankan perintah ini untuk membuat struktur tabel dan mengisi data awal (Jadwal, Rute, Kursi, dan Akun Default).
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Jalankan Server:**
   Jalankan server PHP dan Vite (untuk Tailwind) di dua terminal yang berbeda.
   ```bash
   php artisan serve
   ```
   ```bash
   npm run dev
   ```

---

## 🔐 Kredensial Akun Default (Testing)

Gunakan akun-akun berikut untuk menguji coba masing-masing role:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@busgo.com` | `password` |
| **Checker** | `checker@busgo.com` | `password` |
| **Customer** | `customer1@busgo.com` | `password` |

*(Tersedia customer1@busgo.com hingga customer5@busgo.com untuk simulasi berbagai pelanggan)*

---

## 📸 Panduan Simulasi Alur Kerja (End-to-End)

1. Login sebagai **Customer**, lalu coba lakukan pencarian tiket dari beranda.
2. Pilih jadwal, lalu pilih kursi yang masih kosong (berwarna putih).
3. Selesaikan form *checkout* dengan mengunggah foto apa saja sebagai "Bukti Transfer".
4. Logout, lalu login sebagai **Admin**. Masuk ke menu "Pembayaran" dan klik tombol "Verifikasi" pada transaksi yang baru saja dibuat.
5. Sebagai Admin, masuk ke menu "Surat Jalan" lalu klik "Cetak PDF" untuk melihat bentuk fisik manifest penumpang.
6. Logout, lalu masuk ke akun **Customer** kembali. Buka menu "Pesanan Saya", lalu klik "Lihat Tiket". (E-Ticket lengkap dengan QR Code akan muncul).
7. Di *device* lain (atau di *tab* baru), login sebagai **Checker**. Buka menu "Scan Sekarang".
8. Arahkan kamera ke arah QR Code milik tiket Customer tadi. Data akan langsung terverifikasi secara otomatis!

