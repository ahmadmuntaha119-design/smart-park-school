<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Park School | SMKN 1 Kebumen</title>
    
    <!-- Memanggil CSS dan JS yang sudah di-compile oleh Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">
    
    <!-- Bagian Header (Nanti bisa diganti dinamis) -->
    <header class="bg-blue-600 shadow-md">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <h1 class="text-white text-2xl font-bold">
                Smart Park School
            </h1>
        </div>
    </header>

    <!-- Konten Utama (Berubah-ubah sesuai halaman) -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>

    <!-- Notifikasi Livewire (Nanti digunakan) -->
    @livewireScripts
</body>
</html>
