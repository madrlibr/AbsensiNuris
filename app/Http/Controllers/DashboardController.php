<?php

namespace App\Http\Controllers;

use App\Models\AbsensiHarian;
use App\Models\Siswa;
use App\Models\SuratIzin;
use App\Models\TahunAjaran;

class DashboardController extends Controller
{
    public function index()
    {
        $tahunAktif = TahunAjaran::where('is_aktif', true)->first();
        $hariIni = now()->toDateString();

        $totalSiswa = $tahunAktif
            ? Siswa::whereHas('anggotaKelas', fn ($q) => $q->where('tahun_ajaran_id', $tahunAktif->id))->count()
            : Siswa::count();

        $hari = ['hadir' => 0, 'terlambat' => 0, 'izin' => 0, 'sakit' => 0, 'alpa' => 0];
        if ($tahunAktif) {
            $cacah = AbsensiHarian::where('tahun_ajaran_id', $tahunAktif->id)
                ->where('tanggal', $hariIni)
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');

            foreach ($hari as $status => $nol) {
                $hari[$status] = $cacah[$status] ?? 0;
            }
        }

        $izinPending = SuratIzin::where('status_persetujuan', 'pending')->count();

        return view('dashboard', compact('tahunAktif', 'totalSiswa', 'hari', 'izinPending', 'hariIni'));
    }
}
