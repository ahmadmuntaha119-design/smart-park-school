<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Smart Parkir – SMKN 1 Kebumen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <style>
        :root {
            --surface: #faf8f5;
            --on-s: #2d241e;
            --on-v: #7a6b61;
            --primary: #c2652a; /* goldenrod Sahara */
            --primary-h: #a8551e;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--surface);
            color: var(--on-s);
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, .display-font {
            font-family: 'Manrope', sans-serif;
        }

        .glass-nav {
            background: rgba(250, 248, 245, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(232, 225, 215, 0.5);
        }

        .sahara-btn {
            background: var(--primary);
            color: #fff;
            transition: all 0.2s cubic-bezier(0.22, 1, 0.36, 1);
            box-shadow: 0 8px 24px -6px rgba(194,101,42,0.4);
        }
        .sahara-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px -8px rgba(194,101,42,0.5);
        }
        .sahara-btn:active {
            transform: scale(0.97);
        }
        
        .sahara-btn-outline {
            background: transparent;
            color: var(--primary);
            border: 1.5px solid var(--primary);
            transition: all 0.2s;
        }
        .sahara-btn-outline:hover {
            background: rgba(194,101,42,0.05);
        }

        .feature-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 4px 24px rgba(45,36,30,0.03);
            border: 1px solid rgba(232,225,215,0.6);
        }

        /* Abstract blobs */
        .blob {
            position: absolute;
            filter: blur(60px);
            z-index: 0;
            opacity: 0.4;
            pointer-events: none;
        }
    </style>
</head>
<body class="relative overflow-x-hidden min-h-screen flex flex-col">

    {{-- Decor Blobs --}}
    <div class="blob w-72 h-72 rounded-full top-[-100px] right-[-50px]" style="background: var(--primary); opacity: 0.15;"></div>
    <div class="blob w-96 h-96 rounded-full bottom-[10%] left-[-100px]" style="background: rgba(45,36,30,0.1);"></div>

    {{-- ==================== NAVBAR ==================== --}}
    <nav class="fixed top-0 w-full z-50 glass-nav transition-all duration-300 pointer-events-auto">
        <div class="max-w-5xl mx-auto px-6 py-4 flex items-center justify-between">
            
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 flex-shrink-0 flex items-center justify-center bg-black rounded-lg relative overflow-hidden">
                    <img src="{{ asset('image/logopks-removebg-preview.png') }}" alt="Logo" class="w-full h-full object-contain p-1 relative z-10" />
                </div>
                <div>
                    <h1 class="font-extrabold text-[16px] leading-tight text-[var(--on-s)] tracking-tight">Smart Parkir</h1>
                    <p class="text-[10px] font-bold tracking-widest text-[var(--on-v)] uppercase">SMKN 1 Kebumen</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('daftar') }}" class="sahara-btn px-5 py-2.5 rounded-xl font-extrabold text-[13px] tracking-wide uppercase">Daftar</a>
            </div>

        </div>
    </nav>

    {{-- ==================== HERO SECTION ==================== --}}
    <main class="flex-1 flex flex-col justify-center relative z-10 pt-28 pb-16 px-6">
        <div class="max-w-xl mx-auto text-center">
            
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full mb-6" style="background: rgba(194,101,42,0.1); border: 1px solid rgba(194,101,42,0.2);">
                <span class="material-icons-round text-[16px]" style="color: var(--primary);">verified_user</span>
                <span class="text-[12px] font-extrabold uppercase tracking-widest" style="color: var(--primary);">Sistem Keamanan Resmi</span>
            </div>

            <h2 class="display-font text-[40px] leading-[1.1] font-extrabold text-[var(--on-s)] mb-5 tracking-tight sm:text-[52px]">
                Parkir Lebih Cerdas, Aman & Terdata
            </h2>
            
            <p class="text-[15px] sm:text-[17px] font-medium leading-relaxed text-[var(--on-v)] mb-10 max-w-md mx-auto">
                Kelola kendaraan Anda di SMK N 1 Kebumen dengan sistem verifikasi zona GPS, tiket digital, dan pantauan area parkir secara real-time.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('login') }}" class="w-full sm:w-auto sahara-btn flex items-center justify-center gap-2 px-8 py-4 rounded-[16px] font-extrabold text-[15px] uppercase tracking-wide">
                    Login Aplikasi
                </a>
                <a href="#fitur" class="w-full sm:w-auto sahara-btn-outline flex items-center justify-center px-8 py-4 rounded-[16px] font-extrabold text-[15px] uppercase tracking-wide bg-white">
                    Selengkapnya
                </a>
            </div>

        </div>
    </main>

    {{-- ==================== YOUTUBE VIDEO GUIDE ==================== --}}
    <section class="relative z-10 px-6 pb-20 mt-4">
        <div class="max-w-3xl mx-auto text-center mb-8">
            <p class="text-[14px] font-bold tracking-widest text-[var(--primary)] uppercase mb-2">Panduan Interaktif</p>
            <h3 class="display-font text-[24px] font-extrabold text-[var(--on-s)]">Cara Menggunakan Aplikasi</h3>
        </div>
        
        <div class="max-w-3xl mx-auto relative rounded-[32px] p-2 shadow-2xl" style="background: linear-gradient(145deg, #e8e1d7, #fff); border: 1px solid rgba(255,255,255,0.7);">
            <div class="relative rounded-[24px] overflow-hidden bg-[#2b3437] aspect-video flex items-center justify-center group shadow-inner">
                
                {{-- Abstract pattern --}}
                <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"></div>
                
                {{-- Decorative background placeholder --}}
                <div class="absolute inset-0 bg-gradient-to-tr from-black/80 via-transparent to-black/40 group-hover:bg-black/20 transition-colors duration-500"></div>
                
                {{-- Play Button & Link --}}
                <a href="https://www.youtube.com" target="_blank" rel="noopener noreferrer" class="relative z-10 flex flex-col items-center justify-center transform transition-transform duration-300 group-hover:scale-110">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-red-600 flex items-center justify-center mb-4 shadow-[0_0_40px_rgba(220,38,38,0.6)] group-hover:bg-red-500 transition-colors">
                        <span class="material-icons-round text-white text-[36px] sm:text-[44px] ml-1 sm:ml-2">play_arrow</span>
                    </div>
                    <p class="text-white font-extrabold text-[14px] sm:text-[16px] tracking-wide uppercase drop-shadow-md">Tonton Video Panduan</p>
                </a>

            </div>
        </div>
    </section>

    {{-- ==================== HIGHLIGHT FEATURES ==================== --}}
    <section id="fitur" class="relative z-10 bg-white py-20 px-6 border-t border-[rgba(232,225,215,0.5)]">
        <div class="max-w-5xl mx-auto">
            
            <div class="text-center mb-14">
                <h3 class="display-font text-[28px] font-extrabold text-[var(--on-s)] mb-3">Inovasi Tanpa Batas</h3>
                <p class="text-[14px] font-medium text-[var(--on-v)] max-w-sm mx-auto">Dirancang untuk memudahkan mobilitas ribuan siswa secara instan & tanpa antrean keamanan panjang.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                {{-- Feature 1 --}}
                <div class="feature-card p-8">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6" style="background: rgba(194,101,42,0.1);">
                        <span class="material-icons-round text-[28px]" style="color: var(--primary);">radar</span>
                    </div>
                    <h4 class="font-extrabold text-[17px] text-[var(--on-s)] mb-2">Check-in Radius GPS</h4>
                    <p class="text-[13px] font-medium text-[var(--on-v)] line-clamp-3">
                        Katakan selamat tinggal pada antrean gerbang. Cukup ketuk untuk absen otomatis saat gawai Anda masuki radius terpadu.
                    </p>
                </div>

                {{-- Feature 2 --}}
                <div class="feature-card p-8">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6" style="background: rgba(26,176,118,0.1);">
                        <span class="material-icons-round text-[28px]" style="color: #1AB076;">qr_code_scanner</span>
                    </div>
                    <h4 class="font-extrabold text-[17px] text-[var(--on-s)] mb-2">Sistem Zonasi Khusus</h4>
                    <p class="text-[13px] font-medium text-[var(--on-v)] line-clamp-3">
                        Blok dan area diatur cerdas. Ketahui titik kendaraan Anda tanpa repot mencarinya secara manual saat jam pulang.
                    </p>
                </div>

                {{-- Feature 3 --}}
                <div class="feature-card p-8">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6" style="background: rgba(45,36,30,0.06);">
                        <span class="material-icons-round text-[28px]" style="color: var(--on-s);">inventory_2</span>
                    </div>
                    <h4 class="font-extrabold text-[17px] text-[var(--on-s)] mb-2">Pusat Lost & Found</h4>
                    <p class="text-[13px] font-medium text-[var(--on-v)] line-clamp-3">
                        Ada helm atau barang yang tertinggal di atas motor? Posko keamanan segera memublikasikannya ke beranda profil.
                    </p>
                </div>
            </div>

        </div>
    </section>

    {{-- ==================== FOOTER ==================== --}}
    <footer class="bg-[var(--surface)] border-t border-[rgba(232,225,215,0.7)] pb-4 pt-10 px-6">
        <div class="max-w-5xl mx-auto flex flex-col items-center text-center">
            <p class="text-[13px] font-extrabold text-[var(--on-v)] mb-1">PKS SMK NEGERI 1 KEBUMEN</p>
            <p class="text-[11px] font-medium text-[#abb3b7]">Platform Smart Parkir &copy; {{ date('Y') }}</p>
        </div>
    </footer>

</body>
</html>
