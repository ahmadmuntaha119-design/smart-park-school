<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#f8f9fa">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Panduan Parkir – Smart Parkir SMKN 1 Kebumen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <style>
        /* ─── DESIGN SYSTEM: PREMIUM MONOCHROME TECH ─── */
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

        *, *::before, *::after { box-sizing: border-box; }
        * { -webkit-tap-highlight-color: transparent; }

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

        /* Sophisticated easing */
        .sc-press {
            transition: transform 0.2s var(--ease-exp), opacity 0.15s ease;
            cursor: pointer;
        }
        .sc-press:active { transform: scale(0.975); opacity: 0.85; }

        /* Surface cards — Bento Grid */
        .card-l2 {
            background: var(--sl2);
            border-radius: 20px;
            border: 1px solid var(--outline-v);
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
        }
        .card-l1 {
            background: var(--sl1);
            border-radius: 16px;
        }

        /* Top bar — Glassmorphism */
        .top-bar {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-bottom: 1px solid var(--outline-v);
        }

        /* Bottom nav */
        .bottom-nav {
            background: rgba(0,0,0,0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-top: 1px solid var(--outline-v);
        }

        /* Rule card hover */
        .rule-card {
            background: var(--sl2);
            border-radius: 16px;
            border: 1px solid var(--outline-v);
            transition: all 0.25s var(--ease-exp);
        }
        .rule-card:hover { 
            background: var(--sl-hi); 
            border-color: rgba(255,255,255,0.3);
        }

        /* YouTube embed card */
        .yt-card {
            background: var(--sl2);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--outline-v);
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
        }

        .yt-card iframe {
            width: 100%;
            aspect-ratio: 16 / 9;
            border: none;
            display: block;
        }

        .display-name {
            font-family: 'Manrope', sans-serif;
            letter-spacing: -0.02em;
        }

        /* Section divider — tonal, no 1px solid */
        .tonal-divider {
            height: 1px;
            background: var(--sl1);
        }
    </style>
</head>
<body>

<div class="app-frame">

    {{-- ── SCROLLABLE CONTENT ── --}}
    <div class="app-scroll" style="padding-bottom: 120px;">

        {{-- ── HERO SECTION ── --}}
        <section style="padding: 28px 24px 20px;">
            <h2 class="display-name font-extrabold text-[28px] leading-tight" style="color: var(--on-s); letter-spacing: -0.02em;">
                Panduan Siswa
            </h2>
            <p class="text-[14px] font-light mt-2 leading-relaxed" style="color: var(--on-v);">
                Tata tertib dan panduan lengkap sistem parkir cerdas sekolah.
            </p>
        </section>

        {{-- ── PERATURAN WAJIB ── --}}
        <section style="padding: 0 24px 24px;">
            <h3 class="display-name font-bold text-[16px] mb-4" style="color: var(--on-s);">Peraturan Wajib</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">

                {{-- Rule 1 --}}
                <div class="rule-card p-5">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-4"
                         style="background: var(--sl2); box-shadow: 0 2px 8px rgba(43,52,55,0.04);">
                        <span class="material-symbols-outlined text-[20px]" style="color: var(--primary); font-variation-settings:'FILL' 1;">sports_motorsports</span>
                    </div>
                    <h4 class="display-name font-semibold text-[13px] mb-1.5" style="color: var(--on-s);">Wajib Menggunakan Helm</h4>
                    <p class="text-[11px] font-light leading-relaxed" style="color: var(--on-v);">Helm wajib dipakai hingga motor terparkir sempurna.</p>
                </div>

                {{-- Rule 2 --}}
                <div class="rule-card p-5">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-4"
                         style="background: var(--sl2); box-shadow: 0 2px 8px rgba(43,52,55,0.04);">
                        <span class="material-symbols-outlined text-[20px]" style="color: var(--primary); font-variation-settings:'FILL' 1;">location_on</span>
                    </div>
                    <h4 class="display-name font-semibold text-[13px] mb-1.5" style="color: var(--on-s);">Parkir Sesuai Zona</h4>
                    <p class="text-[11px] font-light leading-relaxed" style="color: var(--on-v);">Parkir hanya di zona yang telah ditentukan admin.</p>
                </div>

                {{-- Rule 3 --}}
                <div class="rule-card p-5">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-4"
                         style="background: var(--sl2); box-shadow: 0 2px 8px rgba(43,52,55,0.04);">
                        <span class="material-symbols-outlined text-[20px]" style="color: var(--primary); font-variation-settings:'FILL' 1;">lock</span>
                    </div>
                    <h4 class="display-name font-semibold text-[13px] mb-1.5" style="color: var(--on-s);">Kunci Ganda</h4>
                    <p class="text-[11px] font-light leading-relaxed" style="color: var(--on-v);">Gunakan kunci ganda untuk keamanan maksimal kendaraanmu.</p>
                </div>

                {{-- Rule 4 --}}
                <div class="rule-card p-5">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-4"
                         style="background: var(--sl2); box-shadow: 0 2px 8px rgba(43,52,55,0.04);">
                        <span class="material-symbols-outlined text-[20px]" style="color: var(--primary); font-variation-settings:'FILL' 1;">my_location</span>
                    </div>
                    <h4 class="display-name font-semibold text-[13px] mb-1.5" style="color: var(--on-s);">Absen Wajib Tiap Hari</h4>
                    <p class="text-[11px] font-light leading-relaxed" style="color: var(--on-v);">Check-in menggunakan GPS .</p>
                </div>

                {{-- Rule 5 --}}
                <div class="rule-card p-5">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-4"
                         style="background: var(--sl2); box-shadow: 0 2px 8px rgba(43,52,55,0.04);">
                        <span class="material-symbols-outlined text-[20px]" style="color: var(--primary); font-variation-settings:'FILL' 1;">speed</span>
                    </div>
                    <h4 class="display-name font-semibold text-[13px] mb-1.5" style="color: var(--on-s);">Kecepatan Aman</h4>
                    <p class="text-[11px] font-light leading-relaxed" style="color: var(--on-v);">Kendaraan masuk/keluar area sekolah max 10 km/jam.</p>
                </div>

                {{-- Rule 6 --}}
                <div class="rule-card p-5">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-4"
                         style="background: var(--sl2); box-shadow: 0 2px 8px rgba(43,52,55,0.04);">
                        <span class="material-symbols-outlined text-[20px]" style="color: var(--primary); font-variation-settings:'FILL' 1;">people</span>
                    </div>
                    <h4 class="display-name font-semibold text-[13px] mb-1.5" style="color: var(--on-s);">Dilarang Bonceng Tiga</h4>
                    <p class="text-[11px] font-light leading-relaxed" style="color: var(--on-v);">Dilarang membawa penumpang lebih dari 1 orang.</p>
                </div>

            </div>
        </section>

        {{-- Tonal separator —  no 1px solid border --}}
        <div class="tonal-divider mx-6 mb-6"></div>

        {{-- ── ALUR CHECK-IN ── --}}
        <section style="padding: 0 24px 24px;">
            <h3 class="display-name font-bold text-[16px] mb-4" style="color: var(--on-s);">Cara Check-In Parkir</h3>

            <div class="card-l2 p-5" style="display: flex; flex-direction: column; gap: 0;">

                {{-- Step 1 --}}
                <div class="flex gap-4 items-start">
                    <div class="flex flex-col items-center flex-shrink-0">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-[13px]"
                             style="background: var(--primary); color: #000;">1</div>
                        <div style="width:1px; height:32px; background: var(--sl1); margin: 4px 0;"></div>
                    </div>
                    <div class="pb-4">
                        <p class="text-[13px] font-semibold" style="color: var(--on-s);">Buka Dashboad & Tekan Check-In</p>
                        <p class="text-[11px] font-light mt-0.5 leading-relaxed" style="color: var(--on-v);">Tombol hijau "CHECK-IN PARKIR" ada di bagian bawah halaman utama.</p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="flex gap-4 items-start">
                    <div class="flex flex-col items-center flex-shrink-0">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-[13px]"
                             style="background: var(--primary); color: #000;">2</div>
                        <div style="width:1px; height:32px; background: var(--sl1); margin: 4px 0;"></div>
                    </div>
                    <div class="pb-4">
                        <p class="text-[13px] font-semibold" style="color: var(--on-s);">Izinkan Akses Lokasi</p>
                        <p class="text-[11px] font-light mt-0.5 leading-relaxed" style="color: var(--on-v);">Browser akan meminta izin akses lokasi.</p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="flex gap-4 items-start">
                    <div class="flex flex-col items-center flex-shrink-0">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-[13px]"
                             style="background: var(--primary); color: #000;">3</div>
                        <div style="width:1px; height:32px; background: var(--sl1); margin: 4px 0;"></div>
                    </div>
                    <div class="pb-4">
                        <p class="text-[13px] font-semibold" style="color: var(--on-s);">Pastikan GPS Hijau (Dalam Radius)</p>
                        <p class="text-[11px] font-light mt-0.5 leading-relaxed" style="color: var(--on-v);">Indikator GPS harus berwarna hijau (dalam radius 200m dari sekolah).</p>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div class="flex gap-4 items-start">
                    <div class="flex flex-col items-center flex-shrink-0">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-[13px]"
                             style="background: var(--on-s); color: #000;">✓</div>
                    </div>
                    <div>
                        <p class="text-[13px] font-semibold" style="color: var(--on-s);">Konfirmasi & Selesai</p>
                        <p class="text-[11px] font-light mt-0.5 leading-relaxed" style="color: var(--on-v);">Setelah Konfirmasi Selesai absensimu berhasil tercatat.</p>
                    </div>
                </div>

            </div>
        </section>

        {{-- Tonal separator --}}
        <div class="tonal-divider mx-6 mb-6"></div>

        {{-- ── VIDEO TUTORIAL ZONA PARKIR ── --}}
        <section style="padding: 0 24px 80px;">
            <h3 class="font-bold text-[16px] mb-2" style="font-family:'Manrope',sans-serif; color:var(--on-s);">Video Panduan Zona Parkir</h3>
            <p class="text-[12px] font-light mb-4" style="color:var(--on-v);">Pelajari denah dan zona parkir sekolah melalui video berikut.</p>

            {{-- Video Card --}}
            <a href="https://www.youtube.com/watch?v=kzunPLbBjBo" target="_blank" rel="noopener noreferrer"
               class="group block rounded-2xl overflow-hidden relative"
               style="background:var(--sl2); border:1px solid var(--outline-v);">

                {{-- Thumbnail / Gradient Area --}}
                <div class="relative w-full" style="padding-bottom:56.25%;">
                    <div class="absolute inset-0 bg-gradient-to-tr from-zinc-950 via-zinc-900 to-zinc-800"></div>

                    {{-- Grid overlay --}}
                    <div class="absolute inset-0" style="
                        background-image:
                            linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                            linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
                        background-size: 32px 32px;
                    "></div>

                    {{-- Play Button --}}
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center transition-all duration-300 group-hover:scale-110"
                             style="background:rgba(255,255,255,0.1); border:1.5px solid rgba(255,255,255,0.25); backdrop-filter:blur(8px);">
                            <span class="material-icons-round text-white text-[32px] ml-1">play_arrow</span>
                        </div>
                    </div>

                    {{-- Bottom label inside thumbnail --}}
                    <div class="absolute bottom-0 left-0 right-0 px-4 py-3" style="background:linear-gradient(to top, rgba(0,0,0,0.85), transparent);">
                        <p class="text-[10px] font-semibold uppercase tracking-widest mb-0.5" style="color:var(--on-v);">Video Visual Denah</p>
                        <p class="text-[14px] font-bold leading-snug" style="color:var(--on-s);">Tonton Video untuk Mengetahui Zona yang Didapatkan</p>
                    </div>
                </div>
            </a>
        </section>


    </div>{{-- end app-scroll --}}

    {{-- ── BOTTOM NAVIGATION ── --}}
    <div class="bottom-nav flex items-center justify-around px-4 pt-3"
         style="padding-bottom: max(20px, env(safe-area-inset-bottom, 20px));">

        {{-- Home – INACTIVE --}}
        <a href="{{ route('siswa.dashboard') }}"
           class="flex flex-col items-center gap-1 px-4 py-1.5 rounded-[12px] sc-press">
            <span class="material-symbols-outlined text-[22px]" style="color: var(--on-v);">home</span>
            <span class="text-[10px] font-semibold" style="color: var(--on-v);">Beranda</span>
        </a>

        {{-- Panduan – ACTIVE --}}
        <a href="{{ route('siswa.panduan') }}"
           class="flex flex-col items-center gap-1 px-4 py-1.5 rounded-[12px] sc-press"
           style="background: var(--primary-c);">
            <span class="material-symbols-outlined text-[22px]" style="color: var(--primary); font-variation-settings:'FILL' 1;">menu_book</span>
            <span class="text-[10px] font-semibold" style="color: var(--primary);">Panduan</span>
        </a>

        {{-- Profil – INACTIVE --}}
        <a href="{{ route('siswa.profil') }}"
           class="flex flex-col items-center gap-1 px-4 py-1.5 rounded-[12px] sc-press">
            <span class="material-symbols-outlined text-[22px]" style="color: var(--on-v);">person</span>
            <span class="text-[10px] font-semibold" style="color: var(--on-v);">Profil</span>
        </a>

    </div>

</div>{{-- end app-frame --}}

</body>
</html>
