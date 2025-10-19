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
        $mataKuliahs = MataKuliah::paginate(10);
        return view('penilaian.index', compact('mataKuliahs'));
    }

    public function input($kode_mk)
    {
        $matakuliah = MataKuliah::where('kode_mk', $kode_mk)->firstOrFail();
        $kode_angkatan = DB::table('mahasiswas')->value('kode_angkatan');

        // Ambil daftar nilai mahasiswa yang sudah diinput untuk MK ini
        $daftarNilai = DB::table('penilaians')
            ->join('mahasiswas', 'penilaians.nim', '=', 'mahasiswas.nim')
            ->select(
                'penilaians.nim',
                'mahasiswas.nama',
                DB::raw('SUM(penilaians.nilai_perkuliahan) as nilai_akhir')
            )
            ->where('penilaians.kode_mk', $kode_mk)
            ->groupBy('penilaians.nim', 'mahasiswas.nama')
            ->get();

        return view('penilaian.input', compact('matakuliah', 'daftarNilai', 'kode_angkatan'));
    }

    public function store(Request $request, $kode_mk)
    {
        $request->validate([
            'nim' => 'required|string',
            'nama' => 'required|string',
            'nilai_akhir' => 'required|numeric|min:0|max:100',
        ]);

        $nim = $request->nim;
        $nilaiAkhir = $request->nilai_akhir;

        // Ambil angkatan mahasiswa
        $kode_angkatan = DB::table('mahasiswas')
            ->where('nim', $nim)
            ->value('kode_angkatan');

        // Ambil semua CPMK dengan bobot untuk MK & angkatan ini
        $cpmkList = DB::table('cpmk_mata_kuliah')
            ->join('cpmks', 'cpmk_mata_kuliah.kode_cpmk', '=', 'cpmks.kode_cpmk')
            ->select('cpmk_mata_kuliah.*', 'cpmks.kode_cpl')
            ->where('kode_mk', $kode_mk)
            ->where('kode_angkatan', $kode_angkatan)
            ->get();

        foreach ($cpmkList as $item) {
            // Hitung nilai berdasarkan bobot
            $nilaiPerkuliahan = ($nilaiAkhir * $item->bobot) / 100;

            Penilaian::create([
                'nim' => $nim,
                'kode_mk' => $kode_mk,
                'kode_cpl' => $item->kode_cpl,
                'kode_cpmk' => $item->kode_cpmk,
                'kode_angkatan' => $kode_angkatan,
                'skor_maks' => $item->bobot, // bobot tetap disimpan
                'nilai_perkuliahan' => $nilaiPerkuliahan, // hasil akhir * bobot / 100
            ]);
        }

        // === Hitung capaian CPL otomatis ===
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

        return redirect()->back()->with('success', 'Nilai akhir berhasil dihitung dan disimpan!');
    }
}
