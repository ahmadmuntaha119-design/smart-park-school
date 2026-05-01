<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangTemuan extends Model
{
    protected $fillable = [
        'id_admin',
        'nama_barang',
        'lokasi_ditemukan',
        'path_foto',
        'status',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_admin');
    }
}

