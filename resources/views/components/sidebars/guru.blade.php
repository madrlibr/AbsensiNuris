@php
$linkAktif = 'flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-semibold text-white bg-white/20 transition-colors';
$linkBiasa = 'flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm text-blue-100 hover:text-white hover:bg-white/10 transition-colors';
$link = fn (...$pola) => request()->routeIs(...$pola) ? $linkAktif : $linkBiasa;
@endphp
<nav class="space-y-1 font-medium">
    <p class="px-3 pt-1 pb-2 text-[11px] font-bold tracking-widest text-blue-200/80">MENU UTAMA</p>

    <a href="{{ route('dashboard') }}" class="{{ $link('dashboard') }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        <span>Dashboard</span>
    </a>

    <p class="px-3 pt-4 pb-2 text-[11px] font-bold tracking-widest text-blue-200/80">PRESENSI KELAS</p>
    <a href="#" class="{{ $linkBiasa }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
        <span>Absensi Mapel</span>
    </a>

    @if(Auth::user()->bertugasSebagai('bk'))
        <p class="px-3 pt-4 pb-2 text-[11px] font-bold tracking-widest text-blue-200/80">BIMBINGAN KONSELING</p>
        <a href="{{ route('bk.laporan.index') }}" class="{{ $link('bk.*') }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>Laporan BK</span>
        </a>
    @endif

    @if(Auth::user()->role === 'wali_kelas')
        <p class="px-3 pt-4 pb-2 text-[11px] font-bold tracking-widest text-blue-200/80">WALI KELAS</p>
        <a href="#" class="{{ $linkBiasa }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span>Rekap Kelas Saya</span>
        </a>
        <a href="#" class="{{ $linkBiasa }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Persetujuan Surat Izin</span>
        </a>
    @endif

    @if(Auth::user()->role === 'piket')
        <p class="px-3 pt-4 pb-2 text-[11px] font-bold tracking-widest text-blue-200/80">GURU PIKET</p>
        <a href="#" class="{{ $linkBiasa }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Absensi Gerbang Manual</span>
        </a>
    @endif
</nav>
