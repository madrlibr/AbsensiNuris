<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjaran = TahunAjaran::latest()->get();

        return view('admin.tahun_ajaran.index', compact('tahunAjaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|string|max:20',
            'semester' => 'required|in:1,2',
        ]);

        TahunAjaran::create([
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'is_aktif' => false,
        ]);

        return redirect()->back()->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function setAktif($id)
    {
        // Nonaktifkan semua tahun ajaran terlebih dahulu
        TahunAjaran::query()->update(['is_aktif' => false]);

        // Aktifkan tahun ajaran yang dipilih
        $tahun = TahunAjaran::findOrFail($id);
        $tahun->update(['is_aktif' => true]);

        return redirect()->back()->with('success', 'Tahun ajaran aktif berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tahun = TahunAjaran::findOrFail($id);
        $tahun->delete();

        return redirect()->back()->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}
