<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::simplePaginate(10);
        $customers_count = Customer::all()->count();
        return view('pages/nasabah/index', compact('customers', 'customers_count'));
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('pages/nasabah/detail', compact('customer'));
    }
}
