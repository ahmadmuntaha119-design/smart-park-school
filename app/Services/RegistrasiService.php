<?php

namespace App\Services;

use App\Models\User;
use App\Models\Kendaraan;
use App\Models\NisWhitelist;
use Illuminate\Support\Facades\DB;

class RegistrasiService 
{
    public function daftar(array $data): User
    {
        // 1. Cek secara ketat apakah NIS ada di buku tamu (Whitelist) dan BELUM mendaftar
        $whitelist = NisWhitelist::where('nis', $data['nis'])
            ->where('sudah_daftar', false)
            ->first();

        if (!$whitelist) {
            // Membatalkan proses jika NIS bodong / sudah terpakai
            throw new \Exception('NIS tidak terdaftar atau sudah digunakan. Hubungi Admin PKS.');
        }

        // --- MULAI PROSES PEMBUATAN DATA BERSAMAAN ---
        DB::beginTransaction();
        try {
            // 2. Ciptakan Akun Siswanya
            $user = User::create([
                'nis_nip'        => $data['nis'],
                'nama_lengkap'   => $whitelist->nama,
                // Ingat: Password awal otomatis disamakan dengan NIS-nya
                'password'       => bcrypt($data['nis']), 
                'role'           => 'Siswa',
                'tahun_masuk'    => now()->year,
                'is_first_login' => true, // <-- Ini yang akan memancing Polisi Ganti Password nanti!
            ]);

            // 3. Masukkan Data Motornya (Zona dibiarkan NULL dulu)
            Kendaraan::create([
                'id_user'         => $user->id,
                'id_zona'         => null, 
                'id_merek'        => $data['id_merek'],
                'model_motor'     => $data['model_motor'],
                'warna'           => $data['warna'],
                'jenis_transmisi' => $data['jenis_transmisi'],
                'plat_nomor'      => $data['plat_nomor'],
                'kelas'           => $data['kelas'],
            ]);

            // 4. Coret namanya dari daftar agar tidak bisa didaftarkan ulang
            $whitelist->update(['sudah_daftar' => true]);

            DB::commit();
            
            return $user;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; // Lempar error kalau gagal
        }
    }
}
