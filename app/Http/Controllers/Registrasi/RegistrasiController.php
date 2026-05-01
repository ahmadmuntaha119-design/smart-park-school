<?php

namespace App\Http\Controllers\Registrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MerekMotor;
use App\Services\RegistrasiService;

class RegistrasiController extends Controller
{
    protected $registrasiService;

    // Menyambungkan Controller dengan Mesin Pabrik tadi
    public function __construct(RegistrasiService $registrasiService)
    {
        $this->registrasiService = $registrasiService;
    }

    // Tampilkan formulir pendaftaran
    public function showForm()
    {
        // Lempar data merek motor ke tampilan agar bisa dipilih di dropdown
        $merekMotors = MerekMotor::all();

        // Template Data Dummy untuk 40 Motor Terpopuler di Indonesia
        $tipeMotors = [
            // HONDA
            'Beat', 'Vario', 'Scoopy', 'PCX', 'ADV', 'Supra X', 'Supra GTR', 'Revo', 'Blade', 
            'CBR150R', 'CBR250RR', 'CB150R', 'Sonic', 'CRF150L', 'Genio', 'Spacy', 'MegaPro', 'Verza',
            // YAMAHA
            'NMAX', 'Aerox', 'Lexi', 'Mio', 'Fino', 'Fazzio', 'Grand Filano', 'Gear 125', 
            'Vixion', 'R15', 'R25', 'MT-15', 'MT-25', 'XSR 155', 'WR155R', 'Jupiter Z1', 'MX King', 'Vega Force',
            // SUZUKI & KAWASAKI & LAINNYA
            'Satria F150', 'GSX-R150', 'Nex II', 'Address', 'Smash',
            'Ninja 250', 'KLX 150', 'W175',
            'Vespa Sprint', 'Vespa Primavera', 'Vespa LX'
        ];
        sort($tipeMotors); // Urutkan sesuai abjad A-Z

        $warnaList = [
            'Hitam', 'Putih', 'Merah', 'Biru', 'Hijau', 'Silver', 
            'Abu-abu', 'Coklat', 'Orange', 'Kuning', 'Pink', 'Ungu'
        ];

        return view('registrasi.index', compact('merekMotors', 'tipeMotors', 'warnaList'));
    }

    // Tangkap data isian siswa
    public function processForm(Request $request)
    {
        // 1. Validasi tidak boleh ada yang kosong
        $data = $request->validate([
            'nis'                 => ['required', 'string'],
            'kelas'               => ['required', 'string', 'max:20'],
            'id_merek'            => ['required', 'exists:merek_motors,id'],
            'model_motor'         => ['required', 'string', 'max:50'],
            'model_motor_custom'  => ['nullable', 'string', 'max:50'],
            'warna'               => ['required', 'string', 'max:50'],
            'warna_custom'        => ['nullable', 'string', 'max:50'],
            'jenis_transmisi'     => ['required', 'in:Matic,Manual'],
            'plat_nomor'          => ['required', 'string', 'max:15'],
        ]);

        // Jika memilih "Lainnya", ambil dari input custom
        if ($data['model_motor'] === 'Lainnya' && !empty($data['model_motor_custom'])) {
            $data['model_motor'] = $data['model_motor_custom'];
        }
        if ($data['warna'] === 'Lainnya' && !empty($data['warna_custom'])) {
            $data['warna'] = $data['warna_custom'];
        }

        try {
            // 2. Suruh Mesin Pabrik untuk memproses pendaftarannya
            $user = $this->registrasiService->daftar($data);

            // 3. Loginkan siswa secara otomatis
            \Illuminate\Support\Facades\Auth::login($user);

            // 4. Arahkan ke dashboard (Sistem Polisi akan otomatis membelokkannya ke halaman Ganti Password!)
            return redirect()->route('siswa.dashboard')->with('success', 'Pendaftaran sukses! Silakan ganti password default Anda.');

        } catch (\Exception $e) {
            // 4. Kalau gagal (Misal: NIS Bodong), balikkan ke halaman daftar bawa pesan error
            return back()->withErrors(['nis' => $e->getMessage()])->withInput();
        }
    }
}
