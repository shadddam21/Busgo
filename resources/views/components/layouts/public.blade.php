<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'BusGo - Pesan Tiket Bus Mudah & Aman' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen">
    
    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-2">
                        <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M4 16c0 .88.39 1.67 1 2.22V20c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h8v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1.78c.61-.55 1-1.34 1-2.22V6c0-3.5-3.58-4-8-4s-8 .5-8 4v10zm3.5 1c-.83 0-1.5-.67-1.5-1.5S6.67 14 7.5 14s1.5.67 1.5 1.5S8.33 17 7.5 17zm9 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-6H6V6h12v5z"/></svg>
                        <span class="text-2xl font-bold text-primary">BusGo</span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-sm font-semibold text-primary">Beranda</a>
                    <a href="/search" class="text-sm text-slate-500 hover:text-primary transition">Cari Tiket</a>
                    <a href="/customer/orders" class="text-sm text-slate-500 hover:text-primary transition">Pesanan Saya</a>
                    <a href="#" class="text-sm text-slate-500 hover:text-primary transition">Bantuan</a>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="/customer/dashboard" class="px-4 py-2 text-sm font-semibold text-primary border border-primary rounded-lg hover:bg-primary-50 transition">Dashboard</a>
                    @else
                        <a href="/login" class="px-4 py-2 text-sm font-semibold text-primary border border-primary rounded-lg hover:bg-primary-50 transition">Masuk</a>
                        <a href="/register" class="px-4 py-2 text-sm font-semibold text-white bg-primary rounded-lg hover:bg-primary-light transition shadow-sm">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-slate-500 text-sm">
            &copy; {{ date('Y') }} BusGo. All rights reserved. <br>
            Sistem Pemesanan Tiket Bus Mudah & Aman.
        </div>
    </footer>
</body>
</html>
