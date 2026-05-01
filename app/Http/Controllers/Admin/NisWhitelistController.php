<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NisWhitelist;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\NisWhitelistImport;

class NisWhitelistController extends Controller
{
    // Menampilkan layar utama Daftar NIS
    public function index()
    {
        $whitelists = NisWhitelist::latest()->get();
        
        // Hitung statistik singkat untuk Admin
        $total = $whitelists->count();
        $sudahDaftar = $whitelists->where('sudah_daftar', true)->count();
        $belumDaftar = $whitelists->where('sudah_daftar', false)->count();

        return view('admin.whitelist.index', compact('whitelists', 'total', 'sudahDaftar', 'belumDaftar'));
    }

    // Memproses Data Excel yang baru masuk
    public function import(Request $request)
    {
        // 1. Validasi: file harus format excel/csv dan maksimal 2MB
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:2048'
        ], [
            'file_excel.mimes' => 'Format salah! File harus berupa Excel (.xlsx, .xls) atau CSV.'
        ]);

        try {
            // 2. Suruh Mesin Excel membaca filenya (NisWhitelistImport belum kita buat, nanti di bawah)
            Excel::import(new NisWhitelistImport, $request->file('file_excel'));
            return back()->with('success', 'Ratusan Data NIS sukses di-import sekejap mata!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import! Pastikan baris paling atas Excel bernama (nis) dan (nama). Error detail: ' . $e->getMessage());
        }
    }

    // Menghapus data NIS cadangan jika angkatan sudah lulus
    public function destroyAll()
    {
        // Kita hanya menghapus yang BELUM daftar saja, agar data yang sudah kepakai tidak rusak
        NisWhitelist::where('sudah_daftar', false)->delete();
        return back()->with('success', 'Data NIS Whitelist bersih-bersih sukses!');
    }

    // Export Data Laporan Whitelist
    public function export()
    {
        return Excel::download(new \App\Exports\NisWhitelistExport, 'Laporan_Data_Whitelist_' . date('Y-m-d') . '.xlsx');
    }
}
