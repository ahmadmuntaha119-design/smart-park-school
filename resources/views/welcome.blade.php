<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Smart Parkir – SMKN 1 Kebumen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Menggunakan Inter untuk tampilan clean dan Manrope untuk Heading yang tegas --}}
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #000000;
            color: #ffffff;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, .display-font {
            font-family: 'Manrope', sans-serif;
            letter-spacing: -0.02em;
        }

        /* Glassmorphism Navbar ala iOS */
        .glass-nav {
            background: rgba(10, 10, 10, 0.65);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Tombol Utama iOS Style */
        .btn-primary {
            background: #ffffff;
            color: #000000;
            transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }
        .btn-primary:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.2);
            background: #f4f4f5;
        }
        .btn-primary:active {
            transform: scale(0.97);
        }

        /* Tombol Sekunder/Outline */
        .btn-outline {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
        }

        /* Bento Box Container */
        .bento-card {
            background: #121212;
            border-radius: 32px;
            border: 1px solid rgba(255, 255, 255, 0.06);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
            overflow: hidden;
            position: relative;
        }
        .bento-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            border-color: rgba(255, 255, 255, 0.12);
        }
        
        /* Subtle Glow / Ambient Light */
        .ambient-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255,255,255,0.04) 0%, rgba(0,0,0,0) 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            z-index: 0;
        }
    </style>
</head>
<body class="relative overflow-x-hidden min-h-screen flex flex-col selection:bg-white/20 selection:text-white">

    {{-- Latar Belakang --}}
    <div class="fixed inset-0 bg-black z-[-2]"></div>
    {{-- Grid Halus di Latar Belakang --}}
    <div class="fixed inset-0 opacity-[0.03] z-[-1]" style="background-image: linear-gradient(rgba(255,255,255,1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,1) 1px, transparent 1px); background-size: 40px 40px;"></div>

    {{-- ==================== NAVBAR ==================== --}}
    <nav class="fixed top-0 w-full z-50 glass-nav pointer-events-auto">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 flex-shrink-0 flex items-center justify-center bg-white/5 border border-white/10 rounded-xl relative overflow-hidden backdrop-blur-md">
                    <img src="{{ asset('image/logopks-removebg-preview.png') }}" alt="Logo" class="w-full h-full object-contain p-1.5 relative z-10 brightness-0 invert opacity-90" />
                </div>
                <div>
                    <h1 class="font-extrabold text-[15px] leading-tight text-white tracking-tight">Smart Parkir</h1>
                    <p class="text-[10px] font-bold tracking-widest text-zinc-500 uppercase">SMKN 1 Kebumen</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('daftar') }}" class="btn-primary px-5 py-2 rounded-full font-extrabold text-[12px] tracking-wide uppercase">Daftar</a>
            </div>

        </div>
    </nav>

    {{-- ==================== HERO SECTION ==================== --}}
    <main class="flex-1 flex flex-col justify-center relative z-10 pt-40 pb-20 px-6">
        <div class="ambient-glow top-[30%]"></div>
        <div class="max-w-4xl mx-auto text-center relative z-10">
            
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full mb-8 bg-white/5 border border-white/10 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)] animate-pulse"></span>
                <span class="text-[11px] font-extrabold uppercase tracking-widest text-zinc-300">Sistem Keamanan Resmi</span>
            </div>

            <h2 class="display-font text-[48px] sm:text-[72px] leading-[1.05] font-extrabold text-white mb-6 tracking-tight">
                Sistem Parkir Terpadu.<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-zinc-300 via-white to-zinc-500">Aman. Instan.</span>
            </h2>
            
            <p class="text-[16px] sm:text-[18px] font-medium leading-relaxed text-zinc-400 mb-12 max-w-xl mx-auto">
                Infrastruktur parkir generasi baru untuk SMKN 1 Kebumen. Verifikasi zona GPS, kartu digital, dan visibilitas waktu nyata tanpa hambatan gerbang.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('login') }}" class="w-full sm:w-auto btn-primary flex items-center justify-center gap-2 px-8 py-4 rounded-full font-extrabold text-[14px] uppercase tracking-wider">
                    Buka Aplikasi
                    <span class="material-icons-round text-[18px]">arrow_forward</span>
                </a>
                <a href="#fitur" class="w-full sm:w-auto btn-outline flex items-center justify-center px-8 py-4 rounded-full font-extrabold text-[14px] uppercase tracking-wider">
                    Lihat Fitur
                </a>
            </div>

        </div>
    </main>

    {{-- ==================== VIDEO BENTO ==================== --}}
    <section class="relative z-10 px-6 pb-20">
        <div class="max-w-5xl mx-auto">
            <div class="bento-card aspect-video w-full flex items-center justify-center group cursor-pointer relative">
                {{-- Decorative mesh gradient background inside video card --}}
                <div class="absolute inset-0 bg-gradient-to-tr from-zinc-900 to-zinc-800 opacity-50"></div>
                
                {{-- Play Button --}}
                <a href="https://www.youtube.com" target="_blank" rel="noopener noreferrer" class="relative z-10 flex flex-col items-center justify-center transform transition-transform duration-500 group-hover:scale-110">
                    <>
                </a>


                <div class="absolute bottom-6 left-8">
                    <p class="text-zinc-500 font-medium text-[12px] uppercase tracking-widest">Tutorial 01</p>
                    <p class="text-white font-bold text-[18px]">Cara Penggunaan Digital Pass</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== BENTO BOX FEATURES ==================== --}}
    <section id="fitur" class="relative z-10 py-24 px-6 border-t border-white/5">
        <div class="max-w-6xl mx-auto">
            
            <div class="mb-16">
                <h3 class="display-font text-[36px] font-extrabold text-white mb-4">Arsitektur Cerdas</h3>
                <p class="text-[16px] text-zinc-400 max-w-xl leading-relaxed">Sistem parkir yang didesain secara modular untuk menghilangkan hambatan fisik, meningkatkan keamanan, dan memodernisasi infrastruktur sekolah.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Feature 1: Large Span --}}
                <div class="bento-card p-10 md:col-span-2 relative overflow-hidden group">
                    <div class="absolute right-0 top-0 w-64 h-64 bg-white/5 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3 group-hover:bg-white/10 transition-colors duration-700"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6 bg-white/10 border border-white/10 backdrop-blur-md">
                            <span class="material-icons-round text-[28px] text-white">satellite_alt</span>
                        </div>
                        <h4 class="font-extrabold text-[24px] text-white mb-3 tracking-tight">Geofencing Real-Time</h4>
                        <p class="text-[15px] font-medium text-zinc-400 max-w-md leading-relaxed">
                            Absensi otomatis tanpa memicu kerumunan gerbang. Algoritma berbasis lokasi kami memverifikasi presensi seketika saat Anda memasuki area teritorial sekolah.
                        </p>
                    </div>
                </div>

                {{-- Feature 2: Small Box --}}
                <div class="bento-card p-10 relative overflow-hidden group">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center mb-6 bg-white/5 border border-white/10">
                        <span class="material-icons-round text-[24px] text-white">grid_view</span>
                    </div>
                    <h4 class="font-extrabold text-[20px] text-white mb-3 tracking-tight">Zonasi Dinamis</h4>
                    <p class="text-[14px] font-medium text-zinc-400 leading-relaxed">
                        Distribusi blok parkir berbasis data. Anda akan selalu mengetahui secara pasti posisi kendaraan Anda melalui antarmuka visual yang terintegrasi.
                    </p>
                </div>

                {{-- Feature 3: Small Box --}}
                <div class="bento-card p-10 relative overflow-hidden group">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center mb-6 bg-white/5 border border-white/10">
                        <span class="material-icons-round text-[24px] text-white">fact_check</span>
                    </div>
                    <h4 class="font-extrabold text-[20px] text-white mb-3 tracking-tight">Regulasi Otomatis</h4>
                    <p class="text-[14px] font-medium text-zinc-400 leading-relaxed">
                        Mesin validasi aturan terpadu menertibkan distribusi tipe transmisi dan marka kendaraan agar selaras dengan ketertiban lingkungan akademik.
                    </p>
                </div>

                {{-- Feature 4: Large Span --}}
                <div class="bento-card p-10 md:col-span-2 relative overflow-hidden group flex flex-col justify-end min-h-[280px]">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent z-10"></div>
                    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center opacity-20 grayscale mix-blend-overlay group-hover:opacity-30 group-hover:scale-105 transition-all duration-700"></div>
                    
                    <div class="relative z-20">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4 bg-white/20 backdrop-blur-md border border-white/30">
                            <span class="material-icons-round text-[24px] text-white">shield</span>
                        </div>
                        <h4 class="font-extrabold text-[24px] text-white mb-2 tracking-tight">Digital Pass Keamanan</h4>
                        <p class="text-[15px] font-medium text-zinc-300 max-w-lg leading-relaxed">
                            Akses masuk menggunakan tiket terenkripsi yang diikat pada ID spesifik Anda. Pos keamanan memiliki kendali absolut atas validitas mobilitas lingkungan.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ==================== FOOTER ==================== --}}
    <footer class="bg-[#050505] border-t border-white/10 py-12 px-6 mt-10 relative z-10">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            
            <div class="flex items-center gap-4">
                <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center border border-white/5">
                    <img src="{{ asset('image/logopks-removebg-preview.png') }}" alt="Logo" class="w-full h-full object-contain p-1 brightness-0 invert opacity-60" />
                </div>
                <div>
                    <p class="text-[14px] font-bold text-zinc-300">ParkirPintar</p>
                    <p class="text-[11px] font-medium text-zinc-600">SMK Negeri 1 Kebumen</p>
                </div>
            </div>

            <div class="flex items-center gap-6 text-[12px] font-medium text-zinc-500">
                <a href="#" class="hover:text-white transition-colors">Tentang Sistem</a>
                <a href="#" class="hover:text-white transition-colors">Pusat Bantuan</a>
                <a href="#" class="hover:text-white transition-colors">Privasi</a>
            </div>
            
            <p class="text-[11px] font-medium text-zinc-600">&copy; {{ date('Y') }} Sistem Parkir Terpadu.</p>
        </div>
    </footer>

</body>
</html>
