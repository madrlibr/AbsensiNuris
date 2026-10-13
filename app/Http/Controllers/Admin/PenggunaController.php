<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PenggunaController extends Controller
{
    public const ROLES = ['admin', 'guru', 'wali_kelas', 'piket', 'orang_tua'];

    public const PENUGASAN = ['bk'];

    public function index()
    {
        $pengguna = User::with('guru')->latest()->get();

        return view('admin.pengguna.index', compact('pengguna'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(self::ROLES)],
            'penugasan' => ['nullable', 'string', 'max:30', Rule::in(self::PENUGASAN)],
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['nullable', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'role' => ['required', Rule::in(self::ROLES)],
            'penugasan' => ['nullable', 'string', 'max:30', Rule::in(self::PENUGASAN)],
        ]);

        // Admin tidak boleh mencabut role admin miliknya sendiri.
        if ($user->is(auth()->user()) && $data['role'] !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak dapat mencabut role admin milik sendiri.');
        }

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->is(auth()->user())) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
