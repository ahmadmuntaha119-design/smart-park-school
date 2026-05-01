<?php

namespace App\Exports;

use App\Models\NisWhitelist;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NisWhitelistExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return NisWhitelist::all();
    }

    public function headings(): array
    {
        return [
            'NIS / NIP',
            'Nama Lengkap',
            'Status Registrasi',
        ];
    }

    public function map($whitelist): array
    {
        return [
            $whitelist->nis,
            $whitelist->nama,
            $whitelist->sudah_daftar ? 'Terpakai' : 'Siap Dipakai (Menunggu)',
        ];
    }
}
