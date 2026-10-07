<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    // Tambahkan baris ini
    protected $table = 'mata_pelajaran';

    protected $guarded = ['id'];
}
