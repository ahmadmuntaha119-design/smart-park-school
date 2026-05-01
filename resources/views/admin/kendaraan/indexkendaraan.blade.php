<x-admin-layout>
    <x-slot name="title">Manajemen Kendaraan</x-slot>

    {{-- ============================================================
         HEADER
    ============================================================ --}}
    <div class="mb-5">
        <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight" style="color: #2d241e;">Pusat Kontrol Kendaraan Siswa</h2>
        <p class="text-xs sm:text-sm font-medium mt-0.5" style="color: #7a6b61;">Assign zona massal, filter data, dan kelola kendaraan siswa.</p>
    </div>

    {{-- ============================================================
         FLASH ALERTS
    ============================================================ --}}
    @if(session('success'))
        <div class="mb-5 flex items-start gap-3 rounded-xl p-4" style="background: #f0fdf4; border: 1.5px solid #86efac;">
            <span class="material-icons text-[20px] mt-0.5 text-green-600 flex-shrink-0">check_circle_outline</span>
            <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-5 flex items-start gap-3 rounded-xl p-4" style="background: #fff5f1; border: 1.5px solid #f4c3a8;">
            <span class="material-icons text-[20px] mt-0.5 flex-shrink-0" style="color: #c2652a;">error_outline</span>
            <p class="text-sm font-semibold" style="color: #8b3a14;">{{ session('error') }}</p>
        </div>
    @endif

    {{-- ============================================================
         PANEL AKSI ATAS (2 KOLOM)
    ============================================================ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6" x-data="{ showHapus: false }">

        {{-- ---- Panel Bulk Assign dengan Baris Dinamis ---- --}}
        <form action="{{ route('admin.kendaraan.bulkAssign') }}" method="POST" id="formBulkAssign"
              class="rounded-2xl p-5 sm:p-6 text-white overflow-hidden relative"
              x-data="bulkAssignPanel()"
              style="background: linear-gradient(135deg, #c2652a 0%, #e07840 60%, #f09058 100%); box-shadow: 0 8px 24px rgba(194,101,42,0.35);">
            @csrf
            <div class="absolute -right-6 -bottom-6 opacity-10 pointer-events-none" aria-hidden="true">
                <span class="material-icons text-[110px]">map</span>
            </div>

            <div class="relative z-10">
                <p class="text-[10px] font-extrabold tracking-widest uppercase text-amber-200 mb-1">Aksi Massal</p>
                <h3 class="text-base sm:text-lg font-extrabold mb-0.5">Assign Zona & Baris Massal</h3>
                <p class="text-xs text-amber-100 font-medium mb-4">Centang motor · pilih zona · pilih baris spesifik · klik Assign.</p>

                <div class="space-y-2.5">
                    {{-- Pilih Zona --}}
                    <select name="id_zona" required @change="loadBaris($event.target.value)"
                            class="w-full px-4 py-3 rounded-xl font-bold text-sm appearance-none cursor-pointer"
                            style="background: rgba(255,255,255,0.18); border: 1.5px solid rgba(255,255,255,0.3); color: white; outline: none;">
                        <option value="" disabled selected class="text-gray-800">Pilih Zona Tujuan</option>
                        @foreach($semuaZona as $zona)
                            <option value="{{ $zona->id }}" class="text-gray-800">Zona {{ $zona->nama_zona }} (Sisa: {{ $zona->sisa_kuota }})</option>
                        @endforeach
                    </select>

                    {{-- Pilih Baris (wajib setelah zona dipilih) --}}
                    <div x-show="barisList.length > 0" x-transition style="display:none;">
                        <select name="id_baris" required
                                @change="pilihBaris($event.target.value)"
                                class="w-full px-4 py-3 rounded-xl font-bold text-sm appearance-none cursor-pointer"
                                style="background: rgba(255,255,255,0.18); border: 1.5px solid rgba(255,255,255,0.3); color: white; outline: none;">
                            <option value="" class="text-gray-800">— Pilih Baris Parkir —</option>
                            <template x-for="b in barisList" :key="b.id">
                                <option :value="b.id" class="text-gray-800"
                                        x-text="b.nama_baris + ' · Petak ' + b.slot_awal + '–' + b.slot_akhir + ' (Sisa: ' + b.sisa + '/' + b.kapasitas + ')' + (b.aturan_label ? ' ⚠ ' + b.aturan_label : '')"
                                        :disabled="b.sisa === 0"></option>
                            </template>
                        </select>
                    </div>

                    {{-- Info Preview Range Petak (muncul setelah baris dipilih) --}}
                    <div x-show="barisTerpilih" x-transition style="display:none;"
                         class="rounded-xl px-4 py-3"
                         style="background: rgba(255,255,255,0.12); border: 1.5px solid rgba(255,255,255,0.3);">
                        <p class="text-[10px] font-bold uppercase tracking-widest mb-1" style="color:rgba(255,255,255,0.5);">INFO PETAK OTOMATIS</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-extrabold text-white" x-text="'Petak ' + barisTerpilih?.slot_awal + ' – ' + barisTerpilih?.slot_akhir"></p>
                                <p class="text-[11px] font-semibold" style="color:rgba(255,255,255,0.65);"
                                   x-text="barisTerpilih?.sisa + ' petak kosong dari ' + barisTerpilih?.kapasitas"></p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-bold uppercase" style="color:rgba(255,255,255,0.5);">Akan Diisi</p>
                                <p class="text-sm font-extrabold text-white"
                                   x-text="jumlahDicentang + ' motor → Petak ' + barisTerpilih?.slot_awal"></p>
                            </div>
                        </div>
                        {{-- Peringatan aturan --}}
                        <template x-if="barisTerpilih?.aturan_label">
                            <div class="mt-2 rounded-lg px-3 py-2 flex items-center gap-2"
                                 style="background:rgba(234,179,8,0.15); border:1px solid rgba(234,179,8,0.3);">
                                <span class="material-icons text-[14px]" style="color:#eab308;">warning</span>
                                <p class="text-[10px] font-bold" style="color:#fef08a;">
                                    ATURAN BARIS: Hanya menerima motor <span x-text="barisTerpilih?.aturan_label" class="font-extrabold underline"></span>
                                </p>
                            </div>
                        </template>
                    </div>

                    <button type="submit"
                            class="w-full px-5 py-3 rounded-xl font-extrabold text-sm tracking-widest uppercase transition-all"
                            style="background: white; color: #c2652a; box-shadow: 0 2px 8px rgba(0,0,0,0.15);"
                            onmouseenter="this.style.background='#faf8f5'"
                            onmouseleave="this.style.background='white'">
                        Assign & Auto-Slot Sekarang
                    </button>
                </div>
            </div>
        </form>

        {{-- ---- Panel Hapus Kelas ---- --}}
        <div class="bg-white rounded-2xl p-5 sm:p-6 border relative overflow-hidden" style="border-color: #e8e1d7;">
            <div class="absolute -right-4 -bottom-4 opacity-5 pointer-events-none" aria-hidden="true">
                <span class="material-icons text-[100px]" style="color: #dc2626;">school</span>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-0.5">
                    <span class="material-icons text-[18px] text-red-500">warning_amber</span>
                    <h3 class="text-sm font-extrabold" style="color: #2d241e;">Hapus Data Berdasarkan Kelas</h3>
                </div>
                <br>

                <div x-show="!showHapus">
                    <button @click="showHapus = true"
                            class="w-full py-3 rounded-xl text-sm font-bold transition-colors border-2 border-dashed"
                            style="border-color: #fca5a5; color: #dc2626;"
                            onmouseenter="this.style.background='#fef2f2'"
                            onmouseleave="this.style.background='transparent'">
                        <span class="material-icons text-[16px] align-text-bottom mr-1">lock_open</span>
                        Buka Panel Hapus Kelas
                    </button>
                </div>

                <form action="{{ route('admin.kendaraan.hapusAngkatan') }}" method="POST"
                      x-show="showHapus" x-transition style="display:none;"
                      onsubmit="
                        const kelas = this.querySelector('[name=nama_kelas]').value.trim();
                        return confirm('⚠️ PERINGATAN KERAS!\n\nAnda akan menghapus SELURUH SISWA & MOTOR yang kelasnya mengandung:\n\n\"' + kelas + '\"\n\nTindakan ini TIDAK DAPAT DIBATALKAN dan akan segera menghapus data dari server.\n\nKetik OK untuk melanjutkan, atau CANCEL untuk membatalkan.');
                      ">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <input type="text" name="nama_kelas" required
                                   placeholder="Contoh: XII atau XII PPLG 1"
                                   class="block w-full  rounded-xl text-sm font-bold transition-all"
                                   style="background: #fef2f2; border: 1.5px solid #fca5a5; color: #991b1b; outline: none;"
                                   onfocus="this.style.borderColor='#dc2626'"
                                   onblur="this.style.borderColor='#fca5a5'">
                        </div>
                        <button type="submit"
                                class="px-4 py-3 rounded-xl text-xs font-extrabold text-white uppercase tracking-wider whitespace-nowrap"
                                style="background: #dc2626; box-shadow: 0 4px 12px rgba(220,38,38,0.3);"
                                onmouseenter="this.style.background='#b91c1c'"
                                onmouseleave="this.style.background='#dc2626'">
                            Hapus
                        </button>
                    </div>
                    <p class="text-[16px] font-semibold mt-2 text-red-400">
                        Akan menghapus kendaraan dan akun siswa secara permanen!.
                    </p>
                </form>
            </div>
        </div>
    </div>

    {{-- ============================================================
         TABEL DATA + SMART FILTERS
    ============================================================ --}}
    <div x-data="kendaraanTable()" class="bg-white rounded-2xl border overflow-hidden" style="border-color: #e8e1d7;">

        {{-- Table Top Bar --}}
        <div class="px-4 sm:px-6 py-4 border-b" style="border-color: #f0ebe4; background: #faf8f5;">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <h3 class="text-sm sm:text-base font-extrabold" style="color: #2d241e;">Seluruh Data Kendaraan</h3>
                    <p class="text-xs font-medium mt-0.5" style="color: #a89b91;"><span x-text="visibleCount">0</span> motor ditampilkan</p>
                </div>
                {{-- Global Search --}}
                <div class="relative w-full sm:w-72">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-icons text-[18px]" style="color: #a89b91;">search</span>
                    </div>
                    <input type="text" x-model="searchQuery" @input="applyFilters()"
                           placeholder="Cari nama, NIS, plat..."
                           class="block w-full pl-9 pr-4 py-2.5 rounded-xl text-sm font-semibold transition-colors"
                           style="background: white; border: 1.5px solid #e8e1d7; color: #2d241e; outline: none;"
                           onfocus="this.style.borderColor='#c2652a'"
                           onblur="this.style.borderColor='#e8e1d7'">
                </div>
            </div>

            {{-- Column Filters --}}
            <div class="flex flex-wrap gap-2 mt-3">
                {{-- Filter Merek (Warna Zona) --}}
                <select x-model="filterMerek" @change="applyFilters()"
                        class="text-xs font-bold px-3 py-2 rounded-xl cursor-pointer"
                        style="background: white; border: 1.5px solid #e8e1d7; color: #7a6b61; outline: none;">
                    <option value="">Semua Merek</option>
                    @foreach($mereks as $m)
                        <option value="{{ $m->nama_merek }}">{{ $m->nama_merek }}</option>
                    @endforeach
                </select>

                {{-- Filter Warna --}}
                <select x-model="filterWarna" @change="applyFilters()"
                        class="text-xs font-bold px-3 py-2 rounded-xl cursor-pointer"
                        style="background: white; border: 1.5px solid #e8e1d7; color: #7a6b61; outline: none;">
                    <option value="">Semua Warna</option>
                    @foreach($warnaList as $w)
                        <option value="{{ $w }}">{{ $w }}</option>
                    @endforeach
                </select>

                {{-- Filter Transmisi --}}
                <select x-model="filterTransmisi" @change="applyFilters()"
                        class="text-xs font-bold px-3 py-2 rounded-xl cursor-pointer"
                        style="background: white; border: 1.5px solid #e8e1d7; color: #7a6b61; outline: none;">
                    <option value="">Matic & Manual</option>
                    <option value="Matic">Matic</option>
                    <option value="Manual">Manual</option>
                </select>

                {{-- Filter Kelas --}}
                <select x-model="filterKelas" @change="applyFilters()"
                        class="text-xs font-bold px-3 py-2 rounded-xl cursor-pointer"
                        style="background: white; border: 1.5px solid #e8e1d7; color: #7a6b61; outline: none;">
                    <option value="">Semua Kelas</option>
                    @foreach($kendaraans->pluck('kelas')->unique()->sort() as $kelas)
                        <option value="{{ $kelas }}">{{ $kelas }}</option>
                    @endforeach
                </select>

                {{-- Filter Zona --}}
                <select x-model="filterZona" @change="applyFilters()"
                        class="text-xs font-bold px-3 py-2 rounded-xl cursor-pointer"
                        style="background: white; border: 1.5px solid #e8e1d7; color: #7a6b61; outline: none;">
                    <option value="">Semua Zona</option>
                    <option value="belum">Belum Ada Zona</option>
                    @foreach($semuaZona as $z)
                        <option value="{{ $z->nama_zona }}">Zona {{ $z->nama_zona }}</option>
                    @endforeach
                </select>

                {{-- Reset Filter --}}
                <button @click="resetFilters()" x-show="searchQuery || filterMerek || filterWarna || filterTransmisi || filterKelas || filterZona"
                        class="text-xs font-extrabold px-3 py-2 rounded-xl flex items-center gap-1"
                        style="background: rgba(194,101,42,0.08); color: #c2652a; border: 1.5px solid rgba(194,101,42,0.2);">
                    <span class="material-icons text-[13px]">filter_alt_off</span> Reset
                </button>
            </div>
        </div>

        {{-- DESKTOP TABLE --}}
        <div class="hidden md:block overflow-x-auto">
            <div class="max-h-[540px] overflow-y-auto">
                <table id="tabelKendaraan" class="w-full text-sm text-left min-w-[900px]">
                    <thead class="text-[10px] uppercase tracking-widest sticky top-0 z-10"
                           style="color: #a89b91; background: #faf8f5; border-bottom: 1.5px solid #f0ebe4;">
                        <tr>
                            <th class="px-4 py-3.5 w-10 text-center">
                                <input type="checkbox" id="checkAll" class="w-4 h-4 rounded cursor-pointer"
                                       style="accent-color: #c2652a;"
                                       @click="toggleAll($event.target.checked)">
                            </th>
                            <th class="px-4 py-3.5 font-extrabold">NIS</th>
                            <th class="px-4 py-3.5 font-extrabold">Nama Siswa</th>
                            <th class="px-4 py-3.5 font-extrabold">Kelas</th>
                            <th class="px-4 py-3.5 font-extrabold">Merek & Tipe</th>
                            <th class="px-4 py-3.5 font-extrabold">Warna</th>
                            <th class="px-4 py-3.5 font-extrabold">Transmisi</th>
                            <th class="px-4 py-3.5 font-extrabold">Zona / Baris</th>
                            <th class="px-4 py-3.5 font-extrabold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="color: #2d241e;">
                        @forelse($kendaraans as $kendaraan)
                            <tr class="border-b baris-data transition-colors"
                                style="border-color: #f0ebe4;"
                                data-nis="{{ strtolower($kendaraan->user->nis_nip ?? '') }}"
                                data-nama="{{ strtolower($kendaraan->user->nama_lengkap ?? '') }}"
                                data-kelas="{{ $kendaraan->kelas }}"
                                data-plat="{{ strtolower($kendaraan->plat_nomor) }}"
                                data-zona="{{ $kendaraan->zona ? $kendaraan->zona->nama_zona : 'belum' }}"
                                data-merek="{{ $kendaraan->merek->nama_merek ?? '' }}"
                                data-warna="{{ $kendaraan->warna ?? '' }}"
                                data-transmisi="{{ $kendaraan->jenis_transmisi ?? '' }}"
                                onmouseenter="this.style.background='#faf8f5'"
                                onmouseleave="this.style.background='white'">
                                <td class="px-4 py-3 text-center">
                                    <input type="checkbox" name="kendaraan_ids[]" value="{{ $kendaraan->id }}"
                                           form="formBulkAssign"
                                           class="kendaraan-checkbox w-4 h-4 rounded cursor-pointer"
                                           style="accent-color: #c2652a;">
                                </td>
                                <td class="px-4 py-3 font-extrabold text-sm">{{ $kendaraan->user->nis_nip ?? '-' }}</td>
                                <td class="px-4 py-3 font-bold uppercase text-sm">{{ $kendaraan->user->nama_lengkap ?? '-' }}</td>
                                <td class="px-4 py-3 font-semibold text-xs" style="color: #7a6b61;">{{ $kendaraan->kelas }}</td>
                                <td class="px-4 py-3 font-semibold text-xs uppercase" style="color: #7a6b61;">
                                    {{ $kendaraan->merek->nama_merek ?? '-' }} {{ $kendaraan->model_motor }}
                                </td>
                                <td class="px-4 py-3">
                                    @if($kendaraan->warna)
                                        <span class="text-xs font-bold px-2 py-1 rounded-lg" style="background:#faf8f5; color:#2d241e; border:1px solid #e8e1d7;">{{ $kendaraan->warna }}</span>
                                    @else
                                        <span class="text-xs" style="color:#a89b91;">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($kendaraan->jenis_transmisi)
                                        <span class="text-xs font-extrabold px-2 py-1 rounded-lg"
                                              style="background: {{ $kendaraan->jenis_transmisi === 'Matic' ? 'rgba(26,176,118,0.1)' : 'rgba(194,101,42,0.1)' }}; color: {{ $kendaraan->jenis_transmisi === 'Matic' ? '#1AB076' : '#c2652a' }};">
                                            {{ $kendaraan->jenis_transmisi }}
                                        </span>
                                    @else
                                        <span class="text-xs" style="color:#a89b91;">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($kendaraan->zona)
                                        <div>
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-extrabold border"
                                                  style="background-color: {{ $kendaraan->zona->kode_warna }}18; color: {{ $kendaraan->zona->kode_warna }}; border-color: {{ $kendaraan->zona->kode_warna }}40;">
                                                <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $kendaraan->zona->kode_warna }};"></span>
                                                {{ $kendaraan->zona->nama_zona }}
                                            </span>
                                            @if($kendaraan->baris || $kendaraan->nomor_slot)
                                                <span class="block text-[10px] font-bold mt-1" style="color:#a89b91;">
                                                    {{ $kendaraan->baris->nama_baris ?? '' }}
                                                    @if($kendaraan->nomor_slot)
                                                        <span class="px-1.5 py-0.5 rounded text-[9px] text-white ml-0.5" style="background: #c2652a;">NO: {{ $kendaraan->nomor_slot }}</span>
                                                    @endif
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-extrabold"
                                              style="background: rgba(194,101,42,0.10); color: #8b3a14; border: 1px solid rgba(194,101,42,0.2);">
                                            <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background: #c2652a;"></span>
                                            Belum Ada
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1.5">
                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                                @click="bukaEditModal({{ $kendaraan->id }}, '{{ $kendaraan->plat_nomor }}', '{{ $kendaraan->id_zona ?? '' }}', '{{ $kendaraan->kelas }}', '{{ $kendaraan->id_merek }}', '{{ $kendaraan->model_motor }}', '{{ $kendaraan->id_baris ?? '' }}', '{{ $kendaraan->nomor_slot ?? '' }}')"
                                                class="inline-flex items-center gap-1 px-2.5 py-2 rounded-lg text-xs font-bold transition-all border"
                                                style="border-color: #e8e1d7; color: #7a6b61; background: white;"
                                                onmouseenter="this.style.borderColor='#c2652a'; this.style.color='#c2652a'; this.style.background='rgba(194,101,42,0.06)'"
                                                onmouseleave="this.style.borderColor='#e8e1d7'; this.style.color='#7a6b61'; this.style.background='white'"
                                                title="Edit Kendaraan">
                                            <span class="material-icons text-[15px]">edit_note</span>
                                        </button>
                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.kendaraan.destroy', $kendaraan->id) }}" method="POST"
                                              onsubmit="return confirm('⚠️ Hapus kendaraan?\n\nMotor milik {{ $kendaraan->user->nama_lengkap ?? 'siswa ini' }} ({{ $kendaraan->plat_nomor }}) akan dihapus permanent.\n\nLanjutkan?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-2.5 py-2 rounded-lg text-xs font-bold transition-all border"
                                                    style="border-color: #fca5a5; color: #dc2626; background: white;"
                                                    onmouseenter="this.style.background='#fef2f2'"
                                                    onmouseleave="this.style.background='white'"
                                                    title="Hapus Kendaraan">
                                                <span class="material-icons text-[15px]">delete_outline</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-20 text-center">
                                    <span class="material-icons text-[56px] block mx-auto mb-3" style="color: #e8e1d7;">two_wheeler</span>
                                    <p class="font-extrabold text-lg" style="color: #a89b91;">Belum Ada Kendaraan Terdaftar</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MOBILE: Card List --}}
        <div class="md:hidden divide-y" style="border-color: #f0ebe4; max-height: 60vh; overflow-y: auto;">
            @forelse($kendaraans as $kendaraan)
                <div class="p-4 baris-data"
                     data-nis="{{ strtolower($kendaraan->user->nis_nip ?? '') }}"
                     data-nama="{{ strtolower($kendaraan->user->nama_lengkap ?? '') }}"
                     data-kelas="{{ $kendaraan->kelas }}"
                     data-plat="{{ strtolower($kendaraan->plat_nomor) }}"
                     data-zona="{{ $kendaraan->zona ? $kendaraan->zona->nama_zona : 'belum' }}">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="kendaraan_ids[]" value="{{ $kendaraan->id }}"
                                   form="formBulkAssign"
                                   class="kendaraan-checkbox w-4 h-4 rounded cursor-pointer flex-shrink-0 mt-1"
                                   style="accent-color: #c2652a;">
                            <div>
                                <p class="font-extrabold text-sm leading-tight" style="color: #2d241e;">{{ $kendaraan->user->nama_lengkap ?? '-' }}</p>
                                <p class="text-xs font-bold mt-0.5" style="color: #a89b91;">NIS {{ $kendaraan->user->nis_nip ?? '-' }} · {{ $kendaraan->kelas }}</p>
                                <p class="text-xs font-semibold mt-1 uppercase" style="color: #7a6b61;">
                                    {{ $kendaraan->merek->nama_merek ?? '-' }} {{ $kendaraan->model_motor }}
                                    · <span class="font-extrabold tracking-widest">{{ $kendaraan->plat_nomor }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-2 flex-shrink-0">
                            @if($kendaraan->zona)
                                <span class="text-[9px] font-extrabold px-2 py-1 rounded-lg uppercase tracking-widest"
                                      style="background-color: {{ $kendaraan->zona->kode_warna }}18; color: {{ $kendaraan->zona->kode_warna }}; border: 1px solid {{ $kendaraan->zona->kode_warna }}40;">
                                    {{ $kendaraan->zona->nama_zona }}
                                    @if($kendaraan->nomor_slot) | NO {{ $kendaraan->nomor_slot }} @endif
                                </span>
                            @else
                                <span class="text-[9px] font-extrabold px-2 py-1 rounded-lg"
                                      style="background: rgba(194,101,42,0.10); color: #8b3a14;">Belum Ada</span>
                            @endif
                            <div class="flex gap-1">
                                <button type="button"
                                        @click="bukaEditModal({{ $kendaraan->id }}, '{{ $kendaraan->plat_nomor }}', '{{ $kendaraan->id_zona ?? '' }}', '{{ $kendaraan->kelas }}', '{{ $kendaraan->id_merek }}', '{{ $kendaraan->model_motor }}', '{{ $kendaraan->id_baris ?? '' }}', '{{ $kendaraan->nomor_slot ?? '' }}')"
                                        class="p-1.5 rounded-lg border" style="border-color: #e8e1d7; color: #7a6b61;">
                                    <span class="material-icons text-[14px]">edit_note</span>
                                </button>
                                <form action="{{ route('admin.kendaraan.destroy', $kendaraan->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus motor {{ $kendaraan->user->nama_lengkap ?? 'siswa' }} ({{ $kendaraan->plat_nomor }})?\n\nTindakan ini permanen.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg border" style="border-color: #fca5a5; color: #dc2626;">
                                        <span class="material-icons text-[14px]">delete_outline</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-16 text-center">
                    <span class="material-icons text-[48px] block mx-auto mb-3" style="color: #e8e1d7;">two_wheeler</span>
                    <p class="font-extrabold" style="color: #a89b91;">Belum Ada Kendaraan</p>
                </div>
            @endforelse
        </div>

    </div>

    {{-- ============================================================
         MODAL EDIT
    ============================================================ --}}
    <div x-data="{ open: false, aksi_url: '', plat: '', zona: '', kelas: '', merek: '', tipe: '', baris: '', nmslot: '' }"
         @open-modal-edit.window="open = true; aksi_url = '/admin/kendaraan/' + $event.detail.id; plat = $event.detail.plat; zona = $event.detail.zona; kelas = $event.detail.kelas; merek = $event.detail.merek; tipe = $event.detail.tipe; baris = $event.detail.baris; nmslot = $event.detail.nmslot;"
         x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4"
         style="background: rgba(45,36,30,0.6); backdrop-filter: blur(4px); display: none;">

        <div @click.away="open = false"
             x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-8"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="bg-white w-full sm:max-w-lg rounded-t-3xl sm:rounded-2xl overflow-hidden shadow-2xl max-h-[90vh] overflow-y-auto">

            {{-- Modal Header --}}
            <div class="px-6 py-4 border-b flex items-center justify-between sticky top-0 bg-white" style="border-color: #f0ebe4;">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: rgba(194,101,42,0.10);">
                        <span class="material-icons text-[20px]" style="color: #c2652a;">edit_note</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold" style="color: #2d241e;">Edit Data Kendaraan</h3>
                        <p class="text-xs font-medium" style="color: #a89b91;">Koreksi data atau pindah zona individu</p>
                    </div>
                </div>
                <button @click="open = false" class="p-2 rounded-xl transition-colors" style="color: #a89b91;"
                        onmouseenter="this.style.background='#faf8f5'" onmouseleave="this.style.background='transparent'">
                    <span class="material-icons text-[20px]">close</span>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-5 sm:p-6">
                <form :action="aksi_url" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    {{-- Kelas --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-extrabold uppercase tracking-wider" style="color: #2d241e;">Kelas Siswa</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-icons text-[18px]" style="color: #a89b91;">class</span>
                            </div>
                            <input type="text" name="kelas" x-model="kelas" required
                                   class="block w-full pl-9 pr-4 py-3.5 rounded-xl text-sm font-bold transition-colors"
                                   style="background: #faf8f5; border: 1.5px solid #e8e1d7; color: #2d241e; outline:none;"
                                   onfocus="this.style.borderColor='#c2652a'; this.style.background='white'"
                                   onblur="this.style.borderColor='#e8e1d7'; this.style.background='#faf8f5'">
                        </div>
                    </div>

                    {{-- Merek & Tipe --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-extrabold uppercase tracking-wider" style="color: #2d241e;">Merek</label>
                            <select name="id_merek" x-model="merek" required
                                    class="block w-full px-3 py-3.5 rounded-xl text-sm font-bold transition-colors appearance-none"
                                    style="background: #faf8f5; border: 1.5px solid #e8e1d7; color: #2d241e; outline:none;"
                                    onfocus="this.style.borderColor='#c2652a'"
                                    onblur="this.style.borderColor='#e8e1d7'">
                                <option value="">— Pilih —</option>
                                @foreach($mereks as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama_merek }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-extrabold uppercase tracking-wider" style="color: #2d241e;">Tipe Motor</label>
                            <input type="text" name="model_motor" x-model="tipe" required
                                   class="block w-full px-3 py-3.5 rounded-xl text-sm font-bold transition-colors"
                                   style="background: #faf8f5; border: 1.5px solid #e8e1d7; color: #2d241e; outline:none;"
                                   onfocus="this.style.borderColor='#c2652a'; this.style.background='white'"
                                   onblur="this.style.borderColor='#e8e1d7'; this.style.background='#faf8f5'">
                        </div>
                    </div>

                    {{-- Plat Nomor --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-extrabold uppercase tracking-wider" style="color: #2d241e;">Plat Nomor</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-icons text-[18px]" style="color: #a89b91;">pin</span>
                            </div>
                            <input type="text" name="plat_nomor" x-model="plat" required
                                   class="block w-full pl-9 pr-4 py-3.5 rounded-xl text-sm font-extrabold uppercase tracking-widest transition-colors"
                                   style="background: #faf8f5; border: 1.5px solid #e8e1d7; color: #2d241e; outline:none;"
                                   onfocus="this.style.borderColor='#c2652a'; this.style.background='white'"
                                   onblur="this.style.borderColor='#e8e1d7'; this.style.background='#faf8f5'">
                        </div>
                    </div>

                    {{-- Zona & Baris --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-extrabold uppercase tracking-wider" style="color: #2d241e;">Zona Parkir</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-icons text-[18px]" style="color: #a89b91;">place</span>
                            </div>
                            <select name="id_zona" x-model="zona"
                                    class="block w-full pl-9 pr-4 py-3.5 rounded-xl text-sm font-bold transition-colors appearance-none"
                                    style="background: #faf8f5; border: 1.5px solid #e8e1d7; color: #2d241e; outline:none;"
                                    onfocus="this.style.borderColor='#c2652a'"
                                    onblur="this.style.borderColor='#e8e1d7'">
                                <option value="">— Kosongkan Zona —</option>
                                @foreach($semuaZona as $z)
                                    <option value="{{ $z->id }}">{{ $z->nama_zona }} (Sisa: {{ $z->sisa_kuota }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Baris & Nomor Slot (Baris di modal bisa tidak dinamis utk edit simpel atau dimunculkan statis) --}}
                    {{-- Karena dynamic baris butuh JS tambahan, kita sediakan input Baris via ID jika perlu,
                         namun untuk sekarang kita tambahkan Nomor Slot saja, Baris dilewati atau biarkan apa adanya dari backend / hidden. --}}
                    {{-- Untuk optimalisasi, kita sediakan Nomor Slot bebas --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-extrabold uppercase tracking-wider" style="color: #2d241e;">Nomor Slot (Opsional)</label>
                        <input type="number" name="nomor_slot" x-model="nmslot" min="1"
                               class="block w-full px-4 py-3.5 rounded-xl text-sm font-bold transition-colors"
                               style="background: #faf8f5; border: 1.5px solid #e8e1d7; color: #2d241e; outline:none;"
                               placeholder="Contoh: 12">
                    </div>

                    {{-- Footer Actions --}}
                    <div class="flex gap-3 pt-3 border-t" style="border-color: #f0ebe4;">
                        <button type="button" @click="open = false"
                                class="flex-1 py-3 rounded-xl text-sm font-bold transition-colors"
                                style="background: #faf8f5; color: #7a6b61; border: 1.5px solid #e8e1d7;"
                                onmouseenter="this.style.background='#f0ebe4'"
                                onmouseleave="this.style.background='#faf8f5'">
                            Batal
                        </button>
                        <button type="submit"
                                class="flex-1 py-3 rounded-xl text-sm font-extrabold text-white tracking-wider uppercase transition-colors"
                                style="background: #c2652a; box-shadow: 0 4px 12px rgba(194,101,42,0.35);"
                                onmouseenter="this.style.background='#a8551e'"
                                onmouseleave="this.style.background='#c2652a'">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ============================================================
         ALPINE SCRIPT
    ============================================================ --}}
    <script>
        document.addEventListener('alpine:init', () => {

            // Data untuk filter tabel
            Alpine.data('kendaraanTable', () => ({
                searchQuery: '',
                filterMerek: '',
                filterWarna: '',
                filterTransmisi: '',
                filterKelas: '',
                filterZona: '',
                visibleCount: {{ $kendaraans->count() }},

                applyFilters() {
                    const sq = this.searchQuery.toLowerCase();
                    const fm = this.filterMerek.toLowerCase();
                    const fw = this.filterWarna.toLowerCase();
                    const ft = this.filterTransmisi.toLowerCase();
                    const fk = this.filterKelas.toLowerCase();
                    const fz = this.filterZona.toLowerCase();
                    let count = 0;

                    document.querySelectorAll('.baris-data').forEach(row => {
                        const matchSearch     = !sq || (row.dataset.nis||'').includes(sq) || (row.dataset.nama||'').includes(sq) || (row.dataset.plat||'').includes(sq);
                        const matchMerek      = !fm || (row.dataset.merek||'').toLowerCase() === fm;
                        const matchWarna      = !fw || (row.dataset.warna||'').toLowerCase() === fw;
                        const matchTransmisi  = !ft || (row.dataset.transmisi||'').toLowerCase() === ft;
                        const matchKelas      = !fk || (row.dataset.kelas||'').toLowerCase() === fk;
                        const matchZona       = !fz || (fz === 'belum' ? (row.dataset.zona||'') === 'belum' : (row.dataset.zona||'').toLowerCase() === fz);

                        const visible = matchSearch && matchMerek && matchWarna && matchTransmisi && matchKelas && matchZona;
                        row.style.display = visible ? '' : 'none';

                        if (!visible) {
                            const cb = row.querySelector('.kendaraan-checkbox');
                            if (cb && cb.checked) cb.checked = false;
                        } else { count++; }
                    });
                    this.visibleCount = count;
                },

                resetFilters() {
                    this.searchQuery = this.filterMerek = this.filterWarna =
                    this.filterTransmisi = this.filterKelas = this.filterZona = '';
                    this.applyFilters();
                },

                toggleAll(isChecked) {
                    document.querySelectorAll('.kendaraan-checkbox').forEach(cb => {
                        const row = cb.closest('.baris-data');
                        if (row && row.style.display !== 'none') cb.checked = isChecked;
                    });
                },

                bukaEditModal(id, plat, id_zona, kelas, id_merek, model_motor, id_baris, nomor_slot) {
                    this.$dispatch('open-modal-edit', { 
                        id, plat, zona: id_zona || '', kelas, merek: id_merek, tipe: model_motor,
                        baris: id_baris || '', nmslot: nomor_slot || ''
                    });
                }
            }));

            // Data untuk panel Bulk Assign (dynamic baris loader + auto-range preview)
            Alpine.data('bulkAssignPanel', () => ({
                barisList: [],
                barisTerpilih: null,
                jumlahDicentang: 0,

                init() {
                    // Pantau jumlah checkbox dicentang secara real-time
                    const updateCount = () => {
                        const checkedNodes = document.querySelectorAll('.kendaraan-checkbox:checked');
                        const uniqueIds = new Set();
                        checkedNodes.forEach(cb => uniqueIds.add(cb.value));
                        this.jumlahDicentang = uniqueIds.size;
                    };
                    document.addEventListener('change', (e) => {
                        if (e.target.classList.contains('kendaraan-checkbox')) updateCount();
                    });
                    // Pantau tombol Pilih Semua
                    document.addEventListener('click', () => {
                        setTimeout(updateCount, 50);
                    });
                },

                loadBaris(zonaId) {
                    this.barisList = [];
                    this.barisTerpilih = null;
                    if (!zonaId) return;
                    fetch(`/admin/zona/${zonaId}/baris-options`)
                        .then(r => r.json())
                        .then(data => { this.barisList = data; })
                        .catch(() => { this.barisList = []; });
                },

                pilihBaris(barisId) {
                    this.barisTerpilih = this.barisList.find(b => b.id == barisId) || null;
                }
            }));
        });
    </script>

</x-admin-layout>
