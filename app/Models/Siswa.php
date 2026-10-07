<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = ['nisn', 'nama_lengkap', 'jenis_kelamin', 'no_hp_ortu', 'qr_code', 'card_number', 'fingerprint_id'];

    public function anggotaKelas()
    {
        return $this->hasMany(AnggotaKelas::class, 'siswa_id');
    }
}
