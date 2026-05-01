<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nis_nip' => 'pks001',
            'nama_lengkap' => 'Admin PKS Utama',
            'password' => bcrypt('pks_smkn1kebumen'), // otomatis dienkripsi acak
            'role' => 'Admin',
            'tahun_masuk' => now()->year,
            'is_first_login' => false, // khusus PKS tidak dipaksa ganti password
        ]);
    }
}
