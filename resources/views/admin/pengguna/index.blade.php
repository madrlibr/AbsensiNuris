<x-app-layout>
    <!-- Breadcrumb & Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="flex items-center space-x-2 text-xs font-semibold text-slate-400 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
                <span>/</span>
                <span class="text-slate-700">Data Pengguna</span>
            </nav>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Manajemen Pengguna</h1>
            <p class="text-xs text-slate-400 font-medium mt-0.5">Kelola akun login, role, dan penugasan khusus seperti BK.</p>
        </div>

        <!-- Tombol Trigger Modal Tambah -->
        <div x-data="{ openModal: false }">
            <button @click="openModal = true" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-blue-500/20 transition-all">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Tambah Pengguna
            </button>

            <!-- Modal Form Tambah -->
            <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs px-4" x-cloak>
                <div @click.outside="openModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-slate-800">Tambah Pengguna Baru</h3>
                        <button @click="openModal = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form action="{{ route('admin.pengguna.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Username</label>
                                    <input type="text" name="username" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Role</label>
                                    <select name="role" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                        <option value="admin">Administrator</option>
                                        <option value="guru" selected>Guru</option>
                                        <option value="wali_kelas">Wali Kelas</option>
                                        <option value="piket">Guru Piket</option>
                                        <option value="orang_tua">Orang Tua</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Email</label>
                                <input type="email" name="email" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Password</label>
                                <input type="password" name="password" required minlength="8" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Penugasan <span class="font-medium text-slate-400">(menambah hak akses)</span></label>
                                <select name="penugasan" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="">— Tanpa penugasan —</option>
                                    <option value="bk">BK – Bimbingan Konseling (akses halaman guru + BK)</option>
                                </select>
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

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold flex items-center justify-between">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">&times;</button>
        </div>
    @endif

    <!-- Tabel Data Pengguna -->
    <div class="bg-white rounded-2xl border border-slate-200/70 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-200/70 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-3.5">No</th>
                        <th class="px-6 py-3.5">Nama / Email</th>
                        <th class="px-6 py-3.5">Username</th>
                        <th class="px-6 py-3.5">Role</th>
                        <th class="px-6 py-3.5">Penugasan</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($pengguna as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-slate-400">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $item->name }}<span class="block text-[11px] font-medium text-slate-400">{{ $item->email }}</span></td>
                            <td class="px-6 py-4">{{ $item->username ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-200/60 capitalize">
                                    {{ str_replace('_', ' ', $item->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($item->penugasan)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-violet-50 text-violet-600 border border-violet-200/60 uppercase">{{ $item->penugasan }}</span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right" x-data="{ editModal: false }">
                                <button @click="editModal = true" class="px-3 py-1 bg-amber-50 text-amber-600 hover:bg-amber-100 font-bold rounded-lg transition-colors text-[11px]">Edit</button>
                                @if($item->id !== auth()->id())
                                    <form action="{{ route('admin.pengguna.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-rose-50 text-rose-600 hover:bg-rose-100 font-bold rounded-lg transition-colors text-[11px]">Hapus</button>
                                    </form>
                                @endif

                                <!-- Modal Edit -->
                                <div x-show="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs px-4" x-cloak>
                                    <div @click.outside="editModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100 text-left max-h-[90vh] overflow-y-auto">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-base font-bold text-slate-800">Edit Pengguna</h3>
                                            <button @click="editModal = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                                        </div>
                                        <form action="{{ route('admin.pengguna.update', $item->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-600 mb-1">Nama Lengkap</label>
                                                    <input type="text" name="name" value="{{ $item->name }}" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                </div>
                                                <div class="grid grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs font-bold text-slate-600 mb-1">Username</label>
                                                        <input type="text" name="username" value="{{ $item->username }}" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-bold text-slate-600 mb-1">Role</label>
                                                        <select name="role" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                            <option value="admin" @selected($item->role === 'admin')>Administrator</option>
                                                            <option value="guru" @selected($item->role === 'guru')>Guru</option>
                                                            <option value="wali_kelas" @selected($item->role === 'wali_kelas')>Wali Kelas</option>
                                                            <option value="piket" @selected($item->role === 'piket')>Guru Piket</option>
                                                            <option value="orang_tua" @selected($item->role === 'orang_tua')>Orang Tua</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-600 mb-1">Email</label>
                                                    <input type="email" name="email" value="{{ $item->email }}" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-600 mb-1">Password Baru <span class="font-medium text-slate-400">(kosongkan jika tidak diubah)</span></label>
                                                    <input type="password" name="password" minlength="8" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-600 mb-1">Penugasan</label>
                                                    <select name="penugasan" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                                        <option value="">— Tanpa penugasan —</option>
                                                        <option value="bk" @selected(strtolower(trim($item->penugasan ?? '')) === 'bk')>BK – Bimbingan Konseling (akses halaman guru + BK)</option>
                                                    </select>
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
                        <tr><td colspan="6" class="px-6 py-8 text-center text-slate-400">Belum ada data pengguna.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
