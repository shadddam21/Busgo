<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel - BusGo' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased h-screen flex overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-[#1E3A5F] text-slate-300 flex-shrink-0 flex flex-col justify-between">
        <div>
            <div class="h-16 flex items-center px-6 border-b border-white/10 gap-2 text-white">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M4 16c0 .88.39 1.67 1 2.22V20c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h8v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1.78c.61-.55 1-1.34 1-2.22V6c0-3.5-3.58-4-8-4s-8 .5-8 4v10zm3.5 1c-.83 0-1.5-.67-1.5-1.5S6.67 14 7.5 14s1.5.67 1.5 1.5S8.33 17 7.5 17zm9 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-6H6V6h12v5z"/></svg>
                <span class="text-xl font-bold uppercase tracking-wider">BusGo Admin</span>
            </div>
            
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}" class="w-10 h-10 rounded-full bg-white/20">
                    <div>
                        <div class="text-xs text-white/60">Selamat datang,</div>
                        <div class="text-sm font-semibold text-white">{{ auth()->user()->name }}</div>
                    </div>
                </div>

                <div class="space-y-1">
                    <x-ui.admin-nav-link href="/admin/dashboard" :active="request()->is('admin/dashboard')" icon="home">Dashboard</x-ui.admin-nav-link>
                    <x-ui.admin-nav-link href="/admin/schedules" :active="request()->is('admin/schedules*')" icon="calendar">Jadwal & Rute</x-ui.admin-nav-link>
                    <x-ui.admin-nav-link href="/admin/orders" :active="request()->is('admin/orders*')" icon="ticket">Pemesanan</x-ui.admin-nav-link>
                    <x-ui.admin-nav-link href="/admin/payments" :active="request()->is('admin/payments*')" icon="credit-card" :badge="$pendingPayments ?? 0">Pembayaran</x-ui.admin-nav-link>
                    <x-ui.admin-nav-link href="/admin/driver-letters" :active="request()->is('admin/driver-letters*')" icon="document">Surat Jalan</x-ui.admin-nav-link>
                    <x-ui.admin-nav-link href="/admin/cities" :active="request()->is('admin/cities*') || request()->is('admin/routes*')" icon="database">Master Data</x-ui.admin-nav-link>
                    <x-ui.admin-nav-link href="/admin/reports" :active="request()->is('admin/reports*')" icon="chart-bar">Laporan</x-ui.admin-nav-link>
                    <x-ui.admin-nav-link href="/admin/users" :active="request()->is('admin/users*')" icon="users">Pengguna</x-ui.admin-nav-link>
                </div>
            </div>
        </div>
        <div class="p-4 border-t border-white/10">
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-3 py-2 text-sm font-medium text-white/70 rounded-lg hover:text-white hover:bg-white/5 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 z-10">
            <h1 class="text-xl font-semibold text-slate-800">{{ $header ?? 'Dashboard' }}</h1>
            <div class="flex items-center gap-4">
                <button class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </button>
            </div>
        </header>
        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6 bg-slate-50">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
