<x-layouts.customer title="Profil Saya - BusGo">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Profil Saya</h2>
        <p class="text-slate-600">Kelola informasi data diri Anda.</p>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm max-w-2xl">
        <div class="flex items-center gap-6 mb-8 pb-6 border-b border-slate-100">
            <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&size=128' }}" class="w-24 h-24 rounded-full border-4 border-slate-50 shadow-sm">
            <div>
                <h3 class="text-xl font-bold text-slate-800">{{ auth()->user()->name }}</h3>
                <div class="text-slate-500 mt-1">{{ auth()->user()->email }}</div>
                <div class="inline-block bg-primary-50 text-primary px-3 py-1 rounded-full text-xs font-bold mt-2">Member Aktif</div>
            </div>
        </div>

        <form>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" class="form-input rounded-xl w-full px-4 py-3 border-slate-200 text-slate-900 bg-slate-50" value="{{ auth()->user()->name }}" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" class="form-input rounded-xl w-full px-4 py-3 border-slate-200 text-slate-900 bg-slate-50" value="{{ auth()->user()->email }}" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor HP</label>
                    <input type="text" class="form-input rounded-xl w-full px-4 py-3 border-slate-200 text-slate-900 bg-slate-50" value="{{ auth()->user()->phone }}" readonly>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">NIK KTP</label>
                    <input type="text" class="form-input rounded-xl w-full px-4 py-3 border-slate-200 text-slate-900 bg-slate-50" value="{{ auth()->user()->nik }}" readonly>
                </div>
            </div>
        </form>
    </div>
</x-layouts.customer>
