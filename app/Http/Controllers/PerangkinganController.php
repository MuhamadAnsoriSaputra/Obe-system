<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Mahasiswa;
use App\Models\Angkatan;
use App\Models\BobotKriteria;
use App\Models\MataKuliah;

class PerangkinganController extends Controller
{
    public function index(Request $request)
    {
        $angkatans = Angkatan::orderBy('kode_angkatan')->get();
        $kode_angkatan = $request->kode_angkatan;

        if (!$kode_angkatan) {
            return view('perangkingan.index', compact('angkatans'));
        }

        // ---------------------------------------------------------
        // 1. Ambil daftar MK yang ada nilainya di penilaians
        // ---------------------------------------------------------
        $matkuls = Penilaian::where('kode_angkatan', $kode_angkatan)
            ->select('kode_mk')
            ->groupBy('kode_mk')
            ->pluck('kode_mk')
            ->toArray();

        // ---------------------------------------------------------
        // 2. Ambil bobot berdasarkan kode_mk
        // ---------------------------------------------------------
        $bobot = BobotKriteria::whereIn('kode_mk', $matkuls)
            ->pluck('bobot', 'kode_mk')
            ->toArray();

        // Jika ada MK tanpa bobot → set bobot default 1
        foreach ($matkuls as $mk) {
            if (!isset($bobot[$mk])) {
                $bobot[$mk] = 1;
            }
        }

        // Hitung total bobot → normalisasi
        $totalBobot = array_sum($bobot);

        foreach ($bobot as $mk => $b) {
            $bobot[$mk] = $b / ($totalBobot ?: 1);
        }

        // ---------------------------------------------------------
        // 3. Ambil mahasiswa
        // ---------------------------------------------------------
        $mahasiswas = Mahasiswa::where('kode_angkatan', $kode_angkatan)->get();

        $hasil = [];

        foreach ($mahasiswas as $mhs) {

            // Ambil nilai MK student tersebut
            $nilai = Penilaian::where('nim', $mhs->nim)
                ->where('kode_angkatan', $kode_angkatan)
                ->pluck('nilai_perkuliahan', 'kode_mk')
                ->toArray();

            $skor = 0;

            foreach ($matkuls as $mk) {
                $val = $nilai[$mk] ?? 0;
                $norm = $val / 100;              // normalisasi nilai 0–100 → 0–1
                $skor += $norm * ($bobot[$mk] ?? 0);
            }

            $hasil[] = [
                'nim' => $mhs->nim,
                'nama' => $mhs->nama,
                'skor' => round($skor, 4)
            ];
        }

        // ---------------------------------------------------------
        // 4. Ranking
        // ---------------------------------------------------------
        usort($hasil, fn($a, $b) => $b['skor'] <=> $a['skor']);

        return view('perangkingan.index', compact('angkatans', 'hasil', 'kode_angkatan'));
    }

    // ============================================================
    //     FITUR ATUR BOBOT
    // ============================================================

    public function bobotIndex()
    {
        $matkuls = MataKuliah::orderBy('kode_mk', 'asc')->get();

        $bobot = BobotKriteria::pluck('bobot', 'kode_mk')->toArray();

        return view('perangkingan.bobot', compact('matkuls', 'bobot'));
    }

    public function bobotSimpan(Request $request)
    {
        foreach ($request->bobot as $kode_mk => $nilai) {
            BobotKriteria::where('kode_mk', $kode_mk)->update([
                'bobot' => $nilai
            ]);
        }

        return back()->with('success', 'Bobot berhasil diperbarui');
    }
}
