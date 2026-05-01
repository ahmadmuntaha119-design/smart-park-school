<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user      = Auth::user();
        $kendaraan = $user->kendaraan; // bisa null kalau belum daftar

        return view('siswa.profil', compact('user', 'kendaraan'));
    }

    /**
     * Update kelas siswa (disimpan di tabel kendaraans).
     * Format bebas: "X TKJ 1", "XI PPLG 2", "XII AKL 3", dll.
     * Field ini yang dipakai admin saat hapus massal per angkatan.
     */
    public function updateKelas(Request $request)
    {
        $request->validate([
            'tingkat' => ['required', 'in:X,XI,XII'],
            'jurusan' => ['required', 'string', 'max:30'],
            'rombel'  => ['nullable', 'integer', 'min:1', 'max:10'],
        ], [
            'tingkat.required' => 'Tingkat kelas wajib dipilih.',
            'tingkat.in'       => 'Tingkat kelas hanya boleh X, XI, atau XII.',
            'jurusan.required' => 'Jurusan wajib diisi.',
            'jurusan.max'      => 'Nama jurusan maksimal 30 karakter.',
        ]);

        $kendaraan = Auth::user()->kendaraan;

        if (!$kendaraan) {
            return back()->with('error_kelas', 'Kendaraan belum terdaftar. Silakan daftar terlebih dahulu.');
        }

        // Bentuk string kelas: "XII PPLG 1" atau "X TKJ" (tanpa rombel)
        $kelasString = $request->tingkat . ' ' . strtoupper(trim($request->jurusan));
        if ($request->filled('rombel')) {
            $kelasString .= ' ' . $request->rombel;
        }

        $kendaraan->kelas = $kelasString;
        $kendaraan->save();

        return back()->with('success_kelas', "Kelas berhasil diperbarui menjadi \"{$kelasString}\".");
    }

    /**
     * Ganti password siswa dari halaman profil.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama'              => ['required'],
            'password_baru'              => ['required', 'min:6', 'confirmed'],
            'password_baru_confirmation' => ['required'],
        ], [
            'password_lama.required'             => 'Password lama wajib diisi.',
            'password_baru.required'             => 'Password baru wajib diisi.',
            'password_baru.min'                  => 'Password baru minimal 6 karakter.',
            'password_baru.confirmed'            => 'Konfirmasi password tidak cocok.',
            'password_baru_confirmation.required'=> 'Konfirmasi password wajib diisi.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.'])->withInput();
        }

        $user->password = bcrypt($request->password_baru);
        $user->save();

        return back()->with('success_password', 'Password berhasil diubah.');
    }
}
