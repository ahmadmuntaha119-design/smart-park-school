<x-admin-layout>
    <x-slot name="title">Data NIS Whitelist</x-slot>

    {{-- ============================================================
         HEADER & ACTION BUTTONS
    ============================================================ --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 gap-3">
        <div>
            <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight" style="color: #2d241e;">Manajemen Kuota Pendaftar</h2>
            <p class="text-xs sm:text-sm font-medium mt-0.5" style="color: #7a6b61;">Upload file Excel daftar resmi siswa di sini.</p>
        </div>

        <div class="flex gap-2 w-full sm:w-auto">
            {{-- Export --}}
            <a href="{{ route('admin.whitelist.export') }}"
               class="flex-1 sm:flex-none inline-flex justify-center items-center gap-1.5 px-3 py-2.5 rounded-xl border-2 text-xs font-bold transition-all"
               style="border-color: #e8e1d7; color: #7a6b61; background: white;"
               onmouseenter="this.style.borderColor='#c2652a'; this.style.color='#c2652a'; this.style.background='rgba(194,101,42,0.05)'"
               onmouseleave="this.style.borderColor='#e8e1d7'; this.style.color='#7a6b61'; this.style.background='white'">
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
                        class="w-full inline-flex justify-center items-center gap-1.5 px-3 py-2.5 rounded-xl border-2 text-xs font-bold transition-all"
                        style="border-color: #fca5a5; color: #dc2626; background: white;"
                        onmouseenter="this.style.background='#fef2f2'"
                        onmouseleave="this.style.background='white'">
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
        <div class="mb-4 flex items-start gap-3 rounded-xl p-4" style="background: #f0fdf4; border: 1.5px solid #86efac;">
            <span class="material-icons text-[20px] mt-0.5 text-green-600 flex-shrink-0">check_circle_outline</span>
            <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 flex items-start gap-3 rounded-xl p-4" style="background: #fff5f1; border: 1.5px solid #f4c3a8;">
            <span class="material-icons text-[20px] mt-0.5 flex-shrink-0" style="color: #c2652a;">error_outline</span>
            <p class="text-sm font-semibold" style="color: #8b3a14;">{{ session('error') }}</p>
        </div>
    @endif

    {{-- ============================================================
         STAT STRIP (Mobile: 3 metric horizontal, Desktop: inside left col)
    ============================================================ --}}
    <div class="grid grid-cols-3 gap-3 mb-5 xl:hidden">
        <div class="bg-white rounded-xl p-3 border text-center" style="border-color: #e8e1d7;">
            <p class="text-[10px] font-bold uppercase tracking-widest mb-1" style="color: #a89b91;">Total</p>
            <p class="text-xl font-extrabold" style="color: #2d241e;">{{ $total }}</p>
        </div>
        <div class="bg-white rounded-xl p-3 border text-center" style="border-color: #e8e1d7;">
            <p class="text-[10px] font-bold uppercase tracking-widest mb-1" style="color: #a89b91;">Daftar</p>
            <p class="text-xl font-extrabold text-emerald-600">{{ $sudahDaftar }}</p>
        </div>
        <div class="bg-white rounded-xl p-3 border text-center" style="border-color: #e8e1d7;">
            <p class="text-[10px] font-bold uppercase tracking-widest mb-1" style="color: #a89b91;">Kosong</p>
            <p class="text-xl font-extrabold" style="color: #e07840;">{{ $belumDaftar }}</p>
        </div>
    </div>

    {{-- ============================================================
         MAIN GRID
    ============================================================ --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        {{-- ======================== KOLOM KIRI ======================== --}}
        <div class="xl:col-span-1 space-y-5">

            {{-- Upload Box --}}
            <div class="bg-white rounded-2xl p-5 border" style="border-color: #e8e1d7;">
                <h3 class="text-sm font-extrabold mb-4" style="color: #2d241e;">Upload File Excel/CSV</h3>

                <form action="{{ route('admin.whitelist.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Dropzone --}}
                    <label id="upload-label"
                           class="flex flex-col items-center justify-center w-full h-32 rounded-xl border-2 border-dashed cursor-pointer transition-all duration-200 mb-4"
                           style="border-color: #e8e1d7; background: #faf8f5;">
                        <span id="upload-icon" class="material-icons text-[32px] mb-1.5 transition-colors" style="color: #a89b91;">upload_file</span>
                        <span id="file-name" class="text-sm font-semibold text-center px-4 leading-snug transition-colors" style="color: #7a6b61;">Klik untuk Pilih File</span>
                        <span class="text-xs mt-1 font-medium" style="color: #a89b91;">.xlsx .xls .csv</span>
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
                                    nameEl.style.color = '#166534';
                                    icon.textContent = 'task_alt';
                                    icon.style.color = '#16a34a';
                                    label.style.borderColor = '#86efac';
                                    label.style.background = '#f0fdf4';
                                }
                            ">
                    </label>
                    @error('file_excel')
                        <p class="text-xs text-red-500 font-bold -mt-2 mb-3">{{ $message }}</p>
                    @enderror

                    {{-- Format Hint --}}
                    <div class="rounded-xl p-3.5 mb-4" style="background: #fffbf5; border: 1.5px solid rgba(194,101,42,0.2);">
                        <p class="text-xs font-bold mb-1.5 flex items-center gap-1" style="color: #c2652a;">
                            <span class="material-icons text-[13px]">info_outline</span>
                            Format Wajib (Baris 1):
                        </p>
                        <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs font-semibold" style="color: #7a6b61;">
                            <span>Kolom A = <code class="px-1.5 py-0.5 rounded font-black" style="background: white; color: #2d241e; border: 1px solid #e8e1d7;">nis</code></span>
                            <span>Kolom B = <code class="px-1.5 py-0.5 rounded font-black" style="background: white; color: #2d241e; border: 1px solid #e8e1d7;">nama</code></span>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full flex justify-center items-center gap-2 py-3.5 px-4 rounded-xl text-sm font-black text-white tracking-widest uppercase transition-all duration-200"
                            style="background: #c2652a; box-shadow: 0 4px 14px rgba(194,101,42,0.35);"
                            onmouseenter="this.style.background='#a8551e'"
                            onmouseleave="this.style.background='#c2652a'">
                        <span class="material-icons text-[18px]">upload</span>
                        Import Data
                    </button>
                </form>
            </div>

            {{-- Statistik Card (Dark Sahara) — Hidden on Mobile (shown as strip above) --}}
            <div class="hidden xl:block rounded-2xl p-6 text-white overflow-hidden relative" style="background: #2d241e;">
                <div class="absolute -right-6 -bottom-6 opacity-10 pointer-events-none" aria-hidden="true">
                    <span class="material-icons text-[110px]">groups</span>
                </div>

                <h3 class="text-base font-extrabold mb-5 relative z-10" style="color: #f2eee9;">Statistik Whitelist</h3>

                <div class="space-y-4 relative z-10">
                    <div class="flex justify-between items-center pb-4" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                        <span class="text-xs font-bold uppercase tracking-widest" style="color: #a89b91;">Total Dibackup</span>
                        <span class="text-2xl font-extrabold" style="color: #f2eee9;">{{ $total }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-4" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                        <span class="text-xs font-bold uppercase tracking-widest" style="color: #a89b91;">Sudah Registrasi</span>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full animate-pulse bg-emerald-400"></span>
                            <span class="text-2xl font-extrabold text-emerald-400">{{ $sudahDaftar }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold uppercase tracking-widest" style="color: #a89b91;">Masih Kosong</span>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full" style="background: #e07840;"></span>
                            <span class="text-2xl font-extrabold" style="color: #e07840;">{{ $belumDaftar }}</span>
                        </div>
                    </div>
                </div>

                @if($total > 0)
                    @php $pct = round(($sudahDaftar / $total) * 100); @endphp
                    <div class="mt-5 relative z-10">
                        <div class="flex justify-between text-xs font-semibold mb-1.5" style="color: #a89b91;">
                            <span>Progres Pendaftaran</span>
                            <span style="color: #f2eee9;">{{ $pct }}%</span>
                        </div>
                        <div class="w-full rounded-full h-2 overflow-hidden" style="background: rgba(255,255,255,0.1);">
                            <div class="h-full rounded-full bg-emerald-400 transition-all duration-700"
                                 style="width: {{ $pct }};"></div>
                        </div>
                    </div>
                @endif
            </div>

        </div>

        {{-- ======================== KOLOM KANAN (DATA LIST) ======================== --}}
        <div class="xl:col-span-2">
            <div class="bg-white rounded-2xl border overflow-hidden" style="border-color: #e8e1d7;">

                {{-- Header --}}
                <div class="px-4 sm:px-6 py-4 border-b flex items-center justify-between" style="border-color: #f0ebe4; background: #faf8f5;">
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold" style="color: #2d241e;">Daftar Terkini</h3>
                        <p class="text-xs font-medium mt-0.5" style="color: #a89b91;">Data whitelist NIS siswa secara real-time</p>
                    </div>
                    <div class="text-xs font-bold px-3 py-1.5 rounded-full flex-shrink-0"
                         style="background: rgba(194,101,42,0.08); color: #c2652a;">
                        {{ $total }} Siswa
                    </div>
                </div>

                {{-- DESKTOP: Table --}}
                <div class="hidden sm:block overflow-x-auto">
                    <div class="max-h-[600px] overflow-y-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs uppercase tracking-widest sticky top-0 z-10"
                                   style="color: #a89b91; background: #faf8f5; border-bottom: 1.5px solid #f0ebe4;">
                                <tr>
                                    <th class="px-6 py-3.5 font-extrabold">NIS</th>
                                    <th class="px-6 py-3.5 font-extrabold">Nama Lengkap Murid</th>
                                    <th class="px-6 py-3.5 font-extrabold">Status</th>
                                </tr>
                            </thead>
                            <tbody style="color: #2d241e;">
                                @forelse($whitelists as $item)
                                    <tr class="border-b transition-colors"
                                        style="border-color: #f0ebe4;"
                                        onmouseenter="this.style.background='#faf8f5'"
                                        onmouseleave="this.style.background='white'">
                                        <td class="px-6 py-4 font-extrabold text-sm tracking-wide">{{ $item->nis }}</td>
                                        <td class="px-6 py-4 font-semibold text-sm">{{ $item->nama }}</td>
                                        <td class="px-6 py-4">
                                            @if($item->sudah_daftar)
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> TERPAKAI
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-extrabold"
                                                      style="background: rgba(224,120,64,0.12); color: #8b3a14; border: 1px solid rgba(194,101,42,0.25);">
                                                    <span class="w-1.5 h-1.5 rounded-full" style="background: #e07840;"></span> MENUNGGU
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-20 text-center">
                                            <span class="material-icons text-[56px] block mx-auto mb-3" style="color: #e8e1d7;">assignment</span>
                                            <p class="font-extrabold text-lg" style="color: #a89b91;">Belum Ada Data Siswa</p>
                                            <p class="text-sm font-medium mt-1" style="color: #a89b91;">Silakan upload file Excel dari panel sebelah kiri.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- MOBILE: Card List --}}
                <div class="sm:hidden divide-y" style="border-color: #f0ebe4; max-height: 65vh; overflow-y: auto;">
                    @forelse($whitelists as $item)
                        <div class="px-4 py-3.5 flex items-center justify-between gap-3"
                             style="color: #2d241e;">
                            <div class="min-w-0">
                                <p class="font-extrabold text-sm tracking-wide">{{ $item->nama }}</p>
                                <p class="text-xs font-bold mt-0.5" style="color: #a89b91;">NIS: {{ $item->nis }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                @if($item->sudah_daftar)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> TERPAKAI
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-extrabold"
                                          style="background: rgba(224,120,64,0.12); color: #8b3a14; border: 1px solid rgba(194,101,42,0.25);">
                                        <span class="w-1.5 h-1.5 rounded-full" style="background: #e07840;"></span> MENUNGGU
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="py-16 text-center px-4">
                            <span class="material-icons text-[48px] block mx-auto mb-3" style="color: #e8e1d7;">assignment</span>
                            <p class="font-extrabold" style="color: #a89b91;">Belum Ada Data Siswa</p>
                            <p class="text-xs mt-1 font-medium" style="color: #a89b91;">Upload file Excel dari panel di atas.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

    </div>

</x-admin-layout>
