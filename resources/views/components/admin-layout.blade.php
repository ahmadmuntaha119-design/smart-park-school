<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin PKS | Smart Park' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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

        *, body { font-family: 'Manrope', sans-serif; -webkit-font-smoothing: antialiased; }

        /* Dark Bento Sidebar Active */
        .nav-item {
            display: flex; align-items: center; padding: 10px 14px;
            border-radius: 12px; font-weight: 600; font-size: 0.875rem;
            transition: all 0.18s;  color: var(--on-v); gap: 10px;
            border: 1px solid transparent;
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.05);
            color: var(--on-s);
            border-color: rgba(255,255,255,0.1);
        }
        .nav-item.active {
            background: rgba(255,255,255,0.1);
            color: var(--on-s);
            border-color: rgba(255,255,255,0.2);
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0,0,0,0.5);
        }
        .nav-item-danger { color: #ef4444; }
        .nav-item-danger:hover { background: rgba(239,68,68,0.1); border-color: rgba(239,68,68,0.2); color: #f87171; }

        /* Scrollbar Dark Theme */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--surface); }
        ::-webkit-scrollbar-thumb { background: #3f3f46; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #52525b; }
    </style>
</head>
<body class="antialiased overflow-hidden text-white" style="background: var(--surface);" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen w-full">

        <!-- ===================== SIDEBAR ===================== -->
        <aside class="flex flex-col w-64 h-full px-4 py-6 border-r -translate-x-full lg:translate-x-0 absolute lg:relative z-20 transition-transform duration-300 ease-in-out shadow-xl lg:shadow-none"
               style="background: var(--sl2); border-color: var(--outline-v);"
               :class="{'translate-x-0': sidebarOpen}">

            <!-- Logo -->
            <div class="flex items-center gap-3 px-2 mb-8">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md border border-white/10"
                     style="background: rgba(255,255,255,0.05);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h4a2 2 0 110 4H8m0 0v6m12-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-extrabold leading-tight" style="color: var(--on-s);">PKS Panel</h2>
                    <p class="text-[11px] font-medium" style="color: var(--on-v);">SMKN 1 Kebumen</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex flex-col flex-1 gap-1">
                <p class="text-[10px] font-bold uppercase tracking-widest px-2 mb-1" style="color: var(--on-v);">Menu Utama</p>

                <a href="{{ route('admin.dashboard') }}"
                   class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="material-icons text-[20px]">dashboard</span>
                    Dashboard
                </a>

                <a href="{{ route('admin.whitelist.index') }}"
                   class="nav-item {{ request()->routeIs('admin.whitelist.*') ? 'active' : '' }}">
                    <span class="material-icons text-[20px]">assignment</span>
                    Import Data
                </a>

                <a href="{{ route('admin.zona.index') }}"
                   class="nav-item {{ request()->routeIs('admin.zona.*') ? 'active' : '' }}">
                    <span class="material-icons text-[20px]">place</span>
                    Zona Parkir
                </a>

                <a href="{{ route('admin.kendaraan.index') }}"
                   class="nav-item {{ request()->routeIs('admin.kendaraan.*') ? 'active' : '' }}">
                    <span class="material-icons text-[20px]">two_wheeler</span>
                    Data Kendaraan
                </a>

                <div class="my-2 border-t" style="border-color: var(--outline-v);"></div>
                <p class="text-[10px] font-bold uppercase tracking-widest px-2 mb-1" style="color: var(--on-v);">Manajemen</p>

                <a href="{{ route('admin.lost-found.index') }}"
                   class="nav-item {{ request()->routeIs('admin.lost-found.*') ? 'active' : '' }}">
                    <span class="material-icons text-[20px]">notifications_active</span>
                    Penyiaran Kehilangan
                </a>

                <a href="{{ route('admin.absensi.index') }}"
                   class="nav-item {{ request()->routeIs('admin.absensi.*') ? 'active' : '' }}">
                    <span class="material-icons text-[20px]">how_to_reg</span>
                    Jurnal Absensi
                </a>
            </nav>

            <!-- Logout -->
            <div class="mt-4 pt-4 border-t" style="border-color: var(--outline-v);">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-item nav-item-danger w-full justify-center font-bold text-xs tracking-widest uppercase">
                        <span class="material-icons text-[18px]">logout</span>
                        Keluar Sistem
                    </button>
                </form>
            </div>
        </aside>

        <!-- Backdrop for mobile sidebar -->
        <div class="fixed inset-0 bg-black/30 backdrop-blur-sm z-10 lg:hidden"
             x-show="sidebarOpen" @click="sidebarOpen = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;"></div>

        <!-- ===================== MAIN CONTENT ===================== -->
        <div class="flex-1 flex flex-col h-full overflow-hidden">

            <!-- Top Header -->
            <header class="flex items-center justify-between px-4 sm:px-6 py-4 border-b sticky top-0 z-10" style="background: rgba(0,0,0,0.8); backdrop-filter: blur(24px); border-color: var(--outline-v);">
                <div class="flex items-center gap-3">
                    <!-- Hamburger (mobile) -->
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden p-2 rounded-xl transition-colors"
                            style="color: var(--on-v);"
                            onmouseenter="this.style.background='rgba(255,255,255,0.05)'"
                            onmouseleave="this.style.background='transparent'">
                        <span class="material-icons text-[22px]">menu</span>
                    </button>
                    <div>
                        <h1 class="text-lg sm:text-xl font-extrabold leading-tight" style="color: var(--on-s);">{{ $title ?? 'Dashboard' }}</h1>
                        <p class="text-xs font-medium hidden sm:block" style="color: var(--on-v);">
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }} · WIB
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="hidden sm:inline-block text-xs font-bold px-3 py-1.5 rounded-full border border-white/10"
                          style="color: var(--on-s); background: rgba(255,255,255,0.05);">
                        Admin PKS
                    </span>
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-black font-bold text-sm shadow"
                         style="background: #ffffff;">
                        A
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-6 lg:p-8" style="background: var(--surface);">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
