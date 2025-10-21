<x-authentication-layout>
    <h1 class="text-3xl text-gray-800 dark:text-gray-100 font-bold mb-6">Selamat Datang di Bank Mini SMK Negeri 1 Amuntai</h1>
    <p class="mb-6">Silakan Login untuk Cek Saldo & Riwayat Transaksi Anda</p>
    <!-- Form -->
    <form method="POST" action="{{ route('nasabah.login.post') }}">
        @csrf
        <div class="space-y-4">
            <div>
                <x-label for="nomor_induk">{{ __('Nomor Induk') }}</x-label>
                <x-input id="nomor_induk" type="text" name="nomor_induk" :value="old('nomor_induk')" required autofocus />
            </div>
            <div>
                <x-label for="pin">{{ __('PIN') }}</x-label>
                <x-input id="pin" type="password" name="pin" required autocomplete="current-password" />
            </div>
        </div>
        <div class="flex items-center justify-between mt-6">
            <x-button class="w-full">
                {{ __('Masuk') }}
            </x-button>
        </div>
    </form>
    <x-validation-errors class="mt-4" />
    <div class="pt-5 mt-6 border-t border-gray-100 dark:border-gray-700/60">
        <div class="text-sm">
            Admin Bank Mini? <a class="font-medium text-violet-500 hover:text-violet-600 dark:hover:text-violet-400" href="{{ route('login') }}">Login</a>
        </div>
        <!-- Warning -->
        <div class="mt-5">
            <div class="bg-yellow-500/20 text-yellow-700 px-3 py-2 rounded-lg">
                <svg class="inline w-3 h-3 shrink-0 fill-current" viewBox="0 0 12 12">
                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                </svg>
                <span class="text-sm">
                    Gunakan PC ini hanya untuk cek saldo. Pastikan Anda KELUAR setelah selesai.
                </span>
            </div>
        </div>
    </div>
</x-authentication-layout>
