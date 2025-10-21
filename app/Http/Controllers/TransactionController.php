<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        return view('pages/transaksi/index');
    }

    public function create()
    {
        return view('pages/transaksi/create');
    }
}
