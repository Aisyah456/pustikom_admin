<?php

namespace App\Imports;

use App\Models\Outgoing_mail;
use Maatwebsite\Excel\Concerns\ToModel;

class OutgoingMailImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Outgoing_mail([
            'nomor_surat'  => $row[0],
            'tanggal_surat' => \Carbon\Carbon::createFromFormat('Y-m-d', $row[1]),
            'tujuan' => $row[2],
            'perihal' => $row[3],
        ]);
    }
}
