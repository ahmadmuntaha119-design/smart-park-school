<!DOCTYPE html>
<html lang="id" class="h-full bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Park School | Ganti Kata Sandi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">

        {{-- Header --}}
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img src="{{ asset('image/logopks-removebg-preview.png') }}" alt="Smart Park School" class="h-40 w-max mx-auto" />
            <h2 class="mt-4 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Buat Kata Sandi Baru</h2>
            <p class="mt-2 text-center text-sm text-gray-600">Ini login pertama Anda. Harap segera ganti kata sandi default.</p>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

            {{-- Warning --}}
            @if (session('warning'))
                <div class="mb-6 flex items-start gap-3 rounded-md p-4 bg-yellow-50 border border-yellow-200">
                    <span class="material-icons text-[20px] mt-0.5 text-yellow-600">warning_amber</span>
                    <p class="text-sm text-yellow-800">{{ session('warning') }}</p>
                </div>
            @endif

            {{-- Error --}}
            @if ($errors->any())
                <div class="mb-6 flex items-start gap-3 rounded-md p-4 bg-red-50 border border-red-200">
                    <span class="material-icons text-[20px] mt-0.5 text-red-600">error_outline</span>
                    <p class="text-sm font-semibold text-red-800">{{ $errors->first() }}</p>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('password.change.process') }}" method="POST" class="space-y-6"
                  x-data="{
                      showNew: false,
                      showConfirm: false,
                      password: '',
                      confirmPw: '',
                      get match() { return this.confirmPw.length > 0 && this.password === this.confirmPw; },
                      get mismatch() { return this.confirmPw.length > 0 && this.password !== this.confirmPw; }
                  }">
                @csrf

                {{-- Kata Sandi Baru --}}
                <div>
                    <label for="password_baru" class="block text-sm/6 font-medium text-gray-900">Kata Sandi Baru</label>
                    <div class="mt-2 relative">
                        <input
                            id="password_baru"
                            name="password_baru"
                            :type="showNew ? 'text' : 'password'"
                            x-model="password"
                            required autofocus
                            placeholder="Minimal 6 karakter"
                            class="block w-full rounded-md bg-white px-3 py-1.5 pr-10 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-yellow-600 sm:text-sm/6">
                        <button type="button" @click="showNew = !showNew"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-yellow-600 hover:text-yellow-600">
                            <span class="material-icons text-[20px]" x-text="showNew ? 'visibility' : 'visibility_off'"></span>
                        </button>
                    </div>
                </div>

                {{-- Konfirmasi Kata Sandi --}}
                <div>
                    <label for="password_baru_confirmation" class="block text-sm/6 font-medium text-gray-900">Ulangi Kata Sandi Baru</label>
                    <div class="mt-2 relative">
                        <input
                            id="password_baru_confirmation"
                            name="password_baru_confirmation"
                            :type="showConfirm ? 'text' : 'password'"
                            x-model="confirmPw"
                            required
                            placeholder="Ketik ulang kata sandi baru"
                            :class="mismatch ? 'outline-red-400 focus:outline-red-500' : (match ? 'outline-green-400 focus:outline-green-500' : 'outline-gray-300 focus:outline-yellow-600')"
                            class="block w-full rounded-md bg-white px-3 py-1.5 pr-10 text-base text-gray-900 outline-1 -outline-offset-1 placeholder:text-gray-400 focus:outline-2 sm:text-sm/6">
                        <button type="button" @click="showConfirm = !showConfirm"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-yellow-600 hover:text-yellow-600">
                            <span class="material-icons text-[20px]" x-text="showConfirm ? 'visibility' : 'visibility_off'"></span>
                        </button>
                    </div>
                    {{-- Match hint --}}
                    <p x-show="match" x-transition class="mt-1.5 text-xs text-green-600 flex items-center gap-1">
                        <span class="material-icons text-[14px]">check_circle</span> Kata sandi cocok
                    </p>
                    <p x-show="mismatch" x-transition class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <span class="material-icons text-[14px]">cancel</span> Kata sandi tidak cocok
                    </p>
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-yellow-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-yellow-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-600">
                        Simpan Kata Sandi
                    </button>
                </div>
            </form>

        </div>
    </div>
</body>
</html>
