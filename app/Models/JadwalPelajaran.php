<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    use HasFactory;

    // Tambahkan baris ini
    protected $table = 'jadwal_pelajaran';

    protected $guarded = ['id'];
}
