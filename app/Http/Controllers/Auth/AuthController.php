<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Menampilkan halaman form login
    public function showLogin()
    {
        // Jika orang tersebut ternyata sudah login, tendang langsung ke dashboard
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        
        return view('auth.login');
    }

    // 2. Mengecek kesesuaian NIS dan Password (Proses Login)
    public function processLogin(Request $request)
    {
        // Validasi input form (wajib diisi)
        $credentials = $request->validate([
            'nis_nip' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Coba cocokan dengan data di Gudang Database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Hindari hacker membajak sesi
            
            return $this->redirectBasedOnRole();
        }

        // Kalau gagal atau salah, paksa balik bawa pesan error warna merah
        return back()->withErrors([
            'nis_nip' => 'Maaf, NIS atau Password Anda salah.',
        ])->onlyInput('nis_nip');
    }

    // 3. Proses keluar dari sistem
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login'); // Lempar balik ke login
    }

        // --- TAMBAHKAN KODE INI ---
    
    // Menampilkan halaman form wajib ganti password
    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    // Memproses penggantian password ke database
    public function processChangePassword(Request $request)
    {
        // 1. Validasi: Password harus diisi, minimal 6 huruf, dan harus sama dengan kolom konfirmasi
        $request->validate([
            'password_baru' => ['required', 'min:6', 'confirmed'], 
        ], [
            'password_baru.min' => 'Password minimal harus 6 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // 2. Ambil data orang yang sedang memegang tiket session (Orang yang login saat ini)
        $user = Auth::user();
        
        // 3. Timpa password lamanya dengan password baru yang sudah dienkripsi (bcrypt)
        $user->password = bcrypt($request->password_baru);
        
        // 4. Ubah status "Login Pertama" menjadi false agar besok-besok polisinya mengizinkan dia lewat!
        $user->is_first_login = false; 
        $user->save();

        // 5. Tendang dia sesuai jabatannya
        return $this->redirectBasedOnRole();
    }



    // Helper: Mengarahkan rute sesuai jabatannya
    private function redirectBasedOnRole()
    {
        $role = Auth::user()->role;
        
        if ($role === 'Admin') {
            return redirect('/admin/dashboard');
        }
        
        return redirect('/siswa/dashboard');
    }
}
