<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ZonaParkir;

class ZonaParkirSeeder extends Seeder
{
    public function run(): void
    {
        $zonas = [
            [
                'nama_zona' => 'A&C',
                'keterangan' => null,
                'kapasitas_total' => 108,
                'kode_warna' => '#3B82F6', // Biru
            ],
            [
                'nama_zona' => 'B Depan',
                'keterangan' => null,
                'kapasitas_total' => 30,
                'kode_warna' => '#10B981', // Hijau
            ],
            [
                'nama_zona' => 'B Belakang',
                'keterangan' => null,
                'kapasitas_total' => 144,
                'kode_warna' => '#10B981', // Hijau
            ],
            [
                'nama_zona' => 'D',
                'keterangan' => null,
                'kapasitas_total' => 180,
                'kode_warna' => '#F59E0B', // Kuning
            ],
            [
                'nama_zona' => 'E',
                'keterangan' => null,
                'kapasitas_total' => 149,
                'kode_warna' => '#8B5CF6', // Ungu
            ],
            [
                'nama_zona' => 'F',
                'keterangan' => null,
                'kapasitas_total' => 150,
                'kode_warna' => '#EF4444', // Merah
            ],
        ];

        foreach ($zonas as $zona) {
            ZonaParkir::create($zona);
        }
    }
}
