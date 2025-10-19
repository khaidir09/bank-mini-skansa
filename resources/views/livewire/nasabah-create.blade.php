<div>
    <form wire:submit="save">
        @csrf
        <div class="px-5 py-4">
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium mb-1" for="name">Nama Nasabah <span class="text-rose-500">*</span></label>
                    <input wire:model="name" id="name" name="name"
                    class="form-input w-full px-2 py-1 @error('name') is-invalid @enderror"
                    type="text"/>
                    @error('name')
                        <div class="text-xs mt-1 text-rose-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="nomor_induk">NIS/NIP <span class="text-rose-500">*</span></label>
                    <input wire:model="nomor_induk" id="nomor_induk" name="nomor_induk" class="form-input w-full px-2 py-1 @error('nomor_induk') is-invalid @enderror" type="number" required />
                    @error('nomor_induk')
                        <div class="text-xs mt-1 text-rose-500">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1" for="types_id">Jenis Kelamin <span class="text-rose-500">*</span></label>
                    <div class="flex flex-wrap items-center -m-3">
                        <div class="m-3">
                            <label class="flex items-center">
                                <input type="radio" wire:model="gender" name="gender" class="form-radio" value="L" />
                                <span class="text-sm ml-2">L</span>
                            </label>
                            </div>
                        <div class="m-3">
                            <label class="flex items-center">
                                <input type="radio" wire:model="gender" name="gender" class="form-radio" value="P" />
                                <span class="text-sm ml-2">P</span>
                            </label>
                            </div>
                    </div>
                    @error('gender')
                        <div class="text-xs mt-1 text-rose-500">{{ $message }}</div>
                    @enderror
                </div>

                <div x-data="{ showDetails: @entangle('kategori').live == 'Siswa' }">
                    <label class="block text-sm font-medium mb-1" for="types_id">Kategori Nasabah <span class="text-rose-500">*</span></label>
                    <div class="flex flex-wrap items-center -m-3">
                        <div class="m-3">
                            <label class="flex items-center">
                                <input type="radio" wire:model="kategori" name="kategori" class="form-radio" value="Siswa" x-on:click="showDetails = true"/>
                                <span class="text-sm ml-2">Siswa</span>
                            </label>
                            </div>
                        <div class="m-3">
                            <label class="flex items-center">
                                <input type="radio" wire:model="kategori" name="kategori" class="form-radio" value="Guru" x-on:click="showDetails = false"/>
                                <span class="text-sm ml-2">Guru</span>
                            </label>
                            </div>
                        <div class="m-3">
                            <label class="flex items-center">
                                <input type="radio" wire:model="kategori" name="kategori" class="form-radio" value="Tendik" x-on:click="showDetails = false"/>
                                <span class="text-sm ml-2">Tendik</span>
                            </label>
                            </div>
                    </div>
                    @error('kategori')
                        <div class="text-xs mt-1 text-rose-500">{{ $message }}</div>
                    @enderror

                    <div x-show="showDetails" class="mt-3">
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium mb-1" for="room_id">Kelas</label>
                                <select wire:model="room_id" id="room_id" name="room_id" class="form-select text-sm py-1 w-full @error('room_id') is-invalid @enderror">
                                    <option selected value="">Pilih Kelas</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->nama_kelas }}</option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                    <div class="text-xs mt-1 text-rose-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1" for="birth_place">Tempat Lahir</label>
                                <input wire:model="birth_place" id="birth_place" name="birth_place"
                                class="form-input w-full px-2 py-1 @error('birth_place') is-invalid @enderror"
                                type="text"/>
                                @error('birth_place')
                                    <div class="text-xs mt-1 text-rose-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1" for="birthday">Tanggal Lahir</label>
                                <input wire:model="birthday" id="birthday" name="birthday"
                                class="form-input w-full px-2 py-1 @error('birthday') is-invalid @enderror"
                                type="date"/>
                                @error('birthday')
                                    <div class="text-xs mt-1 text-rose-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1" for="parent">Nama Orang Tua</label>
                                <input wire:model="parent" id="parent" name="parent"
                                class="form-input w-full px-2 py-1 @error('parent') is-invalid @enderror"
                                type="text"/>
                                @error('parent')
                                    <div class="text-xs mt-1 text-rose-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-1" for="pin">PIN <span class="text-rose-500">*</span></label>
                    <input wire:model="pin" id="pin" name="pin" class="form-input w-full px-2 py-1 @error('pin') is-invalid @enderror" type="number" placeholder="Masukkan 6 digit angka"/>
                    @error('pin')
                        <div class="text-xs mt-1 text-rose-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="px-5 py-4">
            <div class="flex flex-wrap justify-end space-x-2">
                <button class="btn-sm border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-800 dark:text-gray-300" @click="modalOpen = false">Batal</button>
                <button type="submit" class="btn-sm bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">Simpan</button>
            </div>
        </div>
    </form>
</div>