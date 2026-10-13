<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('jurusan')->latest()->get();
        $jurusan = Jurusan::all();

        return view('admin.kelas.index', compact('kelas', 'jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jurusan_id' => 'required|exists:jurusan,id',
            'nama_kelas' => 'required|string|max:50',
            'tingkat' => 'required|in:X,XI,XII',
        ]);

        Kelas::create($request->all());

        return redirect()->back()->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'jurusan_id' => 'required|exists:jurusan,id',
            'nama_kelas' => 'required|string|max:50',
            'tingkat' => 'required|in:X,XI,XII',
        ]);

        $kelas->update($request->all());

        return redirect()->back()->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->back()->with('success', 'Data kelas berhasil dihapus.');
    }
}
