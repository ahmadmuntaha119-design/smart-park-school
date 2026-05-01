<x-admin-layout>
    <x-slot name="title">Manajemen Zona</x-slot>

    <div class="mb-6">
        <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight" style="color: #2d241e;">Manajemen Area Parkir</h2>
        <p class="text-xs sm:text-sm font-medium mt-0.5" style="color: #7a6b61;">Tambahkan zona dan atur baris-barisnya (kapasitas per baris) secara fleksibel.</p>
    </div>

    {{-- Flash Alerts --}}
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- FORM TAMBAH ZONA --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl p-5 sm:p-6 border sticky top-24" style="border-color: #e8e1d7;">
                <div class="flex items-center gap-3 mb-5">
                    <h3 class="text-sm font-extrabold" style="color: #2d241e;">Buka Zona Baru</h3>
                </div>

                <form action="{{ route('admin.zona.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-1.5">
                        <label class="block text-xs font-extrabold uppercase tracking-wider" style="color: #2d241e;">Nama / Kode Zona</label>
                        <div class="relative">
                            <input type="text" name="nama_zona" value="{{ old('nama_zona') }}" required
                                   placeholder="Contoh: A, B, E-Kiri"
                                   class="block w-full px-4 py-3 rounded-xl text-sm font-semibold transition-colors"
                                   style="background: #faf8f5; border: 1.5px solid #e8e1d7; color: #2d241e; outline: none;"
                                   onfocus="this.style.borderColor='#c2652a'; this.style.background='white';"
                                   onblur="this.style.borderColor='#e8e1d7'; this.style.background='#faf8f5';">
                        </div>
                        @error('nama_zona')
                            <p class="text-xs font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-extrabold uppercase tracking-wider" style="color: #2d241e;">Keterangan</label>
                        <input type="text" name="keterangan" value="{{ old('keterangan') }}"
                               placeholder="Contoh: Utara"
                               class="block w-full px-4 py-3 rounded-xl text-sm font-semibold transition-colors"
                               style="background: #faf8f5; border: 1.5px solid #e8e1d7; color: #2d241e; outline: none;"
                               onfocus="this.style.borderColor='#c2652a'; this.style.background='white';"
                               onblur="this.style.borderColor='#e8e1d7'; this.style.background='#faf8f5';">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-extrabold uppercase tracking-wider" style="color: #2d241e;">Warna Zona</label>
                        <div class="relative rounded-xl overflow-hidden" style="border: 1.5px solid #e8e1d7; background: #faf8f5;">
                            <input type="color" name="kode_warna" value="{{ old('kode_warna', '#c2652a') }}" required
                                   class="block w-full h-[46px] cursor-pointer border-0 bg-transparent p-1.5">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider mb-1.5" style="color: #2d241e;">Foto / Denah Lokasi <span class="text-[9px] text-gray-400 normal-case">(Opsional)</span></label>
                        <div class="relative rounded-xl overflow-hidden" style="border: 1.5px solid #e8e1d7; background: #faf8f5;">
                            <input type="file" name="foto_denah" accept="image/*"
                                   class="block w-full text-xs cursor-pointer p-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#c2652a] file:text-white hover:file:bg-[#a8551e] transition-colors">
                        </div>
                    </div>

                    <p class="text-[1em] font-medium" style="color: #a89b91;">
                        Kapasitas zona dihitung otomatis dari total semua baris yang Anda tambahkan.
                    </p>

                    <button type="submit"
                            class="w-full flex justify-center items-center gap-2 mt-1 py-3.5 px-4 rounded-xl text-sm font-extrabold text-white tracking-widest uppercase transition-all duration-200"
                            style="background: #c2652a; box-shadow: 0 4px 14px rgba(194,101,42,0.35);"
                            onmouseenter="this.style.background='#a8551e'"
                            onmouseleave="this.style.background='#c2652a'">
                        Tambah Zona
                    </button>
                </form>
            </div>
        </div>

        {{-- DAFTAR ZONA + BARIS --}}
        <div class="lg:col-span-2 space-y-4">
            @forelse($zonas as $zona)
                <div class="bg-white rounded-2xl border overflow-hidden" style="border-color: #e8e1d7;">

                    {{-- Color Bar --}}
                    <div class="h-1.5" style="background-color: {{ $zona->kode_warna }}"></div>

                    <div class="p-5">
                        {{-- Header Zona --}}
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="text-base font-extrabold" style="color: #2d241e;">Zona {{ $zona->nama_zona }}</h4>
                                <p class="text-xs font-medium" style="color: #a89b91;">{{ $zona->keterangan ?? 'Tanpa Keterangan' }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="text-right">
                                    <span class="block text-[9px] font-extrabold uppercase tracking-widest" style="color: #a89b91;">Total Kapasitas</span>
                                    <span class="block text-lg font-extrabold leading-tight" style="color: #2d241e;">{{ $zona->kapasitas_total }} slot</span>
                                </div>
                                <a href="{{ route('admin.zona.edit', $zona->id) }}"
                                   class="p-2 rounded-xl border text-xs font-bold transition-all"
                                   style="border-color: #e8e1d7; color: #7a6b61;"
                                   onmouseenter="this.style.borderColor='#c2652a'; this.style.color='#c2652a';"
                                   onmouseleave="this.style.borderColor='#e8e1d7'; this.style.color='#7a6b61';">
                                    <span class="material-icons text-[18px]">tune</span>
                                </a>
                                <form action="{{ route('admin.zona.destroy', $zona->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus Zona {{ $zona->nama_zona }}? Semua baris ikut terhapus!');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 rounded-xl border transition-all"
                                            style="border-color: #fca5a5; color: #dc2626; background: white;"
                                            onmouseenter="this.style.background='#fef2f2';"
                                            onmouseleave="this.style.background='white';">
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
                                    <div class="rounded-xl p-3" style="background: #faf8f5; border: 1px solid #e8e1d7;">
                                        <p class="text-xs font-extrabold uppercase tracking-wide" style="color: #2d241e;">{{ $baris->nama_baris }}</p>
                                        <div class="w-full rounded-full h-1.5 mt-1.5 overflow-hidden" style="background: #e8e1d7;">
                                            <div class="h-full rounded-full" style="width: {{ $pct }}%; background-color: {{ $zona->kode_warna }};"></div>
                                        </div>
                                        <p class="text-[10px] font-semibold mt-1" style="color: #7a6b61;">{{ $terisi }} / {{ $baris->kapasitas }} slot ({{ $pct }}%)</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-xl py-6 text-center" style="background: #faf8f5; border: 1.5px dashed #e8e1d7;">
                                <span class="material-icons text-[30px] block" style="color: #e8e1d7;">table_rows</span>
                                <p class="text-xs font-bold mt-1" style="color: #a89b91;">Belum ada baris. Klik ikon atur untuk menambah baris.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border py-16 text-center" style="border-color: #e8e1d7;">
                    <span class="material-icons text-[56px] block mx-auto mb-3" style="color: #e8e1d7;">not_listed_location</span>
                    <p class="font-extrabold text-lg" style="color: #a89b91;">Belum Ada Zona Parkir</p>
                </div>
            @endforelse
        </div>

    </div>

</x-admin-layout>
