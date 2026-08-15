<x-layouts.public title="Register - BusGo">
    <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center bg-slate-50 py-12 px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-xl w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl border border-slate-100 z-10">
            <div>
                <h2 class="text-center text-3xl font-extrabold text-slate-900">
                    Daftar Akun Baru
                </h2>
                <p class="mt-2 text-center text-sm text-slate-600">
                    Sudah punya akun?
                    <a href="/login" class="font-medium text-primary hover:text-primary-light transition">
                        Masuk di sini
                    </a>
                </p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mt-8 space-y-6" action="/register" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap (Sesuai KTP)</label>
                        <input name="name" type="text" required class="form-input rounded-xl w-full px-4 py-3 border-slate-200 text-slate-900 focus:border-primary focus:ring-primary bg-slate-50 focus:bg-white transition" value="{{ old('name') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                        <input name="email" type="email" required class="form-input rounded-xl w-full px-4 py-3 border-slate-200 text-slate-900 focus:border-primary focus:ring-primary bg-slate-50 focus:bg-white transition" value="{{ old('email') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nomor HP / WhatsApp</label>
                        <input name="phone" type="text" required class="form-input rounded-xl w-full px-4 py-3 border-slate-200 text-slate-900 focus:border-primary focus:ring-primary bg-slate-50 focus:bg-white transition" value="{{ old('phone') }}">
                    </div>
                    
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">NIK KTP (16 Digit)</label>
                        <input name="nik" type="text" required class="form-input rounded-xl w-full px-4 py-3 border-slate-200 text-slate-900 focus:border-primary focus:ring-primary bg-slate-50 focus:bg-white transition" value="{{ old('nik') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                        <input name="password" type="password" required class="form-input rounded-xl w-full px-4 py-3 border-slate-200 text-slate-900 focus:border-primary focus:ring-primary bg-slate-50 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                        <input name="password_confirmation" type="password" required class="form-input rounded-xl w-full px-4 py-3 border-slate-200 text-slate-900 focus:border-primary focus:ring-primary bg-slate-50 focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-primary hover:bg-primary-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition shadow-md shadow-primary/20">
                        Daftar Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.public>
