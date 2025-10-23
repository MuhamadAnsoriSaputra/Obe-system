<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Angkatan;
use App\Models\HasilObe;
use Illuminate\Support\Facades\DB;

class DashboardWadir1Controller extends Controller
{
    public function index()
    {
        return view('dashboard.wadir1', [
            'jumlahProdi' => Prodi::count(),
            'jumlahDosen' => Dosen::count(),
            'jumlahMahasiswa' => Mahasiswa::count(),
            'jumlahKurikulum' => Angkatan::count(),
            'rataCapaian' => HasilObe::avg('capaian_persentase'),

            // Data rata-rata capaian OBE per prodi (untuk chart)
            'capaianPerProdi' => HasilObe::select('prodis.nama_prodi', DB::raw('ROUND(AVG(hasil_obes.capaian_persentase),2) as rata'))
                ->join('mahasiswas', 'hasil_obes.nim', '=', 'mahasiswas.nim')
                ->join('prodis', 'mahasiswas.kode_prodi', '=', 'prodis.kode_prodi')
                ->groupBy('prodis.nama_prodi')
                ->get(),
        ]);
    }
}
