<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Kendaraan;
use App\Models\AbsensiParkir;
use App\Models\BarangTemuan;

class DashboardController extends Controller
{
    // ─────────────────────────────────────────────
    // KONFIGURASI GEOFENCING SEKOLAH
    // Ganti koordinat ini sesuai lokasi persis sekolah
    // ─────────────────────────────────────────────
    const SEKOLAH_LAT    = -7.653837;   // Latitude  
    const SEKOLAH_LNG    = 109.663689;  // Longitude 
    const RADIUS_MASUK   = 200;       // Radius check-in  (meter dari pusat sekolah)

    // ─────────────────────────────────────────────
    // 1. LAYAR UTAMA SISWA
    // ─────────────────────────────────────────────
    public function index()
    {
        $user = Auth::user();

        $kendaraan = $user->kendaraan()->with(['zona', 'merek'])->first();

        $absensiHariIni = AbsensiParkir::where('id_user', $user->id)
            ->whereDate('tanggal', today())
            ->first();

        $pengumuman = BarangTemuan::where('status', 'Belum Diambil')->latest()->get();

        return view('siswa.dashboard', compact('user', 'kendaraan', 'absensiHariIni', 'pengumuman'));
    }

    // ─────────────────────────────────────────────
    // 2. CHECK-IN PARKIR (Dengan Validasi GPS & Simpan Foto)
    // ─────────────────────────────────────────────
    public function checkIn(Request $request)
    {
        $userId = Auth::id();

        // === VALIDASI: Cegah double check-in ===
        $existing = AbsensiParkir::where('id_user', $userId)
            ->whereDate('tanggal', today())
            ->first();

        if ($existing) {
            return back()->with('error', 'Kamu sudah tercatat absen masuk hari ini!');
        }

        // === VALIDASI GPS (jika koordinat dikirim) ===
        $lat      = $request->input('latitude');
        $lng      = $request->input('longitude');
        $jarak    = null;

        if (!$lat || !$lng) {
            return back()->with('error', 'Gagal Absen! Sistem tidak dapat melacak koordinat GPS Anda. Pastikan fitur Lokasi (GPS) aktif di HP dan Anda mengizinkan browser mengakses lokasi.');
        }

        $jarak = $this->hitungJarak(
            self::SEKOLAH_LAT, self::SEKOLAH_LNG,
            (float) $lat, (float) $lng
        );

        // Tolak jika lebih dari 200 meter dari sekolah
        if ($jarak > self::RADIUS_MASUK) {
            $jarakFormatted = number_format($jarak, 0, ',', '.');
            return back()->with('error',
                "Gagal Absen! Posisimu {$jarakFormatted} meter dari sekolah. " .
                "Kamu wajib berada di dalam area parkir sekolah (maks. " . self::RADIUS_MASUK . "m)."
            );
        }

        // === SIMPAN ABSENSI ===
        AbsensiParkir::create([
            'id_user'           => $userId,
            'tanggal'           => today(),
            'waktu_masuk'       => now(),
            'latitude_masuk'    => $lat,
            'longitude_masuk'   => $lng,
            'jarak_dari_sekolah' => $jarak ? (int) $jarak : null,
        ]);

        $pesanLokasi = $jarak
            ? " Posisi terverifikasi ✓ (" . number_format($jarak, 0, ',', '.') . "m dari gerbang)"
            : "";

        return back()->with('success', "Absen Parkir Berhasil!{$pesanLokasi} Semangat belajarnya! 🚀");
    }

    // ─────────────────────────────────────────────
    // 3. CHECK-OUT PARKIR
    // ─────────────────────────────────────────────
    public function checkOut(Request $request)
    {
        $absensi = AbsensiParkir::where('id_user', Auth::id())
            ->whereDate('tanggal', today())
            ->first();

        if ($absensi && null === $absensi->waktu_keluar) {
            $absensi->update(['waktu_keluar' => now()]);
            return back()->with('success', 'Selamat pulang! Hati-hati di jalan ya 🙏');
        }

        return back()->with('error', 'Terjadi kesalahan sistem absensi.');
    }

    // ─────────────────────────────────────────────
    // PRIVATE: Formula Haversine
    // Menghitung jarak antara 2 koordinat di permukaan bumi
    // ─────────────────────────────────────────────
    private function hitungJarak(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $R    = 6371000; // Radius bumi dalam meter
        $phi1 = deg2rad($lat1);
        $phi2 = deg2rad($lat2);
        $dPhi = deg2rad($lat2 - $lat1);
        $dLam = deg2rad($lng2 - $lng1);

        $a = sin($dPhi / 2) ** 2
            + cos($phi1) * cos($phi2) * sin($dLam / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($R * $c); // Hasil dalam meter
    }
}
