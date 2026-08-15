<x-layouts.public title="Login - BusGo">
    <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center bg-slate-50 py-12 px-4 sm:px-6 lg:px-8 relative">
        <!-- Background Decoration -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <svg class="absolute -top-24 -right-24 text-blue-50 w-96 h-96" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>
            <svg class="absolute -bottom-24 -left-24 text-orange-50 w-72 h-72" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>
        </div>

        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl border border-slate-100 z-10">
            <div>
                <h2 class="text-center text-3xl font-extrabold text-slate-900">
                    Masuk ke Akun Anda
                </h2>
                <p class="mt-2 text-center text-sm text-slate-600">
                    Atau
                    <a href="/register" class="font-medium text-primary hover:text-primary-light transition">
                        daftar akun baru sekarang
                    </a>
                </p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="mt-8 space-y-6" action="/login" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-slate-200 placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm bg-slate-50 focus:bg-white transition" placeholder="john@example.com" value="{{ old('email') }}">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-slate-200 placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm bg-slate-50 focus:bg-white transition" placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-slate-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-slate-700">
                            Ingat saya
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-primary hover:text-primary-light transition">
                            Lupa password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-primary hover:bg-primary-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition shadow-md shadow-primary/20">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-white/70 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        Masuk Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.public>
