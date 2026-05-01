<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MerekMotor;

class MerekMotorSeeder extends Seeder
{
    public function run(): void
    {
        $mereks = [
            'Honda',
            'Yamaha',
            'Suzuki',
            'Kawasaki',
            'Listrik/Lainnya'
        ];

        foreach ($mereks as $merek) {
            MerekMotor::create(['nama_merek' => $merek]);
        }
    }
}
