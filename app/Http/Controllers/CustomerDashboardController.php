<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Account;
use App\Models\Transaction;

class CustomerDashboardController extends Controller
{
    /**
     * Menampilkan dasbor untuk nasabah yang sedang login.
     */
    public function index(Request $request)
    {
        $customerId = $request->session()->get('customer_id');

        if (!$customerId) {
            return redirect()->route('nasabah.login');
        }

        $customer = Customer::findOrFail($customerId);
        $account = $customer->account;

        if (!$account) {
            // Handle jika nasabah tidak punya rekening
            return view('pages.nasabah.dashboard', [
                'customer' => $customer,
                'account' => null,
                'transactions' => collect()
            ]);
        }

        $menabung = Transaction::where('account_id', $customer->account->id)
            ->where('jenis', 'Setor')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('jumlah');
        $menarik = Transaction::where('account_id', $customer->account->id)
            ->where('jenis', 'Tarik')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('jumlah');

        $transactions = Transaction::where('account_id', $account->id)
            ->latest()
            ->take(20)
            ->get();

        return view('pages.nasabah.dashboard', [
            'customer' => $customer,
            'account' => $account,
            'menabung' => $menabung,
            'menarik' => $menarik,
            'transactions' => $transactions
        ]);
    }
}
