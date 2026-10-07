<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiMapel extends Model
{
    use HasFactory;

    // Tambahkan baris ini
    protected $table = 'absensi_mapel';

    protected $guarded = ['id'];
}
