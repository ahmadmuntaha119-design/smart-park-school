<x-admin-layout>
    {{-- ============================================================
         BANNER HEADER
    ============================================================ --}}
   

    {{-- ============================================================
         STAT CARDS BARIS ATAS
    ============================================================ --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-7">

        {{-- Card: Total Kendaraan --}}
        <div class="rounded-2xl p-5 border flex items-center gap-4 hover:shadow-md transition-shadow"
             style="background: var(--sl2); border-color: var(--outline-v);">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 border border-white/10"
                 style="background: rgba(255,255,255,0.05);">
                <span class="material-icons text-[24px]" style="color: var(--on-s);">two_wheeler</span>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider mb-0.5" style="color: var(--on-v);">Total Kendaraan</p>
                <div class="flex items-baseline gap-1.5">
                    <span class="text-3xl font-extrabold" style="color: var(--on-s);">{{ $totalKendaraan }}</span>
                    <span class="text-sm font-semibold" style="color: var(--on-v);">Motor</span>
                </div>
            </div>
        </div>

        {{-- Card: Menunggu Zona --}}
        <div class="rounded-2xl p-5 border flex items-center gap-4 hover:shadow-md transition-shadow"
             style="background: var(--sl2); border-color: var(--outline-v);">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 border border-yellow-500/20" style="background: rgba(234,179,8,0.1);">
                <span class="material-icons text-[24px] text-yellow-500">schedule</span>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider mb-0.5" style="color: var(--on-v);">Menunggu Zona</p>
                <div class="flex items-baseline gap-1.5">
                    <span class="text-3xl font-extrabold text-yellow-500">{{ $totalPendingZona }}</span>
                    <span class="text-sm font-semibold" style="color: var(--on-v);">Siswa</span>
                </div>
            </div>
        </div>

        {{-- Card: Parkir Hari Ini --}}
        <div class="rounded-2xl p-5 border flex items-center gap-4 hover:shadow-md transition-shadow"
             style="background: var(--sl2); border-color: var(--outline-v);">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 border border-emerald-500/20" style="background: rgba(16,185,129,0.1);">
                <span class="material-icons text-[24px] text-emerald-500">how_to_reg</span>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider mb-0.5" style="color: var(--on-v);">Parkir Hari Ini</p>
                <div class="flex items-baseline gap-1.5">
                    <span class="text-3xl font-extrabold text-emerald-500">{{ $totalHariIni }}</span>
                    <span class="text-sm font-semibold" style="color: var(--on-v);">Motor</span>
                </div>
            </div>
        </div>

    </div>

    {{-- ============================================================
         GRAFIK ABSENSI 7 HARI
    ============================================================ --}}
    <div class="rounded-2xl border mb-7 overflow-hidden" style="background: var(--sl2); border-color: var(--outline-v);">
        <div class="px-6 py-5 border-b flex items-center justify-between" style="border-color: var(--outline-v);">
            <div>
                <h3 class="text-base font-extrabold" style="color: var(--on-s);">Statistik Absensi Parkir</h3>
                <p class="text-xs font-medium mt-0.5" style="color: var(--on-v);">Jumlah Motor Parkir</p>
            </div>
            <div class="flex items-center gap-2 text-xs font-bold px-3 py-1.5 rounded-full border border-white/10"
                 style="background: rgba(255,255,255,0.05); color: var(--on-s);">
                <span class="material-icons text-[14px]">bar_chart</span>
                7 Hari Terakhir
            </div>
        </div>
        <div class="p-4 sm:p-6">
            <div id="chart-absensi" style="min-height: 280px;"></div>
        </div>
    </div>

    {{-- ============================================================
         STATUS KAPASITAS ZONA
    ============================================================ --}}
    <div class="mb-2">
        <h3 class="text-lg font-extrabold mb-5" style="color: var(--on-s);">Status Kapasitas Zona</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($zonas as $zona)
                @php
                    $persentase = ($zona->kapasitas_total > 0)
                        ? round(($zona->kendaraan_count / $zona->kapasitas_total) * 100)
                        : 0;
                    $sisa = $zona->kapasitas_total - $zona->kendaraan_count;
                    $isPenuh = $persentase >= 100;
                @endphp
                <div class="rounded-2xl border overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200"
                     style="background: var(--sl2); border-color: var(--outline-v);">
                    {{-- Color bar top --}}
                    <div class="h-1.5" style="background-color: {{ $zona->kode_warna }}"></div>
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="text-base font-extrabold" style="color: var(--on-s);">Zona {{ $zona->nama_zona }}</h4>
                                @if($zona->keterangan)
                                    <p class="text-xs font-medium mt-0.5" style="color: var(--on-v);">{{ $zona->keterangan }}</p>
                                @endif
                            </div>
                            @if($isPenuh)
                                <span class="px-2.5 py-1 bg-red-500/10 text-red-500 text-[10px] font-black rounded-lg uppercase tracking-widest border border-red-500/20">PENUH</span>
                            @else
                                <span class="px-2.5 py-1 bg-emerald-500/10 text-emerald-500 text-[10px] font-black rounded-lg uppercase tracking-widest border border-emerald-500/20">TERSEDIA</span>
                            @endif
                        </div>

                        {{-- Progress Bar --}}
                        <div class="w-full rounded-full h-2.5 mb-3 overflow-hidden border border-white/5" style="background: rgba(255,255,255,0.05);">
                            <div class="h-full rounded-full transition-all duration-700"
                                 style="width: {{ $persentase }}%; background-color: {{ $zona->kode_warna }};"></div>
                        </div>

                        <div class="flex justify-between text-xs font-semibold" style="color: var(--on-v);">
                            <span>Terisi: <span class="font-extrabold" style="color: var(--on-s);">{{ $zona->kendaraan_count }}</span></span>
                            <span>Kapasitas: <span class="font-extrabold" style="color: var(--on-s);">{{ $zona->kapasitas_total }}</span></span>
                        </div>
                        <p class="text-right text-xs font-semibold mt-2" style="color: var(--on-v);">
                            Sisa <span class="font-extrabold text-sm {{ $isPenuh ? 'text-red-500' : 'text-emerald-500' }}">{{ $sisa }}</span> slot kosong
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ============================================================
         VISUALISASI PETA ZONA
    ============================================================ --}}
    <div class="mb-7 mt-8">
        <h3 class="text-lg font-extrabold mb-5 flex items-center gap-2" style="color: var(--on-s);">
            <span class="material-icons text-zinc-400">map</span> Peta Zona untuk Visualisasi
        </h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($zonas as $zona)
                <div class="rounded-2xl border overflow-hidden relative group hover:shadow-lg transition-all" style="background: var(--sl2); border-color: var(--outline-v);">
                    @if($zona->foto_denah)
                        <div class="aspect-video w-full overflow-hidden" style="background: rgba(255,255,255,0.02);">
                            <img src="{{ Storage::url($zona->foto_denah) }}" alt="Peta Zona {{ $zona->nama_zona }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 opacity-90">
                        </div>
                        {{-- Overlay button --}}
                        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10" style="height: calc(100% - 3rem);">
                            <a href="{{ Storage::url($zona->foto_denah) }}" target="_blank" 
                               class="bg-white/10 border border-white/20 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-md hover:bg-white/20 flex items-center gap-1">
                                <span class="material-icons text-[14px]">zoom_in</span> Perbesar
                            </a>
                        </div>
                    @else
                        <div class="aspect-video w-full flex flex-col items-center justify-center border-b border-dashed border-white/10" style="background: rgba(255,255,255,0.02);">
                            <span class="material-icons text-[32px] text-zinc-600 mb-2">landscape</span>
                            <span class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Belum Ada Peta</span>
                        </div>
                    @endif
                    
                    {{-- Footer Label --}}
                    <div class="h-12 px-4 flex items-center justify-between border-t" style="border-color: var(--outline-v); background: rgba(0,0,0,0.2);">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full" style="background-color: {{ $zona->kode_warna }}"></div>
                            <span class="text-sm font-extrabold" style="color: var(--on-s);">Zona {{ $zona->nama_zona }}</span>
                        </div>
                        <a href="{{ route('admin.zona.edit', $zona->id) }}" class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 hover:text-white transition-colors">
                            {{ $zona->foto_denah ? 'Ubah' : 'Unggah' }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ============================================================
         APEXCHARTS SCRIPT
    ============================================================ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const labels = {!! $chartLabels !!};
            const values = {!! $chartValues !!};

            const options = {
                chart: {
                    type: 'area',
                    height: 280,
                    toolbar: { show: false },
                    fontFamily: 'Manrope, sans-serif',
                    animations: { enabled: true, easing: 'easeinout', speed: 800 },
                    zoom: { enabled: false },
                },
                series: [{
                    name: 'Motor Parkir',
                    data: values,
                }],
                xaxis: {
                    categories: labels,
                    labels: {
                        style: { colors: '#a1a1aa', fontWeight: '600', fontSize: '12px' },
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                },
                yaxis: {
                    labels: {
                        style: { colors: '#a1a1aa', fontWeight: '600', fontSize: '12px' },
                        formatter: (val) => Math.floor(val),
                    },
                    min: 0,
                },
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: 3,
                    colors: ['#ffffff'],
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.35,
                        opacityTo: 0.02,
                        stops: [0, 90, 100],
                        colorStops: [{
                            offset: 0, color: '#ffffff', opacity: 0.25,
                        }, {
                            offset: 100, color: '#121212', opacity: 0.02,
                        }],
                    },
                },
                markers: {
                    size: 5,
                    colors: ['#121212'],
                    strokeColors: '#ffffff',
                    strokeWidth: 3,
                    hover: { size: 7 },
                },
                grid: {
                    borderColor: 'rgba(255,255,255,0.05)',
                    strokeDashArray: 4,
                    yaxis: { lines: { show: true } },
                    xaxis: { lines: { show: false } },
                    padding: { left: 5, right: 5 },
                },
                tooltip: {
                    theme: 'dark',
                    style: { fontFamily: 'Manrope, sans-serif', fontSize: '13px', fontWeight: 600 },
                    y: { formatter: (val) => `${val} Motor` },
                },
                colors: ['#ffffff'],
                noData: {
                    text: 'Belum ada data absensi',
                    style: { color: '#a1a1aa', fontSize: '14px', fontFamily: 'Manrope, sans-serif' },
                },
            };

            const chart = new ApexCharts(document.querySelector('#chart-absensi'), options);
            chart.render();
        });
    </script>

</x-admin-layout>
