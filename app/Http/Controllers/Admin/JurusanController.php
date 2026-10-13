<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::latest()->get();

        return view('admin.jurusan.index', compact('jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_jurusan' => 'required|string|max:10|unique:jurusan,kode_jurusan',
            'nama_jurusan' => 'required|string|max:100',
        ]);

        Jurusan::create($request->all());

        return redirect()->back()->with('success', 'Data jurusan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);

        $request->validate([
            'kode_jurusan' => 'required|string|max:10|unique:jurusan,kode_jurusan,'.$jurusan->id,
            'nama_jurusan' => 'required|string|max:100',
        ]);

        $jurusan->update($request->all());

        return redirect()->back()->with('success', 'Data jurusan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->back()->with('success', 'Data jurusan berhasil dihapus.');
    }
}
