<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kendaraan extends Model
{
    protected $fillable = [
        'id_user',
        'id_zona',
        'id_baris',
        'nomor_slot',
        'id_merek',
        'model_motor',
        'warna',
        'jenis_transmisi',
        'plat_nomor',
        'kelas',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function zonaParkir(): BelongsTo
    {
        return $this->belongsTo(ZonaParkir::class, 'id_zona');
    }

    public function merekMotor(): BelongsTo
    {
        return $this->belongsTo(MerekMotor::class, 'id_merek');
    }

    public function getZonaSudahDiassignAttribute(): bool
    {
        return !is_null($this->id_zona);
    }

    // Alias agar kode Controller dan Tampilan lebih ringkas (dipanggil dengan $kendaraan->zona)
    public function zona(): BelongsTo
    {
        return $this->belongsTo(ZonaParkir::class, 'id_zona');
    }

    public function merek(): BelongsTo
    {
        return $this->belongsTo(MerekMotor::class, 'id_merek');
    }

    public function baris(): BelongsTo
    {
        return $this->belongsTo(BarisZona::class, 'id_baris');
    }
}

