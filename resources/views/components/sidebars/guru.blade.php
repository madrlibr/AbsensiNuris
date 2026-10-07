<nav class="p-4 space-y-1 text-sm">
    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-slate-800' }}">
        <span>Dashboard Guru</span>
    </a>

    <div class="pt-4 pb-1 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Presensi Kelas</div>
    <a href="#" class="flex items-center px-4 py-2 text-gray-300 hover:bg-slate-800 rounded-lg"><span>Absensi Mapel</span></a>

    @if(Auth::user()->role === 'wali_kelas')
        <div class="pt-4 pb-1 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Wali Kelas</div>
        <a href="#" class="flex items-center px-4 py-2 text-gray-300 hover:bg-slate-800 rounded-lg"><span>Rekap Kelas Saya</span></a>
        <a href="#" class="flex items-center px-4 py-2 text-gray-300 hover:bg-slate-800 rounded-lg"><span>Persetujuan Surat Izin</span></a>
    @endif

    @if(Auth::user()->role === 'piket')
        <div class="pt-4 pb-1 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Guru Piket</div>
        <a href="#" class="flex items-center px-4 py-2 text-gray-300 hover:bg-slate-800 rounded-lg"><span>Absensi Gerbang Manual</span></a>
    @endif
</nav>