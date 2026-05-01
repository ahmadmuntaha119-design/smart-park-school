<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangTemuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LostFoundController extends Controller
{
    // 1. Tampilkan layar pusat kendali barang temuan
    public function index()
    {
        $barangs = BarangTemuan::latest()->get();
        return view('admin.lost-found.indexlost', compact('barangs'));
    }

    // 2. Unggah Barang Baru + Foto (Otomatis Menyiarkan Banner ke Siswa)
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'lokasi_ditemukan' => 'required|string|max:100',
            'foto' => 'required|image|max:2048', // Maksimal 2MB, dan wajib berupa gambar (jpg/png)
        ]);

        // Simpan fotonya ke dalam folder storage/app/public/lost-found
        $path = $request->file('foto')->store('lost-found', 'public');

        BarangTemuan::create([
            'id_admin' => Auth::id(), // Rekam ID Admin PKS yang melaporkan
            'nama_barang' => $request->nama_barang,
            'lokasi_ditemukan' => $request->lokasi_ditemukan,
            'path_foto' => $path,
            'status' => 'Belum Diambil', // Status awal pasti belum diambil
        ]);

        return back()->with('success', 'PENYIARAN SUKSES! Banner pengumuman langsung tayang di ponsel seluruh siswa!');
    }

    // 3. Matikan Siaran jika barang sudah dikembalikan (Hapus Data & Foto Secara Permanen)
    public function destroy(BarangTemuan $barang)
    {
        // 1. Eksekusi mati (Hapus Foto Fisik) agar memori server tidak penuh
        if ($barang->path_foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($barang->path_foto)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($barang->path_foto);
        }

        // 2. Hapus Rekam Jejak di Database
        $barang->delete();

        return back()->with('success', 'Barang berhasil diambil! File foto dan pengumuman siaran telah dimusnahkan secara permanen.');
    }
}

