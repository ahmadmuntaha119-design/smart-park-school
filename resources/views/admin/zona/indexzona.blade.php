<x-admin-layout>
    <x-slot name="title">Manajemen Zona</x-slot>

    <div class="mb-6">
        <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight" style="color: var(--on-s);">Manajemen Area Parkir</h2>
        <p class="text-xs sm:text-sm font-medium mt-0.5" style="color: var(--on-v);">Tambahkan zona dan atur baris-barisnya (kapasitas per baris) secara fleksibel.</p>
    </div>

    {{-- Flash Alerts --}}
    @if(session('success'))
        <div class="mb-5 flex items-start gap-3 rounded-xl p-4 border" style="background: rgba(16,185,129,0.1); border-color: rgba(16,185,129,0.2);">
            <span class="material-icons text-[20px] mt-0.5 text-emerald-500 flex-shrink-0">check_circle_outline</span>
            <p class="text-sm font-semibold text-emerald-400">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-5 flex items-start gap-3 rounded-xl p-4 border" style="background: rgba(239,68,68,0.1); border-color: rgba(239,68,68,0.2);">
            <span class="material-icons text-[20px] mt-0.5 text-red-500 flex-shrink-0">error_outline</span>
            <p class="text-sm font-semibold text-red-400">{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- FORM TAMBAH ZONA --}}
        <div class="lg:col-span-1">
            <div class="rounded-2xl p-5 sm:p-6 border sticky top-24" style="background: var(--sl2); border-color: var(--outline-v);">
                <div class="flex items-center gap-3 mb-5">
                    <h3 class="text-sm font-extrabold" style="color: var(--on-s);">Buka Zona Baru</h3>
                </div>

                <form action="{{ route('admin.zona.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-1.5">
                        <label class="block text-xs font-extrabold uppercase tracking-wider" style="color: var(--on-s);">Nama / Kode Zona</label>
                        <div class="relative">
                            <input type="text" name="nama_zona" value="{{ old('nama_zona') }}" required
                                   placeholder="Contoh: A, B, E-Kiri"
                                   class="block w-full px-4 py-3 rounded-xl text-sm font-semibold transition-colors"
                                   style="background: rgba(255,255,255,0.02); border: 1px solid var(--outline-v); color: var(--on-s); outline: none;"
                                   onfocus="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.background='rgba(255,255,255,0.05)';"
                                   onblur="this.style.borderColor='var(--outline-v)'; this.style.background='rgba(255,255,255,0.02)';">
                        </div>
                        @error('nama_zona')
                            <p class="text-xs font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-extrabold uppercase tracking-wider" style="color: var(--on-s);">Keterangan</label>
                        <input type="text" name="keterangan" value="{{ old('keterangan') }}"
                               placeholder="Contoh: Utara"
                               class="block w-full px-4 py-3 rounded-xl text-sm font-semibold transition-colors"
                               style="background: rgba(255,255,255,0.02); border: 1px solid var(--outline-v); color: var(--on-s); outline: none;"
                               onfocus="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.background='rgba(255,255,255,0.05)';"
                               onblur="this.style.borderColor='var(--outline-v)'; this.style.background='rgba(255,255,255,0.02)';">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-extrabold uppercase tracking-wider" style="color: var(--on-s);">Warna Zona</label>
                        <div class="relative rounded-xl overflow-hidden" style="border: 1px solid var(--outline-v); background: rgba(255,255,255,0.02);">
                            <input type="color" name="kode_warna" value="{{ old('kode_warna', '#c2652a') }}" required
                                   class="block w-full h-[46px] cursor-pointer border-0 bg-transparent p-1.5">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider mb-1.5" style="color: var(--on-s);">Foto / Denah Lokasi <span class="text-[9px] text-zinc-500 normal-case">(Opsional)</span></label>
                        <div class="relative rounded-xl overflow-hidden" style="border: 1px solid var(--outline-v); background: rgba(255,255,255,0.02);">
                            <input type="file" name="foto_denah" accept="image/*"
                                   class="block w-full text-xs cursor-pointer p-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-white file:text-black hover:file:bg-zinc-200 transition-colors" style="color: var(--on-v);">
                        </div>
                    </div>

                    <p class="text-[1em] font-medium" style="color: var(--on-v);">
                        Kapasitas zona dihitung otomatis dari total semua baris yang Anda tambahkan.
                    </p>

                    <button type="submit"
                            class="w-full flex justify-center items-center gap-2 mt-1 py-3.5 px-4 rounded-xl text-sm font-extrabold tracking-widest uppercase transition-all duration-200"
                            style="background: #ffffff; color: #000000; box-shadow: 0 4px 14px rgba(255,255,255,0.2);"
                            onmouseenter="this.style.background='#e4e4e7'"
                            onmouseleave="this.style.background='#ffffff'">
                        Tambah Zona
                    </button>
                </form>
            </div>
        </div>

        {{-- DAFTAR ZONA + BARIS --}}
        <div class="lg:col-span-2 space-y-4">
            @forelse($zonas as $zona)
                <div class="rounded-2xl border overflow-hidden" style="background: var(--sl2); border-color: var(--outline-v);">

                    {{-- Color Bar --}}
                    <div class="h-1.5" style="background-color: {{ $zona->kode_warna }}"></div>

                    <div class="p-5">
                        {{-- Header Zona --}}
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="text-base font-extrabold" style="color: var(--on-s);">Zona {{ $zona->nama_zona }}</h4>
                                <p class="text-xs font-medium" style="color: var(--on-v);">{{ $zona->keterangan ?? 'Tanpa Keterangan' }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="text-right">
                                    <span class="block text-[9px] font-extrabold uppercase tracking-widest" style="color: var(--on-v);">Total Kapasitas</span>
                                    <span class="block text-lg font-extrabold leading-tight" style="color: var(--on-s);">{{ $zona->kapasitas_total }} slot</span>
                                </div>
                                <a href="{{ route('admin.zona.edit', $zona->id) }}"
                                   class="p-2 rounded-xl border text-xs font-bold transition-all"
                                   style="border-color: var(--outline-v); color: var(--on-s); background: rgba(255,255,255,0.02);"
                                   onmouseenter="this.style.borderColor='rgba(255,255,255,0.2)'; this.style.background='rgba(255,255,255,0.05)';"
                                   onmouseleave="this.style.borderColor='var(--outline-v)'; this.style.background='rgba(255,255,255,0.02)';">
                                    <span class="material-icons text-[18px]">tune</span>
                                </a>
                                <form action="{{ route('admin.zona.destroy', $zona->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus Zona {{ $zona->nama_zona }}? Semua baris ikut terhapus!');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 rounded-xl border transition-all"
                                            style="border-color: rgba(239,68,68,0.2); color: #ef4444; background: rgba(239,68,68,0.05);"
                                            onmouseenter="this.style.background='rgba(239,68,68,0.1)';"
                                            onmouseleave="this.style.background='rgba(239,68,68,0.05)';">
                                        <span class="material-icons text-[18px]">delete_outline</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Baris List --}}
                        @if($zona->baris->count() > 0)
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                @foreach($zona->baris as $baris)
                                    @php
                                        $terisi = $baris->kendaraan()->count();
                                        $pct = $baris->kapasitas > 0 ? min(round(($terisi / $baris->kapasitas) * 100), 100) : 0;
                                    @endphp
                                    <div class="rounded-xl p-3 border" style="background: rgba(255,255,255,0.02); border-color: var(--outline-v);">
                                        <p class="text-xs font-extrabold uppercase tracking-wide" style="color: var(--on-s);">{{ $baris->nama_baris }}</p>
                                        <div class="w-full rounded-full h-1.5 mt-1.5 overflow-hidden border border-white/5" style="background: rgba(255,255,255,0.05);">
                                            <div class="h-full rounded-full" style="width: {{ $pct }}%; background-color: {{ $zona->kode_warna }};"></div>
                                        </div>
                                        <p class="text-[10px] font-semibold mt-1" style="color: var(--on-v);">{{ $terisi }} / {{ $baris->kapasitas }} slot ({{ $pct }}%)</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-xl py-6 text-center border border-dashed" style="background: rgba(255,255,255,0.02); border-color: var(--outline-v);">
                                <span class="material-icons text-[30px] block opacity-50" style="color: var(--on-v);">table_rows</span>
                                <p class="text-xs font-bold mt-1" style="color: var(--on-v);">Belum ada baris. Klik ikon atur untuk menambah baris.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border py-16 text-center" style="background: var(--sl2); border-color: var(--outline-v);">
                    <span class="material-icons text-[56px] block mx-auto mb-3 opacity-50" style="color: var(--on-v);">not_listed_location</span>
                    <p class="font-extrabold text-lg" style="color: var(--on-v);">Belum Ada Zona Parkir</p>
                </div>
            @endforelse
        </div>

    </div>

</x-admin-layout>
