<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransaksiCreate extends Component
{
    public $search = '';
    public $customers = [];
    public $selectedCustomer;
    public $selectedAccount;
    public $saldo = 0;
    public $jenis = 'Setor';
    public $date;
    public $jumlah;

    public function mount()
    {
        // today()->toDateString() akan menghasilkan format 'Y-m-d' (misal: '2025-10-21')
        $this->date = today()->toDateString();
    }

    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) {
            $searchTerm = '%' . $this->search . '%';
            $this->customers = Customer::where('name', 'like', $searchTerm)
                ->orWhere('nomor_induk', 'like', $searchTerm)
                ->orWhereHas('account', function ($query) use ($searchTerm) {
                    $query->where('nomor_rekening', 'like', $searchTerm);
                })
                ->with('account', 'room')
                ->limit(5)
                ->get();
        } else {
            $this->customers = [];
        }
    }

    public function selectCustomer($customerId)
    {
        $this->selectedCustomer = Customer::with('account.transactions', 'room')->find($customerId);
        $this->selectedAccount = $this->selectedCustomer->account;
        if ($this->selectedAccount) {
            $this->saldo = $this->selectedAccount->saldo;
        }
        $this->search = '';
        $this->customers = [];
    }

    public function processTransaction()
    {
        $this->validate([
            'date' => 'required|date',
            'jenis' => 'required|in:Setor,Tarik',
            'jumlah' => 'required|numeric|min:1',
        ]);

        if (!$this->selectedAccount) {
            session()->flash('error', 'Rekening nasabah tidak ditemukan.');
            return;
        }

        DB::transaction(function () {
            if ($this->jenis == 'Tarik') {
                if ($this->selectedAccount->saldo < $this->jumlah) {
                    session()->flash('error', 'Saldo tidak mencukupi untuk penarikan.');
                    return;
                }
                $this->selectedAccount->saldo -= $this->jumlah;
            } else {
                $this->selectedAccount->saldo += $this->jumlah;
            }

            $this->selectedAccount->save();

            Transaction::create([
                'account_id' => $this->selectedAccount->id,
                'date' => $this->date,
                'room_id' => $this->selectedCustomer->room ? $this->selectedCustomer->room->id : null,
                'jenis' => $this->jenis,
                'jumlah' => $this->jumlah,
            ]);

            session()->flash('message', 'Transaksi berhasil diproses.');
        });

        $this->resetForm();

        return redirect()->route('transaksi.index');
    }

    public function resetForm()
    {
        $this->search = '';
        $this->customers = [];
        $this->selectedCustomer = null;
        $this->selectedAccount = null;
        $this->saldo = 0;
        $this->date = today()->toDateString();
        $this->jenis = 'Setor';
        $this->jumlah = null;
    }


    public function render()
    {
        return view('livewire.transaksi-create');
    }
}
