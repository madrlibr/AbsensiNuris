<?php

use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\PengaturanAbsensiController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\BK\LaporanController as BKLaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Piket\AbsensiController as PiketAbsensiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Tahun Ajaran
    Route::get('/tahun-ajaran', [TahunAjaranController::class, 'index'])->name('tahun-ajaran.index');
    Route::post('/tahun-ajaran', [TahunAjaranController::class, 'store'])->name('tahun-ajaran.store');
    Route::patch('/tahun-ajaran/{id}/aktif', [TahunAjaranController::class, 'setAktif'])->name('tahun-ajaran.set-aktif');
    Route::delete('/tahun-ajaran/{id}', [TahunAjaranController::class, 'destroy'])->name('tahun-ajaran.destroy');

    // Pengaturan Jam Absensi
    Route::get('/pengaturan-absensi', [PengaturanAbsensiController::class, 'index'])->name('pengaturan-absensi.index');
    Route::put('/pengaturan-absensi/{id}', [PengaturanAbsensiController::class, 'update'])->name('pengaturan-absensi.update');

    // Jurusan
    Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
    Route::post('/jurusan', [JurusanController::class, 'store'])->name('jurusan.store');
    Route::put('/jurusan/{id}', [JurusanController::class, 'update'])->name('jurusan.update');
    Route::delete('/jurusan/{id}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');

    // Kelas
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
    Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');

    // Pengguna (akun login, role, penugasan)
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::put('/pengguna/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

    // Siswa + penempatan kelas (anggota_kelas)
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');

    // Guru (+ tautan akun user)
    Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
    Route::post('/guru', [GuruController::class, 'store'])->name('guru.store');
    Route::put('/guru/{id}', [GuruController::class, 'update'])->name('guru.update');
    Route::delete('/guru/{id}', [GuruController::class, 'destroy'])->name('guru.destroy');

    // Mata pelajaran
    Route::get('/mapel', [MapelController::class, 'index'])->name('mapel.index');
    Route::post('/mapel', [MapelController::class, 'store'])->name('mapel.store');
    Route::put('/mapel/{id}', [MapelController::class, 'update'])->name('mapel.update');
    Route::delete('/mapel/{id}', [MapelController::class, 'destroy'])->name('mapel.destroy');

    // Jadwal pelajaran
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
});

Route::middleware(['auth', 'role:bk'])->prefix('bk')->name('bk.')->group(function () {

    // Laporan BK: role guru dengan penugasan bk (lihat users.penugasan)
    Route::get('/laporan', [BKLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/siswa/{siswa}', [BKLaporanController::class, 'show'])->name('laporan.show');
});

Route::middleware(['auth', 'role:piket,admin'])->prefix('piket')->name('piket.')->group(function () {

    // Absensi gerbang harian: scan QR/RFID/sidik jari + input manual.
    Route::get('/absensi', [PiketAbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi/scan', [PiketAbsensiController::class, 'scan'])->name('absensi.scan');
    Route::post('/absensi/manual', [PiketAbsensiController::class, 'manual'])->name('absensi.manual');
});

require __DIR__.'/auth.php';
