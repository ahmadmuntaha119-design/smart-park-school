<!DOCTYPE html>
<html lang="id" class="bg-black antialiased selection:bg-white/20 selection:text-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Smart Park School | Registrasi Kendaraan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4 { font-family: 'Manrope', sans-serif; letter-spacing: -0.02em; }
        
        /* Custom Radio Button for Dark Theme */
        input[type="radio"].dark-radio {
            appearance: none;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.05);
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            position: relative;
        }
        input[type="radio"].dark-radio:checked {
            border-color: #ffffff;
            background: #ffffff;
        }
        input[type="radio"].dark-radio:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
            background: #000000;
        }
    </style>
</head>
<body class="min-h-screen relative overflow-x-hidden text-white bg-black">

    {{-- Latar Belakang --}}
    <div class="fixed inset-0 bg-black z-[-2]"></div>
    <div class="fixed inset-0 opacity-[0.03] z-[-1]" style="background-image: linear-gradient(rgba(255,255,255,1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,1) 1px, transparent 1px); background-size: 40px 40px;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-white/5 blur-[120px] rounded-full pointer-events-none z-[-1]"></div>

    <div class="min-h-screen flex flex-col py-12 sm:py-20 px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
            
            <div class="bg-[#121212] border border-white/10 rounded-[32px] p-6 sm:p-10 shadow-2xl relative overflow-hidden">
                
                {{-- Header Form --}}
                <div class="mb-8 text-center">
                    <div class="w-14 h-14 mx-auto bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center mb-5 backdrop-blur-md">
                        <span class="material-icons-round text-[28px] text-white">two_wheeler</span>
                    </div>
                    <h2 class="text-[26px] sm:text-[32px] font-extrabold text-white tracking-tight">Daftar Kendaraan</h2>
                    <p class="mt-2 text-[14px] font-medium text-zinc-400">Registrasi mandiri tiket digital SMKN 1 Kebumen.</p>
                </div>

                {{-- Success Alert --}}
                @if (session('success'))
                    <div class="mb-8 flex items-start gap-3 rounded-2xl p-4 bg-emerald-950/30 border border-emerald-500/20 backdrop-blur-sm">
                        <span class="material-icons-round text-[20px] mt-0.5 text-emerald-500">check_circle_outline</span>
                        <p class="text-[13px] font-medium text-emerald-400">{{ session('success') }}</p>
                    </div>
                @endif

                {{-- Error Alert --}}
                @if ($errors->any())
                    <div class="mb-8 flex items-start gap-3 rounded-2xl p-4 bg-red-950/30 border border-red-500/20 backdrop-blur-sm">
                        <span class="material-icons-round text-[20px] mt-0.5 text-red-500">error_outline</span>
                        <p class="text-[13px] font-medium text-red-400">{{ $errors->first() }}</p>
                    </div>
                @endif

                {{-- Form dengan Grid 2 Kolom --}}
                <form action="{{ route('daftar') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-x-5 gap-y-6">
                    @csrf

                    {{-- NIS --}}
                    <div>
                        <label for="nis" class="block text-[13px] font-bold text-zinc-300 mb-2">Nomor Induk Siswa (NIS)</label>
                        <input id="nis" type="text" name="nis" value="{{ old('nis') }}" required placeholder="Contoh: 17460"
                            class="block w-full rounded-xl bg-white/5 px-4 py-3 text-[15px] text-white outline-none border border-white/10 placeholder:text-zinc-600 focus:bg-white/10 focus:border-white/30 transition-all">
                    </div>

                    {{-- Kelas --}}
                    <div>
                        <label for="kelas" class="block text-[13px] font-bold text-zinc-300 mb-2">Kelas</label>
                        <input id="kelas" type="text" name="kelas" value="{{ old('kelas') }}" required placeholder="Contoh: X PPLG 1"
                            class="block w-full rounded-xl bg-white/5 px-4 py-3 text-[15px] text-white outline-none border border-white/10 placeholder:text-zinc-600 focus:bg-white/10 focus:border-white/30 transition-all">
                    </div>

                    {{-- Merek Kendaraan --}}
                    <div x-data="searchableDropdown([
                        @foreach($merekMotors as $m) { label: '{{ $m->nama_merek }}', value: '{{ $m->id }}' }, @endforeach
                    ], '{{ old('id_merek') }}')"
                        @keydown.escape="open = false" @click.outside="open = false" class="relative z-40">
                        <label class="block text-[13px] font-bold text-zinc-300 mb-2">Merek Kendaraan</label>
                        <input type="hidden" name="id_merek" :value="selected" :required="!selected">
                        
                        <button type="button" @click="open = !open" :class="open ? 'bg-white/10 border-white/30' : 'bg-white/5 border-white/10'" 
                            class="flex w-full items-center justify-between rounded-xl px-4 py-3 text-[15px] text-white outline-none border hover:bg-white/10 transition-all">
                            <span :class="!selectedLabel ? 'text-zinc-500' : 'text-white'" x-text="selectedLabel || 'Pilih Merek'"></span>
                            <span class="material-icons-round text-zinc-500 text-[20px]">expand_more</span>
                        </button>

                        {{-- Dropdown Panel Dark --}}
                        <div x-show="open" x-cloak x-transition class="absolute mt-2 w-full overflow-hidden rounded-2xl bg-[#1a1a1a] border border-white/10 shadow-2xl flex flex-col backdrop-blur-xl">
                            <div class="p-2 border-b border-white/10">
                                <input type="text" x-model="search" placeholder="Cari..." class="w-full rounded-xl bg-white/5 px-3 py-2 text-[14px] text-white outline-none border border-transparent focus:border-white/20 placeholder:text-zinc-600 transition-all">
                            </div>
                            <div class="overflow-y-auto max-h-48 p-1">
                                <template x-for="option in filteredOptions" :key="option.value">
                                    <div @click="select(option.value)" :class="selected == option.value ? 'bg-white text-black font-extrabold' : 'text-zinc-300 hover:bg-white/10 hover:text-white'" class="cursor-pointer px-4 py-2.5 text-[14px] rounded-xl transition-colors">
                                        <span x-text="option.label"></span>
                                    </div>
                                </template>
                                <div x-show="filteredOptions.length === 0" class="px-4 py-3 text-[13px] text-zinc-500 text-center">Tidak ditemukan.</div>
                            </div>
                        </div>
                    </div>

                    {{-- Tipe Motor --}}
                    <div x-data="searchableDropdown([
                        @foreach($tipeMotors as $t) { label: '{{ $t }}', value: '{{ $t }}' }, @endforeach
                        { label: 'Lainnya (Ketik Manual)', value: 'Lainnya' }
                    ], '{{ old('model_motor') }}')"
                        @keydown.escape="open = false" @click.outside="open = false" class="relative z-30">
                        <label class="block text-[13px] font-bold text-zinc-300 mb-2">Tipe Motor (Model)</label>
                        <input type="hidden" name="model_motor" :value="selected" :required="!selected">
                        
                        <button type="button" @click="open = !open" :class="open ? 'bg-white/10 border-white/30' : 'bg-white/5 border-white/10'" 
                            class="flex w-full items-center justify-between rounded-xl px-4 py-3 text-[15px] text-white outline-none border hover:bg-white/10 transition-all">
                            <span :class="!selectedLabel ? 'text-zinc-500' : 'text-white'" x-text="selectedLabel || 'Pilih Tipe'"></span>
                            <span class="material-icons-round text-zinc-500 text-[20px]">expand_more</span>
                        </button>

                        <div x-show="open" x-cloak x-transition class="absolute mt-2 w-full overflow-hidden rounded-2xl bg-[#1a1a1a] border border-white/10 shadow-2xl flex flex-col backdrop-blur-xl">
                            <div class="p-2 border-b border-white/10">
                                <input type="text" x-model="search" placeholder="Cari..." class="w-full rounded-xl bg-white/5 px-3 py-2 text-[14px] text-white outline-none border border-transparent focus:border-white/20 placeholder:text-zinc-600 transition-all">
                            </div>
                            <div class="overflow-y-auto max-h-48 p-1">
                                <template x-for="option in filteredOptions" :key="option.value">
                                    <div @click="select(option.value)" :class="selected == option.value ? 'bg-white text-black font-extrabold' : 'text-zinc-300 hover:bg-white/10 hover:text-white'" class="cursor-pointer px-4 py-2.5 text-[14px] rounded-xl transition-colors">
                                        <span x-text="option.label"></span>
                                    </div>
                                </template>
                                <div x-show="filteredOptions.length === 0" class="px-4 py-3 text-[13px] text-zinc-500 text-center">Tidak ditemukan.</div>
                            </div>
                        </div>

                        {{-- Input Teks jika "Lainnya" --}}
                        <div x-show="selected === 'Lainnya'" x-cloak x-transition class="absolute mt-16 w-full z-50 p-4 rounded-xl border border-white/20 bg-[#1a1a1a] shadow-2xl">
                            <label class="block text-[11px] font-extrabold text-white uppercase tracking-widest mb-2">Ketik Tipe Motor</label>
                            <input type="text" name="model_motor_custom" value="{{ old('model_motor_custom') }}" placeholder="Harley Davidson" 
                                   :required="selected === 'Lainnya'"
                                   class="block w-full rounded-lg bg-white/5 px-3 py-2 text-[14px] text-white outline-none border border-white/10 placeholder:text-zinc-600 focus:border-white/40">
                        </div>
                    </div>

                    {{-- Warna Motor --}}
                    <div x-data="searchableDropdown([
                        @foreach($warnaList as $w) { label: '{{ $w }}', value: '{{ $w }}' }, @endforeach
                        { label: 'Lainnya (Ketik Manual)', value: 'Lainnya' }
                    ], '{{ old('warna') }}')"
                        @keydown.escape="open = false" @click.outside="open = false" class="relative z-20">
                        <label class="block text-[13px] font-bold text-zinc-300 mb-2">Warna Dominan</label>
                        <input type="hidden" name="warna" :value="selected" :required="!selected">
                        
                        <button type="button" @click="open = !open" :class="open ? 'bg-white/10 border-white/30' : 'bg-white/5 border-white/10'" 
                            class="flex w-full items-center justify-between rounded-xl px-4 py-3 text-[15px] text-white outline-none border hover:bg-white/10 transition-all">
                            <span :class="!selectedLabel ? 'text-zinc-500' : 'text-white'" x-text="selectedLabel || 'Pilih Warna'"></span>
                            <span class="material-icons-round text-zinc-500 text-[20px]">expand_more</span>
                        </button>

                        <div x-show="open" x-cloak x-transition class="absolute mt-2 w-full overflow-hidden rounded-2xl bg-[#1a1a1a] border border-white/10 shadow-2xl flex flex-col backdrop-blur-xl">
                            <div class="p-2 border-b border-white/10">
                                <input type="text" x-model="search" placeholder="Cari..." class="w-full rounded-xl bg-white/5 px-3 py-2 text-[14px] text-white outline-none border border-transparent focus:border-white/20 placeholder:text-zinc-600 transition-all">
                            </div>
                            <div class="overflow-y-auto max-h-48 p-1">
                                <template x-for="option in filteredOptions" :key="option.value">
                                    <div @click="select(option.value)" :class="selected == option.value ? 'bg-white text-black font-extrabold' : 'text-zinc-300 hover:bg-white/10 hover:text-white'" class="cursor-pointer px-4 py-2.5 text-[14px] rounded-xl transition-colors">
                                        <span x-text="option.label"></span>
                                    </div>
                                </template>
                                <div x-show="filteredOptions.length === 0" class="px-4 py-3 text-[13px] text-zinc-500 text-center">Tidak ditemukan.</div>
                            </div>
                        </div>

                        {{-- Input Teks jika "Lainnya" --}}
                        <div x-show="selected === 'Lainnya'" x-cloak x-transition class="absolute mt-16 w-full z-50 p-4 rounded-xl border border-white/20 bg-[#1a1a1a] shadow-2xl">
                            <label class="block text-[11px] font-extrabold text-white uppercase tracking-widest mb-2">Ketik Warna</label>
                            <input type="text" name="warna_custom" value="{{ old('warna_custom') }}" placeholder="Merah Maroon" 
                                   :required="selected === 'Lainnya'"
                                   class="block w-full rounded-lg bg-white/5 px-3 py-2 text-[14px] text-white outline-none border border-white/10 placeholder:text-zinc-600 focus:border-white/40">
                        </div>
                    </div>

                    {{-- Jenis Transmisi --}}
                    <div>
                        <label class="block text-[13px] font-bold text-zinc-300 mb-2">Jenis Transmisi</label>
                        <div class="mt-2 flex gap-5">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="jenis_transmisi" value="Matic" required
                                    {{ old('jenis_transmisi', 'Matic') == 'Matic' ? 'checked' : '' }}
                                    class="dark-radio">
                                <span class="text-[14px] font-medium text-zinc-400 group-hover:text-white transition-colors">Matic</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="jenis_transmisi" value="Manual"
                                    {{ old('jenis_transmisi') == 'Manual' ? 'checked' : '' }}
                                    class="dark-radio">
                                <span class="text-[14px] font-medium text-zinc-400 group-hover:text-white transition-colors">Manual / Kopling</span>
                            </label>
                        </div>
                    </div>

                    {{-- Plat Nomor --}}
                    <div class="md:col-span-2 border-t border-white/5 pt-6 mt-2">
                        <label for="plat_nomor" class="block text-[13px] font-bold text-zinc-300 mb-2">Plat Nomor Kendaraan</label>
                        <input id="plat_nomor" type="text" name="plat_nomor" value="{{ old('plat_nomor') }}" required placeholder="AA 1234 CD"
                            class="block w-full rounded-xl bg-white/5 px-4 py-4 text-[20px] font-extrabold text-center text-white uppercase tracking-[0.2em] outline-none border border-white/10 placeholder:text-zinc-700 placeholder:font-medium placeholder:tracking-normal focus:bg-white/10 focus:border-white/40 transition-all">
                        <p class="mt-2 text-center text-[11px] font-medium text-zinc-500 uppercase tracking-widest">Pastikan plat nomor sesuai STNK.</p>
                    </div>

                    {{-- Submit --}}
                    <div class="md:col-span-2 pt-2">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-4 text-[15px] font-extrabold text-black hover:bg-zinc-200 transition-colors shadow-[0_0_20px_rgba(255,255,255,0.1)] hover:shadow-[0_0_30px_rgba(255,255,255,0.2)]">
                            <span class="material-icons-round text-[20px]">how_to_reg</span>
                            Kirim Data Registrasi
                        </button>
                    </div>

                </form>

                <div class="mt-10 pt-6 border-t border-white/5 text-center text-[13px] font-medium text-zinc-500">
                    Sudah memiliki akses?
                    <a href="/login" class="font-bold text-white hover:text-zinc-300 transition-colors ml-1">Masuk di sini</a>
                </div>

            </div>

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
