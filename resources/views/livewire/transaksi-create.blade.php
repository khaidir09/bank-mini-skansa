<div>
    <form wire:submit.prevent="processTransaction">
        <!-- Step 1: Search Customer -->
        @if (!$selectedCustomer)
            <div class="mb-4">
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cari Nasabah (No. Rekening / Nama / NIS)</label>
                <input type="text" id="search" wire:model.live.debounce.300ms="search" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Ketik untuk mencari...">
                @if (count($customers) > 0)
                    <ul class="border border-gray-200 rounded-md mt-1">
                        @foreach ($customers as $customer)
                            <li class="px-4 py-2 cursor-pointer hover:bg-gray-100" wire:click="selectCustomer({{ $customer->id }})">
                                {{ $customer->name }} - {{ $customer->room ? $customer->room->nama_kelas : $customer->kategori }} ({{ $customer->account ? $customer->account->nomor_rekening : 'Belum Punya Rekening' }})
                            </li>
                        @endforeach
                    </ul>
                @elseif (strlen($search) >= 2)
                    <p class="mt-2 text-sm text-gray-500">Nasabah tidak ditemukan.</p>
                @endif
            </div>
        @endif

        <!-- Step 2: Display Customer Details -->
        @if ($selectedCustomer)
            <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Detail Nasabah</h3>
                <p><strong>Nama:</strong> {{ $selectedCustomer->name }}</p>
                @if ($selectedAccount)
                    <p><strong>No. Rekening:</strong> {{ $selectedAccount->nomor_rekening }}</p>
                    <p><strong>Saldo Saat Ini:</strong> @money($saldo)</p>
                @else
                    <p class="text-red-500">Nasabah ini belum memiliki rekening.</p>
                @endif
            </div>

            <!-- Step 3: Transaction Details -->
            <div class="mb-4">
                <label for="jenis_transaksi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Transaksi</label>
                <select id="jenis_transaksi" wire:model="jenis_transaksi" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    <option value="">Pilih Jenis</option>
                    <option value="setor">Setor Tunai</option>
                    <option value="tarik">Tarik Tunai</option>
                </select>
                @error('jenis_transaksi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="jumlah" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Nominal</label>
                <input type="number" id="jumlah" wire:model="jumlah" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Masukkan jumlah">
                @error('jumlah') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Step 4: Submit Button -->
            <div class="flex justify-end">
                <button type="button" wire:click="resetForm" class="btn-sm border-gray-200 hover:border-gray-300 text-gray-800">Batal</button>
                <button type="submit" class="btn-sm bg-gray-900 text-gray-100 hover:bg-gray-800 ml-2" wire:loading.attr="disabled">
                    <span wire:loading.remove>Proses Transaksi</span>
                    <span wire:loading>Memproses...</span>
                </button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mt-4 text-red-500">{{ session('error') }}</div>
        @endif
    </form>
</div>
