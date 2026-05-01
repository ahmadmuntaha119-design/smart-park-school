<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Park School | PKS SMKN 1 Kebumen</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        *, body { font-family: 'Manrope', sans-serif; -webkit-font-smoothing: antialiased; }

        .sahara-input {
            background: #faf8f5;
            border: 1.5px solid #e8e1d7;
            color: #2d241e;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .sahara-input::placeholder { color: #a89b91; }
        .sahara-input:focus {
            outline: none;
            background: #ffffff;
            border-color: #c2652a;
            box-shadow: 0 0 0 4px rgba(194, 101, 42, 0.12);
        }
        .sahara-btn {
            background-color: #c2652a;
            transition: background-color 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 14px rgba(194, 101, 42, 0.35);
        }
        .sahara-btn:hover { background-color: #a8551e; box-shadow: 0 6px 20px rgba(194, 101, 42, 0.45); }
        .sahara-btn:active { transform: scale(0.98); }

        /* Fade-in on load */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.45s ease both; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 lg:p-8" style="background-color: #faf8f5;">

    {{-- Decorative background blobs --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0" aria-hidden="true">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full opacity-40" style="background: radial-gradient(circle, rgba(194,101,42,0.18) 0%, transparent 70%);"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full opacity-30" style="background: radial-gradient(circle, rgba(194,101,42,0.14) 0%, transparent 70%);"></div>
    </div>

    {{-- Center Card --}}
    <div class="relative z-10 w-full max-w-md lg:max-w-lg fade-up">

        {{-- Logo Header above card --}}
        <div class="flex flex-col items-center mb-6">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-3 shadow-lg" style="background: linear-gradient(135deg, #c2652a, #e07840);">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h4a2 2 0 110 4H8m0 0v6m12-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-xs font-bold tracking-widest uppercase" style="color: #7a6b61;">Smart Park School</span>
            <span class="text-[11px] font-medium mt-0.5" style="color: #a89b91;">SMKN 1 Kebumen</span>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-3xl shadow-xl border p-8 lg:p-10" style="border-color: #e8e1d7;">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        <p class="text-center text-xs mt-6 font-medium" style="color: #a89b91;">
            &copy; {{ date('Y') }} PKS SMKN 1 Kebumen &mdash; Sistem Parkir Digital
        </p>
    </div>

</body>
</html>
