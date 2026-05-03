<x-admin-layout>
    <x-slot name="title">Data NIS Whitelist</x-slot>

    {{-- ============================================================
         HEADER & ACTION BUTTONS
    ============================================================ --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 gap-3">
        <div>
            <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight" style="color: var(--on-s);">Manajemen Kuota Pendaftar</h2>
            <p class="text-xs sm:text-sm font-medium mt-0.5" style="color: var(--on-v);">Upload file Excel daftar resmi siswa di sini.</p>
        </div>

        <div class="flex gap-2 w-full sm:w-auto">
            {{-- Export --}}
            <a href="{{ route('admin.whitelist.export') }}"
               class="flex-1 sm:flex-none inline-flex justify-center items-center gap-1.5 px-3 py-2.5 rounded-xl border-2 text-xs font-bold transition-all"
               style="border-color: var(--outline-v); color: var(--on-s); background: rgba(255,255,255,0.02);"
               onmouseenter="this.style.borderColor='rgba(255,255,255,0.2)'; this.style.background='rgba(255,255,255,0.08)'"
               onmouseleave="this.style.borderColor='var(--outline-v)'; this.style.background='rgba(255,255,255,0.02)'">
                <span class="material-icons text-[16px]">download</span>
                <span class="hidden sm:inline">Export</span> Laporan
            </a>

            {{-- Bersihkan --}}
            <form action="{{ route('admin.whitelist.destroyAll') }}" method="POST"
                  onsubmit="return confirm('⚠️ Yakin ingin menghapus SEMUA NIS yang belum mendaftar?');"
                  class="flex-1 sm:flex-none">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full inline-flex justify-center items-center gap-1.5 px-3 py-2.5 rounded-xl border text-xs font-bold transition-all"
                        style="border-color: rgba(239,68,68,0.2); color: #ef4444; background: rgba(239,68,68,0.05);"
                        onmouseenter="this.style.background='rgba(239,68,68,0.1)'"
                        onmouseleave="this.style.background='rgba(239,68,68,0.05)'">
                    <span class="material-icons text-[16px]">delete_outline</span>
                    <span class="hidden sm:inline">Bersihkan</span> Sisa Data
                </button>
            </form>
        </div>
    </div>

    {{-- ============================================================
         FLASH ALERTS
    ============================================================ --}}
    @if(session('success'))
        <div class="mb-4 flex items-start gap-3 rounded-xl p-4 border" style="background: rgba(16,185,129,0.1); border-color: rgba(16,185,129,0.2);">
            <span class="material-icons text-[20px] mt-0.5 text-emerald-500 flex-shrink-0">check_circle_outline</span>
            <p class="text-sm font-semibold text-emerald-400">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 flex items-start gap-3 rounded-xl p-4 border" style="background: rgba(239,68,68,0.1); border-color: rgba(239,68,68,0.2);">
            <span class="material-icons text-[20px] mt-0.5 text-red-500 flex-shrink-0">error_outline</span>
            <p class="text-sm font-semibold text-red-400">{{ session('error') }}</p>
        </div>
    @endif

    {{-- ============================================================
         STAT STRIP (Mobile: 3 metric horizontal, Desktop: inside left col)
    ============================================================ --}}
    <div class="grid grid-cols-3 gap-3 mb-5 xl:hidden">
        <div class="rounded-xl p-3 border text-center" style="background: var(--sl2); border-color: var(--outline-v);">
            <p class="text-[10px] font-bold uppercase tracking-widest mb-1" style="color: var(--on-v);">Total</p>
            <p class="text-xl font-extrabold" style="color: var(--on-s);">{{ $total }}</p>
        </div>
        <div class="rounded-xl p-3 border text-center" style="background: var(--sl2); border-color: var(--outline-v);">
            <p class="text-[10px] font-bold uppercase tracking-widest mb-1" style="color: var(--on-v);">Daftar</p>
            <p class="text-xl font-extrabold text-emerald-500">{{ $sudahDaftar }}</p>
        </div>
        <div class="rounded-xl p-3 border text-center" style="background: var(--sl2); border-color: var(--outline-v);">
            <p class="text-[10px] font-bold uppercase tracking-widest mb-1" style="color: var(--on-v);">Kosong</p>
            <p class="text-xl font-extrabold text-yellow-500">{{ $belumDaftar }}</p>
        </div>
    </div>

    {{-- ============================================================
         MAIN GRID
    ============================================================ --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        {{-- ======================== KOLOM KIRI ======================== --}}
        <div class="xl:col-span-1 space-y-5">

            {{-- Upload Box --}}
            <div class="rounded-2xl p-5 border" style="background: var(--sl2); border-color: var(--outline-v);">
                <h3 class="text-sm font-extrabold mb-4" style="color: var(--on-s);">Upload File Excel/CSV</h3>

                <form action="{{ route('admin.whitelist.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Dropzone --}}
                    <label id="upload-label"
                           class="flex flex-col items-center justify-center w-full h-32 rounded-xl border-2 border-dashed cursor-pointer transition-all duration-200 mb-4"
                           style="border-color: var(--outline-v); background: rgba(255,255,255,0.02);">
                        <span id="upload-icon" class="material-icons text-[32px] mb-1.5 transition-colors" style="color: var(--on-v);">upload_file</span>
                        <span id="file-name" class="text-sm font-semibold text-center px-4 leading-snug transition-colors" style="color: var(--on-s);">Klik untuk Pilih File</span>
                        <span class="text-xs mt-1 font-medium" style="color: var(--on-v);">.xlsx .xls .csv</span>
                        <input type="file" name="file_excel" class="hidden" accept=".xlsx,.xls,.csv" required
                            onchange="
                                const label = document.getElementById('upload-label');
                                const icon = document.getElementById('upload-icon');
                                const nameEl = document.getElementById('file-name');
                                const file = this.files[0];
                                if (file) {
                                    // Truncate filename for small screens
                                    const name = file.name.length > 24 ? file.name.substring(0,21) + '...' : file.name;
                                    nameEl.textContent = '✅ ' + name;
                                    nameEl.style.color = '#34d399';
                                    icon.textContent = 'task_alt';
                                    icon.style.color = '#10b981';
                                    label.style.borderColor = 'rgba(16,185,129,0.5)';
                                    label.style.background = 'rgba(16,185,129,0.1)';
                                }
                            ">
                    </label>
                    @error('file_excel')
                        <p class="text-xs text-red-500 font-bold -mt-2 mb-3">{{ $message }}</p>
                    @enderror

                    {{-- Format Hint --}}
                    <div class="rounded-xl p-3.5 mb-4 border" style="background: rgba(255,255,255,0.05); border-color: var(--outline-v);">
                        <p class="text-xs font-bold mb-1.5 flex items-center gap-1" style="color: var(--on-s);">
                            <span class="material-icons text-[13px] text-zinc-400">info_outline</span>
                            Format Wajib (Baris 1):
                        </p>
                        <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs font-semibold" style="color: var(--on-v);">
                            <span>Kolom A = <code class="px-1.5 py-0.5 rounded font-black border" style="background: var(--sl-hi); color: var(--on-s); border-color: var(--outline-v);">nis</code></span>
                            <span>Kolom B = <code class="px-1.5 py-0.5 rounded font-black border" style="background: var(--sl-hi); color: var(--on-s); border-color: var(--outline-v);">nama</code></span>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full flex justify-center items-center gap-2 py-3.5 px-4 rounded-xl text-sm font-black tracking-widest uppercase transition-all duration-200"
                            style="background: #ffffff; color: #000000; box-shadow: 0 4px 14px rgba(255,255,255,0.2);"
                            onmouseenter="this.style.background='#e4e4e7'"
                            onmouseleave="this.style.background='#ffffff'">
                        <span class="material-icons text-[18px]">upload</span>
                        Import Data
                    </button>
                </form>
            </div>

            {{-- Statistik Card (Dark Sahara) — Hidden on Mobile (shown as strip above) --}}
            <div class="hidden xl:block rounded-2xl p-6 overflow-hidden relative border" style="background: var(--sl-hi); border-color: var(--outline-v);">
                <div class="absolute -right-6 -bottom-6 opacity-10 pointer-events-none" aria-hidden="true">
                    <span class="material-icons text-[110px] text-white">groups</span>
                </div>

                <h3 class="text-base font-extrabold mb-5 relative z-10" style="color: var(--on-s);">Statistik Whitelist</h3>

                <div class="space-y-4 relative z-10">
                    <div class="flex justify-between items-center pb-4" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <span class="text-xs font-bold uppercase tracking-widest" style="color: var(--on-v);">Total Dibackup</span>
                        <span class="text-2xl font-extrabold" style="color: var(--on-s);">{{ $total }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-4" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <span class="text-xs font-bold uppercase tracking-widest" style="color: var(--on-v);">Sudah Registrasi</span>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full animate-pulse bg-emerald-500"></span>
                            <span class="text-2xl font-extrabold text-emerald-500">{{ $sudahDaftar }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold uppercase tracking-widest" style="color: var(--on-v);">Masih Kosong</span>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                            <span class="text-2xl font-extrabold text-yellow-500">{{ $belumDaftar }}</span>
                        </div>
                    </div>
                </div>

                @if($total > 0)
                    @php $pct = round(($sudahDaftar / $total) * 100); @endphp
                    <div class="mt-5 relative z-10">
                        <div class="flex justify-between text-xs font-semibold mb-1.5" style="color: var(--on-v);">
                            <span>Progres Pendaftaran</span>
                            <span style="color: var(--on-s);">{{ $pct }}%</span>
                        </div>
                        <div class="w-full rounded-full h-2 overflow-hidden border border-white/5" style="background: rgba(255,255,255,0.05);">
                            <div class="h-full rounded-full bg-emerald-500 transition-all duration-700"
                                 style="width: {{ $pct }}%;"></div>
                        </div>
                    </div>
                @endif
            </div>

        </div>

        {{-- ======================== KOLOM KANAN (DATA LIST) ======================== --}}
        <div class="xl:col-span-2">
            <div class="rounded-2xl border overflow-hidden" style="background: var(--sl2); border-color: var(--outline-v);">

                {{-- Header --}}
                <div class="px-4 sm:px-6 py-4 border-b flex items-center justify-between" style="border-color: var(--outline-v); background: transparent;">
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold" style="color: var(--on-s);">Daftar Terkini</h3>
                        <p class="text-xs font-medium mt-0.5" style="color: var(--on-v);">Data whitelist NIS siswa secara real-time</p>
                    </div>
                    <div class="text-xs font-bold px-3 py-1.5 rounded-full flex-shrink-0 border border-white/10"
                         style="background: rgba(255,255,255,0.05); color: var(--on-s);">
                        {{ $total }} Siswa
                    </div>
                </div>

                {{-- DESKTOP: Table --}}
                <div class="hidden sm:block overflow-x-auto">
                    <div class="max-h-[600px] overflow-y-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs uppercase tracking-widest sticky top-0 z-10"
                                   style="color: var(--on-v); background: rgba(255,255,255,0.02); border-bottom: 1px solid var(--outline-v);">
                                <tr>
                                    <th class="px-6 py-3.5 font-extrabold border-b border-white/10">NIS</th>
                                    <th class="px-6 py-3.5 font-extrabold border-b border-white/10">Nama Lengkap Murid</th>
                                    <th class="px-6 py-3.5 font-extrabold border-b border-white/10">Status</th>
                                    <th class="px-6 py-3.5 font-extrabold border-b border-white/10 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody style="color: var(--on-s);">
                                @forelse($whitelists as $item)
                                    <tr class="border-b transition-colors"
                                        style="border-color: var(--outline-v);"
                                        onmouseenter="this.style.background='rgba(255,255,255,0.05)'"
                                        onmouseleave="this.style.background='transparent'">
                                        <td class="px-6 py-4 font-extrabold text-sm tracking-wide">{{ $item->nis }}</td>
                                        <td class="px-6 py-4 font-semibold text-sm">{{ $item->nama }}</td>
                                        <td class="px-6 py-4">
                                            @if($item->sudah_daftar)
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-extrabold bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> TERPAKAI
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-extrabold"
                                                      style="background: rgba(234,179,8,0.1); color: #eab308; border: 1px solid rgba(234,179,8,0.2);">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> MENUNGGU
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form action="{{ route('admin.whitelist.destroy', $item->id) }}" method="POST"
                                                  onsubmit="return confirm('Hapus NIS {{ $item->nis }} ({{ $item->nama }})? Akun siswa jika ada juga akan dihapus.');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                        class="w-8 h-8 rounded-lg inline-flex items-center justify-center transition-all border"
                                                        style="border-color: rgba(239,68,68,0.2); color: #ef4444; background: transparent;"
                                                        onmouseenter="this.style.background='rgba(239,68,68,0.1)'"
                                                        onmouseleave="this.style.background='transparent'"
                                                        title="Hapus NIS ini">
                                                    <span class="material-icons text-[16px]">delete</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-20 text-center">
                                            <span class="material-icons text-[56px] block mx-auto mb-3" style="color: var(--on-v); opacity: 0.5;">assignment</span>
                                            <p class="font-extrabold text-lg" style="color: var(--on-s);">Belum Ada Data Siswa</p>
                                            <p class="text-sm font-medium mt-1" style="color: var(--on-v);">Silakan upload file Excel dari panel sebelah kiri.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- MOBILE: Card List --}}
                <div class="sm:hidden divide-y" style="border-color: var(--outline-v); max-height: 65vh; overflow-y: auto;">
                    @forelse($whitelists as $item)
                        <div class="px-4 py-3.5 flex items-center justify-between gap-3"
                             style="color: var(--on-s);">
                            <div class="min-w-0">
                                <p class="font-extrabold text-sm tracking-wide">{{ $item->nama }}</p>
                                <p class="text-xs font-bold mt-0.5" style="color: var(--on-v);">NIS: {{ $item->nis }}</p>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                @if($item->sudah_daftar)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> TERPAKAI
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-extrabold"
                                          style="background: rgba(234,179,8,0.1); color: #eab308; border: 1px solid rgba(234,179,8,0.2);">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> MENUNGGU
                                    </span>
                                @endif

                                {{-- Hapus individu (mobile) --}}
                                <form action="{{ route('admin.whitelist.destroy', $item->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus NIS {{ $item->nis }}?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="w-7 h-7 rounded-lg inline-flex items-center justify-center transition-all border"
                                            style="border-color: rgba(239,68,68,0.2); color: #ef4444; background: transparent;"
                                            onmouseenter="this.style.background='rgba(239,68,68,0.1)'"
                                            onmouseleave="this.style.background='transparent'">
                                        <span class="material-icons text-[14px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="py-16 text-center px-4">
                            <span class="material-icons text-[48px] block mx-auto mb-3" style="color: var(--on-v); opacity: 0.5;">assignment</span>
                            <p class="font-extrabold" style="color: var(--on-s);">Belum Ada Data Siswa</p>
                            <p class="text-xs mt-1 font-medium" style="color: var(--on-v);">Upload file Excel dari panel di atas.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

    </div>

</x-admin-layout>
