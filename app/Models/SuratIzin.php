<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratIzin extends Model
{
    use HasFactory;

    // Tambahkan baris ini
    protected $table = 'surat_izin';

    protected $guarded = ['id'];
}
