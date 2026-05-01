<!DOCTYPE html>
<html lang="id" class="h-full bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Park School | Registrasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">

        {{-- Header --}}
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img src="{{ asset('image/logopks-removebg-preview.png') }}" alt="Smart Park School" class="h-40 w-max mx-auto" />
            <h2 class="mt-4 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Daftar Kendaraan</h2>
            <p class="mt-2 text-center text-sm text-gray-600">Registrasi mandiri siswa pengguna motor SMKN 1 Kebumen.</p>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

            {{-- Success Alert --}}
            @if (session('success'))
                <div class="mb-6 flex items-start gap-3 rounded-md p-4 bg-green-50 border border-green-200">
                    <span class="material-icons text-[20px] mt-0.5 text-green-600">check_circle_outline</span>
                    <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Error Alert --}}
            @if ($errors->any())
                <div class="mb-6 flex items-start gap-3 rounded-md p-4 bg-red-50 border border-red-200">
                    <span class="material-icons text-[20px] mt-0.5 text-red-600">error_outline</span>
                    <p class="text-sm font-semibold text-red-800">{{ $errors->first() }}</p>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('daftar') }}" method="POST" class="space-y-6">
                @csrf

                {{-- NIS --}}
                <div>
                    <label for="nis" class="block text-sm/6 font-medium text-gray-900">Nomor Induk Siswa (NIS)</label>
                    <div class="mt-2">
                        <input id="nis" type="text" name="nis" value="{{ old('nis') }}" required
                            placeholder="Contoh: 17460"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2  focus:outline-yellow-600 sm:text-sm/6">
                    </div>
                </div>

                {{-- Kelas --}}
                <div>
                    <label for="kelas" class="block text-sm/6 font-medium text-gray-900">Kelas</label>
                    <div class="mt-2">
                        <input id="kelas" type="text" name="kelas" value="{{ old('kelas') }}" required
                            placeholder="Contoh: X PPLG 1"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2  focus:outline-yellow-600 sm:text-sm/6">
                    </div>
                </div>

                {{-- Merek Kendaraan --}}
                <div x-data="searchableDropdown([
                    @foreach($merekMotors as $m) { label: '{{ $m->nama_merek }}', value: '{{ $m->id }}' }, @endforeach
                ], '{{ old('id_merek') }}')"
                    @keydown.escape="open = false" @click.outside="open = false" class="relative">
                    <label class="block text-sm/6 font-medium text-gray-900">Merek Kendaraan</label>
                    <input type="hidden" name="id_merek" :value="selected" :required="!selected">
                    
                    <div class="mt-2">
                        <button type="button" @click="open = !open" :class="open ? 'outline-2 outline-yellow-600' : 'outline-1 outline-gray-300'" class="flex w-full items-center justify-between rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline -outline-offset-1 focus:outline-2 focus:outline-yellow-600">
                            <span :class="!selectedLabel ? 'text-gray-400' : 'text-gray-900'" x-text="selectedLabel || 'Pilih Merek Kendaraan'"></span>
                            <span class="material-icons-round text-gray-400 text-[20px]">expand_more</span>
                        </button>
                    </div>

                    <div x-show="open" x-cloak x-transition class="absolute z-50 mt-1 max-h-60 w-full overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black/5 flex flex-col">
                        <div class="p-2 border-b">
                            <input type="text" x-model="search" placeholder="Cari merek..." class="w-full rounded bg-gray-50 px-3 py-1.5 text-sm text-gray-900 outline-none border border-gray-200 focus:border-yellow-500">
                        </div>
                        <div class="overflow-y-auto flex-1 p-1">
                            <template x-for="option in filteredOptions" :key="option.value">
                                <div @click="select(option.value)" :class="selected == option.value ? 'bg-yellow-50 text-yellow-700 font-bold' : 'text-gray-900 hover:bg-gray-100'" class="cursor-pointer px-3 py-2 text-sm rounded">
                                    <span x-text="option.label"></span>
                                </div>
                            </template>
                            <div x-show="filteredOptions.length === 0" class="px-3 py-2 text-sm text-gray-500">Tidak ditemukan.</div>
                        </div>
                    </div>
                </div>

                {{-- Tipe Motor --}}
                <div x-data="searchableDropdown([
                    @foreach($tipeMotors as $t) { label: '{{ $t }}', value: '{{ $t }}' }, @endforeach
                    { label: 'Lainnya (Ketik Manual)', value: 'Lainnya' }
                ], '{{ old('model_motor') }}')"
                    @keydown.escape="open = false" @click.outside="open = false" class="relative">
                    <label class="block text-sm/6 font-medium text-gray-900">Tipe Motor (Model)</label>
                    <input type="hidden" name="model_motor" :value="selected" :required="!selected">
                    
                    <div class="mt-2">
                        <button type="button" @click="open = !open" :class="open ? 'outline-2 outline-yellow-600' : 'outline-1 outline-gray-300'" class="flex w-full items-center justify-between rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline -outline-offset-1 focus:outline-2 focus:outline-yellow-600">
                            <span :class="!selectedLabel ? 'text-gray-400' : 'text-gray-900'" x-text="selectedLabel || 'Pilih Tipe Motor (Ketik untuk mencari)'"></span>
                            <span class="material-icons-round text-gray-400 text-[20px]">expand_more</span>
                        </button>
                    </div>

                    <div x-show="open" x-cloak x-transition class="absolute z-50 mt-1 max-h-60 w-full overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black/5 flex flex-col">
                        <div class="p-2 border-b">
                            <input type="text" x-model="search" placeholder="Cari tipe motor..." class="w-full rounded bg-gray-50 px-3 py-1.5 text-sm text-gray-900 outline-none border border-gray-200 focus:border-yellow-500">
                        </div>
                        <div class="overflow-y-auto flex-1 p-1">
                            <template x-for="option in filteredOptions" :key="option.value">
                                <div @click="select(option.value)" :class="selected == option.value ? 'bg-yellow-50 text-yellow-700 font-bold' : 'text-gray-900 hover:bg-gray-100'" class="cursor-pointer px-3 py-2 text-sm rounded">
                                    <span x-text="option.label"></span>
                                </div>
                            </template>
                            <div x-show="filteredOptions.length === 0" class="px-3 py-2 text-sm text-gray-500">Tidak ditemukan.</div>
                        </div>
                    </div>

                    {{-- Input Teks jika "Lainnya" --}}
                    <div x-show="selected === 'Lainnya'" x-cloak x-transition class="mt-3 p-3 rounded-lg border border-yellow-200 bg-yellow-50">
                        <label class="block text-xs font-bold text-yellow-800 mb-1">Ketik Tipe Motor Anda</label>
                        <input type="text" name="model_motor_custom" value="{{ old('model_motor_custom') }}" placeholder="Contoh: Harley Davidson" 
                               :required="selected === 'Lainnya'"
                               class="block w-full rounded bg-white px-3 py-1.5 text-sm text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:outline-yellow-600">
                    </div>
                </div>

                {{-- Warna Motor --}}
                <div x-data="searchableDropdown([
                    @foreach($warnaList as $w) { label: '{{ $w }}', value: '{{ $w }}' }, @endforeach
                    { label: 'Lainnya (Ketik Manual)', value: 'Lainnya' }
                ], '{{ old('warna') }}')"
                    @keydown.escape="open = false" @click.outside="open = false" class="relative">
                    <label class="block text-sm/6 font-medium text-gray-900">Warna Dominan</label>
                    <input type="hidden" name="warna" :value="selected" :required="!selected">
                    
                    <div class="mt-2">
                        <button type="button" @click="open = !open" :class="open ? 'outline-2 outline-yellow-600' : 'outline-1 outline-gray-300'" class="flex w-full items-center justify-between rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline -outline-offset-1 focus:outline-2 focus:outline-yellow-600">
                            <span :class="!selectedLabel ? 'text-gray-400' : 'text-gray-900'" x-text="selectedLabel || 'Pilih Warna'"></span>
                            <span class="material-icons-round text-gray-400 text-[20px]">expand_more</span>
                        </button>
                    </div>

                    <div x-show="open" x-cloak x-transition class="absolute z-50 mt-1 max-h-60 w-full overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black/5 flex flex-col">
                        <div class="p-2 border-b">
                            <input type="text" x-model="search" placeholder="Cari warna..." class="w-full rounded bg-gray-50 px-3 py-1.5 text-sm text-gray-900 outline-none border border-gray-200 focus:border-yellow-500">
                        </div>
                        <div class="overflow-y-auto flex-1 p-1">
                            <template x-for="option in filteredOptions" :key="option.value">
                                <div @click="select(option.value)" :class="selected == option.value ? 'bg-yellow-50 text-yellow-700 font-bold' : 'text-gray-900 hover:bg-gray-100'" class="cursor-pointer flex items-center gap-2 px-3 py-2 text-sm rounded">
                                    <span x-text="option.label"></span>
                                </div>
                            </template>
                            <div x-show="filteredOptions.length === 0" class="px-3 py-2 text-sm text-gray-500">Tidak ditemukan.</div>
                        </div>
                    </div>

                    {{-- Input Teks jika "Lainnya" --}}
                    <div x-show="selected === 'Lainnya'" x-cloak x-transition class="mt-3 p-3 rounded-lg border border-yellow-200 bg-yellow-50">
                        <label class="block text-xs font-bold text-yellow-800 mb-1">Ketik Warna Kendaraan</label>
                        <input type="text" name="warna_custom" value="{{ old('warna_custom') }}" placeholder="Contoh: Merah Maroon" 
                               :required="selected === 'Lainnya'"
                               class="block w-full rounded bg-white px-3 py-1.5 text-sm text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:outline-yellow-600">
                    </div>
                </div>

                {{-- Jenis Transmisi --}}
                <div>
                    <label class="block text-sm/6 font-medium text-gray-900">Jenis Transmisi</label>
                    <div class="mt-2 flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenis_transmisi" value="Matic" required
                                {{ old('jenis_transmisi', 'Matic') == 'Matic' ? 'checked' : '' }}
                                class="accent-yellow-600">
                            <span class="text-sm font-medium text-gray-900">Matic</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenis_transmisi" value="Manual"
                                {{ old('jenis_transmisi') == 'Manual' ? 'checked' : '' }}
                                class="accent-yellow-600">
                            <span class="text-sm font-medium text-gray-900">Manual (Kopling/Bebek)</span>
                        </label>
                    </div>
                </div>

                {{-- Plat Nomor --}}
                <div>
                    <label for="plat_nomor" class="block text-sm/6 font-medium text-gray-900">Plat Nomor Kendaraan</label>
                    <div class="mt-2">
                        <input id="plat_nomor" type="text" name="plat_nomor" value="{{ old('plat_nomor') }}" required
                            placeholder="Contoh: AA 1234 CD"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 uppercase tracking-widest outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 placeholder:normal-case placeholder:tracking-normal focus:outline-2  focus:outline-yellow-600 sm:text-sm/6">
                    </div>
                    <p class="mt-1.5 text-xs text-gray-400">Pastikan plat nomor sesuai STNK kendaraanmu.</p>
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-yellow-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-yellow-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-600">
                        Kirim Data Pendaftaran
                    </button>
                </div>
            </form>

            {{-- Back to Login --}}
            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Sudah punya akun?
                <a href="/login" class="font-semibold text-yellow-600 hover:text-yellow-500">Masuk di sini</a>
            </p>

        </div>
    </div>

    <script>
        function searchableDropdown(initialOptions, initialSelected = '') {
            return {
                open: false,
                search: '',
                selected: initialSelected,
                options: initialOptions,
                
                get filteredOptions() {
                    if (this.search === '') return this.options;
                    return this.options.filter(option => option.label.toLowerCase().includes(this.search.toLowerCase()));
                },
                
                get selectedLabel() {
                    const found = this.options.find(opt => opt.value == this.selected);
                    return found ? found.label : '';
                },
                
                select(val) {
                    this.selected = val;
                    this.open = false;
                    this.search = '';
                }
            }
        }
    </script>
</body>
</html>
