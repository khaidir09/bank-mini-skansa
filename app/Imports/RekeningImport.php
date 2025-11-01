<?php

namespace App\Imports;

use App\Models\Account;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RekeningImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Account([
            'customer_id'  => $row['id'],
            'nomor_rekening'   => $row['rekening'],
            'saldo'    => $row['saldo'],
            'status'   => $row['status'],
        ]);
    }
}
