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
        // Ambil data dosen login berdasarkan nip dari user login
        $nip = Auth::user()->nip;

        // Hitung jumlah mata kuliah yang diampu dosen (via tabel pivot)
        $jumlahMataKuliah = DB::table('dosen_mata_kuliah')
            ->where('nip', $nip)
            ->distinct('kode_mk')
            ->count('kode_mk');

        // Hitung jumlah CPL dan CPMK yang terkait dengan mata kuliah yang dia ampu
        $kodeMKs = DB::table('dosen_mata_kuliah')
            ->where('nip', $nip)
            ->pluck('kode_mk');

        $jumlahCPL = Cpl::count(); // opsional: total CPL
        $jumlahCPMK = Cpmk::whereIn('kode_mk', $kodeMKs)->count();

        // Hitung jumlah penilaian yang pernah dimasukkan oleh dosen
        $jumlahPenilaian = Penilaian::whereIn('kode_mk', $kodeMKs)->count();

        // Data untuk grafik: jumlah mahasiswa per mata kuliah yang dia ampu
        $chartData = DB::table('penilaians')
            ->select('kode_mk', DB::raw('COUNT(DISTINCT nim) as total'))
            ->whereIn('kode_mk', $kodeMKs)
            ->groupBy('kode_mk')
            ->get();

        return view('dashboard.dosen', [
            'jumlahMataKuliah' => $jumlahMataKuliah,
            'jumlahCPL' => $jumlahCPL,
            'jumlahCPMK' => $jumlahCPMK,
            'jumlahPenilaian' => $jumlahPenilaian,
            'chartData' => $chartData,
        ]);
    }
}
