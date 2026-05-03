<x-admin-layout>
    <x-slot name="title">Manajemen Baris – Zona {{ $zona->nama_zona }}</x-slot>

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs font-bold mb-6 uppercase tracking-widest" style="color: var(--on-v);">
        <a href="{{ route('admin.zona.index') }}" class="hover:underline" style="color: var(--on-s);">Zona</a>
        <span class="material-icons text-[14px]">chevron_right</span>
        <span>Zona {{ $zona->nama_zona }}</span>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="mb-5 flex items-start gap-3 rounded-xl p-4 border" style="background:rgba(16,185,129,0.1); border-color:rgba(16,185,129,0.2);">
            <span class="material-icons text-[20px] mt-0.5 text-emerald-500">check_circle_outline</span>
            <p class="text-sm font-semibold text-emerald-400">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-5 flex items-start gap-3 rounded-xl p-4 border" style="background:rgba(239,68,68,0.1); border-color:rgba(239,68,68,0.2);">
            <span class="material-icons text-[20px] mt-0.5 text-red-500">error_outline</span>
            <p class="text-sm font-semibold text-red-400">{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- LEFT: Edit Zona + Form Tambah Baris --}}
        <div class="space-y-4">

            {{-- Card: Edit Info Zona --}}
            <div class="rounded-2xl p-5 border" style="background:var(--sl2); border-color:var(--outline-v); border-top: 3px solid {{ $zona->kode_warna }};">
                <h3 class="text-sm font-extrabold mb-4" style="color:var(--on-s);">Info Zona</h3>
                <form action="{{ route('admin.zona.update', $zona->id) }}" method="POST" class="space-y-3" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide mb-1" style="color:var(--on-v);">Nama Zona</label>
                        <input type="text" name="nama_zona" value="{{ $zona->nama_zona }}" required
                               class="block w-full px-3 py-2.5 rounded-xl text-sm font-extrabold uppercase transition-colors"
                               style="background:rgba(255,255,255,0.02); border:1px solid var(--outline-v); color:var(--on-s); outline:none;"
                               onfocus="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.background='rgba(255,255,255,0.05)';" onblur="this.style.borderColor='var(--outline-v)'; this.style.background='rgba(255,255,255,0.02)';">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide mb-1" style="color:var(--on-v);">Keterangan</label>
                        <input type="text" name="keterangan" value="{{ $zona->keterangan }}"
                               class="block w-full px-3 py-2.5 rounded-xl text-sm font-semibold transition-colors"
                               style="background:rgba(255,255,255,0.02); border:1px solid var(--outline-v); color:var(--on-s); outline:none;"
                               onfocus="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.background='rgba(255,255,255,0.05)';" onblur="this.style.borderColor='var(--outline-v)'; this.style.background='rgba(255,255,255,0.02)';">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide mb-1" style="color:var(--on-v);">Warna</label>
                        <div class="rounded-xl overflow-hidden" style="border:1px solid var(--outline-v); background:rgba(255,255,255,0.02);">
                            <input type="color" name="kode_warna" value="{{ $zona->kode_warna }}"
                                   class="block w-full h-10 cursor-pointer border-0 bg-transparent p-1">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide mb-1" style="color:var(--on-v);">Foto / Peta Denah</label>
                        
                        @if($zona->foto_denah)
                            <div class="mb-2 relative rounded-xl overflow-hidden group border" style="border-color:var(--outline-v);">
                                <img src="{{ Storage::url($zona->foto_denah) }}" alt="Peta Zona" class="w-full h-24 object-cover">
                                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ Storage::url($zona->foto_denah) }}" target="_blank" class="text-xs font-bold text-black bg-white px-2 py-1 rounded-lg">Lihat Penuh</a>
                                </div>
                            </div>
                        @endif

                        <div class="rounded-xl overflow-hidden" style="border:1px solid var(--outline-v); background:rgba(255,255,255,0.02);">
                            <input type="file" name="foto_denah" accept="image/*"
                                   class="block w-full text-xs cursor-pointer p-2 file:mr-3 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-white file:text-black hover:file:bg-zinc-200 transition-colors" style="color:var(--on-v);">
                        </div>
                        @if($zona->foto_denah)
                            <p class="text-[9px] mt-1 font-medium" style="color:var(--on-v);">* Unggah file baru untuk mengganti peta saat ini.</p>
                        @endif
                    </div>
                    <button type="submit" class="w-full py-2.5 rounded-xl text-sm font-extrabold transition-colors"
                            style="background:#ffffff; color:#000000;"
                            onmouseenter="this.style.background='#e4e4e7'" onmouseleave="this.style.background='#ffffff'">Simpan Perubahan</button>
                </form>
            </div>

            {{-- Card: Form Tambah Baris --}}
            <div class="rounded-2xl p-5 border" style="background:var(--sl2); border-color:var(--outline-v);">
                <div class="flex items-center gap-2 mb-4">
                    <span class="material-icons text-[20px]" style="color:var(--on-s);">add_road</span>
                    <h3 class="text-sm font-extrabold" style="color:var(--on-s);">Tambah Baris Baru</h3>
                </div>
                <form action="{{ route('admin.zona.baris.store', $zona->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide mb-1" style="color:var(--on-v);">Nama Baris</label>
                        <input type="text" name="nama_baris" required placeholder="Cth: Baris 1"
                               class="block w-full px-3 py-2.5 rounded-xl text-sm font-extrabold transition-colors"
                               style="background:rgba(255,255,255,0.02); border:1px solid var(--outline-v); color:var(--on-s); outline:none;"
                               onfocus="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.background='rgba(255,255,255,0.05)';" onblur="this.style.borderColor='var(--outline-v)'; this.style.background='rgba(255,255,255,0.02)';">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide mb-1" style="color:var(--on-v);">Kapasitas (slot motor)</label>
                        <input type="number" name="kapasitas" required min="1" placeholder="35"
                               class="block w-full px-3 py-2.5 rounded-xl text-sm font-extrabold transition-colors"
                               style="background:rgba(255,255,255,0.02); border:1px solid var(--outline-v); color:var(--on-s); outline:none;"
                               onfocus="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.background='rgba(255,255,255,0.05)';" onblur="this.style.borderColor='var(--outline-v)'; this.style.background='rgba(255,255,255,0.02)';">
                    </div>

                    {{-- === ATURAN KHUSUS (RULE ENGINE) === --}}
                    <div class="rounded-xl p-3 space-y-2.5 border" style="background:rgba(255,255,255,0.02); border-color:var(--outline-v); border-style:dashed;">
                        <p class="text-[10px] font-extrabold uppercase tracking-widest" style="color:var(--on-s);">
                            <span class="material-icons text-[12px] align-text-bottom">rule</span> Aturan Khusus (Opsional)
                        </p>

                        {{-- Filter Warna --}}
                        <div>
                            <label class="block text-[11px] font-bold mb-1" style="color:var(--on-v);">Hanya Warna:</label>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($warnaList as $w)
                                    <label class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-lg cursor-pointer transition-colors"
                                           style="background:rgba(255,255,255,0.05); color:var(--on-s); border:1px solid var(--outline-v);">
                                        <input type="checkbox" name="syarat_warna[]" value="{{ $w }}" class="w-3 h-3" style="accent-color:var(--on-s);">
                                        {{ $w }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Filter Merek --}}
                        <div>
                            <label class="block text-[11px] font-bold mb-1" style="color:var(--on-v);">Hanya Merek:</label>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($merekList as $m)
                                    <label class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-lg cursor-pointer transition-colors"
                                           style="background:rgba(255,255,255,0.05); color:var(--on-s); border:1px solid var(--outline-v);">
                                        <input type="checkbox" name="syarat_merek[]" value="{{ $m }}" class="w-3 h-3" style="accent-color:var(--on-s);">
                                        {{ $m }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            {{-- Filter Transmisi --}}
                            <div>
                                <label class="block text-[11px] font-bold mb-1" style="color:var(--on-v);">Hanya Transmisi:</label>
                                <select name="syarat_transmisi" class="w-full text-xs font-bold px-2.5 py-1.5 rounded-lg"
                                        style="background:var(--sl2); border:1px solid var(--outline-v); color:var(--on-s); outline:none;">
                                    <option value="">Semua Transmisi</option>
                                    <option value="Matic">Matic</option>
                                    <option value="Manual">Manual</option>
                                </select>
                            </div>

                            {{-- Filter Tipe --}}
                            <div>
                                <label class="block text-[11px] font-bold mb-1" style="color:var(--on-v);">Hanya Tipe:</label>
                                <input type="text" name="syarat_tipe" placeholder="Cth: Vario, NMAX"
                                       class="w-full text-xs font-bold px-2.5 py-1.5 rounded-lg transition-colors"
                                       style="background:rgba(255,255,255,0.02); border:1px solid var(--outline-v); color:var(--on-s); outline:none;"
                                       onfocus="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.background='rgba(255,255,255,0.05)';" onblur="this.style.borderColor='var(--outline-v)'; this.style.background='rgba(255,255,255,0.02)';">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl text-sm font-extrabold flex items-center justify-center gap-2 transition-colors"
                            style="background:#ffffff; color:#000000; box-shadow:0 4px 14px rgba(255,255,255,0.2);"
                            onmouseenter="this.style.background='#e4e4e7'" onmouseleave="this.style.background='#ffffff'">
                        <span class="material-icons text-[18px]">add</span> Tambah Baris
                    </button>
                </form>
            </div>

        </div>

        {{-- RIGHT: Tabel Baris + Komposisi --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- TABEL BARIS --}}
            <div class="rounded-2xl border overflow-hidden" style="background:var(--sl2); border-color:var(--outline-v);">
                <div class="p-5 border-b flex justify-between items-center" style="border-color:var(--outline-v);">
                    <div>
                        <h3 class="text-sm font-extrabold" style="color:var(--on-s);">Baris Zona {{ $zona->nama_zona }}</h3>
                        <p class="text-xs font-medium mt-0.5" style="color:var(--on-v);">Total: {{ $zona->kapasitas_total }} slot dari {{ $zona->baris->count() }} baris</p>
                    </div>
                </div>

                @if($zona->baris->count() > 0)
                    <div class="divide-y" style="divide-color:var(--outline-v);">
                        @php $kumulatifSlot = 0; @endphp
                        @foreach($zona->baris as $baris)
                            @php
                                $terisi    = $baris->kendaraan()->count();
                                $sisa      = max(0, $baris->kapasitas - $terisi);
                                $pct       = $baris->kapasitas > 0 ? min(round(($terisi / $baris->kapasitas) * 100), 100) : 0;
                                $slotAwal  = $kumulatifSlot + 1;
                                $slotAkhir = $kumulatifSlot + $baris->kapasitas;
                                $kumulatifSlot = $slotAkhir;

                                // Komposisi data
                                $kendaraanBaris = $baris->kendaraan;
                                $warnaStats     = $kendaraanBaris->groupBy('warna')->map->count()->sortDesc();
                                $merekStats     = $kendaraanBaris->groupBy('merek')->map->count()->sortDesc();
                                $transStats     = $kendaraanBaris->groupBy('jenis_transmisi')->map->count()->sortDesc();

                                // Palet warna untuk chart
                                $warnaMap = [
                                    'Hitam'=>'#1a1a2e','Putih'=>'#e8e1d7','Merah'=>'#dc2626','Biru'=>'#2563eb',
                                    'Hijau'=>'#16a34a','Silver'=>'#94a3b8','Abu-abu'=>'#6b7280','Coklat'=>'#92400e',
                                    'Orange'=>'#ea580c','Kuning'=>'#eab308','Pink'=>'#ec4899','Ungu'=>'#7c3aed','Lainnya'=>'#a89b91',
                                ];

                                // Palet warna untuk merek (opsional)
                                $merekMap = [
                                    'Honda'=>'#dc2626','Yamaha'=>'#2563eb','Suzuki'=>'#2dd4bf','Kawasaki'=>'#16a34a',
                                    'Vespa'=>'#f59e0b','Lainnya'=>'#a89b91',
                                ];

                                $syarat = $baris->syarat_filter;
                            @endphp
                            <div class="p-4" x-data="{ edit: false, komposisi: false }">
                                <div class="flex items-center gap-4">
                                    {{-- Nama & Progress --}}
                                    <div class="flex-1 min-w-0" x-show="!edit">
                                        <div class="flex justify-between items-center mb-1">
                                            <div>
                                                <p class="text-sm font-extrabold" style="color:var(--on-s);">{{ $baris->nama_baris }}</p>
                                                <p class="text-[10px] font-bold" style="color:var(--on-v);">Petak {{ $slotAwal }} – {{ $slotAkhir }}</p>
                                            </div>
                                            <p class="text-xs font-semibold" style="color:var(--on-v);">
                                                {{ $terisi }}/{{ $baris->kapasitas }} · sisa {{ $sisa }}
                                            </p>
                                        </div>
                                        <div class="w-full rounded-full h-2 overflow-hidden border border-white/5" style="background:rgba(255,255,255,0.05);">
                                            <div class="h-full rounded-full transition-all duration-700"
                                                 style="width:{{ $pct }}%; background-color:{{ $zona->kode_warna }};"></div>
                                        </div>

                                        {{-- Badge Aturan --}}
                                        @if($syarat && (!empty($syarat['warna'] ?? []) || !empty($syarat['transmisi'] ?? '') || !empty($syarat['merek'] ?? []) || !empty($syarat['tipe'] ?? [])))
                                            <div class="mt-1.5 flex flex-wrap gap-1">
                                                <span class="text-[9px] font-extrabold px-1.5 py-0.5 rounded uppercase tracking-wider"
                                                      style="background:rgba(255,255,255,0.05); color:var(--on-s); border:1px solid rgba(255,255,255,0.1);">
                                                    <span class="material-icons text-[10px] align-text-bottom">rule</span>
                                                    @php $badgeParts = []; @endphp
                                                    @if(!empty($syarat['warna'] ?? [])) @php $badgeParts[] = implode('/', $syarat['warna']); @endphp @endif
                                                    @if(!empty($syarat['merek'] ?? [])) @php $badgeParts[] = implode('/', $syarat['merek']); @endphp @endif
                                                    @if(!empty($syarat['tipe'] ?? [])) @php $badgeParts[] = implode('/', $syarat['tipe']); @endphp @endif
                                                    @if(!empty($syarat['transmisi'] ?? '')) @php $badgeParts[] = $syarat['transmisi']; @endphp @endif
                                                    
                                                    {{ implode(', ', $badgeParts) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Inline Edit Form --}}
                                    <form x-show="edit" x-cloak
                                          action="{{ route('admin.zona.baris.update', [$zona->id, $baris->id]) }}"
                                          method="POST" class="flex-1 space-y-2">
                                        @csrf @method('PUT')
                                        <div class="flex gap-2 items-center">
                                            <input type="text" name="nama_baris" value="{{ $baris->nama_baris }}" required
                                                   class="flex-1 px-3 py-1.5 rounded-lg text-sm font-bold"
                                                   style="background:rgba(255,255,255,0.02); border:1px solid var(--on-s); color:var(--on-s); outline:none;">
                                            <input type="number" name="kapasitas" value="{{ $baris->kapasitas }}" required min="1"
                                                   class="w-20 px-2 py-1.5 rounded-lg text-sm font-bold text-center"
                                                   style="background:rgba(255,255,255,0.02); border:1px solid var(--on-s); color:var(--on-s); outline:none;">
                                        </div>

                                        {{-- Aturan Edit --}}
                                        <div class="rounded-lg p-2.5 space-y-2 border border-dashed" style="background:rgba(255,255,255,0.02); border-color:var(--outline-v);">
                                            <p class="text-[9px] font-extrabold uppercase tracking-widest" style="color:var(--on-s);">
                                                <span class="material-icons text-[10px] align-text-bottom">rule</span> Aturan
                                            </p>
                                            <div>
                                                <label class="text-[10px] font-bold" style="color:var(--on-v);">Warna:</label>
                                                <div class="flex flex-wrap gap-1 mt-0.5">
                                                    @foreach($warnaList as $w)
                                                        <label class="inline-flex items-center gap-0.5 text-[9px] font-bold px-1.5 py-0.5 rounded cursor-pointer transition-colors"
                                                               style="background:rgba(255,255,255,0.05); color:var(--on-v);">
                                                            <input type="checkbox" name="syarat_warna[]" value="{{ $w }}"
                                                                   {{ in_array($w, $syarat['warna'] ?? []) ? 'checked' : '' }}
                                                                   class="w-2.5 h-2.5" style="accent-color:var(--on-s);">
                                                            {{ $w }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div>
                                                <label class="text-[10px] font-bold" style="color:var(--on-v);">Merek:</label>
                                                <div class="flex flex-wrap gap-1 mt-0.5">
                                                    @foreach($merekList as $m)
                                                        <label class="inline-flex items-center gap-0.5 text-[9px] font-bold px-1.5 py-0.5 rounded cursor-pointer transition-colors"
                                                               style="background:rgba(255,255,255,0.05); color:var(--on-v);">
                                                            <input type="checkbox" name="syarat_merek[]" value="{{ $m }}"
                                                                   {{ in_array($m, $syarat['merek'] ?? []) ? 'checked' : '' }}
                                                                   class="w-2.5 h-2.5" style="accent-color:var(--on-s);">
                                                            {{ $m }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2 mt-1.5">
                                                <div>
                                                    <label class="text-[10px] font-bold" style="color:var(--on-v);">Transmisi:</label>
                                                    <select name="syarat_transmisi" class="w-full text-[10px] font-bold px-2 py-1.5 rounded-lg mt-0.5"
                                                            style="background:var(--sl2); border:1px solid var(--outline-v); color:var(--on-s); outline:none;">
                                                        <option value="" {{ empty($syarat['transmisi'] ?? '') ? 'selected' : '' }}>Semua</option>
                                                        <option value="Matic" {{ ($syarat['transmisi'] ?? '') === 'Matic' ? 'selected' : '' }}>Matic</option>
                                                        <option value="Manual" {{ ($syarat['transmisi'] ?? '') === 'Manual' ? 'selected' : '' }}>Manual</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="text-[10px] font-bold" style="color:var(--on-v);">Tipe:</label>
                                                    <input type="text" name="syarat_tipe" value="{{ implode(', ', $syarat['tipe'] ?? []) }}" placeholder="Cth: Vario, NMAX"
                                                           class="w-full text-[10px] font-bold px-2 py-1.5 rounded-lg mt-0.5 transition-colors"
                                                           style="background:rgba(255,255,255,0.02); border:1px solid var(--outline-v); color:var(--on-s); outline:none;"
                                                           onfocus="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.background='rgba(255,255,255,0.05)';" onblur="this.style.borderColor='var(--outline-v)'; this.style.background='rgba(255,255,255,0.02)';">
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors" style="background:#ffffff; color:#000000;" onmouseenter="this.style.background='#e4e4e7'" onmouseleave="this.style.background='#ffffff'">Simpan</button>
                                    </form>

                                    {{-- Action Buttons --}}
                                    <div class="flex gap-1.5 flex-shrink-0">
                                        {{-- Tombol Komposisi --}}
                                        @if($terisi > 0)
                                            <button @click="komposisi = !komposisi"
                                                    class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"
                                                    style="border:1px solid var(--outline-v); color:var(--on-v);"
                                                    :style="komposisi ? 'border-color:#10b981; color:#10b981; background:rgba(16,185,129,0.1);' : ''"
                                                    title="Lihat Komposisi">
                                                <span class="material-icons text-[16px]">bar_chart</span>
                                            </button>
                                        @endif

                                        <button @click="edit = !edit"
                                                class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"
                                                style="border:1px solid var(--outline-v); color:var(--on-v);"
                                                :style="edit ? 'border-color:var(--on-s); color:var(--on-s); background:rgba(255,255,255,0.05);' : ''">
                                            <span class="material-icons text-[16px]">edit</span>
                                        </button>

                                        @if($terisi === 0)
                                            <form action="{{ route('admin.zona.baris.destroy', [$zona->id, $baris->id]) }}" method="POST"
                                                  onsubmit="return confirm('Hapus {{ $baris->nama_baris }}?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"
                                                        style="border:1px solid rgba(239,68,68,0.2); color:#ef4444;"
                                                        onmouseenter="this.style.background='rgba(239,68,68,0.1)';" onmouseleave="this.style.background='transparent';">
                                                    <span class="material-icons text-[16px]">delete</span>
                                                </button>
                                            </form>
                                        @else
                                            <div class="w-8 h-8 rounded-lg flex items-center justify-center cursor-not-allowed opacity-50"
                                                 title="Masih ada motor di baris ini"
                                                 style="border:1px solid var(--outline-v); color:var(--on-v);">
                                                <span class="material-icons text-[16px]">lock</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- ========= PANEL KOMPOSISI (Dropdown) ========= --}}
                                <div x-show="komposisi" x-transition x-cloak class="mt-3 rounded-xl p-4 space-y-3"
                                     style="background:rgba(255,255,255,0.02); border:1px solid var(--outline-v);">

                                    <p class="text-[10px] font-extrabold uppercase tracking-widest" style="color:var(--on-v);">
                                        <span class="material-icons text-[12px] align-text-bottom">analytics</span>
                                        Analisis Komposisi · {{ $baris->nama_baris }} ({{ $terisi }} motor)
                                    </p>

                                    {{-- Stacked Bar: Warna --}}
                                    @if($warnaStats->count() > 0)
                                        <div>
                                            <p class="text-[10px] font-bold mb-1.5" style="color:var(--on-v);">Sebaran Warna</p>
                                            <div class="w-full h-5 rounded-full overflow-hidden flex" style="background:rgba(255,255,255,0.05);">
                                                @foreach($warnaStats as $warna => $jumlah)
                                                    @php
                                                        $warnaPct  = round(($jumlah / $terisi) * 100, 1);
                                                        $colorCode = $warnaMap[$warna] ?? '#a89b91';
                                                    @endphp
                                                    <div class="h-full flex items-center justify-center text-[8px] font-extrabold text-white transition-all"
                                                         style="width:{{ $warnaPct }}%; background-color:{{ $colorCode }}; {{ $warna === 'Putih' ? 'color:#2d241e;' : '' }}"
                                                         title="{{ $warna }}: {{ $jumlah }} motor ({{ $warnaPct }}%)">
                                                        @if($warnaPct >= 12){{ $warnaPct }}%@endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="flex flex-wrap gap-x-3 gap-y-1 mt-1.5">
                                                @foreach($warnaStats as $warna => $jumlah)
                                                    @php $colorCode = $warnaMap[$warna] ?? '#a89b91'; @endphp
                                                    <div class="flex items-center gap-1">
                                                        <div class="w-2 h-2 rounded-full" style="background-color:{{ $colorCode }};"></div>
                                                        <span class="text-[10px] font-bold" style="color:var(--on-v);">{{ $warna ?: '?' }}: {{ $jumlah }}  ({{ round(($jumlah / $terisi) * 100, 1) }}%)</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Stacked Bar: Transmisi --}}
                                    @if($transStats->count() > 0)
                                        <div>
                                            <p class="text-[10px] font-bold mb-1.5" style="color:var(--on-v);">Sebaran Transmisi</p>
                                            <div class="w-full h-5 rounded-full overflow-hidden flex" style="background:rgba(255,255,255,0.05);">
                                                @foreach($transStats as $trans => $jumlah)
                                                    @php
                                                        $transPct = round(($jumlah / $terisi) * 100, 1);
                                                        $transColor = $trans === 'Matic' ? '#eab308' : '#3b82f6';
                                                    @endphp
                                                    <div class="h-full flex items-center justify-center text-[8px] font-extrabold text-black transition-all"
                                                         style="width:{{ $transPct }}%; background-color:{{ $transColor }};"
                                                         title="{{ $trans }}: {{ $jumlah }} motor ({{ $transPct }}%)">
                                                        @if($transPct >= 15){{ $trans }} {{ $transPct }}%@endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="flex flex-wrap gap-x-3 gap-y-1 mt-1.5">
                                                @foreach($transStats as $trans => $jumlah)
                                                    @php $transColor = $trans === 'Matic' ? '#eab308' : '#3b82f6'; @endphp
                                                    <div class="flex items-center gap-1">
                                                        <div class="w-2 h-2 rounded-full" style="background-color:{{ $transColor }};"></div>
                                                        <span class="text-[10px] font-bold" style="color:var(--on-v);">{{ $trans ?: '?' }}: {{ $jumlah }} ({{ round(($jumlah / $terisi) * 100, 1) }}%)</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Stacked Bar: Merek --}}
                                    @if($merekStats->count() > 0)
                                        <div>
                                            <p class="text-[10px] font-bold mb-1.5" style="color:var(--on-v);">Sebaran Merek</p>
                                            <div class="w-full h-5 rounded-full overflow-hidden flex" style="background:rgba(255,255,255,0.05);">
                                                @foreach($merekStats as $merek => $jumlah)
                                                    @php
                                                        $merekPct  = round(($jumlah / $terisi) * 100, 1);
                                                        $merekColor = $merekMap[$merek] ?? '#a89b91';
                                                    @endphp
                                                    <div class="h-full flex items-center justify-center text-[8px] font-extrabold text-white transition-all"
                                                         style="width:{{ $merekPct }}%; background-color:{{ $merekColor }};"
                                                         title="{{ $merek }}: {{ $jumlah }} motor ({{ $merekPct }}%)">
                                                        @if($merekPct >= 12){{ $merekPct }}%@endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="flex flex-wrap gap-x-3 gap-y-1 mt-1.5">
                                                @foreach($merekStats as $merek => $jumlah)
                                                    @php $merekColor = $merekMap[$merek] ?? '#a89b91'; @endphp
                                                    <div class="flex items-center gap-1">
                                                        <div class="w-2 h-2 rounded-full" style="background-color:{{ $merekColor }};"></div>
                                                        <span class="text-[10px] font-bold" style="color:var(--on-v);">{{ $merek ?: '?' }}: {{ $jumlah }} ({{ round(($jumlah / $terisi) * 100, 1) }}%)</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-20 text-center">
                        <span class="material-icons text-[48px] block opacity-50" style="color:var(--on-v);">table_rows</span>
                        <p class="font-bold mt-2" style="color:var(--on-v);">Belum ada baris. Tambahkan melalui form di kiri.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-admin-layout>
