<!DOCTYPE html>
<html lang="id" class="bg-black antialiased selection:bg-white/20 selection:text-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Smart Park School | Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4 { font-family: 'Manrope', sans-serif; letter-spacing: -0.02em; }
    </style>
</head>
<body class="min-h-screen relative overflow-x-hidden text-white bg-black flex flex-col justify-center py-12">

    {{-- Latar Belakang --}}
    <div class="fixed inset-0 bg-black z-[-2]"></div>
    <div class="fixed inset-0 opacity-[0.03] z-[-1]" style="background-image: linear-gradient(rgba(255,255,255,1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,1) 1px, transparent 1px); background-size: 40px 40px;"></div>
    
    {{-- Glow --}}
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-white/5 blur-[100px] rounded-full pointer-events-none z-[-1]"></div>

    <div class="flex flex-col justify-center px-6 lg:px-8 relative z-10 w-full">
        
        <div class="sm:mx-auto sm:w-full sm:max-w-[420px]">
            {{-- Bento Card Container --}}
            <div class="bg-[#121212] border border-white/10 rounded-[32px] p-8 sm:p-10 shadow-2xl relative overflow-hidden">
                
                {{-- Card Header --}}
                <div class="mb-8 text-center">
                    <div class="w-14 h-14 mx-auto bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center mb-5 backdrop-blur-md">
                        <img src="{{ asset('image/logopks-removebg-preview.png') }}" alt="Logo" class="w-10 h-10 object-contain brightness-0 invert opacity-90" />
                    </div>
                    <h2 class="text-[28px] font-extrabold text-white tracking-tight">Selamat Datang</h2>
                    <p class="mt-2 text-[14px] font-medium text-zinc-400">Autentikasi portal parkir cerdas.</p>
                </div>

                {{-- Alert Error --}}
                @if ($errors->any())
                    <div class="mb-8 flex items-start gap-3 rounded-2xl p-4 bg-red-950/30 border border-red-500/20 backdrop-blur-sm">
                        <span class="material-icons-round text-[20px] mt-0.5 text-red-500">error_outline</span>
                        <p class="text-[13px] font-medium text-red-400">{{ $errors->first() }}</p>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label for="nis_nip" class="block text-[13px] font-bold text-zinc-300 mb-2">Nomor Induk Siswa (NIS)</label>
                        <input id="nis_nip" type="text" name="nis_nip" value="{{ old('nis_nip') }}" required autocomplete="off" placeholder="17460" 
                            class="block w-full rounded-xl bg-white/5 px-4 py-3 text-[15px] text-white outline-none border border-white/10 placeholder:text-zinc-600 focus:bg-white/10 focus:border-white/30 transition-all" />
                    </div>

                    <div x-data="{ show: false }">
                        <label for="password" class="block text-[13px] font-bold text-zinc-300 mb-2">Kata Sandi</label>
                        <div class="relative">
                            <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="••••••••" 
                                class="block w-full rounded-xl bg-white/5 pl-4 pr-12 py-3 text-[15px] tracking-widest text-white outline-none border border-white/10 placeholder:text-zinc-600 focus:bg-white/10 focus:border-white/30 transition-all placeholder:tracking-normal" />
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 px-4 flex items-center justify-center text-zinc-500 hover:text-white transition-colors">
                                <span class="material-icons-round text-[20px]" x-text="show ? 'visibility_off' : 'visibility'"></span>
                            </button>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-3.5 text-[14px] font-extrabold text-black hover:bg-zinc-200 transition-colors shadow-[0_0_20px_rgba(255,255,255,0.1)] hover:shadow-[0_0_30px_rgba(255,255,255,0.2)]">
                            Akses Sistem
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center text-[13px] font-medium text-zinc-500">
                    Belum mendaftar?
                    <a href="/daftar" class="font-bold text-white hover:text-zinc-300 transition-colors ml-1">Registrasi Baru</a>
                </div>

            </div>

            {{-- Hubungi Admin --}}
            <div class="mt-8 text-center">
                <a href="https://wa.me/6288975073072" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 text-[12px] font-medium text-zinc-400 hover:text-white hover:bg-white/10 transition-colors backdrop-blur-md">
                    <span class="material-icons-round text-[16px]">support_agent</span>
                    Butuh Bantuan? Hubungi Admin
                </a>
            </div>

        </div>
    </div>
</body>
</html>
