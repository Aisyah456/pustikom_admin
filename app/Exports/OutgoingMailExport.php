<?php

namespace App\Exports;

use App\Models\Outgoing_mail;
use Maatwebsite\Excel\Concerns\FromCollection;

class OutgoingMailExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Outgoing_mail::select('nomor_surat', 'tanggal_surat', 'tujuan', 'perihal')->get();
    }

    public function headings(): array
    {
        return [
            'Nomor Surat',
            'Tanggal Surat',
            'Tujuan',
            'Perihal',
        ];
    }
}
