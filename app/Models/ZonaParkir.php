<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ZonaParkir extends Model
{
    protected $fillable = [
        'nama_zona',
        'keterangan',
        'kapasitas_total',
        'kode_warna',
        'foto_denah',
    ];

    public function kendaraan(): HasMany
    {
        return $this->hasMany(Kendaraan::class, 'id_zona');
    }

    public function baris(): HasMany
    {
        return $this->hasMany(BarisZona::class, 'id_zona')->orderBy('nama_baris');
    }

    // Kapasitas total dihitung otomatis dari jumlah kapasitas semua baris
    public function getKapasitasTotalAttribute(): int
    {
        return $this->baris()->sum('kapasitas');
    }

    public function getTerisiAttribute(): int
    {
        return $this->kendaraan()->count();
    }

    public function getSisaKuotaAttribute(): int
    {
        return max(0, $this->kapasitas_total - $this->terisi);
    }

    public function getIsPenuhAttribute(): bool
    {
        return $this->sisa_kuota <= 0;
    }
}

