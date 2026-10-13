<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'username', 'email', 'password', 'role', 'penugasan'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function guru()
    {
        return $this->hasOne(Guru::class, 'user_id');
    }

    public function orangTuaSiswa()
    {
        return $this->hasMany(OrangTuaSiswa::class, 'user_id');
    }

    /**
     * Cek penugasan khusus, mis. bertugasSebagai('bk').
     * Role tetap (mis. guru), penugasan menambah hak akses halaman tugas.
     * Perbandingan case-insensitive agar 'BK'/'Bk' tetap dikenali.
     */
    public function bertugasSebagai(string $tugas): bool
    {
        return strtolower(trim($this->penugasan ?? '')) === strtolower($tugas);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
