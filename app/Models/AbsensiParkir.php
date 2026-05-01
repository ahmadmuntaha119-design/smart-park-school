<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsensiParkir extends Model
{
    protected $fillable = [
        'id_user',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'foto_bukti_masuk',
        'latitude_masuk',
        'longitude_masuk',
        'jarak_dari_sekolah',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'            => 'date',
            'waktu_masuk'        => 'datetime',
            'waktu_keluar'       => 'datetime',
            'latitude_masuk'     => 'float',
            'longitude_masuk'    => 'float',
            'jarak_dari_sekolah' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
