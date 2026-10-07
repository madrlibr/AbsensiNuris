<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaKelas extends Model
{
    use HasFactory;

    // Tambahkan baris ini
    protected $table = 'anggota_kelas';

    protected $guarded = ['id'];
}
