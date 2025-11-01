<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerProfileController extends Controller
{
    public function edit()
    {
        $customerId = session('customer_id');
        $customer = Customer::find($customerId);
        return view('pages.nasabah.profile', compact('customer'));
    }

    public function update(Request $request)
    {
        $customerId = session('customer_id');
        $customer = Customer::find($customerId);

        $request->validate([
            'birth_place' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'date'],
            'parent' => ['required', 'string', 'max:255'],
            'pin' => ['nullable', 'string', 'min:6', 'max:6'],
        ]);

        $customer->birth_place = $request->birth_place;
        $customer->birthday = $request->birthday;
        $customer->parent = $request->parent;

        if ($request->pin) {
            $customer->pin = Hash::make($request->pin);
        }

        $customer->save();

        return redirect()->route('nasabah.profile.edit')->with('status', 'Profil berhasil diperbarui!');
    }
}
