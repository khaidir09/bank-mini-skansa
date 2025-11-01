<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\Transaction;

class LaporanController extends Controller
{
    public function index()
    {
        $rooms = Room::with('nasabah.account')->get();
        return view('pages/laporan/index', compact('rooms'));
    }
}
