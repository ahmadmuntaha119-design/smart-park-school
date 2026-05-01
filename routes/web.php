<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

// Halaman Utama / Landing Page
Route::get('/', function () {
    return view('welcome');
});

// -----------------------------------------------------
// WILAYAH BEBAS (Hanya untuk tamu yang belum login)
// -----------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin']);
    
    // Jalur Registrasi Mandiri Siswa Baru
    Route::get('/daftar', [\App\Http\Controllers\Registrasi\RegistrasiController::class, 'showForm'])->name('daftar');
    Route::post('/daftar', [\App\Http\Controllers\Registrasi\RegistrasiController::class, 'processForm']);

});

// -----------------------------------------------------
// WILAYAH TERTUTUP (Harus punya tiket masuk / session Auth)
// -----------------------------------------------------
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // Rute Ganti Password (Harus login dulu, tapi belum masuk ke polisi 'force.password')
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('password.change.show');
    Route::post('/change-password', [AuthController::class, 'processChangePassword'])->name('password.change.process');
    
    // (Jalur Ganti Password akan ditaruh di sini nanti)

    // Melewati gerbang Polisi "Paksa Ganti Password"
    Route::middleware('force.password')->group(function () {
        
        // ---- WILAYAH KHUSUS ADMIN PKS ----
        // Melewati gerbang Polisi "Role:Admin"
        Route::middleware('role:Admin')->prefix('admin')->group(function () {
            
            // RUANGAN ABSOLUT ADMIN PKS
            Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

            // RUANGAN MANAJEMEN WHITELIST
            Route::get('/whitelist', [\App\Http\Controllers\Admin\NisWhitelistController::class, 'index'])->name('admin.whitelist.index');
            Route::post('/whitelist/import', [\App\Http\Controllers\Admin\NisWhitelistController::class, 'import'])->name('admin.whitelist.import');
            Route::get('/whitelist/export', [\App\Http\Controllers\Admin\NisWhitelistController::class, 'export'])->name('admin.whitelist.export');
            Route::delete('/whitelist/destroy-all', [\App\Http\Controllers\Admin\NisWhitelistController::class, 'destroyAll'])->name('admin.whitelist.destroyAll');

            // MANAJEMEN ZONA PAKAI JURUS RESOURCE AUTOMATIC
            Route::resource('zona', \App\Http\Controllers\Admin\ZonaController::class, ['as' => 'admin'])->except(['show', 'create']);

            // CRUD BARIS di dalam Zona (nested resource)
            Route::post('/zona/{zona}/baris', [\App\Http\Controllers\Admin\ZonaController::class, 'storeBaris'])->name('admin.zona.baris.store');
            Route::put('/zona/{zona}/baris/{baris}', [\App\Http\Controllers\Admin\ZonaController::class, 'updateBaris'])->name('admin.zona.baris.update');
            Route::delete('/zona/{zona}/baris/{baris}', [\App\Http\Controllers\Admin\ZonaController::class, 'destroyBaris'])->name('admin.zona.baris.destroy');

            // API: Ambil daftar baris (untuk AJAX dropdown di halaman kendaraan)
            Route::get('/zona/{zona}/baris-options', [\App\Http\Controllers\Admin\ZonaController::class, 'getBarisOptions'])->name('admin.zona.baris.options');
        
            // MANAJEMEN KENDARAAN (FITUR RAKSASA)
            Route::get('/kendaraan', [\App\Http\Controllers\Admin\KendaraanController::class, 'index'])->name('admin.kendaraan.index');
            Route::post('/kendaraan/bulk-assign', [\App\Http\Controllers\Admin\KendaraanController::class, 'bulkAssign'])->name('admin.kendaraan.bulkAssign');
            Route::delete('/kendaraan/hapus-angkatan', [\App\Http\Controllers\Admin\KendaraanController::class, 'destroyAngkatan'])->name('admin.kendaraan.hapusAngkatan');
            Route::put('/kendaraan/{kendaraan}', [\App\Http\Controllers\Admin\KendaraanController::class, 'update'])->name('admin.kendaraan.update');
            Route::delete('/kendaraan/{kendaraan}', [\App\Http\Controllers\Admin\KendaraanController::class, 'destroy'])->name('admin.kendaraan.destroy');

            // PUSAT PENYIARAN BARANG TEMUAN (LOST & FOUND)
            Route::get('/lost-found', [\App\Http\Controllers\Admin\LostFoundController::class, 'index'])->name('admin.lost-found.index');
            Route::post('/lost-found', [\App\Http\Controllers\Admin\LostFoundController::class, 'store'])->name('admin.lost-found.store');
            Route::delete('/lost-found/{barang}', [\App\Http\Controllers\Admin\LostFoundController::class, 'destroy'])->name('admin.lost-found.destroy');

            // RADAR MONITORING ABSENSI HARIAN
            Route::get('/absensi-harian', [\App\Http\Controllers\Admin\AbsensiController::class, 'index'])->name('admin.absensi.index');

        
        });

        // ---- WILAYAH KHUSUS SISWA ----
        // Melewati gerbang Polisi "Role:Siswa"
        Route::middleware('role:Siswa')->prefix('siswa')->name('siswa.')->group(function () {
            
            // RUANGAN KHUSUS SISWA (DASHBOARD & ABSENSI)
            Route::get('/dashboard', [\App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('dashboard');
            Route::post('/checkin', [\App\Http\Controllers\Siswa\DashboardController::class, 'checkIn'])->name('checkin');
            Route::post('/checkout', [\App\Http\Controllers\Siswa\DashboardController::class, 'checkOut'])->name('checkout');

            // PANDUAN PARKIR SISWA
            Route::get('/panduan', function () {
                return view('siswa.panduan');
            })->name('panduan');

            // PROFIL SISWA
            Route::get('/profil', [\App\Http\Controllers\Siswa\ProfilController::class, 'index'])->name('profil');
            Route::post('/profil/update-kelas', [\App\Http\Controllers\Siswa\ProfilController::class, 'updateKelas'])->name('profil.updateKelas');
            Route::post('/profil/update-password', [\App\Http\Controllers\Siswa\ProfilController::class, 'updatePassword'])->name('profil.updatePassword');

        });

    });
});
