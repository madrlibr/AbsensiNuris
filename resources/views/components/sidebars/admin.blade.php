<nav class="space-y-1 text-xs font-medium" x-data="{ openDash: true, openMaster: false, openAkademik: false, openReport: false }">
    
    <!-- DASHBOARDS GROUP -->
    <div>
        <button @click="openDash = !openDash" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-blue-600 bg-blue-50/80 font-semibold transition-all">
            <div class="flex items-center space-x-2.5">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span>Dashboards</span>
            </div>
            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="openDash ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
        
        <div x-show="openDash" class="pl-7 pr-2 py-1 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 px-3 py-1.5 rounded-lg text-blue-600 bg-blue-100/50 font-semibold border-l-2 border-blue-600">
                <span>Default Overview</span>
            </a>
            <a href="#" class="block px-3 py-1.5 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-50 transition-colors">
                Analytics Presensi
            </a>
        </div>
    </div>

    <!-- MASTER DATA GROUP -->
    <div class="pt-2">
        <button @click="openMaster = !openMaster" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-slate-600 hover:bg-slate-100/80 transition-all">
            <div class="flex items-center space-x-2.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span>Master Data</span>
            </div>
            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="openMaster ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
        
        <div x-show="openMaster" x-cloak class="pl-7 pr-2 py-1 space-y-1">
            <a href="#" class="block px-3 py-1.5 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-50">Jam Sekolah</a>
            <a href="#" class="block px-3 py-1.5 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-50">Data Jurusan</a>
            <a href="#" class="block px-3 py-1.5 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-50">Data Kelas</a>
            <a href="#" class="block px-3 py-1.5 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-50">Data Guru</a>
            <a href="#" class="block px-3 py-1.5 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-50">Data Siswa</a>
        </div>
    </div>

    <!-- AKADEMIK GROUP -->
    <div>
        <button @click="openAkademik = !openAkademik" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-slate-600 hover:bg-slate-100/80 transition-all">
            <div class="flex items-center space-x-2.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <span>Akademik</span>
            </div>
            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="openAkademik ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
        
        <div x-show="openAkademik" x-cloak class="pl-7 pr-2 py-1 space-y-1">
            <a href="#" class="block px-3 py-1.5 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-50">Mata Pelajaran</a>
            <a href="#" class="block px-3 py-1.5 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-50">Jadwal Pelajaran</a>
        </div>
    </div>

    <!-- LAPORAN & REKAP -->
    <div>
        <button @click="openReport = !openReport" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-slate-600 hover:bg-slate-100/80 transition-all">
            <div class="flex items-center space-x-2.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Laporan & Rekap</span>
            </div>
            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="openReport ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
        
        <div x-show="openReport" x-cloak class="pl-7 pr-2 py-1 space-y-1">
            <a href="#" class="block px-3 py-1.5 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-50">Rekap Harian</a>
            <a href="#" class="block px-3 py-1.5 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-50">Rekap Bulanan</a>
        </div>
    </div>
</nav>