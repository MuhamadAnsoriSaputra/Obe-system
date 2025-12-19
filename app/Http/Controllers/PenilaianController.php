<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MataKuliah;
use App\Models\Penilaian;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

        $mahasiswa = DB::table('mahasiswas')->where('nim', $nim)->first();
        if (!$mahasiswa) {
            return redirect()->back()->withErrors([
                'nim' => 'Data mahasiswa tidak ditemukan'
            ])->withInput();
        }

        // Ambil angkatan mahasiswa
        $kode_angkatan = $mahasiswa->kode_angkatan;

        $sudahDinilai = DB::table('penilaians')
            ->where('nim', $nim)
            ->where('kode_mk', $kode_mk)
            ->exists();

        if ($sudahDinilai) {
            return redirect()->back()->withErrors([
                'nim' => 'Mahasiswa sudah dinilai pada mata kuliah ini'
            ])->withInput();
        }

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
                'skor_maks' => $item->bobot,
                'nilai_perkuliahan' => $nilaiPerkuliahan,
            ]);
        }

        // Hitung capaian CPL
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

    // 🟢 Tambahan: Fitur Import Excel
    public function importExcel(Request $request, $kode_mk)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // Lewati baris header
        foreach (array_slice($sheetData, 1) as $row) {
            $nim = trim($row['A']);
            $nama = trim($row['B']);
            $nilaiAkhir = floatval($row['C']);

            if (!$nim || !$nilaiAkhir) {
                continue; // lewati baris kosong
            }

            $kode_angkatan = DB::table('mahasiswas')
                ->where('nim', $nim)
                ->value('kode_angkatan');

            if (!$kode_angkatan) {
                continue; // lewati jika mahasiswa tidak ditemukan
            }

            // Ambil CPMK untuk MK & angkatan
            $cpmkList = DB::table('cpmk_mata_kuliah')
                ->join('cpmks', 'cpmk_mata_kuliah.kode_cpmk', '=', 'cpmks.kode_cpmk')
                ->select('cpmk_mata_kuliah.*', 'cpmks.kode_cpl')
                ->where('kode_mk', $kode_mk)
                ->where('kode_angkatan', $kode_angkatan)
                ->get();

            foreach ($cpmkList as $item) {
                $nilaiPerkuliahan = ($nilaiAkhir * $item->bobot) / 100;

                Penilaian::create([
                    'nim' => $nim,
                    'kode_mk' => $kode_mk,
                    'kode_cpl' => $item->kode_cpl,
                    'kode_cpmk' => $item->kode_cpmk,
                    'kode_angkatan' => $kode_angkatan,
                    'skor_maks' => $item->bobot,
                    'nilai_perkuliahan' => $nilaiPerkuliahan,
                ]);
            }

            // Hitung capaian CPL untuk mahasiswa ini
            $cplData = DB::table('penilaians')
                ->select(
                    'kode_cpl',
                    DB::raw('SUM(nilai_perkuliahan) as total_nilai'),
                    DB::raw('SUM(skor_maks) as total_skor')
                )
                ->where('nim', $nim)
                ->groupBy('kode_cpl')
                ->get();

            foreach ($cplData as $rowCpl) {
                $capaian = $rowCpl->total_skor > 0 ? ($rowCpl->total_nilai / $rowCpl->total_skor) * 100 : 0;

                DB::table('hasil_obes')->updateOrInsert(
                    ['nim' => $nim, 'kode_cpl' => $rowCpl->kode_cpl],
                    ['capaian_persentase' => $capaian, 'updated_at' => now(), 'created_at' => now()]
                );
            }
        }

        return redirect()->route('penilaian.input', $kode_mk)->with('success', 'Data nilai berhasil diimport dari Excel!');
    }

    public function destroy($kode_mk, $nim)
    {
        DB::table('penilaians')
            ->where('kode_mk', $kode_mk)
            ->where('nim', $nim)
            ->delete();

        DB::table('hasil_obes')
            ->where('nim', $nim)
            ->delete();

        return redirect()->back()->with('success', 'Nilai mahasiswa berhasil dihapus!');
    }

    public function destroyAll($kode_mk)
    {
        DB::table('penilaians')
            ->where('kode_mk', $kode_mk)
            ->delete();

        DB::table('hasil_obes')->truncate();

        return redirect()->back()->with('success', 'Semua nilai berhasil dihapus!');
    }
}
