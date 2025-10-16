<?php

namespace App\Exports;

use App\Models\Penilaian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenilaianExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Penilaian::select(
            'nim',
            'kode_mk',
            'kode_cpl',
            'kode_cpmk',
            'kode_angkatan',
            'skor_maks',
            'nilai_perkuliahan'
        )->get();
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Kode MK',
            'Kode CPL',
            'Kode CPMK',
            'Kode Angkatan',
            'Skor Maks',
            'Nilai Perkuliahan',
        ];
    }
}
