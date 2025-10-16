<?php

namespace App\Imports;

use App\Models\Penilaian;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PenilaianImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Penilaian([
            'nim' => $row['nim'],
            'kode_mk' => $row['kode_mk'],
            'kode_cpl' => $row['kode_cpl'],
            'kode_cpmk' => $row['kode_cpmk'],
            'kode_angkatan' => $row['kode_angkatan'],
            'skor_maks' => $row['skor_maks'],
            'nilai_perkuliahan' => $row['nilai_perkuliahan'],
        ]);
    }
}
