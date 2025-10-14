<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilObeController extends Controller
{
    // 🔸 Tampilan per mata kuliah
    public function perMatkul(Request $request)
    {
        // Ambil semua nilai yang sudah diinput
        $penilaians = DB::table('penilaians')
            ->join('mata_kuliahs', 'penilaians.kode_mk', '=', 'mata_kuliahs.kode_mk')
            ->join('cpls', 'penilaians.kode_cpl', '=', 'cpls.kode_cpl')
            ->join('cpmks', 'penilaians.kode_cpmk', '=', 'cpmks.kode_cpmk')
            ->select(
                'penilaians.kode_mk',
                'mata_kuliahs.nama_mk',
                'penilaians.kode_cpl',
                'penilaians.kode_cpmk',
                'penilaians.skor_maks',
                'penilaians.nilai_perkuliahan',
                'penilaians.nim'
            )
            ->orderBy('penilaians.kode_mk')
            ->get();

        // Ambil daftar MK unik untuk grouping
        $grouped = $penilaians->groupBy('kode_mk');

        return view('hasilobe.per_matkul', compact('grouped'));
    }
}
