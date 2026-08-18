<x-layouts.public title="Reset Password - BusGo">
    <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center bg-slate-50 py-12 px-4 sm:px-6 lg:px-8 relative">
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <svg class="absolute -top-24 -right-24 text-blue-50 w-96 h-96" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>
            <svg class="absolute -bottom-24 -left-24 text-orange-50 w-72 h-72" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>
        </div>

        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl border border-slate-100 z-10">
            <div>
                <h2 class="text-center text-3xl font-extrabold text-slate-900">
                    Buat Password Baru
                </h2>
                <p class="mt-2 text-center text-sm text-slate-600">
                    Masukkan password baru Anda di bawah ini.
                </p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('password.update') }}" method="POST">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-slate-200 placeholder-slate-400 text-black focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm bg-slate-50 focus:bg-white transition" value="{{ old('email', $request->email) }}" readonly>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
                        <input id="password" name="password" type="password" required class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-slate-200 placeholder-slate-400 text-black focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm bg-slate-50 focus:bg-white transition" placeholder="••••••••">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password Baru</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-slate-200 placeholder-slate-400 text-black focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm bg-slate-50 focus:bg-white transition" placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-primary hover:bg-primary-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition shadow-md shadow-primary/20">
                        Simpan Password Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.public>
