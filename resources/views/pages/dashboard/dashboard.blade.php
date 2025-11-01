<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-[96rem] mx-auto">

        <!-- Dashboard actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Dashboard</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Filter button -->
                {{-- <x-dropdown-filter align="right" /> --}}

                <!-- Datepicker built with flatpickr -->
                {{-- <x-datepicker /> --}}

                <!-- Add view button -->
                {{-- <button class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                    <svg class="fill-current shrink-0 xs:hidden" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="max-xs:sr-only">Add View</span>
                </button> --}}
                
            </div>

        </div>
        
        <!-- Cards -->
        <div class="grid grid-cols-12 gap-6">

            <!-- Line chart (Acme Plus) -->
            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-gray-800 shadow-xs rounded-xl">
                <div class="px-5 py-5">
                    <header class="flex justify-between items-start mb-2">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Total Saldo Seluruh Nasabah</h2>
                        <!-- Menu button -->
                        <div class="relative inline-flex">
                            <a class="text-sm font-medium text-violet-500 hover:text-violet-600 dark:hover:text-violet-400" href="{{ route('nasabah.index') }}">-&gt;</a>
                        </div>
                    </header>
                    <div class="flex items-start">
                        <div class="text-3xl font-bold text-gray-800 dark:text-gray-100 mr-2">{{ number_format($totalSaldo) }}</div>
                    </div>
                    <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase mb-1">Rupiah</div>
                </div>
            </div>

            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-gray-800 shadow-xs rounded-xl">
                <div class="px-5 py-5">
                    <header class="flex justify-between items-start mb-2">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Jumlah Nasabah Aktif</h2>
                        <!-- Menu button -->
                        <div class="relative inline-flex">
                            <a class="text-sm font-medium text-violet-500 hover:text-violet-600 dark:hover:text-violet-400" href="{{ route('nasabah.index') }}">-&gt;</a>
                        </div>
                    </header>
                    <div class="flex items-start">
                        <div class="text-3xl font-bold text-gray-800 dark:text-gray-100 mr-2">{{ $totalNasabah }}</div>
                    </div>
                    <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase mb-1">Orang</div>
                </div>
            </div>
            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-gray-800 shadow-xs rounded-xl">
                <div class="px-5 py-5">
                    <header class="flex justify-between items-start mb-2">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Transaksi Hari Ini</h2>
                        <!-- Menu button -->
                        <div class="relative inline-flex">
                            <a class="text-sm font-medium text-violet-500 hover:text-violet-600 dark:hover:text-violet-400" href="{{ route('transaksi.index') }}">-&gt;</a>
                        </div>
                    </header>
                    <div class="flex items-start">
                        <div class="text-3xl font-bold text-gray-800 dark:text-gray-100 mr-2">{{ $jumlahTransaksiHariIni }}</div>
                    </div>
                    <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase mb-1">Transaksi</div>
                </div>
            </div>

            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-gray-800 shadow-xs rounded-xl">
                <div class="px-5 py-5">
                    <header class="flex justify-between items-start mb-2">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Total Setoran Hari Ini</h2>
                        <!-- Menu button -->
                        <div class="relative inline-flex">
                            <a class="text-sm font-medium text-violet-500 hover:text-violet-600 dark:hover:text-violet-400" href="{{ route('transaksi.index') }}">-&gt;</a>
                        </div>
                    </header>
                    <div class="flex items-start">
                        <div class="text-3xl font-bold text-gray-800 dark:text-gray-100 mr-2">{{ number_format($setoranHariIni) }}</div>
                    </div>
                    <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase mb-1">Rupiah</div>
                </div>
            </div>

            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-gray-800 shadow-xs rounded-xl">
                <div class="px-5 py-5">
                    <header class="flex justify-between items-start mb-2">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Total Tarikan Hari Ini</h2>
                        <!-- Menu button -->
                        <div class="relative inline-flex">
                            <a class="text-sm font-medium text-violet-500 hover:text-violet-600 dark:hover:text-violet-400" href="{{ route('transaksi.index') }}">-&gt;</a>
                        </div>
                    </header>
                    <div class="flex items-start">
                        <div class="text-3xl font-bold text-gray-800 dark:text-gray-100 mr-2">{{ number_format($tarikanHariIni) }}</div>
                    </div>
                    <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase mb-1">Rupiah</div>
                </div>
            </div>


            

        </div>

        <div class="grid grid-cols-12 gap-6 mt-6">
            <!-- Bar chart (Direct vs Indirect) -->
            <x-dashboard.statistik-transaksi-mingguan />

            <!-- Doughnut chart (Top Countries) -->
            <x-dashboard.statistik-jurusan  />

            <!-- Table (Top Channels) -->
            <x-dashboard.statistik-kelas-terbanyak />
        </div>

    </div>
</x-app-layout>
