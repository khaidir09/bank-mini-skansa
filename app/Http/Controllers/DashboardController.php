<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\DataFeed;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $dataFeed = new DataFeed();
        $totalNasabah = Customer::count();
        $totalSaldo = Account::sum('saldo');
        $jumlahTransaksiHariIni = Transaction::whereDate('date', now()->toDateString())->count();
        $setoranHariIni = Transaction::where('jenis', 'Setor')->whereDate('date', now()->toDateString())->sum('jumlah');
        $tarikanHariIni = Transaction::where('jenis', 'Tarik')->whereDate('date', now()->toDateString())->sum('jumlah');
        return view('pages/dashboard/dashboard', compact('dataFeed', 'totalNasabah', 'totalSaldo', 'jumlahTransaksiHariIni', 'setoranHariIni', 'tarikanHariIni'));
    }

    /**
     * Displays the analytics screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function analytics()
    {
        return view('pages/dashboard/analytics');
    }

    /**
     * Displays the fintech screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function fintech()
    {
        return view('pages/dashboard/fintech');
    }
}
