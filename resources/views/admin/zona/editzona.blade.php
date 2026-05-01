<x-admin-layout>
    <x-slot name="title">Manajemen Baris – Zona {{ $zona->nama_zona }}</x-slot>

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs font-bold mb-6 uppercase tracking-widest" style="color: #a89b91;">
        <a href="{{ route('admin.zona.index') }}" class="hover:underline" style="color: #c2652a;">Zona</a>
        <span class="material-icons text-[14px]">chevron_right</span>
        <span>Zona {{ $zona->nama_zona }}</span>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="mb-5 flex items-start gap-3 rounded-xl p-4" style="background:#f0fdf4; border:1.5px solid #86efac;">
            <span class="material-icons text-[20px] mt-0.5 text-green-600">check_circle_outline</span>
            <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-5 flex items-start gap-3 rounded-xl p-4" style="background:#fff5f1; border:1.5px solid #f4c3a8;">
            <span class="material-icons text-[20px] mt-0.5" style="color:#c2652a;">error_outline</span>
            <p class="text-sm font-semibold" style="color:#8b3a14;">{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- LEFT: Edit Zona + Form Tambah Baris --}}
        <div class="space-y-4">

            {{-- Card: Edit Info Zona --}}
            <div class="bg-white rounded-2xl p-5 border" style="border-color:#e8e1d7; border-top: 3px solid {{ $zona->kode_warna }};">
                <h3 class="text-sm font-extrabold mb-4" style="color:#2d241e;">Info Zona</h3>
                <form action="{{ route('admin.zona.update', $zona->id) }}" method="POST" class="space-y-3" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide mb-1" style="color:#7a6b61;">Nama Zona</label>
                        <input type="text" name="nama_zona" value="{{ $zona->nama_zona }}" required
                               class="block w-full px-3 py-2.5 rounded-xl text-sm font-extrabold uppercase"
                               style="background:#faf8f5; border:1.5px solid #e8e1d7; color:#2d241e; outline:none;"
                               onfocus="this.style.borderColor='#c2652a';" onblur="this.style.borderColor='#e8e1d7';">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide mb-1" style="color:#7a6b61;">Keterangan</label>
                        <input type="text" name="keterangan" value="{{ $zona->keterangan }}"
                               class="block w-full px-3 py-2.5 rounded-xl text-sm font-semibold"
                               style="background:#faf8f5; border:1.5px solid #e8e1d7; color:#2d241e; outline:none;"
                               onfocus="this.style.borderColor='#c2652a';" onblur="this.style.borderColor='#e8e1d7';">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide mb-1" style="color:#7a6b61;">Warna</label>
                        <div class="rounded-xl overflow-hidden" style="border:1.5px solid #e8e1d7;">
                            <input type="color" name="kode_warna" value="{{ $zona->kode_warna }}"
                                   class="block w-full h-10 cursor-pointer border-0 bg-transparent p-1">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide mb-1" style="color:#7a6b61;">Foto / Peta Denah</label>
                        
                        @if($zona->foto_denah)
                            <div class="mb-2 relative rounded-xl overflow-hidden group border" style="border-color:#e8e1d7;">
                                <img src="{{ Storage::url($zona->foto_denah) }}" alt="Peta Zona" class="w-full h-24 object-cover">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ Storage::url($zona->foto_denah) }}" target="_blank" class="text-xs font-bold text-white bg-black/50 px-2 py-1 rounded-lg">Lihat Penuh</a>
                                </div>
                            </div>
                        @endif

                        <div class="rounded-xl overflow-hidden" style="border:1.5px solid #e8e1d7; background:#faf8f5;">
                            <input type="file" name="foto_denah" accept="image/*"
                                   class="block w-full text-xs cursor-pointer p-2 file:mr-3 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-[#c2652a] file:text-white hover:file:bg-[#a8551e] transition-colors">
                        </div>
                        @if($zona->foto_denah)
                            <p class="text-[9px] mt-1 text-gray-500 font-medium">* Unggah file baru untuk mengganti peta saat ini.</p>
                        @endif
                    </div>
                    <button type="submit" class="w-full py-2.5 rounded-xl text-sm font-extrabold text-white"
                            style="background:#c2652a;">Simpan Perubahan</button>
                </form>
            </div>

            {{-- Card: Form Tambah Baris --}}
            <div class="bg-white rounded-2xl p-5 border" style="border-color:#e8e1d7;">
                <div class="flex items-center gap-2 mb-4">
                    <span class="material-icons text-[20px]" style="color:#c2652a;">add_road</span>
                    <h3 class="text-sm font-extrabold" style="color:#2d241e;">Tambah Baris Baru</h3>
                </div>
                <form action="{{ route('admin.zona.baris.store', $zona->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide mb-1" style="color:#7a6b61;">Nama Baris</label>
                        <input type="text" name="nama_baris" required placeholder="Cth: Baris 1"
                               class="block w-full px-3 py-2.5 rounded-xl text-sm font-extrabold"
                               style="background:#faf8f5; border:1.5px solid #e8e1d7; color:#2d241e; outline:none;"
                               onfocus="this.style.borderColor='#c2652a';" onblur="this.style.borderColor='#e8e1d7';">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide mb-1" style="color:#7a6b61;">Kapasitas (slot motor)</label>
                        <input type="number" name="kapasitas" required min="1" placeholder="35"
                               class="block w-full px-3 py-2.5 rounded-xl text-sm font-extrabold"
                               style="background:#faf8f5; border:1.5px solid #e8e1d7; color:#2d241e; outline:none;"
                               onfocus="this.style.borderColor='#c2652a';" onblur="this.style.borderColor='#e8e1d7';">
                    </div>

                    {{-- === ATURAN KHUSUS (RULE ENGINE) === --}}
                    <div class="rounded-xl p-3 space-y-2.5" style="background: #fef9f5; border: 1.5px dashed #e8c9a8;">
                        <p class="text-[10px] font-extrabold uppercase tracking-widest" style="color:#c2652a;">
                            <span class="material-icons text-[12px] align-text-bottom">rule</span> Aturan Khusus (Opsional)
                        </p>

                        {{-- Filter Warna --}}
                        <div>
                            <label class="block text-[11px] font-bold mb-1" style="color:#7a6b61;">Hanya Warna:</label>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($warnaList as $w)
                                    <label class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-lg cursor-pointer transition-colors"
                                           style="background:#f0ebe4; color:#7a6b61; border:1px solid #e8e1d7;">
                                        <input type="checkbox" name="syarat_warna[]" value="{{ $w }}" class="w-3 h-3" style="accent-color:#c2652a;">
                                        {{ $w }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Filter Transmisi --}}
                        <div>
                            <label class="block text-[11px] font-bold mb-1" style="color:#7a6b61;">Hanya Transmisi:</label>
                            <select name="syarat_transmisi" class="text-xs font-bold px-2.5 py-1.5 rounded-lg"
                                    style="background:white; border:1.5px solid #e8e1d7; color:#2d241e; outline:none;">
                                <option value="">Semua Transmisi</option>
                                <option value="Matic">Matic</option>
                                <option value="Manual">Manual</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl text-sm font-extrabold text-white flex items-center justify-center gap-2"
                            style="background:#c2652a; box-shadow:0 4px 14px rgba(194,101,42,0.3);">
                        <span class="material-icons text-[18px]">add</span> Tambah Baris
                    </button>
                </form>
            </div>

        </div>

        {{-- RIGHT: Tabel Baris + Komposisi --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- TABEL BARIS --}}
            <div class="bg-white rounded-2xl border overflow-hidden" style="border-color:#e8e1d7;">
                <div class="p-5 border-b flex justify-between items-center" style="border-color:#e8e1d7;">
                    <div>
                        <h3 class="text-sm font-extrabold" style="color:#2d241e;">Baris Zona {{ $zona->nama_zona }}</h3>
                        <p class="text-xs font-medium mt-0.5" style="color:#a89b91;">Total: {{ $zona->kapasitas_total }} slot dari {{ $zona->baris->count() }} baris</p>
                    </div>
                </div>

                @if($zona->baris->count() > 0)
                    <div class="divide-y" style="divide-color:#f0ebe4;">
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
                                $transStats     = $kendaraanBaris->groupBy('jenis_transmisi')->map->count()->sortDesc();

                                // Palet warna untuk chart
                                $warnaMap = [
                                    'Hitam'=>'#1a1a2e','Putih'=>'#e8e1d7','Merah'=>'#dc2626','Biru'=>'#2563eb',
                                    'Hijau'=>'#16a34a','Silver'=>'#94a3b8','Abu-abu'=>'#6b7280','Coklat'=>'#92400e',
                                    'Orange'=>'#ea580c','Kuning'=>'#eab308','Pink'=>'#ec4899','Ungu'=>'#7c3aed','Lainnya'=>'#a89b91',
                                ];

                                $syarat = $baris->syarat_filter;
                            @endphp
                            <div class="p-4" x-data="{ edit: false, komposisi: false }">
                                <div class="flex items-center gap-4">
                                    {{-- Nama & Progress --}}
                                    <div class="flex-1 min-w-0" x-show="!edit">
                                        <div class="flex justify-between items-center mb-1">
                                            <div>
                                                <p class="text-sm font-extrabold" style="color:#2d241e;">{{ $baris->nama_baris }}</p>
                                                <p class="text-[10px] font-bold" style="color:#a89b91;">Petak {{ $slotAwal }} – {{ $slotAkhir }}</p>
                                            </div>
                                            <p class="text-xs font-semibold" style="color:#7a6b61;">
                                                {{ $terisi }}/{{ $baris->kapasitas }} · sisa {{ $sisa }}
                                            </p>
                                        </div>
                                        <div class="w-full rounded-full h-2 overflow-hidden" style="background:#f0ebe4;">
                                            <div class="h-full rounded-full transition-all duration-700"
                                                 style="width:{{ $pct }}%; background-color:{{ $zona->kode_warna }};"></div>
                                        </div>

                                        {{-- Badge Aturan --}}
                                        @if($syarat && (!empty($syarat['warna'] ?? []) || !empty($syarat['transmisi'] ?? '')))
                                            <div class="mt-1.5 flex flex-wrap gap-1">
                                                <span class="text-[9px] font-extrabold px-1.5 py-0.5 rounded uppercase tracking-wider"
                                                      style="background:rgba(194,101,42,0.08); color:#c2652a; border:1px solid rgba(194,101,42,0.2);">
                                                    <span class="material-icons text-[10px] align-text-bottom">rule</span>
                                                    @if(!empty($syarat['warna'] ?? []))
                                                        {{ implode('/', $syarat['warna']) }}
                                                    @endif
                                                    @if(!empty($syarat['transmisi'] ?? ''))
                                                        {{ $syarat['transmisi'] }}
                                                    @endif
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
                                                   style="background:#faf8f5; border:1.5px solid #c2652a; color:#2d241e; outline:none;">
                                            <input type="number" name="kapasitas" value="{{ $baris->kapasitas }}" required min="1"
                                                   class="w-20 px-2 py-1.5 rounded-lg text-sm font-bold text-center"
                                                   style="background:#faf8f5; border:1.5px solid #c2652a; color:#2d241e; outline:none;">
                                        </div>

                                        {{-- Aturan Edit --}}
                                        <div class="rounded-lg p-2.5 space-y-2" style="background:#fef9f5; border:1px dashed #e8c9a8;">
                                            <p class="text-[9px] font-extrabold uppercase tracking-widest" style="color:#c2652a;">
                                                <span class="material-icons text-[10px] align-text-bottom">rule</span> Aturan
                                            </p>
                                            <div>
                                                <label class="text-[10px] font-bold" style="color:#7a6b61;">Warna:</label>
                                                <div class="flex flex-wrap gap-1 mt-0.5">
                                                    @foreach($warnaList as $w)
                                                        <label class="inline-flex items-center gap-0.5 text-[9px] font-bold px-1.5 py-0.5 rounded cursor-pointer"
                                                               style="background:#f0ebe4; color:#7a6b61;">
                                                            <input type="checkbox" name="syarat_warna[]" value="{{ $w }}"
                                                                   {{ in_array($w, $syarat['warna'] ?? []) ? 'checked' : '' }}
                                                                   class="w-2.5 h-2.5" style="accent-color:#c2652a;">
                                                            {{ $w }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div>
                                                <label class="text-[10px] font-bold" style="color:#7a6b61;">Transmisi:</label>
                                                <select name="syarat_transmisi" class="text-[10px] font-bold px-2 py-1 rounded-lg ml-1"
                                                        style="background:white; border:1px solid #e8e1d7; color:#2d241e; outline:none;">
                                                    <option value="" {{ empty($syarat['transmisi'] ?? '') ? 'selected' : '' }}>Semua</option>
                                                    <option value="Matic" {{ ($syarat['transmisi'] ?? '') === 'Matic' ? 'selected' : '' }}>Matic</option>
                                                    <option value="Manual" {{ ($syarat['transmisi'] ?? '') === 'Manual' ? 'selected' : '' }}>Manual</option>
                                                </select>
                                            </div>
                                        </div>

                                        <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold text-white" style="background:#c2652a;">Simpan</button>
                                    </form>

                                    {{-- Action Buttons --}}
                                    <div class="flex gap-1.5 flex-shrink-0">
                                        {{-- Tombol Komposisi --}}
                                        @if($terisi > 0)
                                            <button @click="komposisi = !komposisi"
                                                    class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"
                                                    style="border:1.5px solid #e8e1d7; color:#7a6b61;"
                                                    :style="komposisi ? 'border-color:#16a34a; color:#16a34a; background:rgba(22,163,74,0.05);' : ''"
                                                    title="Lihat Komposisi">
                                                <span class="material-icons text-[16px]">bar_chart</span>
                                            </button>
                                        @endif

                                        <button @click="edit = !edit"
                                                class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"
                                                style="border:1.5px solid #e8e1d7; color:#7a6b61;"
                                                :style="edit ? 'border-color:#c2652a; color:#c2652a;' : ''">
                                            <span class="material-icons text-[16px]">edit</span>
                                        </button>

                                        @if($terisi === 0)
                                            <form action="{{ route('admin.zona.baris.destroy', [$zona->id, $baris->id]) }}" method="POST"
                                                  onsubmit="return confirm('Hapus {{ $baris->nama_baris }}?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center"
                                                        style="border:1.5px solid #fca5a5; color:#dc2626;">
                                                    <span class="material-icons text-[16px]">delete</span>
                                                </button>
                                            </form>
                                        @else
                                            <div class="w-8 h-8 rounded-lg flex items-center justify-center opacity-30 cursor-not-allowed"
                                                 title="Masih ada motor di baris ini"
                                                 style="border:1.5px solid #e8e1d7; color:#a89b91;">
                                                <span class="material-icons text-[16px]">lock</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- ========= PANEL KOMPOSISI (Dropdown) ========= --}}
                                <div x-show="komposisi" x-transition x-cloak class="mt-3 rounded-xl p-4 space-y-3"
                                     style="background:#faf8f5; border:1.5px solid #f0ebe4;">

                                    <p class="text-[10px] font-extrabold uppercase tracking-widest" style="color:#7a6b61;">
                                        <span class="material-icons text-[12px] align-text-bottom">analytics</span>
                                        Analisis Komposisi · {{ $baris->nama_baris }} ({{ $terisi }} motor)
                                    </p>

                                    {{-- Stacked Bar: Warna --}}
                                    @if($warnaStats->count() > 0)
                                        <div>
                                            <p class="text-[10px] font-bold mb-1.5" style="color:#7a6b61;">Sebaran Warna</p>
                                            <div class="w-full h-5 rounded-full overflow-hidden flex" style="background:#e8e1d7;">
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
                                                        <span class="text-[10px] font-bold" style="color:#7a6b61;">{{ $warna ?: '?' }}: {{ $jumlah }}  ({{ round(($jumlah / $terisi) * 100, 1) }}%)</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Stacked Bar: Transmisi --}}
                                    @if($transStats->count() > 0)
                                        <div>
                                            <p class="text-[10px] font-bold mb-1.5" style="color:#7a6b61;">Sebaran Transmisi</p>
                                            <div class="w-full h-5 rounded-full overflow-hidden flex" style="background:#e8e1d7;">
                                                @foreach($transStats as $trans => $jumlah)
                                                    @php
                                                        $transPct = round(($jumlah / $terisi) * 100, 1);
                                                        $transColor = $trans === 'Matic' ? '#c2652a' : '#2563eb';
                                                    @endphp
                                                    <div class="h-full flex items-center justify-center text-[8px] font-extrabold text-white transition-all"
                                                         style="width:{{ $transPct }}%; background-color:{{ $transColor }};"
                                                         title="{{ $trans }}: {{ $jumlah }} motor ({{ $transPct }}%)">
                                                        @if($transPct >= 15){{ $trans }} {{ $transPct }}%@endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="flex flex-wrap gap-x-3 gap-y-1 mt-1.5">
                                                @foreach($transStats as $trans => $jumlah)
                                                    @php $transColor = $trans === 'Matic' ? '#c2652a' : '#2563eb'; @endphp
                                                    <div class="flex items-center gap-1">
                                                        <div class="w-2 h-2 rounded-full" style="background-color:{{ $transColor }};"></div>
                                                        <span class="text-[10px] font-bold" style="color:#7a6b61;">{{ $trans ?: '?' }}: {{ $jumlah }} ({{ round(($jumlah / $terisi) * 100, 1) }}%)</span>
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
                        <span class="material-icons text-[48px] block" style="color:#e8e1d7;">table_rows</span>
                        <p class="font-bold mt-2" style="color:#a89b91;">Belum ada baris. Tambahkan melalui form di kiri.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-admin-layout>
