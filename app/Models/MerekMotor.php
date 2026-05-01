<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MerekMotor extends Model
{
    protected $fillable = ['nama_merek'];

    public function kendaraan(): HasMany
    {
        return $this->hasMany(Kendaraan::class, 'id_merek');
    }
}

