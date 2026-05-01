<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AbsensiParkir;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        // Secara default radar menyorot HARI INI
        // Tapi kalau Admin memilih tanggal kemarin dari filter, radar akan menyesuaikan
        $tanggalPilihan = $request->tanggal ?? today()->toDateString();

        // Tarik semua jejak parkir pada tanggal tersebut
        // Relasi berantai beraksi: Absensi -> User -> Kendaraannya -> Zonanya!
        $absensis = AbsensiParkir::with(['user.kendaraan.zona'])
            ->whereDate('tanggal', $tanggalPilihan)
            ->latest('waktu_masuk') // Yang baru datang taruh paling atas
            ->get();

        // Hitung Statistik Kilat
        $totalMasuk = $absensis->count();
        $totalMasihParkir = $absensis->whereNull('waktu_keluar')->count();
        $totalSudahPulang = $absensis->whereNotNull('waktu_keluar')->count();

        return view('admin.absensi.indexabsensi', compact(
            'absensis', 'tanggalPilihan', 'totalMasuk', 'totalMasihParkir', 'totalSudahPulang'
        ));
    }
}
