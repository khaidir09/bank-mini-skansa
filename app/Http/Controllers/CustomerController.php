<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function index()
    {
        return view('pages/nasabah/index');
    }

    public function show($id)
    {
        $customer = Customer::with('account', 'transactions')->findOrFail($id);
        $transactions = Transaction::where('account_id', 1)->get();
        return view('pages/nasabah/detail', compact('customer', 'transactions'));
    }

    public function bukaRekening($id)
    {
        // 1. Ambil data nasabah, eager load relasi 'room'
        $customer = Customer::with('room')->findOrFail($id);

        // 2. Cek apakah nasabah sudah punya rekening
        $existingAccount = Account::where('customer_id', $customer->id)->first();
        if ($existingAccount) {
            return redirect()->back()->with('error', 'Nasabah ini sudah memiliki rekening.');
        }

        $nomor_rekening_final = '';

        try {
            // 3. Mulai Transaksi Database
            // Ini memastikan jika ada kegagalan, data tidak akan tersimpan
            // dan mencegah race condition saat generate nomor.
            DB::transaction(function () use ($customer, &$nomor_rekening_final) {

                // --- Mulai Logika Prefix (Digit 1-4) ---

                $kode_kategori = '';
                $kode_tingkat = '00'; // Default jika bukan siswa
                $kode_major = '0';   // Default jika bukan siswa

                // Aturan 1: Kategori (Digit 1)
                switch ($customer->kategori) {
                    case 'Siswa':
                        $kode_kategori = '0';
                        break;
                    case 'Guru':
                        $kode_kategori = '1';
                        break;
                    case 'Tendik': // Saya asumsikan 'Tendik' dari form
                        $kode_kategori = '2';
                        break;
                    default:
                        $kode_kategori = '9'; // Fallback
                }

                // Aturan 2 & 3: Tingkat & Major (Hanya jika Siswa & punya kelas)
                if ($customer->kategori == 'Siswa' && $customer->room) {
                    $room = $customer->room;

                    // Aturan 2: Tingkat (Digit 2-3)
                    // (Asumsi kolom di tabel 'rooms' bernama 'tingkat')
                    switch ($room->tingkat) {
                        case 'X':
                            $kode_tingkat = '25';
                            break;
                        case 'XI':
                            $kode_tingkat = '24';
                            break;
                        case 'XII':
                            $kode_tingkat = '23';
                            break;
                        default:
                            $kode_tingkat = '00'; // Fallback jika tingkat tidak X/XI/XII
                    }

                    // Aturan 3: Major (Digit 4)
                    // (Asumsi 'majors_id' adalah 1 digit, sesuai contoh 024202)
                    if ($room->majors_id) {
                        $kode_major = (string)$room->majors_id;
                    }
                }

                // Gabungkan prefix (4 digit pertama)
                // Contoh Siswa: "0" + "24" + "2" = "0242"
                // Contoh Guru: "1" + "00" + "0" = "1000"
                $prefix = $kode_kategori . $kode_tingkat . $kode_major;

                // --- Selesai Logika Prefix ---


                // --- Mulai Logika Increment (Digit 5-6) ---

                // Aturan 4: Increment
                // Kita cari rekening terakhir yang punya prefix sama
                // lockForUpdate() MENGUNCI baris ini agar request lain menunggu
                $last_account = Account::where('nomor_rekening', 'like', $prefix . '%')
                    ->lockForUpdate()
                    ->orderBy('nomor_rekening', 'desc')
                    ->first();

                $next_increment_num = 1; // Nomor urut 1 jika ini yang pertama

                if ($last_account) {
                    // Ambil 2 digit terakhir dari nomor rekening (increment)
                    $last_increment = (int)substr($last_account->nomor_rekening, -2);
                    $next_increment_num = $last_increment + 1;
                }

                // Cek apakah nomor sudah > 99
                if ($next_increment_num > 99) {
                    // Batalkan transaksi dan kirim error
                    throw new \Exception('Batas nomor rekening untuk grup ini (' . $prefix . ') telah habis.');
                }

                // Format increment menjadi 2 digit (e.g., 1 -> "01")
                $kode_increment = str_pad($next_increment_num, 2, '0', STR_PAD_LEFT);

                // --- Selesai Logika Increment ---

                // 4. Gabungkan Nomor Rekening Final
                $nomor_rekening_final = $prefix . $kode_increment; // e.g., "0242" + "02" = "024202"

                // 5. Buat Rekening di Database
                // (Gunakan nama kolom dari migrasi/model kamu)
                Account::create([
                    'customer_id' => $customer->id,
                    'nomor_rekening' => $nomor_rekening_final,
                    'saldo' => 0,
                    'status' => 'Aktif', // Saya sesuaikan dengan 'active' (lowercase)
                ]);
            }); // Transaksi selesai dan di-commit

            // 6. Redirect dengan pesan sukses
            return redirect()->back()->with('message', 'Rekening berhasil dibuka! No. Rek: ' . $nomor_rekening_final);
        } catch (\Exception $e) {
            // 7. Tangkap jika ada error (misal, DB down atau nomor habis)
            Log::error('Gagal Buka Rekening: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuka rekening: ' . $e->getMessage());
        }
    }

    public function tutupRekening($id)
    {
        $customer = Customer::with('account')->findOrFail($id);

        $customer->account->update(['status' => 'Ditutup']);

        return redirect()->back()->with('message', 'Rekening berhasil ditutup!');
    }
}
