<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Angkatan;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Cpl;
use App\Models\Cpmk;
use App\Models\Penilaian;
use App\Models\HasilObe;

class DashboardAkademikController extends Controller
{
    public function akademik()
    {
        return view('dashboard.akademik', [
            'jumlahProdi' => Prodi::count(),
            'jumlahAngkatan' => Angkatan::count(),
            'jumlahDosen' => Dosen::count(),
            'jumlahMahasiswa' => Mahasiswa::count(),
            'jumlahMataKuliah' => MataKuliah::count(),
            'jumlahCPL' => Cpl::count(),
            'jumlahCPMK' => Cpmk::count(),
            'jumlahPenilaian' => Penilaian::count(),
            'capaianCPL' => HasilObe::selectRaw('kode_cpl, ROUND(AVG(capaian_persentase),2) as rata')
                ->groupBy('kode_cpl')
                ->get(),
        ]);
    }
}
