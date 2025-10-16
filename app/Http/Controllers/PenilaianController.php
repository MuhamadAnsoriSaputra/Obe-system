<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MataKuliah;
use App\Models\Penilaian;

class PenilaianController extends Controller
{
    public function index()
    {
        // Ambil semua mata kuliah dari tabel
        $mataKuliahs = MataKuliah::paginate(10);


        // Kirim ke view penilaian.index
        return view('penilaian.index', compact('mataKuliahs'));
    }

    public function input($kode_mk)
    {
        // Ambil data mata kuliah
        $matakuliah = MataKuliah::where('kode_mk', $kode_mk)->firstOrFail();

        // Ambil salah satu angkatan (sementara, bisa disesuaikan dari session/dosen nanti)
        $kode_angkatan = DB::table('mahasiswas')->value('kode_angkatan');

        // Ambil data CPL yang terhubung ke MK dan angkatan
        $cpl = DB::table('cpls')
            ->join('cpl_mata_kuliah', 'cpls.kode_cpl', '=', 'cpl_mata_kuliah.kode_cpl')
            ->select('cpls.kode_cpl', 'cpls.deskripsi', 'cpl_mata_kuliah.kode_angkatan')
            ->where('cpl_mata_kuliah.kode_mk', $kode_mk)
            ->where('cpl_mata_kuliah.kode_angkatan', $kode_angkatan)
            ->get();

        // Ambil data CPMK yang terhubung dengan CPL dan MK
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

        // ================================
        // 🔸 Hitung & simpan capaian CPL
        // ================================
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
            $capaian = 0;
            if ($row->total_skor > 0) {
                $capaian = ($row->total_nilai / $row->total_skor) * 100;
            }

            // Simpan ke tabel hasil_obes (update kalau sudah ada)
            DB::table('hasil_obes')->updateOrInsert(
                [
                    'nim' => $nim,
                    'kode_cpl' => $row->kode_cpl,
                ],
                [
                    'capaian_persentase' => $capaian,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        return redirect()->back()->with('success', 'Data nilai dan capaian CPL berhasil disimpan!');
    }
}
