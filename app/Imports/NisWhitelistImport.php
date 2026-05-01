<?php

namespace App\Imports;

use App\Models\NisWhitelist;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Penting: Agar sistem tahu baris 1 adalah Judul/Header

class NisWhitelistImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Abaikan jika barisnya kosong atau tidak ada tulisan NIS-nya
        if (!isset($row['nis'])) {
            return null;
        }

        // Keamanan Kuat: Jika NIS tersebut sudah ada di gudang, Jangan ditambahkan lagi (Skip baris ini)
        $exists = NisWhitelist::where('nis', $row['nis'])->exists();
        if ($exists) {
            return null;
        }

        // Kalau lolos tes, masukkan baris ini ke Database
        return new NisWhitelist([
            'nis'  => (string) $row['nis'],
            'nama' => $row['nama'] ?? 'Tanpa Nama', // Kalau kolom nama digosongin di excel, kasih tulisan otomatis
            'sudah_daftar' => false,
        ]);
    }
}
