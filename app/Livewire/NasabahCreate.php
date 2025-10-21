<?php

namespace App\Livewire;

use App\Models\Room;
use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class NasabahCreate extends Component
{
    public $name;
    public $nomor_induk;
    public $gender;
    public $birth_place;
    public $birthday;
    public $parent;
    public $room_id;
    public $status;
    public $kategori = 'Siswa';
    public $pin;


    public function render()
    {
        $rooms = Room::all();
        return view('livewire.nasabah-create', [
            'rooms' => $rooms
        ]);
    }

    public function messages()
    {
        return [
            'nomor_induk.unique' => 'Mohon maaf, inputan tidak dapat diproses karena nasabah dengan nomor induk ini sudah tersedia.',
            'room_id.required' => 'Kolom kelas wajib diisi.',
            'birth_place.required' => 'Kolom tempat lahir wajib diisi.',
            'birthday.required' => 'Kolom tanggal lahir wajib diisi.',
            'parent.required' => 'Kolom nama orang tua wajib diisi.',
            'pin.min' => 'PIN harus terdiri dari 6 digit angka.',
            'pin.max' => 'PIN harus terdiri dari 6 digit angka.',
        ];
    }

    public function save()
    {
        if (empty($this->pin)) {
            $this->pin = '123456';
        }

        $rules = [
            'name' => 'required|min:3',
            'nomor_induk' => 'required|unique:customers,nomor_induk',
            'gender' => 'required',
            'kategori' => 'required',
            'pin' => 'required|min:6|max:6',
        ];

        if ($this->kategori == 'Siswa') {
            $rules['room_id'] = 'required';
            $rules['birth_place'] = 'required';
            $rules['birthday'] = 'required';
            $rules['parent'] = 'required';
        } else {
            $this->room_id = null;
            $this->birth_place = null;
            $this->birthday = null;
            $this->parent = null;
        }

        // Jalankan validasi
        $this->validate($rules);

        // Buat customer
        $customer = Customer::create([
            'name' => $this->name,
            'nomor_induk' => $this->nomor_induk,
            'gender' => $this->gender,
            'birth_place' => $this->birth_place,
            'birthday' => $this->birthday,
            'parent' => $this->parent,
            'status' => 'Aktif',
            'kategori' => $this->kategori,
            'room_id' => $this->room_id,
            'pin' => Hash::make($this->pin),
        ]);

        $this->resetInput();

        session()->flash('message', 'Data nasabah berhasil ditambahkan!');

        return redirect()->route('nasabah.index');
    }

    private function resetInput()
    {
        $this->name = null;
        $this->nomor_induk = null;
        $this->gender = null;
        $this->birth_place = null;
        $this->birthday = null;
        $this->parent = null;
        $this->status = null;
        $this->kategori = 'Siswa';
        $this->room_id = null;
        $this->pin = null;
    }
}
