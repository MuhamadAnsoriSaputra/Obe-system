<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\MataKuliah;
use App\Models\Penilaian;
use App\Models\Cpmk;
use App\Models\Cpl;

class DosenDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $dosen = DB::table('dosens')
            ->where('id_user', $user->id_user)
            ->first();

        if (!$dosen) {
            abort(403, 'Dosen tidak ditemukan');
        }

        $nip = $dosen->nip;

        $mataKuliahDosen = DB::table('dosen_mata_kuliah')
            ->where('nip', $nip)
            ->select('kode_mk', 'kode_angkatan')
            ->get();

        $kodeMKs = $mataKuliahDosen->pluck('kode_mk')->unique();

        $jumlahMataKuliah = $kodeMKs->count();

        $jumlahCPL = DB::table('cpl_mata_kuliah')
            ->whereIn('kode_mk', $kodeMKs)
            ->distinct('kode_cpl')
            ->count('kode_cpl');

        $jumlahCPMK = DB::table('cpmk_mata_kuliah')
            ->whereIn('kode_mk', $kodeMKs)
            ->distinct('kode_cpmk')
            ->count('kode_cpmk');

        $jumlahPenilaian = DB::table('penilaians')
            ->whereIn('kode_mk', $kodeMKs)
            ->distinct(DB::raw("CONCAT(nim,'-',kode_mk)"))
            ->count();

        $chartData = DB::table('penilaians')
            ->select(
                'kode_mk',
                DB::raw('COUNT(DISTINCT nim) as total')
            )
            ->whereIn('kode_mk', $kodeMKs)
            ->groupBy('kode_mk')
            ->get();

        return view('dashboard.dosen', compact(
            'jumlahMataKuliah',
            'jumlahCPL',
            'jumlahCPMK',
            'jumlahPenilaian',
            'chartData'
        ));
    }
}
