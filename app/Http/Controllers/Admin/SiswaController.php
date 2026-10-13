<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKelas;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $tahunAktif = TahunAjaran::where('is_aktif', true)->first();
        $tahunAjaranId = $request->get('tahun_ajaran_id', $tahunAktif?->id);

        $siswa = Siswa::with(['anggotaKelas' => fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaranId), 'anggotaKelas.kelas'])
            ->when($tahunAjaranId, fn ($q) => $q->whereHas('anggotaKelas', fn ($qq) => $qq->where('tahun_ajaran_id', $tahunAjaranId)))
            ->orderBy('nama_lengkap')
            ->get();

        return view('admin.siswa.index', [
            'siswa' => $siswa,
            'kelas' => Kelas::orderBy('nama_kelas')->get(),
            'tahunAjaran' => TahunAjaran::latest()->get(),
            'tahunAjaranId' => $tahunAjaranId,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nisn' => 'required|string|max:20|unique:siswa,nisn',
            'nama_lengkap' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp_ortu' => 'nullable|string|max:20',
            'qr_code' => 'nullable|string|max:255|unique:siswa,qr_code',
            'card_number' => 'nullable|string|max:255|unique:siswa,card_number',
            'fingerprint_id' => 'nullable|string|max:255|unique:siswa,fingerprint_id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        ]);

        // Default QR = NISN bila dikosongkan.
        $data['qr_code'] = $data['qr_code'] ?: $data['nisn'];

        $siswa = Siswa::create($data);

        AnggotaKelas::create([
            'siswa_id' => $siswa->id,
            'kelas_id' => $data['kelas_id'],
            'tahun_ajaran_id' => $data['tahun_ajaran_id'],
        ]);

        return redirect()->back()->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $data = $request->validate([
            'nisn' => ['required', 'string', 'max:20', Rule::unique('siswa', 'nisn')->ignore($siswa->id)],
            'nama_lengkap' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp_ortu' => 'nullable|string|max:20',
            'qr_code' => ['nullable', 'string', 'max:255', Rule::unique('siswa', 'qr_code')->ignore($siswa->id)],
            'card_number' => ['nullable', 'string', 'max:255', Rule::unique('siswa', 'card_number')->ignore($siswa->id)],
            'fingerprint_id' => ['nullable', 'string', 'max:255', Rule::unique('siswa', 'fingerprint_id')->ignore($siswa->id)],
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        ]);

        $data['qr_code'] = $data['qr_code'] ?: $data['nisn'];

        $siswa->update($data);

        AnggotaKelas::updateOrCreate(
            ['siswa_id' => $siswa->id, 'tahun_ajaran_id' => $data['tahun_ajaran_id']],
            ['kelas_id' => $data['kelas_id']]
        );

        return redirect()->back()->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Siswa::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Data siswa berhasil dihapus.');
    }
}
