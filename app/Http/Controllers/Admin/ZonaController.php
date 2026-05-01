<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarisZona;
use App\Models\Kendaraan;
use App\Models\ZonaParkir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ZonaController extends Controller
{
    // Daftar warna standar untuk filter aturan
    const WARNA_LIST = [
        'Hitam', 'Putih', 'Merah', 'Biru', 'Hijau', 'Silver',
        'Abu-abu', 'Coklat', 'Orange', 'Kuning', 'Pink', 'Ungu', 'Lainnya'
    ];

    // Menampilkan Tabel Seluruh Zona beserta Baris-barisnya
    public function index()
    {
        $zonas = ZonaParkir::with(['baris', 'kendaraan'])->orderBy('nama_zona')->get();
        return view('admin.zona.indexzona', compact('zonas'));
    }

    // Memproses form TAMBAH zona baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_zona'  => 'required|string|max:20|unique:zona_parkirs',
            'keterangan' => 'nullable|string|max:100',
            'kode_warna' => 'required|string|max:7',
            'foto_denah' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nama_zona.unique' => 'Nama zona ini sudah ada, gunakan nama lain.',
            'foto_denah.image' => 'File harus berupa gambar.',
            'foto_denah.max'   => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Proses unggah foto
        if ($request->hasFile('foto_denah')) {
            $data['foto_denah'] = $request->file('foto_denah')->store('zonas', 'public');
        }

        // kapasitas_total dihapus dari form, dihitung otomatis dari baris
        $data['kapasitas_total'] = 0;

        ZonaParkir::create($data);
        return back()->with('success', 'Zona baru berhasil diresmikan! Silakan tambahkan baris-barisnya.');
    }

    // Menampilkan halaman Edit / Manajemen Baris untuk 1 zona
    public function edit(ZonaParkir $zona)
    {
        $zona->load('baris.kendaraan');
        $warnaList = self::WARNA_LIST;
        return view('admin.zona.editzona', compact('zona', 'warnaList'));
    }

    // Menyimpan perubahan (Update) ke Database
    public function update(Request $request, ZonaParkir $zona)
    {
        $data = $request->validate([
            'nama_zona'  => 'required|string|max:20|unique:zona_parkirs,nama_zona,' . $zona->id,
            'keterangan' => 'nullable|string|max:100',
            'kode_warna' => 'required|string|max:7',
            'foto_denah' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('foto_denah')) {
            // Hapus file lama jika ada
            if ($zona->foto_denah) {
                Storage::disk('public')->delete($zona->foto_denah);
            }
            $data['foto_denah'] = $request->file('foto_denah')->store('zonas', 'public');
        }

        $zona->update($data);
        return redirect()->route('admin.zona.edit', $zona)->with('success', 'Data Zona berhasil diperbarui!');
    }

    // Menghancurkan Zona (Delete)
    public function destroy(ZonaParkir $zona)
    {
        if ($zona->kendaraan()->count() > 0) {
            return back()->with('error', 'PEMBATALAN! Area ini sedang ditempati kendaraan siswa. Kosongkan dulu!');
        }

        // Hapus foto jika ada
        if ($zona->foto_denah) {
            Storage::disk('public')->delete($zona->foto_denah);
        }

        // Hapus semua baris dulu (cascade akan otomatis tapi eksplisit lebih aman)
        $zona->baris()->delete();
        $zona->delete();
        return back()->with('success', 'Area parkir beserta seluruh barisnya telah dihapus!');
    }

    // ===================== CRUD BARIS =====================

    // Tambah Baris Baru ke dalam sebuah Zona
    public function storeBaris(Request $request, ZonaParkir $zona)
    {
        $request->validate([
            'nama_baris' => 'required|string|max:30',
            'kapasitas'  => 'required|integer|min:1|max:999',
        ], [
            'nama_baris.unique' => 'Nama baris ini sudah ada di zona ini.',
        ]);

        // Cek duplikat di zona yang sama
        $exists = BarisZona::where('id_zona', $zona->id)
                           ->where('nama_baris', $request->nama_baris)
                           ->exists();
        if ($exists) {
            return back()->with('error', "Baris \"{$request->nama_baris}\" sudah ada di Zona {$zona->nama_zona}!");
        }

        // Bangun syarat_filter JSON dari input form
        $syarat = $this->buildSyaratFilter($request);

        BarisZona::create([
            'id_zona'        => $zona->id,
            'nama_baris'     => $request->nama_baris,
            'kapasitas'      => $request->kapasitas,
            'syarat_filter'  => !empty($syarat) ? $syarat : null,
        ]);

        return back()->with('success', "Baris \"{$request->nama_baris}\" (kapasitas {$request->kapasitas} motor) berhasil ditambahkan ke Zona {$zona->nama_zona}!");
    }

    // Update satu Baris (kapasitas / nama)
    public function updateBaris(Request $request, ZonaParkir $zona, BarisZona $baris)
    {
        $request->validate([
            'nama_baris' => 'required|string|max:30',
            'kapasitas'  => 'required|integer|min:1|max:999',
        ]);

        // Pastikan baris ini milik zona yang benar
        if ($baris->id_zona !== $zona->id) {
            return back()->with('error', 'Aksi tidak valid!');
        }

        $syarat = $this->buildSyaratFilter($request);

        $baris->update([
            'nama_baris'     => $request->nama_baris,
            'kapasitas'      => $request->kapasitas,
            'syarat_filter'  => !empty($syarat) ? $syarat : null,
        ]);

        return back()->with('success', "Baris \"{$baris->nama_baris}\" berhasil diperbarui!");
    }

    // Hapus satu Baris
    public function destroyBaris(ZonaParkir $zona, BarisZona $baris)
    {
        if ($baris->id_zona !== $zona->id) {
            return back()->with('error', 'Aksi tidak valid!');
        }

        if ($baris->kendaraan()->count() > 0) {
            return back()->with('error', "GAGAL! Baris \"{$baris->nama_baris}\" masih ditempati {$baris->terisi} kendaraan. Pindahkan dulu!");
        }

        $namaBaris = $baris->nama_baris;
        $baris->delete();
        return back()->with('success', "Baris \"{$namaBaris}\" berhasil dihapus!");
    }

    // API: Ambil daftar baris berdasarkan zona (untuk dynamic dropdown di halaman kendaraan)
    public function getBarisOptions(ZonaParkir $zona)
    {
        $barisList = $zona->baris()->orderBy('id')->select('id', 'nama_baris', 'kapasitas')
                          ->withCount('kendaraan')
                          ->get();

        // Hitung slot_awal dan slot_akhir secara kumulatif berdasarkan urutan baris
        $kumulatif = 0;
        $result = $barisList->map(function ($b) use (&$kumulatif) {
            $slotAwal  = $kumulatif + 1;
            $slotAkhir = $kumulatif + $b->kapasitas;
            $kumulatif = $slotAkhir;

            // Buat label aturan yang mudah dibaca
            $aturanLabel = '';
            if ($b->syarat_filter) {
                $parts = [];
                if (!empty($b->syarat_filter['warna'])) $parts[] = implode('/', $b->syarat_filter['warna']);
                if (!empty($b->syarat_filter['transmisi'])) $parts[] = $b->syarat_filter['transmisi'];
                if (!empty($parts)) $aturanLabel = implode(', ', $parts);
            }

            return [
                'id'            => $b->id,
                'nama_baris'    => $b->nama_baris,
                'kapasitas'     => $b->kapasitas,
                'terisi'        => $b->kendaraan_count,
                'sisa'          => max(0, $b->kapasitas - $b->kendaraan_count),
                'slot_awal'     => $slotAwal,
                'slot_akhir'    => $slotAkhir,
                'syarat_filter' => $b->syarat_filter,
                'aturan_label'  => $aturanLabel,
            ];
        });

        return response()->json($result);
    }

    // Helper: Bangun array syarat_filter dari request form
    private function buildSyaratFilter(Request $request): array
    {
        $syarat = [];

        if ($request->filled('syarat_warna')) {
            $syarat['warna'] = array_filter((array) $request->syarat_warna);
        }
        if ($request->filled('syarat_transmisi') && $request->syarat_transmisi !== '') {
            $syarat['transmisi'] = $request->syarat_transmisi;
        }

        return $syarat;
    }
}
