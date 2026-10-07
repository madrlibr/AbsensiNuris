<nav class="p-4 space-y-1 text-sm">
    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-slate-800' }}">
        <span>Dashboard Orang Tua</span>
    </a>

    <div class="pt-4 pb-1 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Kehadiran Anak</div>
    <a href="#" class="flex items-center px-4 py-2 text-gray-300 hover:bg-slate-800 rounded-lg"><span>Riwayat Absensi</span></a>
    <a href="#" class="flex items-center px-4 py-2 text-gray-300 hover:bg-slate-800 rounded-lg"><span>Aju Surat Izin</span></a>
</nav>