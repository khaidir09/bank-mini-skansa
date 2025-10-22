<x-guest-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-[96rem] mx-auto">

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Selamat Datang, {{ $customer->name }}!</h1>
                <p>Berikut adalah informasi tabungan Anda.</p>
            </div>
            <div class="flex space-x-3">
                <a href="" class="btn bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-800 dark:text-gray-300">
                    <svg class="fill-current shrink-0 xs:hidden" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"/>
                    </svg>
                    <span class="max-xs:sr-only">Edit Profil</span>
                </a>
                <form action="{{ route('nasabah.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150">
                        Keluar
                    </button>
                </form>
            </div>
        </div>

        <!-- Welcome banner -->
        <div class="relative bg-gray-900 p-4 sm:p-6 rounded-xl overflow-hidden mb-8">
            <div class="h-full flex flex-col">
                <!-- CC container -->
                <div class="relative w-full max-w-sm mx-auto bg-gray-700/50 p-2.5 rounded-2xl">
                    <!-- Credit Card -->
                    <div class="relative aspect-7/4 bg-linear-to-tr from-gray-900 to-gray-800 p-5 rounded-xl overflow-hidden">
                        <div class="relative h-full flex flex-col justify-between">
                            <!-- Logo on card -->
                            <svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <defs>
                                    <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="icon1-b">
                                        <stop stop-color="#B7ACFF" offset="0%" />
                                        <stop stop-color="#E6E1FF" offset="100%" />
                                    </linearGradient>
                                    <linearGradient x1="50%" y1="24.537%" x2="50%" y2="100%" id="icon1-c">
                                        <stop stop-color="#4634B1" offset="0%" />
                                        <stop stop-color="#4634B1" stop-opacity="0" offset="100%" />
                                    </linearGradient>
                                    <path id="icon1-a" d="M16 0l16 32-16-5-16 5z" />
                                </defs>
                                <g transform="rotate(90 16 16)" fill="none" fill-rule="evenodd">
                                    <mask id="icon1-d" fill="#fff">
                                        <use xlink:href="#icon1-a" />
                                    </mask>
                                    <use fill="url(#icon1-b)" xlink:href="#icon1-a" />
                                    <path fill="url(#icon1-c)" mask="url(#icon1-d)" d="M16-6h20v38H16z" />
                                </g>
                            </svg>
                            <!-- Card number -->
                            @php
                                $accountNumber = (string) $account->nomor_rekening;
                            @endphp
                            <div class="flex justify-between text-lg font-bold text-gray-200 tracking-widest drop-shadow-md">
                                <span>{{ substr($accountNumber, 0, 1) }}</span> <span>{{ substr($accountNumber, 1, 2) }}</span> <span>{{ substr($accountNumber, 3, 1) }}</span> <span>{{ substr($accountNumber, 4, 2) }}</span>
                            </div>
                            <!-- Card footer -->
                            <div class="relative flex justify-between items-center z-10 mb-0.5">
                                <div class="text-sm font-bold text-gray-200 tracking-widest drop-shadow-md space-x-3">
                                    <span>{{ $account->customer->name }}</span>
                                    <span>{{ $account->customer->room ? $account->customer->room->nama_kelas : $account->customer->kategori }}</span>
                                </div>
                            </div>
                            <!-- Mastercard logo -->
                            <svg class="absolute bottom-0 right-0" width="48" height="28" viewBox="0 0 48 28">
                                <circle fill="#F0BB33" cx="34" cy="14" r="14" fill-opacity=".8" />
                                <circle fill="#FF5656" cx="14" cy="14" r="14" fill-opacity=".8" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Details -->
                <div class="grow flex flex-col justify-center mt-3">
                    <div class="text-xs text-gray-500 font-semibold uppercase mb-3">Detail</div>
                    <div class="space-y-2">
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <div class="text-gray-300">Saldo</div>
                                <div class="text-gray-400 italic">Rp. {{ number_format($account->saldo) }}</div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <div class="text-gray-300">Total Menabung Bulan Ini</div>
                                <div class="text-gray-400 italic">Rp. {{ number_format($menabung) }}</div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <div class="text-gray-300">Total Menarik Bulan Ini</div>
                                <div class="text-gray-400 italic">Rp. {{ number_format($menarik) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard content -->
        <!-- Riwayat Transaksi -->
        <div class="col-span-full bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700">
            <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                <h2 class="font-semibold text-gray-800 dark:text-gray-100">Riwayat Transaksi</h2>
            </header>
            <div class="p-3">

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <!-- Table header -->
                        <thead class="text-xs font-semibold uppercase text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-700 dark:bg-opacity-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Tanggal</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Jenis Transaksi</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Jumlah</div>
                                </th>
                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($transactions as $transaction)
                            @php
                                if ($transaction->jenis === 'Setor') {
                                    $amount_color = 'text-green-500';
                                } else {
                                    $amount_color = 'text-red-500';
                                }
                            @endphp
                                <tr>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-left">{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-left font-medium">{{ $transaction->jenis }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap w-px">
                                        <div class="text-end font-medium {{ $amount_color }}">Rp. {{ number_format($transaction->jumlah) }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-2 text-center text-gray-500">
                                        Belum ada riwayat transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</x-guest-layout>
