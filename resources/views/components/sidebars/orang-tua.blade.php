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

    <p class="px-3 pt-4 pb-2 text-[11px] font-bold tracking-widest text-blue-200/80">KEHADIRAN ANAK</p>
    <a href="#" class="{{ $linkBiasa }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <span>Riwayat Absensi</span>
    </a>
    <a href="#" class="{{ $linkBiasa }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        <span>Ajukan Surat Izin</span>
    </a>
</nav>
