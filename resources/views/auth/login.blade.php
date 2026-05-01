<!DOCTYPE html>
<html lang="id" class="h-full bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Park School | Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img src="{{ asset('image/logopks-removebg-preview.png') }}" alt="Smart Park School" class="h-40 w-max mx-auto" />
            <h2 class="mt-4 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Selamat Datang</h2>
            <p class="mt-2 text-center text-sm text-gray-600">Masuk untuk mengakses portal parkir sekolah.</p>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            @if ($errors->any())
                <div class="mb-6 flex items-start gap-3 rounded-md p-4 bg-red-50 border border-red-200">
                    <span class="material-icons text-[20px] mt-0.5 text-red-600">error_outline</span>
                    <p class="text-sm font-semibold text-red-800">{{ $errors->first() }}</p>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="nis_nip" class="block text-sm/6 font-medium text-gray-900">Nomor Induk Siswa (NIS)</label>
                    <div class="mt-2">
                        <input id="nis_nip" type="text" name="nis_nip" value="{{ old('nis_nip') }}" required autocomplete="one-time-code" placeholder="Contoh: 17460" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-yellow-600 sm:text-sm/6" />
                    </div>
                </div>

                <div x-data="{ show: false }">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Kata Sandi</label>
                    </div>
                    <div class="mt-2 relative">
                        <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="••••••••" class="block w-full rounded-md bg-white px-3 py-1.5 pr-10 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2  focus:outline-yellow-600 sm:text-sm/6" />
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-yellow-600 hover:text-yellow-600">
                        </button>
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-yellow-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-yellow-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-600">Masuk ke Sistem</button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Belum punya akun?
                <a href="/daftar" class="font-semibold text-yellow-600 hover:text-yellow-500">Registrasi Mandiri</a>
            </p>
        </div>
    </div>
</body>
</html>
