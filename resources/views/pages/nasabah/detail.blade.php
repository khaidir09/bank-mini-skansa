<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-[96rem] mx-auto">
        
        <div class="sm:flex sm:justify-between sm:items-center mb-5">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Detail Nasabah</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <button class="btn bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-800 dark:text-gray-300">
                    <svg class="fill-current shrink-0 xs:hidden" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"/>
                    </svg>
                    <span class="max-xs:sr-only">Edit Profil</span>
                </button>
                <!-- Add account button -->
                @if ($customer->account && $customer->account->status === 'Aktif')
                    <form action="{{ route('tutup-rekening', $customer->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn bg-red-500 hover:bg-red-600 text-white">
                            <svg class="fill-current shrink-0 xs:hidden" width="16" height="16" viewBox="0 0 16 16">
                                <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"/>
                            </svg>
                            <span class="max-xs:sr-only">Tutup Rekening</span>
                        </button>
                    </form>
                @else
                    <form action="{{ route('buka-rekening', $customer->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                            <svg class="fill-current shrink-0 xs:hidden" width="16" height="16" viewBox="0 0 16 16">
                                <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"/>
                            </svg>
                            <span class="max-xs:sr-only">Buka Rekening</span>
                        </button>
                    </form>
                @endif

            </div>

        </div>

        @if (session()->has('message'))
            <div x-show="open" x-data="{ open: true }" role="alert">
                <div class="px-4 py-2 rounded-lg text-sm bg-green-500 text-white mb-4">
                    <div class="flex w-full justify-between items-start">
                        <div class="flex">
                            <svg class="shrink-0 fill-current opacity-80 mt-[3px] mr-3" width="16" height="16" viewBox="0 0 16 16">
                                <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zM7 11.4L3.6 8 5 6.6l2 2 4-4L12.4 6 7 11.4z" />
                            </svg>
                            <div>{{ session('message') }}</div>
                        </div>
                        <button class="opacity-60 hover:opacity-70 ml-3 mt-[3px]" @click="open = false">
                            <div class="sr-only">Close</div>
                            <svg class="fill-current" width="16" height="16" viewBox="0 0 16 16">
                                <path d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif
        @if (session()->has('error'))
            <div x-show="open" x-data="{ open: true }" role="alert">
                <div class="px-4 py-2 rounded-lg text-sm bg-red-500 text-white mb-4">
                    <div class="flex w-full justify-between items-start">
                        <div class="flex">
                            <svg class="shrink-0 fill-current opacity-80 mt-[3px] mr-3" width="16" height="16" viewBox="0 0 16 16">
                                <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm3.5 10.1l-1.4 1.4L8 9.4l-2.1 2.1-1.4-1.4L6.6 8 4.5 5.9l1.4-1.4L8 6.6l2.1-2.1 1.4 1.4L9.4 8l2.1 2.1z" />
                            </svg>
                            <div class="font-medium">{{ session('error') }}</div>
                        </div>
                        <button class="opacity-60 hover:opacity-70 ml-3 mt-[3px]" @click="open = false">
                            <div class="sr-only">Close</div>
                            <svg class="fill-current" width="16" height="16" viewBox="0 0 16 16">
                                <path d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif
        
        <div class="grid grid-cols-12 gap-6">
            {{-- Informasi Nasabah --}}
            <div class="flex flex-col col-span-full xl:col-span-8 bg-white dark:bg-gray-800 shadow-xs rounded-xl">
                <div class="px-5 py-6">
                    <div class="text-sm font-semibold text-gray-800 dark:text-gray-100 mb-1">Profil</div>
                    <ul>
                        <li class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700/60">
                            <div class="text-sm">Nama Lengkap</div>
                            <div class="text-sm font-medium text-gray-800 dark:text-gray-100 ml-2">{{ $customer->name }}</div>
                        </li>
                        @if ($customer->kategori === 'Siswa')
                            <li class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700/60">
                                <div class="text-sm">NIS</div>
                                <div class="text-sm font-medium text-gray-800 dark:text-gray-100 ml-2">{{ $customer->nomor_induk }}</div>
                            </li>
                            <li class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700/60">
                                <div class="text-sm">Kelas</div>
                                <div class="text-sm font-medium text-gray-800 dark:text-gray-100 ml-2">{{ $customer->room->nama_kelas }}</div>
                            </li>
                            <li class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700/60">
                                <div class="text-sm">Tempat & Tanggal Lahir</div>
                                <div class="text-sm font-medium text-gray-800 dark:text-gray-100 ml-2">{{ $customer->birth_place }}, {{ $customer->birthday }}</div>
                            </li>
                            <li class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700/60">
                                <div class="text-sm">Orang Tua</div>
                                <div class="text-sm font-medium text-gray-800 dark:text-gray-100 ml-2">{{ $customer->parent }}</div>
                            </li>
                        @else
                            <li class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700/60">
                                <div class="text-sm">NIP</div>
                                <div class="text-sm font-medium text-gray-800 dark:text-gray-100 ml-2">{{ $customer->nomor_induk }}</div>
                            </li>
                            <li class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700/60">
                                <div class="text-sm">Jabatan</div>
                                <div class="text-sm font-medium text-gray-800 dark:text-gray-100 ml-2">{{ $customer->kategori }}</div>
                            </li>
                        @endif
                        <li class="flex items-center justify-between py-3 border-gray-200 dark:border-gray-700/60">
                            <div class="text-sm">Status</div>
                            <div class="flex items-center whitespace-nowrap">
                                <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div>
                                <div class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $customer->status }}</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            {{-- Informasi Rekening --}}
            <div class="flex flex-col col-span-full xl:col-span-4 bg-linear-[225deg,var(--color-gray-800),var(--color-gray-900)] shadow-xs rounded-xl">
                <header class="px-5 py-4 border-b border-gray-700/60 flex items-center">
                    <h2 class="font-semibold text-gray-200">Buku Tabungan</h2>
                </header>
                <div class="h-full flex flex-col px-5 py-6">
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
                                @if ($customer->account)
                                    @php
                                        $accountNumber = (string) $customer->account->nomor_rekening;
                                    @endphp
                                    <div class="flex justify-between text-lg font-bold text-gray-200 tracking-widest drop-shadow-md">
                                        <span>{{ substr($accountNumber, 0, 1) }}</span> <span>{{ substr($accountNumber, 1, 2) }}</span> <span>{{ substr($accountNumber, 3, 1) }}</span> <span>{{ substr($accountNumber, 4, 2) }}</span>
                                    </div>
                                @else
                                    <div class="flex justify-between text-lg font-bold text-gray-200 tracking-widest drop-shadow-md">
                                        <span>Belum memiliki buku tabungan</span>
                                    </div>
                                @endif
                                <!-- Card footer -->
                                <div class="relative flex justify-between items-center z-10 mb-0.5">
                                    @if ($customer->account)
                                        <div class="text-sm font-bold text-gray-200 tracking-widest drop-shadow-md space-x-3">
                                            <span>{{ $customer->name }}</span>
                                            <span>{{ $customer->room ? $customer->room->nama_kelas : $customer->kategori }}</span>
                                        </div>
                                    @endif
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
                    @if ($customer->account)
                        <div class="grow flex flex-col justify-center mt-3">
                            <div class="text-xs text-gray-500 font-semibold uppercase mb-3">Detail</div>
                            <div class="space-y-2">
                                <div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <div class="text-gray-300">Saldo</div>
                                        <div class="text-gray-400 italic">Rp. {{ number_format($customer->account->saldo) }}</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <div class="text-gray-300">Total Menabung Bulan Ini</div>
                                        <div class="text-gray-400 italic">Rp. 0</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <div class="text-gray-300">Total Menarik Bulan Ini</div>
                                        <div class="text-gray-400 italic">Rp. 0</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 mt-5">
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full dark:text-gray-300" @click.stop="$dispatch('set-transactionopen', true)">
                    <!-- Table header -->
                    <thead class="text-xs font-semibold uppercase text-gray-500 border-t border-b border-gray-200 dark:border-gray-700/60">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Tanggal</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Jenis</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-right">Jumlah</div>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60 border-b border-gray-200 dark:border-gray-700/60">
                        <!-- Row -->
                        @foreach($transactions as $transaction)
                            @php                    
                                if (substr($transaction->jumlah, 0, 1) === '+') :
                                    $amount_color = 'text-green-500';
                                else :
                                    $amount_color = 'text-gray-800 dark:text-gray-300';
                                endif;
                            @endphp                     
                            <tr>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left">{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left">{{ $transaction->jenis }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="text-right font-medium {{$amount_color}}">{{ $transaction->jumlah }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        
    </div>
</x-app-layout>