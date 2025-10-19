<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;

class Nasabah extends Component
{
    use WithPagination;

    public $paginate = 10;
    public $search;

    public $confirmingDeletion = false;
    public $customer_id_to_delete;

    protected $updatesQueryString = ['search'];

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($customerId)
    {
        $this->customer_id_to_delete = $customerId; // Simpan ID
        $this->confirmingDeletion = true; // Buka modal
    }

    public function deleteCustomer()
    {
        // Pastikan ID ada
        if ($this->customer_id_to_delete) {
            $customer = Customer::find($this->customer_id_to_delete);

            if ($customer) {
                $customer->delete();
                // Kirim pesan sukses (akan kita tampilkan di view)
                session()->flash('message', 'Data nasabah berhasil dihapus.');
            }
        }

        // Tutup modal dan reset ID
        $this->confirmingDeletion = false;
        $this->customer_id_to_delete = null;
    }

    public function render()
    {
        $customers_count = Customer::count();
        $query = Customer::latest()->with('room');

        // Jika ada pencarian, tambahkan kondisi where
        if ($this->search) {
            $searchTerm = '%' . $this->search . '%';

            $query->where(function ($subQuery) use ($searchTerm) {
                $subQuery->where('name', 'like', $searchTerm)
                    ->orWhere('nomor_induk', 'like', $searchTerm)
                    ->orWhere('kategori', 'like', $searchTerm)
                    ->orWhereHas('room', function ($relationQuery) use ($searchTerm) {
                        // 'nama_kelas' adalah kolom di tabel 'rooms'
                        $relationQuery->where('nama_kelas', 'like', $searchTerm);
                    });
            });
        }

        // Ambil hasil akhir dengan paginasi
        $customers = $query->simplePaginate($this->paginate);

        return view('livewire.nasabah', [
            'customers_count' => $customers_count,
            'customers' => $customers
        ]);
    }
}
