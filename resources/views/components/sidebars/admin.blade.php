@php
$linkAktif = 'flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-semibold text-white bg-white/20 transition-colors';
$linkBiasa = 'flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm text-blue-100 hover:text-white hover:bg-white/10 transition-colors';
$link = fn (...$pola) => request()->routeIs(...$pola) ? $linkAktif : $linkBiasa;

$btnAktif = 'w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm text-white bg-white/10 font-semibold transition-all';
$btnBiasa = 'w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm text-blue-100 hover:text-white hover:bg-white/10 transition-all';
$btn = fn ($aktif) => $aktif ? $btnAktif : $btnBiasa;

$dashAktif = request()->routeIs('dashboard');
$masterAktif = request()->routeIs('admin.pengaturan-absensi.*', 'admin.jurusan.*', 'admin.kelas.*', 'admin.pengguna.*', 'admin.guru.*', 'admin.siswa.*');
$akademikAktif = request()->routeIs('admin.mapel.*', 'admin.jadwal.*');
$pengaturanAktif = request()->routeIs('admin.pengaturan-absensi.*', 'admin.tahun-ajaran.*');
@endphp
<nav class="space-y-1 font-medium" x-data="{ openMaster: {{ $masterAktif ? 'true' : 'false' }}, openAkademik: {{ $akademikAktif ? 'true' : 'false' }}, openReport: false, openPengaturan: {{ $pengaturanAktif ? 'true' : 'false' }} }">

    <p class="px-3 pt-1 pb-2 text-[11px] font-bold tracking-widest text-blue-200/80">MENU UTAMA</p>

    <!-- Dashboard -->
    <a href="{{ route('dashboard') }}" class="{{ $link('dashboard') }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        <span>Dashboard</span>
    </a>

    <!-- Absensi Gerbang -->
    <a href="{{ route('piket.absensi.index') }}" class="{{ $link('piket.*') }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>Absensi Gerbang</span>
    </a>

    <!-- MASTER DATA GROUP -->
    <div class="pt-2">
        <button @click="openMaster = !openMaster" class="{{ $btn($masterAktif) }}">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span>Master Data</span>
            </div>
            <svg class="w-4 h-4 transition-transform duration-200" :class="openMaster ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>

        <div x-show="openMaster" x-cloak class="py-1 space-y-0.5">
            <a href="{{ route('admin.pengaturan-absensi.index') }}" class="{{ $link('admin.pengaturan-absensi.*') }}">
                <svg class="w-4 h-4 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Jam Sekolah</span>
            </a>
            <a href="{{ route('admin.jurusan.index') }}" class="{{ $link('admin.jurusan.*') }}">
                <svg class="w-4 h-4 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <span>Data Jurusan</span>
            </a>
            <a href="{{ route('admin.kelas.index') }}" class="{{ $link('admin.kelas.*') }}">
                <svg class="w-4 h-4 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Data Kelas</span>
            </a>
            <a href="{{ route('admin.pengguna.index') }}" class="{{ $link('admin.pengguna.*') }}">
                <svg class="w-4 h-4 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 13a6 6 0 00-12 0m12 0v-2a6 6 0 00-6-6m6 6H3"/></svg>
                <span>Data Pengguna</span>
            </a>
            <a href="{{ route('admin.guru.index') }}" class="{{ $link('admin.guru.*') }}">
                <svg class="w-4 h-4 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>Data Guru</span>
            </a>
            <a href="{{ route('admin.siswa.index') }}" class="{{ $link('admin.siswa.*') }}">
                <svg class="w-4 h-4 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                <span>Data Siswa</span>
            </a>
        </div>
    </div>

    <!-- AKADEMIK GROUP -->
    <div>
        <button @click="openAkademik = !openAkademik" class="{{ $btn($akademikAktif) }}">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <span>Akademik</span>
            </div>
            <svg class="w-4 h-4 transition-transform duration-200" :class="openAkademik ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>

        <div x-show="openAkademik" x-cloak class="py-1 space-y-0.5">
            <a href="{{ route('admin.mapel.index') }}" class="{{ $link('admin.mapel.*') }}">
                <svg class="w-4 h-4 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                <span>Mata Pelajaran</span>
            </a>
            <a href="{{ route('admin.jadwal.index') }}" class="{{ $link('admin.jadwal.*') }}">
                <svg class="w-4 h-4 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Jadwal Pelajaran</span>
            </a>
        </div>
    </div>

    <!-- LAPORAN & REKAP -->
    <div>
        <button @click="openReport = !openReport" class="{{ $btn(false) }}">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Laporan & Rekap</span>
            </div>
            <svg class="w-4 h-4 transition-transform duration-200" :class="openReport ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>

        <div x-show="openReport" x-cloak class="py-1 space-y-0.5">
            <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm text-blue-100 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-4 h-4 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span>Analytics Presensi</span>
            </a>
            <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm text-blue-100 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-4 h-4 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span>Rekap Harian</span>
            </a>
            <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm text-blue-100 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-4 h-4 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span>Rekap Bulanan</span>
            </a>
        </div>
    </div>

    <!-- PENGATURAN -->
    <div>
        <button @click="openPengaturan = !openPengaturan" class="{{ $btn($pengaturanAktif) }}">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Pengaturan</span>
            </div>
            <svg class="w-4 h-4 transition-transform duration-200" :class="openPengaturan ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>

        <div x-show="openPengaturan" x-cloak class="py-1 space-y-0.5">
            <a href="{{ route('admin.pengaturan-absensi.index') }}" class="{{ $link('admin.pengaturan-absensi.*') }}">
                <svg class="w-4 h-4 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Pengaturan Absensi</span>
            </a>
            <a href="{{ route('admin.tahun-ajaran.index') }}" class="{{ $link('admin.tahun-ajaran.*') }}">
                <svg class="w-4 h-4 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Tahun Ajaran</span>
            </a>
        </div>
    </div>
</nav>
