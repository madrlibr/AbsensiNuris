<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::with(['user', 'kelasWali'])->orderBy('nama_lengkap')->get();

        // Akun yang bisa ditautkan: role guru/wali_kelas yang belum punya data guru.
        $akunTersedia = User::whereIn('role', ['guru', 'wali_kelas'])
            ->whereNotIn('id', Guru::whereNotNull('user_id')->pluck('user_id'))
            ->orderBy('name')
            ->get();

        return view('admin.guru.index', compact('guru', 'akunTersedia'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nip' => 'nullable|string|max:30|unique:guru,nip',
            'no_hp' => 'nullable|string|max:20',
            'user_id' => 'nullable|exists:users,id|unique:guru,user_id',
        ]);

        Guru::create($data);

        return redirect()->back()->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nip' => ['nullable', 'string', 'max:30', Rule::unique('guru', 'nip')->ignore($guru->id)],
            'no_hp' => 'nullable|string|max:20',
            'user_id' => ['nullable', 'exists:users,id', Rule::unique('guru', 'user_id')->ignore($guru->id)],
        ]);

        $guru->update($data);

        return redirect()->back()->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Guru::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Data guru berhasil dihapus.');
    }
}
