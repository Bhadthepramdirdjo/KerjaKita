<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nama tabel di database
     */
    protected $table = 'User';

    /**
     * Primary key
     */
    protected $primaryKey = 'idUser';

    /**
     * Kolom yang bisa diisi mass assignment
     */
    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'jenis_kelamin',
        'tipe_user',
        'alamat',
        'no_hp',
        'foto_profil',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Kolom yang di-cast ke tipe tertentu
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke tabel Pekerja
     */
    public function pekerja()
    {
        return $this->hasOne(\App\Models\Pekerja::class, 'idUser', 'idUser');
    }

    /**
     * Relasi ke tabel PemberiKerja
     */
    public function pemberiKerja()
    {
        return $this->hasOne(\App\Models\PemberiKerja::class, 'idUser', 'idUser');
    }

    /**
     * Helper method untuk cek apakah user adalah pekerja
     */
    public function isPekerja()
    {
        return $this->tipe_user === 'Pekerja';
    }

    /**
     * Helper method untuk cek apakah user adalah pemberi kerja
     */
    public function isPemberiKerja()
    {
        return $this->tipe_user === 'PemberiKerja';
    }
}