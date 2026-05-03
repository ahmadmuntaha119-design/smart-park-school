<x-admin-layout>
    <x-slot name="title">Siaran Barang Temuan</x-slot>

<div x-data="{ showImageModal: false, imgSrc: '' }" class="relative">
    {{-- ============================================================
         HEADER
    ============================================================ --}}
    <div class="mb-5 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-3">
        <div>
            <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight" style="color: var(--on-s);">Pusat Penyiaran Massal</h2>
            <p class="text-xs sm:text-sm font-medium mt-0.5" style="color: var(--on-v);">Unggah foto barang temuan untuk segera disiarkan ke profil seluruh siswa.</p>
        </div>
        <div class="flex-shrink-0 px-3 py-1.5 rounded-lg text-xs font-bold flex items-center gap-1.5 border"
             style="background: rgba(255,255,255,0.05); color: var(--on-s); border-color: rgba(255,255,255,0.1);">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
            Sistem Siaran Aktif
        </div>
    </div>

    {{-- ============================================================
         FLASH ALERTS
    ============================================================ --}}
    @if(session('success'))
        <div class="mb-5 flex items-start gap-3 rounded-xl p-4 border" style="background: rgba(16,185,129,0.1); border-color: rgba(16,185,129,0.2);">
            <span class="material-icons text-[20px] mt-0.5 text-emerald-500 flex-shrink-0 animate-bounce">campaign</span>
            <p class="text-sm font-semibold text-emerald-400">{{ session('success') }}</p>
        </div>
    @endif
    @if($errors->any())
        <div class="mb-5 flex items-start gap-3 rounded-xl p-4 border" style="background: rgba(239,68,68,0.1); border-color: rgba(239,68,68,0.2);">
            <span class="material-icons text-[20px] mt-0.5 text-red-500 flex-shrink-0">error_outline</span>
            <p class="text-sm font-semibold text-red-400">Gagal menyiarkan: Periksa input nama/lokasi atau ukuran foto (Maksimal 2MB).</p>
        </div>
    @endif

    {{-- ============================================================
         MAIN GRID
    ============================================================ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        
        {{-- ======================== KOLOM KIRI: STUDIO PENYIARAN ======================== --}}
        <div class="lg:col-span-1 border-t sm:border-none border-gray-800 pt-5 sm:pt-0">
            <div class="rounded-2xl p-5 sm:p-6 overflow-hidden relative border xl:sticky xl:top-24"
                 style="background: var(--sl2); border-color: var(--outline-v);">
                
                <div class="absolute -right-6 -bottom-6 opacity-[0.03] pointer-events-none" aria-hidden="true">
                    <span class="material-icons text-[120px]" style="color: var(--on-s);">podcasts</span>
                </div>
                
                <div class="flex items-center gap-2 mb-5 relative z-10">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center border" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                        <span class="material-icons text-[16px] animate-pulse" style="color: var(--on-s);">cell_tower</span>
                    </div>
                    <h3 class="text-base font-extrabold tracking-tight" style="color: var(--on-s);">Mulai Siaran Baru</h3>
                </div>
                
                <form action="{{ route('admin.lost-found.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 relative z-10">
                    @csrf
                    
                    {{-- Nama Barang --}}
                    <div>
                        <label class="block text-[10px] font-extrabold mb-1.5 uppercase tracking-wider" style="color: var(--on-v);">Nama Barang Temuan</label>
                        <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" required 
                               class="block w-full px-4 py-3 rounded-xl text-sm font-bold transition-all outline-none" 
                               style="background: rgba(255,255,255,0.02); border: 1px solid var(--outline-v); color: var(--on-s);"
                               placeholder="Cth: Kunci Motor Scoopy"
                               onfocus="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.background='rgba(255,255,255,0.05)'"
                               onblur="this.style.borderColor='var(--outline-v)'; this.style.background='rgba(255,255,255,0.02)'">
                    </div>

                    {{-- Lokasi Temuan --}}
                    <div>
                        <label class="block text-[10px] font-extrabold mb-1.5 uppercase tracking-wider" style="color: var(--on-v);">Lokasi / Detail Penemuan</label>
                        <input type="text" name="lokasi_ditemukan" value="{{ old('lokasi_ditemukan') }}" required 
                               class="block w-full px-4 py-3 rounded-xl text-sm font-semibold transition-all outline-none" 
                               style="background: rgba(255,255,255,0.02); border: 1px solid var(--outline-v); color: var(--on-s);"
                               placeholder="Cth: Tertinggal di Kantin, Titip Pos"
                               onfocus="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.background='rgba(255,255,255,0.05)'"
                               onblur="this.style.borderColor='var(--outline-v)'; this.style.background='rgba(255,255,255,0.02)'">
                    </div>

                    {{-- Foto Barang --}}
                    <div>
                        <label class="block text-[10px] font-extrabold mb-1.5 uppercase tracking-wider" style="color: var(--on-v);">Foto Visual Barang</label>
                        <div class="relative group">
                            <input type="file" name="foto" required accept="image/*" 
                                   class="block w-full text-sm rounded-xl cursor-pointer transition-colors focus:outline-none file:mr-4 file:py-3 file:px-4 file:rounded-xl file:rounded-r-none file:border-0 file:text-xs file:font-extrabold file:uppercase file:tracking-wider"
                                   style="background: rgba(255,255,255,0.02); border: 1px dashed var(--outline-v); color: var(--on-v);"
                                   onmouseover="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.background='rgba(255,255,255,0.05)'"
                                   onmouseout="this.style.borderColor='var(--outline-v)'; this.style.background='rgba(255,255,255,0.02)'">
                            <style>
                                input[type=file]::file-selector-button {
                                    background: rgba(255,255,255,0.1);
                                    color: var(--on-s);
                                    transition: background 0.2s;
                                }
                                input[type=file]:hover::file-selector-button {
                                    background: rgba(255,255,255,0.15);
                                }
                            </style>
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full flex items-center justify-center gap-2 mt-4 py-3.5 px-4 font-extrabold text-sm uppercase tracking-widest rounded-xl transition-all duration-200"
                            style="background: white; color: black;"
                            onmouseenter="this.style.background='#e4e4e7'"
                            onmouseleave="this.style.background='white'">
                        <span class="material-icons text-[18px]">send</span>
                        Siarkan Sekarang
                    </button>
                    <p class="text-[9px] font-medium text-center mt-2 leading-tight" style="color: var(--on-v);">
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
                    <div class="rounded-2xl overflow-hidden border flex flex-col transition-all duration-200 group hover:shadow-lg hover:-translate-y-0.5"
                         style="background: var(--sl2); border-color: var(--outline-v);">
                        
                        {{-- Cover Image --}}
                        <div class="h-44 w-full overflow-hidden relative cursor-zoom-in" 
                             style="background: #000;"
                             @click="imgSrc = '{{ Storage::url($item->path_foto) }}'; showImageModal = true;">
                            <img src="{{ Storage::url($item->path_foto) }}" alt="{{ $item->nama_barang }}" 
                                 class="w-full h-full object-cover opacity-95 group-hover:opacity-100 group-hover:scale-105 transition-transform duration-500">
                            
                            {{-- Lencana Status --}}
                            <div class="absolute top-3 right-3 pointer-events-none">
                                <span class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-widest text-white shadow-md backdrop-blur-sm"
                                      style="background: rgba(0,0,0,0.6); border: 1px solid rgba(255,255,255,0.2);">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-300 animate-pulse"></span>
                                    Mengudara
                                </span>
                            </div>
                            
                            {{-- Hover Tap Icon --}}
                            <div class="absolute inset-0 flex justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black/40 backdrop-blur-[2px]">
                                <span class="bg-white/90 p-3 rounded-full flex items-center justify-center transform scale-90 group-hover:scale-100 transition-transform text-black">
                                    <span class="material-icons text-[24px]">zoom_in</span>
                                </span>
                            </div>
                        </div>
                        
                        {{-- Data Konten --}}
                        <div class="p-4 sm:p-5 flex-1 flex flex-col">
                            <h4 class="text-base font-extrabold tracking-wide mb-2 line-clamp-1" style="color: var(--on-s);">{{ $item->nama_barang }}</h4>
                            
                            <div class="flex items-start text-xs font-medium mb-1.5 leading-relaxed" style="color: var(--on-v);">
                                <span class="material-icons text-[14px] mr-1.5 flex-shrink-0" style="color: var(--on-v);">place</span>
                                <span>{{ $item->lokasi_ditemukan }}</span>
                            </div>
                            
                            <div class="flex items-center text-[10px] font-bold mb-4 uppercase tracking-wider" style="color: var(--on-v);">
                                <span class="material-icons text-[12px] mr-1.5">admin_panel_settings</span>
                                Admin / Petugas PKS
                            </div>

                            {{-- Tombol Ambil / Hapus --}}
                            <div class="mt-auto pt-3 border-t" style="border-color: var(--outline-v);">
                                <form action="{{ route('admin.lost-found.destroy', $item->id) }}" method="POST" 
                                      onsubmit="return confirm('Sudah diserahkan kepada pemiliknya?\n\nJika OKE, foto fisik barang dalam harddisk server dan pengumuman di layar siswa akan dimusnahkan secara otomatis.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-extrabold uppercase transition-all"
                                            style="border: 1px solid rgba(16,185,129,0.2); color: #34d399; background: rgba(16,185,129,0.1);"
                                            onmouseenter="this.style.background='rgba(16,185,129,0.15)'"
                                            onmouseleave="this.style.background='rgba(16,185,129,0.1)'">
                                        <span class="material-icons text-[16px]">how_to_reg</span>
                                        Tandai Diambil (Selesai)
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="sm:col-span-2 rounded-2xl border py-16 text-center" style="background: var(--sl2); border-color: var(--outline-v);">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 border" style="background: rgba(255,255,255,0.02); border-color: var(--outline-v);">
                            <span class="material-icons text-[32px]" style="color: var(--on-v);">speaker_notes_off</span>
                        </div>
                        <p class="font-extrabold text-lg" style="color: var(--on-s);">Kosong / Aman</p>
                        <p class="text-sm font-medium mt-1" style="color: var(--on-v);">Belum ada laporan barang yang hilang tertinggal.</p>
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
