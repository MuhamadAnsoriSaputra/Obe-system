<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Cpl;
use Illuminate\Http\Request;

class RumusanController extends Controller
{
    public function index()
    {
        return view('rumusan.index');
    }

    public function rumusanMatkul()
    {
        $mataKuliahs = MataKuliah::with([
            'cpmks.cpl',
            'cpmks' => function ($q) {
                $q->withPivot('bobot');
            }
        ])->get();

        return view('rumusan.mata_kuliah', compact('mataKuliahs'));
    }


    public function indexMatakuliah()
    {
        $data = \DB::table('cpmk_matakuliah')
            ->join('cpmks', 'cpmk_matakuliah.id_cpmk', '=', 'cpmks.id')
            ->join('cpls', 'cpmks.id_cpl', '=', 'cpls.id')
            ->join('mata_kuliahs', 'cpmk_matakuliah.id_matakuliah', '=', 'mata_kuliahs.id')
            ->select(
                'mata_kuliahs.nama_matakuliah',
                'cpls.kode_cpl',
                'cpmks.kode_cpmk',
                'cpmk_matakuliah.bobot'
            )
            ->get()
            ->groupBy('nama_matakuliah');

        return view('rumusan.matakuliah', compact('data'));
    }

    public function rumusanCpl()
    {
        $cpls = Cpl::with([
            'cpmks.mataKuliahs' => function ($q) {
                $q->withPivot('bobot');
            }
        ])->get();

        return view('rumusan.cpl', compact('cpls'));
    }

}
