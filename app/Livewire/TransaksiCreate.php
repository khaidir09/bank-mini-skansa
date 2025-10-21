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

    public $jenis_transaksi;
    public $jumlah;

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
            'jenis_transaksi' => 'required|in:setor,tarik',
            'jumlah' => 'required|numeric|min:1',
        ]);

        if (!$this->selectedAccount) {
            session()->flash('error', 'Rekening nasabah tidak ditemukan.');
            return;
        }

        DB::transaction(function () {
            if ($this->jenis_transaksi == 'tarik') {
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
                'jenis_transaksi' => $this->jenis_transaksi,
                'jumlah' => $this->jumlah,
            ]);
        });

        session()->flash('message', 'Transaksi berhasil diproses.');
        $this->resetForm();
        $this->dispatch('transaction-saved');
    }

    public function resetForm()
    {
        $this->search = '';
        $this->customers = [];
        $this->selectedCustomer = null;
        $this->selectedAccount = null;
        $this->saldo = 0;
        $this->jenis_transaksi = null;
        $this->jumlah = null;
    }


    public function render()
    {
        return view('livewire.transaksi-create');
    }
}
