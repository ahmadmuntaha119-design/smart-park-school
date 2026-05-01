<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarisZona;
use App\Models\Kendaraan;
use App\Models\MerekMotor;
use App\Models\ZonaParkir;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    // Daftar warna standar untuk filter & form
    const WARNA_LIST = [
        'Hitam', 'Putih', 'Merah', 'Biru', 'Hijau', 'Silver',
        'Abu-abu', 'Coklat', 'Orange', 'Kuning', 'Pink', 'Ungu', 'Lainnya'
    ];

    // 1. Tampilkan Halaman Utama Manajemen dengan Filter Multi-Level
    public function index(Request $request)
    {
        $semuaZona  = ZonaParkir::with('baris')->orderBy('nama_zona')->get();
        $mereks     = MerekMotor::orderBy('nama_merek')->get();
        $warnaList  = self::WARNA_LIST;

        // --- Query Filter ---
        $query = Kendaraan::with(['user', 'zona', 'merek', 'baris']);

        if ($request->filled('filter_merek')) {
            $query->where('id_merek', $request->filter_merek);
        }
        if ($request->filled('filter_model')) {
            $query->where('model_motor', 'LIKE', '%' . $request->filter_model . '%');
        }
        if ($request->filled('filter_warna')) {
            $query->where('warna', $request->filter_warna);
        }
        if ($request->filled('filter_transmisi')) {
            $query->where('jenis_transmisi', $request->filter_transmisi);
        }
        if ($request->filled('filter_zona')) {
            $query->where('id_zona', $request->filter_zona);
        }
        if ($request->filter_status === 'belum_assign') {
            $query->whereNull('id_zona');
        } elseif ($request->filter_status === 'sudah_assign') {
            $query->whereNotNull('id_zona');
        }

        $kendaraans = $query->latest()->get();

        return view('admin.kendaraan.indexkendaraan', compact(
            'kendaraans', 'semuaZona', 'mereks', 'warnaList'
        ));
    }

    // 2. Beri Zona & Baris Massal (Bulk Assign ke Baris)
    public function bulkAssign(Request $request)
    {
        $request->validate([
            'id_zona'       => 'required|exists:zona_parkirs,id',
            'id_baris'      => 'required|exists:baris_parkirs,id',
            'kendaraan_ids' => 'required|array',
        ]);

        $zona           = ZonaParkir::findOrFail($request->id_zona);
        
        // --- Dedup ID (karena front-end berpotensi mengirim ganda dari tampilan mobile/desktop) ---
        $uniqueIds       = array_unique($request->kendaraan_ids);
        $jumlahDicentang = count($uniqueIds);

        // --- Validasi Baris ---
        $baris = BarisZona::findOrFail($request->id_baris);

        if ($baris->id_zona != $zona->id) {
            return back()->with('error', 'Baris yang dipilih tidak sesuai dengan zona!');
        }

        if ($baris->sisa_slot < $jumlahDicentang) {
            return back()->with('error', "GAGAL! Baris {$baris->nama_baris} hanya sisa {$baris->sisa_slot} slot kosong, sementara kamu memilih {$jumlahDicentang} motor.");
        }

        // --- Hitung Range Slot Otomatis untuk Baris ini ---
        // Range slot per baris = kumulatif kapasitas baris sebelumnya + 1 s.d. kumulatif baris ini
        $semuaBaris = BarisZona::where('id_zona', $zona->id)->orderBy('id')->get();
        $slotAwal   = 1;
        foreach ($semuaBaris as $b) {
            if ($b->id === $baris->id) break;
            $slotAwal += $b->kapasitas;
        }
        $slotAkhir = $slotAwal + $baris->kapasitas - 1;

        // --- Auto-Finder: Cari slot KOSONG dalam range ---
        // Ambil semua nomor slot yang sudah terisi di zona ini dalam range baris ini
        $slotTerisi = Kendaraan::where('id_zona', $zona->id)
                               ->whereBetween('nomor_slot', [$slotAwal, $slotAkhir])
                               ->pluck('nomor_slot')
                               ->toArray();

        // Temukan slot-slot kosong dalam range
        $slotKosong = [];
        for ($i = $slotAwal; $i <= $slotAkhir && count($slotKosong) < $jumlahDicentang; $i++) {
            if (!in_array($i, $slotTerisi)) {
                $slotKosong[] = $i;
            }
        }

        if (count($slotKosong) < $jumlahDicentang) {
            return back()->with('error', "GAGAL! Hanya ada " . count($slotKosong) . " petak kosong tersisa di {$baris->nama_baris} (Petak {$slotAwal}–{$slotAkhir}). Kamu memilih {$jumlahDicentang} motor.");
        }

        // --- RULE ENGINE: Validasi Aturan Baris ---
        if ($baris->syarat_filter && !empty($baris->syarat_filter)) {
            $kendaraanCek = Kendaraan::whereIn('id', $uniqueIds)->get();
            $pelanggar = [];

            foreach ($kendaraanCek as $kend) {
                $alasan = [];

                // Cek aturan warna
                if (!empty($baris->syarat_filter['warna'])) {
                    $warnaAllowed = array_map('strtolower', $baris->syarat_filter['warna']);
                    if (!in_array(strtolower($kend->warna ?? ''), $warnaAllowed)) {
                        $alasan[] = "Warna: {$kend->warna}";
                    }
                }

                // Cek aturan transmisi
                if (!empty($baris->syarat_filter['transmisi'])) {
                    if (strtolower($kend->jenis_transmisi ?? '') !== strtolower($baris->syarat_filter['transmisi'])) {
                        $alasan[] = "Transmisi: {$kend->jenis_transmisi}";
                    }
                }

                if (!empty($alasan)) {
                    $pelanggar[] = "{$kend->plat_nomor} (" . implode(', ', $alasan) . ")";
                }
            }

            if (!empty($pelanggar)) {
                $aturanWarna = !empty($baris->syarat_filter['warna']) ? implode('/', $baris->syarat_filter['warna']) : '-';
                $aturanTrans = $baris->syarat_filter['transmisi'] ?? '-';
                $listMasalah = implode(', ', $pelanggar);
                return back()->with('error', "DITOLAK oleh Aturan {$baris->nama_baris}! Syarat: Warna [{$aturanWarna}] + Transmisi [{$aturanTrans}]. Motor yang melanggar: {$listMasalah}");
            }
        }

        // --- Eksekusi Assign Data ---
        $kendaraans  = Kendaraan::whereIn('id', $uniqueIds)->get();
        $slotCounter = 0;

        foreach ($kendaraans as $k) {
            /** @var \App\Models\Kendaraan $k */
            $k->update([
                'id_zona'    => $zona->id,
                'id_baris'   => $baris->id,
                'nomor_slot' => $slotKosong[$slotCounter],
            ]);
            $slotCounter++;
        }

        $slotDigunakan = $slotKosong[0] . '–' . end($slotKosong);
        return back()->with('success', "{$jumlahDicentang} kendaraan berhasil diparkir di Zona {$zona->nama_zona} – {$baris->nama_baris} (Petak {$slotDigunakan})!");
    }

    // 3. Hapus Seluruh Siswa Berdasarkan Nama Kelas
    public function destroyAngkatan(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|min:1|max:50',
        ]);

        $namaKelas   = trim($request->nama_kelas);
        $kendaraanIds = Kendaraan::where('kelas', 'LIKE', "%{$namaKelas}%")->pluck('id_user');

        if ($kendaraanIds->isEmpty()) {
            return back()->with('error', "Tidak ditemukan kendaraan dengan kelas \"{$namaKelas}\".");
        }

        $siswaIds    = \App\Models\User::whereIn('id', $kendaraanIds)->where('role', 'Siswa')->pluck('id');
        
        // --- LOGIKA BARU: Hapus permanen data dari Whitelist agar tidak jadi "sampah"
        $nisList = \App\Models\User::whereIn('id', $siswaIds)->pluck('nis_nip')->toArray();
        if (!empty($nisList)) {
            \App\Models\NisWhitelist::whereIn('nis', $nisList)->delete();
        }

        $jumlahMotor = Kendaraan::whereIn('id_user', $siswaIds)->count();
        Kendaraan::whereIn('id_user', $siswaIds)->delete();
        
        $jumlahSiswa = $siswaIds->count();
        \App\Models\User::whereIn('id', $siswaIds)->delete();

        return back()->with('success', "Berhasil! {$jumlahSiswa} siswa dan {$jumlahMotor} motor dari kelas \"{$namaKelas}\" telah dihapus secara permanen beserta data Whitelist-nya.");
    }

    // 4. Update Edit Individu
    public function update(Request $request, Kendaraan $kendaraan)
    {
        $request->validate([
            'kelas'            => 'required|string|max:50',
            'id_merek'         => 'required|exists:merek_motors,id',
            'model_motor'      => 'required|string|max:100',
            'warna'            => 'nullable|string|max:50',
            'jenis_transmisi'  => 'nullable|in:Matic,Manual',
            'plat_nomor'       => 'required|string|max:15|unique:kendaraans,plat_nomor,' . $kendaraan->id,
            'id_zona'          => 'nullable|exists:zona_parkirs,id',
            'id_baris'         => 'nullable|exists:baris_parkirs,id',
            'nomor_slot'       => 'nullable|integer|min:1',
        ]);

        if ($request->filled('nomor_slot') && $request->filled('id_zona')) {
            $isConflict = Kendaraan::where('id_zona', $request->id_zona)
                                   ->where('nomor_slot', $request->nomor_slot)
                                   ->where('id', '!=', $kendaraan->id)
                                   ->exists();
            if ($isConflict) {
                return back()->with('error', "GAGAL! Slot nomor {$request->nomor_slot} di Zona tersebut sudah diisi motor lain.");
            }
        }

        $kendaraan->update([
            'kelas'           => $request->kelas,
            'id_merek'        => $request->id_merek,
            'model_motor'     => $request->model_motor,
            'warna'           => $request->warna,
            'jenis_transmisi' => $request->jenis_transmisi,
            'plat_nomor'      => $request->plat_nomor,
            'id_zona'         => $request->id_zona,
            'id_baris'        => $request->id_baris,
            'nomor_slot'      => $request->nomor_slot,
        ]);

        return back()->with('success', "Data motor plat {$kendaraan->plat_nomor} berhasil direvisi Admin!");
    }

    // 5. Hapus Individu (Reset Motor & Akun)
    public function destroy(Kendaraan $kendaraan)
    {
        $namaSiswa = $kendaraan->user->nama_lengkap ?? 'Tanpa Nama';
        $userId    = $kendaraan->id_user;
        $nis       = $kendaraan->user->nis_nip ?? null;

        // --- Perbarui Data Whitelist agar NIS bisa dipakai daftar ulang
        if ($nis) {
            \App\Models\NisWhitelist::where('nis', $nis)->update(['sudah_daftar' => false]);
        }

        $kendaraan->delete();
        
        // --- Hapus seluruh otorisasi user (loginnya lenyap) agar ia bisa mendaftar dari 0 lagi
        if ($userId) {
            \App\Models\User::where('id', $userId)->delete();
        }

        return back()->with('success', "Izin untuk {$namaSiswa} berhasil dicabut. Akunnya telah direset sehingga dapat digunakan untuk pendaftaran ulang dari awal.");
    }
}
