<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#f8f9fa">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>Profil – Smart Parkir SMKN 1 Kebumen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <style>
        /* ─── THE SILENT CURATOR — Design tokens ─── */
        :root {
            --surface:   #f8f9fa;
            --sl1:       #eaeff1;
            --sl2:       #ffffff;
            --sl-hi:     #dbe4e7;
            --on-s:      #2b3437;
            --on-v:      #586064;
            --primary:   #5d5f60;
            --primary-c: #e2e2e3;
            --tertiary:  #4c6175;
            --outline-v: #abb3b7;
            --ease-exp:  cubic-bezier(0.22, 1, 0.36, 1);
        }

        *, *::before, *::after { box-sizing: border-box; }
        * { -webkit-tap-highlight-color: transparent; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--sl1);
            margin: 0; padding: 0;
            height: 100dvh;
            overflow: hidden;
            display: flex; align-items: flex-start; justify-content: center;
        }

        .app-frame {
            position: relative;
            width: 100%; max-width: 430px;
            height: 100dvh;
            background: var(--surface);
            display: flex; flex-direction: column;
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
            flex: 1; overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior: contain;
        }
        .app-scroll::-webkit-scrollbar { display: none; }

        /* Sophisticated easing */
        .sc-press { transition: transform 0.2s var(--ease-exp), opacity 0.15s ease; cursor: pointer; }
        .sc-press:active { transform: scale(0.975); opacity: 0.85; }

        /* Surface cards */
        .card-l2 { background: var(--sl2); border-radius: 20px; box-shadow: 0 4px 20px rgba(43,52,55,0.04); }
        .card-l1 { background: var(--sl1); border-radius: 16px; }

        /* Top bar */
        .top-bar {
            background: rgba(248,249,250,0.9);
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
        }

        /* Bottom nav */
        .bottom-nav {
            background: rgba(248,249,250,0.97);
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border-top: 1px solid rgba(43,52,55,0.06);
        }

        /* Input fields — "No Box" per Silent Curator */
        .sc-input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: none;
            outline: none;
            background: var(--sl1);
            color: var(--on-s);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 400;
            transition: background 0.2s var(--ease-exp);
            -webkit-appearance: none;
        }
        .sc-input:focus { background: var(--sl-hi); }
        .sc-input::placeholder { color: var(--outline-v); }

        /* Buttons */
        .btn-primary {
            background: var(--primary); color: #f7f8f8;
            border: none; border-radius: 14px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-size: 14px; font-weight: 600;
            padding: 13px 20px;
            transition: all 0.25s var(--ease-exp);
            box-shadow: 0 8px 24px rgba(93,95,96,0.2);
        }
        .btn-primary:hover { box-shadow: 0 12px 32px rgba(93,95,96,0.28); }

        .btn-secondary {
            background: var(--sl1); color: var(--primary);
            border: none; border-radius: 14px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-size: 14px; font-weight: 600;
            padding: 13px 20px;
            transition: background 0.25s var(--ease-exp);
        }
        .btn-secondary:hover { background: var(--sl-hi); }

        /* Display font */
        .display-name { font-family: 'Manrope', sans-serif; letter-spacing: -0.02em; }

        /* Alert */
        .alert-success { background: #f0fff4; color: #276749; border-radius: 14px; }
        .alert-error   { background: #fff5f5; color: #9b2c2c; border-radius: 14px; }

        /* Label */
        .sc-label {
            display: block;
            font-size: 11px; font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--on-v);
            margin-bottom: 8px;
        }

        /* Tonal divider */
        .tonal-divider { height: 1px; background: var(--sl1); }
    </style>
</head>
<body>

<div class="app-frame">
    {{-- ── SCROLLABLE CONTENT ── --}}
    <div class="app-scroll" style="padding-bottom: 90px;">

        {{-- ── HERO: User Identity Card ── --}}
        <section style="padding: 20px 24px 16px;">
            <div class="card-l2 p-6 flex items-center gap-5">
                {{-- Avatar --}}
                <div class="w-16 h-16 rounded-full flex items-center justify-center text-[26px] font-bold flex-shrink-0"
                     style="background: var(--sl1); color: var(--on-s); font-family:'Manrope',sans-serif;">
                    {{ strtoupper(Str::substr($user->nama_lengkap, 0, 1)) }}
                </div>
                <div>
                    <h2 class="display-name font-bold text-[20px] leading-tight" style="color: var(--on-s);">
                        {{ $user->nama_lengkap }}
                    </h2>
                    <p class="text-[12px] font-medium mt-1 flex items-center gap-1.5" style="color: var(--on-v);">
                        NIS {{ $user->nis_nip }}
                    </p>
                    @if($kendaraan && $kendaraan->kelas)
                    <p class="text-[12px] font-medium mt-0.5 flex items-center gap-1.5" style="color: var(--on-v);">
                        Kelas {{ $kendaraan->kelas }}
                    </p>
                    @endif
                </div>
            </div>
        </section>

        {{-- ── SUCCESS / ERROR ALERTS ── --}}
        <div class="px-6">
            @if(session('success_kelas'))
                <div class="alert-success flex items-center gap-3 p-4 mb-4">
                    <span class="material-icons-round text-[18px]" style="color:#276749;">check_circle</span>
                    <p class="text-[13px] font-medium">{{ session('success_kelas') }}</p>
                </div>
            @endif
            @if(session('error_kelas'))
                <div class="alert-error flex items-center gap-3 p-4 mb-4">
                    <span class="material-icons-round text-[18px]" style="color:#9b2c2c;">error_outline</span>
                    <p class="text-[13px] font-medium">{{ session('error_kelas') }}</p>
                </div>
            @endif
            @if(session('success_password'))
                <div class="alert-success flex items-center gap-3 p-4 mb-4">
                    <span class="material-icons-round text-[18px]" style="color:#276749;">lock_open</span>
                    <p class="text-[13px] font-medium">{{ session('success_password') }}</p>
                </div>
            @endif
        </div>

        {{-- ── FORM 1: UBAH KELAS ── --}}
        <section style="padding: 4px 24px 20px;">
            <div class="card-l2 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0"
                         style="background: var(--sl1);">
                        <span class="material-symbols-outlined text-[18px]" style="color: var(--primary); font-variation-settings:'FILL' 1;">school</span>
                    </div>
                    <div>
                        <h3 class="display-name font-bold text-[16px]" style="color: var(--on-s);">Ubah Kelas</h3>
                        <p class="text-[11px] font-medium mt-0.5" style="color: var(--on-v);">Digunakan admin saat pengelolaan data angkatan</p>
                    </div>
                </div>

                {{-- Kelas saat ini --}}
                @if($kendaraan && $kendaraan->kelas)
                    <div class="card-l1 flex items-center gap-3 p-3.5 mb-5">
                        <span class="material-symbols-outlined text-[16px]" style="color: var(--tertiary);">info</span>
                        <p class="text-[12px] font-medium" style="color: var(--on-v);">
                            Kelas saat ini: <span class="font-bold" style="color: var(--on-s);">{{ $kendaraan->kelas }}</span>
                        </p>
                    </div>
                @endif

                @if(!$kendaraan)
                    <div class="card-l1 flex items-center gap-3 p-3.5 mb-5">
                        <span class="material-symbols-outlined text-[16px]" style="color: #9b2c2c;">warning</span>
                        <p class="text-[12px] font-medium" style="color: #9b2c2c;">Kendaraan belum terdaftar. Hubungi Admin PKS.</p>
                    </div>
                @endif

                <form action="{{ route('siswa.profil.updateKelas') }}" method="POST">
                    @csrf

                    {{-- Tingkat Kelas --}}
                    <div class="mb-4">
                        <label class="sc-label" for="tingkat">Tingkat</label>
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px;">
                            @foreach(['X','XI','XII'] as $tk)
                                @php
                                    $currentTingkat = $kendaraan ? explode(' ', $kendaraan->kelas ?? '')[0] : '';
                                @endphp
                                <label class="sc-press" style="cursor:pointer;">
                                    <input type="radio" name="tingkat" value="{{ $tk }}"
                                           {{ old('tingkat', $currentTingkat) === $tk ? 'checked' : '' }}
                                           class="sr-only" required>
                                    <div class="text-center py-3 rounded-[12px] font-semibold text-[14px] transition-all duration-200"
                                         style="background: var(--sl1); color: var(--on-v);"
                                         x-bind:style="">
                                        {{ $tk }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('tingkat')
                            <p class="text-[12px] mt-2" style="color:#9b2c2c;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jurusan --}}
                    <div class="mb-4">
                        <label class="sc-label" for="jurusan">Jurusan / Kompetensi</label>
                        <input type="text" name="jurusan" id="jurusan" class="sc-input"
                               placeholder="Contoh: PPLG, TKJ, AKL, MPLB…"
                               value="{{ old('jurusan', $kendaraan ? implode(' ', array_slice(explode(' ', $kendaraan->kelas ?? ''), 1, -1)) : '') }}"
                               required>
                        @error('jurusan')
                            <p class="text-[12px] mt-2" style="color:#9b2c2c;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Rombel --}}
                    <div class="mb-6">
                        <label class="sc-label" for="rombel">Nomor Rombel <span style="color:var(--outline-v); font-weight:400; text-transform:none; letter-spacing:0;">(opsional)</span></label>
                        <input type="number" name="rombel" id="rombel" class="sc-input"
                               placeholder="Contoh: 1, 2, 3…"
                               min="1" max="10"
                               value="{{ old('rombel', $kendaraan ? last(explode(' ', $kendaraan->kelas ?? '')) : '') }}">
                        @error('rombel')
                            <p class="text-[12px] mt-2" style="color:#9b2c2c;">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary w-full" {{ !$kendaraan ? 'disabled style=opacity:0.4;pointer-events:none;' : '' }}>
                        Simpan Kelas
                    </button>
                </form>
            </div>
        </section>

        {{-- Script untuk radio button highlight --}}
        <script>
            document.querySelectorAll('input[name="tingkat"]').forEach(radio => {
                const updateStyle = () => {
                    document.querySelectorAll('input[name="tingkat"]').forEach(r => {
                        const div = r.nextElementSibling;
                        div.style.background = r.checked ? 'var(--primary)' : 'var(--sl1)';
                        div.style.color      = r.checked ? '#f7f8f8'        : 'var(--on-v)';
                    });
                };
                radio.addEventListener('change', updateStyle);
                if (radio.checked) updateStyle();
            });
            // Run on load
            document.querySelectorAll('input[name="tingkat"]').forEach(r => {
                if (r.checked) r.dispatchEvent(new Event('change'));
            });
        </script>

        {{-- Tonal separator --}}
        <div class="tonal-divider mx-6 mb-4"></div>

        {{-- ── FORM 2: UBAH PASSWORD ── --}}
        <section style="padding: 4px 24px 32px;">
            <div class="card-l2 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0"
                         style="background: var(--sl1);">
                        <span class="material-symbols-outlined text-[18px]" style="color: var(--primary); font-variation-settings:'FILL' 1;">lock</span>
                    </div>
                    <h3 class="display-name font-bold text-[16px]" style="color: var(--on-s);">Ubah Password</h3>
                </div>

                <form action="{{ route('siswa.profil.updatePassword') }}" method="POST">
                    @csrf

                    {{-- Password Lama --}}
                    <div class="mb-5">
                        <label class="sc-label" for="password_lama">Password Saat Ini</label>
                        <input type="password" name="password_lama" id="password_lama"
                               class="sc-input" placeholder="Masukkan password saat ini" autocomplete="current-password">
                        @error('password_lama')
                            <p class="text-[12px] mt-2" style="color:#9b2c2c;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password Baru --}}
                    <div class="mb-5">
                        <label class="sc-label" for="password_baru">Password Baru</label>
                        <input type="password" name="password_baru" id="password_baru"
                               class="sc-input" placeholder="Minimal 6 karakter" autocomplete="new-password">
                        @error('password_baru')
                            <p class="text-[12px] mt-2" style="color:#9b2c2c;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konfirmasi --}}
                    <div class="mb-6">
                        <label class="sc-label" for="password_baru_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" name="password_baru_confirmation" id="password_baru_confirmation"
                               class="sc-input" placeholder="Ulangi password baru" autocomplete="new-password">
                    </div>

                    <button type="submit" class="btn-secondary w-full">Simpan Password</button>
                </form>
            </div>
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

        {{-- Panduan – INACTIVE --}}
        <a href="{{ route('siswa.panduan') }}"
           class="flex flex-col items-center gap-1 px-4 py-1.5 rounded-[12px] sc-press">
            <span class="material-symbols-outlined text-[22px]" style="color: var(--on-v);">menu_book</span>
            <span class="text-[10px] font-semibold" style="color: var(--on-v);">Panduan</span>
        </a>

        {{-- Profil – ACTIVE --}}
        <a href="{{ route('siswa.profil') }}"
           class="flex flex-col items-center gap-1 px-4 py-1.5 rounded-[12px] sc-press"
           style="background: var(--primary-c);">
            <span class="material-symbols-outlined text-[22px]" style="color: var(--primary); font-variation-settings:'FILL' 1;">person</span>
            <span class="text-[10px] font-semibold" style="color: var(--primary);">Profil</span>
        </a>

    </div>

</div>{{-- end app-frame --}}

</body>
</html>
