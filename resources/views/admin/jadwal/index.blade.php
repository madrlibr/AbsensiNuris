<x-app-layout>
    <!-- Breadcrumb & Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="flex items-center space-x-2 text-xs font-semibold text-slate-400 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
                <span>/</span>
                <span class="text-slate-700">Jadwal Pelajaran</span>
            </nav>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Manajemen Jadwal Pelajaran</h1>
            <p class="text-xs text-slate-400 font-medium mt-0.5">Acuan pencocokan absensi per mata pelajaran.</p>
        </div>

        <div x-data="{ openModal: false }">
            <button @click="openModal = true" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-blue-500/20 transition-all">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Tambah Jadwal
            </button>

            <!-- Modal Form Tambah -->
            <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs px-4" x-cloak>
                <div @click.outside="openModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-slate-800">Tambah Jadwal Baru</h3>
                        <button @click="openModal = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form action="{{ route('admin.jadwal.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Tahun Ajaran</label>
                                <select name="tahun_ajaran_id" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    @foreach($tahunAjaran as $ta)
                                        <option value="{{ $ta->id }}" @selected($tahunAjaranId == $ta->id)>{{ $ta->tahun }} - Smt {{ $ta->semester }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Kelas</label>
                                    <select name="kelas_id" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->id }}" @selected($kelasId == $k->id)>{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Hari</label>
                                    <select name="hari" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                        @foreach($daftarHari as $h)
                                            <option value="{{ $h }}">{{ $h }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Mata Pelajaran</label>
                                <select name="mata_pelajaran_id" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    @foreach($mapel as $m)
                                        <option value="{{ $m->id }}">{{ $m->nama_mapel }} ({{ $m->kode_mapel }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Guru Pengampu</label>
                                <select name="guru_id" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    @foreach($guru as $g)
                                        <option value="{{ $g->id }}">{{ $g->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                                @if($guru->isEmpty())
                                    <p class="mt-1 text-[11px] font-bold text-amber-600">Belum ada data guru — tambahkan dulu di Data Guru.</p>
                                @endif
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Jam Mulai</label>
                                    <input type="time" name="jam_mulai" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Jam Selesai</label>
                                    <input type="time" name="jam_selesai" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
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

    <!-- Filter -->
    <div class="bg-white rounded-2xl border border-slate-200/70 shadow-2xs p-4 mb-6">
        <form action="{{ route('admin.jadwal.index') }}" method="GET" class="grid grid-cols-2 md:grid-cols-4 gap-3 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Tahun Ajaran</label>
                <select name="tahun_ajaran_id" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    @foreach($tahunAjaran as $ta)
                        <option value="{{ $ta->id }}" @selected($tahunAjaranId == $ta->id)>{{ $ta->tahun }} - Smt {{ $ta->semester }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Kelas</label>
                <select name="kelas_id" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <option value="">Semua Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" @selected($kelasId == $k->id)>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Hari</label>
                <select name="hari" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <option value="">Semua Hari</option>
                    @foreach($daftarHari as $h)
                        <option value="{{ $h }}" @selected($hariAktif == $h)>{{ $h }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm transition-colors">Tampilkan</button>
            </div>
        </form>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
        </div>
    @endif

    <!-- Tabel Jadwal -->
    <div class="bg-white rounded-2xl border border-slate-200/70 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-200/70 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-3.5">Hari</th>
                        <th class="px-6 py-3.5">Jam</th>
                        <th class="px-6 py-3.5">Kelas</th>
                        <th class="px-6 py-3.5">Mapel</th>
                        <th class="px-6 py-3.5">Guru</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($jadwal as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $item->hari }}</td>
                            <td class="px-6 py-4">{{ substr($item->jam_mulai, 0, 5) }} – {{ substr($item->jam_selesai, 0, 5) }}</td>
                            <td class="px-6 py-4">{{ $item->kelas?->nama_kelas ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $item->mataPelajaran?->nama_mapel ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $item->guru?->nama_lengkap ?? '-' }}</td>
                            <td class="px-6 py-4 text-right" x-data="{ editModal: false }">
                                <button @click="editModal = true" class="px-3 py-1 bg-amber-50 text-amber-600 hover:bg-amber-100 font-bold rounded-lg transition-colors text-[11px]">Edit</button>
                                <form action="{{ route('admin.jadwal.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-rose-50 text-rose-600 hover:bg-rose-100 font-bold rounded-lg transition-colors text-[11px]">Hapus</button>
                                </form>

                                <!-- Modal Edit -->
                                <div x-show="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs px-4" x-cloak>
                                    <div @click.outside="editModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100 text-left max-h-[90vh] overflow-y-auto">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-base font-bold text-slate-800">Edit Jadwal</h3>
                                            <button @click="editModal = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                                        </div>
                                        <form action="{{ route('admin.jadwal.update', $item->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="space-y-4">
                                                <input type="hidden" name="tahun_ajaran_id" value="{{ $item->tahun_ajaran_id }}">
                                                <div class="grid grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs font-bold text-slate-600 mb-1">Kelas</label>
                                                        <select name="kelas_id" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                            @foreach($kelas as $k)
                                                                <option value="{{ $k->id }}" @selected($item->kelas_id == $k->id)>{{ $k->nama_kelas }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-bold text-slate-600 mb-1">Hari</label>
                                                        <select name="hari" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                            @foreach($daftarHari as $h)
                                                                <option value="{{ $h }}" @selected($item->hari == $h)>{{ $h }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-600 mb-1">Mata Pelajaran</label>
                                                    <select name="mata_pelajaran_id" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                        @foreach($mapel as $m)
                                                            <option value="{{ $m->id }}" @selected($item->mata_pelajaran_id == $m->id)>{{ $m->nama_mapel }} ({{ $m->kode_mapel }})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-600 mb-1">Guru Pengampu</label>
                                                    <select name="guru_id" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                        @foreach($guru as $g)
                                                            <option value="{{ $g->id }}" @selected($item->guru_id == $g->id)>{{ $g->nama_lengkap }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="grid grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs font-bold text-slate-600 mb-1">Jam Mulai</label>
                                                        <input type="time" name="jam_mulai" value="{{ substr($item->jam_mulai, 0, 5) }}" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-bold text-slate-600 mb-1">Jam Selesai</label>
                                                        <input type="time" name="jam_selesai" value="{{ substr($item->jam_selesai, 0, 5) }}" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
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
                        <tr><td colspan="6" class="px-6 py-8 text-center text-slate-400">Belum ada jadwal pada filter ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
