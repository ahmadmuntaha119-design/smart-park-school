<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#f8f9fa">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Smart Parkir – PKS SMKN 1 Kebumen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <style>
        /* ─────────────────────────────────────────
           DESIGN SYSTEM: PREMIUM MONOCHROME TECH
        ───────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; }
        * { -webkit-tap-highlight-color: transparent; }

        :root {
            --surface:    #000000;
            --sl1:        #000000;
            --sl2:        #121212;
            --sl-hi:      #18181b; /* zinc-900 */
            --on-s:       #ffffff;
            --on-v:       #a1a1aa; /* zinc-400 */
            --primary:    #ffffff;
            --primary-c:  rgba(255, 255, 255, 0.1);
            --tertiary:   #e4e4e7; /* zinc-200 */
            --outline-v:  rgba(255, 255, 255, 0.1);
            --ease-exp:   cubic-bezier(0.22, 1, 0.36, 1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--sl1);
            margin: 0; padding: 0;
            height: 100dvh;
            overflow: hidden;
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }

        .app-frame {
            position: relative;
            width: 100%;
            max-width: 430px;
            height: 100dvh;
            background: var(--surface);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        @media (min-width: 600px) {
            body { padding: 20px; align-items: center; height: auto; overflow: auto; }
            .app-frame {
                height: calc(100dvh - 40px);
                border-radius: 40px;
                /* Ambient shadow — The Silent Curator rule */
                box-shadow: 0 40px 80px -20px rgba(43,52,55,0.08), 0 0 0 1px rgba(43,52,55,0.04);
            }
        }

        .app-scroll {
            flex: 1;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior: contain;
        }
        .app-scroll::-webkit-scrollbar { display: none; }

        /* Sophisticated easing on interactions */
        .sc-press {
            transition: transform 0.2s var(--ease-exp), opacity 0.15s ease;
            cursor: pointer;
        }
        .sc-press:active { transform: scale(0.975); opacity: 0.85; }

        /* ── SURFACE CARDS ── */
        .card-l2 {
            background: var(--sl2);
            border-radius: 20px;
            border: 1px solid var(--outline-v);
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
        }

        .card-l1 {
            background: var(--sl1);
            border-radius: 20px;
        }

        /* ── TOP APP BAR ── */
        .top-bar {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-bottom: 1px solid var(--outline-v);
        }

        /* ── PARK PASS CARD (APPLE WALLET STYLE) ── */
        .pass-card {
            border-radius: 24px;
            overflow: hidden;
            position: relative;
            background: linear-gradient(145deg, #121212 0%, #1a1a1a 100%);
            border: 1px solid rgba(255,255,255,0.15);
            box-shadow: 0 32px 60px -12px rgba(0,0,0,0.6);
        }
        
        .pass-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(255,255,255,0.05) 0%, transparent 60%);
            pointer-events: none;
        }

        .pass-card-mono {
            font-family: 'Manrope', monospace;
            font-weight: 800;
            letter-spacing: 0.15em;
        }

        /* ── BOTTOM ACTION ── */
        .bottom-dock {
            background: linear-gradient(180deg,
                rgba(0,0,0,0) 0%,
                rgba(0,0,0,0.95) 18%,
                var(--surface) 100%);
        }

        .btn-primary {
            background: var(--primary);
            color: #000;
            font-weight: 800;
            border-radius: 16px;
            transition: all 0.25s var(--ease-exp);
            box-shadow: 0 0 20px rgba(255,255,255,0.1);
        }
        .btn-primary:hover { 
            box-shadow: 0 0 30px rgba(255,255,255,0.2); 
            background: #e4e4e7;
        }

        .btn-danger {
            background: rgba(220, 38, 38, 0.1);
            color: #ef4444;
            border: 1px solid rgba(220, 38, 38, 0.3);
            border-radius: 16px;
            transition: all 0.25s var(--ease-exp);
            box-shadow: 0 0 20px rgba(220,38,38,0.1);
        }

        .btn-done {
            background: var(--sl1);
            border-radius: 16px;
            color: var(--on-v);
        }

        /* ── CHIP ── */
        .chip {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 12px;
            border-radius: 999px;
            background: var(--primary-c);
            font-size: 11px; font-weight: 800;
            color: var(--primary);
        }
        .chip-accent {
            background: rgba(255,255,255,0.1);
            color: #ffffff;
            border: 1px solid rgba(255,255,255,0.2);
        }

        /* ── FLASH ALERT ── */
        .alert-success { background: rgba(16, 185, 129, 0.1); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.2); }
        .alert-error   { background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); }

        /* ── CAMERA OVERLAY ── */
        .camera-overlay {
            position: fixed; inset: 0;
            z-index: 100;
            background: #000;
            display: flex; flex-direction: column;
        }
        video#cameraFeed { width: 100%; flex: 1; object-fit: cover; }
        canvas#snapCanvas { display: none; }

        /* GPS pulse */
        @keyframes gps-pulse {
            0%   { transform: scale(1);   opacity: 0.9; }
            100% { transform: scale(2.6); opacity: 0; }
        }
        .gps-ring { animation: gps-pulse 1.6s var(--ease-exp) infinite; }

        /* Bottom sheet */
        .bottom-sheet {
            background: var(--sl2);
            border-radius: 28px 28px 0 0;
            border-top: 1px solid var(--outline-v);
            box-shadow: 0 -20px 60px rgba(0,0,0,0.5);
        }

        /* Manrope display */
        .display-name {
            font-family: 'Manrope', sans-serif;
            letter-spacing: -0.02em;
        }
    </style>
</head>
<body>

{{-- ================================================================
     LOCATION + GPS OVERLAY
================================================================ --}}
<div x-data="locationCheckIn()" x-init="init()" style="display:contents;">

    <div class="camera-overlay" x-show="step !== 'idle'" style="display:none;"
         x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        {{-- Top bar --}}
        <div class="flex items-center justify-between px-6 flex-shrink-0"
             style="padding-top: max(44px, env(safe-area-inset-top, 44px)); padding-bottom:14px; background:rgba(0,0,0,0.5); backdrop-filter:blur(16px);">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Verifikasi Lokasi Parkir</p>
                <p class="text-[15px] font-semibold text-white mt-0.5" x-text="overlayTitle"></p>
            </div>
            <button @click="cancelCheckIn()" class="w-9 h-9 rounded-full flex items-center justify-center sc-press"
                    style="background:rgba(255,255,255,0.1);">
                <span class="material-icons-round text-white" style="font-size:20px;">close</span>
            </button>
        </div>

        {{-- Main visual --}}
        <div class="relative flex-1 flex flex-col items-center justify-center overflow-hidden gap-6">
            <div class="w-32 h-32 rounded-full flex items-center justify-center relative">
                <div class="absolute inset-0 rounded-full" 
                     :style="inRange ? 'background:#ffffff; animation: gps-pulse 2s cubic-bezier(0.22, 1, 0.36, 1) infinite' : (jarak !== null ? 'background:#52525b; animation: gps-pulse 2s cubic-bezier(0.22, 1, 0.36, 1) infinite' : 'background:rgba(255,255,255,0.1); animation: gps-pulse 1.5s cubic-bezier(0.22, 1, 0.36, 1) infinite')">
                </div>
                <div class="absolute inset-2 rounded-full flex items-center justify-center z-10"
                     :style="inRange ? 'background:#ffffff; box-shadow: 0 0 30px rgba(255,255,255,0.5)' : (jarak !== null ? 'background:#3f3f46; box-shadow: 0 0 20px rgba(63,63,70,0.5)' : 'background:rgba(255,255,255,0.2)')">
                     <span class="material-symbols-outlined text-white" style="font-size:42px; font-variation-settings: 'FILL' 1;"
                           x-text="jarak === null ? 'location_searching' : (inRange ? 'near_me' : 'location_off')">
                     </span>
                </div>
            </div>

            <div class="text-center px-8 z-10">
                <template x-if="jarak === null">
                    <p class="text-white/60 text-[14px]">Menghubungkan ke satelit GPS...</p>
                </template>
                <template x-if="jarak !== null">
                    <div>
                        <p class="text-[32px] font-bold display-name mb-1 leading-none" 
                           :style="inRange ? 'color:#1AB076' : 'color:#fc8181'" 
                           x-text="Math.round(jarak) + 'm'"></p>
                        <p class="text-[12px] font-medium uppercase tracking-widest mb-3" style="color:rgba(255,255,255,0.4)">Jarak dari Satpam</p>
                        <p class="text-white/70 text-[13px] leading-relaxed max-w-[280px] mx-auto">
                            <span x-show="inRange">Lokasi terverifikasi. Anda berada di dalam jangkauan area sekolah.</span>
                            <span x-show="!inRange">Anda berada di luar jangkauan area. Silakan mendekat ke area sekolah.</span>
                        </p>
                    </div>
                </template>
            </div>
            
            {{-- Loading spinner helper --}}
            <div x-show="jarak === null" class="mt-4 flex flex-col items-center gap-2">
                <span class="material-icons-round animate-spin text-[24px]" style="color:#1AB076">sync</span>
                <p class="text-[10px] text-white/40">Pastikan GPS aktif & Izinkan akses lokasi</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="px-5 py-4 flex-shrink-0" style="background:rgba(0,0,0,0.7); padding-bottom: max(20px, env(safe-area-inset-bottom));">
            <button @click="submitAbsen()"
                    class="w-full flex items-center justify-center gap-3 py-4 rounded-[16px] text-white font-semibold text-[15px] sc-press transition-all duration-300"
                    :class="inRange ? '' : 'opacity-40 pointer-events-none'"
                    :style="inRange ? 'background:#1AB076;box-shadow:0 8px 24px rgba(26,176,118,0.35)' : 'background:#3a3a3a'">
                <span class="material-icons-round" style="font-size:20px;">done_all</span>
                Konfirmasi Check-in
            </button>
        </div>
    </div>

    {{-- Hidden form --}}
    <form id="formCheckIn" action="{{ route('siswa.checkin') }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="latitude"   id="inputLatitude">
        <input type="hidden" name="longitude"  id="inputLongitude">
    </form>

    {{-- ================================================================
         APP FRAME
    ================================================================ --}}
    <div class="app-frame" x-data="{ sheetOpen: false }">

        {{-- ── TOP APP BAR – Glassmorphism per spec ── --}}
        <header class="sticky top-0 z-40 top-bar flex items-center justify-between px-6"
        style="padding-top: max(10px, env(safe-area-inset-top, 16px)); padding-bottom: 14px;">
    
            <div class="flex items-center gap-3">
                {{-- Logo --}}
                <div class="w-10 h-10 flex-shrink-0 flex items-center justify-center relative bg-black rounded-lg">
                    <img src="{{ asset('image/logopks-removebg-preview.png') }}" 
                        alt="Smart Park School" 
                        class="w-full h-full object-contain p-1" />
                </div>
                
                <div>
                    <h1 class="font-semibold text-[14px] leading-none" style="color: var(--on-s);">Smart Parkir</h1>
                    <p class="text-[10px] font-medium mt-0.5" style="color: var(--on-v);">SMK N 1 KEBUMEN</p>
                </div>
            </div>

            {{-- Avatar trigger --}}
            <button @click="sheetOpen = true"
                    class="w-10 h-10 flex-shrink-0 rounded-full flex items-center justify-center text-[14px] font-bold sc-press"
                    style="background: var(--sl-hi); color: var(--on-s);">
                {{ strtoupper(Str::substr($user->nama_lengkap, 0, 1)) }}
            </button>
        </header>

        {{-- ── BOTTOM SHEET – Profile ── --}}
        <div x-show="sheetOpen" style="display:none;" class="fixed inset-0 z-50 flex flex-col justify-end">
            <div class="absolute inset-0" style="background:rgba(43,52,55,0.35); backdrop-filter:blur(4px);"
                 @click="sheetOpen = false"
                 x-transition:enter="transition-opacity duration-300"
                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity duration-200"
                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

            <div x-show="sheetOpen"
                 x-transition:enter="transition duration-350 transform"
                 x-transition:enter-start="translate-y-full"
                 x-transition:enter-end="translate-y-0"
                 x-transition:leave="transition duration-250 transform"
                 x-transition:leave-start="translate-y-0"
                 x-transition:leave-end="translate-y-full"
                 class="bottom-sheet relative w-full max-w-[430px] mx-auto"
                 style="padding-bottom: max(28px, env(safe-area-inset-bottom));">
                {{-- Drag handle --}}
                <div class="flex justify-center pt-3 pb-1" @click="sheetOpen = false">
                    <div class="w-10 h-1 rounded-full" style="background: var(--sl-hi);"></div>
                </div>
                <div class="px-6 pt-3 pb-2">
                    {{-- User info --}}
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center text-[20px] font-bold"
                             style="background: var(--sl1); color: var(--on-s);">
                            {{ strtoupper(Str::substr($user->nama_lengkap, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="display-name font-bold text-[17px]" style="color: var(--on-s);">{{ $user->nama_lengkap }}</h3>
                            <p class="text-[12px] mt-0.5" style="color: var(--on-v);">NIS {{ $user->nis_nip }}</p>
                        </div>
                    </div>

                    {{-- Status summary inside sheet --}}
                    <div class="card-l1 p-4 mb-5 flex items-center gap-3">
                        @if(!$absensiHariIni)
                            <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background:rgba(93,95,96,0.12);">
                                <span class="material-icons-round text-[16px]" style="color: var(--on-v);">local_parking</span>
                            </div>
                            <p class="text-[13px] font-medium" style="color: var(--on-v);">Belum check-in parkir hari ini</p>
                        @elseif(null === $absensiHariIni->waktu_keluar)
                            <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background:rgba(26,176,118,0.12);">
                                <span class="material-icons-round text-[16px]" style="color:#1AB076;">verified</span>
                            </div>
                            <p class="text-[13px] font-medium" style="color: var(--on-s);">Motor terparkir sejak {{ $absensiHariIni->waktu_masuk->format('H:i') }}</p>
                        @else
                            <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background: var(--sl-hi);">
                                <span class="material-icons-round text-[16px]" style="color: var(--on-v);">done_all</span>
                            </div>
                            <p class="text-[13px] font-medium" style="color: var(--on-v);">Parkir hari ini selesai</p>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-3 px-4 py-3.5 rounded-[14px] sc-press text-left"
                                style="background: #fff5f5; color: #c53030;">
                            <span class="material-symbols-outlined text-[20px]">logout</span>
                            <span class="font-semibold text-[14px]">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ── SCROLLABLE CONTENT ── --}}
        <div class="app-scroll" style="padding-bottom: 180px;">

            {{-- Flash messages --}}
            @if(session('success') || session('error'))
                <div class="px-6 pt-4">
                    @if(session('success'))
                        <div class="alert-success flex items-start gap-3 p-4 rounded-[16px] mb-3">
                            <span class="material-icons-round flex-shrink-0 mt-0.5" style="font-size:18px; color:#276749;">check_circle</span>
                            <p class="text-[13px] font-medium leading-relaxed">{{ session('success') }}</p>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert-error flex items-start gap-3 p-4 rounded-[16px] mb-3">
                            <span class="material-icons-round flex-shrink-0 mt-0.5" style="font-size:18px; color:#9b2c2c;">error_outline</span>
                            <p class="text-[13px] font-medium leading-relaxed">{{ session('error') }}</p>
                        </div>
                    @endif
                </div>
            @endif

            {{-- ── HERO: Greeting ──
                 Manrope display header per spec, with 32px clearance around it
            --}}
            <section style="padding: 32px 24px 24px;">
                <p class="text-[13px] font-light" style="color: var(--on-v); letter-spacing:0.01em;">Selamat datang</p>
                <div class="flex items-center gap-3 mt-2">
                    <h2 class="display-name text-[32px] font-extrabold leading-none" style="color: var(--on-s); letter-spacing: -0.02em;">
                        {{ explode(' ', $user->nama_lengkap)[0] }}
                    </h2>
                </div>
                {{-- Date - caption level --}}
                <p class="text-[11px] font-medium mt-3" style="color: var(--on-v);">
                    {{ now()->locale('id')->translatedFormat('l, d F Y') }}
                </p>
            </section>

            {{-- ── PARK PASS CARD ──
                 Darkest contrast element = highest perceived elevation
                 Monospace plate for editorial authority
            --}}
            <section style="padding: 0 24px 24px;">
                @if($kendaraan)
                    <div class="pass-card p-6">
                        {{-- Subtle background texture / watermark --}}
                        <div class="absolute inset-0 pointer-events-none overflow-hidden" style="opacity:0.03;">
                            <span class="material-symbols-outlined" style="font-size:340px; position:absolute; bottom:-80px; right:-80px; color:#fff;">two_wheeler</span>
                        </div>

                        {{-- Zona badge + label row --}}
                        <div class="relative z-10 flex items-center justify-between mb-8">
                            <span class="text-[10px] font-semibold uppercase tracking-[0.18em]" style="color:rgba(255,255,255,0.4);">ACTIVE PASS</span>
                            <div class="flex items-center gap-2">
                                @if($kendaraan->zona && $kendaraan->zona->foto_denah)
                                    <button @click="$dispatch('open-map')" class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full flex items-center gap-1 transition-all"
                                            style="background:rgba(255,255,255,0.15); color:white; border: 1px solid rgba(255,255,255,0.3);"
                                            onmouseenter="this.style.background='rgba(255,255,255,0.25)'"
                                            onmouseleave="this.style.background='rgba(255,255,255,0.15)'">
                                        <span class="material-icons-round text-[12px]">map</span> Peta
                                    </button>
                                @endif
                                @if($kendaraan->zona)
                                    <span class="text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full"
                                          style="background:rgba(255,255,255,0.1); color:rgba(255,255,255,0.7);">
                                        {{ $kendaraan->zona->nama_zona }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Plate number — editorial anchor --}}
                        <div class="relative z-10 mb-5">
                            <p class="text-[10px] font-medium uppercase tracking-[0.18em] mb-2" style="color:rgba(255,255,255,0.35);">PLAT NOMOR</p>
                            <h2 class="pass-card-mono text-[34px] leading-none text-white">
                                {{ $kendaraan->plat_nomor }}
                            </h2>
                        </div>

                        {{-- Tonal divider --}}
                        <div style="height:1px; background:rgba(255,255,255,0.06); margin-bottom:16px;"></div>

                        {{-- Vehicle info & Location Details --}}
                        <div class="relative z-10 flex items-end justify-between">
                            <div>
                                <p class="text-[10px] font-medium uppercase tracking-widest mb-1" style="color:rgba(255,255,255,0.35);">KENDARAAN</p>
                                <p class="text-[15px] font-semibold" style="color:rgba(255,255,255,0.85);">
                                    {{ $kendaraan->merek->nama_merek ?? '' }} {{ $kendaraan->model_motor }}
                                </p>
                            </div>

                            @if($kendaraan->baris || $kendaraan->nomor_slot)
                                <div class="text-right">
                                    <p class="text-[10px] font-medium uppercase tracking-widest mb-1" style="color:rgba(255,255,255,0.35);">LOKASI PETAK</p>
                                    <p class="text-[13px] font-bold" style="color:rgba(255,255,255,0.85);">
                                        {{ $kendaraan->baris->nama_baris ?? 'Area Bebas' }}
                                        @if($kendaraan->nomor_slot)
                                            <span class="ml-1 px-1.5 py-0.5 rounded text-[10px]" style="background:rgba(255,255,255,0.15); color:white;">SLOT {{ $kendaraan->nomor_slot }}</span>
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="pass-card p-6 flex flex-col items-center justify-center text-center" style="background:var(--surface-sunken); border: 1.5px dashed var(--border-subtle); box-shadow:none;">
                        <span class="material-icons-round mb-2" style="font-size:36px; color:var(--on-min);">no_crash</span>
                        <p class="text-[12px] font-extrabold uppercase tracking-widest mb-1" style="color:var(--on-v);">BELUM ADA KENDARAAN</p>
                        <p class="text-[11px] font-semibold leading-relaxed px-4" style="color:var(--on-min);">Harap hubungi admin sekolah untuk pendaftaran kendaraan pangkalan.</p>
                    </div>
                @endif
            </section>

            {{-- ── LOCATION INFO ──
                 surface-container level-1 card – no shadow needed, tonal shift does the work
            --}}
            <section style="padding: 0 24px 20px;">
                <div class="card-l1 flex items-center gap-4 p-5">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                         style="background: var(--sl-hi);">
                        <span class="material-symbols-outlined text-[20px]" style="color: var(--tertiary); font-variation-settings:'FILL' 1;">location_on</span>
                    </div>
                    <div>
                        <p class="text-[14px] font-semibold" style="color: var(--on-s);">SMK N 1 Kebumen</p>
                        <p class="text-[12px] mt-0.5" style="color: var(--on-v);">Area Parkir Utama · Radius 200m</p>
                    </div>
                </div>
            </section>

            {{-- ── ATTENDANCE STATUS CARD ── --}}
            @if($absensiHariIni)
                <section style="padding: 0 24px 20px;">
                    @if(null === $absensiHariIni->waktu_keluar)
                        <div class="card-l2 p-5">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                                         style="background:rgba(26,176,118,0.1);">
                                        <span class="material-icons-round" style="font-size:20px; color:#1AB076;">verified_user</span>
                                    </div>
                                    <div>
                                        <p class="text-[14px] font-semibold" style="color: var(--on-s);">Motor Terparkir Aman</p>
                                        <p class="text-[12px] mt-0.5" style="color: var(--on-v);">
                                            Masuk {{ $absensiHariIni->waktu_masuk->format('H:i') }} WIB
                                            @if($absensiHariIni->jarak_dari_sekolah)
                                                · {{ number_format($absensiHariIni->jarak_dari_sekolah, 0, ',', '.') }}m
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @php
                                        $dMenit = $absensiHariIni->waktu_masuk->diffInMinutes(now());
                                        $dJam   = intdiv($dMenit, 60);
                                        $dSisa  = $dMenit % 60;
                                    @endphp
                                    <p class="text-[10px] font-semibold uppercase tracking-widest mb-1" style="color: var(--on-v);">Durasi</p>
                                    <p class="display-name text-[20px] font-bold leading-none" style="color: var(--on-s);">
                                        {{ $dJam > 0 ? $dJam.'j' : '' }}{{ $dSisa }}m
                                    </p>
                                </div>
                            </div>

                            @if($absensiHariIni->jarak_dari_sekolah)
                                {{-- Tonal separator, no border --}}
                                <div style="height:1px; background: var(--sl1); margin: 16px 0;"></div>
                                <div class="flex items-center gap-2.5 text-[12px] font-semibold" style="color: var(--tertiary);">
                                    <span class="material-icons-round" style="font-size:15px;">location_on</span>
                                    Berjarak {{ number_format($absensiHariIni->jarak_dari_sekolah, 0, ',', '.') }}m dari sekolah saat datang
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="card-l1 flex items-center gap-4 p-5">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                                 style="background: var(--sl-hi);">
                                <span class="material-icons-round text-[20px]" style="color: var(--on-v);">done_all</span>
                            </div>
                            <div>
                                <p class="text-[14px] font-semibold" style="color: var(--on-s);">Parkir Hari Ini Selesai</p>
                                <p class="text-[12px] mt-0.5" style="color: var(--on-v);">
                                    {{ $absensiHariIni->waktu_masuk->format('H:i') }} → {{ $absensiHariIni->waktu_keluar->format('H:i') }} WIB
                                </p>
                            </div>
                        </div>
                    @endif
                </section>
            @endif

            {{-- ── LOST & FOUND BANNER ── --}}
            @if($pengumuman->count() > 0)
                <div x-data="{ showImage: false }" style="padding: 0 24px 24px;">
                    <button type="button" @click="showImage = true"
                            class="w-full card-l2 flex items-center gap-4 p-5 sc-press text-left">
                        <div class="relative flex-shrink-0">
                            @if($pengumuman->first()->path_foto)
                                <img src="{{ Storage::url($pengumuman->first()->path_foto) }}"
                                     class="w-12 h-12 rounded-[14px] object-cover" alt="Barang">
                            @else
                                <div class="w-12 h-12 rounded-[14px] flex items-center justify-center" style="background: var(--sl1);">
                                    <span class="material-icons-round" style="font-size:22px; color: var(--on-v);">inventory_2</span>
                                </div>
                            @endif
                            {{-- Tertiary accent dot per spec --}}
                            <span class="absolute -top-1 -right-1 w-3 h-3 rounded-full border-2 border-white"
                                  style="background: var(--tertiary);"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-bold uppercase tracking-widest mb-1" style="color: var(--tertiary);">Barang Temuan</p>
                            <p class="text-[14px] font-semibold truncate" style="color: var(--on-s);">{{ $pengumuman->first()->nama_barang }}</p>
                            <p class="text-[12px] mt-0.5 truncate" style="color: var(--on-v);">{{ $pengumuman->first()->lokasi_ditemukan }}</p>
                        </div>
                        <span class="material-icons-round flex-shrink-0" style="font-size:20px; color: var(--outline-v);">chevron_right</span>
                    </button>

                    {{-- Lightbox --}}
                    <div x-show="showImage" style="display:none;"
                         x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                         class="fixed inset-0 z-50 flex flex-col"
                         style="background:rgba(0,0,0,0.95); backdrop-filter:blur(24px);">
                        <div class="flex items-center justify-between px-6 flex-shrink-0"
                             style="padding-top: max(48px, env(safe-area-inset-top,48px)); padding-bottom:16px;">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest" style="color: var(--tertiary);">Info Barang Temuan</p>
                                <h2 class="display-name text-[20px] font-bold text-white mt-1">{{ $pengumuman->first()->nama_barang }}</h2>
                            </div>
                            <button @click.stop="showImage = false" class="w-9 h-9 rounded-full flex items-center justify-center sc-press"
                                    style="background:rgba(255,255,255,0.08);">
                                <span class="material-icons-round text-white text-[18px]">close</span>
                            </button>
                        </div>
                        <div class="flex-1 flex items-center justify-center px-6 pb-8" @click.stop>
                            @if($pengumuman->first()->path_foto)
                                <img src="{{ Storage::url($pengumuman->first()->path_foto) }}"
                                     class="max-w-full max-h-full object-contain"
                                     style="border-radius:24px; box-shadow: 0 32px 80px rgba(0,0,0,0.5);">
                            @endif
                        </div>
                        <div class="px-6 pb-10 text-center flex-shrink-0">
                            <p class="text-[11px] font-medium" style="color:rgba(255,255,255,0.3);">Hubungi Pos PKS jika ini milik Anda</p>
                        </div>
                    </div>
                </div>
            @endif

        </div>{{-- end app-scroll --}}

        {{-- ── BOTTOM NAVIGATION + CTA DOCK ── --}}
        <div class="absolute bottom-0 left-0 right-0" style="background: rgba(0,0,0,0.85); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); border-top: 1px solid var(--outline-v);">

            {{-- CTA Action --}}
            <div class="px-6 pt-4">
                @if(!$absensiHariIni)
                    <button type="button" @click="bukaLokasi()"
                            class="btn-primary w-full flex items-center justify-center gap-3 py-4 text-white font-semibold text-[15px] sc-press">
                        <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 1;">location_on</span>
                        CHECK-IN PARKIR
                    </button>
                    <p class="text-center text-[11px] font-medium mt-2" style="color: var(--on-v);">
                        GPS wajib aktif di area sekolah
                    </p>

                @elseif($absensiHariIni && null === $absensiHariIni->waktu_keluar)
                    <form action="{{ route('siswa.checkout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="btn-danger w-full flex items-center justify-center gap-3 py-4 text-white font-semibold text-[15px] sc-press">
                            <span class="material-symbols-outlined text-[22px]">logout</span>
                            CHECK-OUT PULANG
                        </button>
                    </form>
                    <p class="text-center text-[11px] font-medium mt-2" style="color: var(--on-v);">
                        Tekan saat sudah meninggalkan area sekolah
                    </p>

                @else
                    <div class="btn-done w-full flex items-center justify-center gap-3 py-4 font-semibold text-[14px] uppercase tracking-wider">
                        <span class="material-icons-round text-[20px]" style="color: var(--on-v);">done_all</span>
                        Selesai Hari Ini
                    </div>
                    <p class="text-center text-[11px] font-medium mt-2" style="color: var(--on-v);">Sampai jumpa besok 🙏</p>
                @endif
            </div>

            {{-- Bottom Nav Bar --}}
            <div class="flex items-center justify-around px-4 pt-3"
                 style="padding-bottom: max(18px, env(safe-area-inset-bottom, 18px)); border-top: 1px solid var(--outline-v); margin-top: 12px;">

                {{-- Home – ACTIVE --}}
                <a href="{{ route('siswa.dashboard') }}"
                   class="flex flex-col items-center gap-1 px-4 py-1.5 rounded-[12px] sc-press"
                   style="background: var(--primary-c);">
                    <span class="material-symbols-outlined text-[22px]" style="color: var(--primary); font-variation-settings:'FILL' 1;">home</span>
                    <span class="text-[10px] font-semibold" style="color: var(--primary);">Beranda</span>
                </a>

                {{-- Panduan – INACTIVE --}}
                <a href="{{ route('siswa.panduan') }}"
                   class="flex flex-col items-center gap-1 px-4 py-1.5 rounded-[12px] sc-press">
                    <span class="material-symbols-outlined text-[22px]" style="color: var(--on-v);">menu_book</span>
                    <span class="text-[10px] font-semibold" style="color: var(--on-v);">Panduan</span>
                </a>

                {{-- Profil – INACTIVE --}}
                <a href="{{ route('siswa.profil') }}"
                   class="flex flex-col items-center gap-1 px-4 py-1.5 rounded-[12px] sc-press">
                    <span class="material-symbols-outlined text-[22px]" style="color: var(--on-v);">person</span>
                    <span class="text-[10px] font-semibold" style="color: var(--on-v);">Profil</span>
                </a>

            </div>
        </div>

    </div>{{-- end app-frame --}}

</div>{{-- end x-data --}}</main>

{{-- ============================================================
     MODAL PETA ZONA (Siswa)
============================================================ --}}
@if($kendaraan && $kendaraan->zona && $kendaraan->zona->foto_denah)
<div x-data="{ open: false }" 
     @open-map.window="open = true" 
     @keydown.escape.window="open = false"
     x-show="open" 
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
     style="display: none;" x-transition>
     
     <div class="bg-[#1a1a1a] border border-white/10 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl" @click.away="open = false">
         <div class="p-4 border-b border-white/10 flex justify-between items-center" style="background: #121212;">
             <h3 class="font-extrabold text-sm text-white">
                 <span class="material-icons-round text-[16px] align-text-bottom text-white">map</span> 
                 Denah Zona {{ $kendaraan->zona->nama_zona }}
             </h3>
             <button @click="open = false" class="text-zinc-500 hover:text-white transition-colors">
                 <span class="material-icons-round text-[20px]">close</span>
             </button>
         </div>
         <div class="p-3 bg-black">
             <img src="{{ Storage::url($kendaraan->zona->foto_denah) }}" class="w-full rounded-xl shadow-inner border border-white/10" alt="Peta Zona">
         </div>
         <div class="p-3 text-center" style="background: #121212;">
             <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">Tutup pop-up dengan mengetuk area luar</p>
         </div>
     </div>
</div>
@endif

<script>
function locationCheckIn() {
    return {
        step: 'idle',
        lat: null, lng: null,
        jarak: null,
        inRange: false,
        gpsWatcher: null,

        SEKOLAH_LAT: {{ \App\Http\Controllers\Siswa\DashboardController::SEKOLAH_LAT }},
        SEKOLAH_LNG: {{ \App\Http\Controllers\Siswa\DashboardController::SEKOLAH_LNG }},
        RADIUS: {{ \App\Http\Controllers\Siswa\DashboardController::RADIUS_MASUK }},

        init() {},

        get overlayTitle() {
            if (this.jarak === null) return 'Mencari Lokasi...';
            if (this.inRange)        return 'Lokasi Sesuai';
            return 'Di Luar Jangkauan';
        },

        bukaLokasi() {
            this.step = 'active';
            this.mulaiGPS();
        },

        mulaiGPS() {
            if (!navigator.geolocation) {
                alert('Browser Anda tidak mendukung fitur Lokasi (GPS).');
                this.step = 'idle';
                return;
            }
            // Add a brief timeout to let UI update before requesting GPS permission which might block thread
            setTimeout(() => {
                this.gpsWatcher = navigator.geolocation.watchPosition(
                    (pos) => {
                        this.lat   = pos.coords.latitude;
                        this.lng   = pos.coords.longitude;
                        this.jarak = this.hitungJarak(this.SEKOLAH_LAT, this.SEKOLAH_LNG, this.lat, this.lng);
                        this.inRange = this.jarak <= this.RADIUS;
                    },
                    (err) => { 
                        if(err.code === err.PERMISSION_DENIED) {
                            alert('⚠️ Izin lokasi ditolak. Buka pengaturan browser untuk mengizinkan akses lokasi.');
                            this.cancelCheckIn();
                        } else {
                            this.lat = null; this.lng = null; this.jarak = null; this.inRange = false; 
                        }
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            }, 100);
        },

        submitAbsen() {
            document.getElementById('inputLatitude').value  = this.lat  ?? '';
            document.getElementById('inputLongitude').value = this.lng  ?? '';
            document.getElementById('formCheckIn').submit();
        },

        cancelCheckIn() {
            if (this.gpsWatcher !== null) {
                navigator.geolocation.clearWatch(this.gpsWatcher);
                this.gpsWatcher = null;
            }
            this.step = 'idle';
            this.jarak = null; this.inRange = false;
        },

        hitungJarak(lat1, lng1, lat2, lng2) {
            const R    = 6371000;
            const phi1 = lat1 * Math.PI / 180;
            const phi2 = lat2 * Math.PI / 180;
            const dPhi = (lat2 - lat1) * Math.PI / 180;
            const dLam = (lng2 - lng1) * Math.PI / 180;
            const a = Math.sin(dPhi/2)**2 + Math.cos(phi1)*Math.cos(phi2)*Math.sin(dLam/2)**2;
            return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        }
    };
}
</script>

</body>
</html>