<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Mahasiswa;
use App\Models\Angkatan;

class PerangkinganController extends Controller
{
    public function index(Request $request)
    {
        // ------------------------------
        // 1. Dropdown angkatan
        // ------------------------------
        $angkatans = Angkatan::orderBy('kode_angkatan')->get();

        $kode_angkatan = $request->kode_angkatan;

        if (!$kode_angkatan) {
            return view('perangkingan.index', compact('angkatans'));
        }

        // ------------------------------
        // 2. Daftar MK yang dipakai
        // ------------------------------
        $matkuls = [
            'MK02',
            'MK04',
            'MK08',
            'MK11',
            'MK16',
            'MK21',
            'MK25',
            'MK30',
            'MK35'
        ];

        // ------------------------------
        // 3. Bobot SAW
        // ------------------------------
        $bobot = [];
        foreach ($matkuls as $mk) {
            $bobot[$mk] = ($mk == 'MK08') ? (1 / 17) : (2 / 17);
        }

        // ------------------------------
        // 4. Ambil mahasiswa 1 angkatan
        // ------------------------------
        $mahasiswas = Mahasiswa::where('kode_angkatan', $kode_angkatan)->get();

        $hasil = [];

        foreach ($mahasiswas as $mhs) {

            // Ambil nilai per MK (nilai_perkuliahan)
            $nilai = Penilaian::where('nim', $mhs->nim)
                ->where('kode_angkatan', $kode_angkatan)
                ->whereIn('kode_mk', $matkuls)
                ->pluck('nilai_perkuliahan', 'kode_mk')
                ->toArray();

            // Normalisasi SAW + Hitung skor
            $skor = 0;

            foreach ($matkuls as $mk) {
                $val = $nilai[$mk] ?? 0;     // jika tidak ada nilai = 0
                $norm = $val / 100;          // normalisasi benefit (0–100 menjadi 0–1)
                $skor += $norm * $bobot[$mk];
            }

            // simpan hasil
            $hasil[] = [
                'nim' => $mhs->nim,
                'nama' => $mhs->nama,
                'skor' => round($skor, 4)
            ];
        }

        // ------------------------------
        // 5. Urutkan skor terbesar
        // ------------------------------
        usort($hasil, function ($a, $b) {
            return $b['skor'] <=> $a['skor'];
        });

        return view('perangkingan.index', compact('angkatans', 'hasil', 'kode_angkatan'));
    }
}
