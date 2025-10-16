<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MataKuliah;
use App\Models\Penilaian;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PenilaianExport;
use App\Imports\PenilaianImport;

class PenilaianController extends Controller
{
    public function index()
    {
        $mataKuliahs = MataKuliah::paginate(10);
        return view('penilaian.index', compact('mataKuliahs'));
    }

    public function input($kode_mk)
    {
        $matakuliah = MataKuliah::where('kode_mk', $kode_mk)->firstOrFail();
        $kode_angkatan = DB::table('mahasiswas')->value('kode_angkatan');

        $cpl = DB::table('cpls')
            ->join('cpl_mata_kuliah', 'cpls.kode_cpl', '=', 'cpl_mata_kuliah.kode_cpl')
            ->select('cpls.kode_cpl', 'cpls.deskripsi', 'cpl_mata_kuliah.kode_angkatan')
            ->where('cpl_mata_kuliah.kode_mk', $kode_mk)
            ->where('cpl_mata_kuliah.kode_angkatan', $kode_angkatan)
            ->get();

        $cpmk = DB::table('cpmks')
            ->join('cpmk_mata_kuliah', 'cpmks.kode_cpmk', '=', 'cpmk_mata_kuliah.kode_cpmk')
            ->select(
                'cpmks.kode_cpmk',
                'cpmks.kode_cpl',
                'cpmks.deskripsi_cpmk',
                'cpmk_mata_kuliah.bobot as skor_maks',
                'cpmk_mata_kuliah.kode_angkatan'
            )
            ->where('cpmk_mata_kuliah.kode_mk', $kode_mk)
            ->where('cpmk_mata_kuliah.kode_angkatan', $kode_angkatan)
            ->get();

        return view('penilaian.input', compact('matakuliah', 'cpl', 'cpmk', 'kode_angkatan'));
    }

    public function store(Request $request, $kode_mk)
    {
        foreach ($request->kode_cpmk as $i => $kode_cpmk) {
            Penilaian::create([
                'nim' => $request->nim,
                'kode_mk' => $kode_mk,
                'kode_cpl' => $request->kode_cpl[$i],
                'kode_cpmk' => $kode_cpmk,
                'kode_angkatan' => $request->kode_angkatan,
                'skor_maks' => $request->skor_maks[$i],
                'nilai_perkuliahan' => $request->nilai_perkuliahan[$i],
            ]);
        }

        // Hitung capaian CPL
        $nim = $request->nim;
        $cplData = DB::table('penilaians')
            ->select(
                'kode_cpl',
                DB::raw('SUM(nilai_perkuliahan) as total_nilai'),
                DB::raw('SUM(skor_maks) as total_skor')
            )
            ->where('nim', $nim)
            ->groupBy('kode_cpl')
            ->get();

        foreach ($cplData as $row) {
            $capaian = $row->total_skor > 0 ? ($row->total_nilai / $row->total_skor) * 100 : 0;

            DB::table('hasil_obes')->updateOrInsert(
                ['nim' => $nim, 'kode_cpl' => $row->kode_cpl],
                ['capaian_persentase' => $capaian, 'updated_at' => now(), 'created_at' => now()]
            );
        }

        return redirect()->back()->with('success', 'Data nilai dan capaian CPL berhasil disimpan!');
    }

    // =====================================================
    // 📤 EXPORT EXCEL
    // =====================================================
    public function export()
    {
        return Excel::download(new PenilaianExport, 'penilaian.xlsx');
    }

    // =====================================================
    // 📥 IMPORT EXCEL
    // =====================================================
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new PenilaianImport, $request->file('file'));

        return back()->with('success', 'Data penilaian berhasil diimpor!');
    }
}
