<x-admin-layout>
    <x-slot name="title">Siaran Barang Temuan</x-slot>

<div x-data="{ showImageModal: false, imgSrc: '' }" class="relative">
    {{-- ============================================================
         HEADER
    ============================================================ --}}
    <div class="mb-5 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-3">
        <div>
            <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight" style="color: #2d241e;">Pusat Penyiaran Massal</h2>
            <p class="text-xs sm:text-sm font-medium mt-0.5" style="color: #7a6b61;">Unggah foto barang temuan untuk segera disiarkan ke profil seluruh siswa.</p>
        </div>
        <div class="flex-shrink-0 px-3 py-1.5 rounded-lg text-xs font-bold flex items-center gap-1.5"
             style="background: rgba(194,101,42,0.1); color: #c2652a; border: 1px solid rgba(194,101,42,0.2);">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
            Sistem Siaran Aktif
        </div>
    </div>

    {{-- ============================================================
         FLASH ALERTS
    ============================================================ --}}
    @if(session('success'))
        <div class="mb-5 flex items-start gap-3 rounded-xl p-4" style="background: #f0fdf4; border: 1.5px solid #86efac;">
            <span class="material-icons text-[20px] mt-0.5 text-green-600 flex-shrink-0 animate-bounce">campaign</span>
            <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
        </div>
    @endif
    @if($errors->any())
        <div class="mb-5 flex items-start gap-3 rounded-xl p-4" style="background: #fff5f1; border: 1.5px solid #f4c3a8;">
            <span class="material-icons text-[20px] mt-0.5 flex-shrink-0" style="color: #c2652a;">error_outline</span>
            <p class="text-sm font-semibold" style="color: #8b3a14;">Gagal menyiarkan: Periksa input nama/lokasi atau ukuran foto (Maksimal 2MB).</p>
        </div>
    @endif

    {{-- ============================================================
         MAIN GRID
    ============================================================ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        
        {{-- ======================== KOLOM KIRI: STUDIO PENYIARAN ======================== --}}
        <div class="lg:col-span-1 border-t sm:border-none border-gray-100 pt-5 sm:pt-0">
            <div class="rounded-2xl p-5 sm:p-6 text-white overflow-hidden relative shadow-xl xl:sticky xl:top-24"
                 style="background: linear-gradient(135deg, #c2652a 0%, #e07840 60%, #f09058 100%);">
                
                <div class="absolute -right-6 -bottom-6 opacity-10 pointer-events-none" aria-hidden="true">
                    <span class="material-icons text-[120px]">podcasts</span>
                </div>
                
                <div class="flex items-center gap-2 mb-5 relative z-10">
                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm">
                        <span class="material-icons text-white text-[16px] animate-pulse">cell_tower</span>
                    </div>
                    <h3 class="text-base font-extrabold tracking-tight">Mulai Siaran Baru</h3>
                </div>
                
                <form action="{{ route('admin.lost-found.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 relative z-10">
                    @csrf
                    
                    {{-- Nama Barang --}}
                    <div>
                        <label class="block text-[10px] font-extrabold text-amber-100 mb-1.5 uppercase tracking-wider">Nama Barang Temuan</label>
                        <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" required 
                               class="block w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-sm font-bold text-white placeholder-amber-200/60 focus:ring-2 focus:ring-white/50 focus:border-white focus:bg-white/20 transition-all outline-none" 
                               placeholder="Cth: Kunci Motor Scoopy">
                    </div>

                    {{-- Lokasi Temuan --}}
                    <div>
                        <label class="block text-[10px] font-extrabold text-amber-100 mb-1.5 uppercase tracking-wider">Lokasi / Detail Penemuan</label>
                        <input type="text" name="lokasi_ditemukan" value="{{ old('lokasi_ditemukan') }}" required 
                               class="block w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-sm font-semibold text-white placeholder-amber-200/60 focus:ring-2 focus:ring-white/50 focus:border-white focus:bg-white/20 transition-all outline-none" 
                               placeholder="Cth: Tertinggal di Kantin, Titip Pos">
                    </div>

                    {{-- Foto Barang --}}
                    <div>
                        <label class="block text-[10px] font-extrabold text-amber-100 mb-1.5 uppercase tracking-wider">Foto Visual Barang</label>
                        <div class="relative group">
                            <input type="file" name="foto" required accept="image/*" 
                                   class="block w-full text-sm text-amber-100 bg-white/10 border border-dashed border-white/40 rounded-xl cursor-pointer transition-colors hover:bg-white/20 hover:border-white focus:outline-none file:mr-4 file:py-3 file:px-4 file:rounded-xl file:rounded-r-none file:border-0 file:text-xs file:font-extrabold file:uppercase file:tracking-wider file:bg-white file:text-[#c2652a] hover:file:bg-amber-50">
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full flex items-center justify-center gap-2 mt-4 py-3.5 px-4 bg-white text-[#c2652a] font-extrabold text-sm uppercase tracking-widest rounded-xl shadow-[0_4px_14px_rgba(0,0,0,0.15)] transition-all duration-200 hover:shadow-[0_6px_20px_rgba(0,0,0,0.2)] hover:-translate-y-0.5"
                            onmouseenter="this.style.background='#faf8f5'"
                            onmouseleave="this.style.background='white'">
                        <span class="material-icons text-[18px]">send</span>
                        Siarkan Sekarang
                    </button>
                    <p class="text-[9px] font-medium text-amber-200/80 text-center mt-2 leading-tight">
                        Broadcast akan otomatis dikirim ke layar ponsel siswa yang membukanya.
                    </p>
                </form>
            </div>
        </div>

        {{-- ======================== KOLOM KANAN: DAFTAR RIWAYAT ======================== --}}
        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($barangs as $item)
                    {{-- KARTU BARANG TEMUAN --}}
                    <div class="bg-white rounded-2xl overflow-hidden border flex flex-col transition-all duration-200 group hover:shadow-lg hover:-translate-y-0.5"
                         style="border-color: #e8e1d7;">
                        
                        {{-- Cover Image --}}
                        <div class="h-44 w-full bg-[#faf8f5] overflow-hidden relative cursor-zoom-in" 
                             @click="imgSrc = '{{ Storage::url($item->path_foto) }}'; showImageModal = true;">
                            <img src="{{ Storage::url($item->path_foto) }}" alt="{{ $item->nama_barang }}" 
                                 class="w-full h-full object-cover opacity-95 group-hover:opacity-100 group-hover:scale-105 transition-transform duration-500">
                            
                            {{-- Lencana Status --}}
                            <div class="absolute top-3 right-3 pointer-events-none">
                                <span class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-widest text-white shadow-md backdrop-blur-sm"
                                      style="background: rgba(194, 101, 42, 0.85); border: 1px solid rgba(255,255,255,0.2);">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-300 animate-pulse"></span>
                                    Mengudara
                                </span>
                            </div>
                            
                            {{-- Hover Tap Icon --}}
                            <div class="absolute inset-0 flex justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black/20 backdrop-blur-[2px]">
                                <span class="bg-white/90 text-[#2d241e] p-3 rounded-full flex items-center justify-center transform scale-90 group-hover:scale-100 transition-transform">
                                    <span class="material-icons text-[24px]">zoom_in</span>
                                </span>
                            </div>
                        </div>
                        
                        {{-- Data Konten --}}
                        <div class="p-4 sm:p-5 flex-1 flex flex-col">
                            <h4 class="text-base font-extrabold tracking-wide mb-2 line-clamp-1" style="color: #2d241e;">{{ $item->nama_barang }}</h4>
                            
                            <div class="flex items-start text-xs font-medium mb-1.5 leading-relaxed" style="color: #7a6b61;">
                                <span class="material-icons text-[14px] mr-1.5 flex-shrink-0" style="color: #c2652a;">place</span>
                                <span>{{ $item->lokasi_ditemukan }}</span>
                            </div>
                            
                            <div class="flex items-center text-[10px] font-bold mb-4 uppercase tracking-wider" style="color: #a89b91;">
                                <span class="material-icons text-[12px] mr-1.5">admin_panel_settings</span>
                                Admin / Petugas PKS
                            </div>

                            {{-- Tombol Ambil / Hapus --}}
                            <div class="mt-auto pt-3 border-t" style="border-color: #f0ebe4;">
                                <form action="{{ route('admin.lost-found.destroy', $item->id) }}" method="POST" 
                                      onsubmit="return confirm('Sudah diserahkan kepada pemiliknya?\n\nJika OKE, foto fisik barang dalam harddisk server dan pengumuman di layar siswa akan dimusnahkan secara otomatis.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-extrabold uppercase transition-all"
                                            style="border: 1.5px solid #86efac; color: #166534; background: #f0fdf4;"
                                            onmouseenter="this.style.background='#dcfce7'"
                                            onmouseleave="this.style.background='#f0fdf4'">
                                        <span class="material-icons text-[16px]">how_to_reg</span>
                                        Tandai Diambil (Selesai)
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="sm:col-span-2 bg-white rounded-2xl border py-16 text-center" style="border-color: #e8e1d7;">
                        <div class="w-16 h-16 rounded-full bg-[#faf8f5] flex items-center justify-center mx-auto mb-3 border" style="border-color: #f0ebe4;">
                            <span class="material-icons text-[32px]" style="color: #c2652a;">speaker_notes_off</span>
                        </div>
                        <p class="font-extrabold text-lg" style="color: #2d241e;">Kosong / Aman</p>
                        <p class="text-sm font-medium mt-1" style="color: #a89b91;">Belum ada laporan barang yang hilang tertinggal.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ============================================================
         MODAL FULLSCREEN GAMBAR (ADMIN)
    ============================================================ --}}
    <div x-show="showImageModal" 
         style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-2 sm:p-6 bg-black/90 backdrop-blur-md cursor-zoom-out"
         @click="showImageModal = false">
         
         <div class="relative w-full h-full flex justify-center items-center pointer-events-none" @click.stop>
             
             {{-- Tombol Tutup X di Kanan Atas --}}
             <button @click="showImageModal = false" 
                     class="absolute top-4 right-4 sm:top-6 sm:right-6 bg-black/50 hover:bg-red-600 text-white rounded-full p-2 transition-colors pointer-events-auto backdrop-blur-sm z-10"
                     title="Tutup (Esc)">
                 <span class="material-icons text-[24px] block">close</span>
             </button>
             
             {{-- Gambar Resolusi Asli --}}
             <img :src="imgSrc" 
                  class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl pointer-events-auto transform scale-95 sm:scale-100 transition-transform duration-300 ease-out" 
                  x-show="showImageModal"
                  x-transition:enter="delay-100 transition-transform ease-out duration-300"
                  x-transition:enter-start="scale-90 opacity-0"
                  x-transition:enter-end="scale-100 sm:scale-100 opacity-100"
                  alt="Full Gambar Bukti">
         </div>
    </div>
</div>
</x-admin-layout>
