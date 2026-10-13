<x-app-layout>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="flex items-center space-x-2 text-xs font-semibold text-slate-400 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
                <span>/</span>
                <span class="text-slate-700">Data Jurusan</span>
            </nav>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Manajemen Jurusan SMK</h1>
            <p class="text-xs text-slate-400 font-medium mt-0.5">Kelola daftar program keahlian/jurusan yang tersedia di sekolah.</p>
        </div>

        <div x-data="{ openModal: false }">
            <button @click="openModal = true" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-blue-500/20 transition-all">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Tambah Jurusan
            </button>

            <!-- Modal Tambah -->
            <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs px-4" x-cloak>
                <div @click.outside="openModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-slate-800">Tambah Jurusan Baru</h3>
                        <button @click="openModal = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                    </div>
                    <form action="{{ route('admin.jurusan.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Kode Jurusan</label>
                                <input type="text" name="kode_jurusan" placeholder="Contoh: RPL" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 uppercase">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Nama Jurusan</label>
                                <input type="text" name="nama_jurusan" placeholder="Contoh: Rekayasa Perangkat Lunak" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="openModal = false" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-100 rounded-xl">Batal</button>
                            <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-500">&times;</button>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200/70 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-200/70 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-3.5">No</th>
                        <th class="px-6 py-3.5">Kode</th>
                        <th class="px-6 py-3.5">Nama Jurusan</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($jurusan as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-slate-400">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-bold text-blue-600 uppercase">{{ $item->kode_jurusan }}</td>
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $item->nama_jurusan }}</td>
                            <td class="px-6 py-4 text-right space-x-2" x-data="{ editModal: false }">
                                <button @click="editModal = true" class="px-3 py-1 bg-amber-50 text-amber-600 hover:bg-amber-100 font-bold rounded-lg transition-colors text-[11px]">Edit</button>
                                
                                <form action="{{ route('admin.jurusan.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus jurusan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-rose-50 text-rose-600 hover:bg-rose-100 font-bold rounded-lg transition-colors text-[11px]">Hapus</button>
                                </form>

                                <!-- Modal Edit -->
                                <div x-show="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs px-4 text-left" x-cloak>
                                    <div @click.outside="editModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-base font-bold text-slate-800">Edit Jurusan</h3>
                                            <button @click="editModal = false" class="text-slate-400">&times;</button>
                                        </div>
                                        <form action="{{ route('admin.jurusan.update', $item->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-600 mb-1">Kode Jurusan</label>
                                                    <input type="text" name="kode_jurusan" value="{{ $item->kode_jurusan }}" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl uppercase">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-600 mb-1">Nama Jurusan</label>
                                                    <input type="text" name="nama_jurusan" value="{{ $item->nama_jurusan }}" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl">
                                                </div>
                                            </div>
                                            <div class="mt-6 flex justify-end space-x-3">
                                                <button type="button" @click="editModal = false" class="px-4 py-2 text-xs font-bold text-slate-500">Batal</button>
                                                <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-blue-600 rounded-xl">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-8 text-center text-slate-400">Belum ada data jurusan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>