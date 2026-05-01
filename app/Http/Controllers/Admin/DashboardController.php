<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\ZonaParkir;
use App\Models\AbsensiParkir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Tarik semua data zona + hitung kendaraan tiap zona
        $zonas = ZonaParkir::withCount('kendaraan')->get();

        // 2. Total kendaraan terdaftar
        $totalKendaraan = Kendaraan::count();

        // 3. Siswa belum dapat zona
        $totalPendingZona = Kendaraan::whereNull('id_zona')->count();

        // 4. Data grafik: jumlah motor yang parkir per hari (7 hari terakhir)
        $chartData = collect();
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $jumlah = AbsensiParkir::whereDate('tanggal', $tanggal)->count();
            $chartData->push([
                'tanggal' => $tanggal->translatedFormat('d M'),
                'jumlah'  => $jumlah,
            ]);
        }

        $chartLabels = $chartData->pluck('tanggal')->toJson();
        $chartValues = $chartData->pluck('jumlah')->toJson();

        // 5. Jumlah motor yang parkir HARI INI
        $totalHariIni = AbsensiParkir::whereDate('tanggal', today())->count();

        return view('admin.dashboard', compact(
            'zonas', 'totalKendaraan', 'totalPendingZona',
            'chartLabels', 'chartValues', 'totalHariIni'
        ));
    }
}
