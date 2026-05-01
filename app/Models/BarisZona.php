<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BarisZona extends Model
{
    protected $table = 'baris_parkirs';

    protected $fillable = [
        'id_zona',
        'nama_baris',
        'kapasitas',
        'syarat_filter',
    ];

    protected function casts(): array
    {
        return [
            'syarat_filter' => 'array',
        ];
    }

    public function zona(): BelongsTo
    {
        return $this->belongsTo(ZonaParkir::class, 'id_zona');
    }

    public function kendaraan(): HasMany
    {
        return $this->hasMany(Kendaraan::class, 'id_baris');
    }

    // Jumlah motor yang sudah menempati baris ini
    public function getTerisiAttribute(): int
    {
        return $this->kendaraan()->count();
    }

    // Sisa slot yang tersedia
    public function getSisaSlotAttribute(): int
    {
        return max(0, $this->kapasitas - $this->terisi);
    }

    public function getIsPenuhAttribute(): bool
    {
        return $this->sisa_slot <= 0;
    }
}
