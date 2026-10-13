<x-app-layout>
    <!-- Breadcrumb & Header -->
    <div class="mb-6">
        <nav class="flex items-center space-x-2 text-xs font-semibold text-slate-400 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            <span>/</span>
            <span class="text-slate-700">Pengaturan Jam Absensi</span>
        </nav>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Pengaturan Jam & Toleransi Gerbang</h1>
        <p class="text-xs text-slate-400 font-medium mt-0.5">Atur batasan jam masuk, jam pulang, serta toleransi keterlambatan siswa secara presisi.</p>
    </div>

    <!-- Alert Notifikasi Sukses -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
        </div>
    @endif

    <!-- Grid Form Pengaturan -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($pengaturan as $item)
            <div class="bg-white rounded-2xl border border-slate-200/70 shadow-2xs p-6">
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                    <div class="flex items-center space-x-2">
                        <span class="w-2.5 h-2.5 rounded-full {{ $item->is_aktif ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                        <h3 class="text-sm font-bold text-slate-800">Hari: {{ $item->hari }}</h3>
                    </div>
                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-full {{ $item->is_aktif ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                        {{ $item->is_aktif ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <form action="{{ route('admin.pengaturan-absensi.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Jam Masuk</label>
                                <input type="time" name="jam_masuk" value="{{ $item->jam_masuk }}" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-medium">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Toleransi (Menit)</label>
                                <input type="number" name="toleransi_keterlambatan" value="{{ $item->toleransi_keterlambatan }}" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-medium">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Jam Tutup Absen</label>
                                <input type="time" name="jam_tutup_absensi" value="{{ $item->jam_tutup_absensi }}" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-medium">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Jam Pulang</label>
                                <input type="time" name="jam_pulang" value="{{ $item->jam_pulang }}" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-medium">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Durasi Absen Pulang (Menit)</label>
                            <input type="number" name="durasi_absensi_pulang" value="{{ $item->durasi_absensi_pulang }}" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-medium">
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        @endforeach
    </div>
</x-app-layout>