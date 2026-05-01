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
        *, body { font-family: 'Manrope', sans-serif; -webkit-font-smoothing: antialiased; }

        /* Sahara Sidebar Active */
        .nav-item {
            display: flex; align-items: center; padding: 10px 14px;
            border-radius: 12px; font-weight: 600; font-size: 0.875rem;
            transition: all 0.18s;  color: #7a6b61; gap: 10px;
            border: 1.5px solid transparent;
        }
        .nav-item:hover {
            background: rgba(194,101,42,0.08);
            color: #c2652a;
            border-color: rgba(194,101,42,0.18);
        }
        .nav-item.active {
            background: rgba(194,101,42,0.10);
            color: #c2652a;
            border-color: rgba(194,101,42,0.22);
            font-weight: 700;
        }
        .nav-item-danger { color: #dc2626; }
        .nav-item-danger:hover { background: #fee2e2; border-color: #fca5a5; color: #b91c1c; }

        /* Sahara scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #faf8f5; }
        ::-webkit-scrollbar-thumb { background: #e8e1d7; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #c2652a; }
    </style>
</head>
<body class="antialiased overflow-hidden" style="background: #faf8f5;" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen w-full">

        <!-- ===================== SIDEBAR ===================== -->
        <aside class="flex flex-col w-64 h-full px-4 py-6 bg-white border-r -translate-x-full lg:translate-x-0 absolute lg:relative z-20 transition-transform duration-300 ease-in-out shadow-xl lg:shadow-none"
               style="border-color: #e8e1d7;"
               :class="{'translate-x-0': sidebarOpen}">

            <!-- Logo -->
            <div class="flex items-center gap-3 px-2 mb-8">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md"
                     style="background: linear-gradient(135deg, #c2652a, #e07840);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h4a2 2 0 110 4H8m0 0v6m12-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-extrabold leading-tight" style="color: #2d241e;">PKS Panel</h2>
                    <p class="text-[11px] font-medium" style="color: #a89b91;">SMKN 1 Kebumen</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex flex-col flex-1 gap-1">
                <p class="text-[10px] font-bold uppercase tracking-widest px-2 mb-1" style="color: #a89b91;">Menu Utama</p>

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

                <div class="my-2 border-t" style="border-color: #f0ebe4;"></div>
                <p class="text-[10px] font-bold uppercase tracking-widest px-2 mb-1" style="color: #a89b91;">Manajemen</p>

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
            <div class="mt-4 pt-4 border-t" style="border-color: #f0ebe4;">
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
            <header class="flex items-center justify-between px-4 sm:px-6 py-4 bg-white border-b sticky top-0 z-10" style="border-color: #e8e1d7;">
                <div class="flex items-center gap-3">
                    <!-- Hamburger (mobile) -->
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden p-2 rounded-xl transition-colors"
                            style="color: #7a6b61;"
                            onmouseenter="this.style.background='rgba(194,101,42,0.08)'"
                            onmouseleave="this.style.background='transparent'">
                        <span class="material-icons text-[22px]">menu</span>
                    </button>
                    <div>
                        <h1 class="text-lg sm:text-xl font-extrabold leading-tight" style="color: #2d241e;">{{ $title ?? 'Dashboard' }}</h1>
                        <p class="text-xs font-medium hidden sm:block" style="color: #a89b91;">
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }} · WIB
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="hidden sm:inline-block text-xs font-bold px-3 py-1.5 rounded-full border"
                          style="color: #c2652a; background: rgba(194,101,42,0.08); border-color: rgba(194,101,42,0.2);">
                        Admin PKS
                    </span>
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-sm shadow"
                         style="background: linear-gradient(135deg, #c2652a, #e07840);">
                        A
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-6 lg:p-8" style="background: #faf8f5;">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
