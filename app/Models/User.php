<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nis_nip',
        'nama_lengkap',
        'password',
        'role',
        'tahun_masuk',
        'is_first_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_first_login' => 'boolean',
        ];
    }

    public function kendaraan(): HasOne
    {
        return $this->hasOne(Kendaraan::class, 'id_user');
    }

    public function absensiParkir(): HasMany
    {
        return $this->hasMany(AbsensiParkir::class, 'id_user');
    }

    public function barangTemuan(): HasMany
    {
        return $this->hasMany(BarangTemuan::class, 'id_admin');
    }
}

