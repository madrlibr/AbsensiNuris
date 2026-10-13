@extends('layouts.app') {{-- Sesuaikan dengan nama layout admin kamu, misal: layouts.app atau layouts.admin --}}

@section('content')
<div class="container-fluid px-4 py-6">
    <!-- Header Section -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="flex items-center space-x-2 text-xs font-semibold text-slate-400 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
                <span>/</span>
                <span class="text-slate-700">Data Kelas</span>
            </nav>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pengaturan Kelas dan Jurusan</h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Kelola daftar rombongan belajar / kelas berdasarkan tingkat dan jurusan sekolah.</p>
        </div>

        <div x-data="{ openModal: false }">
            <button @click="openModal = true" class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-md shadow-blue-500/20 transition-all transform active:scale-95">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Tambah Kelas
            </button>

            <!-- Modal Tambah -->
            <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-xs px-4" x-cloak>
                <div @click.outside="openModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-100">
                    <div class="flex items-center justify-between mb-5 pb-3 border-b border-slate-100">
                        <h3 class="text-sm font-bold text-slate-900">Tambah Kelas Baru</h3>
                        <button @click="openModal = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition-colors">&times;</button>
                    </div>
                    <form action="{{ route('admin.kelas.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4 text-left">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Kelas</label>
                                <input type="text" name="nama_kelas" placeholder="Contoh: XII RPL 1" required class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-800 font-medium">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Tingkat</label>
                                <select name="tingkat" required class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-800 font-medium bg-white">
                                    <option value="X">X (Sepuluh)</option>
                                    <option value="XI">XI (Sebelas)</option>
                                    <option value="XII">XII (Duabelas)</option>                                    
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Jurusan</label>
                                <select name="jurusan_id" required class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-800 font-medium bg-white">
                                    @foreach($jurusan as $j)
                                        <option value="{{ $j->id }}">{{ $j->nama_jurusan }} ({{ $j->kode_jurusan }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-2 pt-3 border-t border-slate-100">
                            <button type="button" @click="openModal = false" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                            <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition-colors">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200/80 text-emerald-700 text-xs font-bold flex items-center justify-between shadow-xs">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </span>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
        </div>
    @endif

    <!-- Main Card Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-4 w-16">No</th>
                        <th class="px-6 py-4">Nama Kelas</th>
                        <th class="px-6 py-4">Tingkat</th>
                        <th class="px-6 py-4">Jurusan</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($kelas as $item)
                        <tr class="hover:bg-slate-50/60 transition-colors group">
                            <td class="px-6 py-4 text-slate-400 font-semibold">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-bold text-slate-900 text-sm">{{ $item->nama_kelas }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                    Tingkat {{ $item->tingkat }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-600">{{ $item->jurusan->nama_jurusan ?? '-' }}</td>
                            <td class="px-6 py-4 text-right" x-data="{ editModal: false }">
                                <div class="inline-flex items-center space-x-2">
                                    <button @click="editModal = true" class="inline-flex items-center px-3 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 font-bold rounded-lg transition-colors text-[11px]">
                                        Edit
                                    </button>
                                    
                                    <form action="{{ route('admin.kelas.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 font-bold rounded-lg transition-colors text-[11px]">
                                            Hapus
                                        </button>
                                    </form>
                                </div>

                                <!-- Modal Edit -->
                                <div x-show="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-xs px-4" x-cloak>
                                    <div @click.outside="editModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-100 text-left">
                                        <div class="flex items-center justify-between mb-5 pb-3 border-b border-slate-100">
                                            <h3 class="text-sm font-bold text-slate-900">Edit Kelas</h3>
                                            <button @click="editModal = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                                        </div>
                                        <form action="{{ route('admin.kelas.update', $item->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Kelas </label>
                                                    <input type="text" name="nama_kelas" value="{{ $item->nama_kelas }}" required class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/25 focus:border-blue-500 text-slate-800 font-medium">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Tingkat</label>
                                                    <select name="tingkat" required class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/25 focus:border-blue-500 text-slate-800 font-medium bg-white">
                                                        <option value="X" {{ $item->tingkat == 'X' ? 'selected' : '' }}>X (Sepuluh)</option>
                                                        <option value="XI" {{ $item->tingkat == 'XI' ? 'selected' : '' }}>XI (Sebelas)</option>
                                                        <option value="XII" {{ $item->tingkat == 'XII' ? 'selected' : '' }}>XII (Duabelas)</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Jurusan</label>
                                                    <select name="jurusan_id" required class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/25 focus:border-blue-500 text-slate-800 font-medium bg-white">
                                                        @foreach($jurusan as $j)
                                                            <option value="{{ $j->id }}" {{ $item->jurusan_id == $j->id ? 'selected' : '' }}>{{ $j->nama_jurusan }} ({{ $j->kode_jurusan }})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mt-6 flex justify-end space-x-2 pt-3 border-t border-slate-100">
                                                <button type="button" @click="editModal = false" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                                                <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition-colors">Update Data</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                <span class="font-medium">Belum ada data kelas tersimpan.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection