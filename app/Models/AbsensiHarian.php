<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiHarian extends Model
{
    use HasFactory;

    // Tambahkan baris ini
    protected $table = 'absensi_harian';

    protected $guarded = ['id'];
}
