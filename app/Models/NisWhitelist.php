<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NisWhitelist extends Model
{
    protected $fillable = [
        'nis',
        'nama',
        'sudah_daftar',
    ];

    protected function casts(): array
    {
        return [
            'sudah_daftar' => 'boolean',
        ];
    }
}

