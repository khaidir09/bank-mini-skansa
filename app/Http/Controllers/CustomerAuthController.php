<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    /**
     * Menampilkan form login untuk nasabah.
     */
    public function showLoginForm()
    {
        return view('auth.customer-login');
    }

    /**
     * Menangani proses login nasabah.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nomor_induk' => 'required|string',
            'pin' => 'required|string',
        ]);

        $customer = Customer::where('nomor_induk', $credentials['nomor_induk'])->first();

        if ($customer && Hash::check($credentials['pin'], $customer->pin)) {
            // Login berhasil, buat session untuk nasabah
            session(['customer_id' => $customer->id]);
            return redirect()->route('nasabah.dashboard');
        }

        return back()->withErrors([
            'nomor_induk' => 'Nomor Induk atau PIN salah.',
        ]);
    }

    /**
     * Menangani proses logout nasabah.
     */
    public function logout(Request $request)
    {
        $request->session()->forget('customer_id');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('nasabah.login');
    }
}
