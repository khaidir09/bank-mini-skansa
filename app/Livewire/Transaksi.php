<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;

class Transaksi extends Component
{
    use WithPagination;

    public $paginate = 10;
    public $search;

    public $confirmingDeletion = false;
    public $transaction_id_to_delete;

    protected $updatesQueryString = ['search'];

    protected $listeners = ['transaction-saved' => '$refresh'];

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($transactionId)
    {
        $this->transaction_id_to_delete = $transactionId; // Simpan ID
        $this->confirmingDeletion = true; // Buka modal
    }

    public function deleteTransaction()
    {
        // Pastikan ID ada
        if ($this->transaction_id_to_delete) {
            $transaction = Transaction::find($this->transaction_id_to_delete);

            if ($transaction) {
                $transaction->delete();
                // Kirim pesan sukses (akan kita tampilkan di view)
                session()->flash('message', 'Data transaksi berhasil dihapus.');
            }
        }

        // Tutup modal dan reset ID
        $this->confirmingDeletion = false;
        $this->transaction_id_to_delete = null;
    }

    public function render()
    {
        $transactions_count = Transaction::count();
        $query = Transaction::latest()->with('account.customer.room');

        // Jika ada pencarian, tambahkan kondisi where
        if ($this->search) {
            $searchTerm = '%' . $this->search . '%';

            $query->where(function ($subQuery) use ($searchTerm) {
                $subQuery->where('jenis', 'like', $searchTerm)
                    ->orWhereHas('account.customer', function ($relationQuery) use ($searchTerm) {
                        $relationQuery->where('name', 'like', $searchTerm);
                    });
            });
        }

        // Ambil hasil akhir dengan paginasi
        $transactions = $query->simplePaginate($this->paginate);

        return view('livewire.transaksi', [
            'transactions_count' => $transactions_count,
            'transactions' => $transactions
        ]);
    }
}
