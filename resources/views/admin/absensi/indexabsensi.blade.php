<x-admin-layout>
    <x-slot name="title">Radar Absensi Harian</x-slot>

    <div x-data="absensiRadar()" x-init="startClock()">

        {{-- ============================================================
             HEADER & FILTER TANGGAL
        ============================================================ --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-5 gap-3">
            <div>
                <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight" style="color: var(--on-s);">Radar Parkir Harian</h2>
                <p class="text-xs sm:text-sm font-medium mt-0.5" style="color: var(--on-v);">Pantau pergerakan masuk dan keluar kendaraan siswa secara <em>Real-Time</em>.</p>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 w-full sm:w-auto">
                {{-- Live Clock WIB --}}
                <div class="flex items-center gap-2 px-3 py-2.5 rounded-xl font-mono border" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse flex-shrink-0"></span>
                    <span class="font-extrabold text-sm tracking-widest" style="color: var(--on-s);" x-text="currentTime"></span>
                    <span class="text-[10px] font-bold" style="color: var(--on-v);">WIB</span>
                </div>

                {{-- Filter Tanggal --}}
                <form action="{{ route('admin.absensi.index') }}" method="GET"
                      class="flex items-center overflow-hidden w-full sm:w-auto rounded-xl border transition-colors"
                      style="background: rgba(255,255,255,0.02); border-color: var(--outline-v);"
                      onfocusin="this.style.borderColor='rgba(255,255,255,0.3)'"
                      onfocusout="this.style.borderColor='var(--outline-v)'">
                    <span class="material-icons pl-3 text-[18px] flex-shrink-0" style="color: var(--on-v);">calendar_month</span>
                    <input type="date" name="tanggal" value="{{ $tanggalPilihan }}"
                           class="border-0 bg-transparent text-xs font-bold focus:ring-0 cursor-pointer px-2 py-2.5 flex-1 appearance-none"
                           style="color: var(--on-s); outline:none; color-scheme: dark;">
                    <button type="submit"
                            class="px-4 py-2.5 text-xs font-extrabold uppercase tracking-widest flex-shrink-0 transition-colors"
                            style="background: white; color: black;"
                            onmouseenter="this.style.background='#e4e4e7'"
                            onmouseleave="this.style.background='white'">
                        Sorot
                    </button>
                </form>
            </div>
        </div>

        {{-- ============================================================
             3 STATISTIK CARD
        ============================================================ --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">

            {{-- TOTAL MASUK (Dark Sahara) --}}
            <div @click="setFilter('semua')"
                 class="cursor-pointer rounded-2xl p-5 relative overflow-hidden transition-all duration-200 flex flex-col justify-between min-h-[130px] border"
                 style="background: var(--sl2); border-color: var(--outline-v);"
                 :class="activeFilter === 'semua' ? 'ring-1 ring-offset-0 ring-white scale-[1.02]' : ''">
                <div class="absolute -right-5 -bottom-5 opacity-[0.03] pointer-events-none">
                    <span class="material-icons text-[100px]" style="color: var(--on-s);">two_wheeler</span>
                </div>
                <div>
                    <p class="text-[9px] font-extrabold tracking-widest uppercase mb-1" style="color: var(--on-v);">Total Kendaraan Masuk</p>
                    <h3 class="text-4xl sm:text-5xl font-extrabold leading-none" style="color: var(--on-s);">{{ $totalMasuk }}</h3>
                    <span class="text-sm font-bold" style="color: var(--on-v);">Motor</span>
                </div>
                <p class="text-[10px] font-extrabold mt-3 flex items-center gap-1" style="color: var(--on-v);">
                    <span class="material-icons text-[12px]">filter_alt</span>
                    Klik lihat semua
                </p>
            </div>

            {{-- MASIH PARKIR (Emerald) --}}
            <div @click="setFilter('parkir')"
                 class="cursor-pointer rounded-2xl p-5 relative overflow-hidden transition-all duration-200 flex flex-col justify-between min-h-[130px] border"
                 style="background: var(--sl2); border-color: rgba(16,185,129,0.3);"
                 :class="activeFilter === 'parkir' ? 'ring-1 ring-offset-0 ring-emerald-500 scale-[1.02]' : ''">
                <div class="absolute -right-5 -bottom-5 opacity-10 animate-pulse pointer-events-none">
                    <span class="material-icons text-[100px] text-emerald-500">sensors</span>
                </div>
                <div>
                    <p class="text-[9px] font-extrabold tracking-widest uppercase mb-1 text-emerald-400">Masih Di Sekolah</p>
                    <h3 class="text-4xl sm:text-5xl font-extrabold leading-none" style="color: var(--on-s);">{{ $totalMasihParkir }}</h3>
                    <span class="text-sm font-bold text-emerald-400">Motor Aktif</span>
                </div>
                <p class="text-[10px] font-extrabold mt-3 flex items-center gap-1 text-emerald-500">
                    <span class="material-icons text-[12px]">filter_alt</span>
                    Klik untuk filter
                </p>
            </div>

            {{-- SUDAH PULANG (Neutral Warm) --}}
            <div @click="setFilter('pulang')"
                 class="cursor-pointer rounded-2xl p-5 relative overflow-hidden transition-all duration-200 flex flex-col justify-between min-h-[130px] border"
                 style="background: var(--sl2); border-color: var(--outline-v);"
                 :class="activeFilter === 'pulang' ? 'ring-1 ring-offset-0 ring-zinc-500 scale-[1.02]' : ''">
                <div class="absolute -right-5 -bottom-5 opacity-[0.03] pointer-events-none">
                    <span class="material-icons text-[100px]" style="color: var(--on-s);">home</span>
                </div>
                <div>
                    <p class="text-[9px] font-extrabold tracking-widest uppercase mb-1" style="color: var(--on-v);">Telah Pulang</p>
                    <h3 class="text-4xl sm:text-5xl font-extrabold leading-none" style="color: var(--on-s);">{{ $totalSudahPulang }}</h3>
                    <span class="text-sm font-bold" style="color: var(--on-v);">Motor</span>
                </div>
                <p class="text-[10px] font-extrabold mt-3 flex items-center gap-1" style="color: var(--on-v);">
                    <span class="material-icons text-[12px]">filter_alt</span>
                    Klik untuk filter
                </p>
            </div>
        </div>

        {{-- ============================================================
             TABLE PANEL + SMART FILTERS
        ============================================================ --}}
        <div class="rounded-2xl border overflow-hidden" style="background: var(--sl2); border-color: var(--outline-v);">

            {{-- Panel Header --}}
            <div class="px-4 sm:px-6 py-4 border-b" style="border-color: var(--outline-v); background: transparent;">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-3">
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold" style="color: var(--on-s);">
                            Daftar Log Absensi
                            <span class="font-medium" style="color: var(--on-v);">({{ \Carbon\Carbon::parse($tanggalPilihan)->translatedFormat('d F Y') }})</span>
                        </h3>
                        <p class="text-xs font-medium mt-0.5" style="color: var(--on-v);">
                            <span x-text="visibleCount">0</span> entri ditampilkan
                        </p>
                    </div>

                    {{-- Tab Status Filter --}}
                    <div class="flex items-center gap-1 p-1 rounded-xl flex-shrink-0 border" style="background: rgba(255,255,255,0.02); border-color: var(--outline-v);">
                        <button @click="setFilter('semua')"
                                class="px-3 py-1.5 text-xs font-extrabold rounded-lg transition-all"
                                :class="activeFilter === 'semua'
                                    ? 'bg-white text-black shadow-sm'
                                    : 'text-[var(--on-v)] hover:text-[var(--on-s)]'">
                            Semua
                            <span class="ml-1 text-[10px]">{{ $totalMasuk }}</span>
                        </button>
                        <button @click="setFilter('parkir')"
                                class="px-3 py-1.5 text-xs font-extrabold rounded-lg transition-all"
                                :class="activeFilter === 'parkir'
                                    ? 'bg-emerald-600 text-white shadow-sm'
                                    : 'text-[var(--on-v)] hover:text-[var(--on-s)]'">
                            <span class="inline-flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"
                                      :class="activeFilter === 'parkir' ? '' : 'bg-emerald-500'"></span>
                                Parkir
                            </span>
                            <span class="ml-1 text-[10px]">{{ $totalMasihParkir }}</span>
                        </button>
                        <button @click="setFilter('pulang')"
                                class="px-3 py-1.5 text-xs font-extrabold rounded-lg transition-all"
                                :class="activeFilter === 'pulang'
                                    ? 'text-white shadow-sm bg-zinc-700'
                                    : 'text-[var(--on-v)] hover:text-[var(--on-s)]'">
                            Pulang
                            <span class="ml-1 text-[10px]">{{ $totalSudahPulang }}</span>
                        </button>
                    </div>
                </div>

                {{-- Smart Filter Row: Search + Kelas + Zona --}}
                <div class="flex flex-wrap gap-2 items-center">

                    {{-- Global Search --}}
                    <div class="relative flex-1 min-w-[160px]">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-icons text-[16px]" style="color: var(--on-v);">search</span>
                        </div>
                        <input type="text" x-model="searchQuery" @input="applyFilters()"
                               placeholder="Cari nama, NIS, plat..."
                               class="block w-full pl-8 pr-3 py-2 rounded-xl text-xs font-semibold transition-colors outline-none"
                               style="background: rgba(255,255,255,0.02); border: 1px solid var(--outline-v); color: var(--on-s);"
                               onfocus="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.background='rgba(255,255,255,0.05)'"
                               onblur="this.style.borderColor='var(--outline-v)'; this.style.background='rgba(255,255,255,0.02)'">
                    </div>

                    {{-- Filter Kelas --}}
                    <select x-model="filterKelas" @change="applyFilters()"
                            class="text-xs font-bold px-3 py-2 rounded-xl cursor-pointer transition-colors outline-none"
                            style="background: rgba(255,255,255,0.02); border: 1px solid var(--outline-v); color: var(--on-s);"
                            onfocus="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.background='rgba(255,255,255,0.05)'"
                            onblur="this.style.borderColor='var(--outline-v)'; this.style.background='rgba(255,255,255,0.02)'">
                        <option value="" style="background: var(--sl2); color: var(--on-s);">Semua Kelas</option>
                        @foreach($absensis->map(fn($a) => optional($a->user)->kelas)->filter()->unique()->sort() as $kls)
                            <option value="{{ $kls }}" style="background: var(--sl2); color: var(--on-s);">{{ $kls }}</option>
                        @endforeach
                    </select>

                    {{-- Filter Zona --}}
                    <select x-model="filterZona" @change="applyFilters()"
                            class="text-xs font-bold px-3 py-2 rounded-xl cursor-pointer transition-colors outline-none"
                            style="background: rgba(255,255,255,0.02); border: 1px solid var(--outline-v); color: var(--on-s);"
                            onfocus="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.background='rgba(255,255,255,0.05)'"
                            onblur="this.style.borderColor='var(--outline-v)'; this.style.background='rgba(255,255,255,0.02)'">
                        <option value="" style="background: var(--sl2); color: var(--on-s);">Semua Zona</option>
                        <option value="belum" style="background: var(--sl2); color: var(--on-s);">Belum Ada Zona</option>
                        @foreach($absensis->map(fn($a) => optional(optional($a->user)->kendaraan)->zona)->filter()->unique('id') as $z)
                            <option value="{{ $z->nama_zona }}" style="background: var(--sl2); color: var(--on-s);">Zona {{ $z->nama_zona }}</option>
                        @endforeach
                    </select>

                    {{-- Reset Button (hanya muncul kalau ada filter aktif) --}}
                    <button @click="resetFilters()"
                            x-show="searchQuery || filterKelas || filterZona"
                            class="text-[10px] font-extrabold px-3 py-2 rounded-xl flex items-center gap-1 flex-shrink-0 transition-colors border"
                            style="background: rgba(255,255,255,0.05); color: var(--on-v); border-color: rgba(255,255,255,0.1);"
                            onmouseover="this.style.color='var(--on-s)'; this.style.background='rgba(255,255,255,0.1)'"
                            onmouseout="this.style.color='var(--on-v)'; this.style.background='rgba(255,255,255,0.05)'">
                        <span class="material-icons text-[13px]">filter_alt_off</span>
                        Reset
                    </button>
                </div>
            </div>

            {{-- ============================================================
                 DESKTOP TABLE
            ============================================================ --}}
            <div class="hidden md:block overflow-x-auto">
                <div class="max-h-[600px] overflow-y-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[10px] uppercase tracking-widest sticky top-0 z-10"
                               style="color: var(--on-v); background: var(--sl2); border-bottom: 1px solid var(--outline-v);">
                            <tr>
                                <th class="px-6 py-3.5 font-extrabold">Identitas Siswa</th>
                                <th class="px-6 py-3.5 font-extrabold">Kendaraan & Zona</th>
                                <th class="px-6 py-3.5 font-extrabold text-center">Masuk</th>
                                <th class="px-6 py-3.5 font-extrabold text-center">Keluar</th>
                                <th class="px-6 py-3.5 font-extrabold text-center">Durasi</th>
                                <th class="px-6 py-3.5 font-extrabold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody style="color: var(--on-s);">
                            @forelse($absensis as $absen)
                                @php
                                    $statusAbsen = $absen->waktu_keluar ? 'pulang' : 'parkir';
                                    $kelasAbsen  = optional($absen->user)->kelas ?? '';
                                    $zonaAbsen   = optional(optional($absen->user)->kendaraan)->zona->nama_zona ?? 'belum';
                                    $namaAbsen   = strtolower(optional($absen->user)->nama_lengkap ?? '');
                                    $nisAbsen    = strtolower(optional($absen->user)->nis_nip ?? '');
                                    $platAbsen   = strtolower(optional(optional($absen->user)->kendaraan)->plat_nomor ?? '');
                                @endphp
                                <tr class="border-b baris-absensi transition-colors"
                                    style="border-color: var(--outline-v); {{ $statusAbsen === 'parkir' ? 'border-left: 3px solid #059669;' : '' }}"
                                    data-status="{{ $statusAbsen }}"
                                    data-kelas="{{ $kelasAbsen }}"
                                    data-zona="{{ strtolower($zonaAbsen) }}"
                                    data-nama="{{ $namaAbsen }}"
                                    data-nis="{{ $nisAbsen }}"
                                    data-plat="{{ $platAbsen }}"
                                    onmouseenter="this.style.background='rgba(255,255,255,0.02)'"
                                    onmouseleave="this.style.background='transparent'">

                                    {{-- Identitas --}}
                                    <td class="px-6 py-4">
                                        <p class="font-extrabold text-sm">{{ optional($absen->user)->nama_lengkap ?? '-' }}</p>
                                        <p class="text-xs font-bold mt-0.5" style="color: var(--on-v);">{{ optional($absen->user)->nis_nip ?? '-' }}</p>
                                        @if($kelasAbsen)
                                            <span class="inline-block mt-1 text-[9px] font-extrabold uppercase tracking-wider px-2 py-0.5 rounded-md"
                                                  style="background: rgba(255,255,255,0.05); color: var(--on-v);">{{ $kelasAbsen }}</span>
                                        @endif
                                    </td>

                                    {{-- Kendaraan --}}
                                    <td class="px-6 py-4">
                                        @if(optional($absen->user)->kendaraan)
                                            <p class="font-extrabold text-sm uppercase tracking-widest">{{ $absen->user->kendaraan->plat_nomor }}</p>
                                            @if(optional($absen->user->kendaraan)->zona)
                                                <div class="flex items-center gap-1.5 mt-1">
                                                    <span class="w-2 h-2 rounded-full flex-shrink-0"
                                                          style="background-color: {{ $absen->user->kendaraan->zona->kode_warna }}"></span>
                                                    <span class="text-xs font-bold" style="color: var(--on-v);">
                                                        Zona {{ $absen->user->kendaraan->zona->nama_zona }}
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-[10px] font-extrabold mt-1 inline-block" style="color: var(--on-v);">Belum Ada Zona</span>
                                            @endif
                                        @else
                                            <span class="text-xs font-bold" style="color: var(--on-v);">Data tidak ditemukan</span>
                                        @endif
                                    </td>

                                    {{-- Waktu Masuk --}}
                                    <td class="px-6 py-4 text-center">
                                        <p class="font-extrabold text-lg leading-none" style="color: var(--on-s);">
                                            {{ $absen->waktu_masuk ? $absen->waktu_masuk->format('H:i') : '-' }}
                                        </p>
                                        <p class="text-[10px] font-bold mt-0.5" style="color: var(--on-v);">WIB</p>
                                    </td>

                                    {{-- Waktu Keluar --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($absen->waktu_keluar)
                                            <p class="font-extrabold text-lg leading-none" style="color: var(--on-s);">{{ $absen->waktu_keluar->format('H:i') }}</p>
                                            <p class="text-[10px] font-bold mt-0.5" style="color: var(--on-v);">WIB</p>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-emerald-400 font-bold text-xs">
                                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                                Masih di sini
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Durasi --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($absen->waktu_keluar && $absen->waktu_masuk)
                                            @php
                                                $durasi = $absen->waktu_masuk->diffInMinutes($absen->waktu_keluar);
                                                $jam    = intdiv($durasi, 60);
                                                $menit  = $durasi % 60;
                                            @endphp
                                            <span class="font-extrabold text-sm" style="color: var(--on-s);">{{ $jam > 0 ? $jam.'j ' : '' }}{{ $menit }}m</span>
                                        @else
                                            <span style="color: var(--outline-v);">—</span>
                                        @endif
                                    </td>

                                    {{-- Bukti GPS + Foto --}}
                                    <td class="px-6 py-4 text-center" x-data="{}">
                                        @if($absen->foto_bukti_masuk)
                                            <button type="button"
                                                    @click="$dispatch('open-bukti', { src: '{{ Storage::url($absen->foto_bukti_masuk) }}', jarak: '{{ $absen->jarak_dari_sekolah ? number_format($absen->jarak_dari_sekolah, 0, ',', '.') . 'm' : 'GPS tidak aktif' }}' })"
                                                    class="mx-auto flex flex-col items-center gap-1 group">
                                                <img src="{{ Storage::url($absen->foto_bukti_masuk) }}"
                                                     class="w-10 h-10 rounded-lg object-cover border-2 border-transparent group-hover:border-emerald-500 transition-all shadow"
                                                     alt="Bukti">
                                                @if($absen->jarak_dari_sekolah)
                                                    <span class="text-[9px] font-extrabold text-emerald-400">{{ number_format($absen->jarak_dari_sekolah, 0, ',', '.') }}m ✓</span>
                                                @endif
                                            </button>
                                        @elseif($absen->jarak_dari_sekolah)
                                            <span class="text-[10px] font-bold text-emerald-400">{{ number_format($absen->jarak_dari_sekolah, 0, ',', '.') }}m ✓</span>
                                        @else
                                            <span style="color:var(--outline-v); font-size:18px;" class="material-icons">image_not_supported</span>
                                        @endif
                                    </td>

                                    {{-- Status Badge --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($absen->waktu_keluar)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-extrabold uppercase border"
                                                  style="background: rgba(255,255,255,0.02); color: var(--on-v); border-color: var(--outline-v);">
                                                <span class="material-icons text-[12px]">done</span>
                                                Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-extrabold uppercase border"
                                                  style="background: rgba(16,185,129,0.1); color: #34d399; border-color: rgba(16,185,129,0.2);">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                Parkir
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-20 text-center border-b" style="border-color: var(--outline-v);">
                                        <span class="material-icons text-[56px] block mx-auto mb-3" style="color: var(--outline-v);">schedule</span>
                                        <p class="font-extrabold text-lg" style="color: var(--on-s);">Belum Ada Pergerakan</p>
                                        <p class="text-sm font-medium mt-1" style="color: var(--on-v);">Belum ada motor yang masuk parkiran pada tanggal ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Empty state saat filter aktif tapi tidak ada yg cocok --}}
                <div x-show="visibleCount === 0 && {{ $totalMasuk }} > 0" x-transition class="py-14 text-center px-6">
                    <span class="material-icons text-[48px] block mx-auto mb-3" style="color: var(--outline-v);">manage_search</span>
                    <p class="font-extrabold" style="color: var(--on-s);">Tidak ada data yang cocok dengan filter ini.</p>
                    <button @click="resetFilters(); setFilter('semua')"
                            class="mt-3 text-xs font-extrabold underline" style="color: var(--on-v);">
                        Reset Semua Filter
                    </button>
                </div>
            </div>

            {{-- ============================================================
                 MOBILE CARD LIST
            ============================================================ --}}
            <div class="md:hidden divide-y" style="border-color: var(--outline-v); max-height: 65vh; overflow-y: auto;">
                @forelse($absensis as $absen)
                    @php
                        $statusAbsenM = $absen->waktu_keluar ? 'pulang' : 'parkir';
                        $kelasAbsenM  = optional($absen->user)->kelas ?? '';
                        $zonaAbsenM   = optional(optional($absen->user)->kendaraan)->zona->nama_zona ?? 'belum';
                        $namaAbsenM   = strtolower(optional($absen->user)->nama_lengkap ?? '');
                        $nisAbsenM    = strtolower(optional($absen->user)->nis_nip ?? '');
                        $platAbsenM   = strtolower(optional(optional($absen->user)->kendaraan)->plat_nomor ?? '');
                    @endphp
                    <div class="p-4 baris-absensi {{ $statusAbsenM === 'parkir' ? 'border-l-4' : '' }}"
                         style="{{ $statusAbsenM === 'parkir' ? 'border-left-color: #059669;' : '' }}"
                         data-status="{{ $statusAbsenM }}"
                         data-kelas="{{ $kelasAbsenM }}"
                         data-zona="{{ strtolower($zonaAbsenM) }}"
                         data-nama="{{ $namaAbsenM }}"
                         data-nis="{{ $nisAbsenM }}"
                         data-plat="{{ $platAbsenM }}">

                        <div class="flex justify-between items-start gap-3">
                            <div class="min-w-0">
                                <p class="font-extrabold text-sm leading-tight truncate" style="color: var(--on-s);">
                                    {{ optional($absen->user)->nama_lengkap ?? '-' }}
                                </p>
                                <p class="text-xs font-bold mt-0.5" style="color: var(--on-v);">
                                    {{ optional($absen->user)->nis_nip ?? '-' }}
                                </p>
                                @if($kelasAbsenM)
                                    <span class="inline-block mt-1 text-[9px] font-extrabold uppercase tracking-wider px-1.5 py-0.5 rounded"
                                          style="background: rgba(255,255,255,0.05); color: var(--on-v);">{{ $kelasAbsenM }}</span>
                                @endif
                            </div>

                            {{-- Status --}}
                            @if($absen->waktu_keluar)
                                <span class="flex-shrink-0 inline-flex items-center gap-1 px-2 py-1 rounded-lg text-[10px] font-extrabold border"
                                      style="background: rgba(255,255,255,0.02); color: var(--on-v); border-color: var(--outline-v);">
                                    <span class="material-icons text-[11px]">done</span> Selesai
                                </span>
                            @else
                                <span class="flex-shrink-0 inline-flex items-center gap-1 px-2 py-1 rounded-lg text-[10px] font-extrabold border"
                                      style="background: rgba(16,185,129,0.1); color: #34d399; border-color: rgba(16,185,129,0.2);">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Masih Parkir
                                </span>
                            @endif
                        </div>

                        {{-- Metric Row --}}
                        <div class="grid grid-cols-3 gap-2 mt-3">
                            <div class="rounded-xl p-2 text-center" style="background: rgba(255,255,255,0.02); border: 1px solid var(--outline-v);">
                                <p class="text-[9px] font-extrabold uppercase tracking-wider mb-0.5" style="color: var(--on-v);">Plat</p>
                                <p class="font-extrabold text-xs uppercase tracking-widest" style="color: var(--on-s);">
                                    {{ optional(optional($absen->user)->kendaraan)->plat_nomor ?? '-' }}
                                </p>
                            </div>
                            <div class="rounded-xl p-2 text-center" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                                <p class="text-[9px] font-extrabold uppercase tracking-wider mb-0.5" style="color: var(--on-v);">Masuk</p>
                                <p class="font-extrabold text-sm leading-none" style="color: var(--on-s);">
                                    {{ $absen->waktu_masuk ? $absen->waktu_masuk->format('H:i') : '-' }}
                                </p>
                            </div>
                            <div class="rounded-xl p-2 text-center" style="background: rgba(255,255,255,0.02); border: 1px solid var(--outline-v);">
                                <p class="text-[9px] font-extrabold uppercase tracking-wider mb-0.5" style="color: var(--on-v);">Keluar</p>
                                @if($absen->waktu_keluar)
                                    <p class="font-extrabold text-sm leading-none" style="color: var(--on-s);">{{ $absen->waktu_keluar->format('H:i') }}</p>
                                @else
                                    <p class="font-extrabold text-xs text-emerald-400 leading-none">—</p>
                                @endif
                            </div>
                        </div>

                        {{-- Zona (jika ada) --}}
                        @if(optional(optional($absen->user)->kendaraan)->zona)
                            <div class="flex items-center gap-1.5 mt-2">
                                <span class="w-2.5 h-2.5 rounded-full flex-shrink-0"
                                      style="background-color: {{ $absen->user->kendaraan->zona->kode_warna }}"></span>
                                <span class="text-[10px] font-bold" style="color: var(--on-v);">
                                    Zona {{ $absen->user->kendaraan->zona->nama_zona }}
                                </span>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="py-16 text-center">
                        <span class="material-icons text-[48px] block mx-auto mb-3" style="color: var(--outline-v);">schedule</span>
                        <p class="font-extrabold" style="color: var(--on-s);">Belum Ada Pergerakan</p>
                    </div>
                @endforelse

                {{-- Mobile empty state filter --}}
                <div x-show="visibleCount === 0 && {{ $totalMasuk }} > 0" x-transition class="py-12 text-center px-6">
                    <span class="material-icons text-[32px] block mx-auto mb-2" style="color: var(--outline-v);">manage_search</span>
                    <p class="font-extrabold text-sm" style="color: var(--on-s);">Tidak ada data cocok.</p>
                    <button @click="resetFilters(); setFilter('semua')"
                            class="mt-2 text-xs font-extrabold underline" style="color: var(--on-v);">
                        Reset Filter
                    </button>
                </div>
            </div>

        </div>
    </div>

    {{-- ============================================================
         ALPINE SCRIPT
    ============================================================ --}}
    <script>
        function absensiRadar() {
            return {
                activeFilter: 'semua',
                searchQuery: '',
                filterKelas: '',
                filterZona: '',
                currentTime: '',
                visibleCount: {{ $totalMasuk }},

                startClock() {
                    this.updateClock();
                    setInterval(() => this.updateClock(), 1000);
                    this.applyFilters();
                },

                updateClock() {
                    const now = new Date();
                    const wib = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Jakarta' }));
                    const h = String(wib.getHours()).padStart(2, '0');
                    const m = String(wib.getMinutes()).padStart(2, '0');
                    const s = String(wib.getSeconds()).padStart(2, '0');
                    this.currentTime = `${h}:${m}:${s}`;
                },

                setFilter(filter) {
                    this.activeFilter = filter;
                    this.$nextTick(() => this.applyFilters());
                },

                applyFilters() {
                    const sq  = this.searchQuery.toLowerCase();
                    const fk  = this.filterKelas.toLowerCase();
                    const fz  = this.filterZona.toLowerCase();
                    const fst = this.activeFilter;
                    let count = 0;

                    document.querySelectorAll('.baris-absensi').forEach(row => {
                        const status = row.dataset.status || '';
                        const kelas  = row.dataset.kelas  ? row.dataset.kelas.toLowerCase()  : '';
                        const zona   = row.dataset.zona   ? row.dataset.zona.toLowerCase()   : '';
                        const nama   = row.dataset.nama   || '';
                        const nis    = row.dataset.nis    || '';
                        const plat   = row.dataset.plat   || '';

                        const matchStatus = fst === 'semua' || fst === status;
                        const matchKelas  = !fk || kelas === fk;
                        const matchZona   = !fz || zona === fz || (fz === 'belum' && zona === 'belum');
                        const matchSearch = !sq || nama.includes(sq) || nis.includes(sq) || plat.includes(sq);

                        const visible = matchStatus && matchKelas && matchZona && matchSearch;
                        row.style.display = visible ? '' : 'none';
                        if (visible) count++;
                    });

                    this.visibleCount = count;
                },

                resetFilters() {
                    this.searchQuery = '';
                    this.filterKelas = '';
                    this.filterZona  = '';
                    this.applyFilters();
                }
            };
        }
    </script>

</x-admin-layout>
