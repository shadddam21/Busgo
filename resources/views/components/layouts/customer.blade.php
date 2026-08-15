<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Customer Panel - BusGo' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
    <!-- Top Navbar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 h-16">
        <div class="px-4 sm:px-6 lg:px-8 h-full flex justify-between items-center">
            <div class="flex items-center gap-2">
                <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M4 16c0 .88.39 1.67 1 2.22V20c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h8v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1.78c.61-.55 1-1.34 1-2.22V6c0-3.5-3.58-4-8-4s-8 .5-8 4v10zm3.5 1c-.83 0-1.5-.67-1.5-1.5S6.67 14 7.5 14s1.5.67 1.5 1.5S8.33 17 7.5 17zm9 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm1.5-6H6V6h12v5z"/></svg>
                <span class="text-xl font-bold text-primary">BusGo</span>
            </div>
            <div class="flex items-center gap-4">
                <button class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </button>
                <div class="flex items-center gap-2">
                    <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}" class="w-8 h-8 rounded-full bg-slate-200">
                    <div class="hidden md:block">
                        <div class="text-sm font-semibold">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-slate-500">Customer</div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex h-[calc(100vh-4rem)]">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-slate-200 flex-shrink-0 flex flex-col justify-between">
            <div class="p-4 space-y-1">
                <x-ui.sidebar-link href="/customer/dashboard" :active="request()->is('customer/dashboard')" icon="home">Beranda</x-ui.sidebar-link>
                <x-ui.sidebar-link href="/search" icon="search">Cari Tiket</x-ui.sidebar-link>
                <x-ui.sidebar-link href="/customer/orders" :active="request()->is('customer/orders*')" icon="ticket">Pesanan Saya</x-ui.sidebar-link>
                <x-ui.sidebar-link href="/customer/profile" :active="request()->is('customer/profile')" icon="user">Profil Saya</x-ui.sidebar-link>
                <x-ui.sidebar-link href="#" icon="help">Bantuan</x-ui.sidebar-link>
            </div>
            <div class="p-4 border-t border-slate-200">
                <form method="POST" action="/logout" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari akun Anda?');">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-3 py-2 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 bg-slate-50 overflow-y-auto p-6">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
