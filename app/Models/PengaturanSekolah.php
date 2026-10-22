<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanSekolah extends Model
{
    protected $table = 'pengaturan_sekolah';

    protected $fillable = [
        'nama_sekolah',
        'npsn',
        'alamat',
        'telepon',
        'tahun_ajaran',
    ];
}