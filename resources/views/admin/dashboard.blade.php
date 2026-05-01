<x-admin-layout>
    {{-- ============================================================
         BANNER HEADER
    ============================================================ --}}
   

    {{-- ============================================================
         STAT CARDS BARIS ATAS
    ============================================================ --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-7">

        {{-- Card: Total Kendaraan --}}
        <div class="bg-white rounded-2xl p-5 border flex items-center gap-4 hover:shadow-md transition-shadow"
             style="border-color: #e8e1d7;">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background: rgba(194,101,42,0.10);">
                <span class="material-icons text-[24px]" style="color: #c2652a;">two_wheeler</span>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider mb-0.5" style="color: #a89b91;">Total Kendaraan</p>
                <div class="flex items-baseline gap-1.5">
                    <span class="text-3xl font-extrabold" style="color: #2d241e;">{{ $totalKendaraan }}</span>
                    <span class="text-sm font-semibold" style="color: #7a6b61;">Motor</span>
                </div>
            </div>
        </div>

        {{-- Card: Menunggu Zona --}}
        <div class="bg-white rounded-2xl p-5 border flex items-center gap-4 hover:shadow-md transition-shadow"
             style="border-color: #e8e1d7;">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 bg-yellow-50">
                <span class="material-icons text-[24px] text-yellow-500">schedule</span>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider mb-0.5" style="color: #a89b91;">Menunggu Zona</p>
                <div class="flex items-baseline gap-1.5">
                    <span class="text-3xl font-extrabold text-yellow-500">{{ $totalPendingZona }}</span>
                    <span class="text-sm font-semibold" style="color: #7a6b61;">Siswa</span>
                </div>
            </div>
        </div>

        {{-- Card: Parkir Hari Ini --}}
        <div class="bg-white rounded-2xl p-5 border flex items-center gap-4 hover:shadow-md transition-shadow"
             style="border-color: #e8e1d7;">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 bg-emerald-50">
                <span class="material-icons text-[24px] text-emerald-600">how_to_reg</span>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider mb-0.5" style="color: #a89b91;">Parkir Hari Ini</p>
                <div class="flex items-baseline gap-1.5">
                    <span class="text-3xl font-extrabold text-emerald-600">{{ $totalHariIni }}</span>
                    <span class="text-sm font-semibold" style="color: #7a6b61;">Motor</span>
                </div>
            </div>
        </div>

    </div>

    {{-- ============================================================
         GRAFIK ABSENSI 7 HARI
    ============================================================ --}}
    <div class="bg-white rounded-2xl border mb-7 overflow-hidden" style="border-color: #e8e1d7;">
        <div class="px-6 py-5 border-b flex items-center justify-between" style="border-color: #f0ebe4;">
            <div>
                <h3 class="text-base font-extrabold" style="color: #2d241e;">Statistik Absensi Parkir</h3>
                <p class="text-xs font-medium mt-0.5" style="color: #a89b91;">Jumlah Motor Parkir</p>
            </div>
            <div class="flex items-center gap-2 text-xs font-bold px-3 py-1.5 rounded-full"
                 style="background: rgba(194,101,42,0.08); color: #c2652a;">
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
        <h3 class="text-lg font-extrabold mb-5" style="color: #2d241e;">Status Kapasitas Zona</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($zonas as $zona)
                @php
                    $persentase = ($zona->kapasitas_total > 0)
                        ? round(($zona->kendaraan_count / $zona->kapasitas_total) * 100)
                        : 0;
                    $sisa = $zona->kapasitas_total - $zona->kendaraan_count;
                    $isPenuh = $persentase >= 100;
                @endphp
                <div class="bg-white rounded-2xl border overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition-all duration-200"
                     style="border-color: #e8e1d7;">
                    {{-- Color bar top --}}
                    <div class="h-1.5" style="background-color: {{ $zona->kode_warna }}"></div>
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="text-base font-extrabold" style="color: #2d241e;">Zona {{ $zona->nama_zona }}</h4>
                                @if($zona->keterangan)
                                    <p class="text-xs font-medium mt-0.5" style="color: #a89b91;">{{ $zona->keterangan }}</p>
                                @endif
                            </div>
                            @if($isPenuh)
                                <span class="px-2.5 py-1 bg-red-100 text-red-700 text-[10px] font-black rounded-lg uppercase tracking-widest border border-red-200">PENUH</span>
                            @else
                                <span class="px-2.5 py-1 bg-green-100 text-green-700 text-[10px] font-black rounded-lg uppercase tracking-widest border border-green-200">TERSEDIA</span>
                            @endif
                        </div>

                        {{-- Progress Bar --}}
                        <div class="w-full rounded-full h-2.5 mb-3 overflow-hidden" style="background: #f0ebe4;">
                            <div class="h-full rounded-full transition-all duration-700"
                                 style="width: {{ $persentase }}%; background-color: {{ $zona->kode_warna }};"></div>
                        </div>

                        <div class="flex justify-between text-xs font-semibold" style="color: #a89b91;">
                            <span>Terisi: <span class="font-extrabold" style="color: #2d241e;">{{ $zona->kendaraan_count }}</span></span>
                            <span>Kapasitas: <span class="font-extrabold" style="color: #2d241e;">{{ $zona->kapasitas_total }}</span></span>
                        </div>
                        <p class="text-right text-xs font-semibold mt-2" style="color: #a89b91;">
                            Sisa <span class="font-extrabold text-sm {{ $isPenuh ? 'text-red-500' : 'text-emerald-600' }}">{{ $sisa }}</span> slot kosong
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
        <h3 class="text-lg font-extrabold mb-5 flex items-center gap-2" style="color: #2d241e;">
            <span class="material-icons" style="color: #c2652a;">map</span> Peta Zona untuk Visualisasi
        </h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($zonas as $zona)
                <div class="bg-white rounded-2xl border overflow-hidden relative group hover:shadow-lg transition-all" style="border-color: #e8e1d7;">
                    @if($zona->foto_denah)
                        <div class="aspect-video w-full overflow-hidden bg-gray-100">
                            <img src="{{ Storage::url($zona->foto_denah) }}" alt="Peta Zona {{ $zona->nama_zona }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        </div>
                        {{-- Overlay button --}}
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10" style="height: calc(100% - 3rem);">
                            <a href="{{ Storage::url($zona->foto_denah) }}" target="_blank" 
                               class="bg-white text-xs font-bold px-3 py-1.5 rounded-lg text-gray-800 shadow-md hover:bg-gray-50 flex items-center gap-1">
                                <span class="material-icons text-[14px]">zoom_in</span> Perbesar
                            </a>
                        </div>
                    @else
                        <div class="aspect-video w-full bg-gray-50 flex flex-col items-center justify-center border-b border-dashed" style="border-color: #e8e1d7;">
                            <span class="material-icons text-[32px] text-gray-300 mb-2">landscape</span>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Belum Ada Peta</span>
                        </div>
                    @endif
                    
                    {{-- Footer Label --}}
                    <div class="h-12 px-4 flex items-center justify-between border-t" style="border-color: #e8e1d7; background: #faf8f5;">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full" style="background-color: {{ $zona->kode_warna }}"></div>
                            <span class="text-sm font-extrabold" style="color: #2d241e;">Zona {{ $zona->nama_zona }}</span>
                        </div>
                        <a href="{{ route('admin.zona.edit', $zona->id) }}" class="text-[10px] font-bold uppercase tracking-wider text-gray-500 hover:text-[#c2652a] transition-colors">
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
                        style: { colors: '#a89b91', fontWeight: '600', fontSize: '12px' },
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                },
                yaxis: {
                    labels: {
                        style: { colors: '#a89b91', fontWeight: '600', fontSize: '12px' },
                        formatter: (val) => Math.floor(val),
                    },
                    min: 0,
                },
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: 3,
                    colors: ['#c2652a'],
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.35,
                        opacityTo: 0.02,
                        stops: [0, 90, 100],
                        colorStops: [{
                            offset: 0, color: '#c2652a', opacity: 0.35,
                        }, {
                            offset: 100, color: '#faf8f5', opacity: 0.02,
                        }],
                    },
                },
                markers: {
                    size: 5,
                    colors: ['#ffffff'],
                    strokeColors: '#c2652a',
                    strokeWidth: 3,
                    hover: { size: 7 },
                },
                grid: {
                    borderColor: '#f0ebe4',
                    strokeDashArray: 4,
                    yaxis: { lines: { show: true } },
                    xaxis: { lines: { show: false } },
                    padding: { left: 5, right: 5 },
                },
                tooltip: {
                    theme: 'light',
                    style: { fontFamily: 'Manrope, sans-serif', fontSize: '13px', fontWeight: 600 },
                    y: { formatter: (val) => `${val} Motor` },
                },
                colors: ['#c2652a'],
                noData: {
                    text: 'Belum ada data absensi',
                    style: { color: '#a89b91', fontSize: '14px', fontFamily: 'Manrope, sans-serif' },
                },
            };

            const chart = new ApexCharts(document.querySelector('#chart-absensi'), options);
            chart.render();
        });
    </script>

</x-admin-layout>
