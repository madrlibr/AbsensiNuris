<x-app-layout>
    <!-- Breadcrumb & Header -->
    <div class="mb-6">
        <nav class="flex items-center space-x-2 text-xs font-semibold text-slate-400 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            <span>/</span>
            <span class="text-slate-700">Absensi Gerbang</span>
        </nav>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Absensi Gerbang Harian</h1>
        <p class="text-xs text-slate-400 font-medium mt-0.5">Scan QR / kartu RFID / sidik jari, atau input manual. {{ $hariIni }}</p>
    </div>

    @unless($tahunAktif)
        <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-700 text-xs font-bold">Belum ada tahun ajaran aktif. Minta admin mengaktifkannya terlebih dahulu.</div>
    @endunless

    <!-- Statistik Hari Ini -->
    <div class="grid grid-cols-3 md:grid-cols-6 gap-3 mb-6">
        <div class="bg-white rounded-2xl border border-slate-200/70 p-4"><p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Terdaftar</p><p id="stat-total-siswa" class="text-xl font-bold text-slate-800">{{ $statistik['total_siswa'] }}</p></div>
        <div class="bg-white rounded-2xl border border-slate-200/70 p-4"><p class="text-[11px] font-bold text-emerald-500 uppercase tracking-wider">Hadir</p><p id="stat-hadir" class="text-xl font-bold text-emerald-600">{{ $statistik['hadir'] }}</p></div>
        <div class="bg-white rounded-2xl border border-slate-200/70 p-4"><p class="text-[11px] font-bold text-amber-500 uppercase tracking-wider">Terlambat</p><p id="stat-terlambat" class="text-xl font-bold text-amber-600">{{ $statistik['terlambat'] }}</p></div>
        <div class="bg-white rounded-2xl border border-slate-200/70 p-4"><p class="text-[11px] font-bold text-sky-500 uppercase tracking-wider">Izin</p><p id="stat-izin" class="text-xl font-bold text-sky-600">{{ $statistik['izin'] }}</p></div>
        <div class="bg-white rounded-2xl border border-slate-200/70 p-4"><p class="text-[11px] font-bold text-violet-500 uppercase tracking-wider">Sakit</p><p id="stat-sakit" class="text-xl font-bold text-violet-600">{{ $statistik['sakit'] }}</p></div>
        <div class="bg-white rounded-2xl border border-slate-200/70 p-4"><p class="text-[11px] font-bold text-rose-500 uppercase tracking-wider">Alpa</p><p id="stat-alpa" class="text-xl font-bold text-rose-600">{{ $statistik['alpa'] }}</p></div>
    </div>

    <!-- Alert Error -->
    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold flex items-center justify-between">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">&times;</button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Kartu Scan Kamera -->
        <div class="bg-white rounded-2xl border border-slate-200/70 shadow-2xs p-6" id="qr-scanner" data-endpoint="{{ route('piket.absensi.scan') }}">
            <h2 class="text-sm font-bold text-slate-800 mb-1">Scan QR Kamera</h2>
            <p id="qr-status" class="text-xs text-slate-400 font-medium mb-4">Menyiapkan kamera…</p>

            <div id="qr-reader" class="overflow-hidden rounded-xl border border-slate-200 bg-slate-900 aspect-[4/3]"></div>

            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                <select id="qr-kamera" class="px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                    <option value="">Memuat daftar kamera…</option>
                </select>
                <div class="flex gap-2">
                    <button type="button" id="qr-mulai" class="hidden flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition-colors">Nyalakan</button>
                    <button type="button" id="qr-stop" class="hidden flex-1 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors">Matikan</button>
                </div>
            </div>

            <!-- Ketik manual (cadangan bila kamera bermasalah) -->
            <details class="mt-4">
                <summary class="text-xs font-bold text-slate-500 cursor-pointer hover:text-slate-700">Ketik kode manual / RFID / NISN</summary>
                <form action="{{ route('piket.absensi.scan') }}" method="POST" class="mt-3 space-y-3">
                    @csrf
                    <input type="hidden" name="metode" value="qr">
                    <input type="text" name="kode" required autocomplete="off" placeholder="QR / UID Kartu / NISN" class="w-full px-4 py-2.5 text-sm font-mono border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <button type="submit" class="w-full px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition-colors">Catat Kehadiran</button>
                </form>
            </details>
        </div>

        <!-- Kartu Hasil -->
        <div class="bg-white rounded-2xl border border-slate-200/70 shadow-2xs p-6">
            <h2 class="text-sm font-bold text-slate-800 mb-4">Hasil Terakhir</h2>
            <div id="hasil-scan">
            @if(session('hasil'))
                @php($h = session('hasil'))
                <div class="rounded-2xl border p-5 text-center {{ $h['status'] === 'alpa' ? 'bg-rose-50 border-rose-200' : 'bg-emerald-50 border-emerald-200' }}">
                    <p class="text-lg font-bold text-slate-800">{{ $h['nama'] }}</p>
                    <p class="text-xs font-medium text-slate-500">{{ $h['nisn'] }} · {{ $h['kelas'] }}</p>
                    <p class="mt-3 inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold capitalize {{ $h['status'] === 'hadir' ? 'bg-emerald-500 text-white' : ($h['status'] === 'terlambat' ? 'bg-amber-500 text-white' : 'bg-slate-500 text-white') }}">
                        {{ $h['status'] }}
                    </p>
                    <p class="mt-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Absen {{ $h['tipe'] }} · {{ $h['jam'] }}</p>
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-slate-200 p-8 text-center text-xs text-slate-400 font-medium">Arahkan QR siswa ke kamera. Hasil akan tampil di sini.</div>
            @endif
            </div>

            <!-- Input Manual -->
            <div class="mt-4" x-data="{ openManual: false }">
                <button @click="openManual = true" class="w-full px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors">Input Manual (lupa kartu)</button>

                <div x-show="openManual" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs px-4" x-cloak>
                    <div @click.outside="openManual = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-base font-bold text-slate-800">Input Manual</h3>
                            <button @click="openManual = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                        </div>
                        <form action="{{ route('piket.absensi.manual') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Siswa</label>
                                    <select name="siswa_id" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                        @foreach($daftarSiswa as $s)
                                            <option value="{{ $s->id }}">{{ $s->nama_lengkap }} ({{ $s->nisn }}) — {{ $s->anggotaKelas->first()?->kelas?->nama_kelas ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Jenis</label>
                                    <select name="tipe" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                        <option value="masuk">Masuk</option>
                                        <option value="pulang">Pulang</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Keterangan <span class="font-medium text-slate-400">(opsional)</span></label>
                                    <input type="text" name="keterangan" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" @click="openManual = false" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                                <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition-colors">Catat</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
