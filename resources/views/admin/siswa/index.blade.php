<x-app-layout>
    <!-- Breadcrumb & Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="flex items-center space-x-2 text-xs font-semibold text-slate-400 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
                <span>/</span>
                <span class="text-slate-700">Data Siswa</span>
            </nav>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Manajemen Siswa</h1>
            <p class="text-xs text-slate-400 font-medium mt-0.5">Kelola data siswa beserta penempatan kelas per tahun ajaran.</p>
        </div>

        <div class="flex items-center gap-3">
            <form action="{{ route('admin.siswa.index') }}" method="GET">
                <select name="tahun_ajaran_id" onchange="this.form.submit()" class="px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white font-bold text-slate-600">
                    @foreach($tahunAjaran as $ta)
                        <option value="{{ $ta->id }}" @selected($tahunAjaranId == $ta->id)>{{ $ta->tahun }} - Smt {{ $ta->semester }}</option>
                    @endforeach
                </select>
            </form>
            <div x-data="{ openModal: false }">
                <button @click="openModal = true" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-blue-500/20 transition-all">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Tambah Siswa
                </button>

                <!-- Modal Form Tambah -->
                <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs px-4" x-cloak>
                    <div @click.outside="openModal = false" class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-base font-bold text-slate-800">Tambah Siswa Baru</h3>
                            <button @click="openModal = false" class="text-slate-400 hover:text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <form action="{{ route('admin.siswa.store') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1">NISN</label>
                                        <input type="text" name="nisn" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">No. HP Orang Tua</label>
                                    <input type="text" name="no_hp_ortu" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                </div>
                                <div class="grid grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1">QR Code <span class="font-medium text-slate-400">(default: NISN)</span></label>
                                        <input type="text" name="qr_code" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Kartu (RFID)</label>
                                        <input type="text" name="card_number" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Sidik Jari</label>
                                        <input type="text" name="fingerprint_id" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Tahun Ajaran</label>
                                        <select name="tahun_ajaran_id" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                            @foreach($tahunAjaran as $ta)
                                                <option value="{{ $ta->id }}" @selected($tahunAjaranId == $ta->id)>{{ $ta->tahun }} - Smt {{ $ta->semester }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Kelas</label>
                                        <select name="kelas_id" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                            @foreach($kelas as $k)
                                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" @click="openModal = false" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                                <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition-colors">Simpan Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
        </div>
    @endif

    <!-- Tabel Data Siswa -->
    <div class="bg-white rounded-2xl border border-slate-200/70 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-200/70 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-3.5">No</th>
                        <th class="px-6 py-3.5">NISN / Nama</th>
                        <th class="px-6 py-3.5 text-center">L/P</th>
                        <th class="px-6 py-3.5">Kelas</th>
                        <th class="px-6 py-3.5">HP Ortu</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($siswa as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-slate-400">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $item->nama_lengkap }}<span class="block text-[11px] font-medium text-slate-400">{{ $item->nisn }}</span></td>
                            <td class="px-6 py-4 text-center">{{ $item->jenis_kelamin }}</td>
                            <td class="px-6 py-4">{{ $item->anggotaKelas->first()?->kelas?->nama_kelas ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $item->no_hp_ortu ?? '-' }}</td>
                            <td class="px-6 py-4 text-right" x-data="{ editModal: false }">
                                <button @click="editModal = true" class="px-3 py-1 bg-amber-50 text-amber-600 hover:bg-amber-100 font-bold rounded-lg transition-colors text-[11px]">Edit</button>
                                <form action="{{ route('admin.siswa.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus siswa ini beserta riwayat absensinya?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-rose-50 text-rose-600 hover:bg-rose-100 font-bold rounded-lg transition-colors text-[11px]">Hapus</button>
                                </form>

                                <!-- Modal Edit -->
                                <div x-show="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs px-4" x-cloak>
                                    <div @click.outside="editModal = false" class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-100 text-left max-h-[90vh] overflow-y-auto">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-base font-bold text-slate-800">Edit Siswa</h3>
                                            <button @click="editModal = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                                        </div>
                                        <form action="{{ route('admin.siswa.update', $item->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="space-y-4">
                                                <div class="grid grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs font-bold text-slate-600 mb-1">NISN</label>
                                                        <input type="text" name="nisn" value="{{ $item->nisn }}" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-bold text-slate-600 mb-1">Jenis Kelamin</label>
                                                        <select name="jenis_kelamin" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                            <option value="L" @selected($item->jenis_kelamin === 'L')>Laki-laki</option>
                                                            <option value="P" @selected($item->jenis_kelamin === 'P')>Perempuan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-600 mb-1">Nama Lengkap</label>
                                                    <input type="text" name="nama_lengkap" value="{{ $item->nama_lengkap }}" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-600 mb-1">No. HP Orang Tua</label>
                                                    <input type="text" name="no_hp_ortu" value="{{ $item->no_hp_ortu }}" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                </div>
                                                <div class="grid grid-cols-3 gap-3">
                                                    <div>
                                                        <label class="block text-xs font-bold text-slate-600 mb-1">QR Code</label>
                                                        <input type="text" name="qr_code" value="{{ $item->qr_code }}" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-bold text-slate-600 mb-1">Kartu (RFID)</label>
                                                        <input type="text" name="card_number" value="{{ $item->card_number }}" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-bold text-slate-600 mb-1">Sidik Jari</label>
                                                        <input type="text" name="fingerprint_id" value="{{ $item->fingerprint_id }}" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs font-bold text-slate-600 mb-1">Tahun Ajaran</label>
                                                        <select name="tahun_ajaran_id" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                            @foreach($tahunAjaran as $ta)
                                                                <option value="{{ $ta->id }}" @selected($tahunAjaranId == $ta->id)>{{ $ta->tahun }} - Smt {{ $ta->semester }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-bold text-slate-600 mb-1">Kelas</label>
                                                        <select name="kelas_id" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                            @foreach($kelas as $k)
                                                                <option value="{{ $k->id }}" @selected($item->anggotaKelas->first()?->kelas_id == $k->id)>{{ $k->nama_kelas }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-6 flex justify-end space-x-3">
                                                <button type="button" @click="editModal = false" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                                                <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition-colors">Update Data</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-8 text-center text-slate-400">Belum ada data siswa pada tahun ajaran ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
